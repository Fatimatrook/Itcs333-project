<?php
session_start(); // Start the session to access $_SESSION variables
include 'Home.php'; // Include the header for the page
include 'common-db-settings.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Booking Cancellation
    if (isset($_POST['cancel_booking'])) {
        $booking_id = $_POST['booking_id'];

        // Check if booking belongs to the logged-in user
        $user_email = $_SESSION['email'];
        $validation_query = "SELECT * FROM bookings WHERE id = ? AND user_email = ?";
        $stmt = $conn->prepare($validation_query);
        $stmt->bind_param("is", $booking_id, $user_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo '<script>alert("No such booking exists or you are not authorized to cancel this booking.");</script>';
        } else {
            // Proceed to delete the booking
            $delete_query = "DELETE FROM bookings WHERE id = ?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("i", $booking_id);

            if ($stmt->execute()) {
                echo '<script>alert("Booking successfully cancelled!");</script>';
            } else {
                echo '<script>alert("Error occurred while cancelling the booking. Please try again.");</script>';
            }
        }
    }
}

// Fetch the user's bookings for display
$user_email = $_SESSION['email'];
$booking_query = "
    SELECT bookings.id, rooms.room_name, bookings.start_date, bookings.end_date 
    FROM bookings 
    JOIN rooms ON bookings.room_id = rooms.id 
    WHERE bookings.user_email = ?";
$stmt = $conn->prepare($booking_query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$user_bookings = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f4f4f9; }
        button { background-color: #d9534f; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #c9302c; }
        h1 { text-align: center; color: #333; }
    </style>
    <script>
        // JavaScript to confirm cancellation
        function confirmCancellation() {
            return confirm("Are you sure you want to cancel this booking?");
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Cancel Booking</h1>

        <h3>Your Current Bookings</h3>
        <table>
            <tr>
                <th>Booking ID</th>
                <th>Room Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
            <?php while ($booking = $user_bookings->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $booking['id']; ?></td>
                    <td><?php echo $booking['room_name']; ?></td>
                    <td><?php echo $booking['start_date']; ?></td>
                    <td><?php echo $booking['end_date']; ?></td>
                    <td>
                        <form action="" method="POST" style="display:inline;" onsubmit="return confirmCancellation();">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                            <button type="submit" name="cancel_booking">Cancel</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
