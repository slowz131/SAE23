<?php
// gestion.php
include("connect.php");

if (session_status() == PHP_SESSION_NONE) { session_start(); }

// 1. SECURITY CHECK: Access restricted to managers only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gestionnaire') {
    header("Location: login.php");
    exit();
}

// 2. BUILDING IDENTIFICATION
// Retrieve the building ID assigned to this manager via session variables
$id_bat = isset($_SESSION['id_bat']) ? $_SESSION['id_bat'] : '';

// $id_bat = 'BAT_E'; // Uncomment this line to test without active sessions

include("header.php");
?>

<link rel="stylesheet" href="styles.css">

<section class="gestion-header">
    <h2>Espace Gestionnaire - Bâtiment <?php echo($id_bat); ?></h2>
    
    <section class="info-box">
        <p>Bienvenue dans votre espace de gestion. Vous ne voyez ici que les données relatives aux salles du <b><?php echo($id_bat); ?></b>.</p>
    </section>
</section>

<section class="gestion-stats">
    <h3>Statistiques globales du bâtiment</h3>

    <?php
    $query_stats = "
        SELECT s.NOM_SALLE, c.Type, c.Unite, 
               ROUND(AVG(m.Valeur), 2) as Moyenne, 
               MIN(m.Valeur) as Minimum, 
               MAX(m.Valeur) as Maximum
        FROM Mesure m
        INNER JOIN Capteur c ON m.NOM_CAPTEUR = c.NOM_CAPTEUR
        INNER JOIN Salle s ON c.NOM_SALLE = s.NOM_SALLE
        WHERE s.ID_BAT = '$id_bat'
        GROUP BY s.NOM_SALLE, c.Type, c.Unite
        ORDER BY s.NOM_SALLE ASC
    ";

    $result_stats = mysqli_query($conn, $query_stats);

    if (mysqli_num_rows($result_stats) > 0) {
        echo "<table class='data-table'>";
        echo "<tr class='header-stats'>";
        echo "<th>Salle</th><th>Type de mesure</th><th>Moyenne</th><th>Minimum</th><th>Maximum</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result_stats)) {
            echo "<tr>";
            echo "<td><b>" . ($row['NOM_SALLE']) . "</b></td>";
            echo "<td>" .($row['Type']) . "</td>";
            echo "<td>" .($row['Moyenne']) . " " .($row['Unite']) . "</td>";
            echo "<td class='val-min'>" .($row['Minimum']) . " " .($row['Unite']) . "</td>";
            echo "<td class='val-max'>" .($row['Maximum']) . " " .($row['Unite']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='msg-warning'>Aucune statistique disponible pour les salles de ce bâtiment.</p>";
    }
    ?>
</section>

<section class="gestion-mesures">
    <h3>Derniers relevés des capteurs</h3>

    <?php
    $query_mesures = "
        SELECT m.NOM_CAPTEUR, m.Date, m.Horaire, m.Valeur, c.Type, c.Unite, s.NOM_SALLE
        FROM Mesure m
        INNER JOIN Capteur c ON m.NOM_CAPTEUR = c.NOM_CAPTEUR
        INNER JOIN Salle s ON c.NOM_SALLE = s.NOM_SALLE
        WHERE s.ID_BAT = '$id_bat'
          AND m.ID_MESURE IN (
              SELECT MAX(sub_m.ID_MESURE)
              FROM Mesure sub_m
              GROUP BY sub_m.NOM_CAPTEUR
          )
        ORDER BY s.NOM_SALLE ASC, c.Type ASC
    ";

    $result_mesures = mysqli_query($conn, $query_mesures);

    if (mysqli_num_rows($result_mesures) > 0) {
        echo "<table class='data-table'>";
        echo "<tr class='header-mesures'>";
        echo "<th>Salle</th><th>Capteur</th><th>Type</th><th>Dernière Valeur</th><th>Date</th><th>Heure</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result_mesures)) {
            echo "<tr>";
            echo "<td><b>" .($row['NOM_SALLE']) . "</b></td>";
            echo "<td>" .($row['NOM_CAPTEUR']) . "</td>";
            echo "<td>" .($row['Type']) . "</td>";
            echo "<td><b>" .($row['Valeur']) . " " .($row['Unite']) . "</b></td>";
            echo "<td>" .($row['Date']) . "</td>";
            echo "<td>" .($row['Horaire']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='msg-warning'>Aucune mesure récente trouvée pour les capteurs de ce bâtiment.</p>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</section>

<?php include("footer.php"); ?>
