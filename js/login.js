$("#btn-login").click(function(event) {
    var gmail = $("#login-email").val();
    var password = $("#login-password").val();

    if (gmail.trim().length > 0) {
        fetch("php/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                user_email: gmail,
                password_hash: password,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.res === "success") {
                console.log('Successfully logged in.');
                var userRole = data.user_role; // Store user role in a variable

                // Redirect based on user role
                if (userRole === "Admin") {
                    window.location.href = 'php/admin-dashboard.php'; // Redirect to admin dashboard
                } else if (userRole === "Staff") {
                    window.location.href = 'php/staff-dashboard.php'; // Redirect to staff dashboard
                }
            } else {
                console.error('Login failed:', data.message);
                alert("Login failed. Please check your credentials.");
            }
        })
        .catch(error => {
            console.error('Error occurred during login:', error);
            alert("An error occurred during login. Please try again later.");
        });
    } else {
        alert("Error: Please enter your email.");
    }
});
