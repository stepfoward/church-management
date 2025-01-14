<?php
require('../admin/includes/config.php'); // Database connection
require('../admin/includes/header.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get data from the form
    $jina_kamili = isset($_POST['jina_kamili']) ? htmlspecialchars(trim($_POST['jina_kamili'])) : '';
    $zaka = isset($_POST['zaka']) ? floatval($_POST['zaka']) : 0;
    $s_kambi = isset($_POST['s_kambi']) ? floatval($_POST['s_kambi']) : 0;
    $ctf = isset($_POST['ctf']) ? floatval($_POST['ctf']) : 0;
    $shule = isset($_POST['shule']) ? floatval($_POST['shule']) : 0;
    $majengo = isset($_POST['majengo']) ? floatval($_POST['majengo']) : 0;
    $idara_ya_wanawake = isset($_POST['idara_ya_wanawake']) ? floatval($_POST['idara_ya_wanawake']) : 0;
    $idara_ya_elimu = isset($_POST['idara_ya_elimu']) ? floatval($_POST['idara_ya_elimu']) : 0;
    $amo_dorcas = isset($_POST['amo_dorcas']) ? floatval($_POST['amo_dorcas']) : 0;
    $s_sabato = isset($_POST['s_sabato']) ? floatval($_POST['s_sabato']) : 0;
    $kwaya = isset($_POST['kwaya']) ? floatval($_POST['kwaya']) : 0;
    $idara_ya_vijana = isset($_POST['idara_ya_vijana']) ? floatval($_POST['idara_ya_vijana']) : 0;
    $date = isset($_POST['date']) ? $_POST['date'] : '';

    // Calculate total and percentages
    $total = $zaka + $s_kambi + $ctf + $shule + $majengo + 
             $idara_ya_wanawake + $idara_ya_elimu + 
             $amo_dorcas + $s_sabato + $kwaya + 
             $idara_ya_vijana;

    // Calculate 58% and 42%
    $sadaka_58 = round($total * 0.58, 2);
    $sadaka_42 = round($total * 0.42, 2);

    // Prepare SQL query to insert data into the donations table
    $sql = $conn->prepare("INSERT INTO donations 
        (jina_kamili, zaka, sadaka_58, sadaka_42, s_kambi, ctf, shule, majengo, 
        idara_ya_wanawake, idara_ya_elimu, amo_dorcas, s_sabato, kwaya, 
        idara_ya_vijana, date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($sql) {
        // Bind parameters
        if (!$sql->bind_param('sdddddddddddddd', 
            $jina_kamili,
            $zaka,
            $sadaka_58,
            $sadaka_42,
            $s_kambi,
            $ctf,
            $shule,
            $majengo,
            $idara_ya_wanawake,
            $idara_ya_elimu,
            $amo_dorcas,
            $s_sabato,
            $kwaya,
            $idara_ya_vijana,
            $date)) {
            echo "<div class='alert alert-danger text-center'>Kosa wakati wa kuunganisha data: " . htmlspecialchars($sql->error) . "</div>";
        }

        // Execute the query
        if ($sql->execute()) {
            echo "<div class='alert alert-success text-center'>Taarifa zimehifadhiwa kwa mafanikio!</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Kosa limetokea wakati wa kutekeleza ombi: " . htmlspecialchars($sql->error) . "</div>";
        }
        
        // Close statement
        $sql->close();
    } else {
        echo "<div class='alert alert-danger text-center'>Kosa limetokea wakati wa kuandaa ombi la SQL: " . htmlspecialchars($conn->error) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Fomu ya Kutuma Michango</title>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-warning text-white text-center">
            <h3>Fomu ya Kutuma Michango</h3>
        </div>
        <div class="card-body p-4">
            <!-- Form ya kutuma michango -->
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="jina_kamili" class="form-label">Jina Kamili</label>
                    <input type="text" name="jina_kamili" id="jina_kamili" class="form-control" placeholder="Ingiza jina lako kamili" required>
                </div>
                <!-- <div class="mb-3">
                    <label for="date" class="form-label">Tarehe ya Michango</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div> -->
                <div class="mb-3">
                    <label for="zaka" class="form-label">Zaka</label>
                    <input type="number" step="0.01" name="zaka" id="zaka" class="form-control" placeholder="Ingiza kiasi cha zaka" required>
                </div>
                <div class="mb-3">
                    <label for="s_kambi" class="form-label">Sadaka ya Kambi</label>
                    <input type="number" step="0.01" name="s_kambi" id="s_kambi" class="form-control" placeholder="Ingiza kiasi cha sadaka ya kambi">
                </div>
                <div class="mb-3">
                    <label for="ctf" class="form-label">CTF</label>
                    <input type="number" step="0.01" name="ctf" id="ctf" class="form-control" placeholder="Ingiza kiasi cha CTF">
                </div>
                <div class='mb-3'>
                    <label for='shule' class='form-label'>Sadaka ya Shule</label>
                    <input type='number' step='0.01' name='shule' id='shule' class='form-control' placeholder='Ingiza kiasi cha sadaka ya shule'>
                </div>
                <div class='mb-3'>
                    <label for='majengo' class='form-label'>Sadaka ya Majengo</label>
                    <input type='number' step='0.01' name='majengo' id='majengo' class='form-control' placeholder='Ingiza kiasi cha sadaka ya majengo'>
                </div>
                <div class='mb-3'>
                    <label for='idara_ya_wanawake' class='form-label'>Idara ya Wanawake</label>
                    <input type='number' step='0.01' name='idara_ya_wanawake' id='idara_ya_wanawake' class='form-control' placeholder='Ingiza kiasi cha sadaka ya wanawake'>
                </div>
                <div class='mb-3'>
                    <label for='idara_ya_elimu' class='form-label'>Idara ya Elimu</label>
                    <input type='number' step='0.01' name='idara_ya_elimu' id='idara_ya_elimu' class='form-control' placeholder='Ingiza kiasi cha sadaka ya elimu'>
                </div>
                <div class='mb-3'>
                    <label for='amo_dorcas' class='form-label'>Amo Dorcas</label>
                    <input type='number' step='0.01' name='amo_dorcas' id='amo_dorcas' class='form-control' placeholder='Ingiza kiasi cha Amo Dorcas'>
                </div>
                <div class='mb-3'>
                    <label for='s_sabato' class='form-label'>Sadaka ya Sabato</label>
                    <input type='number' step='0.01' name='s_sabato' id='s_sabato' class='form-control' placeholder='Ingiza kiasi cha sadaka ya sabato'>
                </div>
                <div class='mb-3'>
                    <label for='kwaya' class='form-label'>Sadaka ya Kwaya</label>
                    <input type='number' step='0.01' name='kwaya' id='kwaya' class='form-control' placeholder='Ingiza kiasi cha sadaka ya kwaya'>
                </div>
                <div class='mb-3'>
                    <label for='idara_ya_vijana' class='form-label'>Idara ya Vijana</label>
                    <input type='number' step='0.01' name='idara_ya_vijana' id='idara_ya_vijana' class='form-control' placeholder='Ingiza kiasi cha sadaka ya vijana'>
                </div>

                <!-- Submit button -->
                <button type='submit' class='btn btn-primary w-100'>Tuma Michango</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
