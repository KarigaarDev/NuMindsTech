<?php
// migrate_phase2.php
require_once 'app/config/db.php';

try {
    // 1. Add status to leads table if it doesn't exist
    $cols = $pdo->query("SHOW COLUMNS FROM leads LIKE 'status'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE leads ADD COLUMN status ENUM('new', 'contacted', 'converted', 'lost') DEFAULT 'new' AFTER ip_address");
        echo "Successfully added 'status' column to 'leads' table.\n";
    } else {
        echo "'status' column already exists in 'leads' table.\n";
    }

    // 2. Create testimonials table
    $pdo->exec("CREATE TABLE IF NOT EXISTS testimonials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client_name VARCHAR(255) NOT NULL,
        client_position VARCHAR(255),
        content TEXT NOT NULL,
        avatar VARCHAR(255),
        status ENUM('active', 'hidden') DEFAULT 'active',
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    echo "Successfully created/verified 'testimonials' table.\n";

    // 3. Populate sample testimonials if empty
    $count = $pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();
    if ($count == 0) {
        $samples = [
            ['Ali Saif', 'CEO, EduStream', 'The system Numinds built for our campus is exceptionally reliable. Clarity and control were exactly what we needed.', 'ali-saif.png', 'active', 1],
            ['Zubair Adil', 'Director, Al-Noor NGO', 'Finally, a tech partner who understands values. Their clean-code approach has made our data management effortless.', 'zubair-adil.png', 'active', 2],
            ['Irfan K.', 'Founder, Stylofur', 'High performance and no bloat. Our e-commerce conversion rates soared after we implemented the custom solution.', 'irfan-k.png', 'active', 3]
        ];
        
        $stmt = $pdo->prepare("INSERT INTO testimonials (client_name, client_position, content, avatar, status, display_order) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($samples as $s) {
            $stmt->execute($s);
        }
        echo "Inserted sample testimonials.\n";
    }

    // 4. Add default settings for social and sections
    $defaults = [
        'show_hero' => '1',
        'show_stats' => '1',
        'show_services' => '1',
        'show_portfolio' => '1',
        'show_testimonials' => '1',
        'show_blogs' => '1',
        'show_cta' => '1',
        'facebook_url' => '',
        'instagram_url' => '',
        'twitter_url' => '',
        'linkedin_url' => '',
        'whatsapp_number' => ''
    ];

    $stmt = $pdo->prepare("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (?, ?)");
    foreach ($defaults as $k => $v) {
        $stmt->execute([$k, $v]);
    }
    echo "Inserted default section and social settings.\n";

} catch (PDOException $e) {
    die("Migration failed: " . $e->getMessage());
}
