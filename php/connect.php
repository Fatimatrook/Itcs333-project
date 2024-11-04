<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'itcs333project');

if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $number = trim($_POST['number']);
    $gender = $_POST['gender'];

    // Validate input
    if (empty($username) || empty($password) || !$email || empty($number) || empty($gender)) {
        $_SESSION['registration_error'] = "All fields are required and email must be valid.";
        header("Location: registration.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO registration (username, password, email, number, gender) VALUES (?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters 
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $number, $gender);
    
    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['registration_success'] = "Registration successful. You can now log in.";
    } else {
        $_SESSION['registration_error'] = "Error executing statement: " . htmlspecialchars($stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to login page or show success message
    header("Location: login.php");
    exit();
}
?>
