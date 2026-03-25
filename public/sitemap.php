<?php
// public/sitemap.php
header("Content-Type: application/xml; charset=utf-8");
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

$base = url('');

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= $base ?></loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    
    <?php
    // Add Portfolio Items
    $items = $pdo->query("SELECT id, updated_at FROM portfolio_items WHERE status = 'published' ORDER BY created_at DESC")->fetchAll();
    foreach ($items as $item): 
    ?>
    <url>
        <loc><?= $base ?>#solutions</loc>
        <lastmod><?= date('Y-m-d', strtotime($item['updated_at'])) ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
</urlset>
