<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Flavorful Finds</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="cacc.css"> <!-- Link to your CSS file -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-fluid h-100 d-flex">
        <div class="image-half"></div> <!-- Image on one half -->
        <div class="form-half d-flex justify-content-center align-items-center">
            <form id="createAccountForm" class="create-account-form" action="chumma.php" method="POST">
                <h2 class="form-title">Create Your Account</h2>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Join the Recipe Revolution</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- <script>
        document.getElementById('createAccountForm').addEventListener('submit', function(event) { -->
            <!-- // Prevent form submission
            // event.preventDefault();

            // Get the values from the form fields
            const name = document.getElementById('name').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            // Validate form fields
            if (!name) {
                alert('Please enter your name.');
                return;
            }

            if (!password || !confirmPassword) {
                alert('Please enter your password and confirm it.');
                return;
            }

            // Password conditions
            const passwordConditions = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!passwordConditions.test(password)) {
                alert('Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one digit, and one special character (e.g., @, #, $, %, &).');
                return;
            }

            if (password !== confirmPassword) {
                alert('Passwords do not match. Please try again.');
                return;
            }

            // If validation passes, you can proceed with form submission (or further processing)
            alert('Account created successfully!'); // For demonstration purposes

            // Optionally, you can submit the form if you have a server-side script
            // this.submit(); // Uncomment to allow form submission
        }); -->
    <!-- </script> -->
</body>
</html>
