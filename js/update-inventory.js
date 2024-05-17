// load categories
function loadCategories() {
    $.ajax({
        url: 'display-categories.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.res === 'success') {
                var categorySelect = $('#update_inventory_category');
                categorySelect.empty(); // Clear existing options

                response.data.forEach(function(category) {
                    categorySelect.append('<option value="' + category.category_id + '">' + category.category_name + '</option>');
                });
            } else {
                console.error("Error fetching categories: ", response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error: ", textStatus, errorThrown);
        }
    });
}

// Call this function to load categories when the document is ready or when needed
$(document).ready(function() {
    loadCategories();
    loadData();
});


// Populate the Update Modal with data
$(document).on("click", ".btn-update-inventory", function() {
    // store em
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
        $.ajax({
            url: "admin-update-inventory.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
        }).done(function(data) {
            let result = JSON.parse(data);
            if (result.res == "success") {
                location.reload();
            }
        }).fail(function(xhr, status, error) {
            console.error("An error occurred while updating inventory info:", error);
            alert("An error occurred while updating inventory info. Please try again later.");
        });
    }
});
