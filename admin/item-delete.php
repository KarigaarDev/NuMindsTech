<?php
session_start();

require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

Auth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::verify();

    $id = $_POST['id'] ?? 0;

    // 1. Fetch image to delete file
    $stmt = $pdo->prepare("SELECT image FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();

    if ($item) {
        // 2. Delete file if exists
        if ($item['image']) {
            $path = __DIR__ . '/../public/uploads/' . $item['image'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // 3. Delete record
        $pdo->prepare("DELETE FROM items WHERE id = ?")->execute([$id]);
    }

    redirect('items');
} else {
    redirect('items');
}
