<?php
// Database configuration variables
$host = "localhost";
$user = "cailleaud";
$password = "rt"; // Put your MySQL password here if you have one
$dbname = "sae23";

// Create a functional connection to the MySQL database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check if the connection established successfully
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8 to correctly handle french accents
mysqli_set_charset($conn, "utf8");
?>
