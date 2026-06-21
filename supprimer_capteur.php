<?php
include("connect.php");
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check: Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("header.php");

// STEP 3: Deletion confirmed (form submitted) -> perform the cascading delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['NOM_CAPTEUR'])) {
    $nom_capteur = mysqli_real_escape_string($conn, $_POST['NOM_CAPTEUR']);

    // Delete every measurement recorded by this sensor first (FK_capteur constraint)
    $query_mesure = "DELETE FROM Mesure WHERE NOM_CAPTEUR = '$nom_capteur'";
    mysqli_query($conn, $query_mesure) or die("<p class='message message-error'>Erreur lors de la suppression des mesures : " . mysqli_error($conn) . "</p>");

    // Then delete the sensor itself
    $query_capteur = "DELETE FROM Capteur WHERE NOM_CAPTEUR = '$nom_capteur'";
    mysqli_query($conn, $query_capteur) or die("<p class='message message-error'>Erreur lors de la suppression du capteur : " . mysqli_error($conn) . "</p>");
    ?>
    <h2>Suppression de capteur</h2>
    <p class="message message-success">Le capteur <b><?php echo htmlspecialchars($nom_capteur); ?></b> ainsi que toutes ses mesures associées ont été supprimés avec succès.</p>
    <p class="mt-20"><a href="supprimer_capteur.php">Retour à la liste des capteurs</a> | <a href="administration.php">Retour à l'espace Administration</a></p>
    <?php
}
// STEP 2: A sensor was selected -> ask for confirmation
elseif (isset($_GET['nom_capteur'])) {
    $nom_capteur = mysqli_real_escape_string($conn, $_GET['nom_capteur']);

    // Fetch the sensor details
    $query = "SELECT NOM_CAPTEUR, Type, Unite, NOM_SALLE FROM Capteur WHERE NOM_CAPTEUR = '$nom_capteur'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Count the measurements recorded by this sensor, to warn the admin about the cascading deletion
        $query_mesures = "SELECT ID_MESURE FROM Mesure WHERE NOM_CAPTEUR = '$nom_capteur'";
        $result_mesures = mysqli_query($conn, $query_mesures);
        $nb_mesures = mysqli_num_rows($result_mesures);
        ?>
        <h2>Confirmer la suppression d'un capteur</h2>

        <section class="card">
            <h3>Détails du capteur :</h3>
            <ul>
                <li><b>Nom du capteur :</b> <?php echo htmlspecialchars($row['NOM_CAPTEUR']); ?></li>
                <li><b>Type de mesure :</b> <?php echo htmlspecialchars($row['Type']); ?></li>
                <li><b>Unité :</b> <?php echo htmlspecialchars($row['Unite']); ?></li>
                <li><b>Salle :</b> <?php echo htmlspecialchars($row['NOM_SALLE']); ?></li>
            </ul>

            <?php if ($nb_mesures > 0) { ?>
                <p class="message message-warning">Attention : ce capteur a enregistré <?php echo $nb_mesures; ?> mesure(s). La suppression entraînera également la suppression définitive de cet historique de mesures.</p>
            <?php } ?>

            <p>Êtes-vous sûr de vouloir supprimer définitivement ce capteur ? Cette action est irréversible.</p>

            <form action="supprimer_capteur.php" method="POST">
                <input type="hidden" name="NOM_CAPTEUR" value="<?php echo htmlspecialchars($row['NOM_CAPTEUR']); ?>">
                <input type="submit" value="Confirmer la suppression" class="btn-delete">
            </form>
            <p class="mt-20"><a href="supprimer_capteur.php">Annuler et revenir à la liste</a></p>
        </section>
        <?php
    } else {
        echo "<h2>Confirmer la suppression d'un capteur</h2>";
        echo "<p class='message message-error'>Capteur introuvable.</p>";
        echo "<p class='mt-20'><a href='supprimer_capteur.php'>Retour à la liste des capteurs</a></p>";
    }
}
// STEP 1: Default view -> list every sensor with a delete link
else {
    ?>
    <h2>Supprimer un capteur</h2>
    <p>Sélectionnez le capteur à supprimer dans la liste ci-dessous :</p>

    <section>
        <?php
        // List every sensor, joined with its room and building name
        $query = "SELECT c.NOM_CAPTEUR, c.Type, c.Unite, c.NOM_SALLE, b.Nom_bat
                  FROM Capteur c
                  INNER JOIN Salle s ON c.NOM_SALLE = s.NOM_SALLE
                  INNER JOIN Batiment b ON s.ID_BAT = b.ID_BAT
                  ORDER BY b.Nom_bat ASC, c.NOM_SALLE ASC, c.NOM_CAPTEUR ASC";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Bâtiment</th>";
            echo "<th>Salle</th>";
            echo "<th>Capteur</th>";
            echo "<th>Type</th>";
            echo "<th>Unité</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // Loop through every sensor and add a "Supprimer" link for each
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Nom_bat']) . "</td>";
                echo "<td>" . htmlspecialchars($row['NOM_SALLE']) . "</td>";
                echo "<td><b>" . htmlspecialchars($row['NOM_CAPTEUR']) . "</b></td>";
                echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Unite']) . "</td>";
                echo "<td><a href='supprimer_capteur.php?nom_capteur=" . urlencode($row['NOM_CAPTEUR']) . "' class='action-link action-link--danger'>Supprimer</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='message message-warning'>Aucun capteur n'a été trouvé dans la base de données.</p>";
        }
        ?>
    </section>

    <p class="mt-20"><a href="administration.php">Retour à l'espace Administration</a></p>
    <?php
}

// Close MySQL connection for this script
mysqli_close($conn);

include("footer.php");
?>
