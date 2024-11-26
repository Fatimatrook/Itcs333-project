
<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'itcs333project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Fetch all rooms
$sql_rooms = "SELECT * FROM rooms";
$result_rooms = $conn->query($sql_rooms);

if ($result_rooms === false) {
    echo "<p>Error retrieving rooms: " . $conn->error . "</p>";
    $result_rooms = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Browsing - IT Room Booking System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
       :root {
            --first-color: #243642;
            --seconed-color: #387478;
            --third-color: #629584;
            --forth-color: #E2F1E7;
        }

        body {
            background-color: var(--forth-color);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: var(--first-color);
        }

        header.header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--seconed-color);
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header .logo img {
            height: 50px;
        }

        header .navbar a {
            color: var(--forth-color);
            margin: 0 10px;
            text-decoration: none;
            font-size: 16px;
        }

        header .navbar a:hover {
            color: var(--third-color);
        }

        header .icons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        header .search-form {
            display: none;
        }

        h3 {
            text-align: center;
            color: var(--first-color);
            margin: 20px 0;
        }

        .room-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .room-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 300px;
            text-align: center;
            transition: transform 0.3s;
        }

        .room-card:hover {
            transform: translateY(-5px);
        }

        .room-card img {
            width: 100%;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .room-card h4 {
            margin: 10px 0;
            font-size: 20px;
            color: var(--first-color);
        }

        .room-card p {
            margin: 5px 0 15px;
            font-size: 16px;
            color: var(--third-color);
        }

        .btn {
            display: inline-block;
            background-color: var(--seconed-color);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: var(--first-color);
        }
    </style>
</head>
<body>
<!-- Header Section -->
<header class="header">
        <!-- UOB Logo -->
        <a href="#" class="logo"><img src="images/UOB LOGO.png" alt="uob logo"></a>
        <!-- Navbar -->
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#about-us">About us</a>
            <a href="profile.php">Profile</a>
            <a href="#rooms">Rooms</a>
            <a href="#contact">Contact us</a>
            <a href="#reviews">Reviews</a>
        </nav>
        <!-- Icons -->
        <div class="icons">
            <div class="fas fa-search" id="search-btn"></div>
            <div class="fas fa-bars" id="menu-btn"></div>
        </div>
    </header>
<section class="home">
    <div class="content">
        <h3>Available Rooms</h3>

        <div class="room-list">
            <?php
           if ($result_rooms && $result_rooms->num_rows > 0) {
            while ($room = $result_rooms->fetch_assoc()) {
                // Display each room with a link to its details page
                echo '<div class="room">';
                echo '<h4>' . htmlspecialchars($room['room_name']) . '</h4>';
                echo '<p>Capacity: ' . htmlspecialchars($room['capacity']) . ' people</p>';
                echo '<a href="room_details.php?room_id=' . $room['id'] . '" class="btn">View Details</a>';
                echo '</div>';
            }
        }else{ echo"<p>No rooms available...</p>";

            }
            ?>
        </div>
    </div>
</section>

</body>
</html>

<?php $conn->close(); ?>