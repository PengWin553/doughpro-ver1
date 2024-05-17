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
    <link rel="stylesheet" href="../css/form-styles.css" />
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/button-styles.css" />
    <link rel="stylesheet" href="../css/table-styles.css" />
    <link rel="stylesheet" href="../css/page-title-styles.css" />
    <link rel="stylesheet" href="../css/page-title-styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="../default-images/baguette-solid-24.png">
</head>

<body>

    <?php include('admin-sidebar.php'); ?>

    <section class="home">
        <div class="page-title-container">
            <div class="page-title-text"> <i class='bx bx-category-alt icon page-title-icon'></i> <span>Categories</span> </div>
        </div>

        <div class="btn-container">
            <button class="btn-crud btn-create" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                    </svg> Add
                </span>
            </button>
        </div>

        <!-- CREATE USER MODAL -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addCategoryModalLabel">Add Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- CREATE CATEGORY FORM -->
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="newUserForm">
                            <!-- categoryname -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="categoryName_field">Category Name</label>
                                <i class='bx bx-category-alt icon icon_inp modal-form-icons' ></i>
                                <input placeholder="category name" title="Inpit title" name="add_category" type="text" class="input_field_inp" id="add_category" autocomplete="off">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="submit" class="sign-in_btn_inp" id="btn-add_category">
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- UPDATE USER MODAL -->
        <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateCategoryModalLabel">Update Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- UPDATE CATEGORY FORM -->
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="updateCategoryForm">
                            <input type="hidden" id="update_category_id">
                            <!-- categoryname -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="updateCategoryName_field">Category Name</label>
                                <i class='bx bx-category-alt icon icon_inp modal-form-icons' ></i>
                                <input placeholder="category name" title="Update Category" name="update_category" type="text" class="input_field_inp" id="update_category" autocomplete="off">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="submit" class="sign-in_btn_inp" id="btn-update_category">
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
         

        <!-- Table -->
        <div class="table-container">
            <div class="resultcontainer">
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Data will be dynamically inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/sidebar.js"></script>
    <script src="../js/display-categories.js"></script>
    <script src="../js/add-category.js"></script>
    <script src="../js/update-category.js"></script>
    <script src="../js/delete-category.js"></script>

</body>

</html>