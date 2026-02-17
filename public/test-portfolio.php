<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

$homeItems = $pdo->query(
    "SELECT * FROM portfolio_items WHERE status = 'published' ORDER BY display_order ASC, created_at DESC LIMIT 4"
)->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Portfolio Fetch Check</h2>";
echo "<p>Items count: " . count($homeItems) . "</p>";
echo "<p>Items data:</p>";
echo "<pre>";
var_dump($homeItems);
echo "</pre>";

echo "<p>JSON encoded:</p>";
echo "<pre>";
echo json_encode($homeItems, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
echo "</pre>";

echo "<h3>Test what would appear in x-data:</h3>";
?>

<div x-data="{ items: <?= json_encode($homeItems) ?> }">
    <p>Total items in Alpine: <span x-text="items.length"></span></p>
    <pre x-text="JSON.stringify(items, null, 2)"></pre>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
