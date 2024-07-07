<?php
include('connection.php');

try {
    $query = "
        SELECT 
            inventory_table.inventory_id, 
            inventory_table.inventory_name, 
            inventory_table.inventory_description, 
            inventory_table.inventory_category, 
            inventory_table.inventory_price, 
            IFNULL(SUM(stocks_table.quantity), 0) AS current_stock, 
            inventory_table.min_stock_level, 
            inventory_table.unit, 
            category_table.category_name 
        FROM 
            inventory_table 
        JOIN 
            category_table 
        ON 
            inventory_table.inventory_category = category_table.category_id 
        LEFT JOIN 
            stocks_table 
        ON 
            inventory_table.inventory_id = stocks_table.inventory_id 
        GROUP BY 
            inventory_table.inventory_id,
            inventory_table.inventory_name,
            inventory_table.inventory_description,
            inventory_table.inventory_category,
            inventory_table.inventory_price,
            inventory_table.min_stock_level,
            inventory_table.unit,
            category_table.category_name
        ORDER BY 
            inventory_table.inventory_id DESC";
    
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["res" => "success", "data" => $result]);
} catch (PDOException $e) {
    echo json_encode(['res' => 'error', 'message' => $e->getMessage()]);
}
?>
