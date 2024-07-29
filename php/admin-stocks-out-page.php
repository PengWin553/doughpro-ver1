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
    <link rel="stylesheet" href="../css/pagination-styles.css" />
    <link rel="stylesheet" href="../css/search-and-filter-styles.css" />
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
            <div class="page-title-text"> <i class='bx bxs-door-open icon page-title-icon'></i> <span>Stocks Out</span> </div>
        </div>

        <!-- Use Stock Modal -->
        <div class="modal fade" id="useStockModal" tabindex="-1" aria-labelledby="useStockModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="useStockModalLabel">Use Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="useStockForm">
                            <input type="hidden" id="useStockId">

                            <div class="input_container_inp">
                                <label class="input_label_inp" for="useQuantity">Quantity Used</label>
                                <i class='bx bxs-circle-three-quarter icon icon_inp modal-form-icons'></i>
                                <input placeholder="Enter quantity" title="Input title" name="update_quantity" type="number" class="input_field_inp" id="useQuantity" autocomplete="off">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="button" class="sign-in_btn_inp" id="confirmUseStock">
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discard Stock Modal -->
        <div class="modal fade" id="discardStockModal" tabindex="-1" aria-labelledby="discardStockModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="discardStockModalLabel">Discard Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form_container_inp" style="width: 100%; padding: 0;" id="discardStockForm">
                            <input type="hidden" id="discardStockId">
                            <div class="input_container_inp">
                                <label class="input_label_inp" for="discardQuantity">Quantity to Discard</label>
                                <i class='bx bxs-circle-three-quarter icon icon_inp modal-form-icons'></i>
                                <input placeholder="Enter quantity" title="Input title" name="discard_quantity" type="number" class="input_field_inp" id="discardQuantity" autocomplete="off" readonly>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button title="Save" type="button" class="sign-in_btn_inp" id="confirmDiscardStock">
                            <span>Discard</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Search and Filter Section -->
        <div class="search-filter-container">
            <!-- search -->
            <div class="InputContainer search-input-container search-stock-style">
                <input type="text" class="input" id="searchStockOutName" placeholder="Search by name" />
                
                <label for="input" class="labelforsearch">
                <svg viewBox="0 0 512 512" class="searchIcon"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
                </label>
            </div>

            <!-- filter -->
            <div class="InputContainer">
                <select id="filterUsedSpoiled" class="input">
                    <option value="all">All</option>
                    <option value="used">Used</option>
                    <option value="expired">Expired</option>
                </select>
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
                            <th>Total Quantity</th>
                            <th>Remaining Quantity</th>
                            <th>Used</th>
                            <th>Spoiled</th>
                            <th>Discarded</th>
                            <th>Expiry Date</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Data will be dynamically inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination controls -->
        <div id="pagination-controls" class="pagination-controls"></div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/sidebar.js"></script>
    <script src="../js/sidebar-highlight.js"></script>
    <script src="../js/display-stocks-out.js"></script>
    <script src="../js/use-stock.js"></script>
</body>
</html>
