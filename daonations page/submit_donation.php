<?php
// Include the database connection file
include('donations page/../admin/includes/config.php'); // Adjust the path as necessary

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collecting form data from the POST request
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $donation_amount = $_POST['donation'];

    // Prepare and bind to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO michango (full_name, phone, email, department, donation_amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $full_name, $phone, $email, $department, $donation_amount);

    // Execute the query
    if ($stmt->execute()) {
        echo "<p class='text-green-500'>Donation submitted successfully!</p>";
    } else {
        echo "<p class='text-red-500'>Error: " . $stmt->error . "</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Michango (Donation)</title>

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
            <li><a href="#" class="hover:bg-blue-700 p-2 rounded-md">Michango</a></li>
            <li><a href="#" class="hover:bg-blue-700 p-2 rounded-md">Reports</a></li>
            <li><a href="#" class="hover:bg-blue-700 p-2 rounded-md">Settings</a></li>
        </ul>
    </div>

    <!-- Main Content Area (after the sidebar) -->
    <div class="ml-60 p-6">

        <!-- Top Header -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md mb-6">
            <!-- Navigation Links -->
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

        <!-- Michango Form Section -->
        <div class="bg-white p-6 shadow-lg rounded-md">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Submit Michango (Donation)</h3>

            <!-- Form to submit donation -->
            <form method="POST" action="daonations page/submit_donation.php">
                <!-- Full Name -->
                <div class="mb-4">
                    <label for="full_name" class="block text-sm font-semibold text-gray-700">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required class="w-full p-3 mt-1 border border-gray-300 rounded-md" />
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-semibold text-gray-700">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required class="w-full p-3 mt-1 border border-gray-300 rounded-md" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required class="w-full p-3 mt-1 border border-gray-300 rounded-md" />
                </div>

                <!-- Department -->
                <div class="mb-4">
                    <label for="department" class="block text-sm font-semibold text-gray-700">Department</label>
                    <input type="text" id="department" name="department" required class="w-full p-3 mt-1 border border-gray-300 rounded-md" />
                </div>

                <!-- Donation Amount -->
                <div class="mb-4">
                    <label for="donation" class="block text-sm font-semibold text-gray-700">Donation Amount</label>
                    <input type="number" id="donation" name="donation" required class="w-full p-3 mt-1 border border-gray-300 rounded-md" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-800 text-white p-3 rounded-md hover:bg-blue-700">Submit Donation</button>
            </form>
        </div>

    </div>

    <!-- Bootstrap JS and Popper.js (for Bootstrap components like dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
