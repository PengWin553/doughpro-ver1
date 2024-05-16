<?php
include ('connection.php');

try {
    $query = "SELECT category_id, category_name FROM category_table ORDER BY category_id DESC"; // Adjust the query according to your database structure
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["res" => "success", "data" => $result]);
} catch (PDOException $th) {
    echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
}
?>
