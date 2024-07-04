<?php
include('connection.php');

// Set headers for SSE
header('Content-Type: text/event-stream'); // Indicates that the response is an SSE stream
header('Cache-Control: no-cache'); // Prevents caching of the response
header('Connection: keep-alive'); // Keeps the connection open

// Function to fetch the latest inventory
function fetchInventory($connection) {
    $query = "
        SELECT 
            inventory_table.inventory_id, 
            inventory_table.inventory_name, 
            inventory_table.inventory_description, 
            inventory_table.inventory_category, 
            inventory_table.inventory_price, 
            IFNULL(SUM(stocks_table.quantity), 0) AS current_stock, 
            inventory_table.min_stock_level, 
            inventory_table.unit, 
            category_table.category_name 
        FROM 
            inventory_table 
        JOIN 
            category_table 
        ON 
            inventory_table.inventory_category = category_table.category_id 
        LEFT JOIN 
            stocks_table 
        ON 
            inventory_table.inventory_id = stocks_table.inventory_id 
        GROUP BY 
            inventory_table.inventory_id,
            inventory_table.inventory_name,
            inventory_table.inventory_description,
            inventory_table.inventory_category,
            inventory_table.inventory_price,
            inventory_table.min_stock_level,
            inventory_table.unit,
            category_table.category_name
        ORDER BY 
            inventory_table.inventory_id DESC";
    
    $statement = $connection->prepare($query); // Prepares the SQL statement
    $statement->execute(); // Executes the SQL statement
    return $statement->fetchAll(PDO::FETCH_ASSOC); // Fetches all the results as an associative array
}

$lastEventId = isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? intval($_SERVER["HTTP_LAST_EVENT_ID"]) : 0; // Retrieve the last event ID sent by the client (if any)

// Enter an infinite loop to send updates periodically
while (true) {
    try {
        $inventory = fetchInventory($connection); // Fetch the latest inventory

        // Send the event ID and data to the client
        echo "id: " . ($lastEventId + 1) . "\n"; // Increment and send the event ID
        echo "data: " . json_encode(["res" => "success", "data" => $inventory]) . "\n\n"; // Send the data as JSON
        ob_flush(); // Flush the output buffer
        flush(); // Flush the system output buffer
        
        $lastEventId++; // Increment the last event ID

        // Wait for 10 seconds before sending the next update
        sleep(10);
    } catch (PDOException $e) {
        // Handle any errors that occur while fetching data
        echo "data: " . json_encode(['res' => 'error', 'message' => $e->getMessage()]) . "\n\n";
        ob_flush(); // Flush the output buffer
        flush(); // Flush the system output buffer
        sleep(10); // Wait before retrying
    }
}
?>
