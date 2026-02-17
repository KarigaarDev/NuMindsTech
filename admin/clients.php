<?php
session_start();

require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
require_once '../app/controllers/ClientsController.php';

Auth::requireLogin();

$controller = new ClientsController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'store';
    if ($action === 'store') {
        $controller->store($_POST, $_FILES);
    } elseif ($action === 'update' && !empty($_POST['id'])) {
        $controller->update((int)$_POST['id'], $_POST, $_FILES);
    } elseif ($action === 'delete' && !empty($_POST['id'])) {
        $controller->delete((int)$_POST['id']);
    }
    exit;
}

$controller->index();
