document.getElementById('btn-login').addEventListener('click', async function(event) {
    event.preventDefault(); // Prevent default form submission

    const gmail = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    if (gmail.trim().length > 0) {
        try {
            const response = await fetch('php/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email: gmail, password: password })
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(errorText);
            }

            const result = await response.json();
            if (result.success) {
                console.log('Successfully logged in.');
                const userRole = result.user_role; // Store user role in a variable

                // Clear the stored active link
                localStorage.removeItem('activeLink');

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
        } catch (error) {
            console.error('Error occurred during login:', error);
            alert("An error occurred during login. Please try again later.");
        }
    } else {
        alert("Error: Please enter your email.");
    }
});
