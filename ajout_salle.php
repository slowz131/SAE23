<?php
// ajout_salle.php
include("connect.php");
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("header.php");

// Extracting and cleaning data from POST
$nom_salle  = $_POST['NOM_SALLE'];
$type_salle = $_POST['Type'];
$capacite   = $_POST['Capacite'];
$id_bat     = $_POST['ID_BAT'];

// SQL Insert statement matching your schema: Salle(NOM_SALLE, Type, Capacite, ID_BAT)
$query = "INSERT INTO Salle (NOM_SALLE, Type, Capacite, ID_BAT) 
          VALUES ('$nom_salle', '$type_salle', '$capacite', '$id_bat')";

// Execute insertion
$result = mysqli_query($conn, $query) or die("Error executing query: " . mysqli_error($conn));

mysqli_close($conn);
?>
<h2>Confirmation d'ajout de salle</h2>
<p class="message message-success">La nouvelle salle a été ajoutée avec succès !</p>

<section class="card">
    <h3>Détails de la salle enregistrée :</h3>
    <ul>
        <li><b>Nom de la salle :</b> <?php echo htmlspecialchars($nom_salle); ?></li>
        <li><b>Type d'usage :</b> <?php echo ($type_salle); ?></li>
        <li><b>Capacité :</b> <?php echo ($capacite); ?> places</li>
        <li><b>Rattachée au Bâtiment ID :</b> <?php echo ($id_bat); ?></li>
    </ul>
</section>

<p><a href="administration.php"> Retour à l'espace Administration</a></p>

<?php
include("footer.php");
?>


