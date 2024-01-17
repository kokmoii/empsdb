<?php 
session_start();
error_reporting(0);
require('include/config.php');
if(strlen( $_SESSION["Empid"])==0)
    {   
      header('location:index.php');
}
else{

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
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
        form textarea {
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
        <a href="supplier.php" class="btn btn-info">Back</a>
        <content>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h2 class="text-center mb-4">ADD SUPPLIER</h2>
                        <form method="post" action="action/addsup.php" onsubmit="return confirm('Are you sure you want to add this supplier?')">
                            <div class="form-group">
                                <label for="supplierName">Supplier Name:</label>
                                <input type="text" class="form-control" id="supplierName" name="supplier_name" required>
                            </div>
                            <div class="form-group">
                                <label for="supplierPhone">Supplier Phone:</label>
                                <input type="number" class="form-control" id="supplierPhone" name="supplier_phone" required>
                            </div>
                            <div class="form-group">
                                <label for="supplierEmail">Supplier Email:</label>
                                <input type="email" class="form-control" id="supplierEmail" name="supplier_email" required>
                            </div>
                            <div class="form-group">
                                <label for="supplierAddress">Supplier Address:</label>
                                <textarea class="form-control" id="supplierAddress" name="supplier_address" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Add Supplier</button>
                        </form>
                    </div>
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