<?php
    include('connection.php');

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = $_POST['user_id'];
        $userName = $_POST['user_name'];
        $userRole = $_POST['user_role'];
        $userEmail = $_POST['user_email'];
        try {
            // Prepare the UPDATE query to update the user information in the database
            $query = "UPDATE users_table SET user_role = :role, user_name = :name, user_email = :email WHERE user_id = :id";
            $statement = $connection->prepare($query);
            // Bind parameters
            $statement->bindParam(':role', $userRole);
            $statement->bindParam(':name', $userName);
            $statement->bindParam(':email', $userEmail);
            $statement->bindParam(':id', $userId);
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
