<?php
session_start();

// Simple in-memory storage (replace with database in real-world scenario)
if (!isset($_SESSION["users"])) {
    $_SESSION["users"] = [];
}

$users = &$_SESSION["users"]; // Use reference to avoid global keyword

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $number = trim($_POST['number']);
    $gender = $_POST['gender'];

    // Check for empty fields and valid email
    if (empty($username) || empty($password) || !$email || empty($number) || empty($gender)) {
        $_SESSION['registration_error'] = "All fields are required and email must be valid.";
        header("Location: registration.php");
        exit();
    }

    // Check if username already exists
    if (isset($users[$username])) {
        $_SESSION['registration_error'] = "Username already exists.";
        header("Location: registration.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Store user details (consider storing additional details like email, number, gender in a real database)
    $users[$username] = [
        'password' => $hashed_password,
        'email' => $email,
        'number' => $number,
        'gender' => $gender,
    ];

    $_SESSION['registration_success'] = "Registration successful. You can now log in.";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
    :root {
    --first-color: #243642;
    --second-color: #387478;
    --third-color: #629584;
    --forth-color: #E2F1E7;}
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    height: 100vh; 
    display: flex; 
    justify-content: center;
    align-items: center; 
    background: var(--forth-color);}

    h2 {
    color: #333;
    margin: 0px;
    text-align: center;
    margin-bottom: 20px;}

    form {
    background: var(--forth-color); 
    padding: 20px; 
    border-radius: 8px; 
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
    width: 400px; 
    height: 500px; }

    .input-group {margin-bottom: 15px; }

    label {
    display: block; 
    margin-top: 10px;
    margin-bottom: 2px;
    color: #555; }

    input[type="text"], input[type="password"], input[type="email"], input[type="number"] {
    width: 100%; 
    padding: 10px; 
    border: 1px solid #ccc; 
    border-radius: 4px; 
    box-sizing: border-box;}

    input[type="submit"] {
    width: 100%; 
    padding: 10px; 
    background: var(--third-color);
    color: white; 
    border: none; 
    border-radius: 4px; 
    cursor: pointer; 
    font-size: 16px;}
    input[type="submit"]:hover {background: var(--forth-color);}

    p {
    text-align: center; 
    margin-top: 550px;
    margin-right: 30%;
    color: var(--second-color);
    }

    a {
    color: #007bff; 
    text-decoration: none; }
    a:hover {text-decoration: underline; }

    .error {
    color: red;
    text-align: center;}

</style>
</head>
<body>
    <h2>Register</h2>
    <form action="connect.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="number">Number:</label>
        <input type="number" id="number" name="number" required><br><br>

        <label for="gender">Gender:</label><label for="male" class="radio">
        <input type="radio" id="male" name="gender" value="M">Male</label>
        <input type="radio" id="female" name="gender" value="F">Female</label><br><br>
        
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>