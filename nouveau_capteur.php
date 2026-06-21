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

<h2>Gestion des Capteurs - Ajouter un nouveau capteur</h2>

<section class="card">
    <h3>Formulaire de saisie :</h3>
    <form action="nouveau_capteur.php" method="POST">
        <p>
            <label for="nom_capteur"><b>Nom du capteur :</b></label><br>
            <input type="text" id="nom_capteur" name="NOM_CAPTEUR" placeholder="Ex: AM107-1" required>
        </p>
        
        <p>
            <label for="type_mesure"><b>Type de mesure :</b></label><br>
            <input type="text" id="type_mesure" name="TYPE_MESURE" placeholder="Ex: CO2, Temperature, Humidite" required>
        </p>

        <p>
            <label for="unite"><b>Unité de mesure :</b></label><br>
            <input type="text" id="unite" name="UNITE" placeholder="Ex: PPM, °C, %" required>
        </p>
        
        <p>
            <label for="nom_salle"><b>Nom de la salle rattachée :</b></label><br>
            <input type="text" id="nom_salle" name="NOM_SALLE" placeholder="Ex: B202" required>
        </p>
        
        <p>
            <input type="submit" value="Enregistrer le capteur">
        </p>
    </form>
</section>

<?php
// FORM PROCESSING (runs once the submit button has been clicked)
if (isset($_POST['NOM_CAPTEUR'], $_POST['TYPE_MESURE'], $_POST['UNITE'], $_POST['NOM_SALLE'])) {

    // Extracting data from POST
    $nom_capteur = $_POST['NOM_CAPTEUR'];
    $type_mesure = $_POST['TYPE_MESURE']; 
    $unite       = $_POST['UNITE']; 
    $nom_salle   = $_POST['NOM_SALLE'];   

    // SQL Insert statement (includes the 'Type' and 'Unite' fields as covered in your course)
    $query = "INSERT INTO Capteur (NOM_CAPTEUR, Type, Unite, NOM_SALLE) 
              VALUES ('$nom_capteur', '$type_mesure', '$unite', '$nom_salle')";

    // Execute insertion
    $result = mysqli_query($conn, $query) or die("<p class='message message-error'>Error executing query: " . mysqli_error($conn) . "</p>");

    // Display the confirmation block
    ?>
    <hr>
    <p class="message message-success">Le nouveau capteur a été ajouté avec succès !</p>

    <section class="card card--success">
        <h3>Détails du capteur enregistré :</h3>
        <ul>
            <li><b>Nom du capteur :</b> <?php echo htmlspecialchars($nom_capteur); ?></li>
            <li><b>Type de mesure :</b> <?php echo htmlspecialchars($type_mesure); ?></li>
            <li><b>Unité :</b> <?php echo htmlspecialchars($unite); ?></li>
            <li><b>Assigné à la salle :</b> <?php echo htmlspecialchars($nom_salle); ?></li>
        </ul>
    </section>
    <?php

    mysqli_close($conn);
}
?>

<p class="mt-20"><a href="administration.php">Retour à l'espace Administration</a></p>

<aside  id="validation">
	<hr>
	<p><em><strong> Validation de la page HTML5 - CSS3 </strong></em></p>
	<a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fbenbahor.atwebpages.com%2FSAE23%2Fnouveau_capteur.php" target="_blank">
		<img class= "image-responsive" src="./images/html5-validator-badge-blue.png" alt="HTML5 Valide !" />
	</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="https://jigsaw.w3.org/css-validator/validator?uri=http://benbahor.atwebpages.com/SAE23/CSS/styles.css" target="_blank">
		<img class= "image-responsive" src="./images/vcss-blue.png" alt="CSS Valide !" />
	</a>
</aside>

<?php
include("footer.php");
?>
