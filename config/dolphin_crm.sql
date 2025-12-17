CREATE Database dolphin_crm;

USE dolphin_crm;

CREATE TABLE users(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(25) NOT NULL,
    date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contacts(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    company VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    assigned_to INT(11) NOT NULL,
    created_by INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

);

CREATE TABLE notes(
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    contact_id INT(11),
    comment TEXT,
    created_by INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (firstname, lastname, password, email, role)
VALUES ('Raheem', 'Sterling', '$2y$10$fQQtOl0eOu0tnr62An0O2O4lO1yJPVTk5zQONt6OWAzhBZPUcb8su', 'admin@project2.com', 'admin');