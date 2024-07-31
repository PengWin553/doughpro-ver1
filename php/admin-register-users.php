<?php
    include('connection.php');

    // Check if the form data is set
    if (isset($_POST['user_name']) && isset($_POST['user_role']) && isset($_POST['user_email'])) {
        $user_name = ucwords($_POST['user_name']);
        $user_role = $_POST['user_role'];
        $user_email = strtolower($_POST['user_email']);

        try {
            // Check if the user already exists
            $checkStmt = $connection->prepare("SELECT * FROM users_table WHERE user_email = :email");
            $checkStmt->bindParam(':email', $user_email);
            $checkStmt->execute();
            $userExists = $checkStmt->fetch();

            if (!$userExists) {
                // Define a default password for the new user (this should ideally be changed by the user later)
                $defaultPassword = 'doughProDefaultPass143'; // Choose a secure default password
                
                // Use password_hash to hash the default password
                $hashedPassword = password_hash($defaultPassword, PASSWORD_BCRYPT);

                // Insert the new user's credentials into the database
                $stmt = $connection->prepare("INSERT INTO users_table (user_role, user_name, user_email, password_hash, created_at, updated_at) VALUES (:role, :name, :email, :password, NOW(), NOW())");
                $stmt->bindParam(':role', $user_role);
                $stmt->bindParam(':name', $user_name);
                $stmt->bindParam(':email', $user_email);
                $stmt->bindParam(':password', $hashedPassword);
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
