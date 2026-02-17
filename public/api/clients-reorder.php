<?php
session_start();

require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
require_once '../app/controllers/ClientsController.php';

Auth::requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Method not allowed']));
}

$data = json_decode(file_get_contents('php://input'), true);
$ids = $data['ids'] ?? [];

$controller = new ClientsController($pdo);
$controller->reorder($ids);
