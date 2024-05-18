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

$("#btn-edit_user").click(function() {
    console.log('The edit user button was pressed');

    // Get the updated data from the form
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
        fetch("admin-update-users.php", {
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
            if (result.res === "success") {
                location.reload();
            }
        })
        .catch(error => {
            console.error("An error occurred while updating user info:", error);
            alert("An error occurred while updating user info. Please try again later.");
        });
    }
});