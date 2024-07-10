<?php
include ('connection.php');

// Set headers for JSON response
header('Content-Type: application/json');
header('Cache-Control: no-cache');

// Function to fetch the latest categories from the database with pagination
function fetchCategories($connection, $offset, $limit) {
    $query = "SELECT category_id, category_name FROM category_table ORDER BY category_id DESC LIMIT :limit OFFSET :offset";
    $statement = $connection->prepare($query);
    $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get the total number of categories
function getTotalCategories($connection) {
    $query = "SELECT COUNT(*) as total FROM category_table";
    $statement = $connection->prepare($query);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC)['total'];
}

// Get the page and limit from the query string
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

try {
    $categories = fetchCategories($connection, $offset, $limit);
    $totalCategories = getTotalCategories($connection);

    echo json_encode([
        "res" => "success",
        "data" => $categories,
        "page" => $page,
        "total" => $totalCategories,
        "limit" => $limit
    ]);
} catch (PDOException $th) {
    echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
}
?>
