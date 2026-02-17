<?php
require 'app/config/db.php';

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) UNIQUE NOT NULL,
        setting_value TEXT,
        group_name VARCHAR(50) DEFAULT 'general',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    $defaults = [
        'site_title' => 'Numinds Tech — Simple Digital Systems',
        'site_description' => 'We build simple, secure websites and business dashboards for schools, organizations, and growing businesses.',
        'maintenance_mode' => '0',
        'social_facebook' => 'https://facebook.com/numindstech',
        'social_twitter' => 'https://twitter.com/numindstech',
        'social_instagram' => 'https://instagram.com/numindstech',
        'social_linkedin' => 'https://linkedin.com/company/numindstech',
        'contact_email' => 'contact@numindstech.com',
        'contact_phone' => '+91 0000 000 000',
        'contact_address' => 'NuMinds Tech HQ, Digital City',
    ];

    foreach ($defaults as $key => $value) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (?, ?)");
        $stmt->execute([$key, $value]);
    }

    echo "Settings table created and populated successfully.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
