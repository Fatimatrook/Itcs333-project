
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

// Fetch available timeslots for booking
$sql_timeslots = "SELECT * FROM timeslots";
$result_timeslots = $conn->query($sql_timeslots);

// Handle room booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Assuming user is logged in and user_id is stored in session
    $room_id = $_POST['room_id'];
    $booking_date = $_POST['booking_date'];
    $timeslot = $_POST['timeslot'];

    // Check if the room is already booked for the selected date and timeslot
    $stmt_check = $conn->prepare("SELECT * FROM bookings WHERE room_id = ? AND booking_date = ? AND timeslot = ?");
    $stmt_check->bind_param("iss", $room_id, $booking_date, $timeslot);
    $stmt_check->execute();
    $stmt_check_result = $stmt_check->get_result();

    if ($stmt_check_result->num_rows > 0) {
        $_SESSION['booking_error'] = "This room is already booked for the selected date and timeslot.";
    } else {
        // Insert booking into the database
        $stmt_insert = $conn->prepare("INSERT INTO bookings (user_id, room_id, booking_date, timeslot) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("iiss", $user_id, $room_id, $booking_date, $timeslot);

        if ($stmt_insert->execute()) {
            $_SESSION['booking_success'] = "Room booked successfully!";
        } else {
            $_SESSION['booking_error'] = "Booking failed. Please try again.";
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
    header("Location: rooms.php"); // Refresh the page after booking
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="rooms.php">Rooms</a>
            <a href="profile.php">Profile</a>
            <a href="contact.php">Contact</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Main Section -->
    <section class="main-section">
        <?php
        // Show success or error messages for booking
        if (isset($_SESSION['booking_success'])) {
            echo "<p style='color:green'>" . $_SESSION['booking_success'] . "</p>";
            unset($_SESSION['booking_success']);
        }
        if (isset($_SESSION['booking_error'])) {
            echo "<p style='color:red'>" . $_SESSION['booking_error'] . "</p>";
            unset($_SESSION['booking_error']);
        }

        // Check if room_id is set for viewing details
        if (isset($_GET['room_id'])) {
            $room_id = $_GET['room_id'];

            // Fetch selected room details
            $stmt_room = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
            $stmt_room->bind_param("i", $room_id);
            $stmt_room->execute();
            $result_room = $stmt_room->get_result();
            $room = $result_room->fetch_assoc();

            // Fetch available timeslots for this room
            $stmt_timeslots = $conn->prepare("SELECT * FROM timeslots");
            $stmt_timeslots->execute();
            $result_timeslots = $stmt_timeslots->get_result();

            // Display room details
            echo "<h2>Room Details: " . htmlspecialchars($room['room_name']) . "</h2>";
            echo "<p><strong>Capacity:</strong> " . $room['capacity'] . " people</p>";
            echo "<p><strong>Equipment:</strong> " . htmlspecialchars($room['equipment']) . "</p>";
            ?>

            <!-- Booking Form for the Selected Room -->
            <h3>Available Timeslots</h3>
            <form action="rooms.php" method="POST">
                <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">

                <div class="timeslot-selection">
                    <label for="timeslot">Select Timeslot:</label>
                    <select name="timeslot" id="timeslot" required>
                        <?php while ($timeslot = $result_timeslots->fetch_assoc()): ?>
                            <option value="<?php echo $timeslot['id']; ?>">
                                <?php echo $timeslot['time']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="date-selection">
                    <label for="booking_date">Select Date:</label>
                    <input type="date" name="booking_date" id="booking_date" required>
                </div>

                <button type="submit" class="btn">Book Room</button>
            </form>

            <?php
            $stmt_room->close();
            $stmt_timeslots->close();
        } else {
            // Room Browsing: Display all available rooms
            echo "<h2>Browse Available Rooms</h2>";

            echo "<div class='room-grid'>";
            while ($room = $result_rooms->fetch_assoc()) {
                echo "<div class='room-card'>";
                echo "<h3>" . htmlspecialchars($room['room_name']) . "</h3>";
                echo "<p><strong>Capacity:</strong> " . $room['capacity'] . " people</p>";
                echo "<p><strong>Equipment:</strong> " . htmlspecialchars($room['equipment']) . "</p>";
                echo "<a href='rooms.php?room_id=" . $room['id'] . "' class='btn'>View Details</a>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>

    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 IT College. All Rights Reserved.</p>
    </footer>

</body>
</html>

<?php
$conn->close();
?>
