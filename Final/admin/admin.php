<?php
include '../common-db-settings.php'; // Include the database connec
include 'header.php';  // Include the header for navigation

// Query to get total bookings per room
$room_bookings_query = "SELECT r.room_name, COUNT(b.id) AS total_bookings
                        FROM bookings b
                        JOIN rooms r ON b.room_id = r.id
                        GROUP BY r.id
                        ORDER BY total_bookings DESC";
$room_bookings_result = $conn->query($room_bookings_query);

// Query to get total booking duration per room
$room_duration_query = "SELECT r.room_name, 
                               SUM(TIMESTAMPDIFF(HOUR, b.start_time, b.end_time)) AS total_hours_booked
                        FROM bookings b
                        JOIN rooms r ON b.room_id = r.id
                        GROUP BY r.id
                        ORDER BY total_hours_booked DESC";
$room_duration_result = $conn->query($room_duration_query);

// Query to get room capacity
$room_capacity_query = "SELECT r.room_name, r.capacity FROM rooms r";
$room_capacity_result = $conn->query($room_capacity_query);

// Query to get upcoming bookings
$upcoming_bookings_query = "SELECT r.room_name, b.start_date, b.end_date, b.start_time, b.end_time
                             FROM bookings b
                             JOIN rooms r ON b.room_id = r.id
                             WHERE b.start_date >= CURDATE()
                             ORDER BY b.start_date";
$upcoming_bookings_result = $conn->query($upcoming_bookings_query);

// Query to get past bookings
$past_bookings_query = "SELECT r.room_name, b.start_date, b.end_date, b.start_time, b.end_time
                        FROM bookings b
                        JOIN rooms r ON b.room_id = r.id
                        WHERE b.end_date < CURDATE()
                        ORDER BY b.end_date DESC";
$past_bookings_result = $conn->query($past_bookings_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Usage Dashboard</title>
    <link rel="stylesheet" href="style4.css">
</head>
<body>
    <div class="container">
        <h1>Room Usage Dashboard</h1>

        <!-- Total Bookings per Room -->
        <h2>Total Bookings per Room</h2>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Total Bookings</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $room_bookings_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['room_name']) ?></td>
                        <td><?= htmlspecialchars($row['total_bookings']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Total Booking Duration (in hours) per Room -->
        <h2>Total Booking Duration per Room (Hours)</h2>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Total Hours Booked</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $room_duration_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['room_name']) ?></td>
                        <td><?= htmlspecialchars($row['total_hours_booked']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Room Capacity -->
        <h2>Room Capacity</h2>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Capacity</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $room_capacity_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['room_name']) ?></td>
                        <td><?= htmlspecialchars($row['capacity']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Upcoming Bookings -->
        <h2>Upcoming Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $upcoming_bookings_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['room_name']) ?></td>
                        <td><?= htmlspecialchars($row['start_date']) ?></td>
                        <td><?= htmlspecialchars($row['end_date']) ?></td>
                        <td><?= htmlspecialchars($row['start_time']) ?></td>
                        <td><?= htmlspecialchars($row['end_time']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Past Bookings -->
        <h2>Past Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $past_bookings_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['room_name']) ?></td>
                        <td><?= htmlspecialchars($row['start_date']) ?></td>
                        <td><?= htmlspecialchars($row['end_date']) ?></td>
                        <td><?= htmlspecialchars($row['start_time']) ?></td>
                        <td><?= htmlspecialchars($row['end_time']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</body>
</html>
