<?php
require 'connection.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Inventory Dashboard</title>

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main2.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Chart.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css">
</head>

<body class="app sidebar-mini rtl">

    <!-- Navbar-->
    <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include 'include/sidebar.php'; ?>

    <main class="app-content">

        <center>
            <h1>INVENTORY DASHBOARD</h1>
        </center>

        <!-- Top Card Section -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Inventory</h5>
                        <?php
                        // Assuming you have a valid database connection in $conn

                        // Query to get total inventory count
                        $totalInventorySql = "SELECT COUNT(*) AS total_count FROM your_inventory_table";
                        $totalInventoryResult = $conn->query($totalInventorySql);

                        if ($totalInventoryResult && $totalInventoryResult->num_rows > 0) {
                            $row = $totalInventoryResult->fetch_assoc();
                            echo '<p class="card-text">' . $row['total_count'] . ' items</p>';
                        } else {
                            echo '<p class="card-text">No data available</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Profit/Loss</h5>
                        <?php
                        // Assuming you have a valid database connection in $conn

                        // Query to get total profit or loss
                        $totalProfitLossSql = "SELECT SUM(your_profit_loss_column) AS total_profit_loss FROM your_profit_loss_table";
                        $totalProfitLossResult = $conn->query($totalProfitLossSql);

                        if ($totalProfitLossResult && $totalProfitLossResult->num_rows > 0) {
                            $row = $totalProfitLossResult->fetch_assoc();
                            echo '<p class="card-text">RM ' . $row['total_profit_loss'] . '</p>';
                        } else {
                            echo '<p class="card-text">No data available</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Sales Chart Section -->
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Product Sales
                    </div>
                    <div class="card-body">
                        <canvas id="productSalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS and other required scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <script>
        var productSalesData = {
            labels: ['Panadol', 'Panadolol', 'Syringe', 'Atopica', 'Cluve ear cleaner'],
            datasets: [{
                label: 'Total sold',
                data: [120, 83, 150, 100, 200],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Initialize charts
        var ctx2 = document.getElementById('productSalesChart').getContext('2d');

        var productSalesChart = new Chart(ctx2, {
            type: 'bar',
            data: productSalesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

<!-- Bootstrap JS and other required scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <!-- Essential javascripts for application to work-->
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
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>

</html>
