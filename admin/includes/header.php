<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    exit;
}

require('../admin/includes/config.php'); // Include database connection

// Function for searching donations
function searchDonations($conn, $searchQuery) {
    $sql = "SELECT * FROM donations WHERE jumla LIKE ? OR zaka LIKE ? OR sadaka_58 LIKE ? OR sadaka_42 LIKE ? OR s_kambi LIKE ? OR ctf LIKE ? OR shule LIKE ? OR majengo LIKE ? OR idara_ya_wanawake LIKE ? OR idara_ya_elimu LIKE ? OR amo_dorcas LIKE ? OR s_sabato LIKE ? OR kwaya LIKE ? OR idara_ya_vijana LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $searchQuery . "%";  // Add the wildcards for LIKE query
    $stmt->bind_param("ssssssssssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    return $stmt->get_result();
}

// Handle search form submission
$searchResults = [];
$searchQuery = ''; // Initialize the searchQuery variable to avoid undefined errors
$noResultsMessage = ''; // Message variable for no results
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search_query'];  // Get the search query from the form
    
    // Only perform search if the search query is not empty
    if (!empty($searchQuery)) {
        $searchResults = searchDonations($conn, $searchQuery);
        if ($searchResults->num_rows == 0) {
            $noResultsMessage = 'No results found for "' . htmlspecialchars($searchQuery) . '"';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            margin-bottom: 100px;
        }

        /* Navbar (Header) */
        .navbar {
            background-color: #0d6efd;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            padding: 10px 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 15px;
            font-size: 18px;
        }

        .navbar .search-bar {
            width: 250px;
        }

        .navbar-toggler {
            border-color: white;
        }

        .navbar-toggler-icon {
            background-color: white;
        }

        /* Sidebar */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 6rem;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            padding-left: 10px;
            padding-bottom: 20px;
        }

        .sidebar a {
            color: white;
            padding: 12px 15px;
            text-decoration: none;
            display: block;
            margin: 5px 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #575d63;
        }

        /* Sidebar Header */
        .sidebar h4 {
            color: white;
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            margin-bottom: 60px;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
            margin-left: 260px;
            padding: 20px;
        }

        .content-header {
            padding-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar (Header) -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">
        <!-- Logo Source -->
        <img src="assets/image/logo.png" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <form class="d-flex ms-auto" method="POST" action="">
            <input class="form-control search-bar" type="search" name="search_query" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit" name="search">Search</button>
        </form>
    </div>
</nav>

<!-- Sidebar (Sidenav) -->
<div class="sidebar">
    <h4 class="text-white">Admin Dashboard</h4>
    <a href="#">Weekly Report</a>
    <a href="#">Quarterly Report</a>
    <a href="#">Monthly Report</a>
    <a href="#">Yearly Report</a>
    <a href="#">Add Offerings</a>
    <a href="index.php">Print Report</a>

</div>

<!-- Main Content -->
<div >
  
    <!-- Display Search Results -->
    <div class="container mt-4">
        <?php if (!empty($searchQuery)): ?>
            <h3>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h3>
            <?php if (!empty($noResultsMessage)): ?>
                <p><?php echo $noResultsMessage; ?></p>
            <?php else: ?>
                <table class="table table-striped table-hover table-bordered text-center align-middle">
                    <thead class="table-dark">
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
                    </thead>
                    <tbody>
                        <?php while ($row = $searchResults->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['jumla']; ?></td>
                                <td><?php echo $row['zaka']; ?></td>
                                <td><?php echo $row['sadaka_58']; ?></td>
                                <td><?php echo $row['sadaka_42']; ?></td>
                                <td><?php echo $row['s_kambi']; ?></td>
                                <td><?php echo $row['ctf']; ?></td>
                                <td><?php echo $row['shule']; ?></td>
                                <td><?php echo $row['majengo']; ?></td>
                                <td><?php echo $row['idara_ya_wanawake']; ?></td>
                                <td><?php echo $row['idara_ya_elimu']; ?></td>
                                <td><?php echo $row['amo_dorcas']; ?></td>
                                <td><?php echo $row['s_sabato']; ?></td>
                                <td><?php echo $row['kwaya']; ?></td>
                                <td><?php echo $row['idara_ya_vijana']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS and Popper.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Timeout to remove the welcome message after 5 seconds
    setTimeout(function() {
        document.getElementById("welcome-message").style.display = "none";
    }, 5000);
</script>

</body>
</html>
