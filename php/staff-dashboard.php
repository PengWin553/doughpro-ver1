<?php
    include('connection.php');
    session_start();

    // Check if the user is logged in and has the "Staff" role
    if (!isset($_SESSION["user_name"]) || $_SESSION["user_role"] !== 'Staff') {
        header("location:../index.php");
        exit();
    }

    $user_name = $_SESSION["user_name"];
    $user_id =  $_SESSION["user_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoughPro</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="../default-images/baguette-solid-24.png">
</head>
<body>
   
    <?php include("staff-sidebar.php") ?>

    <section class="home">
        <div class="text">Staff Dashboard</div>
    </section>

    <script src="../js/sidebar.js"></script>

</body>
</html>