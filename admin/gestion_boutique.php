<?php
require_once '../inc/init.inc.php';

// 1- On vérifie si membre est admin :
if (!internauteEstConnecteEtAdmin()) {
    header('location:../connexion.php'); //si pas admin, on le redirige vers la page de connexion
    exit();
}

// 3- Suppression d'un produit :
debug($_GET);

if(isset($_GET['id_produit'])){
    $resultat = executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array('id_produit' => $_GET['id_produit']));

    if($resultat->rowCount() == 1) { // si j'ai une ligne dans $resultat, j'ai supprimé un produit
        $contenu .= '<div class="bg-success">Le produit a bien été supprimé !</div>';
    } else {
        $contenu .= '<div class="bg-danger">Erreur lors de la suppression du produit !</div>'; //sinon j'affiche un message d'erreur
    }
}



// 2- Affichage des produits dans le back-office :
// Exercice : afficher tous les produits sous forme de table HTML que vous stockez dans la variable $contenu. Tous les champs doivent être affichés. Pour la photo, afficher une image (de 90px de côté).


$contenuProduit = $pdo->query("SELECT id_produit, reference, categorie, titre, description, couleur, taille, public, prix, stock, photo FROM produit ORDER BY id_produit DESC");

$contenu .= '<table border="1">';
	// La ligne d'entêtes :
	$contenu .= '<tr>';
        $contenu .= '<th>id produit</th>';
        $contenu .= '<th>La référence</th>';
		$contenu .= '<th>le catégorie</th>';
		$contenu .= '<th>le titre</th>';
        $contenu .= '<th>la description</th>';
        $contenu .= '<th>la couleur</th>';
        $contenu .= '<th>la taille</th>';
        $contenu .= '<th>le genre</th>';
        $contenu .= '<th>le prix</th>';
        $contenu .= '<th>stock</th>';
        $contenu .= '<th>présentation</th>';
        $contenu .= '<th>action</th>';

    $contenu .= '</tr>';


	// Affichage des autres lignes :
	while($ligne = $contenuProduit->fetch(PDO::FETCH_ASSOC)) {
		$contenu .= '<tr>';
			// affichage des infos de chaque ligne $ligne :
			foreach($ligne as $indice => $info ) {

                if($indice == 'photo'){
                    $contenu .= '<td> <img style="width:90px;height:90px;" src="../'. $info .'" alt="' . $ligne['titre'] . '"> </td>';
                } else{
                    $contenu .= '<td>'	. $info . '</td>';
                }

            }
            $contenu .= '<td><a href="?id_produit='. $ligne['id_produit'] .'" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer ce produit ?\'))" > supprimer </a></td>';
            //$ligne['id_produit'] contient 'lid de chaque produit à chque tour de boucle while : ainsi le lien est dynamique, l'id passé en GET change selon le produit sur lequel je clique


        $contenu .= '</tr>';
	}
$contenu .= '</table>';








//------------------------------- AFFICHAGE -------------------------

require_once '../inc/haut.inc.php';
?>
    <img src="" alt="">
    <h1 class="mt-4">Gestion boutique</h1>

    <ul class="nav nav-tabs">
        <li><a href="gestion_boutique.php" class="nav-link active">Affichage des produits</a></li>
        <li><a href="ajout_produit.php" class="nav-link"> Ajout d'un produit </a><li>
    </ul>


<?php
echo $contenu;
require_once '../inc/bas.inc.php';