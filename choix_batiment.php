<?php
// choix_batiment.php
include("connect.php");
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check: Only admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("header.php");
?>
<h2>Ajouter une Salle - Étape 1 : Choisir le Bâtiment</h2>

<form action="nouvelle_salle.php" method="POST">
    <fieldset>
        <legend>Sélectionnez le bâtiment de destination :</legend>
        
        <?php
        // SQL query to fetch all existing buildings
        $query = "SELECT ID_BAT, Nom_bat FROM Batiment ORDER BY Nom_bat ASC";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $is_first = true;
            
            // Loop to generate radio buttons for each building
            while ($row = mysqli_fetch_assoc($result)) {
                $id_bat = ($row['ID_BAT']);
                $nom_bat = ($row['Nom_bat']);
                
                $checked = $is_first ? "checked='checked'" : "";
                $is_first = false;
                
                echo '<p>';
                echo '<input type="radio" name="id_bat" value="' . $id_bat . '" id="bat_' . $id_bat . '" ' . $checked . ' /> ';
                echo '<label for="bat_' . $id_bat . '">Bâtiment <b>' . $nom_bat . '</b> (ID: ' . $id_bat . ')</label>';
                echo '</p>';
            }
        } else {
            echo "<p class='message message-error'>Aucun bâtiment trouvé. Créez d'abord un bâtiment.</p>";
        }
        ?>
    </fieldset>
    <br>
    <input type="submit" value="Suivant : Configurer la salle">
</form>

<?php
mysqli_close($conn);
include("footer.php");
?>


