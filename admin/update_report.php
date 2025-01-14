<?php
require('../admin/includes/config.php'); // Uunganisho wa database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve values from the form
    $id = $_POST['id'];
    $jumla = $_POST['jumla'];
    $zaka = $_POST['zaka'];
    $sadaka_58 = $_POST['sadaka_58'];
    $sadaka_42 = $_POST['sadaka_42'];
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

    // Prepare the SQL query to update the record in the database
    $sql = "UPDATE donations SET 
                jumla = '$jumla', 
                zaka = '$zaka', 
                sadaka_58 = '$sadaka_58', 
                sadaka_42 = '$sadaka_42', 
                s_kambi = '$s_kambi', 
                ctf = '$ctf', 
                shule = '$shule', 
                majengo = '$majengo', 
                idara_ya_wanawake = '$idara_ya_wanawake', 
                idara_ya_elimu = '$idara_ya_elimu', 
                amo_dorcas = '$amo_dorcas', 
                s_sabato = '$s_sabato', 
                kwaya = '$kwaya', 
                idara_ya_vijana = '$idara_ya_vijana'
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Ripoti ilihaririwa kwa mafanikio.</div>";
    } else {
        echo "<div class='alert alert-danger'>Kumekuwa na tatizo katika kuhifadhi taarifa.</div>";
    }
}
?>
