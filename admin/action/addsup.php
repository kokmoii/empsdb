<?php
require '../include/config.php';

// Function to generate auto-incremented supplier ID
function generateSupplierID($conn) {
    $sql = "SELECT MAX(CAST(SUBSTRING(supplier_id, 3) AS UNSIGNED)) AS max_id FROM supplier";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $maxID = $row['max_id'];

    if ($maxID === null) {
        return "sp00001"; // Default to sp00001 if there is an issue with the database query
    } else {
        // Format the next ID as spX (e.g., sp00009)
        $newID = 'sp' . str_pad($maxID + 1, 5, '0', STR_PAD_LEFT);
        return $newID;
    }
}


// Function to check for duplicate supplier
function isDuplicateSupplier($conn, $name, $phone, $email) {
    $sql = "SELECT * FROM supplier WHERE supplier_name = '$name' OR supplier_phone = '$phone' OR supplier_email = '$email'";
    $result = $conn->query($sql);

    return ($result->num_rows > 0);
}

// Function to validate phone number format
function isValidPhoneNumber($phone) {
    $pattern = "/^0[0-9]{1,2}[0-9]{7,8}$/";
    return preg_match($pattern, $phone);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplierID = generateSupplierID($conn);
    $supplierName = $_POST['supplier_name'];
    $supplierPhone = $_POST['supplier_phone'];
    $supplierEmail = $_POST['supplier_email'];
    $supplierAddress = $_POST['supplier_address'];
    $supplierStatus = "Active";

    // Validate phone number format
    if (!isValidPhoneNumber($supplierPhone)) {
        showErrorPopup('Invalid phone number format. Please enter a valid phone number.');
    } elseif (isDuplicateSupplier($conn, $supplierName, $supplierPhone, $supplierEmail)) {
        showErrorPopup('Supplier with the same name, phone, or email already exists. Please enter another details.');
    } else {
        $supplierID = generateSupplierID($conn);

        // Insert data into the database
        $sql = "INSERT INTO supplier (supplier_id, supplier_name, supplier_phone, supplier_email, supplier_address, supplier_status)
                VALUES ('$supplierID', '$supplierName', '$supplierPhone', '$supplierEmail', '$supplierAddress', '$supplierStatus')";

        if ($conn->query($sql) === TRUE) {
            showSuccessPopup("Supplier $supplierName Added Successfully");
        } else {
            showErrorPopup("Error: " . $sql . "<br>" . $conn->error);
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
                        <button type="button" class="btn btn-primary" onclick="redirectToAddSupplier()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $('#successModal').modal('show');
            function redirectToAddSupplier() {
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
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $error; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="redirectToAddSupplier()">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>
            $('#errorModal').modal('show');
            function redirectToAddSupplier() {
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
