<?php
    include('connection.php');

    // Check if the form data is set
    if (isset($_POST['category_name'])) {
        $categoryName = $_POST['category_name'];

        try {
                // Insert the new user's credentials into the database
                $stmt = $connection->prepare("INSERT INTO category_table (category_name, created_at, updated_at) VALUES (:name, NOW(), NOW())");
                $stmt->bindParam(':name', $categoryName);
                $stmt->execute();
                echo json_encode(['res' => 'success']);
        } catch(PDOException $e) {
            echo json_encode(['res' => 'error', 'msg' => $e->getMessage()]);
        }
    }
?>
