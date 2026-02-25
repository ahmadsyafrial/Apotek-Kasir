<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT id, name, price, stock, unit FROM products");
    $products = $stmt->fetchAll();

    echo json_encode($products);
} catch (PDOException $e) {
    echo json_encode([
        'error' => 'Query gagal',
        'message' => $e->getMessage()
    ]);
}
