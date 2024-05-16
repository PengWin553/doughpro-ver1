<?php
    include('connection.php');

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $categoryId = $_POST['category_id'];
        $categoryName = $_POST['category_name'];
        try {
            // Prepare the UPDATE query to update the user information in the database
            $query = "UPDATE category_table SET category_name = :name WHERE category_id = :id";
            $statement = $connection->prepare($query);
            // Bind parameters
            $statement->bindParam(':name', $categoryName);
            $statement->bindParam(':id', $categoryId);
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
