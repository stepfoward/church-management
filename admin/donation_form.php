<?php
session_start();
require('../admin/includes/config.php');

// Hakikisha mtumiaji ameingia
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Hifadhi thamani za awali za fomu
$fields = [
    'jumla', 'zaka', 'sadaka', 's_kambi', 'ctf', 'shule',
    'majengo', 'idara_ya_wanawake', 'idara_ya_elimu', 
    'amo_dorcas', 's_sabato', 'kwaya', 'idara_ya_vijana'
];
foreach ($fields as $field) {
    $$field = $_POST[$field] ?? ''; // Hifadhi data ya awali
}

// Ikiwa fomu imetumwa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hesabu sehemu za sadaka
    $sadaka_58 = $sadaka ? round($sadaka * 0.58, 2) : 0; // 58% ya sadaka
    $sadaka_42 = $sadaka ? round($sadaka * 0.42, 2) : 0; // 42% ya sadaka

    // Weka data kwenye jedwali
    $sql = "INSERT INTO donations (jumla, zaka, sadaka_58, sadaka_42, s_kambi, ctf, shule, majengo, idara_ya_wanawake, idara_ya_elimu, amo_dorcas, s_sabato, kwaya, idara_ya_vijana) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iiiiiiiiiddddd", 
        $jumla, $zaka, $sadaka_58, $sadaka_42, 
        $s_kambi, $ctf, $shule, $majengo, 
        $idara_ya_wanawake, $idara_ya_elimu, 
        $amo_dorcas, $s_sabato, $kwaya, $idara_ya_vijana
    );

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Michango imewasilishwa kwa mafanikio!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Kosa: " . $stmt->error . "</div>";
    }

    // Futa maoni ya fomu baada ya kutumwa
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fomu ya Michango</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0d6efd;
            color: #fff;
            border-radius: 12px 12px 0 0;
            text-align: center;
            padding: 20px;
            font-size: 1.3rem;
        }
        .form-floating input {
            height: 40px;
            font-size: 14px;
            padding: 10px;
        }
        .form-floating label {
            color: #495057;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 15px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Fomu ya Michango
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="row g-3">
                        <!-- Field kwa ajili ya jumla -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="jumla" id="jumla" class="form-control" placeholder="Jumla ya Michango" value="<?= htmlspecialchars($jumla) ?>">
                                <label for="jumla">Jumla ya Michango</label>
                            </div>
                        </div>

                        <!-- Zaka -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="zaka" id="zaka" class="form-control" placeholder="Zaka" value="<?= htmlspecialchars($zaka) ?>">
                                <label for="zaka">Zaka</label>
                            </div>
                        </div>

                        <!-- Sadaka -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="sadaka" id="sadaka" class="form-control" placeholder="Sadaka" value="<?= htmlspecialchars($sadaka) ?>">
                                <label for="sadaka">Sadaka (Jumla)</label>
                            </div>
                        </div>

                        <!-- Sadaka ya Kambi -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="s_kambi" id="s_kambi" class="form-control" placeholder="Sadaka ya Kambi" value="<?= htmlspecialchars($s_kambi) ?>">
                                <label for="s_kambi">Sadaka ya Kambi</label>
                            </div>
                        </div>

                        <!-- CTF -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="ctf" id="ctf" class="form-control" placeholder="CTF" value="<?= htmlspecialchars($ctf) ?>">
                                <label for="ctf">CTF</label>
                            </div>
                        </div>

                        <!-- Michango ya Shule -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="shule" id="shule" class="form-control" placeholder="Michango ya Shule" value="<?= htmlspecialchars($shule) ?>">
                                <label for="shule">Michango ya Shule</label>
                            </div>
                        </div>

                        <!-- Mfuko wa Majengo -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="majengo" id="majengo" class="form-control" placeholder="Mfuko wa Majengo" value="<?= htmlspecialchars($majengo) ?>">
                                <label for="majengo">Mfuko wa Majengo</label>
                            </div>
                        </div>

                        <!-- Idara ya Wanawake -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="idara_ya_wanawake" id="idara_ya_wanawake" class="form-control" placeholder="Idara ya Wanawake" value="<?= htmlspecialchars($idara_ya_wanawake) ?>">
                                <label for="idara_ya_wanawake">Idara ya Wanawake</label>
                            </div>
                        </div>

                        <!-- Idara ya Elimu -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="idara_ya_elimu" id="idara_ya_elimu" class="form-control" placeholder="Idara ya Elimu" value="<?= htmlspecialchars($idara_ya_elimu) ?>">
                                <label for="idara_ya_elimu">Idara ya Elimu</label>
                            </div>
                        </div>

                        <!-- Amo Dorcas -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="amo_dorcas" id="amo_dorcas" class="form-control" placeholder="Amo Dorcas" value="<?= htmlspecialchars($amo_dorcas) ?>">
                                <label for="amo_dorcas">Amo Dorcas</label>
                            </div>
                        </div>

                        <!-- Michango ya Sabato -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="s_sabato" id="s_sabato" class="form-control" placeholder="Michango ya Sabato" value="<?= htmlspecialchars($s_sabato) ?>">
                                <label for="s_sabato">Michango ya Sabato</label>
                            </div>
                        </div>

                        <!-- Mfuko wa Kwaya -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="kwaya" id="kwaya" class="form-control" placeholder="Mfuko wa Kwaya" value="<?= htmlspecialchars($kwaya) ?>">
                                <label for="kwaya">Mfuko wa Kwaya</label>
                            </div>
                        </div>

                        <!-- Idara ya Vijana -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" name="idara_ya_vijana" id="idara_ya_vijana" class="form-control" placeholder="Idara ya Vijana" value="<?= htmlspecialchars($idara_ya_vijana) ?>">
                                <label for="idara_ya_vijana">Idara ya Vijana</label>
                            </div>
                        </div>

                        <!-- Button ya Submit -->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary w-100">Tuma Michango</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
