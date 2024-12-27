CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,       
    username VARCHAR(255) NOT NULL,              
    email VARCHAR(255) NOT NULL UNIQUE,       
    password VARCHAR(255) NOT NULL            
);
INSERT INTO users (username, email, password) VALUES
('john_doe', 'john.doe@example.com', '1234'),         -- Uživatel s heslem 1234
('jane_doe', 'jane.doe@example.com', 'password123'),  -- Uživatel s heslem password123
('admin', 'admin@example.com', 'adminpass');          -- Administrátor s heslem adminpass


