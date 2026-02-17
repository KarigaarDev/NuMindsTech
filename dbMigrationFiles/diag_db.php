<?php
require 'app/config/db.php';
function dump($q, $pdo) {
    echo "\n$q:\n";
    $stmt = $pdo->query($q);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo implode(" | ", array_keys($row)) . "\n";
        echo implode(" | ", array_values($row)) . "\n---\n";
    }
}
dump("DESCRIBE users", $pdo);
dump("DESCRIBE leads", $pdo);
dump("DESCRIBE items", $pdo);
