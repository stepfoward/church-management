<?php
require('../admin/includes/config.php'); // Uunganisho wa database

// Delete report
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM donations WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Ripoti imefutwa kwa mafanikio!";
        // Redirect back to the report list
        header("Location: weekly_report.php");
    } else {
        echo "Makosa: " . $conn->error;
    }
}
?>
