--Deze line create de project1 database.
CREATE DATABASE project1;
--Deze line selecteert de project1 database om er mee te werken.
USE project1;
--Hier maak ik mijn eerste table.
CREATE TABLE Account (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    PRIMARY KEY(id)
);
--Hier maak ik een tweede table.
CREATE TABLE Persoon (
    id INT NOT NULL AUTO_INCREMENT,
    voornaam VARCHAR(255),
    tussenvoegsel VARCHAR(255),
    achternaam VARCHAR(255),
    username VARCHAR(255),
    account_id INT,
    PRIMARY KEY(id),
    FOREIGN KEY (account_id) REFERENCES account(id)
);