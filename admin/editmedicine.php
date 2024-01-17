<?php 
session_start();
error_reporting(0);
require('include/config.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Inventory Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="app sidebar-mini rtl">

    <!-- Navbar-->
    <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include 'include/sidebar.php'; ?>

    <main class="app-content">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h1 class="text-center">EDIT MEDICINE</h1>

                    <?php
                    if (isset($_GET['id'])) {
                        $medicineID = $_GET['id'];

                        // Fetch medicine data based on ID
                        $sql = "SELECT medicine.*, supplier.supplier_name 
                        FROM medicine 
                        JOIN supplier ON medicine.supplier_id = supplier.supplier_id 
                        WHERE medicine.medicine_id = '$medicineID'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            // Display a form for editing medicine data
                            echo '<form method="post" action="action/editmed.php" onsubmit="return confirm(\'Are you sure you want to update this medicine?\');">';
                            echo '<input type="hidden" name="medicine_id" value="' . $row['medicine_id'] . '">';
                            echo '<div class="form-group">';
                            echo '<label for="medicine_name">Medicine Name:</label>';
                            echo '<input type="text" class="form-control" id="medicine_name" name="medicine_name" value="' . $row['medicine_name'] . '" required>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<label for="medicine_desc">Medicine Description:</label>';
                            echo '<textarea class="form-control" id="medicine_desc" name="medicine_desc" required>' . $row['medicine_desc'] . '</textarea>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<label for="medicine_status">Medicine Status:</label>';
                            echo '<select class="form-control" id="medicine_status" name="medicine_status" required>';
                            echo '<option value="Active" ' . ($row['medicine_status'] == 'Active' ? 'selected' : '') . '>Active</option>';
                            echo '<option value="Inactive" ' . ($row['medicine_status'] == 'Inactive' ? 'selected' : '') . '>Inactive</option>';
                            echo '</select>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<label for="supplier">Supplier:</label>';
                            echo '<div class="input-group">';
echo '<input type="text" class="form-control" id="searchSupplier" autocomplete="off" placeholder="Search for a supplier" value="' . $row['supplier_name'] . '">';
                            echo '<div class="input-group-append">';
                            echo '<button class="btn btn-outline-secondary" type="button" id="clearSearch">';
                            echo '<i class="fa fa-times"></i>';
                            echo '</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="dropdown">';
                            echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                            echo 'Select a supplier';
                            echo '</button>';
                            echo '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="supplierDropdown">';
                            // Fetch all suppliers initially
                            $sqlSuppliers = "SELECT supplier_id, supplier_name FROM supplier WHERE supplier_status='Active'";
                            $resultSuppliers = $conn->query($sqlSuppliers);

                            while ($rowSupplier = $resultSuppliers->fetch_assoc()) {
                                echo '<div class="supplierOption" data-supplier-id="' . $rowSupplier['supplier_id'] . '">' . $rowSupplier['supplier_name'] . '</div>';
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '<input type="hidden" id="selectedSupplierId" name="supplier_id" value="' . $row['supplier_id'] . '"required>';
                            echo '</div>';
                            // You can add more fields as needed
                            echo '<div class="form-group">';
                            echo '<button type="submit" class="btn btn-primary">Update Medicine</button>&nbsp';
                            echo '<button type="reset" class="btn btn-secondary">Reset</button>';
                            echo '</div>';
                            echo '</form>';

                            echo '<a href="medicine.php" class="btn btn-secondary mt-3">Back to All Medicines</a>';
                        } else {
                            echo '<p class="text-center">Medicine not found.</p>';
                            echo '<a href="medicine.php" class="btn btn-secondary">Back to All Medicines</a>';
                        }
                    } else {
                        echo '<p class="text-center">Invalid request.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Essential javascripts for the application to work-->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="../js/plugins/pace.min.js"></script>

    <script>
$(document).ready(function () {
    // Fetch all suppliers initially
    fetchSuppliers('');

    // Your live search script goes here
    $('#searchSupplier').on('input', function () {
        var searchQuery = $(this).val();
        fetchSuppliers(searchQuery);
    });

    // Handle item selection from the dropdown
    $(document).on('click', '.supplierOption', function () {
        var supplierId = $(this).data('supplier-id');
        var supplierName = $(this).text();

        $('#selectedSupplierId').val(supplierId);
        $('#searchSupplier').val(supplierName);
        // Do not hide the dropdown
    });

    // Clear search input without hiding dropdown
    $('#clearSearch').on('click', function () {
        $('#searchSupplier').val('');
        $('#selectedSupplierId').val('');
        // Fetch all suppliers when search is cleared
        fetchSuppliers('');
    });

    // Function to fetch suppliers
    function fetchSuppliers(searchQuery) {
        $.ajax({
            type: 'POST',
            url: 'live_search_sup.php',
            data: { searchQuery: searchQuery },
            success: function (data) {
                // Update the supplier dropdown with the fetched data
                $('#supplierDropdown').html(data);
                // Show the dropdown regardless of the number of results
            }
        });
    }
});

    </script>
</body>
</html>
