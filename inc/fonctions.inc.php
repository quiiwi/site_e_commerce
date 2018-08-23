<?php

//---------------- fonction de debug -------------------

function debug($param){
	echo'<pre>';
		print_r($param);
	echo '</pre>';
}

//--------------- fonction membres ---------------------

// Fonction qui indique si l'internaute est connect� :
function internauteEstConnecte(){
	if (isset($_SESSION['membre'])){ // si la session "membre" existe, c'est que l'internaute est pass� par la page de connexion et que nous avons cr�� cet indice dans $_SESSION
		return true;
	} else {
		return false;
	}
	// OU :
	return (isset($_SESSION['membre']));
}
//Fonction qui indique si le membre est admin connect� :
function internauteEstConnecteEtAdmin(){
	if (internauteEstConnecte() && $_SESSION['membre']['statut'] == 1) {
		//si membre connect� ET que son statut dans la session vaut 1, il est admin connect�
		return true;
	}else {
		return false;
	}
	// OU :
	return (internauteESTConnecte() && $_SESSION['membre']['statut'] == 1);
}



//-------------------- fonction de requ�te ----------------------
function executeRequete($req,$param = array()){ // cette fonction attend 2 valeurs : 1 requ�te SQL (obligatoire) et un array qui associe les marqueurs aux valeurs (non obligatoire car on lui a affect� au param�tre $param un array() vide par d�faut)

	// Echappement des donn�es re�ues avec htmlspecialchars :
	if(!empty($param)){ // si l'array $param n'est pas vide, je peux faire la boucle:
		foreach($param as $indice => $valeur){
			$param[$indice] = htmlspecialchars($valeur, ENT_QUOTES); // on �chappe les valeurs de $param que l'on remet � leur place dans $param[$indice]
		}
	}


	global $pdo; //permet d'avoir acc�s � la variable $pdo d�finie dans l'espace global (c'est-�-dire hors de cette fonction) au sein de cette Fonction

	$result = $pdo->prepare($req); // on pr�pare la requ�te envoy�e � notre fonction.
	$result->execute($param); // on ex�cute la requ�te en lui donnant l'array pr�sent dans $param qui associe tous les marqueurs � leur valeur
	return $result; // on retourne le s�sultat de la requ�te de SELECT











}