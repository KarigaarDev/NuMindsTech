<?php
// public/client-dashboard.php
session_start();
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
require_once '../app/controllers/ClientPortalController.php';

Auth::requireLogin();

// Instantiate controller and display client dashboard
$controller = new ClientPortalController($pdo);
$controller->index();

