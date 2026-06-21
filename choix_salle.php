<?php
// choix_salle.php
include("connect.php");
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check: Only admin can access this form
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("header.php");
?>

<h2>Ajouter un Capteur - Étape 1 : Choisir la Salle</h2>

<form action="nouveau_capteur.php" method="POST">
    <fieldset>
        <legend>Sélectionnez la salle de destination :</legend>
        
        <?php
        // SQL query to fetch all rooms from the database
        $query = "SELECT NOM_SALLE, Type FROM Salle ORDER BY NOM_SALLE ASC";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $is_first = true;
            
            // Loop through each room to create a radio button
            while ($row = mysqli_fetch_assoc($result)) {
                $salle_name = ($row['NOM_SALLE']);
                $salle_type = ($row['Type']);
                
                // Check the first radio button by default
                $checked = $is_first ? "checked='checked'" : "";
                $is_first = false;
                
                echo '<p>';
                echo '<input type="radio" name="nom_salle" value="' . $salle_name . '" id="' . $salle_name . '" ' . $checked . ' /> ';
                echo '<label for="' . $salle_name . '">Salle <b>' . $salle_name . '</b> (' . $salle_type . ')</label>';
                echo '</p>';
            }
        } else {
            echo "<p class='message message-error'>Aucune salle disponible. Créez d'abord une salle.</p>";
        }
        ?>
    </fieldset>
    <br>
    <input type="submit" value="Suivant : Configurer le capteur">
</form>

<?php
mysqli_close($conn);
include("footer.php");
?>
