<?php
session_start();
$conn = new mysqli("localhost", "root", "", "flavorful_finds");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    // Increment the likes count for the specific recipe
    $conn->query("UPDATE recipes SET likes = likes + 1 WHERE id = $id");
    
    // Fetch the updated likes count
    $result = $conn->query("SELECT likes FROM recipes WHERE id = $id");
    $row = $result->fetch_assoc();
    echo $row['likes']; // Return the updated likes count
}

$conn->close();
?>
