<?php
session_start();
require('includes/../config.php'); // Faili ya kuunganisha na database
require('includes/../header.php'); // Faili ya kuunganisha na database

// Initialize variables for form data
$jumla = $zaka = $sadaka = $s_kambi = $ctf = $shule = $majengo = $idara_ya_wanawake = $idara_ya_elimu = $amo_dorcas = $s_sabato = $kwaya = $idara_ya_vijana = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Pata data kutoka fomu
   $jumla = $_POST['jumla'];
   $zaka = $_POST['zaka'];
   $sadaka = $_POST['sadaka'];
   
   // Hesabu ya Sadaka
   $sadaka_part1 = round($sadaka * 0.58, 2); // 58%
   $sadaka_part2 = round($sadaka * 0.42, 2); // 42%

   // Pata data zingine kutoka fomu
   $s_kambi = $_POST['s_kambi'];
   $ctf = $_POST['ctf'];
   $shule = $_POST['shule'];
   $majengo = $_POST['majengo'];
   $idara_ya_wanawake = $_POST['idara_ya_wanawake'];
   $idara_ya_elimu = $_POST['idara_ya_elimu'];
   $amo_dorcas = $_POST['amo_dorcas'];
   $s_sabato = $_POST['s_sabato'];
   $kwaya = $_POST['kwaya'];
   $idara_ya_vijana = $_POST['idara_ya_vijana'];

   // Kujiandikisha kwenye database
   $sql = "INSERT INTO donations (jumla, zaka, sadaka_part1, sadaka_part2, s_kambi, ctf, shule, majengo, idara_ya_wanawake, idara_ya_elimu, amo_dorcas, s_sabato, kwaya, idara_ya_vijana) 
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

   if ($stmt = $conn->prepare($sql)) {
       // Tumia 'i' kwa integers, 'd' kwa floats
       $stmt->bind_param("iiiiiiiiiddddd", 
           $jumla, 
           $zaka, 
           $sadaka_part1, 
           $sadaka_part2,
           $s_kambi,
           $ctf,
           $shule,
           $majengo,
           $idara_ya_wanawake,
           $idara_ya_elimu,
           $amo_dorcas,
           $s_sabato,
           $kwaya,
           $idara_ya_vijana);
       
       if ($stmt->execute()) {
           echo "<div class='alert alert-success'>Matoleo yamefanikiwa kutumwa!</div>";
           header('Location: index.php'); // Redirect baada ya mafanikio
           exit;
       } else {
           echo "<div class='alert alert-danger'>Kosa: " . htmlspecialchars($stmt->error) . "</div>";
       }
       
       $stmt->close();
   } else {
       echo "<div class='alert alert-danger'>Kosa la kujiandikisha kwenye database: " . htmlspecialchars($conn->error) . "</div>";
   }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fomu ya Michango</title>
    
    <!-- Link ya Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon Pack (Font Awesome) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

    <!-- Container yenye upana mdogo -->
    <div class="container mt-4" style="max-width: 500px;">
        <div class="card shadow-sm rounded p-4">
            <h2 class="text-center mb-4">Fomu ya Michango</h2>
            <form action="your_php_script.php" method="POST">
                
                <div class="row">
                    <!-- Jumla ya Michango (Column 1) -->
                    <div class="col-md-6 mb-3">
                        <label for="jumla" class="form-label small">Jumla ya Michango</label>
                        <input type="number" class="form-control form-control-sm" id="jumla" name="jumla" placeholder="Ingiza Jumla ya Michango">
                    </div>

                    <!-- Zaka (Column 2) -->
                    <div class="col-md-6 mb-3">
                        <label for="zaka" class="form-label small">Zaka</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="fas fa-coins"></i></span>
                            <input type="number" class="form-control" id="zaka" name="zaka" placeholder="Ingiza Zaka">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Sadaka (Column 1) -->
                    <div class="col-md-6 mb-3">
                        <label for="sadaka" class="form-label small">Sadaka</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                            <input type="number" class="form-control" id="sadaka" name="sadaka" placeholder="Ingiza Sadaka">
                        </div>
                    </div>

                    <!-- Kambi (Column 2) -->
                    <div class="col-md-6 mb-3">
                        <label for="s_kambi" class="form-label small">Kambi</label>
                        <input type="number" class="form-control form-control-sm" id="s_kambi" name="s_kambi" placeholder="Kambi">
                    </div>
                </div>

                <div class="row">
                    <!-- CTF (Column 1) -->
                    <div class="col-md-6 mb-3">
                        <label for="ctf" class="form-label small">CTF</label>
                        <input type="number" class="form-control form-control-sm" id="ctf" name="ctf" placeholder="CTF">
                    </div>

                    <!-- Shule (Column 2) -->
                    <div class="col-md-6 mb-3">
                        <label for="shule" class="form-label small">Shule</label>
                        <input type="number" class="form-control form-control-sm" id="shule" name="shule" placeholder="Shule">
                    </div>
                </div>

                <div class="row">
                    <!-- Majengo (Column 1) -->
                    <div class="col-md-6 mb-3">
                        <label for="majengo" class="form-label small">Majengo</label>
                        <input type="number" class="form-control form-control-sm" id="majengo" name="majengo" placeholder="Majengo">
                    </div>

                    <!-- Idara ya Wanawake (Column 2) -->
                    <div class="col-md-6 mb-3">
                        <label for="idara_ya_wanawake" class="form-label small">Idara ya Wanawake</label>
                        <input type="number" class="form-control form-control-sm" id="idara_ya_wanawake" name="idara_ya_wanawake" placeholder="Idara ya Wanawake">
                    </div>
                </div>

                <div class="row">
                    <!-- Idara ya Elimu (Column 1) -->
                    <div class="col-md-6 mb-3">
                        <label for="idara_ya_elimu" class="form-label small">Idara ya Elimu</label>
                        <input type="number" class="form-control form-control-sm" id="idara_ya_elimu" name="idara_ya_elimu" placeholder="Idara ya Elimu">
                    </div>

                    <!-- Amo Dorcas (Column 2) -->
                    <div class="col-md-6 mb-3">
                        <label for="amo_dorcas" class="form-label small">Amo Dorcas</label>
                        <input type="number" class="form-control form-control-sm" id="amo_dorcas" name="amo_dorcas" placeholder="Amo Dorcas">
                    </div>
                </div>

                <div class="row">
                    <!-- Sadaka ya Sabato (Column 1) -->
                    <div class="col-md-6 mb-3">
                        <label for="s_sabato" class="form-label small">Sadaka ya Sabato</label>
                        <input type="number" class="form-control form-control-sm" id="s_sabato" name="s_sabato" placeholder="Sadaka ya Sabato">
                    </div>

                    <!-- Kwaya (Column 2) -->
                    <div class="col-md-6 mb-3">
                        <label for="kwaya" class="form-label small">Kwaya</label>
                        <input type="number" class="form-control form-control-sm" id="kwaya" name="kwaya" placeholder="Kwaya">
                    </div>
                </div>

                <div class="row">
                    <!-- Idara ya Vijana (Column 1) -->
                    <div class="col-md-6 mb-3">
                        <label for="idara_ya_vijana" class="form-label small">Idara ya Vijana</label>
                        <input type="number" class="form-control form-control-sm" id="idara_ya_vijana" name="idara_ya_vijana" placeholder="Idara ya Vijana">
                    </div>
                </div>

                <!-- Submit button -->
                <div class="d-flex justify-content-between mt-3">
                    <!-- Button ya kurudi nyuma -->
                    <a href="../index.php" class="btn btn-secondary btn-sm">Kurudi Nyuma</a>

                    <!-- Button ya kutuma -->
                    <button type="submit" class="btn btn-primary btn-sm">Tuma Michango</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Bootstrap JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
