<?php
session_start();

require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

Auth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::verify();

    $id = $_POST['id'] ?? 0;
    $status = $_POST['status'] ?? 'New';
    $remarks = $_POST['remarks'] ?? '';

    $stmt = $pdo->prepare("UPDATE leads SET status = ?, remarks = ? WHERE id = ?");
    $stmt->execute([$status, $remarks, $id]);

    redirect('admin/lead-view?id=' . $id . '&updated=1');
} else {
    redirect('admin/leads');
}
