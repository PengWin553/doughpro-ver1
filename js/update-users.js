// UPDATE USERS
$(document).on("click", ".btn-update", function() {
    var user_id = $(this).attr("id");
    var user_name = $(this).data("user_name");
    var user_role = $(this).data("user_role");
    var user_email = $(this).data("user_email");
    // var currentPictureUrl = $(this).closest(".card").find(".card-img-top").attr("src");

    // // Set values in the update modal
    $("#update_user_id").val(user_id);
    $("#udpate_username").val(user_name);
    $("#update_role").val(user_role);
    $("#update_email").val(user_email);

    $("#updateUserModal").modal("show");
});
