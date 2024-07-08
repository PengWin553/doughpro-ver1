<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connection.php');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

// Check if email and password are provided
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit();
}

try {
    // Retrieve the user from the database
    $stmt = $connection->prepare("SELECT user_id, user_name, user_role, user_email, password_hash, last_login_date FROM users_table WHERE user_email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password
    if ($user && password_verify($password, $user['password_hash'])) {
        session_start(); // Start the session

        // SET SESSION GLOBAL VARIABLES
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["user_name"] = $user["user_name"];
        $_SESSION["user_role"] = $user["user_role"];
        $_SESSION["user_email"] = $user["user_email"];
        $_SESSION["last_login_date"] = $user["last_login_date"];

        // Update last login date
        $updateSql = "UPDATE users_table SET last_login_date = NOW() WHERE user_id = :user_id";
        $updateStmt = $connection->prepare($updateSql);
        $updateStmt->bindParam(':user_id', $_SESSION["user_id"]);
        $updateStmt->execute();

        echo json_encode(["success" => true, "message" => "Login successful!", "user_name" => $user["user_name"], "user_role" => $user["user_role"]]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

// Close the connection
$connection = null;
?>
