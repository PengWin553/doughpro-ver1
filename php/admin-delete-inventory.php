<?php 
include ('connection.php');

if (isset($_POST['inventory_id'])) {
    $id = $_POST['inventory_id'];
    try {
        $query = "DELETE FROM inventory_table WHERE inventory_id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();

        echo json_encode(["res" => "success"]);
    } catch (PDOException $th) {
        echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
    }
} else {
    echo json_encode(['res' => 'error', 'message' => 'Product ID not provided.']);
}
?>