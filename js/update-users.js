// UPDATE USERS

// Populate the Update Users Modal with data
$(document).on("click", ".btn-update", function() {
    var user_id = $(this).attr("id");
    var user_name = $(this).data("user-name");
    var user_role = $(this).data("user-role");
    var user_email = $(this).data("user-email");

    // Set values in the update modal
    $("#update_user_id").val(user_id);
    $("#update_username").val(user_name);
    $("#update_role").val(user_role);
    $("#update_email").val(user_email);

    $("#updateUserModal").modal("show");
});

// Update the database
$("#btn-edit_user").click(function() {
    console.log('The edit user button was pressed');
    var userId = $("#update_user_id").val();
    var userName = $("#update_username").val();
    var userRole = $("#update_role").val();
    var userEmail = $("#update_email").val();

    var formData = new FormData();

    // Append form data
    formData.append('user_id', userId);
    formData.append('user_name', userName);
    formData.append('user_role', userRole);
    formData.append('user_email', userEmail);

    if (userName.length > 0 && userRole.length > 0 && userEmail.length > 0) {
        $.ajax({
            url: "admin-update-users.php",
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
            console.error("An error occurred while updating user info:", error);
            alert("An error occurred while updating user info. Please try again later.");
        });
    }
});
