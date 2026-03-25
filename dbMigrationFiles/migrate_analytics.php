<?php
require_once __DIR__ . '/../app/config/db.php';

try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS site_analytics (
            id INT AUTO_INCREMENT PRIMARY KEY,
            session_id VARCHAR(255) NULL,
            ip_address VARCHAR(45) NULL,
            user_agent VARCHAR(255) NULL,
            page_url VARCHAR(255) NULL,
            ref_code VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    echo "Table 'site_analytics' created successfully.\n";
} catch (PDOException $e) {
    die("Migration failed: " . $e->getMessage() . "\n");
}
