<?php
    include('connection.php');

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $supplierId = $_POST['supplier_id'];
        $supplierName = $_POST['supplier_name'];
        $supply = $_POST['supply'];
        try {
            // Prepare the UPDATE query to update the user information in the database
            $query = "UPDATE suppliers_table SET supplier_name = :suppliername, supply = :supply WHERE supplier_id = :supplierid";
            $statement = $connection->prepare($query);
            // Bind parameters
            $statement->bindParam(':supplierid', $supplierId);
            $statement->bindParam(':suppliername', $supplierName);
            $statement->bindParam(':supply', $supply);
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
