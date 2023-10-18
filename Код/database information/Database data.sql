CREATE DATABASE project;
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE project;

CREATE TABLE users(
id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
user VARCHAR(32) NOT NULL UNIQUE,
pass CHAR(97) NOT NULL
)CHARACTER SET ascii;

GRANT SELECT
ON project.users
TO login@localhost
IDENTIFIED BY "login123";

ALTER TABLE users
CHANGE pass pass BINARY(32) NOT NULL;

GRANT INSERT
ON project.users
TO register@localhost
IDENTIFIED BY "register123";

CREATE TABLE users_tokens(
UID bigint unsigned NOT NULL,
FOREIGN KEY(UID) REFERENCES users(id),
token binary(32) NOT NULL
)CHARACTER SET ASCII;

GRANT SELECT, INSERT
ON project.users_tokens
TO login@localhost;

ALTER TABLE users_tokens
ADD expires_at datetime NOT NULL DEFAULT DATE_ADD(now(),interval 1 HOUR);

DELETE FROM users_tokens
WHERE expires_at < now();

GRANT SELECT, UPDATE
ON project.users_tokens
TO login@localhost;

ALTER TABLE users_tokens
ADD series binary(32) NOT NULL
COLLATE ascii_general_ci;


CREATE TABLE login_logs_hash(
ip VARBINARY(16) NOT NULL,
PRIMARY KEY(ip) USING HASH,
attempts INT UNSIGNED NOT NULL DEFAULT 1
) ENGINE = Memory;

GRANT INSERT, SELECT, UPDATE
ON project.login_logs_hash
TO login@localhost;

CREATE TABLE infoUser(
users VARCHAR(256) NOT NULL,
ip VARCHAR(256) NOT NULL,
os VARCHAR(256) NOT NULL,
viewpage VARCHAR(256) NOT NULL
)CHARACTER SET ascii;

GRANT INSERT
ON project.infoUser
TO login@localhost;

ALTER TABLE infoUser
ADD date DATETIME;

CREATE TABLE report(
users VARCHAR(256) NOT NULL,
date DATETIME,
descriptionOfProblem VARCHAR(1024)
)CHARACTER SET ascii;

GRANT INSERT
ON project.report
TO login@localhost;