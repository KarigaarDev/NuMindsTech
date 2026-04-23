<?php
// session_start(); handled by Auth::startSession() below

require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
Auth::startSession();
require_once '../app/controllers/LeadsController.php';

Auth::requireLogin();

// Instantiate controller and display leads
$controller = new LeadsController($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === 'delete' && isset($_POST['id'])) {
        $controller->delete($_POST['id']);
        header('Location: ' . url('admin/leads'));
        exit;
    } else {
        $controller->{$action}($_POST);
    }
}
$controller->index();
