<?php
require 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Batch</title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main2.css">
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
    require 'connection.php';

    // Get the medicine ID from the URL parameter
    $medicineId = isset($_GET['medicine_id']) ? $_GET['medicine_id'] : '';
    $medicineId = mysqli_real_escape_string($conn, $medicineId);

    // Fetch medicine details based on medicine ID
    $medicineSql = "SELECT * FROM medicine WHERE medicine_id = '$medicineId'";
    $medicineResult = $conn->query($medicineSql);
    $medicineRow = $medicineResult->fetch_assoc();
    ?>

    <main class="app-content">
        <!-- Back button to go to the Batch List -->
        <a href="batchmedicine.php?id=<?php echo $medicineId; ?>" class="btn btn-info">Back to Batch List</a>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                <h2 class="text-center mb-4">Add Batch: <?php echo $medicineRow['medicine_name']; ?></h2>
                    <div class="card">
                        <div class="card-body">

                            <form method="post" action="action/addbatchmed.php" onsubmit="return confirm('Are you sure you want to add this batch for <?php echo $medicineRow['medicine_name']; ?> ?')">
                                <!-- Add a hidden input field to include medicine_id in the form -->
                                <input type="hidden" name="medicine_id" value="<?php echo $medicineId; ?>">

                                <div class="form-group">
                                    <label for="price_per_unit">Price per Unit:</label>
                                    <input type="text" class="form-control" name="price_per_unit" required>
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Quantity:</label>
                                    <input type="text" class="form-control" name="quantity" required>
                                </div>

                                <div class="form-group">
                                    <label for="expiration_date">Expiration Date:</label>
                                    <input type="date" class="form-control" name="expiration_date" required>
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
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
</body>
</html>
