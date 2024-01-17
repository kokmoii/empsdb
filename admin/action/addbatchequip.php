<?php
require '../include/config.php';

// Get the equipment ID from the form or URL parameter
$equipmentId = isset($_GET['equipment_id']) ? $_GET['equipment_id'] : '';
$equipmentId = isset($_POST['equipment_id']) ? $_POST['equipment_id'] : $equipmentId;
$equipmentId = mysqli_real_escape_string($conn, $equipmentId);

$getSupplierIdSql = "SELECT supplier_id FROM equipment WHERE equipment_id = '$equipmentId'";
$result = $conn->query($getSupplierIdSql);

if ($result && $row = $result->fetch_assoc()) {
    $supplierId = $row['supplier_id'];
} else {
    // Handle the case where the supplier ID is not found
    $supplierId = ''; // You can set a default value or handle it based on your logic
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pricePerUnit = $_POST['price_per_unit'];
    $quantity = $_POST['quantity'];
    $purchaseDate = $_POST['purchase_date'];

    // Verifications
    if ($pricePerUnit < 0 || $quantity < 0) {
        showErrorAlert('Price and quantity must not be negative.',$equipmentId);
        exit;
    }

    // Format price to always have two decimal places
    $pricePerUnit = number_format((float)$pricePerUnit, 2, '.', '');

    /**if (strtotime($expirationDate) <= strtotime($purchaseDate)) {
        showErrorAlert('Expiration date must be after the purchase date.',$equipmentId);
        exit;
    }**/

    $currentDate = date("Y-m-d");
    if (strtotime($purchaseDate) > strtotime($currentDate)) {
        showErrorAlert('Purchase date must not be after the current date.',$equipmentId);
        exit;
    }

    $checkInvoiceSql = "(
        SELECT invoice_no 
        FROM batch b
        JOIN equipment e ON b.equipment_id = e.equipment_id
        WHERE b.purchase_date = '$purchaseDate'
        AND e.supplier_id = '$supplierId'
        LIMIT 1
    )
    UNION
    (
        SELECT invoice_no 
        FROM batch b
        JOIN medicine m ON b.medicine_id = m.medicine_id
        WHERE b.purchase_date = '$purchaseDate'
        AND m.supplier_id = '$supplierId'
        LIMIT 1
    )";
    $checkInvoiceResult = $conn->query($checkInvoiceSql);
    
    if ($checkInvoiceResult) {
        // Check if the query was successful
        if ($checkInvoiceResult->num_rows > 0) {
            // Invoice exists in the batch table, reuse the existing invoice number
            $row = $checkInvoiceResult->fetch_assoc();
            $invoiceNo = $row['invoice_no'];
    
            // Calculate new cost based on quantity and price per unit
            $newCost = $quantity * $pricePerUnit;
    
            // Update the cost in the existing invoice in the invoice table by adding the new cost
            $updateInvoiceSql = "UPDATE invoice SET cost = cost + '$newCost' WHERE invoice_no = '$invoiceNo'";
    
            if ($conn->query($updateInvoiceSql) !== TRUE) {
                showErrorAlert('Error updating invoice: ' . $conn->error);
                exit;
            }
        } else {
            // Invoice does not exist in the batch table, create a new invoice
            $autoGeneratedInvoiceIdSql = "SELECT MAX(CAST(SUBSTRING(invoice_no, 4) AS SIGNED)) AS max_id FROM invoice";
            $result = $conn->query($autoGeneratedInvoiceIdSql);
            
            if ($result && $row = $result->fetch_assoc()) {
                // Extract the numeric part and increment
                $nextId = $row['max_id'] + 1;
            
                // Format the next ID as inv00001 (e.g., inv00002)
                $invoiceNo = 'inv' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
            } else {
                $invoiceNo = 'inv00001'; // Default to inv00001 if there is an issue with the database query
            }
            
            // Calculate cost based on quantity and price per unit
            $cost = $quantity * $pricePerUnit;
    
            // Insert data into the invoice table
            $invoiceSql = "INSERT INTO invoice (invoice_no, cost, payment_reference, time_stamp)
                           VALUES ('$invoiceNo', '$cost', 'Equipment_Invoice', NOW())";
    
            if ($conn->query($invoiceSql) !== TRUE) {
                showErrorAlert('Error creating invoice: ' . $conn->error,$equipmentId);
                exit;
            }
        }
    } else {
        showErrorAlert('Error in query: ' . $conn->error,$equipmentId);
        exit;
    }

    // Generate an auto-incremented Batch ID
    $autoGeneratedBatchIdSql = "SELECT MAX(CAST(SUBSTRING(batch_id, 3) AS SIGNED)) AS max_id FROM batch";
    $result = $conn->query($autoGeneratedBatchIdSql);

    if ($result && $row = $result->fetch_assoc()) {
        // Extract the numeric part and increment
        $nextId = $row['max_id'] + 1;
    
        // Format the next ID as btX (e.g., bt00009)
        $batchId = 'bt' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    } else {
        $batchId = 'bt00001'; // Default to bt00001 if there is an issue with the database query
    }
    
    

    // Insert data into the batch table
    $batchSql = "INSERT INTO batch (batch_id, price_punit, quantity, quantity_stock, equipment_id, status, purchase_date, invoice_no)
                 VALUES ('$batchId', '$pricePerUnit', '$quantity', '$quantity', '$equipmentId', 'Unused', '$purchaseDate', '$invoiceNo')";

    if ($conn->query($batchSql) === TRUE) {
        showSuccessAlert("Batch '$batchId' Added Successfully",$equipmentId);
    } else {
        showErrorAlert('Error creating batch: ' . $conn->error);
    }
}

function showSuccessAlert($message,$equipmentId) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Success</title>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
    <body>
        <div class="modal" tabindex="-1" role="dialog" id="successModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Success</h5>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $message; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="redirectToBatchequipment()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $('#successModal').modal('show');
            function redirectToBatchequipment() {
                var equipmentId = "<?php echo $equipmentId; ?>";
                window.location.href = '../batchequipment.php?id=' + equipmentId;
            }
        </script>
    </body>
    </html>
    <?php
    exit();
}

function showErrorAlert($error,$equipmentId) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
    <body>
        <div class="modal" tabindex="-1" role="dialog" id="errorModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Error</h5>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $error; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="redirectToBatchequipment()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $('#errorModal').modal('show');
            function redirectToBatchequipment() {
                var equipmentId = "<?php echo $equipmentId; ?>";
                window.location.href = '../batchequipment.php?id=' + equipmentId;
            }
        </script>
    </body>
    </html>
    <?php
    exit();
}

$conn->close();
?>


