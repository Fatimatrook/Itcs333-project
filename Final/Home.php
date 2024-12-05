<?php
include 'sessionHandler.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/header.css">
    <title>IT Room Booking System</title>
</head>
<body>
    <header class="header">
        <!-- Logo -->
        <a href="#" class="logo"><img src="images/UOB LOGO.png" alt="UOB logo"></a>
        <!-- Navbar -->
        <nav class="navbar">
            <a href="#home">Home</a>
            <div class="dropdown">
                <a href="#">Booking</a>
                <div class="dropdown-content">
                    <a href="NewBooking.php">Room Booking</a>
                    <a href="CanclatioBooking.php">Cancellation Booking</a>
                </div>
            </div>
            <a>About us</a>
            <a>Profile</a>
            <a>Rooms</a>
            <a>Contact us</a>
            <a>Reviews</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
</body>
