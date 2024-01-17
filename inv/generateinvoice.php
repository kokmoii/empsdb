<?php
// Include your database connection logic here
require 'connection.php';

// Function to fetch batch details from the database
function getBatchDetails($batchId) {
    global $conn; // Assuming $conn is your database connection

    $batchId = mysqli_real_escape_string($conn, $batchId);
    $sql = "SELECT * FROM batch WHERE batch_id = '$batchId'";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return $row;
    }

    return null;
}

// Function to generate an invoice for selected batches and store it in the database
function generateAndStoreInvoice($selectedBatches) {
    global $conn; // Assuming $conn is your database connection

    // Calculate total cost for all selected batches
    $totalCost = 0;
    foreach ($selectedBatches as $batchId) {
        $batchDetails = getBatchDetails($batchId);

        if ($batchDetails) {
            $totalCost += $batchDetails['total_cost'];
        }
    }

    // Example payment reference and timestamp (replace with actual logic)
    $paymentReference = 'PAY123';
    $timestamp = date('Y-m-d H:i:s');

    // Insert invoice information into the database
    $insertInvoiceSql = "INSERT INTO invoice (cost, payment_reference, time_stamp) 
                         VALUES ('$totalCost', '$paymentReference', '$timestamp')";

    if ($conn->query($insertInvoiceSql) === TRUE) {
        // Get the invoice number of the newly inserted invoice
        $invoiceNo = $conn->insert_id;

        // Associate selected batches with the generated invoice
        foreach ($selectedBatches as $batchId) {
            $updateBatchSql = "UPDATE batches SET invoice_no = '$invoiceNo' WHERE batch_id = '$batchId'";
            $conn->query($updateBatchSql);
        }

        echo "Invoice generated and stored successfully. Invoice Number: $invoiceNo\n";
    } else {
        echo "Error creating invoice: " . $conn->error;
    }
}

// Example usage
$selectedBatches = ['ABC-123', 'XYZ-456']; // Replace with your actual batch IDs
generateAndStoreInvoice($selectedBatches);
?>
