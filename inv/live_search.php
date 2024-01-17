<?php
require 'connection.php';

$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = empty($searchKeyword) ? '' : " WHERE supplier_name LIKE '%$searchKeyword%' OR supplier_phone LIKE '%$searchKeyword%' OR supplier_email LIKE '%$searchKeyword%' OR supplier_address LIKE '%$searchKeyword%' OR supplier_status = '$searchKeyword'";

$sql = "SELECT * FROM supplier" . $searchCondition;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered table-striped">';
    echo '<thead class="thead-dark">';
    echo '<tr><th scope="col">No</th><th scope="col">Name</th><th scope="col">Phone</th><th scope="col">Email</th><th scope="col">Address</th><th scope="col">Status</th><th scope="col">Action</th></tr></thead>';
    echo '<tbody>';

    $rowNumber = 1;
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<th scope="row">' . $rowNumber . '</th>';
        echo '<td>' . $row['supplier_name'] . '</td>';
        echo '<td>' . $row['supplier_phone'] . '</td>';
        echo '<td>' . $row['supplier_email'] . '</td>';
        echo '<td>' . $row['supplier_address'] . '</td>';
        echo '<td>' . $row['supplier_status'] . '</td>';
        echo '<td><a href="editsupplier.php?id=' . $row['supplier_id'] . '" class="btn btn-primary">Edit</a></td>';
        echo '</tr>';
        $rowNumber++;
    }

    echo '</tbody></table>';
} else {
    echo '<p class="alert alert-info">No suppliers found.</p>';
    if (!empty($searchKeyword)) {
        echo '<a href="supplier.php" class="btn btn-secondary">Back to All Suppliers</a>';
    }
}
?>
