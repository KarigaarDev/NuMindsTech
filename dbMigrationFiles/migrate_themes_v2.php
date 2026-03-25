<?php
require_once __DIR__ . '/../app/core/Env.php';
Env::load();
require_once __DIR__ . '/../app/config/db.php';

try {
    // Drop existing table to rebuild with HEX format and exact columns
    $pdo->exec("DROP TABLE IF EXISTS themes");

    // 1. Create themes table
    $sql = "CREATE TABLE IF NOT EXISTS themes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        is_active BOOLEAN DEFAULT FALSE,
        font_sans VARCHAR(100) DEFAULT 'Inter',
        font_display VARCHAR(100) DEFAULT 'Outfit',
        
        -- Light Mode Tokens (HEX values)
        light_primary VARCHAR(50) DEFAULT '#085ae6',
        light_accent VARCHAR(50) DEFAULT '#f1501a',
        light_secondary VARCHAR(50) DEFAULT '#1b2434',
        light_dark VARCHAR(50) DEFAULT '#f4f6f9',
        light_navy VARCHAR(50) DEFAULT '#34455f',
        light_teal VARCHAR(50) DEFAULT '#14b8a6',
        light_tech VARCHAR(50) DEFAULT '#f4f6f9',
        light_text_heading VARCHAR(50) DEFAULT '#0f172a',
        light_text_body VARCHAR(50) DEFAULT '#64748b',
        light_text_muted VARCHAR(50) DEFAULT '#94a3b8',
        light_text_inverse VARCHAR(50) DEFAULT '#ffffff',
        light_btn_bg VARCHAR(50) DEFAULT '#085ae6',
        light_btn_text VARCHAR(50) DEFAULT '#ffffff',

        -- Dark Mode Tokens (HEX values)
        dark_primary VARCHAR(50) DEFAULT '#3b82f6',
        dark_accent VARCHAR(50) DEFAULT '#fd5d26',
        dark_secondary VARCHAR(50) DEFAULT '#050b14',
        dark_dark VARCHAR(50) DEFAULT '#050b14',
        dark_navy VARCHAR(50) DEFAULT '#0f172a',
        dark_teal VARCHAR(50) DEFAULT '#2dd4bf',
        dark_tech VARCHAR(50) DEFAULT '#0f172a',
        dark_text_heading VARCHAR(50) DEFAULT '#ffffff',
        dark_text_body VARCHAR(50) DEFAULT '#94a3b8',
        dark_text_muted VARCHAR(50) DEFAULT '#64748b',
        dark_text_inverse VARCHAR(50) DEFAULT '#ffffff',
        dark_btn_bg VARCHAR(50) DEFAULT '#3b82f6',
        dark_btn_text VARCHAR(50) DEFAULT '#ffffff',

        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    echo "Themes table rebuilt successfully with HEX columns.\n";

    // 2. Insert Default Theme (NuMinds Base)
    $insert = "INSERT INTO themes (
        name, is_active, font_sans, font_display,
        light_primary, light_accent, light_secondary, light_dark, light_navy, light_teal, light_tech, light_text_heading, light_text_body, light_text_muted, light_text_inverse, light_btn_bg, light_btn_text,
        dark_primary, dark_accent, dark_secondary, dark_dark, dark_navy, dark_teal, dark_tech, dark_text_heading, dark_text_body, dark_text_muted, dark_text_inverse, dark_btn_bg, dark_btn_text
    ) VALUES (
        'NuMinds Base', 1, 'Inter', 'Outfit',
        '#085ae6', '#f1501a', '#1b2434', '#f4f6f9', '#34455f', '#14b8a6', '#f4f6f9', '#0f172a', '#64748b', '#94a3b8', '#ffffff', '#085ae6', '#ffffff',
        '#3b82f6', '#fd5d26', '#050b14', '#050b14', '#0f172a', '#2dd4bf', '#0f172a', '#ffffff', '#94a3b8', '#64748b', '#ffffff', '#3b82f6', '#ffffff'
    )";
    $pdo->exec($insert);
    echo "Themes table rebuilt successfully with HEX columns and seeded.\n";

} catch (PDOException $e) {
    die("Migration failed: " . $e->getMessage() . "\n");
}
