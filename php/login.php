<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Room Booking System</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100vh; 
            display: flex; 
            justify-content: center;
            align-items: center; 
            background: var(--forth-color);}

        :root {
            --first-color: #243642;
            --second-color: #387478;
            --third-color: #629584;
            --forth-color: #E2F1E7;}

        h2 {
            text-align: center;
            color: #333;
            margin: 10; }

            
        form {
            background: var(--forth-color); 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            max-width: 400px; 
            width: 100%; 
        }
        .input-group {
            margin-bottom: 15px; 
        }
        label {
            display: block; 
            margin-bottom: 5px;
            color: #555; 
        }
        input[type="text"], input[type="password"] {
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-sizing: border-box; 
        }
        .btn {
            width: 100%; 
            padding: 10px; 
            background: var(--third-color);
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px;
        }
        .btn:hover {
            background: var(--second-color);
        }
        p {
            text-align: center; 
            margin-top: 15px;
            color: var(--second-color);
        }
        a {
            color: #007bff; 
            text-decoration: none; 
        }
        a:hover {
            text-decoration: underline; 
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

    <form method="post" action="">
        <h2>Login</h2>
        
        <!-- Display error messages -->
        <?php
        session_start();
        if (isset($_SESSION['login_error'])) {
            echo '<p class="error">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']);
        }
        ?>

        <div class="input-group">
            <label for="email">Username or Email</label>
            <input type="text" id="email" name="email" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="input-group">
            <button type="submit" class="btn" name="login">Login</button>
        </div>
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </form>

    <?php
    // Handle login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Database connection
        $con = new mysqli('localhost', 'root', '', 'itcs333project');
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        } else {
            // Check for user in the database
            $stmt = $con->prepare("SELECT * FROM registration WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $email, $email);
            $stmt->execute();
            $stmt_result = $stmt->get_result();

            if ($stmt_result->num_rows > 0) {
                $data = $stmt_result->fetch_assoc();
                if (password_verify($password, $data['password'])) {
                    // Start session and set user data
                    $_SESSION['user_id'] = $data['username']; // or any other identifier
                    echo "Successfully logged in.";
                    // Redirect to a protected page or dashboard
                    header("Location: dashboard.php"); // Adjust to your dashboard page
                    exit();
                } else {
                    $_SESSION['login_error'] = "Invalid email or password.";
                }
            } else {
                $_SESSION['login_error'] = "Invalid email or password.";
            }

            $stmt->close();
            $con->close();
        }
    }
    ?>
</body>
</html>
