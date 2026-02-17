<?php
require 'app/config/db.php';

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS client_websites (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        site_name VARCHAR(255),
        site_url VARCHAR(255),
        status VARCHAR(50) DEFAULT 'active',
        plan VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS client_services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        service_name VARCHAR(255),
        service_type VARCHAR(100),
        status VARCHAR(50) DEFAULT 'active',
        expiry_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    echo "Migration successful.";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
