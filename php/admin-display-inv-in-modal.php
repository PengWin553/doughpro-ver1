<?php
include('connection.php');

try {
    // Fetch the inventory items
    $stmt = $connection->prepare("SELECT inventory_id, inventory_name FROM inventory_table");
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['res' => 'success', 'inventory' => $inventory]);
} catch(PDOException $e) {
    echo json_encode(['res' => 'error', 'msg' => $e->getMessage()]);
}
?>
