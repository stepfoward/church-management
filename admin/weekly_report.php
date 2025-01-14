<?php
require('../admin/includes/config.php'); // Uunganisho wa database
require('../admin/includes/header.php');

// Function to get donations for the specified week
function getDonationsByWeek($conn, $start_date, $end_date) {
    // Prepared SQL query to avoid SQL injection
    $sql = $conn->prepare("SELECT * FROM donations WHERE date BETWEEN ? AND ?");
    $sql->bind_param('ss', $start_date, $end_date);
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
    echo "<h3>Ripoti ya Michango kwa Wiki</h3>";
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
                    <th>Actions</th> <!-- Added Actions column -->
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
                    <td>
                        <div class='btn-group' role='group' aria-label='Actions'>
                            <a href='view_report.php?id={$row['id']}' class='btn btn-sm btn-info'><i class='bi bi-eye'></i> View</a>
                            <a href='edit_report.php?id={$row['id']}' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i> Edit</a>
                            <a href='delete_report.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this report?\")'><i class='bi bi-trash'></i> Delete</a>
                            <a href='print_report.php?id={$row['id']}' class='btn btn-sm btn-success' target='_blank'><i class='bi bi-printer'></i> Print</a>
                        </div>
                    </td>
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
                    <td>
                        <!-- Empty footer cell for consistency, no actions needed here -->
                    </td>
                </tr>
              </tfoot>";
        echo "</table>";
        echo "</div>";  // End of the scrollable div
    } else {
        echo "<div class='alert alert-warning text-center'>Hakuna michango iliyorekodiwa kwa wiki hii.</div>";
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
    <title>Ripoti ya Michango kwa Wiki</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-responsive {
            max-height: 500px; /* Adjust the height as necessary */
            overflow-y: auto;  /* Vertical scroll */
            overflow-x: auto;  /* Horizontal scroll */
        }

        .table-warning th {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Form ya kuchagua wiki -->
        <div class="col-md-3 ms-auto mt-3">
            <form action="" method="GET" class="d-flex flex-column gap-3">
                <div class="d-flex gap-3">
                    <div class="mb-2 flex-grow-1">
                        <label for="start_date" class="form-label">Tarehe ya Kuanzia</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="mb-2 flex-grow-1">
                        <label for="end_date" class="form-label">Tarehe ya Kumaliza</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Pata Ripoti ya Wiki</button>
            </form>
        </div>

        <!-- Onyesha ripoti kulingana na wiki -->
        <div class="col-md-10 ms-auto">
            <?php
            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                $start_date = $_GET['start_date'];
                $end_date = $_GET['end_date'];
                getDonationsByWeek($conn, $start_date, $end_date);
            }
            ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
