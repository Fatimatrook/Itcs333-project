<?php
session_start();
if (!(isset($_SESSION['username']) && $_SESSION['email'] != '')) {
header("Location:login.php");
}
?>

