<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'itcs333project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch rooms from the database
$sql_rooms = "SELECT * FROM rooms";
$result_rooms = $conn->query($sql_rooms);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Room Browsing - IT Room Booking System</title>
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

<h1>Available Rooms</h1>
<div class="room-container">
    <?php while ($room = $result_rooms->fetch_assoc()): ?>
        <div class="room-card" data-room-id="<?php echo $room['id']; ?>">
            <h3><?php echo htmlspecialchars($room['room_name']); ?></h3>
            <p>Capacity: <?php echo $room['capacity']; ?></p>
            <p>Equipment: <?php echo htmlspecialchars($room['equipment']); ?></p>
            <a href="booking.php?room_id=<?php echo $room['id']; ?>" class="btn">Book Now</a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>