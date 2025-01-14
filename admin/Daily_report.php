<?php
require('../admin/includes/config.php'); // Uunganisho wa database
require('../admin/includes/header.php');

// Function to get donations for the specified day
function getDonationsByDay($conn, $date) {
    // Prepared SQL query to avoid SQL injection
    $sql = $conn->prepare("SELECT * FROM donations WHERE DATE(date) = ?");
    $sql->bind_param('s', $date);
    $sql->execute();
    $result = $sql->get_result();

    // Variables for totals
    $total_jumla = 0;
    $total_zaka = 0;
    $total_sadaka_58 = 0;
    $total_sadaka_42 = 0;
    $total_s_kambi = 0;
    $total_ctf = 0;
    $total_shule = 0;
    $total_majengo = 0;
    $total_idara_ya_wanawake = 0;
    $total_idara_ya_elimu = 0;
    $total_amo_dorcas = 0;
    $total_s_sabato = 0;
    $total_kwaya = 0;
    $total_idara_ya_vijana = 0;

    echo "<div class='container mt-5'>";
    echo "<div class='card shadow-lg border-0'>";
    echo "<div class='card-header bg-warning text-white text-center'>";
    echo "<h3>Ripoti ya Michango kwa Siku: $date</h3>";
    echo "</div>";
    echo "<div class='card-body p-4'>";

    if ($result->num_rows > 0) {
        echo "<div class='table-responsive' style='max-height: 500px; overflow-y: auto;'>";  // Scrollable vertical area
        echo "<table class='table table-striped table-hover table-bordered text-center align-middle'>";
        echo "<thead class='table-warning text-dark'>
                <tr>
                    <th>Jumla</th>
                    <th>Zaka</th>
                    <th>Sadaka 58</th>
                    <th>Sadaka 42</th>
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
                </tr>
              </thead>";

        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            // Calculate 'jumla' dynamically if it's not calculated in the database
            $calculated_jumla = $row['zaka'] + $row['sadaka_58'] + $row['sadaka_42'] + $row['s_kambi'] + $row['ctf'] + $row['shule'] + $row['majengo'] + $row['idara_ya_wanawake'] + $row['idara_ya_elimu'] + $row['amo_dorcas'] + $row['s_sabato'] + $row['kwaya'] + $row['idara_ya_vijana'];

            // Add row values to totals
            $total_jumla += $calculated_jumla;
            $total_zaka += $row['zaka'];
            $total_sadaka_58 += $row['sadaka_58'];
            $total_sadaka_42 += $row['sadaka_42'];
            $total_s_kambi += $row['s_kambi'];
            $total_ctf += $row['ctf'];
            $total_shule += $row['shule'];
            $total_majengo += $row['majengo'];
            $total_idara_ya_wanawake += $row['idara_ya_wanawake'];
            $total_idara_ya_elimu += $row['idara_ya_elimu'];
            $total_amo_dorcas += $row['amo_dorcas'];
            $total_s_sabato += $row['s_sabato'];
            $total_kwaya += $row['kwaya'];
            $total_idara_ya_vijana += $row['idara_ya_vijana'];

            echo "<tr>
                    <td><strong>{$calculated_jumla}</strong></td>
                    <td>{$row['zaka']}</td>
                    <td>{$row['sadaka_58']}</td>
                    <td>{$row['sadaka_42']}</td>
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

        // Add totals row
        echo "<tfoot class='table-warning text-dark'>
                <tr>
                    <th><strong>{$total_jumla}</strong></th>
                    <th><strong>{$total_zaka}</strong></th>
                    <th><strong>{$total_sadaka_58}</strong></th>
                    <th><strong>{$total_sadaka_42}</strong></th>
                    <th><strong>{$total_s_kambi}</strong></th>
                    <th><strong>{$total_ctf}</strong></th>
                    <th><strong>{$total_shule}</strong></th>
                    <th><strong>{$total_majengo}</strong></th>
                    <th><strong>{$total_idara_ya_wanawake}</strong></th>
                    <th><strong>{$total_idara_ya_elimu}</strong></th>
                    <th><strong>{$total_amo_dorcas}</strong></th>
                    <th><strong>{$total_s_sabato}</strong></th>
                    <th><strong>{$total_kwaya}</strong></th>
                    <th><strong>{$total_idara_ya_vijana}</strong></th>
                </tr>
              </tfoot>";
        echo "</table>";
        echo "</div>";  // End of the scrollable div
    } else {
        echo "<div class='alert alert-warning text-center'>Hakuna michango iliyorekodiwa kwa siku hii.</div>";
    }

    echo "</div>";
    echo "</div>";
    echo "</div>";
}

?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Ripoti ya Michango kwa Siku</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Form ya kuchagua tarehe -->
        <div class="col-md-3 ms-auto mt-3">
            <form action="" method="GET" class="d-flex flex-column gap-3">
                <div class="mb-2">
                    <label for="date" class="form-label">Tarehe</label>
                    <!-- Tarehe input -->
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Pata Ripoti ya Siku</button>
            </form>
        </div>

        <!-- Onyesha ripoti kulingana na tarehe -->
        <div class="col-md-10 ms-auto">
            <?php
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                getDonationsByDay($conn, $date);
            }
            ?>
        </div>
    </div>
</div>

<script>
// Convert the date format from yyyy-mm-dd to yyyy/mm/dd on form submission
document.querySelector('form').addEventListener('submit', function(event) {
    var dateInput = document.getElementById('date');
    var dateValue = dateInput.value;
    // Convert the format to yyyy/mm/dd
    var formattedDate = dateValue.replace(/-/g, '/');
    dateInput.value = formattedDate;
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
