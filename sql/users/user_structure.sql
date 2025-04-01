CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,              -- Unique ID for each user
    username VARCHAR(255) UNIQUE NOT NULL,          -- Username of the user (unique)
    password VARCHAR(255) NOT NULL,                 -- Password (hashed)
    role ENUM('user', 'librarian') DEFAULT 'user',  -- Role of the user (user or librarian)
    );