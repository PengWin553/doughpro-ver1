<?php
include('connection.php');

// Check if the form data is set
if (isset($_POST['category_name'])) {
    $categoryName = ucfirst($_POST['category_name']);

    try {
        // Check if category name already exists
        $stmt = $connection->prepare("SELECT COUNT(*) as count FROM category_table WHERE category_name = :name");
        $stmt->bindParam(':name', $categoryName);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            echo json_encode(['res' => 'exists', 'msg' => 'Category name already exists.']);
        } else {
            // Insert the new category into the database
            $stmt = $connection->prepare("INSERT INTO category_table (category_name, created_at, updated_at) VALUES (:name, NOW(), NOW())");
            $stmt->bindParam(':name', $categoryName);
            $stmt->execute();
            echo json_encode(['res' => 'success']);
        }
    } catch (PDOException $e) {
        echo json_encode(['res' => 'error', 'msg' => $e->getMessage()]);
    }
}
?>
