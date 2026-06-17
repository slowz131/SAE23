<?php
// administration.php
include("connect.php");
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check: Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("header.php");
?>
<link rel="stylesheet" href="styles.css">
<h2>Espace Administration</h2>
<p>Bienvenue, administrateur. Utilisez les outils ci-dessous pour gérer les infrastructures :</p>

<ul>
    <li>
        <a href="choix_batiment.php" style="font-weight: bold; color: #0056b3;">Ajouter une nouvelle salle dans un bâtiment</a>
    </li>
    <br>
    <li>
        <a href="choix_salle.php" style="font-weight: bold; color: green;"> Ajouter un nouveau capteur dans une salle</a>
    </li>
</ul>

<?php
mysqli_close($conn);
include("footer.php");
?>
