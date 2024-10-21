<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavorful Finds Dashboard</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            /* background-color: #754f2e; Light background for better contrast */
            background: url('bg.jpg') no-repeat center center fixed; 
    background-size: cover;
            font-family: 'Arial', sans-serif;
        }
        .text-center{
            font-family: 'Pacifico','cursive';
            color:white; 
     font-size: 3rem; 
    text-align: center;
    /* text-shadow: 
        0 0 5px rgba(255, 255, 255, 0.9),
        0 0 10px rgb(4, 68, 123), 
        0 0 20px rgb(3, 78, 144); */
    /* transition: text-shadow 0.3s ease, transform 0.3s ease;
    display: inline-block; */ 
        }
        .navbar {
            background-color: #967c63; /* Tomato-like theme */
        }
        .navbar-brand {
            color: #fff !important;
        }
        .recipe-card {
            margin-bottom: 30px;
            background-color: ivory;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }
        .recipe-card:hover {
            transform: scale(1.02); /* Slight zoom effect on hover */
        }
        .recipe-card img {
            max-height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            padding-left:25px;
            padding-top:5px;
        }
        .card-body {
            padding: 20px;
        }
        .like-btn {
            background: none;
            border: none;
            color: #ff6347;
            cursor: pointer;
            font-size: 20px;
        }
        .rating {
            display: flex;
            justify-content: flex-end;
            margin-top: 5px;
        }
        .rating input {
            display: none;
        }
        .rating label {
            cursor: pointer;
            color: #ddd;
            font-size: 25px;
            transition: color 0.2s;
        }
        .rating input:checked ~ label,
        .rating input:checked ~ label ~ input:checked ~ label {
            color: #ff6347;
        }
        .comment-section {
            display: none;
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 10px;
            margin-top: 15px;
        }
        .comment-toggle {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
            margin-top: 10px;
        }
        .comment-form textarea {
            width: 100%;
            height: 60px;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 5px;
        }
        .comment-form button {
            margin-top: 10px;
            background-color: #ff6347;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
        }
        .comment-form button:hover {
            background-color: #e55347; /* Darker shade on hover */
        }
    </style>
</head>
<body>

    <?php
    session_start(); // Start the session
    
// echo '<pre>'; print_r($_SESSION); echo '</pre>'; // Debugging line
?>
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Flavorful Finds</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
    <a class="nav-link" href="upload_recipe.php">Upload Recipe</a>
</li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Top Recipes</h1>

        <?php if (isset($_SESSION['username'])): ?>
        <h2 class="text-center">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <?php endif; ?>

        <div class="row">
        <?php
        // Fetching recipe details from the database
        $conn = new mysqli("localhost", "root", "", "flavorful_finds");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, title, description, image, likes, comments FROM recipes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4">
                    <div class="recipe-card">
                        <a href="recipe_detail.php?id=<?php echo $row['id']; ?>">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="img-fluid">
                            <div class="card-body">
                                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                <p><?php echo htmlspecialchars($row['description']); ?></p>
                            </div>
                        </a>
                        <div class="card-body">
                            <button class="like-btn" data-id="<?php echo $row['id']; ?>">
                                <i class="fas fa-thumbs-up"></i>
                            </button>
                            <span>Likes: <?php echo htmlspecialchars($row['likes']); ?></span>

                            <div class="rating">
                                <input type="radio" name="rating[<?php echo $row['id']; ?>]" id="star1_<?php echo $row['id']; ?>" value="5">
                                <label for="star1_<?php echo $row['id']; ?>" title="5 stars">&#9733;</label>
                                <input type="radio" name="rating[<?php echo $row['id']; ?>]" id="star2_<?php echo $row['id']; ?>" value="4">
                                <label for="star2_<?php echo $row['id']; ?>" title="4 stars">&#9733;</label>
                                <input type="radio" name="rating[<?php echo $row['id']; ?>]" id="star3_<?php echo $row['id']; ?>" value="3">
                                <label for="star3_<?php echo $row['id']; ?>" title="3 stars">&#9733;</label>
                                <input type="radio" name="rating[<?php echo $row['id']; ?>]" id="star4_<?php echo $row['id']; ?>" value="2">
                                <label for="star4_<?php echo $row['id']; ?>" title="2 stars">&#9733;</label>
                                <input type="radio" name="rating[<?php echo $row['id']; ?>]" id="star5_<?php echo $row['id']; ?>" value="1">
                                <label for="star5_<?php echo $row['id']; ?>" title="1 star">&#9733;</label>
                                <button class="submit-rating" data-id="<?php echo $row['id']; ?>">Submit Rating</button>
                            </div>
                            
                            <div class="comment-toggle" data-id="<?php echo $row['id']; ?>">Show Comments</div>
                            <div class="comment-section" data-id="<?php echo $row['id']; ?>">
                                <form class="comment-form" data-id="<?php echo $row['id']; ?>">
                                    <label for="comment">Comment:</label>
                                    <textarea name="comment" required></textarea>
                                    <button type="submit">Submit Comment</button>
                                </form>
                                <h4>Comments:</h4>
                                <p><?php echo htmlspecialchars($row['comments']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No recipes found.";
        }
        $conn->close();
        ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
    // Like button functionality
    $('.like-btn').click(function() {
        var recipeId = $(this).data('id');

        $.ajax({
            url: 'update_like.php', // PHP script to handle likes
            method: 'POST',
            data: { id: recipeId },
            success: function(likesCount) {
                // Update the likes count dynamically
                $('span:contains("Likes:")').filter(function() {
                    return $(this).prev().data('id') == recipeId;
                }).text('Likes: ' + likesCount);
            }
        });
    });

    // Star rating functionality
    $('.submit-rating').click(function() {
        var recipeId = $(this).data('id');
        var ratingValue = $('input[name="rating[' + recipeId + ']:checked"]').val();

        $.ajax({
            url: 'update_rating.php',
            method: 'POST',
            data: { id: recipeId, rating: ratingValue },
            success: function() {
                // Optionally, show a message or update the rating display
                // alert('Rating submitted successfully!');
            }
        });
    });

    // Comment section toggle
    $('.comment-toggle').click(function() {
        var recipeId = $(this).data('id');
        $('.comment-section[data-id="' + recipeId + '"]').toggle();
    });

    // Comment form submission
    $('.comment-form').submit(function(e) {
        // e.preventDefault(); // Prevent default form submission
        var recipeId = $(this).data('id');
        var comment = $(this).find('textarea[name="comment"]').val();

        $.ajax({
            url: 'update_comment.php', // PHP script to submit comment
            method: 'POST',
            data: { id: recipeId, comment: comment },
            success: function(response) {
                // Append the new comment to the comment section
                $('.comment-section[data-id="' + recipeId + '"] p').append('<p>' + comment + '</p>');
                $(this).find('textarea[name="comment"]').val(''); // Clear the textarea
            }.bind(this) // Bind to maintain context
        });
    });
</script>

</body>
</html>



