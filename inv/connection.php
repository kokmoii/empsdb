<?php

$servername = "localhost";
$username = "root";
$password = "root123";
$dbname = "inv";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//echo("Database connected Successfully!");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>