<?php
// public/admin/testimonials.php
session_start();
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
require_once '../app/controllers/TestimonialsController.php';

$controller = new TestimonialsController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $controller->update($id, $_POST);
    } else {
        $controller->store($_POST);
    }
    redirect('admin/testimonials');
}

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

$controller->index($action, $id);
