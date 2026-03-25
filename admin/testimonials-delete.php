<?php
// public/admin/testimonials-delete.php
session_start();
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
require_once '../app/controllers/TestimonialsController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new TestimonialsController($pdo);
    $controller->delete($_POST['id']);
}
redirect('admin/testimonials');
