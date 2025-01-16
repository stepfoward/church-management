<?php
require('../admin/includes/config.php'); // Database connection
require('../admin/includes/header.php'); // Include your header

// Function to get all donations with optional day or month filter
function getDonationsByDayOrMonth($conn, $dayOfWeek = null, $month = null) {
    $sql = "SELECT * FROM donations";
    
    // Add filter for day of the week if provided
    if ($dayOfWeek) {
        $sql .= " WHERE DAYOFWEEK(date) = ?";
    }

    // Add filter for month if provided
    if ($month) {
        if ($dayOfWeek) {
            $sql .= " AND MONTH(date) = ?";
        } else {
            $sql .= " WHERE MONTH(date) = ?";
        }
    }

    $stmt = $conn->prepare($sql);

    // Bind parameters based on which filter is used
    if ($dayOfWeek && $month) {
        $stmt->bind_param("ii", $dayOfWeek, $month);
    } elseif ($dayOfWeek) {
        $stmt->bind_param("i", $dayOfWeek);
    } elseif ($month) {
        $stmt->bind_param("i", $month);
    }

    $stmt->execute();
    return $stmt->get_result();
}

// Handle form submission
$selectedDayOfWeek = isset($_GET['dayOfWeek']) ? $_GET['dayOfWeek'] : null;
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : null;

?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- FontAwesome for Icons -->
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

        /* Sticky Header */
        .table th {
            position: sticky;
            top: 0;
            z-index: 1;
            background-color: #fff; /* Make the header background white */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: add shadow for better visibility */
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
                        
                        <!-- Day of Week Dropdown -->
                        <div class="input-group mb-3">
                            <select name="dayOfWeek" class="form-control">
                                <option value="">Chagua Siku ya Wiki</option>
                                <option value="1" <?php echo ($selectedDayOfWeek == 1) ? 'selected' : ''; ?>>Jumatatu</option>
                                <option value="2" <?php echo ($selectedDayOfWeek == 2) ? 'selected' : ''; ?>>Jumanne</option>
                                <option value="3" <?php echo ($selectedDayOfWeek == 3) ? 'selected' : ''; ?>>Jumatano</option>
                                <option value="4" <?php echo ($selectedDayOfWeek == 4) ? 'selected' : ''; ?>>Alhamisi</option>
                                <option value="5" <?php echo ($selectedDayOfWeek == 5) ? 'selected' : ''; ?>>Ijumaa</option>
                                <option value="6" <?php echo ($selectedDayOfWeek == 6) ? 'selected' : ''; ?>>Jumamosi</option>
                                <option value="7" <?php echo ($selectedDayOfWeek == 7) ? 'selected' : ''; ?>>Jumapili</option>
                            </select>
                        </div>
                        
                        <!-- Month Dropdown -->
                        <div class="input-group mb-3">
                            <select name="month" class="form-control">
                                <option value="">Chagua Mwezi</option>
                                <option value="1" <?php echo ($selectedMonth == 1) ? 'selected' : ''; ?>>Januari</option>
                                <option value="2" <?php echo ($selectedMonth == 2) ? 'selected' : ''; ?>>Februari</option>
                                <option value="3" <?php echo ($selectedMonth == 3) ? 'selected' : ''; ?>>Machi</option>
                                <option value="4" <?php echo ($selectedMonth == 4) ? 'selected' : ''; ?>>Aprili</option>
                                <option value="5" <?php echo ($selectedMonth == 5) ? 'selected' : ''; ?>>Mei</option>
                                <option value="6" <?php echo ($selectedMonth == 6) ? 'selected' : ''; ?>>Juni</option>
                                <option value="7" <?php echo ($selectedMonth == 7) ? 'selected' : ''; ?>>Julai</option>
                                <option value="8" <?php echo ($selectedMonth == 8) ? 'selected' : ''; ?>>Agosti</option>
                                <option value="9" <?php echo ($selectedMonth == 9) ? 'selected' : ''; ?>>Septemba</option>
                                <option value="10" <?php echo ($selectedMonth == 10) ? 'selected' : ''; ?>>Oktoba</option>
                                <option value="11" <?php echo ($selectedMonth == 11) ? 'selected' : ''; ?>>Novemba</option>
                                <option value="12" <?php echo ($selectedMonth == 12) ? 'selected' : ''; ?>>Desemba</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-secondary">Tafuta</button>
                    </form>
                </div>
            </div>

            <?php
            // Fetch donations with day or month filter if selected
            $donations = getDonationsByDayOrMonth($conn, $selectedDayOfWeek, $selectedMonth);
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
                echo "<h3 class='text-center' id='printTitle'>Ripoti ya Michango</h3>";
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
                echo "<div class='alert alert-warning'>Hakuna michango iliyorekodiwa kwa siku hii au mwezi.</div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
