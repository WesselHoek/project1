--Deze line create de project1 database.
CREATE DATABASE project1;
--Deze line selecteert de project1 database om er mee te werken.
USE project1;

--Deze statement ceates een table.
CREATE TABLE Usertype(
    id INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(255) NOT NULL,
    created DATE NOT NULL,
    updated DATE NOT NULL,
    PRIMARY KEY(id)
);

--Deze statement creates een table.
CREATE TABLE Account (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE  NOT NULL,
    password VARCHAR(255)  NOT NULL,
    created DATE NOT NULL,
    updated DATE NOT NULL,
    usertype_id INT,
    FOREIGN KEY (usertype_id) REFERENCES Usertype(id),
    PRIMARY KEY(id)
);
--Deze statement creates een table.
CREATE TABLE Persoon (
    id INT NOT NULL AUTO_INCREMENT,
    voornaam VARCHAR(255) NOT NULL,
    tussenvoegsel VARCHAR(255),
    achternaam VARCHAR(255) NOT NULL,
    account_id INT,
    created DATE NOT NULL,
    updated DATE NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (account_id) REFERENCES account(id)
);

--Insert Admin account
INSERT INTO Account (email, password, username)
VALUES ('wessel@admin.com', 'admin', 'admin');

INSERT INTO Persoon (voornaam, tussenvoegsel, achternaam)
VALUES ('wessel', '', 'hoek');

INSERT INTO usertype (type)
VALUES ( 'Admin');

UPDATE Persoon 
SET account_id = (select id from account where email = 'wessel@admin.com')
WHERE voornaam = 'wessel';

UPDATE account
SET usertype_id = (select id from usertype where type = "admin")
WHERE email = 'wessel@admin.com';