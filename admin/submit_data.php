<?php
// Include the database connection file
require_once '../admin/includes/config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $jina_kamili = $_POST['jina_kamili'];
    $jumla = $_POST['jumla'];
    $zaka = $_POST['zaka'];
    $sadaka = $_POST['sadaka'];
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

    // Prepare the SQL query to insert the data into the database using prepared statements
    $sql = "INSERT INTO donations (jina_kamili, jumla, zaka, sadaka, sadaka_58, sadaka_42, s_kambi, ctf, shule, majengo, idara_ya_wanawake, idara_ya_elimu, amo_dorcas, s_sabato, kwaya, idara_ya_vijana) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the query
        $stmt->bind_param("ssssssssssssssss", $jina_kamili, $jumla, $zaka, $sadaka, $sadaka_58, $sadaka_42, $s_kambi, $ctf, $shule, $majengo, $idara_ya_wanawake, $idara_ya_elimu, $amo_dorcas, $s_sabato, $kwaya, $idara_ya_vijana);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Data has been successfully submitted!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the query.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuma Taarifa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 750px;
            padding: 15px;
        }
        .form-label {
            font-size: 0.85rem;
        }
        .form-control {
            font-size: 0.85rem;
            padding: 0.4rem;
        }
        .mb-3 {
            margin-bottom: 0.75rem;
        }
        .btn-send {
            width: 100%;
            padding: 0.6rem;
        }
        .form-section {
            margin-bottom: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="h5 text-center mb-3">Tuma Taarifa</h1>
        <form action="submit_data.php" method="post">
            <!-- First Section -->
            <div class="form-section">
                <h6>Details</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jina_kamili" class="form-label">Jina Kamili:</label>
                        <input type="text" id="jina_kamili" name="jina_kamili" class="form-control form-control-sm" placeholder="Jina Kamili">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jumla" class="form-label">Jumla:</label>
                        <input type="text" id="jumla" name="jumla" class="form-control form-control-sm" placeholder="Jumla" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="zaka" class="form-label">Zaka:</label>
                        <input type="number" step="0.01" id="zaka" name="zaka" class="form-control form-control-sm" placeholder="Zaka" oninput="calculateTotal()">
                    </div>
                </div>
            </div>

            <!-- Second Section -->
            <div class="form-section">
                <h6>Sadaka Breakdown</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sadaka" class="form-label">Sadaka:</label>
                        <input type="number" step="0.01" id="sadaka" name="sadaka" class="form-control form-control-sm" placeholder="Sadaka" oninput="calculateTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sadaka_58" class="form-label">Sadaka 58%:</label>
                        <input type="text" id="sadaka_58" name="sadaka_58" class="form-control form-control-sm" placeholder="Sadaka 58%" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sadaka_42" class="form-label">Sadaka 42%:</label>
                        <input type="text" id="sadaka_42" name="sadaka_42" class="form-control form-control-sm" placeholder="Sadaka 42%" readonly>
                    </div>
                </div>
            </div>

            <!-- Third Section -->
            <div class="form-section">
                <h6>Additional Contributions</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="s_kambi" class="form-label">S Kambi:</label>
                        <input type="number" step="0.01" id="s_kambi" name="s_kambi" class="form-control form-control-sm" placeholder="S Kambi" oninput="calculateTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ctf" class="form-label">CTF:</label>
                        <input type="number" step="0.01" id="ctf" name="ctf" class="form-control form-control-sm" placeholder="CTF" oninput="calculateTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="shule" class="form-label">Shule:</label>
                        <input type="number" step="0.01" id="shule" name="shule" class="form-control form-control-sm" placeholder="Shule" oninput="calculateTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="majengo" class="form-label">Majengo:</label>
                        <input type="number" step="0.01" id="majengo" name="majengo" class="form-control form-control-sm" placeholder="Majengo" oninput="calculateTotal()">
                    </div>
                </div>
            </div>

            <!-- Fourth Section -->
            <div class="form-section">
                <h6>Departments</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="idara_ya_wanawake" class="form-label">Idara ya Wanawake:</label>
                        <input type="number" step="0.01" id="idara_ya_wanawake" name="idara_ya_wanawake" class="form-control form-control-sm" placeholder="Idara ya Wanawake" oninput="calculateTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="idara_ya_elimu" class="form-label">Idara ya Elimu:</label>
                        <input type="number" step="0.01" id="idara_ya_elimu" name="idara_ya_elimu" class="form-control form-control-sm" placeholder="Idara ya Elimu" oninput="calculateTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="amo_dorcas" class="form-label">Amo/Dorcas:</label>
                        <input type="number" step="0.01" id="amo_dorcas" name="amo_dorcas" class="form-control form-control-sm" placeholder="Amo Dorcas" oninput="calculateTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="s_sabato" class="form-label">S Sabato:</label>
                        <input type="number" step="0.01" id="s_sabato" name="s_sabato" class="form-control form-control-sm" placeholder="S Sabato" oninput="calculateTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kwaya" class="form-label">Kwaya:</label>
                        <input type="number" step="0.01" id="kwaya" name="kwaya" class="form-control form-control-sm" placeholder="Kwaya" oninput="calculateTotal()">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="idara_ya_vijana" class="form-label">Idara ya Vijana:</label>
                        <input type="number" step="0.01" id="idara_ya_vijana" name="idara_ya_vijana" class="form-control form-control-sm" placeholder="Idara ya Vijana" oninput="calculateTotal()">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-sm btn-send">Tuma</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to calculate Sadaka 58% and 42% and total jumla
        function calculateTotal() {
            var zaka = parseFloat(document.getElementById('zaka').value) || 0;
            var sadaka = parseFloat(document.getElementById('sadaka').value) || 0;
            var sadaka58 = (sadaka * 58) / 100;
            var sadaka42 = (sadaka * 42) / 100;

            document.getElementById('sadaka_58').value = sadaka58.toFixed(2);
            document.getElementById('sadaka_42').value = sadaka42.toFixed(2);

            // Calculate total (jumla)
            var jumla = zaka + sadaka58 + sadaka42;
            jumla += parseFloat(document.getElementById('s_kambi').value) || 0;
            jumla += parseFloat(document.getElementById('ctf').value) || 0;
            jumla += parseFloat(document.getElementById('shule').value) || 0;
            jumla += parseFloat(document.getElementById('majengo').value) || 0;
            jumla += parseFloat(document.getElementById('idara_ya_wanawake').value) || 0;
            jumla += parseFloat(document.getElementById('idara_ya_elimu').value) || 0;
            jumla += parseFloat(document.getElementById('amo_dorcas').value) || 0;
            jumla += parseFloat(document.getElementById('s_sabato').value) || 0;
            jumla += parseFloat(document.getElementById('kwaya').value) || 0;
            jumla += parseFloat(document.getElementById('idara_ya_vijana').value) || 0;

            document.getElementById('jumla').value = jumla.toFixed(2);
        }
    </script>
</body>
</html>
