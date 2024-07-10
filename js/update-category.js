// Populate the Update Modal with selected row data
$(document).on("click", ".btn-update-category", function() {
    var categoryId = $(this).attr("id");
    var categoryName = $(this).data("category-name");

    // Set values in the update modal
    $("#update_category_id").val(categoryId);
    $("#update_category").val(categoryName);

    // Show the modal
    $("#updateCategoryModal").modal("show");
});

// Update the database
$("#btn-update_category").click(function() {
    console.log('The edit category button was pressed');

    // get data from form
    var categoryId = $("#update_category_id").val();
    var categoryName = $("#update_category").val();

    var formData = new FormData();
    formData.append('category_id', categoryId);
    formData.append('category_name', categoryName);

    if (categoryName.length > 0) {
        fetch("admin-update-category.php", {
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
            } else if (result.res == "exists" || result.res == "error") {
                alert(result.msg);
            }
        })
        .catch(error => {
            console.error("An error occurred while updating category info:", error);
            alert("An error occurred while updating category info. Please try again later.");
        });
    }
});
