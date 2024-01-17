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
        <a href="addsupplier.php" class="btn btn-info">Add Supplier</a>
        <center><h1>SUPPLIER</h1></center>
        <content>
            <div class="container mt-3">
                <center>
                    <?php
                    // Handle search query
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = empty($searchKeyword) ? '' : " WHERE supplier_name LIKE '%$searchKeyword%' OR supplier_phone LIKE '%$searchKeyword%' OR supplier_email LIKE '%$searchKeyword%' OR supplier_address LIKE '%$searchKeyword%' OR supplier_status = '$searchKeyword'";

$sql = "SELECT * FROM supplier" . $searchCondition;
$result = $conn->query($sql);
                    ?>

                    <?php
                    if (!empty($searchKeyword)) {
                        echo '<a href="supplier.php" class="btn btn-secondary mt-3">Back to All Suppliers</a>';
                    }
                    ?>
                </center>
            </div>
            <div class="container mt-3">
                <div class="table-responsive">
                    <?php


                     // Pagination query
                $paginationSql = "SELECT COUNT(*) as total FROM supplier" . $searchCondition;
                $paginationResult = $conn->query($paginationSql);
                $totalRows = $paginationResult->fetch_assoc()['total'];
                $totalPages = ceil($totalRows / $recordsPerPage);

                                    // Display range of rows being shown
        $startRow = $offset + 1;
        $endRow = min($offset + $recordsPerPage, $totalRows);

        echo '<p>Displaying ' . $startRow . ' - ' . $endRow . ' out of ' . $totalRows . ' rows</p>';

                $sql .= " LIMIT $offset, $recordsPerPage";

                $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<form method="get" action="supplier.php">';
                        echo '<div class="input-group mb-3">';
                        echo '<input type="text" class="form-control" name="search" placeholder="Search" value="' . $searchKeyword . '">';
                        echo '<div class="input-group-append">';
                        echo '<button class="btn btn-outline-secondary" type="submit">Search</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';

                        echo '<table class="table table-bordered table-striped" id="sampleTable">';
                        echo '<thead class="thead-dark">';
                        echo '<tr><th scope="col">No</th><th scope="col">Name</th><th scope="col">Phone</th><th scope="col">Email</th><th scope="col">Address</th><th scope="col">Status</th><th scope="col">Action</th></tr></thead>';
                        echo '<tbody>';

                        $rowNumber = $offset + 1;
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<th scope="row">' . $rowNumber . '</th>';
                            echo '<td>' . $row['supplier_name'] . '</td>';
                            echo '<td>' . $row['supplier_phone'] . '</td>';
                            echo '<td>' . $row['supplier_email'] . '</td>';
                            echo '<td>' . $row['supplier_address'] . '</td>';
                            echo '<td>' . $row['supplier_status'] . '</td>';
                            echo '<td><a href="editsupplier.php?id=' . $row['supplier_id'] . '" class="btn btn-primary">Edit</a></td>';
                            echo '</tr>';
                            $rowNumber++;
                        }

                        echo '</tbody></table>';
                    } else {
                        echo '<p class="alert alert-info">No suppliers found.</p>';
                        if (!empty($searchKeyword)) {
                            echo '<a href="supplier.php" class="btn btn-secondary">Back to All Suppliers</a>';
                        }
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
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
</body>
</html>
<?php }?>