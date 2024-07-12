<?php
include('connection.php');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 8;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$offset = ($page - 1) * $items_per_page;

$query = "SELECT stocks_out_table.stock_id, inventory_table.inventory_name, stocks_out_table.quantity, stocks_out_table.remaining_quantity, stocks_out_table.used, stocks_out_table.spoiled 
          FROM stocks_out_table 
          INNER JOIN inventory_table ON stocks_out_table.inventory_id = inventory_table.inventory_id 
          WHERE inventory_table.inventory_name LIKE :search ";

$params = [':search' => "%$search%"];

if ($filter === 'used') {
    $query .= "AND stocks_out_table.used = 1 ";
} elseif ($filter === 'spoiled') {
    $query .= "AND stocks_out_table.spoiled = 1 ";
}

$query .= "LIMIT :limit OFFSET :offset";

$stmt = $connection->prepare($query);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalQuery = "SELECT COUNT(*) as total FROM stocks_out_table 
               INNER JOIN inventory_table ON stocks_out_table.inventory_id = inventory_table.inventory_id 
               WHERE inventory_table.inventory_name LIKE :search";

if ($filter === 'used') {
    $totalQuery .= " AND stocks_out_table.used = 1";
} elseif ($filter === 'spoiled') {
    $totalQuery .= " AND stocks_out_table.spoiled = 1";
}

$stmtTotal = $connection->prepare($totalQuery);
$stmtTotal->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmtTotal->execute();
$total = $stmtTotal->fetchColumn();

$response = [
    'res' => 'success',
    'data' => $data,
    'page' => $page,
    'total' => $total,
    'limit' => $items_per_page
];

echo json_encode($response);
?>