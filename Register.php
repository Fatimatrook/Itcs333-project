<?php
include 'common-db-settings.php'; 
include 'new_reg.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Registration - IT Room Booking System</title>
    <link rel="stylesheet" href="styles1.css"> 
    <script>
</script>
</head>
<body>
    <div class="login-container">
        <h2>Registration</h2>
        <form action="Register.php" method="POST" onsubmit="return validateEmail()">
             <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="firstname" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lastname" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-phone"></i>
                <input type="tel" name="phone" placeholder="Phone Number" required>
            </div>
            <div class="form-group">
                <i class="fas fa-venus-mars"></i>
                <select name="gender" id="gender" required>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                </select>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="oval-button">Register</button>
        </form>
        <div class="links">
            <a href="login.php">Already Registered? Login Here</a>
        </div>
         <!-- Link to the external script -->
    <script src="validation.js"></script>
    </div>
</body>
</html>
