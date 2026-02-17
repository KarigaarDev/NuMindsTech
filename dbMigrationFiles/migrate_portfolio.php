<?php
// migrate_portfolio.php
require_once 'app/config/db.php';

try {
    // Drop old items table if exists and create new portfolio_items
    $pdo->exec("DROP TABLE IF EXISTS items");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS portfolio_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        client_name VARCHAR(255),
        featured_image VARCHAR(255),
        gallery_images TEXT,
        category VARCHAR(100) DEFAULT 'Web Design',
        tags TEXT,
        project_url VARCHAR(255),
        completion_date DATE,
        status ENUM('draft', 'published') DEFAULT 'published',
        is_featured BOOLEAN DEFAULT 0,
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    echo "Table 'portfolio_items' created successfully.\n";

    // Populate sample data
    $samples = [
        [
            'EduStream Campus Portal',
            'A comprehensive school management system with student portals, attendance tracking, and real-time parent notifications.',
            'EduStream International',
            'school-dashboard.png',
            'Web Design',
            'Education, Dashboard, PHP',
            'https://edustream.example.com',
            '2025-11-15',
            1
        ],
        [
            'Al-Noor NGO Website',
            'Clean, accessible website for a non-profit organization with donation integration and volunteer management.',
            'Al-Noor Foundation',
            'ngo-website.png',
            'Web Design',
            'Non-Profit, Responsive, SEO',
            'https://alnoor.example.com',
            '2025-10-20',
            1
        ],
        [
            'Stylofur E-Commerce',
            'High-performance online furniture store with custom product configurator and seamless checkout experience.',
            'Stylofur Interiors',
            'ecommerce-site.png',
            'E-commerce',
            'Shopping, Payment Gateway, Custom',
            'https://stylofur.example.com',
            '2025-12-05',
            1
        ],
        [
            'TechCorp Dashboard',
            'Internal analytics dashboard for enterprise client with real-time data visualization and reporting.',
            'TechCorp Solutions',
            'analytics-dashboard.png',
            'Custom Apps',
            'Analytics, Enterprise, API',
            null,
            '2026-01-10',
            0
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO portfolio_items (title, description, client_name, featured_image, category, tags, project_url, completion_date, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($samples as $s) {
        $stmt->execute($s);
    }

    echo "Sample portfolio data inserted successfully.\n";

} catch (PDOException $e) {
    die("Migration failed: " . $e->getMessage());
}
