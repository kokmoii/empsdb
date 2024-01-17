<?php 
session_start();
error_reporting(0);
require('include/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Equipment</title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        main {
            padding: 20px;
        }
        h2 {
            color: #009688;
        }
        form {
            max-width: 400px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form input,
        form textarea,
        form select {
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="app sidebar-mini rtl">

    <!-- Navbar-->
    <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include 'include/sidebar.php'; ?>

    <main class="app-content">
        <a href="equipment.php" class="btn btn-info">Back</a>
        <content>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h2 class="text-center mb-4">ADD EQUIPMENT</h2>
                        <form method="post" action="action/addequip.php" onsubmit="return confirm('Are you sure you want to add this equipment?')">
                            <div class="form-group">
                                <label for="equipmentName">Equipment Name:</label>
                                <input type="text" class="form-control" id="equipmentName" name="equipment_name" required>
                            </div>
                            <div class="form-group">
                                <label for="equipmentDesc">Equipment Description:</label>
                                <textarea class="form-control" id="equipmentDesc" name="equipment_desc" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="supplier">Supplier:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchSupplier" autocomplete="off" placeholder="Search for a supplier" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Select a supplier
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="supplierDropdown">
                                        <!-- Supplier options will be dynamically added here -->
                                    </div>
                                </div>
                                <input type="hidden" id="selectedSupplierId" name="supplier_id" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Add Equipment</button>
                        </form>
                    </div>
                </div>
            </div>
        </content>
    </main>

 <!-- Bootstrap JS and other required scripts -->
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="../js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>

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


