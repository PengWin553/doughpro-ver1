// Populate the Update Modal with selected row data
$(document).on("click", ".btn-update-stock", function() {
    var id = $(this).attr("id");
    var inventoryName = $(this).data("inventory-name");
    var quantity = $(this).data("quantity");
    var expiry = $(this).data("expiry-date");

    // Set values in the update modal
    $("#update_stock_id").val(id);
    $("#update_quantity").val(quantity);
    $("#update_expiry_date").val(expiry);

    // Load inventory items and set the current inventory name
    loadInventoryItems(inventoryName);

    // Show the modal
    $("#updateStockModal").modal("show");
});

// Load inventory items into the modal select dropdown and set the current inventory item
function loadInventoryItems(selectedInventoryName) {
    fetch('admin-display-inv-in-modal.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(response => {
        if (response.res === 'success') {
            var inventorySelect = document.getElementById('update_stock_name');
            inventorySelect.innerHTML = ''; // Clear existing options

            response.inventory.forEach(function(item) {
                let option = document.createElement('option');
                option.value = item.inventory_id;
                option.textContent = item.inventory_name;
                if (item.inventory_name === selectedInventoryName) {
                    option.selected = true; // Set the current inventory item as selected
                }
                inventorySelect.appendChild(option);
            });
        } else {
            console.error("Error fetching inventory items: ", response.msg);
        }
    })
    .catch(error => {
        console.error("Fetch error: ", error);
    });
}

// Call this function to load inventory items when the document is ready or when needed
document.addEventListener("DOMContentLoaded", function() {
    loadInventoryItems();
});

// Update the stock in the database
$("#btn-update_stock").click(function() {
    var stockId = $("#update_stock_id").val();
    var stockName = $("#update_stock_name").val();
    var stockQuantity = $("#update_quantity").val();
    var stockExpiry = $("#update_expiry_date").val();

    var formData = new FormData();
    formData.append('stock_id', stockId);
    formData.append('stock_name', stockName);
    formData.append('stock_quantity', stockQuantity);
    formData.append('stock_expiry', stockExpiry);

    if (stockName.length > 0 && stockQuantity > 0 && stockExpiry.length > 0) {
        fetch("admin-update-stock.php", {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(result => {
            if (result.res == "success") {
                location.reload();
            } else {
                console.error("Error updating stock: ", result.msg);
            }
        })
        .catch(error => {
            console.error("An error occurred while updating stock info:", error);
            alert("An error occurred while updating stock info. Please try again later.");
        });
    }
});
