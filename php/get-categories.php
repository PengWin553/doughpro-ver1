<?php
include('connection.php');

try {
    $query = "SELECT category_id, category_name FROM category_table";
    $statement = $connection->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($categories);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>