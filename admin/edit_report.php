<?php
require('../admin/includes/config.php'); // Uunganisho wa database

// Get the report details for editing
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM donations WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Add styles for a better form appearance with reduced height
        echo "<style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f9;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: auto;
                    margin: 0;
                    padding: 20px;
                }

                .form-container {
                    background-color: white;
                    padding: 15px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    width: 100%;
                    max-width: 600px;
                    min-height: 600px;
                }

                h1 {
                    text-align: center;
                    color: #333;
                    font-size: 26px;
                    font-weight: bold;
                    margin-bottom: 10px;
                    text-transform: uppercase;
                }

                h2 {
                    text-align: center;
                    color: #333;
                    font-size: 22px;
                    margin-bottom: 15px;
                    font-weight: 600;
                }

                .form-container label {
                    display: block;
                    margin-bottom: 8px;
                    color: #555;
                    font-size: 16px;
                }

                .form-container input[type='text'] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 12px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    font-size: 16px;
                    box-sizing: border-box;
                    transition: all 0.3s ease;
                }

                .form-container input[type='text']:focus {
                    border-color: #4CAF50;
                    outline: none;
                }

                .form-container input[type='submit'] {
                    width: 100%;
                    padding: 12px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    font-size: 18px;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }

                .form-container input[type='submit']:hover {
                    background-color: #45a049;
                }

                .alert {
                    color: red;
                    text-align: center;
                    margin-top: 20px;
                    padding: 10px;
                    background-color: #f8d7da;
                    border-radius: 5px;
                }

            </style>";

        // Display the form to edit the report
        echo "<div class='form-container'>
                <h1>Ripoti ya Michango</h1>
                <h2>Hariri Ripoti</h2>
                <form action='update_report.php' method='POST'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    
                    <label for='jumla'>Jumla:</label>
                    <input type='text' name='jumla' id='jumla' value='{$row['jumla']}' required readonly>
                    
                    <label for='zaka'>Zaka:</label>
                    <input type='text' name='zaka' id='zaka' value='{$row['zaka']}' oninput='updateTotal()' required>
                    
                    <label for='sadaka_58'>Sadaka Part 58:</label>
                    <input type='text' name='sadaka_58' id='sadaka_58' value='{$row['sadaka_58']}' oninput='updateTotal()' required>
                    
                    <label for='sadaka_42'>Sadaka Part 42:</label>
                    <input type='text' name='sadaka_42' id='sadaka_42' value='{$row['sadaka_42']}' oninput='updateTotal()' required>
                    
                    <label for='s_kambi'>Sadaka ya Kambi:</label>
                    <input type='text' name='s_kambi' id='s_kambi' value='{$row['s_kambi']}' oninput='updateTotal()' required>
                    
                    <label for='ctf'>CTF:</label>
                    <input type='text' name='ctf' id='ctf' value='{$row['ctf']}' oninput='updateTotal()' required>
                    
                    <label for='shule'>Shule:</label>
                    <input type='text' name='shule' id='shule' value='{$row['shule']}' oninput='updateTotal()' required>
                    
                    <label for='majengo'>Majengo:</label>
                    <input type='text' name='majengo' id='majengo' value='{$row['majengo']}' oninput='updateTotal()' required>
                    
                    <label for='idara_ya_wanawake'>Idara ya Wanawake:</label>
                    <input type='text' name='idara_ya_wanawake' id='idara_ya_wanawake' value='{$row['idara_ya_wanawake']}' oninput='updateTotal()' required>
                    
                    <label for='idara_ya_elimu'>Idara ya Elimu:</label>
                    <input type='text' name='idara_ya_elimu' id='idara_ya_elimu' value='{$row['idara_ya_elimu']}' oninput='updateTotal()' required>
                    
                    <label for='amo_dorcas'>Amo Dorcas:</label>
                    <input type='text' name='amo_dorcas' id='amo_dorcas' value='{$row['amo_dorcas']}' oninput='updateTotal()' required>
                    
                    <label for='s_sabato'>Sadaka ya Sabato:</label>
                    <input type='text' name='s_sabato' id='s_sabato' value='{$row['s_sabato']}' oninput='updateTotal()' required>
                    
                    <label for='kwaya'>Kwaya:</label>
                    <input type='text' name='kwaya' id='kwaya' value='{$row['kwaya']}' oninput='updateTotal()' required>
                    
                    <label for='idara_ya_vijana'>Idara ya Vijana:</label>
                    <input type='text' name='idara_ya_vijana' id='idara_ya_vijana' value='{$row['idara_ya_vijana']}' oninput='updateTotal()' required>

                    <input type='submit' value='Save Changes'>
                </form>
              </div>";

        // JavaScript to calculate total
        echo "<script>
                function updateTotal() {
                    var zaka = parseFloat(document.getElementById('zaka').value) || 0;
                    var sadaka58 = parseFloat(document.getElementById('sadaka_58').value) || 0;
                    var sadaka42 = parseFloat(document.getElementById('sadaka_42').value) || 0;
                    var sKambi = parseFloat(document.getElementById('s_kambi').value) || 0;
                    var ctf = parseFloat(document.getElementById('ctf').value) || 0;
                    var shule = parseFloat(document.getElementById('shule').value) || 0;
                    var majengo = parseFloat(document.getElementById('majengo').value) || 0;
                    var idaraWanawake = parseFloat(document.getElementById('idara_ya_wanawake').value) || 0;
                    var idaraElimu = parseFloat(document.getElementById('idara_ya_elimu').value) || 0;
                    var amoDorcas = parseFloat(document.getElementById('amo_dorcas').value) || 0;
                    var sabato = parseFloat(document.getElementById('s_sabato').value) || 0;
                    var kwaya = parseFloat(document.getElementById('kwaya').value) || 0;
                    var vijana = parseFloat(document.getElementById('idara_ya_vijana').value) || 0;

                    var total = zaka + sadaka58 + sadaka42 + sKambi + ctf + shule + majengo + idaraWanawake + idaraElimu + amoDorcas + sabato + kwaya + vijana;
                    document.getElementById('jumla').value = total.toFixed(2);
                }
              </script>";

    } else {
        echo "<div class='alert'>Ripoti haipo.</div>";
    }
}
?>
