<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    height: 100vh; 
    display: flex; 
    justify-content: center;
    align-items: center; 
}

/* Header style */
.header {
    text-align: center;
    margin-bottom: 20px; 
}

/* Style the heading */
h2 {
    color: #333;
    margin: 0; 
}

/* Form style */
form {
    background-color: white; 
    padding: 20px; 
    border-radius: 8px; 
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
    max-width: 400px; 
    width: 100%; 
}

/* Style for input groups */
.input-group {
    margin-bottom: 15px; 
}

/* Style for labels */
label {
    display: block; 
    margin-bottom: 5px;
    color: #555; 
}

/* Style for input fields */
input[type="text"] {
    width: 100%; 
    padding: 10px; 
    border: 1px solid #ccc; 
    border-radius: 4px; 
    box-sizing: border-box; 
}

/* Style for submit button */
.btn {
    width: 100%; 
    padding: 10px; 
    background-color: #007bff; 
    color: white; 
    border: none; 
    border-radius: 4px; 
    cursor: pointer; 
    font-size: 16px;}

/* Button hover effect */
.btn:hover {
    background-color: #0056b3; }

/* Style for the sign-up link */
p {
    text-align: center; 
    margin-top: 15px; }

a {
    color: #007bff; 
    text-decoration: none; }

a:hover {
    text-decoration: underline; }

</style>
</head>
<body>
   
    <form method="post" action="login(1).php">
        
        <div class="input-group">
            <label>username or email</label>
            <input type="text" name="email" required>
        </div>

        <div class="input-group">
            <label>password</label>
            <input type="text" name="password" required>
        </div>

        <div class="input-group">
            <button type="submit" class="btn" name="Login">Login</button>
        </div>
        <p>Already have Account? <a href="register.php">Sign up</a></p>
    
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$email = $_POST['email']?? '';
$password = $_POST['password']?? '';

$con = new mysqli('localhost','root','','project333');
if($con->connect_error){
    error_log("Connection failed: " . $con->connect_error);
        die("Failed to connect.");
} else {
    $stmt = $con->prepare("select * from registration where email =?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt_result= $stmt->get_result();
    if($stmt_result->num_rows > 0){
     $data = $stmt_result->fetch_assoc();
     if (password_verify($password, $data['password'])) {
     echo"successfully login";}
    else{
        echo"Invalid Email or Password";}
    }else{
        echo"Invalid Email or Password";
    }
    $stmt->close();
    $con->close();
}}
?>