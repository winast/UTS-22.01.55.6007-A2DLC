# UTS-22.01.55.6007-A2DLC

Nama : Pratiwi Winastuti
NIM  : 22.01.55.6007

## Deskripsi Project

## Query SQL pembuatan tabel
```sql
CREATE TABLE pets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    species VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    status VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO pets (name, species, age, status) VALUES
(‘Fluffy’, ’Kucing Persia’, 3, ‘Vaccinated’),
(‘Brownie’, ‘Anjing Golden Retriever’, 5, ’Unvaccinated’),
(‘Neno’, ‘Ikan Badut’, 2, ’Unvaccinated’),
(‘Polly’, ‘Burung Beo’, 10, ‘Vaccinated’),
(‘Coco’, ‘Kucing Mainecoon’, 1, ‘Vaccinated’);
```
## Daftar endpoint API
1. **GET** `/api/[objek]`
  
2. **GET** `/api/[objek]/{id}`

3. **POST** `/api/[objek]`

4. **PUT** `/api/[objek]/{id}`

5. **DELETE** `/api/[objek]/{id}`

## Screenshot hasil pengujian di Postman
#### a. GET All Pets
![image](https://github.com/user-attachments/assets/c2106b69-e601-4f8f-b9be-bd1b18264410)
#### b. GET Specific Pet
![image](https://github.com/user-attachments/assets/529804a1-eb02-4923-8f58-b4fbd15d47ca)
#### c. Post New Pet
![image](https://github.com/user-attachments/assets/3da11077-b20c-4d95-bb78-dbceb1a2dbb7)
#### d. Put (Update) Pet
![image](https://github.com/user-attachments/assets/528de37d-abe1-46a4-b1cb-72e14b1efa4b)
#### e. Delete Pet
![image](https://github.com/user-attachments/assets/06a05bcd-fdad-4f66-91d7-29edbd397d4a)
