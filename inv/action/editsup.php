<?php
include('../connection.php');

function isValidPhoneNumber($phone) {
    // Add your validation logic for the phone number format here
    // For example, you can use a regular expression
    $pattern = "/^0[0-9]{1,2}[0-9]{7,8}$/";
    return preg_match($pattern, $phone);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplierID = $_POST['supplier_id'];
    $supplierName = $_POST['supplier_name'];
    $supplierPhone = $_POST['supplier_phone'];
    $supplierEmail = $_POST['supplier_email'];
    $supplierAddress = $_POST['supplier_address'];
    $supplierStatus = $_POST['supplier_status'];

    // Validate phone number format
    if (!isValidPhoneNumber($supplierPhone)) {
        showErrorPopup('Invalid phone number format. Please enter a valid phone number.');
    } else {
        // Update data in the database
        $sql = "UPDATE supplier SET 
                supplier_name = '$supplierName',
                supplier_phone = '$supplierPhone',
                supplier_email = '$supplierEmail',
                supplier_address = '$supplierAddress',
                supplier_status = '$supplierStatus'
                WHERE supplier_id = '$supplierID'";

        if ($conn->query($sql) === TRUE) {
            showSuccessPopup("Supplier $supplierName updated successfully");
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
                window.location.href = '../supplier.php';
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
                window.location.href = '../supplier.php';
            }
        </script>
    </body>
    </html>
    <?php
    exit();
}

$conn->close();
?>
