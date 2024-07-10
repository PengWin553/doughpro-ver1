<?php
include('connection.php');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 8;
$offset = ($page - 1) * $limit;

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
            inventory_table.inventory_id DESC
        LIMIT :limit OFFSET :offset";
    
    $statement = $connection->prepare($query);
    $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
    $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Get the total count of items
    $countQuery = "SELECT COUNT(*) as total FROM inventory_table";
    $countStatement = $connection->prepare($countQuery);
    $countStatement->execute();
    $countResult = $countStatement->fetch(PDO::FETCH_ASSOC);
    $totalItems = $countResult['total'];

    echo json_encode(["res" => "success", "data" => $result, "page" => $page, "total" => $totalItems, "limit" => $limit]);
} catch (PDOException $e) {
    echo json_encode(['res' => 'error', 'message' => $e->getMessage()]);
}
?>
