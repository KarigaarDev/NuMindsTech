<?php
// admin/analytics.php
require_once __DIR__ . '/../app/core/Env.php';
Env::load();
session_start();
require_once __DIR__ . '/../app/config/db.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/controllers/AnalyticsController.php';

$controller = new AnalyticsController($pdo);
$controller->index();

