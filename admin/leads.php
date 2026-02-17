<?php
session_start();

require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
require_once '../app/controllers/LeadsController.php';

Auth::requireLogin();

// Instantiate controller and display leads
$controller = new LeadsController($pdo);
$controller->index();

