<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        try {
            if (!empty($search)) {
                $stmt = $pdo->prepare("
                    SELECT id, name, phone, discount_percent 
                    FROM members 
                    WHERE (name LIKE ? OR phone LIKE ?) AND is_active = 1
                    LIMIT 1
                ");
                $stmt->execute(["%$search%", "%$search%"]);
                $member = $stmt->fetch();
                
                if ($member) {
                    echo json_encode(['success' => true, 'member' => $member]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Member tidak ditemukan']);
                }
            } else {
                $stmt = $pdo->query("SELECT id, name, phone FROM members WHERE is_active = 1");
                echo json_encode(['success' => true, 'members' => $stmt->fetchAll()]);
            }
        } catch(PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;
}
?>