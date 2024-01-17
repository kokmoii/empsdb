<?php
require '../include/config.php';

function generateMedicineId($conn) {
    // Get the last medicine_id from the database
    $sql = "SELECT MAX(CAST(SUBSTRING(medicine_id, 3) AS UNSIGNED)) AS max_id FROM medicine";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        // Increment the last ID
        $nextId = $row['max_id'] + 1;

        // Format the next ID as md00001, md00002, etc.
        $formattedId = 'md' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        return $formattedId;
    }

    // Default to md00001 if there is an issue with the database query
    return 'md00001';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicineName = $_POST['medicine_name'];
    $medicineDesc = $_POST['medicine_desc'];
    $supplierID = $_POST['supplier_id'];
    $medicineStatus = "Inactive";

    // Check if the supplier exists
    $checkSupplierSql = "SELECT * FROM supplier WHERE supplier_id = '$supplierID'";
    $supplierResult = $conn->query($checkSupplierSql);

    if ($supplierResult->num_rows == 0) {
        echo <<<HTML
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
                            Supplier does not exist. Please add the supplier.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="redirectToAddMedicine()">OK</button>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <script>
                $('#errorModal').modal('show');
                function redirectToAddMedicine() {
                    window.location.href = '../addmedicine.php';
                }
            </script>
        </body>
        </html>
HTML;
        exit();
    }

    // Check for duplicate medicine names
    $checkDuplicateSql = "SELECT * FROM medicine WHERE medicine_name = '$medicineName'";
    $duplicateResult = $conn->query($checkDuplicateSql);

    if ($duplicateResult->num_rows > 0) {
        echo <<<HTML
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
                            Medicine with name '$medicineName' already exists. Please choose a different name.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="redirectToAddMedicine()">OK</button>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <script>
                $('#errorModal').modal('show');
                function redirectToAddMedicine() {
                    window.location.href = '../addmedicine.php';
                }
            </script>
        </body>
        </html>
HTML;
        exit();
    }

    // Generate a new medicine_id
    $newMedicineId = generateMedicineId($conn);

    // Insert data into the medicine table with the generated medicine_id
    $medicineSql = "INSERT INTO medicine (medicine_id, medicine_name, medicine_desc, medicine_status, supplier_id)
                    VALUES ('$newMedicineId', '$medicineName', '$medicineDesc', '$medicineStatus', '$supplierID')";

    if ($conn->query($medicineSql) === TRUE) {
        echo <<<HTML
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
                            Medicine '$medicineName' Added Successfully
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="redirectToMedicinePage()">OK</button>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <script>
                $('#successModal').modal('show');
                function redirectToMedicinePage() {
                    window.location.href = '../medicine.php';
                }
            </script>
        </body>
        </html>
HTML;
        exit();
    } else {
        echo "Error: " . $medicineSql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
