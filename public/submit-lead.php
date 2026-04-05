<?php
require '../app/config/db.php';
require '../app/core/helpers.php';
require '../app/controllers/LeadsController.php';

header('Content-Type: application/json'); // ✅ Always JSON for AJAX

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// ❌ Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
    exit;
}

// ✅ CSRF Safe Handling
try {
    Csrf::verify();
} catch (Exception $e) {
    http_response_code(419);
    echo json_encode([
        'success' => false,
        'message' => 'Session expired. Refresh and try again.'
    ]);
    exit;
}

// ✅ Controller
$leadsController = new LeadsController($pdo);

try {

    $id = $leadsController->store($_POST);

    echo json_encode([
        'success' => true,
        'id' => $id,
        'message' => 'Thank you — your request has been received.'
    ]);
    exit;

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage() ?: 'Server error'
    ]);
    exit;
}