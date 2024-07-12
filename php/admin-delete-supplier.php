<?php 
include ('connection.php');

if (isset($_POST['supplier_id'])) {
    $supplierId = $_POST['supplier_id'];
    try {
        $query = "DELETE FROM suppliers_table WHERE supplier_id = :id";
        $statement = $connection->prepare($query);
        $statement->bindParam(':id', $supplierId);
        $statement->execute();

        echo json_encode(["res" => "success"]);
    } catch (PDOException $th) {
        echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
    }
} else {
    echo json_encode(['res' => 'error', 'message' => 'Supplier ID not provided.']);
}
?>