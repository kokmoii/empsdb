<?php
require 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Stock Inventory Report</title>
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

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Latest Stock Inventory Report</a>
    </nav>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Latest Stock Inventory
            </div>
            <div class="card-body">
                <?php
                // Assuming you have a valid database connection in $conn

$latestStockSql = "(SELECT b.batch_id, b.purchase_date, b.quantity, m.medicine_name AS item_name, 'Medicine' AS type
                   FROM batch b
                   JOIN medicine m ON b.medicine_id = m.medicine_id
                   ORDER BY b.batch_id DESC
                   LIMIT 3)
                   UNION
                   (SELECT b.batch_id, b.purchase_date, b.quantity, e.equipment_name AS item_name, 'Equipment' AS type
                   FROM batch b
                   JOIN equipment e ON b.equipment_id = e.equipment_id
                   ORDER BY b.batch_id DESC
                   LIMIT 3)
                   ORDER BY purchase_date DESC
                   LIMIT 3";

$latestStockResult = $conn->query($latestStockSql);

// Display the data
if ($latestStockResult->num_rows > 0) {
    while ($row = $latestStockResult->fetch_assoc()) {
        echo '<p>Batch ID: ' . $row['batch_id'];
        echo 'Item Name: ' . $row['item_name'];
        echo 'Type: ' . $row['type'];
        echo 'Quantity: ' . $row['quantity'] . '</p>';
        // Display other relevant information
        echo '<hr>';
    }
} else {
    echo '<p>No latest stock found.</p>';
}

                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and other required scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
