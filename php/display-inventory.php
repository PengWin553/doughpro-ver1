<?php
include ('connection.php');

try {
    $query = "SELECT product_id, product_name, product_category, product_description, min_stock_level FROM products_table ORDER BY product_id DESC"; // Adjust the query according to your database structure
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["res" => "success", "data" => $result]);
} catch (PDOException $th) {
    echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
}
?>
