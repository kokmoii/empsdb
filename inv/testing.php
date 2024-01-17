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
                <li class="nav-item active">
                    <a class="nav-link" href="#todaysArrivals">Today's Arrivals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#totalInventory">Total Inventory</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#lowStockInventory">Low Stock Inventory</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#expiringProducts">Expiring Products</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Inventory Report</h1>
        <hr>

        <!-- Today's Arrivals Section -->
        <div id="todaysArrivals" class="report-section">
            <h2>Today's Arrivals</h2>
            <?php
            // Fetch today's arrivals
            $todaysArrivalsSql = "SELECT b.*, m.medicine_name
                                  FROM batch b
                                  JOIN medicine m ON b.medicine_id = m.medicine_id
                                  WHERE b.purchase_date = CURDATE()";

            $todaysArrivalsResult = $conn->query($todaysArrivalsSql);

            // Display the data
            if ($todaysArrivalsResult->num_rows > 0) {
                while ($row = $todaysArrivalsResult->fetch_assoc()) {
                    echo '<p><strong>Batch ID:</strong> ' . $row['batch_id'] . '</p>';
                    echo '<p><strong>Medicine Name:</strong> ' . $row['medicine_name'] . '</p>';
                    // Display other relevant information
                }
            } else {
                echo '<p>No arrivals today.</p>';
            }
            ?>
        </div>

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

        <!-- Low Stock Inventory Section -->
        <div id="lowStockInventory" class="report-section">
            <h2>Low Stock Inventory</h2>
            <?php
            // Fetch low stock inventory
            $lowStockThreshold = 10; // Adjust this threshold based on your criteria

            $lowStockInventorySql = "SELECT * FROM (
                                  SELECT 'Medicine' AS inventory_type, m.*, b.quantity
                                  FROM medicine m
                                  JOIN batch b ON m.medicine_id = b.medicine_id
                                  WHERE b.quantity < $lowStockThreshold
                                  UNION
                                  SELECT 'Equipment' AS inventory_type, e.*, b.quantity
                                  FROM equipment e
                                  JOIN batch b ON e.equipment_id = b.equipment_id
                                  WHERE b.quantity < $lowStockThreshold
                                ) AS low_stock_inventory";

            $lowStockInventoryResult = $conn->query($lowStockInventorySql);

            // Display the data
            if ($lowStockInventoryResult->num_rows > 0) {
                while ($row = $lowStockInventoryResult->fetch_assoc()) {
                    echo '<p><strong>Inventory Type:</strong> ' . $row['inventory_type'] . '</p>';
                    echo '<p><strong>Item Name:</strong> ' . $row['medicine_name'] . '</p>';
                    echo '<p><strong>Quantity:</strong> ' . $row['quantity'] . '</p>';
                    // Display other relevant information
                }
            } else {
                echo '<p>No low stock inventory found.</p>';
            }
            ?>
        </div>

        <!-- Expiring Products Section -->
        <div id="expiringProducts" class="report-section">
            <h2>Expiring Products (Next 10 Days)</h2>
            <?php
            // Fetch expiring items
            $expirationDateThreshold = date('Y-m-d', strtotime('+10 days'));

            $expiringItemsSql = "SELECT 'Medicine' AS inventory_type, m.*, b.expiration_date
                                FROM medicine m
                                JOIN batch b ON m.medicine_id = b.medicine_id
                                WHERE b.expiration_date BETWEEN CURDATE() AND '$expirationDateThreshold'
                                UNION
                                SELECT 'Equipment' AS inventory_type, e.*, b.expiration_date
                                FROM equipment e
                                JOIN batch b ON e.equipment_id = b.equipment_id
                                WHERE b.expiration_date BETWEEN CURDATE() AND '$expirationDateThreshold'";

            $expiringItemsResult = $conn->query($expiringItemsSql);

            // Display the data
            if ($expiringItemsResult->num_rows > 0) {
                while ($row = $expiringItemsResult->fetch_assoc()) {
                    echo '<p><strong>Inventory Type:</strong> ' . $row['inventory_type'] . '</p>';
                    echo '<p><strong>Item Name:</strong> ' . $row['medicine_name'] . '</p>';
                    echo '<p><strong>Expiration Date:</strong> ' . $row['expiration_date'] . '</p>';
                    // Display other relevant information
                }
            } else {
                echo '<p>No expiring items found in the next 10 days.</p>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and other required scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
