<?php
include('connection.php');

// Check if the form data is set
if (isset($_POST['supplier_name'])) {
    $supplierName = $_POST['supplier_name'];
    $supply = $_POST['supply'];

    try {
        // Check if supplier name already exists
        $stmt = $connection->prepare("SELECT COUNT(*) as count FROM suppliers_table WHERE supplier_name = :supplier_name");
        $stmt->bindParam(':supplier_name', $supplierName);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            echo json_encode(['res' => 'exists', 'msg' => 'Supplier name already exists.']);
        } else {
            // Insert the new supplier into the database
            $stmt = $connection->prepare("INSERT INTO suppliers_table (supplier_name, supply, created_at, updated_at) VALUES (:supplier_name, :supply, NOW(), NOW())");
            $stmt->bindParam(':supplier_name', $supplierName);
            $stmt->bindParam(':supply', $supply);
            $stmt->execute();
            echo json_encode(['res' => 'success']);
        }
    } catch (PDOException $e) {
        echo json_encode(['res' => 'error', 'msg' => $e->getMessage()]);
    }
}
?>
