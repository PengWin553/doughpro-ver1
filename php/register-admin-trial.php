@ -0,0 +1,69 @@
<?php
include('connection.php');
session_start();

if (!isset($_SESSION["user_name"])) {
    header("location:../index.php");
}

$user_name = $_SESSION["user_name"];
$user_id =  $_SESSION["user_id"];
try {

    // Check if the admin credentials already exist
    $checkStmt = $connection->prepare("SELECT * FROM users_table WHERE user_email = :email");
    $checkStmt->bindParam(':email', $adminEmail);
    $checkStmt->execute();
    $adminExists = $checkStmt->fetch();

    if (!$adminExists) {
        // Define the admin's email
        $adminEmail = 'yuzuaihara@gmail.com';
        $role = 'Staff';
        $adminName = 'Yuzu Aihara';

        // Define the admin's password
        $adminPassword = 'meiaihara'; // Choose a secure password for the admin
        $adminPasswordHashed = md5($adminPassword);

        // Generate a unique salt for the admin
        $adminSalt = bin2hex(random_bytes(16)); // Generate a 16-byte (128-bit) random salt

        // Combine the salt with the admin's password
        $adminSaltedPassword = $adminPasswordHashed . $adminSalt;

        // Use bcrypt to hash the salted password
        $hashedPassword = $adminSaltedPassword;

        // Insert the admin's credentials into the database
        $stmt = $connection->prepare("INSERT INTO users_table (user_role, user_name, user_email, password_hash, salt) VALUES (:role, :name, :email, :password, :salt)");
        $role = 'Admin'; // Set the user role to Admin
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':name', $adminName);
        $stmt->bindParam(':email', $adminEmail);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':salt', $adminSalt);
        $stmt->execute();

        echo "Admin credentials inserted successfully!";
    } else {
        echo "Admin credentials already exist!";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Admin Credentials</title>
</head>
<body>
    <h2>Insert Admin Credentials</h2>
    <form method="post" >
        <button type="submit" name="insert_admin">Insert Admin Credentials</button>
    </form>
</body>
</html>