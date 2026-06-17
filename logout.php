<?php
// Start session to access it
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the actual session
session_destroy();

// Redirect automatically to home page
header("Location: index.php");
exit();
?>
