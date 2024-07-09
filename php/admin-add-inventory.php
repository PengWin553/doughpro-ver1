<?php
include('connection.php');

// Check if the form data is set
if (isset($_POST['inventory_name'])) {
    $invName = $_POST['inventory_name'];
    $invCategory = $_POST['inventory_category'];
    $invDescription = $_POST['inventory_description'];
    $invPrice = $_POST['inventory_price'];
    $invStock = $_POST['inventory_stock'];
    $invUnit = strtoupper($_POST['inventory_unit']);

    try {
        // Check for duplicate inventory item
        $stmt = $connection->prepare("SELECT COUNT(*) FROM inventory_table WHERE inventory_name = :invName");
        $stmt->bindParam(':invName', $invName);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(['res' => 'exists', 'msg' => 'Inventory item already exists.']);
        } else {
            // Insert the new inventory data into the database
            $stmt = $connection->prepare("INSERT INTO inventory_table (
                inventory_name,
                inventory_description,
                inventory_category,
                inventory_price, 
                min_stock_level, 
                unit, 
                created_at, 
                updated_at)
            VALUES(
                :invName, 
                :invDescription, 
                :invCategory, 
                :invPrice, 
                :invStock, 
                :invUnit, 
                NOW(), 
                NOW())");
            $stmt->bindParam(':invName', $invName);
            $stmt->bindParam(':invDescription', $invDescription);
            $stmt->bindParam(':invCategory', $invCategory);
            $stmt->bindParam(':invPrice', $invPrice);
            $stmt->bindParam(':invStock', $invStock);
            $stmt->bindParam(':invUnit', $invUnit);
            $stmt->execute();
            echo json_encode(['res' => 'success']);
        }
    } catch(PDOException $e) {
        echo json_encode(['res' => 'error', 'msg' => $e->getMessage()]);
    }
}
?>
