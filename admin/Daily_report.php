<?php
require('../admin/includes/config.php'); // Database connection
require('../admin/includes/header.php'); // Include your header

// Function to get all donations with optional date filter
function getDonationsByDate($conn, $startDate = null, $endDate = null) {
    $sql = "SELECT * FROM donations";
    if ($startDate && $endDate) {
        $sql .= " WHERE date BETWEEN ? AND ?";
    } elseif ($startDate) {
        $sql .= " WHERE date = ?";
    }

    $stmt = $conn->prepare($sql);
    
    if ($startDate && $endDate) {
        $stmt->bind_param("ss", $startDate, $endDate);
    } elseif ($startDate) {
        $stmt->bind_param("s", $startDate);
    }

    $stmt->execute();
    return $stmt->get_result();
}

// Handle form submission for date filtering
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : null;
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Ripoti ya Michango Yote</title>
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
        }

        /* Fixed Header */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Push down the content to avoid overlap */
        .content {
            margin-top: 70px;
            padding: 15px;
            margin-left: 230px; /* Adjust content to avoid sidebar */
        }

        /* Full-width table */
        table {
            width: 100%;
            table-layout: auto;
        }

        /* Adjust input fields */
        .form-control {
            height: calc(1.75rem + 2px);
        }

        /* Additional table styling */
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: middle;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .table thead {
                display: none;
            }
            .table, 
            .table tbody, 
            .table tr, 
            .table td {
                display: block;
                width: 100%;
            }
            .table tr {
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
            }
            .table td {
                text-align: right;
                position: relative;
                padding-left: 50%;
            }
            .table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 10px;
                font-weight: bold;
                text-align: left;
            }
        }

        /* Print-specific styles */
        @media print {
            body * {
                visibility: hidden;
            }

            #donationTable, #donationTable * {
                visibility: visible;
            }

            #donationTable {
                position: absolute;
                left: 0;
                top: 0;
            }

            .print-button {
                display: none; /* Hide print button during printing */
            }

            /* Print title */
            #printTitle {
                visibility: visible;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="fixed-header">
        <?php require('../admin/includes/header.php'); ?>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <form action="" method="GET" class="d-flex justify-content-center align-items-center gap-3">
                        
                        <div class="input-group mb-3">
                            <label for="start_date" class="form-label">Tangu</label>
                            <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($startDate); ?>" required>
                        </div>
                        
                        <div class="input-group mb-3">
                            <label for="end_date" class="form-label">Mpaka</label>
                            <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($endDate); ?>" required>
                        </div>
                        
                        <button type="submit" class="btn btn-secondary">Tafuta kwa Tarehe</button>
                    </form>
                </div>
            </div>

            <?php
            // Fetch donations with date filter if selected
            $donations = getDonationsByDate($conn, $startDate, $endDate);
            $totals = [
                'jumla' => 0,
                'zaka' => 0,
                'sadaka' => 0,
                'sadaka_58' => 0,
                'sadaka_42' => 0,
                's_kambi' => 0,
                'ctf' => 0,
                'shule' => 0,
                'majengo' => 0,
                'idara_ya_wanawake' => 0,
                'idara_ya_elimu' => 0,
                'amo_dorcas' => 0,
                's_sabato' => 0,
                'kwaya' => 0,
                'idara_ya_vijana' => 0
            ];

            if ($donations->num_rows > 0) {
                echo "<div class='mt-5'>";
                echo "<h3 class='text-center' id='printTitle'>Ripoti ya Michango - Tangu $startDate Mpaka $endDate</h3>";
                echo "<button class='btn btn-success mb-3 print-button' onclick='window.print()'>Chapisha Ripoti</button>";
                echo "<table class='table table-striped table-bordered text-center mt-3' id='donationTable'>";
                echo "<thead class='table-warning'>
                        <tr>
                            <th>ID</th>
                            <th>Jina Kamili</th>
                            <th>Jumla</th>
                            <th>Zaka</th>
                            <th>Sadaka</th>
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
                            <th>Tarehe</th>
                        </tr>
                      </thead>
                      <tbody>";

                while ($row = $donations->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['jina_kamili']}</td>
                            <td>{$row['jumla']}</td>
                            <td>{$row['zaka']}</td>
                            <td>{$row['sadaka']}</td>
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
                            <td>{$row['date']}</td>
                        </tr>";
                    
                    // Calculate totals
                    foreach ($totals as $key => $value) {
                        $totals[$key] += $row[$key];
                    }
                }
                
                // Total row
                echo "<tr class='table-info'>
                        <td colspan='2'><strong>Jumla</strong></td>";
                foreach ($totals as $total) {
                    echo "<td><strong>{$total}</strong></td>";
                }
                echo "<td></td></tr>";
                echo "</tbody></table></div>";
            } else {
                echo "<div class='alert alert-warning'>Hakuna michango iliyorekodiwa kwa tarehe ulizochagua.</div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
