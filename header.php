<?php
// Start the PHP session session before any HTML output
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>WELO - System Supervision</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>WELO IoT Beyond Connectivity</h1>
    <nav>
        <a href="index.php">Accueil</a> |
        <a href="consultation.php">Consultation</a> |
        <a href="projet.php">Gestion de Projet</a> |
        <a href="gestion.php">Gestion</a> |
        <a href="administration.php">Administration</a> 
        
        <?php 
        // Display logout link and username only if someone is logged in
        if (isset($_SESSION['role'])) {
            echo ' | <span class="session-status"> Connecter à : ' . ($_SESSION['login']) . '</span> | ';
            echo '<a href="logout.php">Déconnexion</a>';
        }
        ?>
    </nav>
</header>
<hr>
<main>
