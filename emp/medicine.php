<?php 
session_start();
error_reporting(0);
require('include/config.php');
if(strlen( $_SESSION["Empid"])==0)
    {   
      header('location:index.php');
}
else{

// Pagination variables
$recordsPerPage = 10; // Adjust this value as needed
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier</title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body class="app sidebar-mini rtl">

    <!-- Navbar-->
    <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include 'include/sidebar.php'; ?>

    <main class="app-content">
    <a href="inventory.php" class="btn btn-secondary">Back to Inventory</a>
        <a href="addmedicine.php" class="btn btn-info">Add Medicine</a>
        <center><h1>MEDICINE</h1></center>
        <content>
            <div class="container mt-3">
                <center>
                    <?php
                    // Handle search query
                    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
                    $searchCondition = empty($searchKeyword) ? '' : " WHERE 
                        (m.medicine_name LIKE '%$searchKeyword%' OR m.medicine_desc LIKE '%$searchKeyword%' OR m.supplier_id LIKE '%$searchKeyword%' OR b.quantity_stock LIKE '%$searchKeyword%' OR b.price_punit LIKE '%$searchKeyword%' OR b.expiration_date LIKE '%$searchKeyword%' OR s.supplier_name LIKE '%$searchKeyword%' OR m.medicine_status LIKE '%$searchKeyword%')";
                    
                    $sql = "SELECT m.medicine_id, m.medicine_name, m.medicine_desc, m.supplier_id,
                        COALESCE(b.quantity_stock, 'Batch not selected') as quantity_stock,
                        COALESCE(b.price_punit, 'Batch not selected') as price_per_unit,
                        COALESCE(b.expiration_date, 'Batch not selected') as expiration_date, m.medicine_status, s.supplier_name
                        FROM medicine m
                        LEFT JOIN supplier s ON m.supplier_id = s.supplier_id
                        LEFT JOIN batch b ON m.medicine_id = b.medicine_id AND b.status = 'Used'" . $searchCondition;
                    
                    $result = $conn->query($sql);
                    ?>

                    <?php
                    if (!empty($searchKeyword)) {
                        echo '<a href="medicine.php" class="btn btn-secondary mt-3">Back to All Medicine</a>';
                    }
                    ?>
                </center>
            </div>
            <div class="container mt-3">
                <div class="table-responsive">
                    <?php

                                         // Pagination query
                $paginationSql = $paginationSql = "SELECT COUNT(*) as total FROM medicine m
                LEFT JOIN supplier s ON m.supplier_id = s.supplier_id
                LEFT JOIN batch b ON m.medicine_id = b.medicine_id AND b.status = 'Used'" . $searchCondition;
                $paginationResult = $conn->query($paginationSql);
                $totalRows = $paginationResult->fetch_assoc()['total'];
                $totalPages = ceil($totalRows / $recordsPerPage);

                                    // Display range of rows being shown
        $startRow = $offset + 1;
        $endRow = min($offset + $recordsPerPage, $totalRows);

        echo '<p>Displaying ' . $startRow . ' - ' . $endRow . ' out of ' . $totalRows . ' rows</p>';

                $sql .= " LIMIT $offset, $recordsPerPage";
                

                    if ($result->num_rows > 0) {
                        echo '<form method="get" action="medicine.php">';
                        echo '<div class="input-group mb-3">';
                        echo '<input type="text" class="form-control" name="search" placeholder="Search" value="' . $searchKeyword . '">';
                        echo '<div class="input-group-append">';
                        echo '<button class="btn btn-outline-secondary" type="submit">Search</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';

                        echo '<table class="table table-bordered table-striped">';
                        echo '<thead class="thead-dark">';
                        echo '<tr><th scope="col">No</th><th scope="col">Medicine Name</th><th scope="col">Description</th><th scope="col">Quantity</th><th scope="col">Price per unit(RM)</th><th scope="col">Expiration Date</th><th scope="col">Supplier Name</th><th scope="col">Status</th><th scope="col">Action</th><th scope="col">Batch</th></tr></thead>';
                        echo '<tbody>';

                        $rowNumber = $offset + 1;
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<th scope="row">' . $rowNumber . '</th>';
                            echo '<td>' . $row['medicine_name'] . '</td>';
                            echo '<td>' . $row['medicine_desc'] . '</td>';
                            echo '<td>' . $row['quantity_stock'] . '</td>';
                            echo '<td>' . $row['price_per_unit'] . '</td>';
                            echo '<td>' . $row['expiration_date'] . '</td>';
                            echo '<td>' . $row['supplier_name'] . '</td>';
                            echo '<td>' . $row['medicine_status'] . '</td>';
                            echo '<td><a href="editmedicine.php?id=' . $row['medicine_id'] . '" class="btn btn-primary">Edit</a></td>';
                            echo '<td><a href="batchmedicine.php?id=' . $row['medicine_id'] . '" class="btn btn-primary">BatchList</a></td>';
                            echo '</tr>';
                            $rowNumber++;
                        }

                        echo '</tbody></table>';
                    } else {
                        echo '<p class="alert alert-info">No Medicine found.</p>';

                    }
                     // Pagination links
                echo '<ul class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . $searchKeyword . '">' . $i . '</a></li>';
                }
                echo '</ul>';
                    ?>
                </div>
            </div>
        </content>
    </main>

    <!-- Bootstrap JS and other required scripts -->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="../js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
</body>
</html>

<?php } ?>
