<?php
include('connection.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Log POST data for debugging
    error_log(print_r($_POST, true));

    $stockId = $_POST['stock_id'];
    $stockName = $_POST['stock_name'];
    $stockQuantity = $_POST['stock_quantity'];
    $stockExpiry = $_POST['stock_expiry'];

    $remainingStock = $stockQuantity;

    try {
        // Prepare the UPDATE query to update the stock information in the database
        $query = "UPDATE stocks_table
            SET inventory_id = :name,
                quantity = :quantity,
                remaining_quantity = :remaining_quantity,
                expiry_date = :expiry
            WHERE stock_id = :id";
        $statement = $connection->prepare($query);
        // Bind parameters
        $statement->bindParam(':id', $stockId);
        $statement->bindParam(':name', $stockName);
        $statement->bindParam(':quantity', $stockQuantity);
        $statement->bindParam(':remaining_quantity', $remainingStock);
        $statement->bindParam(':expiry', $stockExpiry);
        // Execute the query
        $statement->execute();

        // Return success response as JSON
        echo json_encode(["res" => "success"]);
    } catch (PDOException $th) {
        // Debugging output
        error_log("PDOException: " . $th->getMessage());
        // Return error response as JSON
        echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
    }
} else {
    // If the request method is not POST, return an error response
    echo json_encode(['res' => 'error', 'message' => 'Invalid request method']);
}
?>
