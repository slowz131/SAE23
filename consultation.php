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
    echo "<table>";
    echo "<tr>";
    echo "<th>Salle</th>";
    echo "<th>Type de Grandeur</th>";
    echo "<th>Dernière Valeur</th>";
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

        // Format French Date for clean display (YYYY-MM-DD to DD/MM/YYYY if needed, or keep standard)
        echo "<td>" . ($row['Date']) . "</td>";
        echo "<td>" . ($row['Horaire']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='message message-warning'>Aucune mesure n'a encore été enregistrée dans la base de données.</p>";
}
?>

<aside  id="validation">
	<hr>
	<p><em><strong> Validation de la page HTML5 - CSS3 </strong></em></p>
	<a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fbenbahor.atwebpages.com%2FSAE23%2Fconsultation.php" target="_blank">
		<img class= "image-responsive" src="./images/html5-validator-badge-blue.png" alt="HTML5 Valide !" />
	</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="https://jigsaw.w3.org/css-validator/validator?uri=http://benbahor.atwebpages.com/SAE23/CSS/styles.css" target="_blank">
		<img class= "image-responsive" src="./images/vcss-blue.png" alt="CSS Valide !" />
	</a>
</aside>

<?php
// Close MySQL connection for this script
mysqli_close($conn);

include("footer.php");
?>
