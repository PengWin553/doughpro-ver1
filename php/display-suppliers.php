<?php
include ('connection.php');

// Set headers for JSON response
header('Content-Type: application/json');
header('Cache-Control: no-cache');

// Function to fetch the latest suppliers from the database with pagination and search
function fetchSuppliers($connection, $offset, $limit, $search = '') {
    $query = "SELECT supplier_id, supplier_name, supply FROM suppliers_table ";
    if ($search !== '') {
        $query .= "WHERE supplier_name LIKE :search ";
    }
    $query .= "ORDER BY supplier_id DESC LIMIT :limit OFFSET :offset";
    $statement = $connection->prepare($query);
    $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    if ($search !== '') {
        $statement->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get the total number of suppliers with search
function getTotalSuppliers($connection, $search = '') {
    $query = "SELECT COUNT(*) as total FROM suppliers_table ";
    if ($search !== '') {
        $query .= "WHERE supplier_name LIKE :search";
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
    $suppliers = fetchSuppliers($connection, $offset, $limit, $search);
    $totalSuppliers = getTotalSuppliers($connection, $search);

    echo json_encode([
        "res" => "success",
        "data" => $suppliers,
        "page" => $page,
        "total" => $totalSuppliers,
        "limit" => $limit
    ]);
} catch (PDOException $th) {
    echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
}
?>
