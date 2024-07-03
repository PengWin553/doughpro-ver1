<?php
include ('connection.php');

// Set headers for SSE
header('Content-Type: text/event-stream'); // Indicates that the response is an SSE stream
header('Cache-Control: no-cache'); // Prevents caching of the response
header('Connection: keep-alive'); // Keeps the connection open

// Function to fetch the latest categories from the database
function fetchCategories($connection) {
    $query = "SELECT category_id, category_name FROM category_table ORDER BY category_id DESC"; // SQL query to fetch categories
    $statement = $connection->prepare($query); // Prepares the SQL statement
    $statement->execute(); // Executes the SQL statement
    return $statement->fetchAll(PDO::FETCH_ASSOC); // Fetches all the results as an associative array
}

// Retrieve the last event ID sent by the client (if any)
$lastEventId = isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? intval($_SERVER["HTTP_LAST_EVENT_ID"]) : 0;

// Enter an infinite loop to send updates periodically
while (true) {
    try {
        $categories = fetchCategories($connection); // Fetch the latest categories

        // Send the event ID and data to the client
        echo "id: " . ($lastEventId + 1) . "\n"; // Increment and send the event ID
        echo "data: " . json_encode(["res" => "success", "data" => $categories]) . "\n\n"; // Send the data as JSON
        ob_flush(); // Flush the output buffer
        flush(); // Flush the system output buffer
        
        $lastEventId++; // Increment the last event ID

        // Wait for 10 seconds before sending the next update
        sleep(10);
    } catch (PDOException $th) {
        // Handle any errors that occur while fetching data
        echo "data: " . json_encode(['res' => 'error', 'message' => $th->getMessage()]) . "\n\n";
        ob_flush(); // Flush the output buffer
        flush(); // Flush the system output buffer
        sleep(10); // Wait before retrying
    }
}
?>
