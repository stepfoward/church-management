<?php
require('../admin/includes/config.php'); // Database connection

// Get the donation ID from the URL parameter
$donationId = isset($_GET['id']) ? $_GET['id'] : 0;

if ($donationId > 0) {
    // Prepare the SQL statement to delete the donation
    $stmt = $conn->prepare("DELETE FROM donations WHERE id = ?");
    $stmt->bind_param("i", $donationId);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Donation deleted successfully!</div>";
        header("Location: index.php"); // Redirect to the donation list page
        exit();
    } else {
        echo "<div class='alert alert-danger'>Failed to delete donation.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>Invalid donation ID.</div>";
}
?>
