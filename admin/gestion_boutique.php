<?php
require_once '../inc/init.inc.php';

// 1- On vérifie si membre est admin :
if (!internauteEstConnecteEtAdmin()) {
    header('location:../connexion.php'); //si pas admin, on le redirige vers la page de connexion
    exit();
}





//------------------------------- AFFICHAGE -------------------------

require_once '../inc/haut.inc.php';
?>

    <h1 class="mt-4">Gestion boutique</h1>

    <ul class="nav nav-tabs">
        <li><a href="gestion_boutique.php" class="nav-link active">Affichage des produits</a></li>
        <li><a href="ajout_produit.php" class="nav-link"> Ajout d'un produit </a><li>
    </ul>


<?php
echo $contenu;
require_once '../inc/bas.inc.php';