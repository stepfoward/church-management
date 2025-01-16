<?php
require('../admin/includes/config.php'); // Database connection
require('../admin/includes/header.php'); // Include your header

// Function to get all donations with optional month and year filters
function getDonationsByMonthAndYear($conn, $month = null, $year = null) {
    $sql = "SELECT * FROM donations";
    $conditions = [];
    $params = [];

    if ($month) {
        $conditions[] = "MONTH(date) = ?";
        $params[] = $month;
    }
    
    if ($year) {
        $conditions[] = "YEAR(date) = ?";
        $params[] = $year;
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $stmt = $conn->prepare($sql);
    
    // Bind parameters dynamically based on the filters
    if (count($params) > 0) {
        $types = str_repeat('i', count($params)); // Dynamically determine the type for bind_param
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}

// Handle form submission
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : null;
$selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
$searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

// Month names array
$months = [
    1 => "Januari", 2 => "Februari", 3 => "Machi", 4 => "Aprili", 
    5 => "Mei", 6 => "Juni", 7 => "Julai", 8 => "Agosti", 
    9 => "Septemba", 10 => "Oktoba", 11 => "Novemba", 12 => "Desemba"
];

$monthName = $selectedMonth ? $months[$selectedMonth] : 'Jumla ya Michango';
$yearName = $selectedYear ? $selectedYear : 'Mwaka';

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

                            <select name="year" class="form-control">
                                <option value="">Chagua Mwaka</option>
                                <?php 
                                // Assuming donations are from the last few years, or you can set specific years.
                                $currentYear = date("Y");
                                for ($year = 2015; $year <= $currentYear; $year++) {
                                    echo "<option value='$year'" . ($selectedYear == $year ? ' selected' : '') . ">$year</option>";
                                }
                                ?>
                            </select>
                            <button type="submit" class="btn btn-secondary">Tafuta</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            // Fetch donations with month and year filter if selected
            $donations = getDonationsByMonthAndYear($conn, $selectedMonth, $selectedYear);
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
                echo "<h3 class='text-center' id='printTitle'>Ripoti ya Michango - $monthName $yearName</h3>";
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
                            <th>Actions</th>
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
                            <td>
                                <div class='flex space-x-2'>
                                    <a href='#' class='btn btn-info btn-sm'>
                                        <i class='fas fa-eye'></i> View
                                    </a>
                                    <a href='#' class='btn btn-warning btn-sm'>
                                        <i class='fas fa-edit'></i> Edit
                                    </a>
                                    <a href='#' class='btn btn-danger btn-sm'>
                                        <i class='fas fa-trash-alt'></i> Delete
                                    </a>
                                </div>
                            </td>
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
                echo "<div class='alert alert-warning'>Hakuna michango iliyorekodiwa.</div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
