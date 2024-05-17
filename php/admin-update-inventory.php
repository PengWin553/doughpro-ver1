<?php
include('connection.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $invId = $_POST['inventory_id'];
    $invName = $_POST['inventory_name'];
    $invCat = $_POST['inventory_category'];
    $invDes = $_POST['inventory_description'];
    $invPrice = $_POST['inventory_price'];
    $invMinStock = $_POST['inventory_min_stock_level'];

    try {
        // Prepare the UPDATE query to update the user information in the database
        $query = "UPDATE inventory_table
            SET inventory_name = :name,
                inventory_description = :desc,
                inventory_category = :cat,
                inventory_price = :price,
                min_stock_level = :min_stock
            WHERE inventory_id = :id";
        $statement = $connection->prepare($query);
        // Bind parameters
        $statement->bindParam(':id', $invId);
        $statement->bindParam(':name', $invName);
        $statement->bindParam(':desc', $invDes); // Corrected mapping
        $statement->bindParam(':cat', $invCat); // Corrected mapping
        $statement->bindParam(':price', $invPrice);
        $statement->bindParam(':min_stock', $invMinStock);
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
