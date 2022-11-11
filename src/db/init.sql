CREATE DATABASE IF NOT EXISTS appDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT,UPDATE,INSERT,DELETE ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE appDB;
-- pr3
CREATE TABLE IF NOT EXISTS admin_users (
  login VARCHAR(20) NOT NULL,
  password VARCHAR(65) NOT NULL,
  PRIMARY KEY (login)
);

INSERT INTO admin_users (login, password)
SELECT * FROM (SELECT 'admin', '{SHA}0DPiKuNIrrVmD8IUCuw1hQxNqZc=') AS tmp
WHERE NOT EXISTS (
    SELECT login FROM admin_users WHERE login = 'admin' AND password = '{SHA}0DPiKuNIrrVmD8IUCuw1hQxNqZc='
) LIMIT 1;

CREATE TABLE IF NOT EXISTS products (
  ID INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  price INT(11) NOT NULL,
  PRIMARY KEY (ID)
);

INSERT INTO products (name, price)
SELECT * FROM (SELECT 'Диагностика', 500) AS tmp
WHERE NOT EXISTS (
    SELECT name FROM products WHERE name = 'Диагностика' AND price = 500
) LIMIT 1;

INSERT INTO products (name, price)
SELECT * FROM (SELECT 'Покраска', 2000) AS tmp
WHERE NOT EXISTS (
    SELECT name FROM products WHERE name = 'Покраска' AND price = 2000
) LIMIT 1;

CREATE TABLE IF NOT EXISTS orders (
  ID INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  product_id INT(11) NOT NULL,
  PRIMARY KEY (ID),
  FOREIGN KEY (product_id) REFERENCES products(ID)
);

INSERT INTO orders (name, product_id)
VALUES ('Алексей', 2), ('Евгений', 1);

-- pr1
CREATE TABLE IF NOT EXISTS users (
  ID INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(20) NOT NULL,
  surname VARCHAR(40) NOT NULL,
  PRIMARY KEY (ID)
);

INSERT INTO users (name, surname)
SELECT * FROM (SELECT 'Alex', 'Rover') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'Alex' AND surname = 'Rover'
) LIMIT 1;

INSERT INTO users (name, surname)
SELECT * FROM (SELECT 'Bob', 'Marley') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'Bob' AND surname = 'Marley'
) LIMIT 1;

INSERT INTO users (name, surname)
SELECT * FROM (SELECT 'Alex', 'Rover') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'Alex' AND surname = 'Rover'
) LIMIT 1;

INSERT INTO users (name, surname)
SELECT * FROM (SELECT 'Kate', 'Yandson') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'Kate' AND surname = 'Yandson'
) LIMIT 1;

INSERT INTO users (name, surname)
SELECT * FROM (SELECT 'Lilo', 'Black') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM users WHERE name = 'Lilo' AND surname = 'Black'
) LIMIT 1;
