<?php 
include('includes/db.php');
include('includes/header.php'); 

// 1. Barrier: Check if the user is verified as an Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<h1>Espace Administration</h1>
<p>Bienvenue, <strong><?php echo htmlspecialchars($_SESSION['user_logged']); ?></strong>. Vous pouvez gérer l'infrastructure globale.</p>

<form>
    <label for="select-batiment">Sélectionner un Bâtiment :</label>
    <select id="select-batiment" name="id_bat">
        <option value="">-- Choisir un bâtiment --</option>
        <?php
        // Fetch building keys using your friend's schema column names
        $res = mysqli_query($conn, "SELECT ID_BAT, Nom_bat FROM batiment");
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<option value='".$row['ID_BAT']."'>".htmlspecialchars($row['Nom_bat'])."</option>";
        }
        ?>
    </select>

    <label for="select-capteur">Capteurs associés :</label>
    <select id="select-capteur" name="nom_capteur" disabled>
        <option value="">-- Choisissez d'abord un bâtiment --</option>
    </select>
</form>

<?php include('includes/footer.php'); ?>
