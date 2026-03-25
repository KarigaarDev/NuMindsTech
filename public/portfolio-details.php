<?php
// public/portfolio-details.php
require_once __DIR__ . '/../app/config/db.php';
require_once __DIR__ . '/../app/core/helpers.php';

$slug = $_GET['slug'] ?? null;

if (!$slug) {
    redirect('');
}

// Fetch portfolio item by slug (using title as fallback for now or ID)
// For now, let's assume the slug is the ID or we match title.
// Better: Add a slug column to portfolio_items.
// Since I don't have a slug column, I'll use ID if numeric, otherwise try to match title.
if (is_numeric($slug)) {
    $stmt = $pdo->prepare("SELECT * FROM portfolio_items WHERE id = ? AND status = 'published'");
    $stmt->execute([$slug]);
} else {
    // Try to match title (sanitize slug back to title-like)
    $stmt = $pdo->prepare("SELECT * FROM portfolio_items WHERE REPLACE(LOWER(title), ' ', '-') = ? AND status = 'published'");
    $stmt->execute([$slug]);
}

$item = $stmt->fetch();

if (!$item) {
    require '404.php';
    exit;
}

$title = $item['title'] . ' | Portfolio';
$description = substr(strip_tags($item['description']), 0, 160);

require '../app/views/header.php';
require '../app/views/portfolio-details.php';
require '../app/views/footer.php';
