<?php 
session_start();
error_reporting(0);
require('include/config.php');
if(strlen( $_SESSION["Empid"])==0)
    {   
      header('location:index.php');
}
else{?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Batch</title>
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
    
    <?php

    // Get the equipment ID from the URL parameter
    $equipmentId = isset($_GET['equipment_id']) ? $_GET['equipment_id'] : '';
    $equipmentId = mysqli_real_escape_string($conn, $equipmentId);

    // Fetch equipment details based on equipment ID
    $equipmentSql = "SELECT * FROM equipment WHERE equipment_id = '$equipmentId'";
    $equipmentResult = $conn->query($equipmentSql);
    $equipmentRow = $equipmentResult->fetch_assoc();
    ?>

    <main class="app-content">
        <!-- Back button to go to the Batch List -->
        <a href="batchequipment.php?id=<?php echo $equipmentId; ?>" class="btn btn-info">Back to Batch List</a>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                <h2 class="text-center mb-4">Add Batch: <?php echo $equipmentRow['equipment_name']; ?></h2>
                    <div class="card">
                        <div class="card-body">

                            <form method="post" action="action/addbatchequip.php">
                                <!-- Add a hidden input field to include equipment_id in the form -->
                                <input type="hidden" name="equipment_id" value="<?php echo $equipmentId; ?>">

                                <div class="form-group">
                                    <label for="price_per_unit">Price per Unit:</label>
                                    <input type="text" class="form-control" name="price_per_unit" required>
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Quantity:</label>
                                    <input type="text" class="form-control" name="quantity" required>
                                </div>

                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date:</label>
                                    <input type="date" class="form-control" name="purchase_date" required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Add Batch</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
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
    <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
</body>
</html>
<?php }?>