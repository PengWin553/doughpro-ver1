<?php
include('connection.php');

// Check if the form data is set
if (isset($_POST['stock_name'])) {
    $inventoryId = $_POST['stock_name'];  // It's actually inventory ID
    $quantity = $_POST['stock_quantity'];
    $expiry = $_POST['stock_expiry'];

    try {
        // Insert the new stock entry into the database
        $stmt = $connection->prepare("INSERT INTO stocks_table (inventory_id, quantity, expiry_date, created_at, updated_at) VALUES (:inventoryId, :quantity, :expiry, NOW(), NOW())");
        $stmt->bindParam(':inventoryId', $inventoryId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':expiry', $expiry);
        $stmt->execute();
        
        echo json_encode(['res' => 'success']);
    } catch(PDOException $e) {
        echo json_encode(['res' => 'error', 'msg' => $e->getMessage()]);
    }
}
?>
