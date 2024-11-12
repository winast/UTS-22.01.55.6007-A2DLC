<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, speciesization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];
$request = [];

if (isset($_SERVER['PATH_INFO'])) {
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
}

function getConnection() {
    $host = 'localhost';
    $db   = 'pets';
    $user = 'root';
    $pass = ''; // Ganti dengan password MySQL Anda jika ada
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function response($status, $data = NULL) {
    header("HTTP/1.1 " . $status);
    if ($data) {
        echo json_encode($data);
    }
    exit();
}

$db = getConnection();

switch ($method) {
    case 'GET':
        if (!empty($request) && isset($request[0])) {
            $id = $request[0];
            $stmt = $db->prepare("SELECT * FROM pets WHERE id = ?");
            $stmt->execute([$id]);
            $pets = $stmt->fetch();
            if ($pets) {
                response(200, $pets);
            } else {
                response(404, ["message" => "Pets not found"]);
            }
        } else {
            $stmt = $db->query("SELECT * FROM pets");
            $pets = $stmt->fetchAll();
            response(200, $pets);
        }
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->name) || !isset($data->species) || !isset($data->age) || !isset($data->status)) {
            response(400, ["message" => "Missing required fields"]);
        }
        $sql = "INSERT INTO pets (name, species, age, status) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$data->name, $data->species, $data->age, $data->status])) {
            response(201, ["message" => "Pet created", "id" => $db->lastInsertId()]);
        } else {
            response(500, ["message" => "Failed to create Pet"]);
        }
        break;
    
    case 'PUT':
        if (empty($request) || !isset($request[0])) {
            response(400, ["message" => "Pet ID is required"]);
        }
        $id = $request[0];
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->name) || !isset($data->species) || !isset($data->age) || !isset($data->status)) {
            response(400, ["message" => "Missing required fields"]);
        }
        $sql = "UPDATE pets SET name = ?, species = ?, age = ?, status = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$data->name, $data->species, $data->age, $data->status, $id])) {
            response(200, ["message" => "Pet updated"]);
        } else {
            response(500, ["message" => "Failed to update Pet"]);
        }
        break;
    
    case 'DELETE':
        if (empty($request) || !isset($request[0])) {
            response(400, ["message" => "Pet ID is required"]);
        }
        $id = $request[0];
        $sql = "DELETE FROM pets WHERE id = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$id])) {
            response(200, ["message" => "Pet deleted"]);
        } else {
            response(500, ["message" => "Failed to delete Pet"]);
        }
        break;
    
    default:
        response(405, ["message" => "Method not allowed"]);
        break;
}
?>