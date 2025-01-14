<?php
require('../admin/includes/config.php'); // Uunganisho wa database

// Get the report details based on ID
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM donations WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Calculate the total of all the amounts
        $jumla = floatval($row['jumla']);
        $zaka = floatval($row['zaka']);
        $sadaka_58 = floatval($row['sadaka_58']);
        $sadaka_42 = floatval($row['sadaka_42']);
        $s_kambi = floatval($row['s_kambi']);
        $ctf = floatval($row['ctf']);
        $shule = floatval($row['shule']);
        $majengo = floatval($row['majengo']);
        $idara_ya_wanawake = floatval($row['idara_ya_wanawake']);
        $idara_ya_elimu = floatval($row['idara_ya_elimu']);
        $amo_dorcas = floatval($row['amo_dorcas']);
        $s_sabato = floatval($row['s_sabato']);
        $kwaya = floatval($row['kwaya']);
        $idara_ya_vijana = floatval($row['idara_ya_vijana']);

        // Sum all amounts
        $total = $jumla + $zaka + $sadaka_58 + $sadaka_42 + $s_kambi + $ctf + $shule + $majengo + $idara_ya_wanawake + $idara_ya_elimu + $amo_dorcas + $s_sabato + $kwaya + $idara_ya_vijana;

        // Add style for a better appearance
        echo "<style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #f7f8fc;
                    margin: 0;
                    padding: 20px 0;
                    display: flex;
                    justify-content: center;
                    align-items: flex-start;
                    min-height: 90vh; /* Adjusted height to see title */
                }

                .container {
                    width: 100%;
                    max-width: 800px;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 15px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    gap: 15px;
                }

                h2 {
                    text-align: center;
                    font-size: 28px;
                    color: #333;
                    margin-bottom: 20px;
                    font-weight: 600;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th, td {
                    padding: 12px;
                    text-align: left;
                    border: 1px solid #ddd;
                    font-size: 16px;
                }

                th {
                    background-color: #007bff;
                    color: white;
                    text-transform: uppercase;
                }

                td {
                    background-color: #f9f9f9;
                    color: #555;
                }

                tr:nth-child(even) td {
                    background-color: #f1f1f1;
                }

                .total-row {
                    font-weight: bold;
                    background-color: #e1f7d5;
                }

                .alert {
                    color: red;
                    text-align: center;
                    margin-top: 20px;
                    padding: 15px;
                    background-color: #f8d7da;
                    border-radius: 5px;
                }
            </style>";

        // Display the report details in a table
        echo "<div class='container'>
                <h2>Ripoti ya Michango</h2>
                <table>
                    <tr><th>Jumla</th><td>{$row['jumla']}</td></tr>
                    <tr><th>Zaka</th><td>{$row['zaka']}</td></tr>
                    <tr><th>Sadaka Part 1</th><td>{$row['sadaka_58']}</td></tr>
                    <tr><th>Sadaka Part 2</th><td>{$row['sadaka_42']}</td></tr>
                    <tr><th>Sadaka ya Kambi</th><td>{$row['s_kambi']}</td></tr>
                    <tr><th>CTF</th><td>{$row['ctf']}</td></tr>
                    <tr><th>Shule</th><td>{$row['shule']}</td></tr>
                    <tr><th>Majengo</th><td>{$row['majengo']}</td></tr>
                    <tr><th>Idara ya Wanawake</th><td>{$row['idara_ya_wanawake']}</td></tr>
                    <tr><th>Idara ya Elimu</th><td>{$row['idara_ya_elimu']}</td></tr>
                    <tr><th>Amo Dorcas</th><td>{$row['amo_dorcas']}</td></tr>
                    <tr><th>Sadaka ya Sabato</th><td>{$row['s_sabato']}</td></tr>
                    <tr><th>Kwaya</th><td>{$row['kwaya']}</td></tr>
                    <tr><th>Idara ya Vijana</th><td>{$row['idara_ya_vijana']}</td></tr>
                    <tr class='total-row'>
                        <th>Total</th>
                        <td>{$total}</td>
                    </tr>
                </table>
              </div>";
    } else {
        echo "<div class='alert'>Ripoti haipo.</div>";
    }
}
?>
