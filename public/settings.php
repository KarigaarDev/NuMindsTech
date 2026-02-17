<?php
// public/settings.php
session_start();
require '../app/config/db.php';
require '../app/core/helpers.php';

Auth::requireLogin();

$message = '';

// SAVE SETTINGS
if (isset($_POST['save_settings'])) {
    Csrf::verify();
    
    $settings = [
        'site_title' => $_POST['site_title'] ?? '',
        'site_description' => $_POST['site_description'] ?? '',
        'maintenance_mode' => isset($_POST['maintenance_mode']) ? '1' : '0',
        'social_facebook' => $_POST['social_facebook'] ?? '',
        'social_twitter' => $_POST['social_twitter'] ?? '',
        'social_instagram' => $_POST['social_instagram'] ?? '',
        'social_linkedin' => $_POST['social_linkedin'] ?? '',
        'contact_email' => $_POST['contact_email'] ?? '',
        'contact_phone' => $_POST['contact_phone'] ?? '',
        'contact_address' => $_POST['contact_address'] ?? '',
    ];

    // File Upload Handling
    $uploadDir = __DIR__ . '/uploads/';
    foreach (['site_logo', 'site_thumbnail'] as $fileKey) {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
            $newName = $fileKey . '_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $uploadDir . $newName)) {
                $settings[$fileKey] = $newName;
            }
        }
    }

    // Unified Save Logic
    foreach ($settings as $key => $value) {
        // Handle Flags (Boolean bit toggles)
        if ($key === 'maintenance_mode') {
            $stmt = $pdo->prepare("INSERT INTO site_flags (flag_key, flag_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE flag_value = VALUES(flag_value)");
            $stmt->execute([$key, $value]);
            continue;
        }

        // Handle General Settings
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        $stmt->execute([$key, $value]);
    }

    $message = "Settings updated successfully.";
}

// FETCH SETTINGS
$settings = getSiteSettings($pdo);

$title = 'Platform Settings';

require '../app/views/dashboard/layout.php';
