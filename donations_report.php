<?php
// Jumuisha faili ya uunganisho
require('../admin/includes/config.php'); // Adjust path based on your project structure

function getDonationsReport($conn) {
    // Hesabu jumla za michango kwa kila kipengele
    $sql = "SELECT jumla, zaka, sadaka_part1, sadaka_part2, s_kambi, ctf, shule, majengo, 
                   idara_ya_wanawake, idara_ya_elimu, amo_dorcas, s_sabato, kwaya, idara_ya_vijana 
            FROM donations";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Anza kurudisha ripoti
        echo "<div class='container'>";
        echo "<h2 class='text-center mb-4'>Ripoti ya Michango</h2>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr>
                <th>Jumla</th>
                <th>Zaka</th>
                <th>Sadaka Part 1</th>
                <th>Sadaka Part 2</th>
                <th>Sadaka ya Kambi</th>
                <th>CTF</th>
                <th>Shule</th>
                <th>Majengo</th>
                <th>Idara ya Wanawake</th>
                <th>Idara ya Elimu</th>
                <th>Amo Dorcas</th>
                <th>Sadaka ya Sabato</th>
                <th>Kwaya</th>
                <th>Idara ya Vijana</th>
              </tr></thead>";

        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['jumla']}</td>
                    <td>{$row['zaka']}</td>
                    <td>{$row['sadaka_part1']}</td>
                    <td>{$row['sadaka_part2']}</td>
                    <td>{$row['s_kambi']}</td>
                    <td>{$row['ctf']}</td>
                    <td>{$row['shule']}</td>
                    <td>{$row['majengo']}</td>
                    <td>{$row['idara_ya_wanawake']}</td>
                    <td>{$row['idara_ya_elimu']}</td>
                    <td>{$row['amo_dorcas']}</td>
                    <td>{$row['s_sabato']}</td>
                    <td>{$row['kwaya']}</td>
                    <td>{$row['idara_ya_vijana']}</td>
                  </tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-warning text-center'>Hakuna michango iliyorekodiwa.</div>";
    }
}

// Call the function to display the donations report
getDonationsReport($conn);
?>
