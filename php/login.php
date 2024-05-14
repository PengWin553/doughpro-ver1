<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = $_POST['user_email'];
    $password = $_POST['password_hash'];

    try {
        $sql = "SELECT user_id, user_name, user_role, user_email, password_hash, salt, last_login_date FROM users_table WHERE user_email = :gmail";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':gmail', $gmail);
        $stmt->execute();

        $rowResult = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rowResult) {
            $storedPassword = $rowResult["password_hash"];
            $salt = $rowResult["salt"];
            $userInputPasswordHashedSalted = md5($password) . $salt;

            if ($userInputPasswordHashedSalted === $storedPassword) {
                // Password is correct

                // Clear the previous session and start a new one
                session_unset();
                session_destroy();
                session_start();

                // SET SESSION GLOBAL VARIABLES
                $_SESSION["user_id"] = $rowResult["user_id"];
                $_SESSION["user_name"] = $rowResult["user_name"];
                $_SESSION["user_role"] = $rowResult["user_role"];
                $_SESSION["user_email"] = $rowResult["user_email"];
                $_SESSION["last_login_date"] = $rowResult["last_login_date"];

                // Update last login date
                $updateSql = "UPDATE users_table SET last_login_date = NOW() WHERE user_id = :user_id";
                $updateStmt = $connection->prepare($updateSql);
                $updateStmt->bindParam(':user_id', $_SESSION["user_id"]);
                $updateStmt->execute();

                echo json_encode(["res" => "success", "message" => "Login successful!", "user_name" => $rowResult["user_name"], "user_role" => $rowResult["user_role"]]);
            } else {
                // Password is incorrect
                echo json_encode(["res" => "error", "message" => "Username or password incorrect"]);
            }
        } else {
            // No user found with the given email
            echo json_encode(["res" => "error", "message" => "Username or password incorrect"]);
        }
    } catch (PDOException $th) {
        echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
    }
} else {
    echo json_encode(['res' => 'error', 'message' => 'Invalid request method']);
}
?>
