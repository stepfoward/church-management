<?php
$servername = "localhost";
$username = "root";    // Adjust if you have different credentials
$password = "";        // Adjust if you have a password
$dbname = "church_donations"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

