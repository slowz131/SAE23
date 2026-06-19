<?php
// nouveau_capteur.php
include("connect.php");

if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("header.php");
?>

<link rel="stylesheet" href="styles.css">
<h2>Gestion des Capteurs - Ajouter un nouveau capteur</h2>

<div style="background-color: #ffffff; padding: 20px; border: 1px solid #dddddd; border-radius: 4px; margin-bottom: 20px;">
    <h3>Formulaire de saisie :</h3>
    <form action="nouveau_capteur.php" method="POST">
        <p>
            <label for="nom_capteur"><b>Nom du capteur :</b></label><br>
            <input type="text" id="nom_capteur" name="NOM_CAPTEUR" placeholder="Ex: AM107-1" required style="width: 100%; padding: 8px; margin-top: 5px;">
        </p>
        
        <p>
            <label for="type_mesure"><b>Type de mesure :</b></label><br>
            <input type="text" id="type_mesure" name="TYPE_MESURE" placeholder="Ex: CO2, Temperature, Humidite" required style="width: 100%; padding: 8px; margin-top: 5px;">
        </p>

        <p>
            <label for="unite"><b>Unité de mesure :</b></label><br>
            <input type="text" id="unite" name="UNITE" placeholder="Ex: PPM, °C, %" required style="width: 100%; padding: 8px; margin-top: 5px;">
        </p>
        
        <p>
            <label for="nom_salle"><b>Nom de la salle rattachée :</b></label><br>
            <input type="text" id="nom_salle" name="NOM_SALLE" placeholder="Ex: B202" required style="width: 100%; padding: 8px; margin-top: 5px;">
        </p>
        
        <p>
            <input type="submit" value="Enregistrer le capteur" style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">
        </p>
    </form>
</div>

<?php
// TRAITEMENT DU FORMULAIRE (Dès que le bouton est cliqué)
if (isset($_POST['NOM_CAPTEUR'], $_POST['TYPE_MESURE'], $_POST['UNITE'], $_POST['NOM_SALLE'])) {

    // Extracting data from POST
    $nom_capteur = $_POST['NOM_CAPTEUR'];
    $type_mesure = $_POST['TYPE_MESURE']; 
    $unite       = $_POST['UNITE']; 
    $nom_salle   = $_POST['NOM_SALLE'];   

    // SQL Insert statement (Inclusion de 'Type' et 'Unite' selon ton cours)
    $query = "INSERT INTO Capteur (NOM_CAPTEUR, Type, Unite, NOM_SALLE) 
              VALUES ('$nom_capteur', '$type_mesure', '$unite', '$nom_salle')";

    // Execute insertion
    $result = mysqli_query($conn, $query) or die("<p style='color: red; font-weight: bold;'>Error executing query: " . mysqli_error($conn) . "</p>");

    // Affichage du bloc de confirmation
    ?>
    <hr>
    <p style="color: green; font-weight: bold;">Le nouveau capteur a été ajouté avec succès !</p>

    <div style="background-color: #e8f5e9; padding: 15px; border: 1px solid #c8e6c9; border-radius: 4px;">
        <h3>Détails du capteur enregistré :</h3>
        <ul>
            <li><b>Nom du capteur :</b> <?php echo htmlspecialchars($nom_capteur); ?></li>
            <li><b>Type de mesure :</b> <?php echo htmlspecialchars($type_mesure); ?></li>
            <li><b>Unité :</b> <?php echo htmlspecialchars($unite); ?></li>
            <li><b>Assigné à la salle :</b> <?php echo htmlspecialchars($nom_salle); ?></li>
        </ul>
    </div>
    <?php

    mysqli_close($conn);
}
?>

<p style="margin-top: 20px;"><a href="administration.php">Retour à l'espace Administration</a></p>

<?php
include("footer.php");
?>
