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
                                <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="icon_inp">
                                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
                                    <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
                                </svg>
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
                                <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="icon_inp">
                                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
                                    <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
                                </svg>
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
    <!-- <script src="../js/display-users.js"></script>
    <script src="../js/register-users.js"></script>
    <script src="../js/update-users.js"></script>
    <script src="../js/delete-users.js"></script> -->

    <script src="../js/display-categories.js"></script>
    <script src="../js/add-category.js"></script>
    <script src="../js/update-category.js"></script>
    <script src="../js/delete-category.js"></script>

</body>

</html>