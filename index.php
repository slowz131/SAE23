<?php 
// Include system configuration and layout structures[cite: 2, 3]
include('includes/db.php');
include('includes/header.php'); 
?>

<h1>Solution de Supervision IoT de l'IUT (SAE23)</h1>
<p><strong>Objectif du site :</strong> Offrir aux gestionnaires et administrateurs une interface pratique pour visualiser et analyser les données des capteurs de température, CO2 ou luminosité des bâtiments[cite: 3].</p>

<h2>Bâtiments supervisés et Salles équipées</h2>
<?php
// SQL Query to fetch buildings and their corresponding rooms from database
$query = "SELECT b.nom AS b_nom, s.nom AS s_nom, s.type FROM batiment b JOIN salle s ON s.id_batiment = b.id";
$result = mysqli_query($conn, $query); //

if ($result && mysqli_num_rows($result) > 0) {
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li><strong>" . htmlspecialchars($row['b_nom']) . "</strong> - Salle " . htmlspecialchars($row['s_nom']) . " (" . htmlspecialchars($row['type']) . ")</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No infrastructure metadata loaded in MySQL database yet[cite: 4].</p>";
}
?>

<?php include('includes/footer.php'); ?>
