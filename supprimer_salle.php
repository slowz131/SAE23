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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['NOM_SALLE'])) {
    $nom_salle = mysqli_real_escape_string($conn, $_POST['NOM_SALLE']);

    // Delete every measurement recorded by the sensors of this room first (FK_capteur constraint)
    $query_mesure = "DELETE FROM Mesure WHERE NOM_CAPTEUR IN (SELECT NOM_CAPTEUR FROM Capteur WHERE NOM_SALLE = '$nom_salle')";
    mysqli_query($conn, $query_mesure) or die("<p class='message message-error'>Erreur lors de la suppression des mesures : " . mysqli_error($conn) . "</p>");

    // Then delete every sensor of this room (FK_salle constraint)
    $query_capteur = "DELETE FROM Capteur WHERE NOM_SALLE = '$nom_salle'";
    mysqli_query($conn, $query_capteur) or die("<p class='message message-error'>Erreur lors de la suppression des capteurs : " . mysqli_error($conn) . "</p>");

    // Finally delete the room itself
    $query_salle = "DELETE FROM Salle WHERE NOM_SALLE = '$nom_salle'";
    mysqli_query($conn, $query_salle) or die("<p class='message message-error'>Erreur lors de la suppression de la salle : " . mysqli_error($conn) . "</p>");
    ?>
    <h2>Suppression de salle</h2>
    <p class="message message-success">La salle <b><?php echo htmlspecialchars($nom_salle); ?></b> ainsi que tous ses capteurs et mesures associés ont été supprimés avec succès.</p>
    <p class="mt-20"><a href="supprimer_salle.php">Retour à la liste des salles</a> | <a href="administration.php">Retour à l'espace Administration</a></p>
    <?php
}
// STEP 2: A room was selected -> ask for confirmation
elseif (isset($_GET['nom_salle'])) {
    $nom_salle = mysqli_real_escape_string($conn, $_GET['nom_salle']);

    // Fetch the room details, joined with its building name
    $query = "SELECT s.NOM_SALLE, s.Type, s.Capacite, b.Nom_bat
              FROM Salle s
              INNER JOIN Batiment b ON s.ID_BAT = b.ID_BAT
              WHERE s.NOM_SALLE = '$nom_salle'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Count the sensors attached to this room, to warn the admin about the cascading deletion
        $query_capteurs = "SELECT NOM_CAPTEUR FROM Capteur WHERE NOM_SALLE = '$nom_salle'";
        $result_capteurs = mysqli_query($conn, $query_capteurs);
        $nb_capteurs = mysqli_num_rows($result_capteurs);
        ?>
        <h2>Confirmer la suppression d'une salle</h2>

        <section class="card">
            <h3>Détails de la salle :</h3>
            <ul>
                <li><b>Nom de la salle :</b> <?php echo htmlspecialchars($row['NOM_SALLE']); ?></li>
                <li><b>Type d'usage :</b> <?php echo htmlspecialchars($row['Type']); ?></li>
                <li><b>Capacité :</b> <?php echo htmlspecialchars($row['Capacite']); ?> places</li>
                <li><b>Bâtiment :</b> <?php echo htmlspecialchars($row['Nom_bat']); ?></li>
            </ul>

            <?php if ($nb_capteurs > 0) { ?>
                <p class="message message-warning">Attention : cette salle contient <?php echo $nb_capteurs; ?> capteur(s). La suppression entraînera également la suppression définitive de ce(s) capteur(s) et de toutes leurs mesures enregistrées.</p>
            <?php } ?>

            <p>Êtes-vous sûr de vouloir supprimer définitivement cette salle ? Cette action est irréversible.</p>

            <form action="supprimer_salle.php" method="POST">
                <input type="hidden" name="NOM_SALLE" value="<?php echo htmlspecialchars($row['NOM_SALLE']); ?>">
                <input type="submit" value="Confirmer la suppression" class="btn-delete">
            </form>
            <p class="mt-20"><a href="supprimer_salle.php">Annuler et revenir à la liste</a></p>
        </section>
        <?php
    } else {
        echo "<h2>Confirmer la suppression d'une salle</h2>";
        echo "<p class='message message-error'>Salle introuvable.</p>";
        echo "<p class='mt-20'><a href='supprimer_salle.php'>Retour à la liste des salles</a></p>";
    }
}
// STEP 1: Default view -> list every room with a delete link
else {
    ?>
    <h2>Supprimer une salle</h2>
    <p>Sélectionnez la salle à supprimer dans la liste ci-dessous :</p>

    <section>
        <?php
        // List every room, joined with its building name, ordered by building then room
        $query = "SELECT s.NOM_SALLE, s.Type, s.Capacite, b.Nom_bat
                  FROM Salle s
                  INNER JOIN Batiment b ON s.ID_BAT = b.ID_BAT
                  ORDER BY b.Nom_bat ASC, s.NOM_SALLE ASC";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Bâtiment</th>";
            echo "<th>Salle</th>";
            echo "<th>Type</th>";
            echo "<th>Capacité</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // Loop through every room and add a "Supprimer" link for each
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Nom_bat']) . "</td>";
                echo "<td><b>" . htmlspecialchars($row['NOM_SALLE']) . "</b></td>";
                echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Capacite']) . "</td>";
                echo "<td><a href='supprimer_salle.php?nom_salle=" . urlencode($row['NOM_SALLE']) . "' class='action-link action-link--danger'>Supprimer</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='message message-warning'>Aucune salle n'a été trouvée dans la base de données.</p>";
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
