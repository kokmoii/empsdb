<?php 
session_start();
error_reporting(0);
require('include/config.php');
if(strlen( $_SESSION["Empid"])==0)
    {   
      header('location:index.php');
}
else{

// Get the invoice number from the URL parameter
$invoiceNo = isset($_GET['invoice_no']) ? $_GET['invoice_no'] : '';
$invoiceNo = mysqli_real_escape_string($conn, $invoiceNo);

// Fetch invoice details with related batch information
$invoiceDetailsSql = "SELECT i.*, b.*, 
                      COALESCE(m.medicine_name, e.equipment_name) AS item_name,
                      COALESCE(s_m.supplier_name, s_e.supplier_name) AS supplier_name,
                      COALESCE(m.medicine_id, e.equipment_id) AS inventory_id,
                      CASE 
                          WHEN m.medicine_id IS NOT NULL THEN 'Medicine'
                          WHEN e.equipment_id IS NOT NULL THEN 'Equipment'
                      END AS inventory_type,
                      s.supplier_name AS supplier_name,
                      s.supplier_email AS supplier_email,
                      s.supplier_phone AS supplier_phone,
                      s.supplier_address AS supplier_address
                      FROM invoice i
                      JOIN batch b ON i.invoice_no = b.invoice_no
                      LEFT JOIN medicine m ON b.medicine_id = m.medicine_id
                      LEFT JOIN supplier s_m ON m.supplier_id = s_m.supplier_id
                      LEFT JOIN equipment e ON b.equipment_id = e.equipment_id
                      LEFT JOIN supplier s_e ON e.supplier_id = s_e.supplier_id
                      LEFT JOIN supplier s ON s_m.supplier_id = s.supplier_id OR s_e.supplier_id = s.supplier_id
                      WHERE i.invoice_no = '$invoiceNo'";

$invoiceDetailsResult = $conn->query($invoiceDetailsSql);
$invoiceDetails = $invoiceDetailsResult->fetch_all(MYSQLI_ASSOC);

// Initialize total amount and total cost
$totalAmount = 0;
$totalCost = 0;

$companyAddress = "2358-1 Jalan Merbok, 53100 Gombak, Selangor ";
$phone ="Phone : +06-5676615";
$companyLogoUrl = "../img/logo.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Invoice</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
<div class="row mt-3">
    <div class="col-md-6">
        <a href="invoice.php" class="btn btn-secondary no-print">Back to All Invoice</a>
    </div>
    <div class="col-md-6 text-right"> <!-- Align the button to the right -->
        <button class="btn btn-info no-print" onclick="printInvoice()">Print Invoice</button>
    </div>
</div>
    <div class="row">
        <div class="col-md-6 text-left">
            <img src="<?php echo $companyLogoUrl; ?>" alt="Company Logo" width="250">
            <p><?php echo $companyAddress; ?></p>
            <p><?php echo $phone; ?></p>
        </div>
        <div class="col-md-6 text-right">
            <h5>Payment Reference: <?php echo $invoiceDetails[0]['payment_reference']; ?></h5>
            <h5>Invoice No: <?php echo $invoiceDetails[0]['invoice_no']; ?></h5>
            <p><?php echo $invoiceDetails[0]['time_stamp']; ?></p>
        </div>
        <div class="col-md-12 text-center"> <!-- Center align the invoice -->
            <h1> INVOICE</h1>
        </div>
    </div>
    <hr>

    <?php if (!empty($invoiceDetails)) { ?>
        <div class="row">
            <div class="col-md-6 text-left">
                <h5><strong>Supplier Information:</strong></h5>
                <p><strong>Name:</strong> <?php echo $invoiceDetails[0]['supplier_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $invoiceDetails[0]['supplier_email']; ?></p>
                <p><strong>Phone:</strong> <?php echo $invoiceDetails[0]['supplier_phone']; ?></p>
                <p><strong>Address:</strong> <?php echo $invoiceDetails[0]['supplier_address']; ?></p>
            </div>
        </div>

        <table class="table table-bordered mt-4">
    <thead class="thead-dark">
        <tr>
            <th>No.</th>
            <th>Item Name</th>
            <th>Inventory Type</th>
            <th>Expiration Date</th>
            <th>Purchase Date</th>
            <th>Price per Unit(RM)</th>
            <th>Quantity</th>
            <th>Total(RM)</th>
        </tr>
    </thead>
    <tbody>
        <?php $rowNumber = 1; ?>
        <?php foreach ($invoiceDetails as $batch) { ?>
            <tr>
                <td><?php echo $rowNumber; ?></td>
                <td><?php echo $batch['item_name']; ?></td>
                <td><?php echo $batch['inventory_type']; ?></td>
                <td><?php echo $batch['inventory_type'] === 'Equipment' ? ($batch['expiration_date'] ?? '<center>-</center>') : $batch['expiration_date'];  ?></td>
                <td><?php echo $batch['purchase_date']; ?></td>
                <td><?php echo 'RM '.$batch['price_punit']; ?></td>
                <td><?php echo $batch['quantity']; ?></td>
                <td><?php echo 'RM '.$batch['price_punit'] * $batch['quantity']; ?></td>
            </tr>
            <?php
                // Calculate and update total amount
                $totalAmount += $batch['price_punit'] * $batch['quantity'];

                // Increment row number
                $rowNumber++;
            ?>
        <?php } ?>
        <!-- Total Amount Row -->
        <tr>
            <td colspan="7" class="text-right"><strong>Total Amount:</strong></td>
            <td><?php echo 'RM '.$totalAmount; ?></td>
        </tr>
    </tbody>
</table>

    <?php } else { ?>
        <p class="text-danger">Invoice details not found.</p>
    <?php } ?>

</div>




<!-- Bootstrap JS and other required scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<style>
    /* Styles for printing */
    @media print {
        .no-print {
            display: none;
        }
    }
</style>

<script>
    function printInvoice() {
        window.print();
    }
</script>
</body>
</html>

<?php } ?>

