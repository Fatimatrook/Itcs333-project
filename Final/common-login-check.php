<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password1 = $_POST['password'];
   // SQL query to get the user record by email
    $sql = "SELECT * FROM registration WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // User found, fetch user details
        $user = $result->fetch_assoc();
        // Verify the password using password_verify
        if (password_verify($password1, $user['password'])) {
            // Password is correct, save user details in the session
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            echo '<script>alert("Login successful!");</script>';
            echo '<script>window.location.href = "Home.php";</script>';

            // Redirect to a protected page
        } else {
            // Invalid password
            echo '<script>alert("Invalid password!");</script>';
        }
    } else {
        // User not found
        echo '<script>alert("No user found with that email!");</script>';
    }

    // Close the connection
    $conn->close();
}
?>