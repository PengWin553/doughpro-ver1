<?php
include('connection.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = $_POST['category_id'];
    $categoryName = $_POST['category_name'];

    try {
        // Check if category name already exists (excluding the current category being updated)
        $stmt = $connection->prepare("SELECT COUNT(*) as count FROM category_table WHERE category_name = :name AND category_id != :id");
        $stmt->bindParam(':name', $categoryName);
        $stmt->bindParam(':id', $categoryId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            echo json_encode(['res' => 'exists', 'msg' => 'Category name already exists.']);
        } else {
            // Prepare the UPDATE query to update the category information in the database
            $query = "UPDATE category_table SET category_name = :name, updated_at = NOW() WHERE category_id = :id";
            $statement = $connection->prepare($query);
            // Bind parameters
            $statement->bindParam(':name', $categoryName);
            $statement->bindParam(':id', $categoryId);
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
