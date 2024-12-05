<?php
include '../common-db-settings.php'; // Include the database connection
include 'header.php'; 
include 'sessionHandler.php';  // Include the header for navigatio

// Default query for all past bookings
$query = "SELECT * FROM bookings WHERE end_date < CURDATE() ORDER BY end_date DESC";

// Initialize the start_date and end_date values
$start_date = '';
$end_date = '';

// Check if filter is applied
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    // Modify the query to filter bookings between selected start and end date
    $query = "SELECT * FROM bookings WHERE end_date < CURDATE() AND end_date BETWEEN '$start_date' AND '$end_date' ORDER BY end_date DESC";
}

// Fetch past bookings with or without the date filter
$past_bookings = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Bookings</title>
    <link rel="stylesheet" href="style4.css">
</head>
<body>
    <div class="container">
        <h1>Past Bookings</h1>

        <!-- Filter Form for Date Range -->
        <form method="POST" action="past_bookings.php">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($start_date) ?>" required>
            
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($end_date) ?>" required>
            
            <button type="submit">Filter</button>
        </form>

        <!-- Display Bookings -->
        <?php if ($past_bookings->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Room Name</th>
                        <th>User Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $past_bookings->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php 
                                    $room = $conn->query("SELECT room_name FROM rooms WHERE id = " . $row['room_id'])->fetch_assoc();
                                    echo htmlspecialchars($room['room_name']); 
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row['user_name']) ?></td>
                            <td><?= htmlspecialchars($row['start_date']) ?></td>
                            <td><?= htmlspecialchars($row['end_date']) ?></td>
                            <td><?= htmlspecialchars($row['start_time']) ?></td>
                            <td><?= htmlspecialchars($row['end_time']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No past bookings for the selected date range.</p>
        <?php endif; ?>
        
    </div>
</body>
</html>
