<?php
require_once "../admin/includes/config.php"; // Kuunganisha na hifadhidata

// Thibitisha thamani za awali
$search_type = $_POST['search_type'] ?? '';
$zaka = $_POST['zaka'] ?? 0;
$sadaka = $_POST['sadaka'] ?? 0;
$total_results = 0;
$result = null;

// Fanya utafutaji ikiwa fomu imetumwa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "";

    // Fanya query kulingana na aina ya utafutaji
    if ($search_type == "zaka") {
        $sql = "SELECT * FROM donations WHERE zaka >= ?";
    } elseif ($search_type == "sadaka") {
        $sql = "SELECT * FROM donations WHERE sadaka >= ?";
    } elseif ($search_type == "zaka_sadaka") {
        $sql = "SELECT * FROM donations WHERE zaka >= ? AND sadaka >= ?";
    } elseif ($search_type == "hajatoa") {
        $sql = "SELECT * FROM donations WHERE zaka = 0 AND sadaka = 0";
    }

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        if ($search_type == "zaka" || $search_type == "sadaka") {
            // Pass by reference using variable variables
            $param = ($search_type == "zaka") ? $zaka : $sadaka;
            $stmt->bind_param("d", $param);
        } elseif ($search_type == "zaka_sadaka") {
            // Pass both zaka and sadaka by reference
            $stmt->bind_param("dd", $zaka, $sadaka);
        }

        // Execute the query
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();
        $total_results = $result->num_rows;

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Donations</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f4f7fa;
        }
        .form-container {
            max-width: 100%;
        }

        /* Custom style for print */
        @media print {
            .no-print {
                display: none;
            }
            .printable-area {
                width: 100%;
                margin: 0;
                padding: 20px;
                background-color: #fff;
                font-family: Arial, sans-serif;
            }
            .form-container {
                display: none; /* Hide the search form during print */
            }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="form-container bg-white p-4 rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold mb-4 text-center">Search Donations</h1>

        <!-- Horizontal search form -->
        <form method="post" action="" class="row g-3 align-items-center justify-content-center">
            <div class="col-auto">
                <label for="search_type" class="form-label">Select Search Type:</label>
                <select name="search_type" id="search_type" class="form-select">
                    <option value="zaka" <?= ($search_type == "zaka") ? 'selected' : '' ?>>Zaka</option>
                    <option value="zaka_sadaka" <?= ($search_type == "zaka_sadaka") ? 'selected' : '' ?>>Zaka & Sadaka</option>
                    <option value="sadaka" <?= ($search_type == "sadaka") ? 'selected' : '' ?>>Sadaka</option>
                    <option value="hajatoa" <?= ($search_type == "hajatoa") ? 'selected' : '' ?>>Hajatoa</option>
                </select>
            </div>

            <div class="col-auto">
                <label for="zaka" class="form-label">Zaka Amount:</label>
                <input type="number" step="0.01" name="zaka" id="zaka" value="<?= htmlspecialchars($zaka) ?>" class="form-control">
            </div>

            <div class="col-auto">
                <label for="sadaka" class="form-label">Sadaka Amount:</label>
                <input type="number" step="0.01" name="sadaka" id="sadaka" value="<?= htmlspecialchars($sadaka) ?>" class="form-control">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>

            <div class="col-auto">
                <button type="button" class="btn btn-success no-print" onclick="window.print()">Print</button>
            </div>
        </form>
    </div>

    <h2 class="text-xl font-semibold mt-6">Search Results</h2>

    <!-- Display count of results -->
    <p class="text-center mb-4">Total results: <?= $total_results ?></p>

    <div class="printable-area">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($result && $total_results > 0) {
            echo "<table class='table table-striped mt-2'>
                    <thead>
                        <tr>";
            if ($search_type == "zaka" || $search_type == "zaka_sadaka") {
                echo "<th>Jina Kamili</th><th>Zaka</th>";
            }
            if ($search_type == "sadaka" || $search_type == "zaka_sadaka") {
                echo "<th>Sadaka</th>";
            }
            echo "<th>Status</th><th>Date</th></tr></thead><tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                $jina_kamili = !empty($row['jina_kamili']) ? $row['jina_kamili'] : $row['username'];

                if ($search_type == "zaka" || $search_type == "zaka_sadaka") {
                    echo "<td>" . $jina_kamili . "</td><td>" . $row['zaka'] . "</td>";
                }
                if ($search_type == "sadaka" || $search_type == "zaka_sadaka") {
                    echo "<td>" . $row['sadaka'] . "</td>";
                }

                if (isset($row['status'])) {
                    echo "<td>" . $row['status'] . "</td>";
                } else {
                    echo "<td>Donated</td>";
                }

                echo "<td>" . $row['date'] . "</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            if ($search_type == "hajatoa") {
                echo "<p class='text-center text-danger'>No users found who have not donated zaka or sadaka.</p>";
            } else {
                echo "<p class='text-center text-danger'>No results found for the selected criteria.</p>";
            }
        }
    }
    ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
