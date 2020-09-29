CREATE TABLE users (
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
username VARCHAR(50) NOT NULL,
password VARCHAR(50) NOT NULL,
PRIMARY KEY(id)
);

INSERT INTO users (username, password)
VALUES ('marino', 'test');

INSERT INTO users (username, password)
VALUES ('francesco', 'test');

INSERT INTO users (username, password)
VALUES ('michele', 'test');

INSERT INTO users (username, password)
VALUES ('ivan', 'test');

UPDATE users SET password = sha1(password);

CREATE TABLE users_logged (
id INT UNSIGNED AUTO_INCREMENT NOT NULL,
username VARCHAR(50) NOT NULL,
action VARCHAR(50) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(id)
);
