<?php
    include('connection.php');
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $supplierId = $_POST['supplier_id'];
        $supplierName = $_POST['supplier_name'];
        $supply = $_POST['supply'];
        try {
            // Check if supplier name already exists (excluding the current supplier)
            $checkQuery = "SELECT COUNT(*) as count FROM suppliers_table WHERE supplier_name = :suppliername AND supplier_id != :supplierid";
            $checkStatement = $connection->prepare($checkQuery);
            $checkStatement->bindParam(':suppliername', $supplierName);
            $checkStatement->bindParam(':supplierid', $supplierId);
            $checkStatement->execute();
            $row = $checkStatement->fetch(PDO::FETCH_ASSOC);

            if ($row['count'] > 0) {
                // Supplier name already exists
                echo json_encode(['res' => 'exists', 'message' => 'Supplier name already exists.']);
            } else {
                // Prepare the UPDATE query to update the supplier information in the database
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
            }
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