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
            <div class="page-title-text"> <i class='bx bxs-baguette icon page-title-icon'></i> <span>Inventory</span> </div>
        </div>

        <div class="btn-container">
            <button class="btn-crud btn-create" data-bs-toggle="modal" data-bs-target="#addInventoryModal">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                    </svg> Add
                </span>
            </button>
        </div>

        <!-- CREATE ITEM MODAL -->
        <div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addInventoryModalLabel">Add Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- CREATE Inventory FORM -->
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="newInventoryForm">
                            <!-- name -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="Inventoryname_field">Item Name</label>
                                <i class='bx bx-tag-alt icon icon_inp modal-form-icons' ></i>
                                <input placeholder="enter item name" title="Inpit title" name="add_inventory_name" type="text" class="input_field_inp" id="add_inventory_name" autocomplete="off">
                            </div>

                            <!-- category -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="category_select">Category</label>
                                <i class='bx bx-category icon icon_inp modal-form-icons'></i>
                                <select name="category_select" id="add_category" class="input_field_inp">
                                    <option value="" selected disabled>select category</option>
                                    <!-- Options will be populated by JavaScript -->
                                </select>
                            </div>

                            <!-- description -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="inventory_description_field">Description</label>
                                <i class='bx bx-info-circle icon icon_inp modal-form-icons' ></i>
                                <input placeholder="enter description" title="Inpit title" name="add_inventory_description" type="text" class="input_field_inp" id="add_inventory_description" autocomplete="off">
                            </div>

                            <!-- price -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="inventory_price_field">Price</label>
                                <i class='bx bx-purchase-tag icon icon_inp modal-form-icons' ></i>
                                <input placeholder="enter price" title="Inpit title" name="add_inventory_price" type="number" class="input_field_inp" id="add_inventory_price" autocomplete="off">
                            </div>

                           <!-- min stock level -->
                            <div class="input_container_inp">
                                <i class='bx bx-down-arrow-alt icon_inp modal-form-icons' ></i>
                                <label class="input_label_inp" for="min_stock_level_field">Mininum Stock</label>
                                <input placeholder="enter mininum stock value" title="Input title" name="add_min_stock_level" type="text" class="input_field_inp" id="add_min_stock_level" autocomplete="off">
                            </div>

                            <!-- unit -->
                            <div class="input_container_inp">
                                <i class='bx bx-down-arrow-alt icon_inp modal-form-icons' ></i>
                                <label class="input_label_inp" for="min_stock_level_field">Unit</label>
                                <input placeholder="enter unit" title="Input title" name="add_inventory_unit" type="text" class="input_field_inp" id="add_inventory_unit" autocomplete="off">
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="submit" class="sign-in_btn_inp" id="btn-add_inventory">
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- UPDATE ITEM MODAL -->
        <div class="modal fade" id="updateInventoryModal" tabindex="-1" aria-labelledby="updateInventoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateInventoryModalLabel">Update Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="updateInventoryForm">
                            <!-- id -->
                            <input name="update_inventory_id" type="hidden" id="update_inventory_id">
                            <!-- name -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="update_inventory_name">Item Name</label>
                                <i class='bx bx-tag-alt icon icon_inp modal-form-icons' ></i>
                                <input placeholder="enter item name" title="Inpit title" name="update_inventory_name" type="text" class="input_field_inp" id="update_inventory_name" autocomplete="off">
                            </div>

                            <!-- category -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="update_inventory_category">Category</label>
                                <i class='bx bx-category icon icon_inp modal-form-icons'></i>
                                <select name="update_inventory_category" id="update_inventory_category" class="input_field_inp">
                                    <option value="" selected disabled>select category</option>
                                    <!-- Options will be populated by JavaScript -->
                                </select>
                            </div>

                            <!-- description -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="update_inventory_description">Description</label>
                                <i class='bx bx-info-circle icon icon_inp modal-form-icons' ></i>
                                <input placeholder="enter description" title="Inpit title" name="update_inventory_description" type="text" class="input_field_inp" id="update_inventory_description" autocomplete="off">
                            </div>

                            <!-- price -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="update_inventory_price">Price</label>
                                <i class='bx bx-purchase-tag icon icon_inp modal-form-icons' ></i>
                                <input placeholder="enter price" title="Inpit title" name="update_inventory_price" type="number" class="input_field_inp" id="update_inventory_price" autocomplete="off">
                            </div>

                            <!-- unit -->
                            <div class="input_container_inp">
                                <i class='bx bx-down-arrow-alt icon_inp modal-form-icons' ></i>
                                <label class="input_label_inp" for="update_unit">Unit</label>
                                <input placeholder="enter new unit" title="Input title" name="update_unit" type="text" class="input_field_inp" id="update_unit" autocomplete="off">
                            </div>

                           <!-- min stock level -->
                            <div class="input_container_inp">
                                <i class='bx bx-down-arrow-alt icon_inp modal-form-icons' ></i>
                                <label class="input_label_inp" for="update_min_stock_level">Mininum Stock</label>
                                <input placeholder="enter mininum stock value" title="Input title" name="update_min_stock_level" type="text" class="input_field_inp" id="update_min_stock_level" autocomplete="off">
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="submit" class="sign-in_btn_inp" id="btn-update_inventory">
                            <span>Save</span>
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
                            <th>Category</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Min. Stock Level</th>
                            <th>Unit</th>
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
    <script src="../js/display-inventory.js"></script>
    <script src="../js/display-cats-in-modal.js"></script>
    <script src="../js/add-inventory.js"></script>
    <script src="../js/update-inventory.js"></script>
    <script src="../js/delete-inventory.js"></script>

</body>

</html>