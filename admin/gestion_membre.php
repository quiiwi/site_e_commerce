<?php
require_once '../inc/init.inc.php';
// Exercice :
/* Vous allez créer la page de gestion des membres dans le back-office :
    1- Seul les admin ont accès à cette page. Les autres sont redirigés vers connexion.php.
    2- Afficher dans cette pasge tous les membres inscrits sous forme de table HTML, avec toutes les infos SAUF le mot de passe.
    3- Afficher le nombre de membres.
*/
// 1- On vérifie si membre est admin :
if (!internauteEstConnecteEtAdmin()) {
    header('location:../connexion.php'); //si pas admin, on le redirige vers la page de connexion
    exit();
}

if(isset($_GET['id_membre'])){
    $resultat = executeRequete("DELETE FROM membre WHERE id_membre = :id_membre", array('id_membre' => $_GET['id_membre']));

    if($resultat->rowCount() == 1) { // si j'ai une ligne dans $resultat, j'ai supprimé un produit
        $contenu .= '<div class="bg-success">Le membre a bien été supprimé !</div>';
    } else {
        $contenu .= '<div class="bg-danger">Erreur lors de la suppression du membre !</div>'; //sinon j'affiche un message d'erreur
    }
}


$contenuMembres = $pdo->query("SELECT id_membre, pseudo, nom, email, civilite, ville, code_postal, adresse, statut FROM membre ORDER BY id_membre DESC");


$contenu .= '<table border="1">';
	// La ligne d'entêtes :
	$contenu .= '<tr>';
        $contenu .= '<th>id_membre</th>';
        $contenu .= '<th>pseudo</th>';
		//$contenu .= '<th>mdp</th>';
		$contenu .= '<th>nom</th>';
        $contenu .= '<th>email</th>';
        $contenu .= '<th>civilite</th>';
        $contenu .= '<th>ville</th>';
        $contenu .= '<th>code_postal</th>';
        $contenu .= '<th>adresse</th>';
        $contenu .= '<th>statut</th>';

    $contenu .= '</tr>';

    
	// Affichage des autres lignes :
	while($ligne = $contenuMembres->fetch(PDO::FETCH_ASSOC)) {
        $contenu .= '<tr>';
        
        
			// affichage des infos de chaque ligne $ligne :
			foreach($ligne as $indice => $info ) {

                $contenu .= '<td>'	. $info . '</td>';
                
            }
            $contenu .= '<td><a href="?id_membre='. $ligne['id_membre'] .'" onclick="return(confirm(\'Etes-vous certain de vouloir supprimer ce produit ?\'))" > supprimer </a></td>';
            //$ligne['id_produit'] contient 'lid de chaque produit à chque tour de boucle while : ainsi le lien est dynamique, l'id passé en GET change selon le produit sur lequel je clique


        $contenu .= '</tr>';
	}
$contenu .= '</table>';

//$contenu .= '<p> Il y a '. $contenuMembres->rowCount() . ' inscrit sur votre site !</p>';

if($contenuMembres->rowCount() == 0){
    $contenu .= '<p>Vous n\'avez aucun membre inscrit</p>';
} else{
    $contenu .= '<p> Il y a '. $contenuMembres->rowCount() . ' inscrit sur votre site !</p>';
}







//------------AFFICHAGE-------------
require_once '../inc/haut.inc.php';
?>

    <h1 class="mt-4">Gestion des membres !</h1>


<?php
echo $contenu;
require_once '../inc/bas.inc.php';