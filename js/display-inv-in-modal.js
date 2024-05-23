$(document).ready(function() {
    // Fetch the inventory items and populate the select dropdown
    fetch("admin-display-inv-in-modal.php")
        .then(response => response.json())
        .then(data => {
            if (data.res === "success") {
                var inventorySelect = $("#add_stock_name");
                data.inventory.forEach(function(item) {
                    inventorySelect.append(new Option(item.inventory_name, item.inventory_id));
                });
            } else {
                alert("Failed to load inventory items");
            }
        })
        .catch(error => {
            console.error('Error occurred while fetching inventory items:', error);
            alert("An error occurred. Please try again later.");
        });
});