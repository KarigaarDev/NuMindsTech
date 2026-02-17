<?php
// public/billing.php
session_start();
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

Auth::requireLogin();

// Fetch Invoices for the logged-in client
$userId = Auth::userId();
$stmt = $pdo->prepare("SELECT * FROM invoices WHERE user_id = ? ORDER BY due_date DESC");
$stmt->execute([$userId]);
$invoices = $stmt->fetchAll();

$title = 'Billing & Invoices';

require '../app/views/dashboard/layout.php';
