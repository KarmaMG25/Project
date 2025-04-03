<?php
$host = "localhost";
$username = "root";
$password = "";  // Your MySQL root password (if any)
$database = "jewelry_store";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
