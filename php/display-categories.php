<?php
include ('connection.php');

// Set headers for JSON response
header('Content-Type: application/json');
header('Cache-Control: no-cache');

// Function to fetch the latest categories from the database with pagination and search
function fetchCategories($connection, $offset, $limit, $search = '') {
    $query = "SELECT category_id, category_name FROM category_table ";
    if ($search !== '') {
        $query .= "WHERE category_name LIKE :search ";
    }
    $query .= "ORDER BY category_id DESC LIMIT :limit OFFSET :offset";
    $statement = $connection->prepare($query);
    $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    if ($search !== '') {
        $statement->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get the total number of categories with search
function getTotalCategories($connection, $search = '') {
    $query = "SELECT COUNT(*) as total FROM category_table ";
    if ($search !== '') {
        $query .= "WHERE category_name LIKE :search";
    }
    $statement = $connection->prepare($query);
    if ($search !== '') {
        $statement->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC)['total'];
}

// Get the page and limit from the query string
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 8;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$offset = ($page - 1) * $limit;

try {
    $categories = fetchCategories($connection, $offset, $limit, $search);
    $totalCategories = getTotalCategories($connection, $search);

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
