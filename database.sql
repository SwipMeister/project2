-- SQL script wat zonder poes of pas werkt, hierboven had aanpassingen nodig om het werkend te krijgen.
-- db deleten als hij bestaat
-- SCRIPT WORKS LIKE A CHARM
DROP DATABASE IF EXISTS project2;
-- create new db
CREATE DATABASE project2;

-- default db
USE project2;
-- create table fabriek
CREATE TABLE fabriek(
    fabriekscode INT NOT NULL AUTO_INCREMENT,
    fabriek VARCHAR(250) UNIQUE,
    telefoon int(10) NOT NULL,
    PRIMARY KEY(fabriekscode)
);

-- create table locatie
CREATE TABLE locatie(
    locatiecode INT NOT NULL AUTO_INCREMENT,
    locatie VARCHAR(250) UNIQUE,
    PRIMARY KEY(locatiecode)
);


-- create table persoon
CREATE TABLE artikel(
    productcode INT NOT NULL AUTO_INCREMENT,
    product VARCHAR(250) NOT NULL,
    type VARCHAR(250) NOT NULL,
    fabriekscode INT,
    inkoopprijs DECIMAL(5,2) NOT NULL,
    verkoopprijs DECIMAL(5,2) NOT NULL,
    PRIMARY KEY(productcode),
    FOREIGN KEY(fabriekscode) REFERENCES fabriek(fabriekscode)
);
-- create table voorraad als laatst voor FK constraints
CREATE TABLE voorraad(
    productcode INT,
    locatiecode INT,
    aantal INT,
    FOREIGN KEY(productcode) REFERENCES artikel(productcode),
    FOREIGN KEY(locatiecode) REFERENCES locatie(locatiecode)
);
-- create table medewerkers
CREATE TABLE medewerkers(
    medewerkerscode INT NOT NULL AUTO_INCREMENT,
    voorletters VARCHAR(250) NOT NULL,
    voorvoegsels VARCHAR(250) NOT NULL,
    gebruikersnaam VARCHAR(250) UNIQUE,
    password VARCHAR(250) NOT NULL,
    PRIMARY KEY(medewerkerscode)
);


-- vergeten achternaam in medewerker table toe te voegen:

ALTER TABLE table_name
  ADD achternaam VARCHAR(250) AFTER voorvoegsels;