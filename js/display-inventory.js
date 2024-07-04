function loadData() {
    // Initialize a new EventSource instance to connect to the SSE endpoint
    const eventSource = new EventSource("display-inventory.php");

    // Define the event handler for incoming messages
    eventSource.onmessage = function(event) {
        const result = JSON.parse(event.data); // Parse the JSON data from the server
        
        if (result.res === "success") {
            let tableBody = document.querySelector("table.content-table tbody");
            tableBody.innerHTML = ''; // Clear existing table data
            
            result.data.forEach(item => {
                // Check if current_stock is less than min_stock_level
                let rowClass = item.current_stock < item.min_stock_level ? 'low-stock' : '';

                // Create a new table row for each inventory item
                let tableRow = `
                    <tr class="${rowClass}">
                        <td>${item.inventory_id}</td>
                        <td>${item.inventory_name}</td>
                        <td>${item.category_name}</td>
                        <td>${item.inventory_description}</td>
                        <td>${item.unit}</td>
                        <td>${item.inventory_price}</td>
                        <td>${item.current_stock}</td>
                        <td>${item.min_stock_level}</td>
                        <td class="actions-buttons-container">
                            <button class="btn-update btn-update-delete btn-update-inventory" 
                                id="${item.inventory_id}" 
                                data-inventory-name="${item.inventory_name}" 
                                data-inventory-category="${item.inventory_category}" 
                                data-category-name="${item.category_name}"
                                data-inventory-description="${item.inventory_description}" 
                                data-inventory-price="${item.inventory_price}" 
                                data-min-stock-level="${item.min_stock_level}"
                                data-inventory-unit="${item.unit}"
                            >Edit</button>
                            <button class="btn-update-delete btn-delete btn-delete-inventory" id="${item.inventory_id}">Delete</button>
                        </td>
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', tableRow); // Add the new row to the table
            });
        } else {
            // Log an error message if the data load failed
            console.error("Failed to load inventory data:", result.message);
        }
    };

    // Define the event handler for errors
    eventSource.onerror = function(event) {
        // Log an error message and close the connection
        console.error("An error occurred while fetching inventory data via SSE:", event);
        eventSource.close();
    };
}

// Add an event listener to load data when the DOM content is fully loaded
document.addEventListener("DOMContentLoaded", function() {
    loadData(); // Call loadData to initiate the SSE connection
});
