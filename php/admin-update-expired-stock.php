<?php
include('connection.php');

$data = json_decode(file_get_contents('php://input'), true);

$stock_id = isset($data['stock_id']) ? (int)$data['stock_id'] : 0;
$remaining_quantity = isset($data['remaining_quantity']) ? (int)$data['remaining_quantity'] : 0;

if ($stock_id > 0 && $remaining_quantity > 0) {
    try {
        // Update the expired column to the remaining quantity
        $query = "UPDATE stocks_out_table 
                  SET expired = :remaining_quantity
                  WHERE stock_id = :stock_id";

        $statement = $connection->prepare($query);
        $statement->bindValue(':remaining_quantity', $remaining_quantity, PDO::PARAM_INT);
        $statement->bindValue(':stock_id', $stock_id, PDO::PARAM_INT);
        $statement->execute();

        echo json_encode(["res" => "success"]);
    } catch (PDOException $e) {
        echo json_encode(["res" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["res" => "error", "message" => "Invalid input"]);
}
?>
