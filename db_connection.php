<?php
// Database connection details
$servername = "localhost";
$username = "root";  // Default username for XAMPP
$password = "";  // Default password for XAMPP (empty)
$dbname = "ATM_bank_system";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Failed to connect to MYSQL: " . mysqli_connect_error());
}
else {
    echo "Connected to MySQL";
}
?>
