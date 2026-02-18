<?php
// Load environment
require_once __DIR__ . '/../core/Env.php';

// Database credentials from environment or defaults
$db_host = Env::get('DB_HOST', 'localhost');
$db_name = Env::get('DB_NAME', 'numinds_db');
$db_user = Env::get('DB_USER', 'root');
$db_pass = Env::get('DB_PASS', '');

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection error. Check logs for details.");
}