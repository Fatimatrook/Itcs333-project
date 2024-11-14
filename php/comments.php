<?php
session_start();

try {
    
    $conn = new PDO("mysql:host=localhost;dbname=itcs333project", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to comment.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $username = $_SESSION['user_id']; 
    $comment = htmlspecialchars(trim($_POST['comment']));

    if (!empty($comment)) {
        
        $stmt = $conn->prepare("INSERT INTO comments (username, comment) VALUES (:username, :comment)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':comment', $comment);

        if ($stmt->execute()) {
            $_SESSION['comment_success'] = "Comment added successfully!";
        } else {
            $_SESSION['comment_error'] = "Failed to add comment. Please try again.";
        }
    } else {
        $_SESSION['comment_error'] = "Comment cannot be empty.";
    }
    header("Location: comments.php"); 
    exit();
}


$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments - IT Room Booking System</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>


<section class="home">
    <div class="content">
        <h3>Comments</h3>
        
        
        <?php
        if (isset($_SESSION['comment_success'])) {
            echo "<p style='color:green'>" . $_SESSION['comment_success'] . "</p>";
            unset($_SESSION['comment_success']);
        }
        if (isset($_SESSION['comment_error'])) {
            echo "<p style='color:red'>" . $_SESSION['comment_error'] . "</p>";
            unset($_SESSION['comment_error']);
        }
        ?>
        
        
        <form action="comments.php" method="post">
            <textarea name="comment" required placeholder="Enter your comment"></textarea>
            <button type="submit" class="btn">Submit Comment</button>
        </form>

        
        <div class="comments-section">
            <h3>Previous Comments</h3>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="comment-box">
                    <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                    <p><?php echo htmlspecialchars($row['comment']); ?></p>
                    <small><?php echo $row['created_at']; ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

</body>
</html>

<?php $conn = null; ?>
