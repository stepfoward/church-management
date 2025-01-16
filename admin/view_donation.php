<?php
require('../admin/includes/config.php'); // Database connection
require('../admin/includes/header.php'); // Include your header

// Get the donation ID from the URL parameter
$donationId = isset($_GET['id']) ? $_GET['id'] : 0;

if ($donationId > 0) {
    // Fetch the donation from the database
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>View Donation</title>
</head>
<body>
    <div class="container mt-5">
        <?php if ($donation): ?>
            <h2 class="text-center">Maelezo ya Michango - <?php echo $donation['jina_kamili']; ?></h2>
            <table class="table table-bordered">
                <tr><th>ID</th><td><?php echo $donation['id']; ?></td></tr>
                <tr><th>Jina Kamili</th><td><?php echo $donation['jina_kamili']; ?></td></tr>
                <tr><th>Jumla</th><td><?php echo $donation['jumla']; ?></td></tr>
                <tr><th>Zaka</th><td><?php echo $donation['zaka']; ?></td></tr>
                <tr><th>Sadaka</th><td><?php echo $donation['sadaka']; ?></td></tr>
                <tr><th>Sadaka 58</th><td><?php echo $donation['sadaka_58']; ?></td></tr>
                <tr><th>Sadaka 42</th><td><?php echo $donation['sadaka_42']; ?></td></tr>
                <tr><th>Sadaka ya Kambi</th><td><?php echo $donation['s_kambi']; ?></td></tr>
                <tr><th>CTF</th><td><?php echo $donation['ctf']; ?></td></tr>
                <tr><th>Shule</th><td><?php echo $donation['shule']; ?></td></tr>
                <tr><th>Majengo</th><td><?php echo $donation['majengo']; ?></td></tr>
                <tr><th>Idara ya Wanawake</th><td><?php echo $donation['idara_ya_wanawake']; ?></td></tr>
                <tr><th>Idara ya Elimu</th><td><?php echo $donation['idara_ya_elimu']; ?></td></tr>
                <tr><th>Amo Dorcas</th><td><?php echo $donation['amo_dorcas']; ?></td></tr>
                <tr><th>Sadaka ya Sabato</th><td><?php echo $donation['s_sabato']; ?></td></tr>
                <tr><th>Kwaya</th><td><?php echo $donation['kwaya']; ?></td></tr>
                <tr><th>Idara ya Vijana</th><td><?php echo $donation['idara_ya_vijana']; ?></td></tr>
                <tr><th>Tarehe</th><td><?php echo $donation['date']; ?></td></tr>
            </table>
            <a href="index.php" class="btn btn-primary">Back to Donations List</a>
        <?php endif; ?>
    </div>
</body>
</html>
