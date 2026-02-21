<?php
require '../app/config/db.php';
require '../app/core/helpers.php';
require '../app/controllers/LeadsController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // If AJAX, return JSON error
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit;
    }
    redirect('');
}

Csrf::verify();

// Use controller to save lead
$leadsController = new LeadsController($pdo);

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

try {
    $id = $leadsController->store($_POST);
    if ($isAjax) {
        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Thank you — your request has been received.']);
        exit;
    }
    redirect('?sent=1');
} catch (Exception $e) {
    // Controller may already have emitted JSON on validation failures. For safety, return JSON for AJAX.
    if ($isAjax) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error']);
        exit;
    }
    // fallback redirect
    redirect('?sent=1');
}
