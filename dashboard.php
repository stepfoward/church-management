<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Include the header and sidebar
include 'admin/includes/header.php';
include 'admin/includes/sidenav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin-left: 250px; /* Push content to the right */
            padding-top: 60px; /* Space for the navbar */
            background-color: #f4f6f9;
        }
        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidenav a {
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            display: block;
            font-size: 18px;
            transition: background-color 0.3s;
        }
        .sidenav a:hover {
            background-color: #007bff;
        }
        .sidenav i {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 40px 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .btn-custom-logout {
            background-color: #dc3545;
            color: white;
        }
        .btn-custom-logout:hover {
            background-color: #c82333;
        }
        h2 {
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            color: #555;
        }
    </style>
</head>
<body>

<!-- Main Content -->
<div class="container mt-5 main-content">
    <div class="card">
        <div class="card-header">
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        </div>
        <div class="card-body">
            <p>This is your dashboard where you can manage your activities. Navigate through the sidebar for detailed reports.</p>
        </div>
    </div>

    <!-- Logout button -->
    <a href="logout.php" class="btn btn-custom-logout">Logout</a>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
