<?php
include('connection.php');

try {
    $query = "
        SELECT 
            stocks_table.stock_id, 
            inventory_table.inventory_name, 
            stocks_table.quantity, 
            stocks_table.unit, 
            stocks_table.expiry_date
        FROM 
            stocks_table
        JOIN 
            inventory_table 
        ON 
            stocks_table.inventory_id = inventory_table.inventory_id
        ORDER BY 
            stocks_table.stock_id DESC";
    
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["res" => "success", "data" => $result]);
} catch (PDOException $e) {
    echo json_encode(['res' => 'error', 'message' => $e->getMessage()]);
}
?>
