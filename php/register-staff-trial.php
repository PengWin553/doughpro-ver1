<?php
include('connection.php');
session_start();

// Check if the user is logged in and has the "Admin" role
if (!isset($_SESSION["user_name"]) || $_SESSION["user_role"] !== 'Admin') {
    header("location:../index.php");
    exit();
}

$user_name = $_SESSION["user_name"];
$user_id = $_SESSION["user_id"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Define the staff's email
        $staffEmail = 'staff@example.com'; // Change to the actual staff email

        // Check if the staff credentials already exist
        $checkStmt = $connection->prepare("SELECT * FROM users_table WHERE user_email = :email");
        $checkStmt->bindParam(':email', $staffEmail);
        $checkStmt->execute();
        $staffExists = $checkStmt->fetch();

        if (!$staffExists) {
            $staffName = 'Staff Name'; // Change to the actual staff name
            $staffPassword = 'staffpassword'; // Choose a secure password for the staff
            $role = 'Staff';

            // Generate a unique salt for the staff
            $staffSalt = bin2hex(random_bytes(16)); // Generate a 16-byte (128-bit) random salt

            // Hash the password using md5
            $staffPasswordHashed = md5($staffPassword);

            // Combine the salt with the staff's hashed password
            $staffSaltedPassword = $staffPasswordHashed . $staffSalt;

            // Use bcrypt to hash the salted password
            $hashedPassword = $staffSaltedPassword;

            // Insert the staff's credentials into the database
            $stmt = $connection->prepare("INSERT INTO users_table (user_role, user_name, user_email, password_hash, salt) VALUES (:role, :name, :email, :password, :salt)");
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':name', $staffName);
            $stmt->bindParam(':email', $staffEmail);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':salt', $staffSalt);
            $stmt->execute();

            echo "Staff credentials inserted successfully!";
        } else {
            echo "Staff credentials already exist!";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Staff Credentials</title>
</head>
<body>
    <h2>Insert Staff Credentials</h2>
    <form method="post">
        <button type="submit" name="insert_staff">Insert Staff Credentials</button>
    </form>
</body>
</html>
