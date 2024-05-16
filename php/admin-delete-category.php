<?php 
include ('connection.php');

if (isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];
    try {
        $query = "DELETE FROM category_table WHERE category_id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $categoryId);
        $statement->execute();

        echo json_encode(["res" => "success"]);
    } catch (PDOException $th) {
        echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
    }
} else {
    echo json_encode(['res' => 'error', 'message' => 'Product ID not provided.']);
}
?>