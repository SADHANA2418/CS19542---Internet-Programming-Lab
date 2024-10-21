<?php
session_start(); // Start the session

$name = $_POST['name'];
$password = $_POST['password'];

// Create a connection to the database
$conn = new mysqli("localhost", "root", "", "flavorful_finds");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $password); // 'ss' means both parameters are strings

// Execute the prepared statement
if ($stmt->execute()) {
    // Store the username in a session variable
    $_SESSION['username'] = $name; // Assuming you want to greet the user by name in dash.php
    
    // Redirect to dashboard
    header("Location: dash.php");
    exit(); // Always exit after a header redirect to prevent further script execution
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
