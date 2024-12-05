<?php
include '../common-db-settings.php'; // Include the database connection
include 'header.php';  // Include the header for navigation

// Query to get room usage report
$room_usage_query = "SELECT r.room_name, COUNT(b.id) AS total_bookings, 
                             SUM(DATEDIFF(b.end_date, b.start_date) + 1) AS total_days_booked, 
                             SUM(TIMESTAMPDIFF(HOUR, b.start_time, b.end_time)) AS total_hours_booked
                      FROM bookings b
                      JOIN rooms r ON b.room_id = r.id
                      GROUP BY r.id
                      ORDER BY total_bookings DESC";

$room_usage_result = $conn->query($room_usage_query);

// Query to get room popularity (Bookings per room)
$room_popularity_query = "SELECT r.room_name, COUNT(b.id) AS total_bookings
                           FROM bookings b
                           JOIN rooms r ON b.room_id = r.id
                           WHERE b.start_date BETWEEN '2023-01-01' AND '2023-12-31'  -- Adjust date range here
                           GROUP BY r.id
                           ORDER BY total_bookings DESC";

$room_popularity_result = $conn->query($room_popularity_query);

// Query to get user booking frequency
$user_booking_query = "SELECT b.user_name, COUNT(b.id) AS total_bookings
                       FROM bookings b
                       GROUP BY b.user_name
                       ORDER BY total_bookings DESC";

$user_booking_result = $conn->query($user_booking_query);

// Query to get booking duration report
$booking_duration_query = "SELECT r.room_name, SUM(TIMESTAMPDIFF(HOUR, b.start_time, b.end_time)) AS total_hours_booked
                            FROM bookings b
                            JOIN rooms r ON b.room_id = r.id
                            GROUP BY r.id
                            ORDER BY total_hours_booked DESC";

$booking_duration_result = $conn->query($booking_duration_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Usage and Popularity Reports</title>
    <link rel="stylesheet" href="../css/style4.css">
</head>
<body>
    <div class="container">
        <h1>Room Usage and Popularity Reports</h1>

        <!-- Room Usage Report -->
        <h2>Room Usage</h2>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Total Bookings</th>
                    <th>Total Days Booked</th>
                    <th>Total Hours Booked</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $room_usage_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['room_name']) ?></td>
                        <td><?= htmlspecialchars($row['total_bookings']) ?></td>
                        <td><?= htmlspecialchars($row['total_days_booked']) ?></td>
                        <td><?= htmlspecialchars($row['total_hours_booked']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Room Popularity Report -->
        <h2>Room Popularity (Bookings per Room)</h2>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Total Bookings</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $room_popularity_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['room_name']) ?></td>
                        <td><?= htmlspecialchars($row['total_bookings']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- User Booking Frequency Report -->
        <h2>User Booking Frequency</h2>
        <table>
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Total Bookings</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $user_booking_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars($row['total_bookings']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Booking Duration Report -->
        <h2>Booking Duration (Total Hours)</h2>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Total Hours Booked</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $booking_duration_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['room_name']) ?></td>
                        <td><?= htmlspecialchars($row['total_hours_booked']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</body>
</html>
