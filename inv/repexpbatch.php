<?php include 'connection.php ';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expired Batches Report</title>
    <!-- Add your CSS stylesheets or Bootstrap links here if needed -->
</head>
<body>

    <h1>Expired Batches Report</h1>

    <?php
    // Fetch expired batches
    $expiredBatchesSql = "SELECT * FROM batch WHERE expiration_date < CURDATE()";
    $expiredBatchesResult = $conn->query($expiredBatchesSql);

    if ($expiredBatchesResult && $expiredBatchesResult->num_rows > 0) {
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr><th>Batch ID</th><th>Medicine/Equipment ID</th><th>Expiration Date</th></tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $expiredBatchesResult->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['batch_id'] . '</td>';
            echo '<td>' . $row['medicine_id'] . '</td>'; // Change this to 'equipment_id' if applicable
            echo '<td>' . $row['expiration_date'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No expired batches found.</p>';
    }
    ?>

</body>
</html>