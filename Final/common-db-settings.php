<?php
// Establish connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "itcs333project";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

