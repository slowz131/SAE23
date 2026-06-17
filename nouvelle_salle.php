<?php
// nouvelle_salle.php
include("connect.php");
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Retrieve selected building ID from previous form
$selected_bat = $_POST['id_bat'];

include("header.php");
?>
<link rel="stylesheet" href="styles.css">
<h2>Ajouter une Salle - Étape 2 : Informations de la Salle</h2>

<form action="ajout_salle.php" method="POST">
    <fieldset>
        <legend>Configuration des paramètres de la salle</legend>
        
        <p>Bâtiment cible : <b>ID <?php echo ($selected_bat); ?></b></p>
        <input type="hidden" name="ID_BAT" value="<?php echo ($selected_bat); ?>" />
        
        <label for="nom_salle">Nom/Numéro de la Salle (Clé primaire textuelle) :</label>
        <input type="text" name="NOM_SALLE" id="nom_salle" required placeholder="Ex: E201, B105">
        
        <label for="type">Type de salle :</label>
        <input type="text" name="Type" id="type" required placeholder="Ex: Cours, TP Réseaux, Amphi">
        
        <label for="capacite">Capacité maximale (nombre de places) :</label>
        <input type="text" name="Capacite" id="capacite" required placeholder="Ex: 24">
    </fieldset>
    <br>
    <input type="submit" value="Enregistrer la salle dans la Base">
</form>

<?php
mysqli_close($conn);
include("footer.php");
?>


