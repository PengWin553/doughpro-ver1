<?php
include ('connection.php');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 7;
$offset = ($page - 1) * $limit;

try {
    $query = "SELECT user_id, user_role, user_name, user_email, last_login_date FROM users_table ORDER BY user_id DESC LIMIT :limit OFFSET :offset";
    $statement = $connection->prepare($query);
    $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
    $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $countQuery = "SELECT COUNT(*) as total FROM users_table";
    $countStatement = $connection->prepare($countQuery);
    $countStatement->execute();
    $total = $countStatement->fetch(PDO::FETCH_ASSOC)['total'];

    echo json_encode(["res" => "success", "data" => $result, "total" => $total, "page" => $page, "limit" => $limit]);
} catch (PDOException $th) {
    echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
}
?>
