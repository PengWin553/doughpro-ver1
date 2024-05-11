<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = $_POST['user_email']; // Correct variable name
    $password = $_POST['password_hash']; // Correct variable name

    try {
        $sql = "SELECT * FROM users_table WHERE user_email = :gmail AND password_hash = :password";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':gmail', $gmail); // Correct parameter name
        $stmt->bindParam(':password', $password); // Correct parameter name
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Matching input found

            // SET SESSION GLOBAL VARIABLES
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["user_name"] = $row["user_name"];
            $_SESSION["user_role"] = $row["user_role"];
            $_SESSION["last_login_date"] = $row["last_login_date"];

            // Update last login date
            $updateSql = "UPDATE users_table SET last_login_date = NOW() WHERE user_id = :user_id";
            $updateStmt = $connection->prepare($updateSql);
            $updateStmt->bindParam(':user_id', $_SESSION["user_id"]);
            $updateStmt->execute();
            
            echo json_encode(["res" => "success", "message" => "Login successful!", "user_name" => $row["user_name"], "user_role" => $row["user_role"]]);
        } else {
            // No matching input found
            echo json_encode(["res" => "error", "message" => "Username or password incorrect"]);
        }
    } catch (PDOException $th) {
        echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
    }
} else {
    echo json_encode(['res' => 'error', 'message' => 'Invalid request method']);
}
