<?php
// administration.php
include("connect.php");
if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Security check: Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include("header.php");
?>
<h2>Espace Administration</h2>
<p>Bienvenue, administrateur. Utilisez les outils ci-dessous pour gérer les infrastructures :</p>

<ul>
    <li>
        <a href="choix_batiment.php" class="action-link action-link--primary">Ajouter une nouvelle salle dans un bâtiment</a>
    </li>
    <br>
    <li>
        <a href="choix_salle.php" class="action-link action-link--accent"> Ajouter un nouveau capteur dans une salle</a>
    </li>
</ul>

<aside  id="validation">
	<hr>
	<p><em><strong> Validation de la page HTML5 - CSS3 </strong></em></p>
	<a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fbenbahor.atwebpages.com%2FSAE23%2Fadministration.php" target="_blank">
		<img class= "image-responsive" src="./images/html5-validator-badge-blue.png" alt="HTML5 Valide !" />
	</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="https://jigsaw.w3.org/css-validator/validator?uri=http://benbahor.atwebpages.com/SAE23/CSS/styles.css" target="_blank">
		<img class= "image-responsive" src="./images/vcss-blue.png" alt="CSS Valide !" />
	</a>
</aside>


<?php
mysqli_close($conn);
include("footer.php");
?>
