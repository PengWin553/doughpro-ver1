<?php
include('connection.php');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 8;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$offset = ($page - 1) * $items_per_page;

try {
    $total_query = "SELECT COUNT(*) as total FROM stocks_out_table
                    JOIN inventory_table ON stocks_out_table.inventory_id = inventory_table.inventory_id
                    WHERE inventory_table.inventory_name LIKE :search";

    if ($filter === 'used') {
        $total_query .= " AND stocks_out_table.used > 0";
    } elseif ($filter === 'spoiled') {
        $total_query .= " AND stocks_out_table.spoiled > 0";
    }

    $total_statement = $connection->prepare($total_query);
    $total_statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $total_statement->execute();
    $total_result = $total_statement->fetch(PDO::FETCH_ASSOC);
    $total_records = $total_result['total'];

    $query = "
        SELECT 
            stocks_out_table.stock_id, 
            inventory_table.inventory_name, 
            stocks_out_table.quantity, 
            stocks_out_table.remaining_quantity,
            stocks_out_table.used,
            stocks_out_table.spoiled,
            stocks_out_table.expiry_date,
            stocks_out_table.updated_at
        FROM 
            stocks_out_table
        JOIN 
            inventory_table 
        ON 
            stocks_out_table.inventory_id = inventory_table.inventory_id
        WHERE 
            inventory_table.inventory_name LIKE :search";

    if ($filter === 'used') {
        $query .= " AND stocks_out_table.used > 0";
    } elseif ($filter === 'spoiled') {
        $query .= " AND stocks_out_table.spoiled > 0";
    }

    $query .= " ORDER BY stocks_out_table.stock_id DESC LIMIT :limit OFFSET :offset";

    $statement = $connection->prepare($query);
    $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
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