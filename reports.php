<?php
require('config.php'); // Kuungana na database

// Cheki ikiwa parameter 'report' imetumwa kwenye URL na validate
$report_type = isset($_GET['report']) ? $_GET['report'] : ''; // Default empty
$valid_reports = ['weekly', 'monthly', 'yearly'];

if (!in_array($report_type, $valid_reports)) {
    $report_type = ''; // Ikiwa 'report' haipo au siyo valid, chagua default
}

// Kuandaa query kulingana na aina ya ripoti
switch ($report_type) {
    case 'weekly':
        // Ripoti ya kila wiki
        $sql = "SELECT * FROM donations WHERE DATE(date) > NOW() - INTERVAL 7 DAY";
        break;
    case 'monthly':
        // Ripoti ya kila mwezi
        $sql = "SELECT * FROM donations WHERE MONTH(date) = MONTH(CURRENT_DATE) AND YEAR(date) = YEAR(CURRENT_DATE)";
        break;
    case 'yearly':
        // Ripoti ya kila mwaka
        $sql = "SELECT * FROM donations WHERE YEAR(date) = YEAR(CURRENT_DATE)";
        break;
    default:
        // Ripoti ya jumla (hakuna filter)
        $sql = "SELECT * FROM donations";
        break;
}

// Execute query
$result = $conn->query($sql);

// Kuonyesha matokeo katika HTML table
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Jumla</th>
                <th>Zaka</th>
                <th>Sadaka</th>
                <th>Date</th> <!-- Ongeza other fields kama unavyohitaji -->
            </tr>";

    // Iterating each record
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['jumla']) . "</td>
                <td>" . htmlspecialchars($row['zaka']) . "</td>
                <td>" . htmlspecialchars($row['sadaka']) . "</td>
                <td>" . htmlspecialchars($row['date']) . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Hakuna data inayopatikana kwa ripoti hii.";
}

$conn->close(); // Funga muunganisho na database
?>
