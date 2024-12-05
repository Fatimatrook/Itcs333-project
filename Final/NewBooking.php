<?php
session_start(); // Start the session to access $_SESSION variables
include 'Home.php'; // Include the header for the page
include 'common-db-settings.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $user_name = $_SESSION['username']; // Pre-filled from session
    $user_email = $_SESSION['email'];   // Pre-filled from session
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $start_time = $_POST['start_time'] ?: '00:01:00'; // Default to 12:01 AM
    $end_time = $_POST['end_time'] ?: '23:59:00';     // Default to 11:59 PM

    // Conflict checking query
    $conflict_query = "
        SELECT * FROM bookings
        WHERE room_id = ? 
        AND (
            (? BETWEEN start_date AND end_date OR ? BETWEEN start_date AND end_date)
            OR
            (start_date BETWEEN ? AND ? OR end_date BETWEEN ? AND ?)
        )
        AND (
            (start_time < ? AND end_time > ?) OR 
            (start_time < ? AND end_time > ?) OR
            (start_time >= ? AND end_time <= ?)
        )";
    
    $stmt = $conn->prepare($conflict_query);
    $stmt->bind_param(
        "isssssssissss",
        $room_id,
        $start_date,
        $end_date,
        $start_date,
        $end_date,
        $start_date,
        $end_date,
        $end_time,
        $start_time,
        $start_time,
        $end_time,
        $start_time,
        $end_time
    );
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<script>alert("The selected room is already booked for the specified period and time.");</script>';
    } else {
        // Insert booking
        $insert_query = "
            INSERT INTO bookings (room_id, user_name, user_email, start_date, end_date, start_time, end_time)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param(
            "issssss",
            $room_id,
            $user_name,
            $user_email,
            $start_date,
            $end_date,
            $start_time,
            $end_time
        );
        
        if ($stmt->execute()) {
            echo '<script>alert("Booking successfully added!");</script>';
        } else {
            echo '<script>alert("Error occurred while adding the booking. Please try again.");</script>';
        }
    }
}

// Fetch available rooms
$query = "SELECT id, room_name, capacity, equipment, image FROM rooms";
$rooms = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 1.2em;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            font-size: 1em;
            border: 2px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #4CAF50;
        }

        .form-group input[type="date"], .form-group input[type="time"] {
            max-width: 200px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .room-image {
            text-align: center;
            margin-top: 20px;
        }

        .room-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .form-group input[readonly] {
            background-color: #f9f9f9;
        }

        select {
            padding: 12px;
        }

        .form-group input[type="email"] {
            background-color: #f9f9f9;
        }
        .row-group {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Space between elements */
    justify-content: space-between;
}

.row-group .sub-group {
    flex: 1 1 calc(50% - 10px); /* Flexible layout for each field */
    min-width: 150px; /* Ensures proper sizing on small screens */
}

.row-group label {
    display: block;
    margin-bottom: 5px;
    font-size: 1em;
    color: #555;
}

.row-group input {
    width: 100%;
    padding: 10px;
    font-size: 1em;
    border: 2px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

.row-group input:focus {
    border-color: #4CAF50;
}


    </style>
    <script>
        // Function to update room image based on selected room
        function updateRoomImage() {
            var roomId = document.getElementById('room_id').value;
            var imageUrl = document.getElementById('room_image_' + roomId).src;
            document.getElementById('room_image_display').src = imageUrl;
        }
    // Function to set the default start date to today's date
    window.onload = function () {
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0]; // Format date as YYYY-MM-DD
        document.getElementById('start_date').value = formattedDate;
    };

    </script>
</head>

<body>
    <div class="container">
        <h1>Room Booking</h1>

        <form action="NewBooking.php" method="POST">
            <div class="form-group">
                <label for="room_id">Room:</label>
                <select id="room_id" name="room_id" required onchange="updateRoomImage()">
                    <option value="">Select a Room</option>
                    <?php while ($room = $rooms->fetch_assoc()) { ?>
                        <option value="<?php echo $room['id']; ?>"><?php echo $room['room_name']; ?> (<?php echo $room['capacity']; ?> people)</option>
                        <!-- Store room image in hidden image tags -->
                        <img id="room_image_<?php echo $room['id']; ?>" src="images/<?php echo $room['image']; ?>" style="display:none;" />
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="user_name">Your Name:</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo $_SESSION['username']; ?>">
            </div>

            <div class="form-group">
                <label for="user_email">Your Email:</label>
                <input type="email" id="user_email" name="user_email" value="<?php echo $_SESSION['email']; ?>">
            </div>

            <div class="form-group row-group">
    <div class="sub-group">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
    </div>
    <div class="sub-group">
        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" value="00:01" required>
    </div>
    <div class="sub-group">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
    </div>
    <div class="sub-group">
        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" value="23:59" required>
    </div>
</div>

            <button type="submit">Book Room</button>
        </form>

        <!-- Display Room Image -->
        <div class="room-image">
            <img id="room_image_display" src="" alt="Room Image" />
        </div>
    </div>
</body>
</html>
