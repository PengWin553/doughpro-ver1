// LOGIN
$("#btn-login").click(function () {
    var gmail = $("#login-email").val();
    var password = $("#login-password").val();
  
    if (gmail.trim().length > 0 && password.trim().length > 0) {
        // Hash the password client-side (for demonstration purposes; typically done server-side)
        var passwordHash = md5(password);

        $.ajax({
            url: "php/login2.php",
            method: "POST",
            data: {
                user_email: gmail,
                password_hash: passwordHash,
            },
            success: function (data) {
                var result = JSON.parse(data);
                if (result.res === "success") {
                    var userName = result.user_name;
                    var userEmail = result.user_email;

                    $.ajax({
                        url: "php/send-verification-code.php",
                        method: "POST",
                        data: {
                            user_name: userName,
                            user_email: userEmail,
                        },
                        success: function (data){
                            var result = JSON.parse(data);

                            if(result.res === "success"){
                                var userRole = result.user_role;
                                if (userRole === "Admin") {
                                    window.location.href = 'php/admin-dashboard.php';
                                } else if (userRole === "Staff") {
                                    window.location.href = 'php/staff-dashboard.php';
                                }
                            }
                        }
                    });
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
        alert("Error: Please enter your email and password.");
    }
});
