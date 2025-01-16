<?php
session_start(); // Start a session to manage session variables

// Include the configuration file that handles the database connection
require('admin/includes/config.php');

// Check if the form has been submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email and password values from the POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare an SQL query to fetch the user details based on the email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql); // Prepare the SQL statement
    $stmt->bind_param("s", $email); // Bind the email parameter to the prepared statement
    $stmt->execute(); // Execute the statement
    $result = $stmt->get_result(); // Get the result of the query
    
    // Check if exactly one user was found with the provided email
    if ($result->num_rows == 1) {
        // Fetch the user's details from the result
        $user = $result->fetch_assoc();
        
        // Verify the password against the hashed password in the database
        if (password_verify($password, $user['password'])) {
            // If the password is correct, store user details in session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Store role for authorization purposes
            header('Location: index.php'); // Redirect to the dashboard or homepage
            exit;
        } else {
            // If the password is incorrect, set an error message
            $error = "Invalid password.";
        }
    } else {
        // If no user is found with the provided email, set an error message
        $error = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0d6efd;
            color: #fff;
            border-radius: 12px 12px 0 0;
            text-align: center;
            padding: 20px;
            font-size: 1.3rem;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 15px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-control {
            height: 40px;
            font-size: 14px;
            padding: 10px;
        }
        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            Login Form
        </div>
        <div class="card-body">
            <!-- Display error message if it exists -->
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form action="login.php" method="POST">
                <!-- Email input field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <!-- Password input field -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <!-- Link to the signup page if the user doesn't have an account -->
            <div class="mt-3 text-center">
                <a href="signup.php">Don't have an account? Sign up here</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
