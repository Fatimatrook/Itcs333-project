<?php

session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'itcs333project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch rooms from the database
$sql_rooms = "SELECT * FROM rooms";
$result_rooms = $conn->query($sql_rooms);

// Check if a room has been selected for booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['room_id'])) {
    $user_id = $_SESSION['user_id']; // Assuming you have a user session
    $room_id = $_POST['room_id'];
    $booking_date = $_POST['booking_date'];
    $timeslot = $_POST['timeslot'];

    // Check if the room is already booked for the selected date and time
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE room_id = ? AND booking_date = ? AND timeslot = ?");
    $stmt->bind_param("iss", $room_id, $booking_date, $timeslot);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows == 0) {
        // Insert new booking into the database
        $stmt_insert = $conn->prepare("INSERT INTO bookings (user_id, room_id, booking_date, timeslot) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("iiss", $user_id, $room_id, $booking_date, $timeslot);

        if ($stmt_insert->execute()) {
            $_SESSION['booking_success'] = "Room booked successfully!";
        } else {
            $_SESSION['booking_error'] = "Booking failed. Please try again.";
        }

        $stmt_insert->close();
    } else {
        $_SESSION['booking_error'] = "This room is already booked for the selected date and timeslot.";
    }

    $stmt->close();
    header("Location: rooms.php"); 
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Rooms - IT Room Booking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="room-browsing">
    <div class="content">
        <h3>Browse Available Rooms</h3>

        <!-- Display success or error message after booking -->
        <?php
        if (isset($_SESSION['booking_success'])) {
            echo "<p style='color:green'>" . $_SESSION['booking_success'] . "</p>";
            unset($_SESSION['booking_success']);
        }
        if (isset($_SESSION['booking_error'])) {
            echo "<p style='color:red'>" . $_SESSION['booking_error'] . "</p>";
            unset($_SESSION['booking_error']);
        }
        ?>

        <?php if ($result_rooms->num_rows > 0): ?>
            <form action="rooms.php" method="POST">
                <div class="form-group">
                    <label for="room_id">Select Room:</label>
                    <select id="room_id" name="room_id" required>
                        <?php while ($room = $result_rooms->fetch_assoc()): ?>
                            <option value="<?php echo $room['id']; ?>">
                                <?php echo htmlspecialchars($room['room_name']) . " (Capacity: " . $room['capacity'] . ")"; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="booking_date">Select Date:</label>
                    <input type="date" id="booking_date" name="booking_date" required>
                </div>

                <div class="form-group">
                    <label for="timeslot">Select Timeslot:</label>
                    <input type="time" id="timeslot" name="timeslot" required>
                </div>

                <button type="submit" class="btn">Book Room</button>
            </form>
        <?php else: ?>
            <p>No rooms available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

