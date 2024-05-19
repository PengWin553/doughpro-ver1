<?php
include('connection.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Log POST data for debugging
    error_log(print_r($_POST, true));

    $invId = $_POST['inventory_id'];
    $invName = $_POST['inventory_name'];
    $invCat = $_POST['inventory_category'];
    $invDes = $_POST['inventory_description'];
    $invPrice = $_POST['inventory_price'];
    $invMinStock = $_POST['inventory_min_stock_level'];
    $invUnit = $_POST['inventory_unit'];

    try {
        // Prepare the UPDATE query to update the user information in the database
        $query = "UPDATE inventory_table
            SET inventory_name = :name,
                inventory_description = :desc,
                inventory_category = :cat,
                inventory_price = :price,
                min_stock_level = :min_stock,
                unit = :unit
            WHERE inventory_id = :id";
        $statement = $connection->prepare($query);
        // Bind parameters
        $statement->bindParam(':id', $invId);
        $statement->bindParam(':name', $invName);
        $statement->bindParam(':desc', $invDes);
        $statement->bindParam(':cat', $invCat);
        $statement->bindParam(':price', $invPrice);
        $statement->bindParam(':min_stock', $invMinStock); // Ensure this is bound
        $statement->bindParam(':unit', $invUnit);
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
