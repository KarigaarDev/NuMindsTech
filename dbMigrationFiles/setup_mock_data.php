<?php
// Only run from CLI, never from web
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    die('This script must be run from command line only.');
}

require '../app/config/db.php';

try {
    // 1. Create Mock Client
    $name = "Global Brands Ltd";
    $email = "client@globalbrands.com";
    // Generate a random password for demo
    $demo_password = bin2hex(random_bytes(12));
    $pass = password_hash($demo_password, PASSWORD_DEFAULT);
    $role = "client";
    
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'active', NOW(), NOW()) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)");
    $stmt->execute([$name, $email, $pass, $role]);
    $userId = $pdo->lastInsertId();

    // 2. Add Mock Websites
    $stmt = $pdo->prepare("DELETE FROM client_websites WHERE user_id = ?");
    $stmt->execute([$userId]);
    
    $stmt = $pdo->prepare("INSERT INTO client_websites (user_id, site_name, site_url, status, plan) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userId, "Global Brands E-Store", "https://shop.globalbrands.com", "active", "enterprise"]);
    $stmt->execute([$userId, "Corporate Investor Portal", "https://investors.globalbrands.com", "active", "business"]);

    // 3. Add Mock Services
    $stmt = $pdo->prepare("DELETE FROM client_services WHERE user_id = ?");
    $stmt->execute([$userId]);
    
    $stmt = $pdo->prepare("INSERT INTO client_services (user_id, service_name, service_type, status, expiry_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userId, "Priority SEO Scaling", "Digital Marketing", "active", date('Y-m-d', strtotime('+6 months'))]);
    $stmt->execute([$userId, "24/7 Infrastructure Monitoring", "DevOps Support", "active", date('Y-m-d', strtotime('+1 year'))]);

    echo "✓ Mock data setup successful\n";
    echo "  Email: client@globalbrands.com\n";
    echo "  Password: Check your email or admin panel (automatically generated)\n";
} catch (PDOException $e) {
    echo "✗ Setup failed: " . $e->getMessage() . "\n";
    exit(1);
}
