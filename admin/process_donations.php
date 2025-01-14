<?php
session_start(); // Anza session
require('includes/../config.php'); // Faili ya kuunganisha na database
require('includes/../header.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pata data kutoka fomu na hakikisha ni salama
    $jumla = isset($_POST['jumla']) ? intval($_POST['jumla']) : 0;
    $zaka = isset($_POST['zaka']) ? intval($_POST['zaka']) : 0;
    $sadaka = isset($_POST['sadaka']) ? floatval($_POST['sadaka']) : 0.0;
    
    // Hesabu ya Sadaka
    $sadaka_part1 = round($sadaka * 0.58, 2); // 58%
    $sadaka_part2 = round($sadaka * 0.42, 2); // 42%

    // Pata data zingine kutoka fomu na hakikisha ni salama
    $s_kambi = isset($_POST['s_kambi']) ? intval($_POST['s_kambi']) : 0;
    $ctf = isset($_POST['ctf']) ? intval($_POST['ctf']) : 0;
    $shule = isset($_POST['shule']) ? intval($_POST['shule']) : 0;
    $majengo = isset($_POST['majengo']) ? intval($_POST['majengo']) : 0;
    $idara_ya_wanawake = isset($_POST['idara_ya_wanawake']) ? intval($_POST['idara_ya_wanawake']) : 0;
    $idara_ya_elimu = isset($_POST['idara_ya_elimu']) ? intval($_POST['idara_ya_elimu']) : 0;
    $amo_dorcas = isset($_POST['amo_dorcas']) ? intval($_POST['amo_dorcas']) : 0;
    $s_sabato = isset($_POST['s_sabato']) ? intval($_POST['s_sabato']) : 0;
    $kwaya = isset($_POST['kwaya']) ? intval($_POST['kwaya']) : 0;
    $idara_ya_vijana = isset($_POST['idara_ya_vijana']) ? intval($_POST['idara_ya_vijana']) : 0;

    // Kujiandikisha kwenye database
    $sql = "INSERT INTO donations 
            (jumla, zaka, sadaka_part1, sadaka_part2, s_kambi, ctf, shule, majengo, 
             idara_ya_wanawake, idara_ya_elimu, amo_dorcas, s_sabato, kwaya, idara_ya_vijana) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Tumia prepared statement na bind_param
    if ($stmt = $conn->prepare($sql)) {
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
        
        // Jaribu kuifanya execute
        if ($stmt->execute()) {
            echo "Matoleo yamefanikiwa kutumwa!";
            header('Location: index.php'); // Redirect baada ya mafanikio
            exit;
        } else {
            echo "Kosa: " . $stmt->error; // Onyesha kosa
        }
        
        $stmt->close();
    } else {
        echo "Kosa la kujiandikisha kwenye database: " . $conn->error;
    }
}

$conn->close();
?>
