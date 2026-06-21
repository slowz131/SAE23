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

<aside  id="validation">
	<hr>
	<p><em><strong> Validation de la page HTML5 - CSS3 </strong></em></p>
	<a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fbenbahor.atwebpages.com%2FSAE23%2Fnouvelle_salle.php" target="_blank">
		<img class= "image-responsive" src="./images/html5-validator-badge-blue.png" alt="HTML5 Valide !" />
	</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="https://jigsaw.w3.org/css-validator/validator?uri=http://benbahor.atwebpages.com/SAE23/CSS/styles.css" target="_blank">
		<img class= "image-responsive" src="./images/vcss-blue.png" alt="CSS Valide !" />
	</a>
</aside>

<?php
mysqli_close($conn);
include("footer.php");
?>


