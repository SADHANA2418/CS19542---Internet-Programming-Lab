<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        body {
            /* background: linear-gradient(to right, #7d5b29, #a57b44); */
             /* Brown gradient background */
             background: url('bg.jpg') no-repeat center center fixed; 
    background-size: cover;
            color: #fff; /* White text color */
        }
        .recipe-detail {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            margin: 20px auto;
            max-width: 800px;
            color: #333; /* Dark text color for readability */
        }
        h1 {
            color: #5d3a19; /* Dark brown for headings */
        }
        .like-btn {
            background: none;
            border: none;
            color: #ff6347;
            cursor: pointer;
            font-size: 20px;
            transition: color 0.3s;
        }
        .like-btn:hover {
            color: #d94f2a; /* Lighter brown on hover */
        }
        .comment-section {
            margin-top: 20px;
        }
        .comment-section h4 {
            margin-bottom: 10px;
            color: #5d3a19; /* Dark brown for subheadings */
        }
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #d94f2a; /* Lighter brown on hover */
            color: white;
        }
        .print-btn, .share-btn, .back-btn {
            background-color: #5d3a19; /* Dark brown */
            color: white; /* White text */
        }
        .print-btn:hover, .share-btn:hover, .back-btn:hover {
            background-color: #d94f2a; /* Lighter brown on hover */
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="recipe-detail">
            <?php
            // Fetch recipe details from the database based on the recipe ID
            $conn = new mysqli("localhost", "root", "", "flavorful_finds");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get recipe ID from query parameter
            $recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            $sql = "SELECT title, image, description, prep_steps, main_process, tips, likes, comments FROM recipes WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $recipe_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>

                <h1><?php echo htmlspecialchars($row['title']); ?></h1>
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="img-fluid rounded mb-3">
                
                <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>

                <h3>Preparation Steps</h3>
                <p><?php echo nl2br(htmlspecialchars($row['prep_steps'])); ?></p>

                <h3>Main Cooking Process</h3>
                <p><?php echo nl2br(htmlspecialchars($row['main_process'])); ?></p>

                <h3>Tips</h3>
                <p><?php echo nl2br(htmlspecialchars($row['tips'])); ?></p>

                <div>
                    <button class="like-btn" data-id="<?php echo $recipe_id; ?>">
                        <i class="fas fa-thumbs-up"></i> Like
                    </button>
                    <span>Likes: <?php echo htmlspecialchars($row['likes']); ?></span>
                </div>

                <div class="comment-section">
                    <h4>Comments:</h4>
                    <p><?php echo htmlspecialchars($row['comments']); ?></p>
                    <!-- Add a form for submitting new comments -->
                    <form class="comment-form">
                        <textarea name="comment" required placeholder="Add your comment..."></textarea>
                        <button type="submit">Submit Comment</button>
                    </form>
                </div>

                <div class="mt-4">
                    <button class="print-btn" onclick="window.print()">Print Recipe</button>
                    <button class="share-btn" onclick="shareRecipe()">Share Recipe</button>
                    <a href="dash.php" class="btn btn-secondary back-btn">Back to Dashboard</a>
                </div>

                <script>
                    // Function to handle the share functionality
                    function shareRecipe() {
                        const title = "<?php echo addslashes($row['title']); ?>";
                        const url = window.location.href;
                        const shareText = `Check out this recipe: ${title} - ${url}`;
                        
                        if (navigator.share) {
                            navigator.share({
                                title: title,
                                text: shareText,
                                url: url,
                            }).then(() => {
                                console.log('Share successful!');
                            }).catch((error) => {
                                console.log('Error sharing:', error);
                            });
                        } else {
                            alert('Sharing not supported on this browser.');
                        }
                    }

                    // Like button functionality
                    document.querySelector('.like-btn').addEventListener('click', function() {
                        var recipeId = this.getAttribute('data-id');

                        fetch('update_like.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ id: recipeId }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Liked!');
                                location.reload(); // Reload to show the updated likes
                            } else {
                                alert('Error liking the recipe.');
                            }
                        });
                    });

                    // Comment submission
                    document.querySelector('.comment-form').addEventListener('submit', function(e) {
                        e.preventDefault();
                        var comment = this.querySelector('textarea[name="comment"]').value;

                        fetch('submit_comment.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ id: <?php echo $recipe_id; ?>, comment: comment }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Comment added!');
                                location.reload(); // Reload to show the new comment
                            } else {
                                alert('Error adding comment.');
                            }
                        });
                    });
                </script>

                <?php
            } else {
                echo "Recipe not found.";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>

</body>
</html>

