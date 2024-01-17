<?php
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the search query from the AJAX request
    $searchQuery = $_POST["searchQuery"];

    // Escape the search query to prevent SQL injection
    $searchQuery = mysqli_real_escape_string($conn, $searchQuery);

    // Perform a database query to fetch matching suppliers
    $sql = "SELECT supplier_id, supplier_name FROM supplier WHERE supplier_status='Active' AND supplier_name LIKE '%$searchQuery%'";
    
    // If the search query is empty, fetch all suppliers
    if (empty($searchQuery)) {
        $sql = "SELECT supplier_id, supplier_name FROM supplier WHERE supplier_status='Active'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the matching suppliers as options
        while ($row = $result->fetch_assoc()) {
            echo '<div class="supplierOption" data-supplier-id="' . $row['supplier_id'] . '">' . $row['supplier_name'] . '</div>';
        }
    } else {
        // Display a message if no matching suppliers are found
        echo '<div>No matching suppliers found</div>';
    }
}

// Close the database connection
$conn->close();
?>
