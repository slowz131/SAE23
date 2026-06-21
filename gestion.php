<?php
include("connect.php");
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check: If not logged in OR not a manager, redirect to login.php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gestionnaire') {
    header("Location: login.php");
    exit();
}

include("header.php");

// Retrieve the building assigned to the connected manager
$id_bat = $_SESSION['id_bat'];

// Fetch the building name for display purposes
$query_bat = "SELECT Nom_bat FROM Batiment WHERE ID_BAT = '" . mysqli_real_escape_string($conn, $id_bat) . "'";
$result_bat = mysqli_query($conn, $query_bat);
$nom_bat = "";
if ($result_bat && mysqli_num_rows($result_bat) == 1) {
    $row_bat = mysqli_fetch_assoc($result_bat);
    $nom_bat = $row_bat['Nom_bat'];
}
?>

<h2>Espace Gestion - Bâtiment <?php echo ($nom_bat); ?> (ID: <?php echo ($id_bat); ?>)</h2>
<p>Bienvenue <b><?php echo ($_SESSION['login']); ?></b>, voici l'état des capteurs installés dans les salles de votre bâtiment.</p>

<section>
    <h3>Observation des capteurs</h3>
    <p>Ce tableau présente, pour chaque capteur de votre bâtiment, la dernière valeur mesurée ainsi que les valeurs minimale, maximale et moyenne enregistrées depuis sa mise en service.</p>

    <?php
    // SQL Query: list every sensor of the manager's building (LEFT JOINs so sensors
    // without any measurement yet are still displayed), with:
    //  - "latest" : a derived table giving the most recent value (highest ID_MESURE)
    //  - "stats"  : a derived table computing MIN / MAX / AVG over all measurements
    $query = "SELECT c.NOM_CAPTEUR, c.Type, c.Unite, c.NOM_SALLE,
                     latest.Val_Actuelle,
                     stats.Val_Min, stats.Val_Max, stats.Val_Moy
              FROM Capteur c
              INNER JOIN Salle s ON c.NOM_SALLE = s.NOM_SALLE
              LEFT JOIN (
                  SELECT NOM_CAPTEUR, MIN(Valeur) AS Val_Min, MAX(Valeur) AS Val_Max, AVG(Valeur) AS Val_Moy
                  FROM Mesure
                  GROUP BY NOM_CAPTEUR
              ) stats ON stats.NOM_CAPTEUR = c.NOM_CAPTEUR
              LEFT JOIN (
                  SELECT m1.NOM_CAPTEUR, m1.Valeur AS Val_Actuelle
                  FROM Mesure m1
                  WHERE m1.ID_MESURE IN (
                      SELECT MAX(m2.ID_MESURE) FROM Mesure m2 GROUP BY m2.NOM_CAPTEUR
                  )
              ) latest ON latest.NOM_CAPTEUR = c.NOM_CAPTEUR
              WHERE s.ID_BAT = '" . mysqli_real_escape_string($conn, $id_bat) . "'
              ORDER BY c.NOM_SALLE ASC, c.Type ASC";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Salle</th>";
        echo "<th>Capteur</th>";
        echo "<th>Type</th>";
        echo "<th>Valeur actuelle</th>";
        echo "<th>Min</th>";
        echo "<th>Max</th>";
        echo "<th>Moyenne</th>";
        echo "</tr>";

        // Loop through every sensor of the building and display its statistics
        while ($row = mysqli_fetch_assoc($result)) {
            $unite = ($row['Unite']);
            echo "<tr>";
            echo "<td><b>" . ($row['NOM_SALLE']) . "</b></td>";
            echo "<td>" . ($row['NOM_CAPTEUR']) . "</td>";
            echo "<td>" . ($row['Type']) . "</td>";

            // Handle sensors that have not produced any measurement yet
            if ($row['Val_Actuelle'] === null) {
                echo "<td colspan='4' class='text-muted'>Aucune mesure enregistrée pour ce capteur</td>";
            } else {
                echo "<td>" . ($row['Val_Actuelle']) . " " . $unite . "</td>";
                echo "<td class='stat-min'>" . ($row['Val_Min']) . " " . $unite . "</td>";
                echo "<td class='stat-max'>" . ($row['Val_Max']) . " " . $unite . "</td>";
                echo "<td class='stat-avg'>" . number_format($row['Val_Moy'], 1) . " " . $unite . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='message message-warning'>Aucun capteur n'a été trouvé pour ce bâtiment.</p>";
    }
    ?>
</section>

<?php
// Close MySQL connection for this script
mysqli_close($conn);

include("footer.php");
?>
