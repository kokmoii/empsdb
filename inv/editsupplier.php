<?php
require 'connection.php';

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Inventory Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main2.css">
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
                    <h1 class="text-center">EDIT SUPPLIER</h1>

                    <?php
                    if (isset($_GET['id'])) {
                        $supplierID = $_GET['id'];

                        // Fetch supplier data based on ID
                        $sql = "SELECT * FROM supplier WHERE supplier_id = '$supplierID'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            // Display a form for editing supplier data
                            echo '<form method="post" action="action/editsup.php" onsubmit="return confirm(\'Are you sure you want to update this supplier?\');">';
                            echo '<input type="hidden" name="supplier_id" value="' . $row['supplier_id'] . '">';
                            echo '<div class="form-group">';
                            echo '<label for="supplier_name">Supplier Name:</label>';
                            echo '<input type="text" class="form-control" id="supplier_name" name="supplier_name" value="' . $row['supplier_name'] . '" required>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<label for="supplier_phone">Supplier Phone:</label>';
                            echo '<input type="text" class="form-control" id="supplier_phone" name="supplier_phone" value="' . $row['supplier_phone'] . '" required>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<label for="supplier_email">Supplier Email:</label>';
                            echo '<input type="email" class="form-control" id="supplier_email" name="supplier_email" value="' . $row['supplier_email'] . '" required>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<label for="supplier_address">Supplier Address:</label>';
                            echo '<textarea class="form-control" id="supplier_address" name="supplier_address" required>' . $row['supplier_address'] . '</textarea>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<label for="supplier_status">Supplier Status:</label>';
                            echo '<select class="form-control" id="supplier_status" name="supplier_status" required>';
                            echo '<option value="Active" ' . ($row['supplier_status'] == 'Active' ? 'selected' : '') . '>Active</option>';
                            echo '<option value="Inactive" ' . ($row['supplier_status'] == 'Inactive' ? 'selected' : '') . '>Inactive</option>';
                            echo '</select>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<button type="submit" class="btn btn-primary">Update Supplier</button>&nbsp';
                            echo '<button type="reset" class="btn btn-secondary">Reset</button>';
                            echo '</div>';
                            echo '</form>';

                            echo '<a href="supplier.php" class="btn btn-secondary mt-3">Back to All Suppliers</a>';
                        } else {
                            echo '<p class="text-center">Supplier not found.</p>';
                            echo '<a href="supplier.php" class="btn btn-secondary">Back to All Suppliers</a>';
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
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
</body>
</html>
