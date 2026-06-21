<?php
// Include database connection and structural components
include("connect.php");
include("header.php");
?>

<h2>Consultation des Dernières Mesures</h2>
<p>Ce tableau affiche la dernière valeur reçue pour chaque capteur déployé dans les salles.</p>

<?php
// SQL Query: get the latest measurement for each sensor (subquery on MAX ID_MESURE),
// joined with a derived table computing the min, max and average value ever recorded for that sensor
$query = "SELECT m.NOM_CAPTEUR, m.Date, m.Horaire, m.Valeur, c.Type, c.Unite, c.NOM_SALLE,
                 stats.Val_Min, stats.Val_Max, stats.Val_Moy
          FROM Mesure m
          INNER JOIN Capteur c ON m.NOM_CAPTEUR = c.NOM_CAPTEUR
          INNER JOIN (
              SELECT NOM_CAPTEUR, MIN(Valeur) AS Val_Min, MAX(Valeur) AS Val_Max, AVG(Valeur) AS Val_Moy
              FROM Mesure
              GROUP BY NOM_CAPTEUR
          ) stats ON stats.NOM_CAPTEUR = m.NOM_CAPTEUR
          WHERE m.ID_MESURE IN (
              SELECT MAX(sub_m.ID_MESURE) 
              FROM Mesure sub_m 
              GROUP BY sub_m.NOM_CAPTEUR
          )
          ORDER BY c.NOM_SALLE ASC, c.Type ASC";

// Execute the query
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>Salle</th>";
    echo "<th>Type de Grandeur</th>";
    echo "<th>Dernière Valeur</th>";
    echo "<th>Min</th>";
    echo "<th>Max</th>";
    echo "<th>Moyenne</th>";
    echo "<th>Date de capture</th>";
    echo "<th>Horaire</th>";
    echo "</tr>";

    // Loop to display each specific latest measurement row, with its min/max/average stats
    while ($row = mysqli_fetch_assoc($result)) {
        $unite = ($row['Unite']);
        echo "<tr>";
        echo "<td><b>" . ($row['NOM_SALLE']) . "</b></td>";
        echo "<td>" . ($row['Type']) . "</td>";

        // Concat value with its specific unit (e.g., 23.5 °C, 45 %)
        echo "<td>" . ($row['Valeur']) . " " . $unite . "</td>";
        echo "<td class='stat-min'>" . ($row['Val_Min']) . " " . $unite . "</td>";
        echo "<td class='stat-max'>" . ($row['Val_Max']) . " " . $unite . "</td>";
        echo "<td class='stat-avg'>" . number_format($row['Val_Moy'], 1) . " " . $unite . "</td>";

        // Format French Date for clean display (YYYY-MM-DD to DD/MM/YYYY if needed, or keep standard)
        echo "<td>" . ($row['Date']) . "</td>";
        echo "<td>" . ($row['Horaire']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='message message-warning'>Aucune mesure n'a encore été enregistrée dans la base de données.</p>";
}

// Close MySQL connection for this script
mysqli_close($conn);

include("footer.php");
?>
