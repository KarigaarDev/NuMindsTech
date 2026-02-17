<?php
// public/portfolio-delete.php
session_start();
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

Auth::requireLogin();
Auth::requireAdmin();

$id = $_GET['id'] ?? null;

if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::verify();
    
    // Get image filename before deleting
    $stmt = $pdo->prepare("SELECT featured_image FROM portfolio_items WHERE id = ?");
    $stmt->execute([$id]);
    $image = $stmt->fetchColumn();
    
    // Delete from database
    $stmt = $pdo->prepare("DELETE FROM portfolio_items WHERE id = ?");
    $stmt->execute([$id]);
    
    // Delete image file if exists
    if ($image && file_exists("../public/uploads/$image")) {
        unlink("../public/uploads/$image");
    }
    
    $_SESSION['success'] = 'Portfolio item deleted successfully!';
}

redirect('portfolio');
