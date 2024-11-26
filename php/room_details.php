<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'itcs333project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the room_id from the URL
if (isset($_GET['room_id'])) {
    $room_id = intval($_GET['room_id']);
} else {
    // Redirect if no room_id is provided
    header("Location: rooms.php");
    exit();
}

// Fetch the details of the selected room
$sql_room_details = "SELECT * FROM rooms WHERE id = ?";
$stmt = $conn->prepare($sql_room_details);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p>Room not found.</p>";
    exit();
}

$room = $result->fetch_assoc();
$stmt->close();

// Handle booking logic here
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; 
    $room_id = $room['id'];
    $booking_date = $_POST['booking_date'];
    $timeslot = $_POST['timeslot'];

    // Check if the room is already booked for the selected date and timeslot
    $stmt_check = $conn->prepare("SELECT * FROM bookings WHERE room_id = ? AND booking_date = ? AND timeslot = ?");
    $stmt_check->bind_param("iss", $room_id, $booking_date, $timeslot);
    $stmt_check->execute();
    $stmt_check_result = $stmt_check->get_result();

    if ($stmt_check_result->num_rows == 0) {
        // Proceed with booking the room
        $stmt_book = $conn->prepare("INSERT INTO bookings (user_id, room_id, booking_date, timeslot) VALUES (?, ?, ?, ?)");
        $stmt_book->bind_param("iiss", $user_id, $room_id, $booking_date, $timeslot);
        $stmt_book->execute();
        $_SESSION['booking_success'] = "Room booked successfully!";
        $stmt_book->close();
    } else {
        $_SESSION['booking_error'] = "This room is already booked for the selected date and timeslot.";
    }

    $stmt_check->close();
    header("Location: room-details.php?room_id=$room_id"); 
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details - IT Room Booking System</title>
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
            align-items: flex-start; 
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
            width: 40px;
            height: 40px;
            float: left;
            border-radius: 10px;
            margin-bottom: 10px;
            margin-right: 40px; 
        }

        .room-card h4 {
            margin: 10px 0;
            font-size: 20px;
            color: var(--first-color);
        }

        .room-card p {
            margin-bottom: 20px;
            font-size: 16px;
            color: var(--third-color);
        }

        .btn {
            display: flex;
            background-color: var(--seconed-color);
            width: 100%; 
            justify-content: space-between; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center; 
            flex: 1; 
            margin: 0 5px; 
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: var(--first-color);
        }
    </style>
</head>
<body>

<section class="home">
    <div class="content">
        <h3>Room Details</h3>

        <div class="room-details">
        <?php
if (!empty($room['image'])) {
    echo '<img src="images/' . htmlspecialchars($room['image']) . '" alt="' . htmlspecialchars($room['room_name']) . '" style="width:100%;max-width:400px;border-radius:10px;margin-bottom:20px;">';
}
?>
            <h4><?php echo htmlspecialchars($room['room_name']); ?></h4>
            <p><strong>Capacity:</strong> <?php echo htmlspecialchars($room['capacity']); ?> people</p>
            <p><strong>Equipment:</strong> <?php echo htmlspecialchars($room['equipment']); ?></p>

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

            <h4>Book this Room</h4>
            <form action="room-details.php?room_id=<?php echo $room['id']; ?>" method="POST">
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
    </div>
</section>

</body>
</html>

<?php $conn->close(); ?>


