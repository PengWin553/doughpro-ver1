<?php
include('connection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stockId = $_POST['stock_id'];
    $discardQuantity = $_POST['quantity'];

    try {
        $connection->beginTransaction();

        // Get current stock information
        $stmt = $connection->prepare("SELECT remaining_quantity, expired FROM stocks_out_table WHERE stock_id = :stock_id");
        $stmt->bindParam(':stock_id', $stockId);
        $stmt->execute();
        $currentStock = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$currentStock) {
            throw new Exception("Stock not found");
        }

        if ($currentStock['remaining_quantity'] != $discardQuantity) {
            throw new Exception("Discard quantity does not match remaining quantity");
        }

        // Update the stocks_out_table
        $updateStmt = $connection->prepare("UPDATE stocks_out_table SET remaining_quantity = 0, discarded = discarded + :discard_quantity WHERE stock_id = :stock_id");
        $updateStmt->bindParam(':discard_quantity', $discardQuantity);
        $updateStmt->bindParam(':stock_id', $stockId);
        $updateStmt->execute();

        // Update the stocks_table
        $updateStocksTableStmt = $connection->prepare("UPDATE stocks_table SET remaining_quantity = remaining_quantity - :discard_quantity WHERE stock_id = :stock_id");
        $updateStocksTableStmt->bindParam(':discard_quantity', $discardQuantity);
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
