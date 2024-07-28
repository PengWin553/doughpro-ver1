<?php
include('connection.php');
session_start();

// Check if the user is logged in and has the "Admin" role
if (!isset($_SESSION["user_name"]) || $_SESSION["user_role"] !== 'Admin') {
    echo json_encode(['res' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

// Get pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 8;
$offset = ($page - 1) * $limit;

// Get search parameter
$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    // Get the total count of to_order items
    $total_query = "SELECT COUNT(*) as total FROM to_order_table t
                    JOIN inventory_table i ON t.inventory_id = i.inventory_id
                    WHERE i.inventory_name LIKE :search";
    $total_statement = $connection->prepare($total_query);
    $total_statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $total_statement->execute();
    $total_result = $total_statement->fetch(PDO::FETCH_ASSOC);
    $total_records = $total_result['total'];

    // Get the paginated to_order data with inventory_name
    $query = "SELECT t.to_order_id, i.inventory_name, t.to_order_quantity 
              FROM to_order_table t
              JOIN inventory_table i ON t.inventory_id = i.inventory_id
              WHERE i.inventory_name LIKE :search 
              ORDER BY t.to_order_id DESC 
              LIMIT :limit OFFSET :offset";
    
    $statement = $connection->prepare($query);
    $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
    $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $to_order_items = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the response
    $response = [
        'res' => 'success',
        'data' => $to_order_items,
        'page' => $page,
        'limit' => $limit,
        'total' => $total_records
    ];

    header('Content-Type: application/json');

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['res' => 'error', 'message' => $e->getMessage()]);
}
?>