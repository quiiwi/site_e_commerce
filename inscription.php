<?php
require_once 'inc/init.inc.php';

$inscription = false; // pour savoir si l'internaute vient de s'inscrire (on mettra la variable à true) et ne plus afficher le formulaire d'inscription.

//var_dump($_POST);

//traitement du formulaire :
if(!empty($_POST)){ //si le formulaire est soumis
	
	// Validation des champs du formulaire :
	if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) <4 || strlen($_POST['pseudo']) >20    ) $contenu .= '<div class="bg-danger">Le pseudo doit contenir entre 4 et 20 caractères.</div>';

	if (!isset($_POST['mdp']) || strlen($_POST['mdp']) <4 || strlen($_POST['mdp']) >20    ) $contenu .= '<div class="bg-danger">Le mot de passe doit contenir entre 4 et 20 caractères.</div>';

	if (!isset($_POST['nom']) || strlen($_POST['nom']) <1 || strlen($_POST['nom']) >20    ) $contenu .= '<div class="bg-danger">Le nom doit contenir entre 1 et 20 caractères.</div>';

	if (!isset($_POST['prenom']) || strlen($_POST['prenom']) <1 || strlen($_POST['prenom']) >20    ) $contenu .= '<div class="bg-danger">Le prenom doit contenir entre 1 et 20 caractères.</div>';

	if (!isset($_POST['ville']) || strlen($_POST['ville']) <2 || strlen($_POST['ville']) >20    ) $contenu .= '<div class="bg-danger">La ville doit contenir entre 2 et 20 caractères.</div>';

	if (!isset($_POST['civilite']) || ($_POST['civilite'] != 'm' && $_POST['civilite'] != 'f'  )) $contenu .= '<div class="bg-danger">La civilité est incorrecte.</div>';

	if (!isset($_POST['adresse']) || strlen($_POST['adresse']) <5 || strlen($_POST['adresse']) >50    ) $contenu .= '<div class="bg-danger">L\'adresse doit contenir entre 3 et 50 caractères.</div>';

	if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $contenu .= '<div class="bg-danger">L\'email n\'est pas correct.</div>'; //filter_var,FILTER_VALID_EMAIL permet de vérifier si l'email est correct

	if (!isset($_POST['code_postal']) || !ctype_digit($_POST['code_postal']) || strlen($_POST['code_postal']) != 5) $contenu .= '<div class="bg-danger">Le code postal est incorrect.</div>';  // ctype_digit() permet de vérifier qu'un string contient un nombre entier (utilisé pour les formulaires qui ne retournent que des string avec le type "text")

	//-----------
	//Si pas d'erreur sur le formulaire, on vérifie que le pseudo est disponible dans la BDD :
	if (empty($contenu)){
		$membre = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo'])); //on sélectionne en base les éventuels membre dont le pseudo correspond au pseudo donné par l'internaute lors de l'inscription


		if($membre -> rowCount() > 0) { // si la requête retourne 1 ou plusieurs résultats c'est que le pseudo existe en BDD'
			$contenu .= '<div class="bg-danger"> Le pseudo est indisponible. Veuillez en choisir un autre. </div>';
		} else {
			// sinon, le pseudo étant disponible, on enregistre le membre en BDD :

			//debug($_POST);

			executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, 0) ",
				array(':pseudo' => $_POST['pseudo'],
					  ':mdp' => $_POST['mdp'],
					  ':nom' => $_POST['nom'],
					  ':prenom' => $_POST['prenom'],
					  ':email' => $_POST['email'],
					  ':civilite' => $_POST['civilite'],
					  ':ville' => $_POST['ville'],
					  ':code_postal' => $_POST['code_postal'],
					  ':adresse' => $_POST['adresse']
				));

			$contenu .= '<div class="bg-success"> Vous êtes inscrit à notre site. <a href="connexion.php"> cliquez ici pour vous connecter. </a>  </div>';

			$inscription = true; // pour ne plus afficher le formulaire sur cette page

		}//fin du else


	} //fin du if (empty($contenu))


} //fin du if(!empty($_POST)){


//------------------ AFFICHAGE ---------------------
require_once 'inc/haut.inc.php';
echo $contenu; // pour afficher les messages à l'internaute'
?>
	<h1 class="mt-4">Inscription</h1>
<?php

if(!$inscription) : //(!inscription) équivaut à ($inscription == false), c'est à dire que nous entrons dans la condition si $inscription vaut false.syntaxe en if (condition) : ... enfif.
?>

	<p>Veuillez renseigner le formulaire pour vous inscrire.</p>

	<form method="post" action="">
		<label for="pseudo">Pseudo</label><br>
		<input type="text" name="pseudo" id="pseudo" value=""><br><br>

		<label for="mdp">Mot de passe</label><br>
		<input type="text" name="mdp" id="mdp" value=""><br><br>

		<label for="nom">Nom</label><br>
		<input type="text" name="nom" id="nom" value=""><br><br>

		<label for="prenom">Prenom</label><br>
		<input type="text" name="prenom" id="prenom" value=""><br><br>

		<label for="email">Email</label><br>
		<input type="text" name="email" id="email" value=""><br><br>

		<label >civilité</label> <br>
		<input type="radio" name="civilite" id="" value="m" checked> Homme
		<input type="radio" name="civilite" id="" value="f"> Femme <br>

		<label for ="ville">Ville</label><br>
		<input type="text" name="ville" id="ville" value=""><br><br>

		<label for ="code_postal">Code postale</label><br>
		<input type="text" name="code_postal" id="code_postal" value=""><br><br>

		<label for ="adresse">Adresse</label><br>
		<textarea name='adresse' id='adresse'></textarea><br><br>

		<input type="submit" name="inscription" value="s'inscrire" class="btn">

	</form>





<?php

endif;

require_once 'inc/bas.inc.php';