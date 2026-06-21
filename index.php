<?php
// Include database connection and structural components
include("connect.php");
include("header.php");
?>
<h2>Accueil - Supervision des infrastructures</h2>
<p>
    Bienvenue sur l'interface de supervision de l'IUT de Blagnac. Ce site permet de suivre en temps réel 
    les mesures environnementales (température, humidité, CO2) des différents bâtiments de votre campus.
</p>

<hr>

<h3>Liste des Bâtiments et Salles fonctionnelles</h3>
<p>Voici l'état actuel de votre campus et la répartition des salles de cours ou de TP :</p>

<?php
// SQL Query to get all buildings and their associated rooms using a standard join
$query = "SELECT b.ID_BAT, b.Nom_bat, s.NOM_SALLE, s.Type, s.Capacite 
          FROM Batiment b 
          LEFT JOIN Salle s ON b.ID_BAT = s.ID_BAT 
          ORDER BY b.Nom_bat ASC, s.NOM_SALLE ASC";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if there are any results in the table
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>ID Bâtiment</th>";
    echo "<th>Nom du Bâtiment</th>";
    echo "<th>Nom de la Salle</th>";
    echo "<th>Type de Salle</th>";
    echo "<th>Capacité</th>";
    echo "</tr>";
    
    // Loop through each row returned by the database
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . ($row['ID_BAT']) . "</td>";
        echo "<td>" . ($row['Nom_bat']) . "</td>";
        
        // Handle cases where a building exists but has no rooms assigned yet
        if ($row['NOM_SALLE'] != null) {
            echo "<td>" . ($row['NOM_SALLE']) . "</td>";
            echo "<td>" . ($row['Type']) . "</td>";
            echo "<td>" . ($row['Capacite']) . " places</td>";
        } else {
            echo "<td colspan='3' class='text-muted'>Aucune salle enregistrée pour ce bâtiment</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='message message-error'>Aucun bâtiment ni aucune salle n'ont été trouvés dans la base de données.</p>";
}

// Close MySQL connection for this script
mysqli_close($conn);

include("footer.php");
?>
