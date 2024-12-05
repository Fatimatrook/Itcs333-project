<?php
include '../common-db-settings.php';
include 'header.php';
// Query to get booking frequency by day
$booking_frequency_query = "SELECT DATE(b.start_date) AS booking_date, COUNT(b.id) AS bookings_count
                            FROM bookings b
                            GROUP BY booking_date
                            ORDER BY booking_date DESC";
$booking_frequency_result = $conn->query($booking_frequency_query);

if (!$booking_frequency_result) {
    die("Error in booking frequency query: " . $conn->error);
}

// Query to get peak booking times
$peak_booking_times_query = "SELECT b.start_time, COUNT(b.id) AS bookings_count
                              FROM bookings b
                              GROUP BY b.start_time
                              ORDER BY bookings_count DESC";
$peak_booking_times_result = $conn->query($peak_booking_times_query);

if (!$peak_booking_times_result) {
    die("Error in peak booking times query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Usage Analytics</title>
    <link rel="stylesheet" href="../css/style5.css">

    <!-- Add Chart.js CDN for visualizations -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Room Usage Analytics</h1>

        <!-- Booking Frequency per Day (Line Chart) -->
        <h2>Booking Frequency by Day</h2>
        <canvas id="bookingFrequencyChart"></canvas>
        <script>
            var ctx = document.getElementById('bookingFrequencyChart').getContext('2d');
            var bookingFrequencyData = {
                labels: [],
                datasets: [{
                    label: 'Bookings per Day',
                    data: [],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            };

            <?php while ($row = $booking_frequency_result->fetch_assoc()): ?>
                bookingFrequencyData.labels.push("<?= $row['booking_date'] ?>");
                bookingFrequencyData.datasets[0].data.push(<?= $row['bookings_count'] ?>);
            <?php endwhile; ?>

            var bookingFrequencyChart = new Chart(ctx, {
                type: 'line',
                data: bookingFrequencyData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <!-- Peak Booking Times (Bar Chart) -->
        <h2>Peak Booking Times</h2>
        <canvas id="peakBookingTimesChart"></canvas>
        <script>
            var ctx2 = document.getElementById('peakBookingTimesChart').getContext('2d');
            var peakBookingTimesData = {
                labels: [],
                datasets: [{
                    label: 'Bookings Count by Time',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            <?php while ($row = $peak_booking_times_result->fetch_assoc()): ?>
                peakBookingTimesData.labels.push("<?= $row['start_time'] ?>");
                peakBookingTimesData.datasets[0].data.push(<?= $row['bookings_count'] ?>);
            <?php endwhile; ?>

            var peakBookingTimesChart = new Chart(ctx2, {
                type: 'bar',
                data: peakBookingTimesData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>
</html>
