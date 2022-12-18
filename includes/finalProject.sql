DROP DATABASE IF EXISTS finalProjectLeviDiaz;
CREATE DATABASE finalProjectLeviDiaz;
USE finalProjectLeviDiaz;


-- userId, username, fullName, businessId, businessName, businessLocation, ethnicities, type of business

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    roleId INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    roleName VARCHAR(255)
);

DROP TABLE IF EXISTS users;
CREATE TABLE users (
userId INT PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(255),
fullName VARCHAR(255),
userPassword VARCHAR(255)
);

DROP TABLE IF EXISTS businesses;
CREATE TABLE businesses (
    businessId INT PRIMARY KEY AUTO_INCREMENT,
    businessOwnerId INT,
    businessName VARCHAR(255), 
    businessLocation VARCHAR(255),
    typeOfBusiness VARCHAR(255),
    ethnicities VARCHAR(255),
    businessDescription VARCHAR(3000),
    businessImage MEDIUMBLOB, 
    imageAlt VARCHAR(255),
    FOREIGN KEY (businessOwnerId) REFERENCES users(userId) ON DELETE CASCADE
);


INSERT INTO roles (roleName)
VALUES
("admin"),
("author"),
("editor");

INSERT INTO users (username, fullName)
VALUES 
("Bing chilling lover <3", "John Cena"),
("amo la comida mexicana", "Lorenzo Diaz");

INSERT INTO businesses (businessOwnerId, businessName, businessLocation, typeOfBusiness, ethnicities, businessDescription)
VALUES
(1, "Mood stone", "777 Delaware Rd", "Mineral collection", "Asian", "Selling unique and rare stones from all around the world"),
(2, "Blake's pizza", "778 Delaware Rd", "Restuarant", "Black", "Quality pizza and wings!");