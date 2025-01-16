<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Left Sidebar (Fixed) -->
    <div class="w-60 bg-blue-800 text-white h-screen p-5 fixed top-0 left-0">
        <h2 class="text-xl font-bold mb-6">Admin Dashboard</h2>
        <ul class="space-y-4">
            <li><a href="#" class="hover:bg-blue-700 p-2 rounded-md">Dashboard</a></li>
            <li><a href="daonations page/submit_donation.php" class="hover:bg-blue-700 p-2 rounded-md">Michango</a></li>
            <li><a href="#" class="hover:bg-blue-700 p-2 rounded-md">Reports</a></li>
            <li><a href="#" class="hover:bg-blue-700 p-2 rounded-md">Settings</a></li>
            <a href="daonations page/submit_donation.php">Day Report</a>
        
        </ul>
    </div>

    <!-- Main Content -->
    <div class="ml-60 p-6">

        <!-- Header -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md">
            <div class="flex space-x-8">
                <a href="#" class="text-blue-800 hover:text-blue-600">Services</a>
                <a href="#" class="text-blue-800 hover:text-blue-600">About</a>
                <a href="#" class="text-blue-800 hover:text-blue-600">Contact</a>
            </div>

            <!-- Search and Admin Icons -->
            <div class="flex items-center space-x-4">
                <input type="text" placeholder="Search..." class="p-2 border border-gray-300 rounded-md" />
                
                <!-- Search Icon (FontAwesome) -->
                <button class="bg-blue-800 text-white p-2 rounded-full hover:bg-blue-700">
                    <i class="fas fa-search"></i>
                </button>
                
                <!-- Admin Icon (FontAwesome) -->
                <button class="bg-blue-800 text-white p-2 rounded-full hover:bg-blue-700">
                    <i class="fas fa-user-cog"></i>
                </button>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="mt-6">
            <h3 class="text-2xl font-semibold text-gray-800">Welcome to the Dashboard</h3>
            <p class="mt-4 text-gray-600">Manage your content here with ease. Use the sidebar to navigate between sections.</p>

            <!-- Additional Content/Widgets can be added here -->
        </div>

    </div>

    <!-- Bootstrap JS and Popper.js (for Bootstrap components like dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
