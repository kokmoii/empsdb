<?php 
session_start();
error_reporting(0);
require_once('include/config.php');
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Inventory Dashboard</title>

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Chart.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.min.css">
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
    <div class="card text-center border-success shadow">
        <div class="card-header text-white" style="background-color: #009688;">
            <h4 class="card-title">Total Inventory</h4>
        </div>
        <div class="card-body">
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
                    echo '<div class="row mb-4">';
                    echo '<div class="col-md-12">';
                    echo '<h5 class="card-text">';
                    switch ($row['inventory_type']) {
                        case 'Medicine':
                            echo '<i class="bi bi-capsule-pill me-2"></i>'; // Icon for Medicine
                            break;
                        case 'Equipment':
                            echo '<i class="bi bi-tools me-2"></i>'; // Icon for Equipment
                            break;
                        default:
                            echo '<i class="bi bi-question-circle me-2"></i>'; // Default icon
                    }
                    echo $row['inventory_type'] . ' <strong>Total :</strong> ' . $row['total_count'] . '</h5>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="card-text text-muted">No inventory found.</p>';
            }
            ?>
        </div>
    </div>
</div>


            <div class="col-md-6">
    <div class="card border-success shadow">
        <div class="card-header  text-white" style="background-color: #009688;">
            <h4 class="card-title">Total Profit/Loss</h4>
        </div>
        <div class="card-body d-flex flex-column justify-content-center">
            <?php
            // ... PHP code to fetch total profit/loss ...

           
                echo '<p class="card-text text-muted text-center">No profit/loss data available.</p>';
            ?>
        </div>
    </div>
</div>

        </div>

        <div class="row mt-3">
            <!-- Low Stock Inventory Card Section -->
            <div class="col-md-6 mt-3">
  <div class="card border-danger shadow">
    <div class="card-header bg-danger text-white">
      <h4 class="card-title">Low Stock Inventory (Below 10)</h4>
    </div>
    <div class="card-body">
      <?php
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

      if ($lowStockInventoryResult->num_rows > 0) {
        ?>
        <table class="table table-hover table-bordered table-danger">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Inventory Type</th>
              <th scope="col">Item Name</th>
              <th scope="col">Quantity</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $rowNumber = 1;
            while ($row = $lowStockInventoryResult->fetch_assoc()) {
              ?>
              <tr >
                <th scope="row"><?php echo $rowNumber; ?></th>
                <td><?php echo $row['inventory_type']; ?></td>
                <td><?php echo $row['medicine_name']; // Adjust for equipment ?></td>
                <td><?php echo $row['quantity']; ?></td>
              </tr>
              <?php
              $rowNumber++;
            }
            ?>
          </tbody>
        </table>
        <?php
      } else {
        ?>
        <p class="text-center text-muted">No low stock inventory found.</p>
        <?php
      }
      ?>
    </div>
  </div>
</div>


            <!-- Expired Products Card Section -->
            <div class="col-md-6 mt-3">
  <div class="card border-warning shadow">
    <div class="card-header bg-warning text-white">
      <h4 class="card-title"><i class="bi bi-exclamation-triangle-fill"></i> Expiring Products (In 10 Days) <i class="bi bi-exclamation-triangle-fill"></i> </h4>
      </div>
    <div class="card-body">
    <table class="table table-hover table-bordered table-warning">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Inventory Type</th>
            <th scope="col">Item Name</th>
            <th scope="col">Expiration Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $expirationDateThreshold = date('Y-m-d', strtotime('+10 days'));

            $expiringItemsSql = "SELECT * FROM (
                (SELECT 'Medicine' AS inventory_type, m.*, b.expiration_date
                FROM medicine m
                JOIN batch b ON m.medicine_id = b.medicine_id
                WHERE b.expiration_date BETWEEN CURDATE() AND '$expirationDateThreshold')
                UNION
                (SELECT 'Equipment' AS inventory_type, e.*, b.expiration_date
                FROM equipment e
                JOIN batch b ON e.equipment_id = b.equipment_id
                WHERE b.expiration_date BETWEEN CURDATE() AND '$expirationDateThreshold')
            ) AS expiring_items
            ORDER BY expiration_date ASC";

$expiringItemsResult = $conn->query($expiringItemsSql);
            
            // Display the expiring items data as a table
            if ($expiringItemsResult->num_rows > 0) {
                $rowNumber = 1;
                while ($row = $expiringItemsResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<th scope="row">' . $rowNumber . '</th>';
                    echo '<td>' . $row['inventory_type'] . '</td>';
                    echo '<td>' . $row['medicine_name'] . '</td>'; // Adjust for equipment
                    echo '<td>' . $row['expiration_date'] . '</td>';
                    $rowNumber++;
                    echo '</tr>';
                    
                }
            } else {
                echo '<tr><td colspan="3">No expiring items found in the next 10 days.</td></tr>';
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

                    </div>


        <!-- Product Sales Chart Section -->
        <div class="row mt-3">
        <div class="col-md-6">
  <div class="card border-info shadow">
    <div class="card-header text-white" style="background-color: #009688;">
      <h4 class="card-title"><i class="bi bi-bar-chart"></i> Product Sales Trends</h4>
    </div>
    <div class="card-body">
      <canvas id="productSalesChart" class="chartjs-render-monitor"></canvas>
    </div>
  </div>
</div>


            <div class="col-md-6">
  <div class="card border-success shadow">
    <div class="card-header  text-white" style="background-color: #009688;" >
      <h4 class="card-title"><i class="bi bi-box-seam"></i> Latest Stock</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-bordered table-sm">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Type</th>
            <th scope="col">Item Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Purchase Date</th>
          </tr>
        </thead>
        <tbody>
        <?php
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
    $rowNumber = 1;
    while ($row = $latestStockResult->fetch_assoc()) {

        echo '<tr>';
        echo '<th scope="row">' . $rowNumber . '</th>';
        echo '<td>' . $row['type']. '</td>';
        echo '<td>' . $row['item_name']. '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['purchase_date']. '</td>';
        $rowNumber++;
        // Display other relevant information
        echo '</tr>';
    }
} else {
    echo '<p>No latest stock found.</p>';
    echo '<tr><td colspan="3">No expiring items found in the next 10 days.</td></tr>';
}

                ?>
        </tbody>
      </table>
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
    <!-- Essential javascripts for application to work-->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="../js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="j../s/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>

</html>