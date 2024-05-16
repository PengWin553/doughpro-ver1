$("#btn-add_user").click(function(event) {
    event.preventDefault(); // Prevent form from submitting normally

    // get the values from the form
    var userName = $("#add_username").val();
    var userRole = $("#add_role").val();
    var userEmail = $("#add_email").val();

    if (userName.trim().length > 0 && userRole && userEmail.trim().length > 0) {
        $.ajax({
            url: "admin-register-users.php",
            method: "POST",
            data: {
                user_name: userName,
                user_role: userRole,
                user_email: userEmail,
            },
            success: function(data) {
                var result = JSON.parse(data);
                if (result.res === "success") {
                    location.reload();
                } else if (result.res === "exists") {
                    alert(result.msg);
                } else {
                    alert(result.msg);
                }
            }
        });
    } else {
        alert("Please fill out all fields.");
    }
});
