$('#btn-add_user').click(function(event) {
    event.preventDefault(); // Prevent form from submitting normally

    // get the values from the form
    var userName = $("#add_username").val();
    var userRole = $("#add_role").val();
    var userEmail = $("#add_email").val();

    if (userName.trim().length > 0 && userRole && userEmail.trim().length > 0) {
        // Prepare the form data to be sent
        var formData = new URLSearchParams();
        formData.append('user_name', userName);
        formData.append('user_role', userRole);
        formData.append('user_email', userEmail);

        fetch("admin-register-users.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData.toString()
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
            } else if (result.res === "exists") {
                alert(result.msg);
            } else {
                alert(result.msg);
            }
        })
        .catch(error => {
            console.error("An error occurred while registering the user:", error);
            alert("An error occurred while registering the user. Please try again later.");
        });
    } else {
        alert("Please fill out all fields.");
    }
});
