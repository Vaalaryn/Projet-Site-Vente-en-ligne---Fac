<?php require("entete.php"); ?>
	<div id="inscription">
		<?php 
		if($_SESSION["pseudo"] != "admin"){
			header("Location: index.php");
		}
		//cette page est similaire a la page d'inscription sauf qu'ici on va ajouter un nouveau produit
		$k = "Ajout reussi";
		$h = $_SESSION["msg"];
		if($h != $k OR !isset($_SESSION["msg"])){
			echo "<h2>Nouvel Objet</h2>
				<form method='post' action='formulaire_nouvel_objet.php' enctype='multipart/form-data'>
				<input class='saisie' type='text' name='nom' placeholder='Nom'><br/>
				<input class='saisie' type='text' name='prix' placeholder='Prix'><br/>
				<input class='saisie' type='text' name='qte' placeholder='Quantité'><br/>";
				require("categorie.php");
			echo "<input class='saisie' type='hidden' name='MAX_FILE_SIZE' value='1073741824' />
				 <input class='saisie' type='file' name='image' id='image' /><br />
				 <textarea id='saisie_desc' name='desc' placeholder='Description de votre fichier (max. 255 caractères)'></textarea><br/>";
				
				
		}
		if(isset($_SESSION["msg"])) {
			echo "<p id='attention'>".$_SESSION["msg"]."</p>";
			if($h == $k){
				$_SESSION["msg"] = "";
				}
		}
		
		if($h != $k){
			echo "<input class='saisie' type='submit' name='submit' value='Ajouter' ><br/>";
		}
		echo "</form>";
		$_SESSION["msg"] = ""
		?>
	<form method="post" action="index.php"><input class="bouton_retour2" type="submit" value="Retour"/></form>
	</div>
<?php require("pied.php"); ?>
 
