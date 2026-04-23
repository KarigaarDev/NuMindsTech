<?php
require '../app/config/db.php';
require '../app/core/helpers.php';
Auth::startSession();

Auth::requireLogin();

$message = '';

// SAVE SETTINGS
if (isset($_POST['save_settings'])) {
    Csrf::verify();
    
    $settings = [
        'site_title' => $_POST['site_title'] ?? '',
        'site_description' => $_POST['site_description'] ?? '',
        'maintenance_mode' => isset($_POST['maintenance_mode']) ? '1' : '0',
        
        // Section Toggles
        'show_hero' => isset($_POST['show_hero']) ? '1' : '0',
        'show_stats' => isset($_POST['show_stats']) ? '1' : '0',
        'show_services' => isset($_POST['show_services']) ? '1' : '0',
        'show_portfolio' => isset($_POST['show_portfolio']) ? '1' : '0',
        'show_testimonials' => isset($_POST['show_testimonials']) ? '1' : '0',
        'show_blogs' => isset($_POST['show_blogs']) ? '1' : '0',
        'show_cta' => isset($_POST['show_cta']) ? '1' : '0',
        'show_problems' => isset($_POST['show_problems']) ? '1' : '0',
        'show_process' => isset($_POST['show_process']) ? '1' : '0',
        'show_chatbot' => isset($_POST['show_chatbot']) ? '1' : '0',
        'show_estimator' => isset($_POST['show_estimator']) ? '1' : '0',
        'show_grid_bg' => isset($_POST['show_grid_bg']) ? '1' : '0',
        'show_preloader' => isset($_POST['show_preloader']) ? '1' : '0',

        // Social Media
        'facebook_url' => $_POST['facebook_url'] ?? '',
        'twitter_url' => $_POST['twitter_url'] ?? '',
        'instagram_url' => $_POST['instagram_url'] ?? '',
        'linkedin_url' => $_POST['linkedin_url'] ?? '',
        'whatsapp_number' => $_POST['whatsapp_number'] ?? '',

        // Contact Info
        'contact_email' => $_POST['contact_email'] ?? '',
        'contact_phone' => $_POST['contact_phone'] ?? '',
        'contact_address' => $_POST['contact_address'] ?? '',

        // Promo Modal
        'promo_active' => isset($_POST['promo_active']) ? '1' : '0',
        'promo_title' => $_POST['promo_title'] ?? '',
        'promo_text' => $_POST['promo_text'] ?? '',

        // reCAPTCHA
        'recaptcha_site_key' => $_POST['recaptcha_site_key'] ?? '',
        'recaptcha_secret_key' => $_POST['recaptcha_secret_key'] ?? '',

        // Mail
        'mail_sender_name' => $_POST['mail_sender_name'] ?? '',
        'mail_sender_email' => $_POST['mail_sender_email'] ?? '',
        'mail_notifications_to' => $_POST['mail_notifications_to'] ?? '',
    ];


    // File Upload Handling
    $uploadDir = __DIR__ . '/uploads/';
    foreach (['site_logo', 'site_thumbnail', 'promo_image'] as $fileKey) {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
            $upload = $_FILES[$fileKey];
            $allowedMimes = ['image/png', 'image/jpeg', 'image/webp', 'image/x-icon', 'image/vnd.microsoft.icon'];
            $allowedExts = ['png', 'jpg', 'jpeg', 'webp', 'ico'];

            if (Validator::validateFile($upload, $allowedMimes, $allowedExts)) {
                $ext = strtolower(pathinfo($upload['name'], PATHINFO_EXTENSION));
                $newName = $fileKey . '_' . time() . '.' . $ext;
                if (move_uploaded_file($upload['tmp_name'], $uploadDir . $newName)) {
                    $settings[$fileKey] = $newName;
                }
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
    Logger::adminAction(Auth::userId(), 'UPDATE_PLATFORM_SETTINGS', 'Updated global site configuration and layout');
}

// FETCH SETTINGS
$settings = getSiteSettings($pdo, true);

$title = 'Platform Settings';

require '../app/views/dashboard/layout.php';
