<?php
require('../admin/includes/config.php'); // Database connection
require('../admin/includes/header.php'); // Include your header

// Check if 'id' is provided in the URL
if (!isset($_GET['id'])) {
    die('ID ya michango haijapatikana.');
}

$id = $_GET['id'];

// Fetch donation details by ID
$sql = "SELECT * FROM donations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Michango haikupatikana.');
}

$donation = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tazama Michango</title>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Tazama Michango - <?php echo $donation['jina_kamili']; ?></h3>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td><?php echo $donation['id']; ?></td>
            </tr>
            <tr>
                <th>Jina Kamili</th>
                <td><?php echo $donation['jina_kamili']; ?></td>
            </tr>
            <tr>
                <th>Jumla</th>
                <td><?php echo $donation['jumla']; ?></td>
            </tr>
            <tr>
                <th>Zaka</th>
                <td><?php echo $donation['zaka']; ?></td>
            </tr>
            <tr>
                <th>Sadaka</th>
                <td><?php echo $donation['sadaka']; ?></td>
            </tr>
            <tr>
                <th>Sadaka 58%</th>
                <td><?php echo $donation['sadaka_58']; ?></td>
            </tr>
            <tr>
                <th>Sadaka 42%</th>
                <td><?php echo $donation['sadaka_42']; ?></td>
            </tr>
            <tr>
                <th>Kambi</th>
                <td><?php echo $donation['s_kambi']; ?></td>
            </tr>
            <tr>
                <th>CTF</th>
                <td><?php echo $donation['ctf']; ?></td>
            </tr>
            <tr>
                <th>Shule</th>
                <td><?php echo $donation['shule']; ?></td>
            </tr>
            <tr>
                <th>Majengo</th>
                <td><?php echo $donation['majengo']; ?></td>
            </tr>
            <tr>
                <th>Idara ya Wanawake</th>
                <td><?php echo $donation['idara_ya_wanawake']; ?></td>
            </tr>
            <tr>
                <th>Idara ya Elimu</th>
                <td><?php echo $donation['idara_ya_elimu']; ?></td>
            </tr>
            <tr>
                <th>Amo Dorcas</th>
                <td><?php echo $donation['amo_dorcas']; ?></td>
            </tr>
            <tr>
                <th>Sadaka ya Sabato</th>
                <td><?php echo $donation['s_sabato']; ?></td>
            </tr>
            <tr>
                <th>Kwaya</th>
                <td><?php echo $donation['kwaya']; ?></td>
            </tr>
            <tr>
                <th>Idara ya Vijana</th>
                <td><?php echo $donation['idara_ya_vijana']; ?></td>
            </tr>
            <tr>
                <th>Tarehe</th>
                <td><?php echo $donation['date']; ?></td>
            </tr>
        </table>

        <a href="edit_donation.php?id=<?php echo $donation['id']; ?>" class="btn btn-warning">Hariri Michango</a>
        <a href="donation_report.php" class="btn btn-secondary">Rudi kwa Ripoti</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
