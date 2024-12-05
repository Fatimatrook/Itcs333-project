<?php
include '../common-db-settings.php'; // Include the database connection
include 'header.php';  
// Variables for Add/Edit actions
$action = $_GET['action'] ?? 'list'; // Determines current action
$id = $_GET['id'] ?? null;           // Room ID for Edit/Del
$message = '';

// Handle Add or Edit form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_name = $_POST['room_name'];
    $capacity = $_POST['capacity'];
    $equipment = $_POST['equipment'];
    $image_name = $_FILES['image']['name'] ?? null;

    if ($image_name) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = '../images/';
        move_uploaded_file($image_tmp_name, $upload_dir . $image_name);
    }

    if ($action == 'add') {
        $stmt = $conn->prepare("INSERT INTO rooms (room_name, capacity, equipment, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $room_name, $capacity, $equipment, $image_name);
        $stmt->execute();
        $message = "Room added successfully!";
    } elseif ($action == 'edit' && $id) {
        if (!$image_name) {
            $image_name = $_POST['existing_image'];
        }
        $stmt = $conn->prepare("UPDATE rooms SET room_name = ?, capacity = ?, equipment = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sissi", $room_name, $capacity, $equipment, $image_name, $id);
        $stmt->execute();
        $message = "Room updated successfully!";
    }

    header("Location: room_management.php");
    exit;
}

// Handle Delete action
if ($action == 'delete' && $id) {
    $conn->query("DELETE FROM rooms WHERE id = $id");
    $message = "Room deleted successfully!";
    header("Location: room_management.php");
    exit;
}

// Fetch all rooms for listing
$rooms = $conn->query("SELECT * FROM rooms");
$current_room = null;

// Fetch current room data for editing
if ($action == 'edit' && $id) {
    $current_room = $conn->query("SELECT * FROM rooms WHERE id = $id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <link rel="stylesheet" href="../css/style2.css">
</head>
<body>
    <div class="container">
        <h1>Room Management</h1>

        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <!-- Room List -->
        <?php if ($action == 'list'): ?>
            <a href="room_management.php?action=add" class="btn">Add Room</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room Name</th>
                        <th>Capacity</th>
                        <th>Equipment</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $rooms->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['room_name']) ?></td>
                            <td><?= $row['capacity'] ?></td>
                            <td><?= htmlspecialchars($row['equipment']) ?></td>
                            <td>
                                <img src="../images/<?= $row['image'] ?>" alt="Room Image" style="width: 100px;">
                            </td>
                            <td>
                                <a href="room_management.php?action=edit&id=<?= $row['id'] ?>">Edit</a> | 
                                <a href="room_management.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Add/Edit Form -->
        <?php if ($action == 'add' || $action == 'edit'): ?>
            <form method="POST" enctype="multipart/form-data">
                <label>Room Name:</label>
                <input type="text" name="room_name" value="<?= htmlspecialchars($current_room['room_name'] ?? '') ?>" required>

                <label>Capacity:</label>
                <input type="number" name="capacity" value="<?= $current_room['capacity'] ?? '' ?>" required>

                <label>Equipment:</label>
                <textarea name="equipment" required><?= htmlspecialchars($current_room['equipment'] ?? '') ?></textarea>

                <label>Image:</label>
                <input type="file" name="image" accept="image/*">
                <?php if ($action == 'edit' && $current_room): ?>
                    <input type="hidden" name="existing_image" value="<?= $current_room['image'] ?>">
                    <p>Current Image: <img src="../images/<?= $current_room['image'] ?>" alt="Current Image" style="width: 100px;"></p>
                <?php endif; ?>

                <button type="submit"><?= $action == 'add' ? 'Add Room' : 'Update Room' ?></button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
