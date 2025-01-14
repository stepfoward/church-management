<!-- sidebar.php -->
<div class="sidebar">
    <h4 class="text-white">Admin Dashboard</h4>
    <a href="#">Weekly Report</a>
    <a href="#">Quarterly Report</a>
    <a href="#">Monthly Report</a>
    <a href="#">Yearly Report</a>
    <a href="#">Print Report</a>

    <!-- Donation Form inside Sidebar -->
    <form action="admin/donation_form.php" method="POST">
        <button type="submit" class="btn btn-success btn-block">Go to Donation Form</button>
    </form>

    <!-- Logout inside Sidebar -->
    <form action="logout.php" method="POST">
        <button type="submit" class="btn btn-danger btn-block">Logout</button>
    </form>
</div>

<!-- Add a separate header section for sticky -->
<header class="sticky-header">
    <div class="container">
        <h1 class="text-center text-white">Admin Dashboard</h1>
    </div>
</header>

<!-- Add CSS for the sidebar and sticky header -->
<style>
    /* Fixed Sidebar Style */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100vh;
        background-color: #343a40;
        padding-top: 20px;
        padding-left: 20px;
        color: #fff;
        overflow-y: auto; /* Allows scrolling for sidebar */
    }

    /* Links inside Sidebar */
    .sidebar a {
        display: block;
        padding: 10px;
        margin: 10px 0;
        color: white;
        text-decoration: none;
    }

    /* Change link color on hover */
    .sidebar a:hover {
        background-color: #007bff;
        color: white;
    }

    /* Sidebar buttons */
    .sidebar form button {
        width: 100%;
        margin-top: 20px;
    }

    /* Sticky Header */
    .sticky-header {
        position: sticky;
        top: 0;
        background-color: #007bff;
        padding: 10px;
        color: white;
        text-align: center;
        z-index: 1000; /* Ensure header stays on top */
    }

    /* Body content styling */
    body {
        margin-left: 260px; /* To leave space for the fixed sidebar */
        background-color: #f8f9fa;
    }
    
    /* Make the content area scrollable */
    .content {
        padding: 20px;
        max-height: 100vh;
        overflow-y: auto;
    }
</style>
