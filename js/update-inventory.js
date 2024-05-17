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
    $("#update_inventory_category").val(invCategory);
    $("#update_inventory_description").val(invDescription);
    $("#update_inventory_price").val(invPrice);
    $("#update_min_stock_level").val(invStock);

    // Set the selected category option
    $("#update_inventory_category").val(invCategory);

    $("#updateInventoryModal").modal("show");
});

// // Update the database
// $("#btn-update_category").click(function() {
//     console.log('The edit category button was pressed');
//     var categoryId = $("#update_category_id").val();
//     var categoryName = $("#update_category").val();

//     var formData = new FormData();

//     // Append form data
//     formData.append('category_id', categoryId);
//     formData.append('category_name', categoryName);

//     if (categoryName.length > 0) {
//         $.ajax({
//             url: "admin-update-category.php",
//             type: "POST",
//             data: formData,
//             contentType: false,
//             processData: false,
//         }).done(function(data) {
//             let result = JSON.parse(data);
//             if (result.res == "success") {
//                 location.reload();
//             }
//         }).fail(function(xhr, status, error) {
//             console.error("An error occurred while updating category info:", error);
//             alert("An error occurred while updating category info. Please try again later.");
//         });
//     }
// });
