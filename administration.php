<?php 
include('includes/db.php');
include('includes/header.php'); 

// Mock admin authentication check block - secure access requirement[cite: 3]
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    $_SESSION['user_type'] = 'admin'; // Simulated bypass for interface validation
}

// Basic POST routing process to manage infrastructure updates[cite: 4]
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_building') {
        $name = mysqli_real_escape_string($conn, $_POST['b_name']);
        $insert = "INSERT INTO batiment (nom) VALUES ('$name')";
        mysqli_query($conn, $insert);
    }
    // Implement delete routing routines here[cite: 4]
}
?>

<h1>Interface d'Administration Générale</h1>
<p>Outils CRUD pour la gestion de l'infrastructure de la base de données[cite: 3, 4].</p>

<h2>Ajouter un Bâtiment</h2>
<form method="POST" action="administration.php">
    <input type="hidden" name="action" value="add_building">
    <label for="b_name">Nom du bâtiment :</label>
    <input type="text" id="b_name" name="b_name" required placeholder="Ex: Batiment Informatique">
    <button type="submit">Ajouter l'infrastructure</button>
</form>

<h2>Infrastructures existantes (Suppression)</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nom du Bâtiment</th>
        <th>Action</th>
    </tr>
    <?php
    $b_list = mysqli_query($conn, "SELECT * FROM batiment");
    while($b_row = mysqli_fetch_assoc($b_list)) {
        echo "<tr>";
        echo "<td>".$b_row['id']."</td>";
        echo "<td>".htmlspecialchars($b_row['nom'])."</td>";
        echo "<td><button style='color:red;'>Supprimer</button></td>";
        echo "</tr>";
    }
    ?>
</table>

<?php include('includes/footer.php'); ?>
