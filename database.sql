-- Active: 1685527305804@@127.0.0.1@3306@symfony_auth_rest
DROP TABLE IF EXISTS user;

CREATE TABLE user(
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(128) NOT NULL
);

INSERT INTO user (email,password,role) VALUES 
('admin@test.com', '$2y$13$QhBMs8WdRMaZUc7iQTQUm.DDn/3AFUGa8BukmNZQTZdQTiWDYIMQG', 'ROLE_ADMIN'),
('test@test.com', '$2y$13$QhBMs8WdRMaZUc7iQTQUm.DDn/3AFUGa8BukmNZQTZdQTiWDYIMQG', 'ROLE_USER');