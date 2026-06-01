<?php
$host = "localhost";
$username = "cailleaud";
$password = "rt";
$database = "sae23"; 

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

echo "<p style='color: green;'>[DEBUG] Connexion réussie à la base de données !</p>";
?>
