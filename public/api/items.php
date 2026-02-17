<?php
// public/api/items.php
header('Content-Type: application/json');
require_once '../../app/config/db.php';
require_once '../../app/core/helpers.php';
require_once '../../app/controllers/PortfolioController.php';

try {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 4;

    $controller = new PortfolioController($pdo);
    $result = $controller->getPublicPaginated($page, $perPage);

    echo json_encode([
        'success' => true,
        'items' => $result['items'],
        'has_more' => $result['has_more'],
        'total' => $result['total']
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Failed to load items'
    ]);
}
