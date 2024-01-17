<?php
include('../include/config.php');

function isDuplicateName($name, $id) {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM equipment WHERE equipment_name = '$name' AND equipment_id != '$id'";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['count'] > 0;
    }

    return false;
}

function isDuplicateDescription($desc, $id) {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM equipment WHERE equipment_desc = '$desc' AND equipment_id != '$id'";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['count'] > 0;
    }

    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipmentID = $_POST['equipment_id'];
    $equipmentName = $_POST['equipment_name'];
    $equipmentDesc = $_POST['equipment_desc'];
    $equipmentStatus = $_POST['equipment_status'];
    $supplierID = $_POST['supplier_id'];

    // Validate data or perform other necessary checks

    // Check for duplicate name
    if (isDuplicateName($equipmentName, $equipmentID)) {
        showErrorPopup("Duplicate equipment name. Please choose a different name.");
    }
    // Check for duplicate description
    elseif (isDuplicateDescription($equipmentDesc, $equipmentID)) {
        showErrorPopup("Duplicate equipment description. Please choose a different description.");
    }
    // Update data in the database
    else {
        $sql = "UPDATE equipment SET 
                equipment_name = '$equipmentName',
                equipment_desc = '$equipmentDesc',
                equipment_status = '$equipmentStatus',
                supplier_id = '$supplierID'
                WHERE equipment_id = '$equipmentID'";

        if ($conn->query($sql) === TRUE) {
            showSuccessPopup("equipment $equipmentName updated successfully");
        } else {
            showErrorPopup("Error updating record: " . $conn->error);
        }
    }
}

function showSuccessPopup($message) {
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $message; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="redirectToSupplierList()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $('#successModal').modal('show');
            function redirectToSupplierList() {
                window.location.href = '../equipment.php';
            }
        </script>
    </body>
    </html>
    <?php
    exit();
}

function showErrorPopup($error) {
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $error; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="redirectToSupplierList()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $('#errorModal').modal('show');
            function redirectToSupplierList() {
                window.location.href = '../equipment.php';
            }
        </script>
    </body>
    </html>
    <?php
    exit();
}

$conn->close();
?>
