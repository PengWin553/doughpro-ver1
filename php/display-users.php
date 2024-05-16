<?php
include ('connection.php');

try {
    $query = "SELECT user_id, user_role, user_name, user_email, last_login_date FROM users_table ORDER BY user_id DESC"; // Adjust the query according to your database structure
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["res" => "success", "data" => $result]);
} catch (PDOException $th) {
    echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
}
?>
