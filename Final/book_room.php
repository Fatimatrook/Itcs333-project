<?php
include 'common-db-settings.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Check for conflicts
    $check_sql = "SELECT * FROM bookings 
                  WHERE room_id = $room_id AND booking_date = '$booking_date' 
                  AND (('$start_time' BETWEEN start_time AND end_time) 
                       OR ('$end_time' BETWEEN start_time AND end_time) 
                       OR (start_time BETWEEN '$start_time' AND '$end_time'))";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "The room is already booked for the selected time.";
    } else {
        $sql = "INSERT INTO bookings (room_id, user_name, user_email, booking_date, start_time, end_time) 
                VALUES ($room_id, '$user_name', '$user_email', '$booking_date', '$start_time', '$end_time')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Room booked successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
