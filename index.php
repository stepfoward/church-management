<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            margin-bottom: 100px; /* To ensure space for the sidebar below */
        }

        /* Navbar (Header) */
        .navbar {
            background-color: #0d6efd;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
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

        .navbar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        /* Sidebar */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 6rem; /* Adjust to leave space for navbar */
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
        <!-- Logo Source - Add your logo URL here -->
        <img src="assets/image/logo.png" alt="Logo"> 
    </a>
    <div class="navbar-collapse">
        <form class="d-flex ms-auto">
            <input class="form-control search-bar" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    </div>
</nav>

<!-- Sidebar (Sidenav) -->
<div class="sidebar">
    <h4 class="text-white">Admin Dashboard</h4>

    <!-- Links for Reports -->
    <div>
        <a href="admin/Daily_report.php">Daily Report</a>
        <a href="admin/weekly_report.php">Weekly Report</a>
        <a href="admin/quarterly_report.php">Quarterly Report</a>
        <a href="admin/monthly_report.php">Monthly Report</a>
        <a href="admin/yearly_report.php">Yearly Report</a>
        <a href="admin/print_report.php">Print Report</a> <!-- Corrected the link for print report -->
    </div>

    <!-- Donation Form inside Sidebar -->
    <form action="admin/donation_form.php" method="POST">
        <button type="submit" class="btn btn-success btn-block">Go to Donation Form</button>
    </form>
    
    <!-- Logout inside Sidebar -->
    <form action="logout.php" method="POST">
        <button type="submit" class="btn btn-danger btn-block">Logout</button>
    </form>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- You can add any additional dashboard content here -->
</div>

<!-- Bootstrap JS and Popper.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
