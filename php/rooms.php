<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'itcs333project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch room data from the database (You can update with real data fetching)
$sql_rooms = "SELECT * FROM rooms";
$result_rooms = $conn->query($sql_rooms);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking System</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Function to display room details when a room image is clicked
        function showRoomDetails(roomId) {
            const allDetails = document.querySelectorAll('.room-details');
            allDetails.forEach(detail => detail.style.display = 'none');
            
            const selectedRoomDetail = document.getElementById('room-' + roomId);
            if (selectedRoomDetail) {
                selectedRoomDetail.style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <!-- Header Start -->
    <header class="header">
        <a href="home.php" class="logo"><img src="images/UOB_LOGO.png" alt="UOB Logo"></a>
        <div class="icons">
            <div class='bx bxs-user-circle'></div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Room Browsing Section Start -->
    <section class="home">
        <div class="content">
            <h3>Available Rooms for Booking</h3>
        </div>
    </section>

    <section class="room-list">
        <!-- Room Items Display -->
        <?php while ($room = $result_rooms->fetch_assoc()): ?>
            <div class="room-item" onclick="showRoomDetails(<?php echo $room['id']; ?>)">
                <img src="images/<?php echo $room['room_image']; ?>" alt="<?php echo $room['room_name']; ?>" />
                <h2><?php echo $room['room_name']; ?></h2>
            </div>
        <?php endwhile; ?>
    </section>

    <section>
        <!-- Room Details (Initially hidden) -->
        <?php 
        // Fetching the room details for each room dynamically
        $result_rooms->data_seek(0);  // Reset result pointer for looping
        while ($room = $result_rooms->fetch_assoc()):
        ?>
            <div id="room-<?php echo $room['id']; ?>" class="room-details" style="display: none;">
                <h2><?php echo $room['room_name']; ?> - Detailed Information</h2>
                <p><strong>Capacity:</strong> <?php echo $room['capacity']; ?> people</p>
                <p><strong>Available Equipment:</strong> <?php echo $room['equipment']; ?></p>

                <h3>Available Time Slots</h3>
                <ul>
                    <!-- Display available timeslots dynamically if applicable -->
                    <?php 
                    $timeslots = explode(',', $room['available_timeslots']); // Assuming timeslots are stored in DB as comma-separated values
                    foreach ($timeslots as $slot):
                    ?>
                        <li><?php echo $slot; ?></li>
                    <?php endforeach; ?>
                </ul>

                <!-- Book Room Button -->
                <a href="booking.php?room=<?php echo $room['id']; ?>" class="booking-btn">Book Room <?php echo $room['room_name']; ?></a>
            </div>
        <?php endwhile; ?>
    </section>
    
    <!-- Footer Section Start -->
    <footer>
        <p>© 2024 IT Room Booking System</p>
    </footer>
    <!-- Footer Section End -->
</body>
</html>

<?php $conn->close(); ?>
