<?php 
include('includes/db.php');
include('includes/header.php'); 

// 2. Barrier: Check if the user is verified as a Building Manager
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'gestionnaire') {
    header("Location: login.php");
    exit();
}

$my_bat_id = $_SESSION['managed_bat_id'];
$my_bat_nom = $_SESSION['managed_bat_nom'];
?>

<h1>Espace Gestionnaire - <?php echo htmlspecialchars($my_bat_nom); ?></h1>
<p>Utilisateur connecté : <strong><?php echo htmlspecialchars($_SESSION['user_logged']); ?></strong></p>

<form>
    <label for="select-batiment">Votre Bâtiment :</label>
    <select id="select-batiment" name="id_bat">
        <option value="<?php echo $my_bat_id; ?>"><?php echo htmlspecialchars($my_bat_nom); ?></option>
    </select>

    <label for="select-capteur">Sélectionner un Capteur de votre bâtiment :</label>
    <select id="select-capteur" name="nom_capteur">
        <option value="">-- Choisir un capteur --</option>
        <?php
        // Querying rooms and sensors restricted strictly to the manager's building ID
        $query = "SELECT c.NOM_CAPTEUR, c.Type, s.NOM_SALLE 
                  FROM capteur c 
                  JOIN salle s ON c.NOM_SALLE = s.NOM_SALLE 
                  WHERE s.ID_BAT = $my_bat_id";
                  
        $res = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<option value='".$row['NOM_CAPTEUR']."'>Salle ".$row['NOM_SALLE']." - ".$row['NOM_CAPTEUR']." (".$row['Type'].")</option>";
        }
        ?>
    </select>
    
    <button type="submit">Visualiser les métriques</button>
</form>

<?php include('includes/footer.php'); ?>
