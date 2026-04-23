<?php
/**
 * Event Tracking API Endpoint
 * Receives JSON data from client-side tracker and logs it to database
 */
header('Content-Type: application/json');

require_once '../../app/config/db.php';
require_once '../../app/core/Analytics.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['category']) || !isset($data['action'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

// Sanitize inputs
$category = filter_var($data['category'], FILTER_SANITIZE_SPECIAL_CHARS);
$action = filter_var($data['action'], FILTER_SANITIZE_SPECIAL_CHARS);
$label = filter_var($data['label'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

// Log the event
$result = Analytics::logEvent($pdo, $category, $action, $label);

echo json_encode(['success' => $result]);
