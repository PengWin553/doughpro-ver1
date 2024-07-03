function loadData() {
    // Initialize a new EventSource instance to connect to the SSE endpoint
    const eventSource = new EventSource("display-categories.php");

    // Define the event handler for incoming messages
    eventSource.onmessage = function(event) {
        const result = JSON.parse(event.data); // Parse the JSON data from the server
        
        if (result.res === "success") {
            let tableBody = document.querySelector("table.content-table tbody");
            tableBody.innerHTML = ''; // Clear existing table data
            
            result.data.forEach(item => {
                // Create a new table row for each category
                let tableRow = `
                    <tr>
                        <td>${item.category_id}</td>
                        <td>${item.category_name}</td>
                        <td class="actions-buttons-container">
                            <button class="btn-update btn-update-delete btn-update-category" id="${item.category_id}" data-category-name="${item.category_name}">Edit</button>
                            <button class="btn-update-delete btn-delete btn-delete-category" id="${item.category_id}">Delete</button>
                        </td>
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', tableRow); // Add the new row to the table
            });
        } else {
            // Log an error message if the data load failed
            console.error("Failed to load category data:", result.message);
        }
    };

    // Define the event handler for errors
    eventSource.onerror = function(event) {
        // Log an error message and close the connection
        console.error("An error occurred while fetching category data via SSE:", event);
        eventSource.close();
    };
}

// Add an event listener to load data when the DOM content is fully loaded
document.addEventListener("DOMContentLoaded", function() {
    loadData(); // Call loadData to initiate the SSE connection
});
