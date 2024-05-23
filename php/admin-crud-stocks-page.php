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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="../default-images/baguette-solid-24.png">

    <!-- jQuery and jQuery UI for autocomplete -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>

    <?php include('admin-sidebar.php'); ?>

    <section class="home">
        <div class="page-title-container">
            <div class="page-title-text"> <i class='bx bxs-objects-vertical-bottom icon page-title-icon'></i> <span>Stocks</span> </div>
        </div>

        <div class="btn-container">
            <button class="btn-crud btn-create" data-bs-toggle="modal" data-bs-target="#addStockModal">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                    </svg> Add
                </span>
            </button>
        </div>

        <!-- CREATE STOCK MODAL -->
        <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addStockModalLabel">Add Stock</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- CREATE Stock FORM -->
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="newStockForm">
                            <!-- name -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="Stockname_field">Item Name</label>
                                <i class='bx bx-tag-alt icon icon_inp modal-form-icons' ></i>
                                <select name="add_stock_name" id="add_stock_name" class="input_field_inp">
                                    <option value="">select item</option>
                                </select>
                            </div>

                            <!-- quantity -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="set_quantity">Quantity</label>
                                <i class='bx bxs-circle-three-quarter icon icon_inp modal-form-icons' ></i>
                                <input placeholder="enter quantity" title="Inpit title" name="set_quantity" type="number" class="input_field_inp" id="set_quantity" autocomplete="off">
                            </div>

                            <!-- expiry date -->
                            <div class="input_container_inp">
                            <label class="input_label_inp" for="set_expiry_date">Expiry Date</label>
                                <i class='bx bxs-hourglass-bottom icon icon_inp modal-form-icons' ></i>
                                <input placeholder="enter expiry date" title="Inpit title" name="set_expiry_date" type="date" class="input_field_inp" id="set_expiry_date" autocomplete="off">
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="submit" class="sign-in_btn_inp" id="btn-add_stock">
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- UPDATE STOCK MODAL -->
        <div class="modal fade" id="updateStockModal" tabindex="-1" aria-labelledby="updateStockModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateStockModalLabel">Update Stock</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- UPDATE Stock FORM -->
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="updateStockForm">
                            <!-- name -->
                            <input type="hidden" id="update_stock_id">
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="update_stock_name">Item Name</label>
                                <i class='bx bx-tag-alt icon icon_inp modal-form-icons'></i>
                                <select name="update_stock_name" id="update_stock_name" class="input_field_inp">
                                    <option value="">select item</option>
                                </select>
                            </div>

                            <!-- quantity -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="update_quantity">Quantity</label>
                                <i class='bx bxs-circle-three-quarter icon icon_inp modal-form-icons'></i>
                                <input placeholder="enter quantity" title="Input title" name="update_quantity" type="number" class="input_field_inp" id="update_quantity" autocomplete="off">
                            </div>

                            <!-- expiry date -->
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="update_expiry_date">Expiry Date</label>
                                <i class='bx bxs-hourglass-bottom icon icon_inp modal-form-icons'></i>
                                <input placeholder="enter expiry date" title="Input title" name="update_expiry_date" type="date" class="input_field_inp" id="update_expiry_date" autocomplete="off">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="submit" class="sign-in_btn_inp" id="btn-update_stock">
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
                            <th>Stock ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Expiry Date</th>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/sidebar.js"></script>
    <script src="../js/display-stocks.js"></script>
    <script src="../js/display-inv-in-modal.js"></script>
    <script src="../js/add-stock.js"></script>
    <script src="../js/update-stock.js"></script>
    <script src="../js/delete-stock.js"></script>
</body>
</html>
