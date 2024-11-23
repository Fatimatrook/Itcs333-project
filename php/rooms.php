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

// Get the room_id from the URL query parameter
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $user_id = $_SESSION['user_id'];
    $room_id = $_POST['room_id'];
    $booking_date = $_POST['booking_date'];
    $timeslot = $_POST['timeslot'];

    // Check if the room is available for the selected date and timeslot
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE room_id = ? AND booking_date = ? AND timeslot = ?");
    $stmt->bind_param("iss", $room_id, $booking_date, $timeslot);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows == 0) {
        // Room is available, proceed with booking
        $stmt_insert = $conn->prepare("INSERT INTO bookings (user_id, room_id, booking_date, timeslot) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("iiss", $user_id, $room_id, $booking_date, $timeslot);

        if ($stmt_insert->execute()) {
            $_SESSION['booking_success'] = "Room booked successfully!";
        } else {
            $_SESSION['booking_error'] = "Booking failed. Please try again.";
        }
        $stmt_insert->close();
    } else {
        // Room is already booked for the selected date and timeslot
        $_SESSION['booking_error'] = "This room is already booked for the selected date and timeslot.";
    }
    $stmt->close();
    header("Location: booking.php?room_id=" . $room_id); // Reload the page with the same room_id
    exit();
}

// If a room_id is provided in the URL, fetch its details
if ($room_id) {
    $room_sql = "SELECT * FROM rooms WHERE id = ?";
    $stmt = $conn->prepare($room_sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $room_result = $stmt->get_result();

    if ($room_result->num_rows > 0) {
        $room = $room_result->fetch_assoc(); // Fetch room details
    } else {
        $_SESSION['booking_error'] = "Room not found.";
        header("Location: rooms.php"); // Redirect to rooms page if room not found
        exit();
    }
    $stmt->close();
} else {
    $_SESSION['booking_error'] = "No room selected.";
    header("Location: rooms.php"); // Redirect to rooms page if no room_id is passed
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking - IT Room Booking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="home">
    <div class="content">
        <h3>Room Booking: <?php echo htmlspecialchars($room['room_name']); ?></h3>

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

        <form action="booking.php" method="post">
            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">

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
    </div>
</section>

</body>
</html>

<?php
$conn->close();
?>
