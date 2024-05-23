<?php 
include ('connection.php');

if (isset($_POST['stock_id'])) {
    $id = $_POST['stock_id'];
    try {
        $query = "DELETE FROM stocks_table WHERE stock_id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();

        echo json_encode(["res" => "success"]);
    } catch (PDOException $th) {
        echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
    }
} else {
    echo json_encode(['res' => 'error', 'message' => 'Stock ID not provided.']);
}
?>