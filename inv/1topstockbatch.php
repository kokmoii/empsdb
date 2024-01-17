<?php
require 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complex Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Chart.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css">
    <style>
        body {
            padding-top: 56px;
        }

        @media (min-width: 768px) {
            body {
                padding-top: 70px;
            }
        }

        .dashboard-header {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .card {
            margin-bottom: 20px;
        }

        canvas {
            max-width: 100%;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->

    <div class="container mt-5">
        <div class="dashboard-header">
            <h1>most inventory that been used in year(siap boleh filter)</h1>
        </div>

            <!-- Chart 2: Product Sales -->
            <div class="col-md-8">
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

</html>
