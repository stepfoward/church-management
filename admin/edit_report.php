<?php
require('../admin/includes/config.php'); // Database connection

// Get the donation ID from the URL parameter
$donationId = isset($_GET['id']) ? $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data and update the donation in the database
    $jumla = $_POST['jumla'];
    $zaka = $_POST['zaka'];
    $sadaka = $_POST['sadaka'];
    // Add other fields here
    
    $stmt = $conn->prepare("UPDATE donations SET jumla = ?, zaka = ?, sadaka = ? WHERE id = ?");
    $stmt->bind_param("dddi", $jumla, $zaka, $sadaka, $donationId);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Donation updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to update donation.</div>";
    }
}

// Fetch the current donation details
if ($donationId > 0) {
    $stmt = $conn->prepare("SELECT * FROM donations WHERE id = ?");
    $stmt->bind_param("i", $donationId);
    $stmt->execute();
    $result = $stmt->get_result();
    $donation = $result->fetch_assoc();
    
    if (!$donation) {
        echo "<div class='alert alert-warning'>Donation not found.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>Invalid donation ID.</div>";
}

?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Donation</title>
    <!-- Include your CSS and JS links here -->
</head>
<body>

<div class="container">
    <?php if ($donation): ?>
        <h2>Edit Donation</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="jumla" class="form-label">Jumla</label>
                <input type="number" class="form-control" id="jumla" name="jumla" value="<?php echo $donation['jumla']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="zaka" class="form-label">Zaka</label>
                <input type="number" class="form-control" id="zaka" name="zaka" value="<?php echo $donation['zaka']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="sadaka" class="form-label">Sadaka</label>
                <input type="number" class="form-control" id="sadaka" name="sadaka" value="<?php echo $donation['sadaka']; ?>" required>
            </div>
            <!-- Add other fields as needed -->
            <button type="submit" class="btn btn-success">Update Donation</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
