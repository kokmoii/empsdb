<?php 
session_start();
error_reporting(0);
require('include/config.php');
if(strlen( $_SESSION["Empid"])==0)
    {   
      header('location:index.php');
}
else{
?><?php

// Get the medicine ID from the URL parameter
$medicineId = isset($_GET['id']) ? $_GET['id'] : '';
$medicineId = mysqli_real_escape_string($conn, $medicineId);

// Fetch medicine details based on medicine ID
$medicineSql = "SELECT * FROM medicine WHERE medicine_id = '$medicineId'";
$medicineResult = $conn->query($medicineSql);
$medicineRow = $medicineResult->fetch_assoc();

// Fetch batch details based on medicine ID and search condition
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = empty($searchKeyword) ? '' : " AND (batch_id LIKE '%$searchKeyword%' OR price_punit LIKE '%$searchKeyword%' OR quantity_stock LIKE '%$searchKeyword%' OR expiration_date LIKE '%$searchKeyword%' OR purchase_date LIKE '%$searchKeyword%' OR status LIKE '%$searchKeyword%' OR invoice_no LIKE '%$searchKeyword%')";
$searchCondition .= " AND (quantity_stock > 0 AND expiration_date >= CURDATE())";
// Pagination variables
$recordsPerPage = 5; // Adjust this value as needed
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Pagination query
$paginationSql = "SELECT COUNT(*) as total FROM batch WHERE medicine_id = '$medicineId'" . $searchCondition;
$paginationResult = $conn->query($paginationSql);
$totalRows = $paginationResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $recordsPerPage);

// Display range of rows being shown
$startRow = $offset + 1;
$endRow = min($offset + $recordsPerPage, $totalRows);


$batchSql = "SELECT * FROM batch WHERE medicine_id = '$medicineId'" . $searchCondition . " LIMIT $offset, $recordsPerPage";
$batchResult = $conn->query($batchSql);



// Store medicine name in session if it exists
if ($medicineResult->num_rows > 0) {
    $_SESSION['medicine_name'] = $medicineRow['medicine_name'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch List</title>
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
        <div class="container mt-3">
        <?php if (!empty($searchKeyword)) { ?>
        <a href="batchmedicine.php?id=<?php echo $medicineId; ?>" class="btn btn-secondary">Back to Batch List</a>
    <?php } else { ?>
        <a href="medicine.php" class="btn btn-secondary">Back to Medicine List</a>
    <?php } ?>
            <a href="addbatchmedicine.php?medicine_id=<?php echo $medicineId; ?>" class="btn btn-info">Add New Batch</a>
            <center>
                <h1>BATCH LIST</h1>
                <p>Medicine: <?php echo isset($_SESSION['medicine_name']) ? $_SESSION['medicine_name'] : ''; ?></p>
    </center>
                <form method="get" action="" class="mb-3">
                <?php echo '<p>Displaying ' . $startRow . ' - ' . $endRow . ' out of ' . $totalRows . ' rows</p>';?>
    <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Search" value="<?php echo $searchKeyword; ?>">
        <!-- Add hidden input for medicine_id -->
        <input type="hidden" name="id" value="<?php echo $medicineId; ?>">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </div>
</form>
                    </div>
                </form>
            </center>

            <?php   

                
                if ($batchResult->num_rows > 0) {
                 ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Batch ID</th>
                                <th scope="col">Price per Unit(RM)</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Expiration Date</th>
                                <th scope="col">Purchase Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Invoice No</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                

                            $rowNumber = $offset +1;
                            while ($batchRow = $batchResult->fetch_assoc()) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $rowNumber; ?></th>
                                    <td><?php echo $batchRow['batch_id']; ?></td>
                                    <td><?php echo $batchRow['price_punit']; ?></td>
                                    <td><?php echo $batchRow['quantity_stock']; ?></td>
                                    <td><?php echo $batchRow['expiration_date']; ?></td>
                                    <td><?php echo $batchRow['purchase_date']; ?></td>
                                    <td><?php echo $batchRow['status']; ?></td>
                                    <td><?php echo $batchRow['invoice_no']; ?></td>
                                    <td>
                                        <?php
                                        if ($batchRow['status'] == 'Unused') {
                                            echo '<a href="updatestatusmed.php?medicine_id=' . $medicineId . '&batch_id=' . $batchRow['batch_id'] . '" class="btn btn-success">Set to Used</a>';
                                        } else {
                                            echo '<a href="updatestatusmed.php?medicine_id=' . $medicineId . '&batch_id=' . $batchRow['batch_id'] . '" class="btn btn-warning">Set to Unused</a>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $rowNumber++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <p class="alert alert-info">No batches found for this medicine.</p>
            <?php } 
             // Pagination links
             echo '<ul class="pagination">';
             for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . $searchKeyword . '&id=' . $medicineId . '">' . $i . '</a></li>';
             }
             echo '</ul>';
            ?>
        </div>
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