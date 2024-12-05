<?php
// Start the session
session_start();

// Unset session variables
unset($_SESSION['username']);
unset($_SESSION['email']);

// Destroy the session
session_destroy();

// Redirect to index.php
header("Location:login.php");
exit; // Ensure that no further code is executed after the header redirection
?>