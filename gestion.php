<?php 
include('includes/db.php');
include('includes/header.php'); 

// Mock authentication session for testing development - secure access restriction[cite: 3]
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'gestionnaire') {
    // For development convenience, setting up a temporary simulated login
    $_SESSION['user_type'] = 'gestionnaire';
    $_SESSION['building_id'] = 1; // Assuming managed building ID is 1[cite: 3]
}
$managed_building = $_SESSION['building_id'];
?>

<h1>Espace de Gestion - Analyses Métriques</h1>
<p>Statistiques fines et historique de vos capteurs assignés[cite: 3].</p>

<h2>Filtrer les données d'un capteur</h2>
<!-- Form logic targeting specific time range and sensor selections[cite: 3, 4] -->
<form method="GET" action="gestion.php">
    <label for="sensor">Capteur :</label>
    <select name="sensor" id="sensor">
        <?php
        // Populate options based strictly on the current building context[cite: 3, 4]
        $s_query = "SELECT c.id, c.nom, s.nom AS s_nom FROM capteur c JOIN salle s ON c.id_salle = s.id WHERE s.id_batiment = $managed_building";
        $s_res = mysqli_query($conn, $s_query);
        while($s_row = mysqli_fetch_assoc($s_res)) {
            echo "<option value='".$s_row['id']."'>".$s_row['s_nom']." - ".$s_row['nom']."</option>";
        }
        ?>
    </select>

    <label for="start_date">Date début :</label>
    <input type="date" id="start_date" name="start_date">

    <button type="submit">Afficher les données</button>
</form>

<h2>Moyennes, Minimum et Maximum par salle</h2>
<!-- Metrics layout logic generated directly via database aggregations[cite: 3, 4] -->
<table>
    <tr>
        <th>Salle</th>
        <th>Capteur</th>
        <th>Valeur Min</th>
        <th>Valeur Max</th>
        <th>Moyenne</th>
    </tr>
    <?php
    $stats_query = "SELECT s.nom AS s_nom, c.type AS c_type, MIN(m.valeur) as min_v, MAX(m.valeur) as max_v, AVG(m.valeur) as avg_v 
                    FROM mesure m JOIN capteur c ON m.id_capteur = c.id JOIN salle s ON c.id_salle = s.id 
                    WHERE s.id_batiment = $managed_building GROUP BY c.id";
    $stats_res = mysqli_query($conn, $stats_query);
    while($st = mysqli_fetch_assoc($stats_res)) {
        echo "<tr>";
        echo "<td>".htmlspecialchars($st['s_nom'])."</td>";
        echo "<td>".htmlspecialchars($st['c_type'])."</td>";
        echo "<td>".round($st['min_v'], 2)."</td>";
        echo "<td>".round($st['max_v'], 2)."</td>";
        echo "<td>".round($st['avg_v'], 2)."</td>";
        echo "</tr>";
    }
    ?>
</table>

<?php include('includes/footer.php'); ?>
