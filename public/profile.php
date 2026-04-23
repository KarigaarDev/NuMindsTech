<?php
require   '../app/config/db.php';
require '../app/core/helpers.php';
Auth::startSession();
require '../app/controllers/ProfileController.php';

Auth::requireLogin();

$controller = new ProfileController($pdo);

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';
    
    if ($action === 'update') {
        $controller->update($_POST);
    } elseif ($action === 'password') {
        $controller->updatePassword($_POST);
    }
}

// Display view
$controller->index();
