// UPDATE USERS

// populate the Update Users Modal with data
$(document).on("click", ".btn-update", function() {
    var user_id = $(this).attr("id");
    var user_name = $(this).data("user-name");
    var user_role = $(this).data("user-role");
    var user_email = $(this).data("user-email");

    // // Set values in the update modal
    $("#update_user_id").val(user_id);
    $("#update_username").val(user_name);
    $("#update_role").val(user_role);
    $("#update_email").val(user_email);

    $("#updateUserModal").modal("show");
});

// update the database
$("#btnUpdateProduct").click(function() {
    var productId = $("#updateProductId").val();
    var productName = $("#updateProductName").val();
    var productCategory = $("#updateProductCategory").val();
    var productQuantity = $("#updateProductQuantity").val();

    var formData = new FormData();
    var picture = $("#updatePicture")[0].files[0];

    // Append form data
    formData.append('id', productId);
    formData.append('name', productName);
    formData.append('category', productCategory);
    formData.append('quantity', productQuantity);

    // Append picture
    formData.append('picture', picture);

    if (productName.length > 0 && productCategory.length > 0 && productQuantity.length > 0) {
        $.ajax({
            url: "products.update.php",
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
            console.error("An error occurred while updating product:", error);
            alert("An error occurred while updating product. Please try again later.");
        });
    }
});