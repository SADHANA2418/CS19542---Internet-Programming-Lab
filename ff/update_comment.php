<?php
$conn = new mysqli("localhost", "root", "", "flavorful_finds");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$recipe_id = $_POST['id'];
$comment = $_POST['comment'];

// Append the new comment to the existing ones
$sql = "UPDATE recipes SET comments = CONCAT(comments, '\n', ?) WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $comment, $recipe_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();
?>
