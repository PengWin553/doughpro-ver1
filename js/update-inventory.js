// Load categories on modal Update Inventory
function loadCategories() {
    fetch('display-categories.php', {
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
            var categorySelect = document.getElementById('update_inventory_category');
            categorySelect.innerHTML = ''; // Clear existing options

            response.data.forEach(function(category) {
                let option = document.createElement('option');
                option.value = category.category_id;
                option.textContent = category.category_name;
                categorySelect.appendChild(option);
            });
        } else {
            console.error("Error fetching categories: ", response.message);
        }
    })
    .catch(error => {
        console.error("Fetch error: ", error);
    });
}

// Call this function to load categories when the document is ready or when needed
document.addEventListener("DOMContentLoaded", function() {
    loadCategories();
    loadData();
});


// Populate the Update Modal with data
$(document).on("click", ".btn-update-inventory", function() {
        // store data
        var invId = $(this).attr("id");
        var invName = $(this).data("inventory-name");
        var invCategory = $(this).data("inventory-category");
        var invDescription = $(this).data("inventory-description");
        var invPrice = $(this).data("inventory-price");
        var invStock = $(this).data("min-stock-level");

        // Set values in the update modal
        $("#update_inventory_id").val(invId);
        $("#update_inventory_name").val(invName);
        $("#update_inventory_description").val(invDescription);
        $("#update_inventory_price").val(invPrice);
        $("#update_min_stock_level").val(invStock);

        // Set the selected category option
        $("#update_inventory_category").val(invCategory);

        // Show the modal
        $("#updateInventoryModal").modal("show");
});

// Update the database
$("#btn-update_inventory").click(function() {
    console.log('The edit inventory button was pressed');

    // get the updated data from the form
    var invId = $("#update_inventory_id").val();
    var invName = $("#update_inventory_name").val();
    var invCategory = $("#update_inventory_category").val();
    var invDescription = $("#update_inventory_description").val();
    var invPrice = $("#update_inventory_price").val();
    var invStock = $("#update_min_stock_level").val();

    var formData = new FormData();

    // Append form data
    formData.append('inventory_id', invId);
    formData.append('inventory_name', invName);
    formData.append('inventory_category', invCategory);
    formData.append('inventory_description', invDescription);
    formData.append('inventory_price', invPrice);
    formData.append('inventory_min_stock_level', invStock);

    if (invName.length > 0) {
        fetch("admin-update-inventory.php", {
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
            }
        })
        .catch(error => {
            console.error("An error occurred while updating inventory info:", error);
            alert("An error occurred while updating inventory info. Please try again later.");
        });
    }
});

