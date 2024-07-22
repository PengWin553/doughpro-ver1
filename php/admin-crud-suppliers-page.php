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
    <link rel="stylesheet" href="../css/search-and-filter-styles.css" />
    <link rel="stylesheet" href="../css/pagination-styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="../default-images/baguette-solid-24.png">
</head>

<body>

    <?php include('admin-sidebar.php'); ?>

    <section class="home">
        <div class="page-title-container">
            <div class="page-title-text"> <i class='bx bx-group icon page-title-icon'></i> <span>Suppliers</span> </div>
        </div>

        <!-- CREATE SUPPLIER MODAL -->
        <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addSupplierModalLabel">Add Supplier</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- CREATE supplier FORM -->
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="newSupplierForm">
                            <!-- suppliername -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="supplierName_field">Supplier Name</label>
                                <i class='bx bx-group icon icon_inp modal-form-icons' ></i>
                                <input placeholder="supplier name" title="Inpit title" name="add_supplier" type="text" class="input_field_inp" id="add_supplier" autocomplete="off">
                            </div>

                            <!-- supply -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="supplierName_field">Supply</label>
                                <i class='bx bx-tag-alt icon icon_inp modal-form-icons' ></i>
                                <input placeholder="supply" title="Inpit title" name="add_supply" type="text" class="input_field_inp" id="add_supply" autocomplete="off">
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="submit" class="sign-in_btn_inp" id="btn-add_supplier">
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- UPDATE USER MODAL -->
        <div class="modal fade" id="updateSupplierModal" tabindex="-1" aria-labelledby="updateSupplierModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updatesupplierModalLabel">Update Supplier</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- UPDATE supplier FORM -->
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="updateSupplierForm">
                            <input type="hidden" id="update_supplier_id">
                            <!-- suppliername -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="updateSupplierName_field">Supplier Name</label>
                                <i class='bx bx-user icon icon_inp modal-form-icons' ></i>
                                <input placeholder="supplier name" title="Update supplier" name="update_supplier" type="text" class="input_field_inp" id="update_supplier" autocomplete="off">
                            </div>

                            <!-- supply -->
                            <div class="input_container_inp">
                            <label class="input_label_inp" for="updatesupplierName_field">Supply</label>
                                <i class='bx bxs-baguette icon icon_inp modal-form-icons' ></i>
                                <input placeholder="supply" title="Update supplier" name="update_supply" type="text" class="input_field_inp" id="update_supply" autocomplete="off">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="submit" class="sign-in_btn_inp" id="btn-update_supplier">
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search input field -->
        <div class="search-filter-container">

            <!-- create btn -->
            <div class="btn-container categories-add-search">
            <button class="btn-crud btn-create" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                    </svg> Add
                </span>
            </button>
            </div>

            <!-- search -->
            <div class="InputContainer search-input-container">
                <input type="text" class="input" id="searchInput" placeholder="Search supplier" oninput="liveSearch()">
                
                <label for="input" class="labelforsearch">
                <svg viewBox="0 0 512 512" class="searchIcon"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
                </label>
            </div>
            <!-- <input type="text" id="searchInput" placeholder="Search categories..." oninput="liveSearch()"> -->
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="resultcontainer">
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Supply</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be dynamically inserted here by JavaScript -->
                    </tbody>
                </table>
            
            </div>
        </div>

        <!-- Pagination Controls -->
        <div id="pagination-controls" class="pagination-controls" >
            <!-- Pagination buttons will be dynamically inserted here by JavaScript -->
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/sidebar.js"></script>
    <script src="../js/sidebar-highlight.js"></script>
    <script src="../js/display-suppliers.js"></script>
    <script src="../js/add-supplier.js"></script>
    <script src="../js/update-supplier.js"></script>
    <script src="../js/delete-supplier.js"></script>

</body>

</html>