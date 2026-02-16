<?php
require_once 'config.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($query)) {
    echo json_encode(['products' => []]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT id, name, price, stock, unit 
        FROM products 
        WHERE name LIKE ? AND stock >= 0
        ORDER BY name ASC
    ");
    $stmt->execute(["%$query%"]);
    $products = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'products' => $products,
        'count' => count($products)
    ]);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>