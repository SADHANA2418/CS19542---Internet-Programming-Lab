<?php
session_start(); // Start the session

// Get the username and password from the form
$username = $_POST['username'];  // The form field name is 'username'
$password = $_POST['password'];  // The form field name is 'password'

// Connect to the database
$conn = new mysqli("localhost", "root", "", "flavorful_finds");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE name = ? AND password = ?");
$stmt->bind_param("ss", $username, $password); // 'ss' means both parameters are strings

// Execute the prepared statement
$stmt->execute();

// Store the result
$result = $stmt->get_result();

// If the query returns a result, it means the login is successful
if ($result->num_rows > 0) {
    // Fetch user data (optional)
    $user = $result->fetch_assoc();
    
    // Store the username in a session variable
    $_SESSION['username'] = $user['name']; // Assuming 'name' is the column in your users table
    
    // Redirect to dashboard
    header("Location: dash.php");
    exit(); // Always exit after a header redirect to prevent further script execution
} else {
    echo "<h2>Invalid username or password. Please try again.</h2>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
