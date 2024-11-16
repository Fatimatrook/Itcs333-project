<?php
include 'common-db-settings.php'; 
include 'common-login-check.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Login - IT Room Booking System</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <!-- Include Footer -->
<?php include 'Header.php'; ?>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Name@mail.com" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="*********" required>
            </div>
            <!-- Signup link -->
            <div class="links">
                <a href="Register.php">Signup Now</a>
            </div>
            <!-- Submit button -->
            <button type="submit" class="oval-button">Login</button>
            <!-- Forgot Password link -->
            <div class="links">
                <a href="/forgot-password">Forgot Password?</a>
            </div>
        </form>
    </div>
</body>
</html>
