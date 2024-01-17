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
$recordsPerPage = 3; // Adjust this value as needed
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
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
        <center><h1>INVOICE</h1></center>
        <content>
            <div class="container mt-3">

                <?php
        // Handle search query
        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $searchCondition = empty($searchKeyword) ? '' : " 
        WHERE 
            i.invoice_no LIKE '%$searchKeyword%' OR 
            i.cost LIKE '%$searchKeyword%' OR 
            i.payment_reference LIKE '%$searchKeyword%' OR 
            b.purchase_date LIKE '%$searchKeyword%' OR 
            s_m.supplier_name LIKE '%$searchKeyword%' OR 
            s_e.supplier_name LIKE '%$searchKeyword%'";

            $sql = "SELECT i.*, m.medicine_name, e.equipment_name, 
            COALESCE(s_m.supplier_name, s_e.supplier_name) AS combined_supplier,
            b.quantity, b.purchase_date
            FROM invoice i
            LEFT JOIN batch b ON i.invoice_no = b.invoice_no
            LEFT JOIN medicine m ON b.medicine_id = m.medicine_id
            LEFT JOIN supplier s_m ON m.supplier_id = s_m.supplier_id
            LEFT JOIN equipment e ON b.equipment_id = e.equipment_id
            LEFT JOIN supplier s_e ON e.supplier_id = s_e.supplier_id" . $searchCondition . " GROUP BY i.invoice_no
        LIMIT $offset, $recordsPerPage";

            // Pagination query
$paginationSql = "SELECT COUNT(DISTINCT i.invoice_no) as total 
                  FROM invoice i
                  LEFT JOIN batch b ON i.invoice_no = b.invoice_no
                  LEFT JOIN medicine m ON b.medicine_id = m.medicine_id
                  LEFT JOIN supplier s_m ON m.supplier_id = s_m.supplier_id
                  LEFT JOIN equipment e ON b.equipment_id = e.equipment_id
                  LEFT JOIN supplier s_e ON e.supplier_id = s_e.supplier_id" . $searchCondition;

$paginationResult = $conn->query($paginationSql);
$totalRows = $paginationResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $recordsPerPage);

// Display range of rows being shown
$startRow = $offset + 1;
$endRow = min($offset + $recordsPerPage, $totalRows);

if (!empty($searchKeyword)) {
    echo '<center><a href="invoice.php" class="btn btn-secondary mt-3">Back to All Invoice</a></center>';
}


echo '<p>Displaying ' . $startRow . ' - ' . $endRow . ' out of ' . $totalRows . ' rows</p>';



        $result = $conn->query($sql);

        // Check for errors in the query
        if (!$result) {
            die("Error: " . $conn->error);
        }
                    ?>

            </div>
            <div class="container mt-3">
                <div class="table-responsive">
                    <?php
                    if ($result->num_rows > 0) {
                        echo '<form method="get" action="invoice.php">';
                        echo '<div class="input-group mb-3">';
                        echo '<input type="text" class="form-control" name="search" placeholder="Search" value="' . $searchKeyword . '">';
                        echo '<div class="input-group-append">';
                        echo '<button class="btn btn-outline-secondary" type="submit">Search</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';

                        echo '<table class="table table-bordered table-striped">';
                        echo '<thead class="thead-dark">';
                        echo '<tr><th scope="col">No</th><th scope="col">Invoice No</th><th scope="col">Purchase Date</th><th scope="col">Supplier</th><th scope="col">View</th></tr></thead>';
                        echo '<tbody>';

                        $rowNumber = 1 + $offset;
                        // Output invoice data with specified columns
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $rowNumber . '</td>';
                            echo '<td>' . $row['invoice_no'] . '</td>';
                            echo '<td>' . $row['purchase_date'] . '</td>';
                            echo '<td>' . $row['combined_supplier'] .'</td>'; // Display both medicine and equipment suppliers
                            echo '<td><a href="viewinvoice.php?invoice_no=' . $row['invoice_no'] . '"class="btn btn-primary">View</a></td>';
                            echo '</tr>';
                            $rowNumber++;
                        }

                        echo '</tbody></table>';
                    } else {
                        echo '<p class="alert alert-info">No Invoice found.</p>';

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

<?php } ?>

