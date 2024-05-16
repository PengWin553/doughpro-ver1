// UPDATE FORM

// Populate the Update Modal with data
$(document).on("click", ".btn-update-category", function() {
    var categoryId = $(this).attr("id");
    var categoryName = $(this).data("category-name");

    // Set values in the update modal
    $("#update_category_id").val(categoryId);
    $("#update_category").val(categoryName);

    $("#updateCategoryModal").modal("show");
});

// Update the database
$("#btn-update_category").click(function() {
    console.log('The edit category button was pressed');
    var categoryId = $("#update_category_id").val();
    var categoryName = $("#update_category").val();

    var formData = new FormData();

    // Append form data
    formData.append('category_id', categoryId);
    formData.append('category_name', categoryName);

    if (categoryName.length > 0) {
        $.ajax({
            url: "admin-update-category.php",
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
            console.error("An error occurred while updating category info:", error);
            alert("An error occurred while updating category info. Please try again later.");
        });
    }
});
