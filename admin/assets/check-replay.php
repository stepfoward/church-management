<?php
if (isset($_SESSION['reply'])) {
    $error_code = $_SESSION['reply'];

    // Create MySQLi connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "SELECT * FROM users WHERE code = ?";
    $stmt = $conn->prepare($sql);

    // Bind the parameter
    $stmt->bind_param("s", $error_code); // Assuming $error_code is a string

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Fetch and display the results
        while ($row = $result->fetch_assoc()) {
            echo '<div class="alert alert-' . $row['type'] . ' mb-2" role="alert">' . $row['description'] . '</div>';
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Unset session reply
    unset($_SESSION['reply']);
}
?>
