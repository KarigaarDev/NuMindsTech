<?php
require '../app/config/db.php';
require '../app/core/helpers.php';
require '../app/controllers/LeadsController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('');
}

Csrf::verify();

// Use controller to save lead
$leadsController = new LeadsController($pdo);
$leadsController->store($_POST);

redirect('?sent=1');
