<?php
include('connection.php');
session_start();

// Check if the user is logged in and has the "Admin" role
if (!isset($_SESSION["user_name"]) || $_SESSION["user_role"] !== 'Admin') {
    header("location:../index.php");
    exit();
}

$user_name = $_SESSION["user_name"];
$user_id = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoughPro</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/button-styles.css" />
    <link rel="stylesheet" href="../css/table-styles.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="../default-images/baguette-solid-24.png">
</head>
<body>

    <?php include('admin-sidebar.php'); ?>

    <section class="home">
        <div class="text">Users</div>

        <div class="btn-container">
            <button class="btn-crud btn-create">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path></svg> Add User
                </span>
            </button>
        </div>
       

        <!-- Table -->
        <div class="table-container">
            <table class="content-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Admin</td>
                        <td>Yuu Koito</td>
                        <td>arianatorswiftyfangurl@gmail.com</td>
                        <td>May 5, 2025 8:00AM</td>
                        <td class="actions-buttons-container">
                            <button class="btn-update-delete">Edit</button>
                            <button class="btn-update-delete">Delete</button>
                        </td>
                    </tr>
                    <tr class="active-row">
                        <td>1</td>
                        <td>Admin</td>
                        <td>Yuu Koito</td>
                        <td>arianatorswiftyfangurl@gmail.com</td>
                        <td>May 5, 2025 8:00AM</td>
                        <td class="actions-buttons-container"></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Admin</td>
                        <td>Yuu Koito</td>
                        <td>arianatorswiftyfangurl@gmail.com</td>
                        <td>May 5, 2025 8:00AM</td>
                        <td class="actions-buttons-container"></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Admin</td>
                        <td>Yuu Koito</td>
                        <td>arianatorswiftyfangurl@gmail.com</td>
                        <td>May 5, 2025 8:00AM</td>
                        <td class="actions-buttons-container"></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Admin</td>
                        <td>Yuu Koito</td>
                        <td>arianatorswiftyfangurl@gmail.com</td>
                        <td>May 5, 2025 8:00AM</td>
                        <td class="actions-buttons-container"></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Admin</td>
                        <td>Yuu Koito</td>
                        <td>arianatorswiftyfangurl@gmail.com</td>
                        <td>May 5, 2025 8:00AM</td>
                        <td class="actions-buttons-container"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </section>

    <script src="../js/admin-dashboard.js"></script>
</body>
</html>
