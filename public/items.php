<?php
// public/items.php
session_start();
require '../app/config/db.php';
require '../app/core/helpers.php';

Auth::requireLogin();

// ADD ITEM
if (isset($_POST['save'])) {
    Csrf::verify();
    $title = $_POST['title'];
    $desc  = $_POST['description'];

    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        
        // 1. Validate Error
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die('File upload error');
        }

        // 2. Validate Size (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            die('File too large (max 2MB)');
        }

        // 3. Validate Type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, $allowedTypes)) {
            die('Invalid file type. Only JPG, PNG, and WebP are allowed.');
        }

        // 4. Generate Safe Filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $imageName = bin2hex(random_bytes(16)) . '.' . $ext;

        // Ensure uploads directory exists
        if (!is_dir(__DIR__ . '/uploads')) {
            mkdir(__DIR__ . '/uploads', 0755, true);
        }
        
        if (!move_uploaded_file($file['tmp_name'], __DIR__ . "/uploads/$imageName")) {
            die('Failed to save file');
        }
    }

    $stmt = $pdo->prepare(
        "INSERT INTO items (title, description, image) VALUES (?,?,?)"
    );
    $stmt->execute([$title, $desc, $imageName]);

    redirect('items');
}

// FETCH ITEMS
$items = $pdo->query("SELECT * FROM items ORDER BY id DESC")->fetchAll();

$title = 'Manage Items';

require '../app/views/dashboard/layout.php';
