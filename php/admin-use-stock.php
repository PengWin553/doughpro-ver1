<?php
include('connection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stockId = $_POST['stock_id'];
    $useQuantity = $_POST['quantity'];
    try {
        $connection->beginTransaction();
        
        // Get current stock information from stocks_out_table
        $stmt = $connection->prepare("SELECT remaining_quantity, used FROM stocks_out_table WHERE stock_id = :stock_id");
        $stmt->bindParam(':stock_id', $stockId);
        $stmt->execute();
        $currentStock = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$currentStock) {
            throw new Exception("Stock not found");
        }
        
        $newRemainingQuantity = $currentStock['remaining_quantity'] - $useQuantity;
        $newUsedQuantity = $currentStock['used'] + $useQuantity;
        
        if ($newRemainingQuantity < 0) {
            throw new Exception("Not enough stock available");
        }
        
        // --- START OF NEW CODE ---
        
        // Check the current quantity in stocks_table
        $checkStocksTableStmt = $connection->prepare("SELECT remaining_quantity FROM stocks_table WHERE stock_id = :stock_id");
        $checkStocksTableStmt->bindParam(':stock_id', $stockId);
        $checkStocksTableStmt->execute();
        $stocksTableQuantity = $checkStocksTableStmt->fetchColumn();
        
        if ($stocksTableQuantity < $useQuantity) {
            throw new Exception("Not enough stock available in main inventory");
        }
        
        // --- END OF NEW CODE ---
        
        // Update the stocks_out_table
        $updateStmt = $connection->prepare("UPDATE stocks_out_table SET remaining_quantity = :remaining_quantity, used = :used WHERE stock_id = :stock_id");
        $updateStmt->bindParam(':remaining_quantity', $newRemainingQuantity);
        $updateStmt->bindParam(':used', $newUsedQuantity);
        $updateStmt->bindParam(':stock_id', $stockId);
        $updateStmt->execute();
        
        // Update the stocks_table
        $updateStocksTableStmt = $connection->prepare("UPDATE stocks_table SET remaining_quantity = remaining_quantity - :use_quantity WHERE stock_id = :stock_id");
        $updateStocksTableStmt->bindParam(':use_quantity', $useQuantity);
        $updateStocksTableStmt->bindParam(':stock_id', $stockId);
        $updateStocksTableStmt->execute();
        
        $connection->commit();
        echo json_encode(['res' => 'success']);
    } catch (Exception $e) {
        $connection->rollBack();
        echo json_encode(['res' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['res' => 'error', 'message' => 'Invalid request method']);
}
?>