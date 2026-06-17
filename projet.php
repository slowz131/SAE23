<?php
// projet.php
include("connect.php");
include("header.php");
?>

<h2>Suivi de Projet - WELO Iot</h2>
<p>Cette page présente le déroulement du projet pour L'IUT de Blagnac, le planning de réalisation, les outils collaboratifs utilisés ainsi que le bilan individuel de chaque membre.</p>

<hr>

<h3>1. Planification temporelle (Diagramme de GANTT)</h3>
<p>Voici le planning de développement et d'intégration final réalisé pour notre projet :</p>
<div style="background-color: #ffffff; padding: 15px; border: 1px solid #dddddd; border-radius: 4px; text-align: center;">
    <img src="images/gantt.png" alt="Diagramme de GANTT Final" style="max-width: 100%; height: auto; border: 1px solid #cccccc;">
    <p style="font-style: italic; color: #666666; margin-top: 5px;">Figure 1 : Diagramme de GANTT du projet finalisé</p>
</div>

<hr>

<h3>2. Outils collaboratifs et environnement de travail</h3>
<p>Pour assurer la gestion de versions de notre code PHP et centraliser nos documents techniques, nous avons utilisé plusieurs outils :</p>

<div style="margin: 20px 0;">
    <h4>Suivi des versions et code source (Git / GitHub)</h4>
    <div style="background-color: #ffffff; padding: 15px; border: 1px solid #dddddd; border-radius: 4px; text-align: center; margin-bottom: 15px;">
        <img src="images/screenshot_git.png" alt="Capture d'écran GitHub" style="max-width: 100%; height: auto; border: 1px solid #cccccc;">
        <p style="font-style: italic; color: #666666; margin-top: 5px;">Figure 2 : Capture d'écran du dépôt Git de l'équipe</p>
    </div>

    <h4>Communication et partage de documents</h4>
    <div style="background-color: #ffffff; padding: 15px; border: 1px solid #dddddd; border-radius: 4px; text-align: center;">
        <img src="images/screenshot_outils.png" alt="Capture d'écran outils collaboratifs" style="max-width: 100%; height: auto; border: 1px solid #cccccc;">
        <p style="font-style: italic; color: #666666; margin-top: 5px;">Figure 3 : Environnement d'échange d'équipe</p>
    </div>
</div>

<hr>

<h3>3. Synthèses personnelles des membres de l'équipe</h3>
<p>Chaque employé présente ici le travail précis réalisé, les difficultés techniques rencontrées et les solutions apportées.</p>

<div style="background-color: #ffffff; padding: 15px; border: 1px solid #dddddd; border-radius: 4px; margin-bottom: 20px;">
    <h4>Fiche de synthèse : Walid Ben Bahor</h4>
    <ul>
        <li><b>Travail précis réalisé :</b></li>
        <p>Pour ce projet SAE23, je me suis entièrement occupé de la base de donnée ainsi que de la réalisation d'un script bash pour l'automatisation.</p>
        
        <li><b>Problèmes rencontrés :</b></li>
        <p>Lors de l'élaboration du script bash permettant de tout automatiser (notamment, la récupération des valeurs, le stockage et l'envoi de ces dernières dans la base de donnée), l'exportation des valeurs à poser problème de par une mauvaise syntaxe des informations stockées dans un fichier, dédié pour l'exportation vers la base de donnée.   </p>
        
        <li><b>Solutions proposées et appliquées :</b></li>
        <p>Pour résoudre ce problème, j'ai tester des syntaxes différentes jusqu'à que cela fonctionne.</p>
    </ul>
</div>

<div style="background-color: #ffffff; padding: 15px; border: 1px solid #dddddd; border-radius: 4px; margin-bottom: 20px;">
    <h4>Fiche de synthèse : Fennot Nazavae</h4>
    <ul>
        <li><b>Travail précis réalisé :</b></li>
        <p>emplacement txt membre 2</p>
        
        <li><b>Problèmes rencontrés :</b></li>
        <p>emplacement txt membre 2</p>
        
        <li><b>Solutions proposées et appliquées :</b></li>
        <p>emplacement txt membre 2</p>
    </ul>
</div>

<div style="background-color: #ffffff; padding: 15px; border: 1px solid #dddddd; border-radius: 4px; margin-bottom: 20px;">
    <h4>Fiche de synthèse : Léon Cailleaud</h4>
    <ul>
        <li><b>Travail précis réalisé :</b></li>
        <p>emplacement txt membre 3</p>
        
        <li><b>Problèmes rencontrés :</b></li>
        <p>emplacement txt membre 3</p>
        
        <li><b>Solutions proposées et appliquées :</b></li>
        <p>emplacement txt membre 3</p>
    </ul>
</div>

<hr>

<h3>4. Conclusion et validation du cahier des charges</h3>
<p>Bilan général concernant l'atteinte des objectifs fixés par le projet:</p>
<div>
    <p><b>Degré de satisfaction global :</b></p>
    <p>emplacement txt conclusion générale sur la validation du cahier des charges, l'intégration des scripts d'administration et la restitution des mesures pour les gestionnaires.</p>
</div>

<?php
// Close the database link
mysqli_close($conn);
include("footer.php");
?>


