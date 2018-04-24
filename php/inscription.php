<?php require("entete.php"); ?>
	<div id="inscription">
		<?php 
		//cette page permet d'afficher un message d'erreur et les champs de saisie concernés si l'inscription n'est pas faite ou si il y a eu une erreur lors de l'inscription
		// et d'afficher uniquement une message de reussite et un lien pour retourner vers l'index si l'inscription est réussie
		$k = "Inscription reussi";
		$h = $_SESSION["msg"];
		if($h != $k OR !isset($_SESSION["msg"])){
			echo "<form method='post' action='formulaire_inscription.php'>
				<input class='saisie' type='text' name='nom' placeholder='Nom'><br/>
				<input class='saisie' type='text' name='prenom' placeholder='Prénom'><br/>
				<input class='saisie' type='text' name='pseudo' placeholder='Pseudo'><br/>
				<input class='saisie' type='text' name='email' placeholder='Email'><br/>
				<input class='saisie' type='text' name='addr' placeholder='Addresse'><br/>
				<input class='saisie' type='password' name='mdp' placeholder='Mot De Passe'><br/>
				<input class='saisie' type='password' name='c_mdp' placeholder='Confirmer Mot De Passe'><br/>";
				
				
		}
		if(isset($_SESSION["msg"])) {
			echo "<p id='attention'>".$_SESSION["msg"]."</p>";
			if($h == $k){
				echo "<a href='index.php'><p id='attention'>Retour à la page principale</p></a>";
			}
		}
		
		if($h != $k){
			echo "<input class='saisie' type='submit' name='submit' value='Envoyer' ><br/>";
		}
		echo "</form>";
		?>
	<form method="post" action="index.php"><input class="bouton_retour2" type="submit" value="Retour"/></form>
	</div>
<?php require("pied.php"); ?>
