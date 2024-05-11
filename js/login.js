// LOGIN
$("#btn-login").click(function () {
    // Save the data from the modal inside variables
    var gmail = $("#login-email").val();
    var password = $("#login-password").val();
  
    if (gmail.trim().length > 0) {
        $.ajax({
            url: "php/login.php",
            method: "POST",
            data: {
                user_email: gmail,
                password_hash: password,
            },
            success: function (data) {
                var result = JSON.parse(data);
                if (result.res === "success") {
                    console.log('Successfully logged in.');
                    var userRole = result.user_role; // Store user role in a variable

                    // Redirect based on user role
                    if (userRole === "Admin") {
                        window.location.href = 'php/admin-dashboard.php'; // Redirect to admin dashboard
                    } else if (userRole === "Staff") {
                        window.location.href = 'php/staff-dashboard.php'; // Redirect to staff dashboard
                    }
                } else {
                    console.error('Login failed:', result.message);
                    alert("Login failed. Please check your credentials.");
                }
            },
            error: function (xhr, status, error) {
                console.error('Error occurred during login:', error);
                alert("An error occurred during login. Please try again later.");
            }
        });
    } else {
        alert("Error: Please enter your email.");
    }
});
