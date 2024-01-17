<?php
require 'connection.php';

$equipmentId = isset($_GET['equipment_id']) ? $_GET['equipment_id'] : '';
$batchId = isset($_GET['batch_id']) ? $_GET['batch_id'] : '';

// Fetch the current status and quantity stock of the clicked batch
$currentStatusSql = "SELECT status, quantity_stock FROM batch WHERE equipment_id = '$equipmentId' AND batch_id = '$batchId'";
$result = $conn->query($currentStatusSql);

if ($result && $row = $result->fetch_assoc()) {
    $currentStatus = $row['status'];
    $quantityStock = $row['quantity_stock'];

    // Toggle the status between "Used" and "Unused"
    $newStatus = ($currentStatus == 'Used') ? 'Unused' : 'Used';

    // Update the status for the clicked batch
    $updateBatchSql = "UPDATE batch SET status = '$newStatus' WHERE equipment_id = '$equipmentId' AND batch_id = '$batchId'";
    $conn->query($updateBatchSql);

    // If the new status is "Used," update other batches to "Unused"
    if ($newStatus == 'Used') {
        $updateOtherBatchesSql = "UPDATE batch SET status = 'Unused' WHERE equipment_id = '$equipmentId' AND batch_id != '$batchId'";
        $conn->query($updateOtherBatchesSql);

        // Check if the quantity stock is more than 0
        if ($quantityStock > 0) {
            // Update the equipment status to "Active"
            $updateEquipmentStatusSql = "UPDATE equipment SET equipment_status = 'Active' WHERE equipment_id = '$equipmentId'";
            $conn->query($updateEquipmentStatusSql);
        }
    } elseif ($newStatus == 'Unused') {
        // If the new status is "Unused," update the equipment status to "Inactive"
        $updateEquipmentStatusSql = "UPDATE equipment SET equipment_status = 'Inactive' WHERE equipment_id = '$equipmentId'";
        $conn->query($updateEquipmentStatusSql);
    }
}

// Redirect back to the batch list page
header("Location: batchequipment.php?id=$equipmentId");
exit;
?>
