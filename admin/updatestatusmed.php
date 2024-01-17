<?php
include ('include/config.php');

$medicineId = isset($_GET['medicine_id']) ? $_GET['medicine_id'] : '';
$batchId = isset($_GET['batch_id']) ? $_GET['batch_id'] : '';


// Fetch batch details including quantity and expiration date
$batchDetailsSql = "SELECT status, quantity_stock, expiration_date FROM batch WHERE medicine_id = '$medicineId' AND batch_id = '$batchId'";
$result = $conn->query($batchDetailsSql);

if ($result && $row = $result->fetch_assoc()) {
    $currentStatus = $row['status'];
    $quantity = $row['quantity_stock'];
    $expirationDate = $row['expiration_date'];

    // Output for debugging
    echo "Current Status: $currentStatus<br>";
    echo "Quantity: $quantity<br>";
    echo "Expiration Date: $expirationDate<br>";

    // Check if the quantity is not zero and the batch is not expired
    if ($quantity > 0 && strtotime($expirationDate) >= time()) {
        // Output for debugging
        echo "Updating Status...<br>";

        // Toggle the status between "Used" and "Unused"
        $newStatus = ($currentStatus == 'Used') ? 'Unused' : 'Used';

        // Update the status for the clicked batch
        $updateBatchSql = "UPDATE batch SET status = '$newStatus' WHERE medicine_id = '$medicineId' AND batch_id = '$batchId'";
        $conn->query($updateBatchSql);

        // If the new status is "Used," update other batches to "Unused"
        if ($newStatus == 'Used') {
            $updateOtherBatchesSql = "UPDATE batch SET status = 'Unused' WHERE medicine_id = '$medicineId' AND batch_id != '$batchId'";
            $conn->query($updateOtherBatchesSql);

            // Update the medicine status to "Active"
            $updateMedicineStatusSql = "UPDATE medicine SET medicine_status = 'Active' WHERE medicine_id = '$medicineId'";
            $conn->query($updateMedicineStatusSql);
        } elseif ($newStatus == 'Unused') {
            // If the new status is "Unused," update the medicine status to "Inactive"
            $updateMedicineStatusSql = "UPDATE medicine SET medicine_status = 'Inactive' WHERE medicine_id = '$medicineId'";
            $conn->query($updateMedicineStatusSql);
        }

        // Output for debugging
        echo "Status Updated Successfully!<br>";
    } else {
        // Output for debugging
        echo "Conditions not met. Quantity or expiration date issue.<br>";
    }
} else {
    // Output for debugging
    echo "Batch details not found.<br>";
}

// Redirect back to the batch list page
header("Location: batchmedicine.php?id=$medicineId");
exit;
?>
