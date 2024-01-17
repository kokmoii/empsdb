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

        <!-- Main CSS-->
        <link rel="stylesheet" type="text/css" href="../css/main.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font-icon CSS-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="app sidebar-mini rtl">

    <!-- Navbar-->
    <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include 'include/sidebar.php'; ?>

    <main class="app-content">
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>REPORT</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="content text-center">
                        <br>
                        <a href="#" class="btn btn-info btn-lg btn-block">Profit/Lost by date</a>
                        <br>
                        <a href="repexpbatch.php" class="btn btn-info btn-lg btn-block"> List expired batch</a>
                        <br>
                        <a href="#" class="btn btn-info btn-lg btn-block">Latesst stock batch</a>
                        <br>
                        <a href="#" class="btn btn-info btn-lg btn-block"> List low stock batch</a>
                        <br>
                        <a href="#" class="btn btn-info btn-lg btn-block"> List low stock batch</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Essential javascripts for application to work-->
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
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>

</body>

</html>
