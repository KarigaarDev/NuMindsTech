<?php
// migrate_client_portal.php
require_once 'app/config/db.php';

try {
    // 0. Drop existing tables if they have legacy schema
    $pdo->exec("DROP TABLE IF EXISTS invoices");
    $pdo->exec("DROP TABLE IF EXISTS client_services");

    // 1. Create client_services table
    $pdo->exec("CREATE TABLE IF NOT EXISTS client_services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        service_name VARCHAR(255) NOT NULL,
        service_type VARCHAR(100) DEFAULT 'Cloud',
        status ENUM('active', 'pending', 'expired', 'suspended') DEFAULT 'active',
        plan VARCHAR(100) DEFAULT 'Standard',
        expiry_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    // 2. Create invoices table
    $pdo->exec("CREATE TABLE IF NOT EXISTS invoices (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        invoice_number VARCHAR(50) UNIQUE NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        status ENUM('paid', 'unpaid', 'overdue', 'cancelled') DEFAULT 'unpaid',
        due_date DATE,
        paid_at DATETIME NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    echo "Tables 'client_services' and 'invoices' created successfully.\n";

    // 3. Populate Mock Data for client@globalbrands.com
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = 'client@globalbrands.com'");
    $stmt->execute();
    $userId = $stmt->fetchColumn();

    if ($userId) {
        // Clear existing mock data for this client to avoid duplicates
        $stmt = $pdo->prepare("DELETE FROM client_services WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        $stmt = $pdo->prepare("DELETE FROM invoices WHERE user_id = ?");
        $stmt->execute([$userId]);

        // Add Services
        $services = [
            ['Enterprise Cloud Hosting', 'Infrastructure', 'active', 'Pro Plus', '2026-05-12'],
            ['Managed Security Audit', 'Security', 'active', 'Quarterly', '2026-03-01'],
            ['CDN & Edge Optimization', 'Network', 'pending', 'Standard', '2026-06-20']
        ];

        $stmt = $pdo->prepare("INSERT INTO client_services (user_id, service_name, service_type, status, plan, expiry_date) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($services as $s) {
            $stmt->execute([$userId, $s[0], $s[1], $s[2], $s[3], $s[4]]);
        }

        // Add Invoices
        $invoices = [
            ['INV-2026-001', 450.00, 'paid', '2026-01-15', '2026-01-10 14:30:00'],
            ['INV-2026-008', 1200.00, 'unpaid', '2026-02-28', null],
            ['INV-2025-099', 450.00, 'paid', '2025-12-15', '2025-12-12 09:15:00']
        ];

        $stmt = $pdo->prepare("INSERT INTO invoices (user_id, invoice_number, amount, status, due_date, paid_at) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($invoices as $i) {
            $stmt->execute([$userId, $i[0], $i[1], $i[2], $i[3], $i[4]]);
        }

        echo "Mock data for 'client@globalbrands.com' inserted successfully.\n";
    } else {
        echo "Client 'client@globalbrands.com' not found. Please run 'setup_mock_data.php' first.\n";
    }

} catch (PDOException $e) {
    die("Migration failed: " . $e->getMessage());
}
