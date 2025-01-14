<?php
$servername = "localhost";
$username = "root";    // Adjust if you have different credentials
$password = "";        // Adjust if you have a password
$dbname = "church_donations"; // Your database name

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Display a more descriptive error message
    die("Connection failed: " . $conn->connect_error . ". Please check your database credentials or server status.");
} else {
    // Optionally, log the successful connection (can be enabled for debugging)
    // error_log("Connected to the database successfully on " . date('Y-m-d H:i:s'));
    // echo "Connected successfully"; // This line can be used for debugging
}
?>
