<?php
include('connection.php');
session_start();

// Check if the user is logged in and has the "Admin" role
if (!isset($_SESSION["user_name"]) || $_SESSION["user_role"] !== 'Admin') {
    header("location:../index.php");
    exit();
}

// Check if the form data is set
if (isset($_POST['user_name']) && isset($_POST['user_role']) && isset($_POST['user_email'])) {
    $user_name = $_POST['user_name'];
    $user_role = $_POST['user_role'];
    $user_email = $_POST['user_email'];

    try {
        // Check if the user already exists
        $checkStmt = $connection->prepare("SELECT * FROM users_table WHERE user_email = :email");
        $checkStmt->bindParam(':email', $user_email);
        $checkStmt->execute();
        $userExists = $checkStmt->fetch();

        if (!$userExists) {
            // Define a default password for the new user (this should ideally be changed by the user later)
            $defaultPassword = 'doughProDefaultPass143'; // Choose a secure default password
            $defaultPasswordHashed = md5($defaultPassword);

            // Generate a unique salt for the new user
            $userSalt = bin2hex(random_bytes(16)); // Generate a 16-byte (128-bit) random salt

            // Combine the salt with the user's password
            $userSaltedPassword = $defaultPasswordHashed . $userSalt;

            // Use bcrypt to hash the salted password
            $hashedPassword = $userSaltedPassword;

            // Insert the new user's credentials into the database
            $stmt = $connection->prepare("INSERT INTO users_table (user_role, user_name, user_email, password_hash, salt) VALUES (:role, :name, :email, :password, :salt)");
            $stmt->bindParam(':role', $user_role);
            $stmt->bindParam(':name', $user_name);
            $stmt->bindParam(':email', $user_email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':salt', $userSalt);
            $stmt->execute();

            echo json_encode(['res' => 'success']);
        } else {
            echo json_encode(['res' => 'exists', 'msg' => 'User already exists!']);
        }
    } catch(PDOException $e) {
        echo json_encode(['res' => 'error', 'msg' => $e->getMessage()]);
    }
} else {
    echo json_encode(['res' => 'error', 'msg' => 'Invalid form data']);
}
?>
