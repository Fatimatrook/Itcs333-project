<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'itcs333project');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['user_id']; 
    $comment = htmlspecialchars($_POST['comment']);

    $sql = "INSERT INTO comments (username, comment) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $comment);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="home">
    <h3>Comments</h3>
    <form action="comments.php" method="post">
        <textarea name="comment" required placeholder="Enter your comment"></textarea>
        <button type="submit" class="btn">Submit Comment</button>
    </form>

    <div class="comments-section">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="comment">
                <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                <p><?php echo htmlspecialchars($row['comment']); ?></p>
                <small><?php echo $row['created_at']; ?></small>
            </div>
        <?php endwhile; ?>
    </div>
</section>

</body>
</html>

<?php $conn->close(); ?>
