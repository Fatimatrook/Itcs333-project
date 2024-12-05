<?php
session_start();
include '../common-db-settings.php'; // Include the database 
include 'header.php';  

// Variables for Add/Edit actions
$action = $_GET['action'] ?? 'list'; // Determines current action
$id = $_GET['id'] ?? null;           // Booking ID for Edit/Delete
$message = $_SESSION['message'] ?? ''; // Retrieve message from session
unset($_SESSION['message']); // Clear the session message after displaying

// Fetch room details
$rooms = $conn->query("SELECT id, room_name, capacity FROM rooms");

// Handle Add or Edit form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Check if the booking conflicts with existing bookings
    if (check_booking_conflict($conn, $room_id, $start_date, $end_date, $start_time, $end_time, $id)) {
        $_SESSION['message'] = "Conflict detected! The room is already booked for the specified dates and times.";
    } else {
        if ($action == 'add') {
            // Add booking
            $stmt = $conn->prepare("INSERT INTO bookings (room_id, user_name, user_email, start_date, end_date, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $room_id, $user_name, $user_email, $start_date, $end_date, $start_time, $end_time);
            $stmt->execute();
            $_SESSION['message'] = "Booking added successfully!";
        } elseif ($action == 'edit' && $id) {
            // Update booking
            $stmt = $conn->prepare("UPDATE bookings SET room_id = ?, user_name = ?, user_email = ?, start_date = ?, end_date = ?, start_time = ?, end_time = ? WHERE id = ?");
            $stmt->bind_param("issssssi", $room_id, $user_name, $user_email, $start_date, $end_date, $start_time, $end_time, $id);
            $stmt->execute();
            $_SESSION['message'] = "Booking updated successfully!";
        }
    }
    header("Location: schedule_management.php");
    exit;
}

// Handle Delete action
if ($action == 'delete' && $id) {
    $conn->query("DELETE FROM bookings WHERE id = $id");
    $_SESSION['message'] = "Booking deleted successfully!";
    header("Location: schedule_management.php");
    exit;
}

// Fetch all bookings for listing
$bookings = $conn->query("SELECT * FROM bookings");
$current_booking = null;

// Fetch current booking data for editing
if ($action == 'edit' && $id) {
    $current_booking = $conn->query("SELECT * FROM bookings WHERE id = $id")->fetch_assoc();
}

// Function to check for booking conflicts
function check_booking_conflict($conn, $room_id, $start_date, $end_date, $start_time, $end_time, $exclude_id = null) {
    $query = "SELECT * FROM bookings 
              WHERE room_id = ? 
              AND (
                  (start_date <= ? AND end_date >= ?) OR
                  (start_date >= ? AND start_date <= ?) OR
                  (end_date >= ? AND end_date <= ?)
              )";

    if ($exclude_id) {
        $query .= " AND id != ?";
    }

    $stmt = $conn->prepare($query);

    if ($exclude_id) {
        $stmt->bind_param("issssssi", $room_id, $end_date, $start_date, $start_date, $end_date, $start_date, $end_date, $exclude_id);
    } else {
        $stmt->bind_param("issssss", $room_id, $end_date, $start_date, $start_date, $end_date, $start_date, $end_date);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Management</title>
    <link rel="stylesheet" href="../css/style4.css">
</head>
<body>
    <div class="container">
        <h1>Room Booking Schedule</h1>

        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <!-- Booking List -->
        <?php if ($action == 'list'): ?>
            <a href="schedule_management.php?action=add" class="btn">Add Booking</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room ID</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['room_id']) ?></td>
                            <td><?= htmlspecialchars($row['user_name']) ?></td>
                            <td><?= htmlspecialchars($row['user_email']) ?></td>
                            <td><?= htmlspecialchars($row['start_date']) ?></td>
                            <td><?= htmlspecialchars($row['end_date']) ?></td>
                            <td><?= htmlspecialchars($row['start_time']) ?></td>
                            <td><?= htmlspecialchars($row['end_time']) ?></td>
                            <td>
                                <a href="schedule_management.php?action=edit&id=<?= $row['id'] ?>">Edit</a> | 
                                <a href="schedule_management.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Add/Edit Form -->
        <?php if ($action == 'add' || $action == 'edit'): ?>
            <form method="POST">
                <label>Room:</label>
                <select name="room_id" required>
                    <option value="">Select a Room</option>
                    <?php while ($room = $rooms->fetch_assoc()): ?>
                        <option value="<?= $room['id'] ?>" 
                            <?= (isset($current_booking['room_id']) && $current_booking['room_id'] == $room['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($room['room_name']) ?> (Capacity: <?= $room['capacity'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>User Name:</label>
                <input type="text" name="user_name" value="<?= htmlspecialchars($current_booking['user_name'] ?? '') ?>" required>

                <label>User Email:</label>
                <input type="email" name="user_email" value="<?= htmlspecialchars($current_booking['user_email'] ?? '') ?>" required>

                <label>Start Date:</label>
                <input type="date" name="start_date" 
                       value="<?= $current_booking['start_date'] ?? date('Y-m-d') ?>" required>

                <label>End Date:</label>
                <input type="date" name="end_date" 
                       value="<?= $current_booking['end_date'] ?? date('Y-m-d') ?>" required>

                <label>Start Time:</label>
                <input type="time" name="start_time" 
                       value="<?= $current_booking['start_time'] ?? '00:01' ?>" required>

                <label>End Time:</label>
                <input type="time" name="end_time" 
                       value="<?= $current_booking['end_time'] ?? '23:59' ?>" required>

                <button type="submit"><?= $action == 'add' ? 'Add Booking' : 'Update Booking' ?></button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
