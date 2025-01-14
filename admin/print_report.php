<?php
require('../admin/includes/config.php'); // Uunganisho wa database
require('../admin/includes/header.php');

// Function to get donations based on report type (daily, weekly, quarterly, or yearly)
function getDonationsByDateRange($conn, $start_date, $end_date) {
    $sql = $conn->prepare("SELECT * FROM donations WHERE date BETWEEN ? AND ?");
    $sql->bind_param('ss', $start_date, $end_date);
    $sql->execute();
    return $sql->get_result();
}

// Function to get donations for a specific quarter and year
function getDonationsByQuarter($conn, $quarter, $year) {
    switch($quarter) {
        case 1:
            $start_date = "$year-01-01";
            $end_date = "$year-03-31";
            break;
        case 2:
            $start_date = "$year-04-01";
            $end_date = "$year-06-30";
            break;
        case 3:
            $start_date = "$year-07-01";
            $end_date = "$year-09-30";
            break;
        case 4:
            $start_date = "$year-10-01";
            $end_date = "$year-12-31";
            break;
    }

    return getDonationsByDateRange($conn, $start_date, $end_date);
}

// Function to get donations for a specific year
function getDonationsByYear($conn, $year) {
    $start_date = "$year-01-01";
    $end_date = "$year-12-31";
    return getDonationsByDateRange($conn, $start_date, $end_date);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ripoti ya Michango - Kuchagua Aina ya Ripoti</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .form-select, .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
        }
        .mb-3 {
            margin-bottom: 1.5rem;
        }
        .table th, .table td {
            text-align: center;
        }
        /* Additional styles for print */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center mb-4">Chagua Aina ya Ripoti</h2>

            <!-- Form ya kuchagua aina ya ripoti -->
            <form action="print_report.php" method="GET" class="d-flex flex-column gap-4">
                <div class="mb-4">
                    <label for="report_type" class="form-label">Aina ya Ripoti</label>
                    <select name="report_type" id="report_type" class="form-select" required>
                        <option value="daily">Ya Kila Siku</option>
                        <option value="weekly">Ya Kila Wiki</option>
                        <option value="quarterly">Ya Kila Robo Mwaka</option>
                        <option value="yearly">Ya Kila Mwaka</option>
                    </select>
                </div>

                <!-- Daily Report Fields -->
                <div class="mb-4" id="daily-fields">
                    <label for="date" class="form-label">Tarehe</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>

                <!-- Weekly Report Fields -->
                <div class="mb-4" id="weekly-fields" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Tarehe ya Kuanzia</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Tarehe ya Kumaliza</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Quarterly Report Fields -->
                <div class="mb-4" id="quarterly-fields" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="quarter" class="form-label">Robo ya Mwaka</label>
                            <select name="quarter" id="quarter" class="form-select" required>
                                <option value="1">Robo ya Kwanza (Jan - Mar)</option>
                                <option value="2">Robo ya Pili (Apr - Jun)</option>
                                <option value="3">Robo ya Tatu (Jul - Sep)</option>
                                <option value="4">Robo ya Nne (Oct - Dec)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="year" class="form-label">Mwaka</label>
                            <input type="number" name="year" id="year" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Yearly Report Fields -->
                <div class="mb-4" id="yearly-fields" style="display: none;">
                    <label for="year" class="form-label">Mwaka</label>
                    <input type="number" name="year" id="year" class="form-control" required>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary w-50">Pata Ripoti</button>
                </div>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['report_type'])) {
                $report_type = $_GET['report_type'];
                $data = [];
                
                if ($report_type == 'daily') {
                    $date = $_GET['date'];
                    $data = getDonationsByDateRange($conn, $date, $date);
                } elseif ($report_type == 'weekly') {
                    $start_date = $_GET['start_date'];
                    $end_date = $_GET['end_date'];
                    $data = getDonationsByDateRange($conn, $start_date, $end_date);
                } elseif ($report_type == 'quarterly') {
                    $quarter = $_GET['quarter'];
                    $year = $_GET['year'];
                    $data = getDonationsByQuarter($conn, $quarter, $year);
                } elseif ($report_type == 'yearly') {
                    $year = $_GET['year'];
                    $data = getDonationsByYear($conn, $year);
                }

                if ($data->num_rows > 0) {
                    echo "<h3 class='mt-4'>Ripoti ya Michango</h3>";
                    echo "<div id='report-content'>";
                    echo "<table class='table table-striped table-bordered'>";
                    echo "<thead><tr><th>ID</th><th>Tarehe</th><th>Zaka</th><th>Sadaka 58</th><th>Sadaka 42</th><th>Sadaka ya Kambi</th><th>CTF</th><th>Shule</th><th>Majengo</th><th>Idara ya Wanawake</th><th>Idara ya Elimu</th><th>Amo Dorcas</th><th>Sadaka ya Sabato</th><th>Kwaya</th><th>Idara ya Vijana</th></tr></thead><tbody>";
                    
                    while ($row = $data->fetch_assoc()) {
                        // Format the date fields to yyyy/mm/dd
                        $formatted_date = (new DateTime($row['date']))->format('Y/m/d');
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$formatted_date}</td>";  // Display the formatted date
                        echo "<td>{$row['zaka']}</td>";
                        echo "<td>{$row['sadaka_58']}</td>";
                        echo "<td>{$row['sadaka_42']}</td>";
                        echo "<td>{$row['s_kambi']}</td>";
                        echo "<td>{$row['ctf']}</td>";
                        echo "<td>{$row['shule']}</td>";
                        echo "<td>{$row['majengo']}</td>";
                        echo "<td>{$row['idara_ya_wanawake']}</td>";
                        echo "<td>{$row['idara_ya_elimu']}</td>";
                        echo "<td>{$row['amo_dorcas']}</td>";
                        echo "<td>{$row['s_sabato']}</td>";
                        echo "<td>{$row['kwaya']}</td>";
                        echo "<td>{$row['idara_ya_vijana']}</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                    echo "<button class='btn btn-primary no-print' onclick='window.print()'>Chapisha Ripoti</button>";
                    echo "</div>";
                } else {
                    echo "<div class='alert alert-warning mt-4'>Hakuna data inayolingana na vigezo ulivyoweka.</div>";
                }
            }
            ?>

        </div>
    </div>

    <script>
        // Dynamic form fields based on report type selection
        document.getElementById('report_type').addEventListener('change', function () {
            var reportType = this.value;
            document.getElementById('daily-fields').style.display = (reportType === 'daily') ? 'block' : 'none';
            document.getElementById('weekly-fields').style.display = (reportType === 'weekly') ? 'block' : 'none';
            document.getElementById('quarterly-fields').style.display = (reportType === 'quarterly') ? 'block' : 'none';
            document.getElementById('yearly-fields').style.display = (reportType === 'yearly') ? 'block' : 'none';
        });
    </script>
</body>
</html>
