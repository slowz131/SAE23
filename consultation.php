<?php
// Include database connection and structural components
include("connect.php");
include("header.php");
?>

<h2>Consultation des Dernières Mesures</h2>
<p>Ce tableau affiche la dernière valeur reçue pour chaque capteur déployé dans les salles.</p>

<?php
// SQL Query using a subquery to fetch ONLY the latest measurement for each sensor
$query = "SELECT m.NOM_CAPTEUR, m.Date, m.Horaire, m.Valeur, c.Type, c.Unite, c.NOM_SALLE
          FROM Mesure m
          INNER JOIN Capteur c ON m.NOM_CAPTEUR = c.NOM_CAPTEUR
          WHERE m.ID_MESURE IN (
              SELECT MAX(sub_m.ID_MESURE) 
              FROM Mesure sub_m 
              GROUP BY sub_m.NOM_CAPTEUR
          )
          ORDER BY c.NOM_SALLE ASC, c.Type ASC";

// Execute the query
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%; text-align: left;'>";
    echo "<tr style='background-color: #e6f2ff;'>";
    echo "<th>Salle</th>";
    echo "<th>Type de Grandeur</th>";
    echo "<th>Dernière Valeur</th>";
    echo "<th>Date de capture</th>";
    echo "<th>Horaire</th>";
    echo "</tr>";

    // Loop to display each specific latest measurement row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><b>" . ($row['NOM_SALLE']) . "</b></td>";
        echo "<td>" . ($row['Type']) . "</td>";
        
        // Concat value with its specific unit (e.g., 23.5 °C, 45 %)
        echo "<td>" . ($row['Valeur']) . " " . ($row['Unite']) . "</td>";
        
        // Format French Date for clean display (YYYY-MM-DD to DD/MM/YYYY if needed, or keep standard)
        echo "<td>" . ($row['Date']) . "</td>";
        echo "<td>" . ($row['Horaire']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: orange; font-weight: bold;'>Aucune mesure n'a encore été enregistrée dans la base de données.</p>";
}

// Close MySQL connection for this script
mysqli_close($conn);

include("footer.php");
?>
