<?php
// Start secure session to manage user authentication levels
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAE23 - IoT Enterprise Solution</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="consultation.php">Consultation</a></li>
                <li><a href="gestion.php">Gestion</a></li>
                <li><a href="administration.php">Administration</a></li>
                <li><a href="projet.php">Gestion de Projet</a></li>
                <?php if (isset($_SESSION['user_type'])): ?>
                    <li><a href="logout.php" style="color: #ff7675;">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
