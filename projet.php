<?php
// projet.php
include("connect.php");
include("header.php");
?>

<h2>Suivi de Projet - WELO Iot</h2>
<p>Cette page présente le déroulement du projet pour L'IUT de Blagnac, le planning de réalisation, les outils collaboratifs utilisés ainsi que le bilan individuel de chaque membre.</p>

<hr>

<section>
    <h3>1. Planification temporelle (Diagramme de GANTT)</h3>
    <p>Voici le planning de développement et d'intégration final réalisé pour notre projet :</p>
    <figure class="card card--centered">
        <img src="./images/Gantt_1.png" alt="Diagramme de GANTT Final">
        <img src="./images/Gantt_2.png" alt="Diagramme de GANTT Final">
        <img src="./images/Gantt_3.png" alt="Diagramme de GANTT Final">
        <figcaption class="figure-caption">Figure 1 : Diagramme de GANTT du projet finalisé</figcaption>
    </figure>
</section>

<hr>

<section>
    <h3>2. Outils collaboratifs et environnement de travail</h3>
    <p>Pour assurer la gestion de versions de notre code PHP et centraliser nos documents techniques, nous avons utilisé plusieurs outils :</p>

    <section class="section-group">
        <h4>Suivi des versions et code source (Git / GitHub)</h4>
        <figure class="card card--centered">
            <img src="./images/github.jpg" alt="Capture d'écran GitHub">
            <figcaption class="figure-caption">Figure 2 : Capture d'écran du dépôt Git de l'équipe</figcaption>
        </figure>

        <h4>Communication et partage de documents</h4>
        <figure class="card card--centered">
            <img src="./images/drive_vm.png" alt="Capture d'écran outils collaboratifs">
            <img src="./images/conv_insta.png" alt="Capture d'écran outils collaboratifs">
            <figcaption class="figure-caption">Figure 3 : Environnement d'échange d'équipe</figcaption>
        </figure>
    </section>
</section>

<hr>

<section>
    <h3>3. Synthèses personnelles des membres de l'équipe</h3>
    <p>Chaque employé présente ici le travail précis réalisé, les difficultés techniques rencontrées et les solutions apportées.</p>

    <section class="card">
        <h4>Fiche de synthèse : Walid Ben Bahor</h4>
        <ul>
            <li><b>Travail précis réalisé :</b></li>
            <p>Pour ce projet SAE23, je me suis entièrement occupé de la base de donnée ainsi que de la réalisation d'un script bash pour l'automatisation.</p>
            
            <li><b>Problèmes rencontrés :</b></li>
            <p>Lors de l'élaboration du script bash permettant de tout automatiser (notamment, la récupération des valeurs, le stockage et l'envoi de ces dernières dans la base de donnée), l'exportation des valeurs à poser problème de par une mauvaise syntaxe des informations stockées dans un fichier, dédié pour l'exportation vers la base de donnée.   </p>
            
            <li><b>Solutions proposées et appliquées :</b></li>
            <p>Pour résoudre ce problème, j'ai tester des syntaxes différentes jusqu'à que cela fonctionne.</p>
        </ul>
    </section>

    <section class="card">
        <h4>Fiche de synthèse : Fennot Nazavae</h4>
        <ul>
            <li><b>Travail précis réalisé :</b></li>
            <p>emplacement txt membre 2</p>
            
            <li><b>Problèmes rencontrés :</b></li>
            <p>emplacement txt membre 2</p>
            
            <li><b>Solutions proposées et appliquées :</b></li>
            <p>emplacement txt membre 2</p>
        </ul>
    </section>

    <section class="card">
        <h4>Fiche de synthèse : Léon Cailleaud</h4>
        <ul>
            <li><b>Travail précis réalisé :</b></li>
            <p>Pour ce projet SAE23, j'ai pris en charge l'intégralité du développement du site web (front-end et back-end). Cela inclut la création des interfaces en HTML5 et CSS3, la gestion sécurisée des sessions utilisateurs en PHP (rôles admin et gestionnaire), et l'élaboration des requêtes SQL complexes avec jointures pour afficher dynamiquement les relevés des capteurs.</p>
            
            <li><b>Problèmes rencontrés :</b></li>
            <p>Lors du développement, j'ai été confronté à des erreurs PHP de type "Undefined Index" lors du traitement des formulaires et des sessions. J'ai également rencontré des problèmes de connexion à la base de données lors d'un changement de poste de travail, ainsi que des conflits de fusion (Merge Conflicts) lors de la synchronisation de mon code sur GitHub.</p>
            
            <li><b>Solutions proposées et appliquées :</b></li>
            <p>Pour corriger ces soucis, j'ai sécurisé le code PHP en systématisant les vérifications avec `isset()`. J'ai centralisé l'intégralité du design dans un fichier CSS externe unique pour rendre le code plus propre. Enfin, j'ai reconfiguré mes accès locaux à la base de données et appliqué les commandes Git adéquates pour résoudre les conflits d'historique.</p>
        </ul>
    </section>
</section>

<hr>

<section>
    <h3>4. Conclusion et validation du cahier des charges</h3>
    <p>Bilan général concernant l'atteinte des objectifs fixés par le projet:</p>
    <section>
        <p><b>Degré de satisfaction global :</b></p>
        <p>emplacement txt conclusion générale sur la validation du cahier des charges, l'intégration des scripts d'administration et la restitution des mesures pour les gestionnaires.</p>
    </section>
</section>

<aside  id="validation">
	<hr>
	<p><em><strong> Validation de la page HTML5 - CSS3 </strong></em></p>
	<a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fbenbahor.atwebpages.com%2FSAE23%2Fprojet.php" target="_blank">
		<img class= "image-responsive" src="./images/html5-validator-badge-blue.png" alt="HTML5 Valide !" />
	</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="https://jigsaw.w3.org/css-validator/validator?uri=http://benbahor.atwebpages.com/SAE23/CSS/styles.css" target="_blank">
		<img class= "image-responsive" src="./images/vcss-blue.png" alt="CSS Valide !" />
	</a>
</aside>

<?php
// Close the database link
mysqli_close($conn);
include("footer.php");
?>


