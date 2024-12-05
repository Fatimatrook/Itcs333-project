<?php
include 'sessionHandler.php';  // Include the header for navigat
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Panel</h1>
        <p>Select an option to manage the system:</p>
        
        <!-- Navigation Menu -->
        <div class="nav">
            <a href="admin.php">Admin Dashboard</a>
            <a href="room_management.php">Room Management System</a>
            <a href="schedule_management.php">Room Schedule Management</a>
            <a href="upcoming_bookings.php">Up Coming Booking</a>
            <a href="past_bookings.php">Past Booking</a>
            <a href="Room_Usages.php">Room Usages</a> 
            <a href="Analysis.php">Report Analysis</a>
        </div>

        <!-- Logout Button -->
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
