<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Recipe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome for icons -->
    <style>
        body {
            background-image: url('bg.jpg'); /* Replace with your background image path */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            color: #343a40; /* Dark text color */
        }
        .container {
            background-color: rgba(210, 180, 140, 0.9); /* Light brown with some transparency */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Soft shadow */
            padding: 30px; /* Padding around the form */
            margin-top: 30px; /* Top margin */
        }
        h2 {
            margin-bottom: 20px; /* Space below heading */
        }
        .btn {
            width: 100%; /* Full width buttons */
            margin-top: 10px; /* Margin between buttons */
           
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Upload a New Recipe</h2>
    <form action="upload_recipe.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" placeholder="Add title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" placeholder="Add description" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" id="image" placeholder="Add the image of your dish" name="image" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="prep_steps">Preparation Steps:</label>
            <textarea class="form-control" id="prep_steps" name="prep_steps" placeholder="Add Preperation Steps" required></textarea>
        </div>
        <div class="form-group">
            <label for="main_process">Main Process:</label>
            <textarea class="form-control" id="main_process" name="main_process" placeholder="Add Main Process" required></textarea>
        </div>
        <div class="form-group">
            <label for="tips">Tips:</label>
            <textarea class="form-control" id="tips" name="tips" placeholder="Add Tips"></textarea>
        </div>
        <button type="submit" class="btn btn-warning">Upload Recipe</button>
        <a href="dash.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "flavorful_finds");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user is logged in
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('You need to be logged in to upload a recipe.'); window.location.href='login.php';</script>";
        exit();
    }

    // Get the user_id based on the logged-in user's name
    $user_name = $_SESSION['username'];
    $user_id_query = "SELECT id FROM users WHERE name = '$user_name'";
    $result = $conn->query($user_id_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    } else {
        echo "User not found.";
        exit();
    }

    // Validate and sanitize input
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $prep_steps = $conn->real_escape_string($_POST['prep_steps']);
    $main_process = $conn->real_escape_string($_POST['main_process']);
    $tips = $conn->real_escape_string($_POST['tips']);

    // Handle image upload
    $target_dir = "uploads/"; // Ensure this directory exists and has appropriate permissions
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Prepare and execute insert statement
            $sql = "INSERT INTO recipes (title, description, image, prep_steps, main_process, tips, user_id) VALUES ('$title', '$description', '$target_file', '$prep_steps', '$main_process', '$tips', '$user_id')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Recipe uploaded successfully!'); window.location.href='dash.php';</script>";
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }

    $conn->close();
}
?>

</body>
</html>

