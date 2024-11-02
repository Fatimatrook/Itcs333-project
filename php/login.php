<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Room Booking System</title>

    <style>
        
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    height: 100vh; 
    display: flex; 
    justify-content: center;
    align-items: center; 
   
}
:root{
    --first-color:#243642;
    --seconed-color: #387478;
    --third-color:#629584;
    --forth-color: #E2F1E7;
}
html{
    font-size: 62.5%;
    overflow-x: hidden;
    scroll-padding-top: 9rem;
    scroll-behavior: smooth;
}

html::-webkit-scrollbar{
    width: .8rem;
}
html::-webkit-scrollbar-track{
    background: transparent;
}
html::-webkit-scrollbar-thumb{
    background: #ffffff;
    border-radius: 5rem;
}
body{
    background: var(--forth-color);
}
section{
    padding: 2rem 7%;
}
.btn{
    margin-top: 1rem;
    display: inline-block;
    padding: .9rem 3rem;
    font-size: 1.7rem;
    color: #fff;
    background:var(--first-color) ;
    cursor: pointer;
}
.btn:hover{
    letter-spacing: .1rem;
}
.header{
    background: var(--forth-color);
    display: flex;
    align-items: center;
    justify-content: space-between ;
    padding: 1.5rem 7%;
    border-bottom: var(--first-color);
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1000;
}
.header .logo img{
    height: 6rem;
}
.header .navbar a{
    margin:0 1rem;
    font-size: 1.6rem;
    color: var(--first-color);
}
.header .navbar a:hover{
    color: var(--seconed-color);
    border-bottom: .1rem solid var(--seconed-color);
    padding-bottom: .5rem;
}
.header .icons div{
    color: var(--first-color);
    cursor: pointer;
    font-size: 2.5rem;
    margin-left: 2rem;
}
.header .icons div:hover{
    color: var(--seconed-color);
}
#menu-btn{
    display: none;
}
.header .search-form{
    position: absolute;
    top: 115%; right: 7%;
    background: var(--forth-color);
    width: 50rem;
    height: 5rem;
    display: flex;
    align-items: center;
    transform: scaleY(0);
    transform-origin: top;
}
.header .search-form.active{
    transform: scaleY(1);

}
.header .search-form input{
    height: 100%;
    width: 100%;
    font-size: 1.6rem;
    color: #000;
    padding: 1rem;
    text-transform: none;
}
.header .search-form label{
    cursor: pointer;
    font-size: 2.2rem;
    margin-right: 1.5rem;
    color: #000;
}
.header .search-form label:hover{
  color: var(--first-color);
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
    background: var(--forth-color); 
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
    background: var(--third-color);
    color: white; 
    border: none; 
    border-radius: 4px; 
    cursor: pointer; 
    font-size: 16px;}

/* Button hover effect */
.btn:hover {
    background: var(--secound-color);}

/* Style for the sign-up link */
p {
    text-align: center; 
    margin-top: 15px;
    color: var(--secound-color);; }

a {
    color: #007bff; 
    text-decoration: none; }

a:hover {
    text-decoration: underline; }

</style>
</head>
<body>
    <!--Header start-->    
    <header class="header">
        
        <!-- this is for  uob logo-->
        <a href="#" class="logo"><img src="images/UOB LOGO.png" alt="uob logo"></a>
        <!-- this is for  uob logo end-->    
        
        <!--navbar-->
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#about">About us</a>
            <a href="php/login.php">Log in</a>
            <a href="#rooms">Rooms</a>
            <a href="#contact">Contact us</a>
            <a href="#reviews">Reviews</a>
        </nav>
        <!--navbar end-->
        <div class="icons">
            <div class="fas fa-search" id="search-btn"></div>
            <div class="fas fa-bars" id="menu-btn"></div>
        </div>

        <div class="search-form">
            <input type="search" id="search-box" placeholder="search here...">
            <label for="search-box" class="fas fa-search"></label>
        </div>
    </header>
    <!--Header end-->

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