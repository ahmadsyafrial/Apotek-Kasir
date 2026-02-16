<?php
require_once 'config.php'; 

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

try {
    $pdo->beginTransaction();
    
    // Generate transaction code
    $transactionCode = 'TRX' . date('YmdHis') . rand(100, 999);
    
    // Calculate totals
    $subtotal = 0;
    foreach ($data['items'] as $item) {
        $subtotal += $item['price'] * $item['qty'];
    }
    
    $discount = 0;
    $memberId = null;
    
    if ($data['member_id']) {
        $stmt = $pdo->prepare("SELECT discount_percent FROM members WHERE id = ?");
        $stmt->execute([$data['member_id']]);
        $member = $stmt->fetch();
        
        if ($member) {
            $discount = $subtotal * ($member['discount_percent'] / 100);
            $memberId = $data['member_id'];
        }
    }
    
    $total = $subtotal - $discount;
    
    // Insert transaction
    $stmt = $pdo->prepare("
        INSERT INTO transactions 
        (transaction_code, member_id, subtotal, discount_amount, total_amount, 
         payment_method, cash_amount, change_amount, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'completed')
    ");
    
    $cashAmount = $data['payment_method'] === 'cash' ? $data['cash_amount'] : $total;
    $changeAmount = $data['payment_method'] === 'cash' ? $data['cash_amount'] - $total : 0;
    
    $stmt->execute([
        $transactionCode, $memberId, $subtotal, $discount, $total,
        $data['payment_method'], $cashAmount, $changeAmount
    ]);
    
    $transactionId = $pdo->lastInsertId();
    
    // Insert items and update stock
    $stmtItem = $pdo->prepare("
        INSERT INTO transaction_items 
        (transaction_id, product_id, quantity, price, subtotal) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $stmtUpdateStock = $pdo->prepare("
        UPDATE products 
        SET stock = stock - ? 
        WHERE id = ? AND stock >= ?
    ");
    
    foreach ($data['items'] as $item) {
        // Insert item
        $stmtItem->execute([
            $transactionId,
            $item['id'],
            $item['qty'],
            $item['price'],
            $item['price'] * $item['qty']
        ]);
        
        // Update stock with validation
        $stmtUpdateStock->execute([$item['qty'], $item['id'], $item['qty']]);
        
        if ($stmtUpdateStock->rowCount() === 0) {
            throw new Exception("Stok tidak mencukupi untuk: " . $item['name']);
        }
    }
    
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'transaction_code' => $transactionCode,
        'total' => $total,
        'discount' => $discount
    ]);
    
} catch(Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>