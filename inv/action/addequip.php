<?php
include('../connection.php');

function generateEquipmentId($conn) {
    $sql = "SELECT MAX(CAST(SUBSTRING(equipment_id, 3) AS SIGNED)) AS max_id FROM equipment";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $nextId = $row['max_id'] + 1;
        $formattedId = 'eq' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        return $formattedId;
    }

    return 'eq00001';
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipmentName = $_POST['equipment_name'];
    $equipmentDesc = $_POST['equipment_desc'];
    $supplierID = $_POST['supplier_id'];
    $equipmentStatus= "Inactive";

    $checkSupplierSql = "SELECT * FROM supplier WHERE supplier_id = '$supplierID'";
    $supplierResult = $conn->query($checkSupplierSql);

    if ($supplierResult->num_rows == 0) {
        showErrorPopup('Supplier does not exist. Please add the supplier.');
        exit;
    }

    $checkDuplicateSql = "SELECT * FROM equipment WHERE equipment_name = '$equipmentName'";
    $duplicateResult = $conn->query($checkDuplicateSql);

    if ($duplicateResult->num_rows > 0) {
        showErrorPopup("Equipment with name '$equipmentName' already exists. Please choose a different name.");
        exit;
    }

    $newEquipmentId = generateEquipmentId($conn);

    $equipmentSql = "INSERT INTO equipment (equipment_id, equipment_name, equipment_desc, equipment_status, supplier_id)
                    VALUES ('$newEquipmentId', '$equipmentName', '$equipmentDesc','$equipmentStatus', '$supplierID')";

    if ($conn->query($equipmentSql) === TRUE) {
        showSuccessPopup("Equipment '$equipmentName' Added Successfully");
    } else {
        showErrorPopup("Error: " . $equipmentSql . "<br>" . $conn->error);
    }
}

function showSuccessPopup($message) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Supplier Added</title>
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
                        <button type="button" class="btn btn-primary" onclick="redirectToAddEquipment()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $('#successModal').modal('show');
            function redirectToAddEquipment() {
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
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $error; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="redirectToAddEquipment()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $('#errorModal').modal('show');
            function redirectToAddEquipment() {
                window.location.href = '../addequipment.php';
            }
        </script>
    </body>
    </html>
    <?php
    exit();
}

$conn->close();
?>
