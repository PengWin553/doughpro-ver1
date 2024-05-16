<?php 
include ('connection.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $query = "DELETE FROM users_table WHERE user_id = :id";
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