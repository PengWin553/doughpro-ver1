<?php
include('connection.php');

// Get the current page number and items per page from the request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 8;
$offset = ($page - 1) * $items_per_page;

try {
    // Get the total count of stocks
    $total_query = "SELECT COUNT(*) as total FROM stocks_table";
    $total_statement = $connection->prepare($total_query);
    $total_statement->execute();
    $total_result = $total_statement->fetch(PDO::FETCH_ASSOC);
    $total_records = $total_result['total'];

    // Get the paginated stocks data
    $query = "
        SELECT 
            stocks_table.stock_id, 
            inventory_table.inventory_name, 
            stocks_table.quantity, 
            stocks_table.expiry_date
        FROM 
            stocks_table
        JOIN 
            inventory_table 
        ON 
            stocks_table.inventory_id = inventory_table.inventory_id
        ORDER BY 
            stocks_table.stock_id DESC
        LIMIT :limit OFFSET :offset";

    $statement = $connection->prepare($query);
    $statement->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
    $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "res" => "success", 
        "data" => $result, 
        "total" => $total_records, 
        "limit" => $items_per_page, 
        "page" => $page
    ]);
} catch (PDOException $e) {
    echo json_encode(['res' => 'error', 'message' => $e->getMessage()]);
}
?>
