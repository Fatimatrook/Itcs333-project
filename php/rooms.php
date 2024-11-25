
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
        /* Basic styles for the rooms page */
        body {
            background-color: var(--forth-color);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .room-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .room-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        .room-card h3 {
            margin: 0 0 10px;
            font-size: 24px;
            color: var(--first-color);
        }

        .room-card p {
            margin: 5px 0;
            color: #555;
        }

        .room-card .btn {
            background-color: var(--seconed-color);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .room-card .btn:hover {
            background-color: var(--first-color);
        }
    </style>
</head>
<body>

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
                echo '<a href="room-details.php?room_id=' . $room['id'] . '" class="btn">View Details</a>';
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