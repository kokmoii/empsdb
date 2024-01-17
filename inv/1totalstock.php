<?php require 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 56px;
        }

        @media (min-width: 768px) {
            body {
                padding-top: 70px;
            }
        }

        .report-section {
            margin-bottom: 30px;
        }

        .report-section h2 {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .report-section p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Inventory Report</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#totalInventory">Total Inventory</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Inventory Report</h1>
        <hr>

        <!-- Total Inventory Section -->
        <div id="totalInventory" class="report-section">
            <h2>Total Inventory by Type</h2>
            <?php
            // Fetch total inventory by type
            $totalInventorySql = "SELECT 'Medicine' AS inventory_type, COUNT(*) AS total_count
                                  FROM medicine
                                  UNION
                                  SELECT 'Equipment' AS inventory_type, COUNT(*) AS total_count
                                  FROM equipment";

            $totalInventoryResult = $conn->query($totalInventorySql);

            // Display the data
            if ($totalInventoryResult->num_rows > 0) {
                while ($row = $totalInventoryResult->fetch_assoc()) {
                    echo '<p><strong>Inventory Type:</strong> ' . $row['inventory_type'] . '</p>';
                    echo '<p><strong>Total Count:</strong> ' . $row['total_count'] . '</p>';
                    // Display other relevant information
                }
            } else {
                echo '<p>No inventory found.</p>';
            }
            ?>
        </div>


    <!-- Bootstrap JS and other required scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
