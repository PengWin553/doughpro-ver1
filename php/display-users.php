<?php
include ('connection.php');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 8;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

try {
    $query = "SELECT user_id, user_role, user_name, user_email, last_login_date FROM users_table WHERE user_name LIKE :search";
    
    if ($filter !== '') {
        $query .= " AND user_role = :filter";
    }
    
    $query .= " ORDER BY user_id DESC LIMIT :limit OFFSET :offset";
    
    $statement = $connection->prepare($query);
    $searchParam = "%" . $search . "%";
    $statement->bindParam(':search', $searchParam, PDO::PARAM_STR);
    
    if ($filter !== '') {
        $statement->bindParam(':filter', $filter, PDO::PARAM_STR);
    }
    
    $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
    $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $countQuery = "SELECT COUNT(*) as total FROM users_table WHERE user_name LIKE :search";
    
    if ($filter !== '') {
        $countQuery .= " AND user_role = :filter";
    }

    $countStatement = $connection->prepare($countQuery);
    $countStatement->bindParam(':search', $searchParam, PDO::PARAM_STR);
    
    if ($filter !== '') {
        $countStatement->bindParam(':filter', $filter, PDO::PARAM_STR);
    }

    $countStatement->execute();
    $total = $countStatement->fetch(PDO::FETCH_ASSOC)['total'];

    echo json_encode(["res" => "success", "data" => $result, "total" => $total, "page" => $page, "limit" => $limit]);
} catch (PDOException $th) {
    echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
}
?>
