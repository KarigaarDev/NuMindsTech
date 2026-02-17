<?php
session_start();

require_once __DIR__ . '/../app/config/db.php';
require_once __DIR__ . '/../app/core/helpers.php';

Auth::requireLogin();

/* Validate ID */
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
    redirect('dashboard');
}

/* Fetch lead */
$stmt = $pdo->prepare("SELECT * FROM leads WHERE id = ?");
$stmt->execute([$id]);
$lead = $stmt->fetch();

if (!$lead) {
    redirect('dashboard');
}

$title = 'Lead Details';

/* Load dashboard layout */
require __DIR__ . '/../app/views/dashboard/layout.php';
