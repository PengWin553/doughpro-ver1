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
    // Get the total count of products
    $total_query = "SELECT COUNT(*) as total FROM products_table WHERE product_name LIKE :search";
    $total_statement = $connection->prepare($total_query);
    $total_statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $total_statement->execute();
    $total_result = $total_statement->fetch(PDO::FETCH_ASSOC);
    $total_records = $total_result['total'];

    // Get the paginated products data
    $query = "SELECT * FROM products_table WHERE product_name LIKE :search ORDER BY product_id DESC LIMIT :limit OFFSET :offset";
    
    $statement = $connection->prepare($query);
    $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
    $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the response
    $response = [
        'res' => 'success',
        'data' => $products,
        'page' => $page,
        'limit' => $limit,
        'total' => $total_records
    ];

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['res' => 'error', 'message' => $e->getMessage()]);
}
?>