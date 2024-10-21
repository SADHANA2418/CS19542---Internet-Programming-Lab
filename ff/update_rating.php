<?php
$conn = new mysqli("localhost", "root", "", "flavorful_finds");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$recipe_id = $_POST['id'];
$rating = $_POST['rating'];

// Update rating (assuming rating is a numeric field in your DB)
$sql = "UPDATE recipes SET rating = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $rating, $recipe_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
