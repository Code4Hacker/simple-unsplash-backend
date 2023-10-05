CREATE DATABASE UNSPLASHDB;

USE UNSPLASHDB;

CREATE TABLE USERS (
    userID INT PRIMARY KEY AUTO_INCREMENT,
    userName VARCHAR (50),
    photo VARCHAR (40),
    email VARCHAR (50) UNIQUE,
    passcode VARCHAR(10)
);

CREATE TABLE CONTENTS (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR (50),
    decription TEXT,
    photo VARCHAR (40),
    userid INT,
    FOREIGN KEY(userid) REFERENCES USERS (userID) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO USERS (userID, userName, photo, email, passcode) VALUES (NULL, 'Gemini Child','/profiles/photo.png', 'paulprogrammer947@gmail.com', 'gemini123'),(NULL, 'Harson','/profiles/photo2.png', 'hary@gmail.com', 'admin123'),(NULL, 'Jasmin','/profiles/photo3.png', 'jsmin@gmail.com', 'js123');

INSERT INTO CONTENTS (id, title, decription, photo, userid) VALUES (NULL, 'Title One','/contents/photo.png', 'New First description for this one', 1),(NULL, 'Title Two','/contents/photo.png', 'New First description for this one', 1),(NULL, 'Title Three','/contents/photo2.png', 'New First description for this one', 1),(NULL, 'Title Four','/contents/photo.png', 'New Form description for this three', 2);

