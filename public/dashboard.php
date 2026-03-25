<?php
// public/dashboard.php
session_start();

require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
require_once '../app/controllers/DashboardController.php';

Auth::requireLogin();

// Instantiate controller and display dashboard
$controller = new DashboardController($pdo);
$controller->index();

