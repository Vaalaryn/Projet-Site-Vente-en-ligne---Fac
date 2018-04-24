<?php
session_start();
// ce formulaire est semblable au formulaire d'inscription 
if(isset($_POST["submit"])) {

	if(isset($_POST["nom"]) && isset($_POST["prix"])
		&& !empty($_POST["nom"]) && !empty($_POST["prix"])
		&& isset($_POST["desc"]) && isset($_POST["qte"])
		&& isset($_POST["cat"]) && !empty($_POST["cat"])
		&& !empty($_POST["desc"]) && !empty($_POST["qte"])) {
		//ce teste permet de savoir si la quantité et le prix sont bien des nombres
		if(is_numeric($_POST["qte"]) && is_numeric($_POST["prix"])) {
			//ici on test si l'extension de l'image est au bon format
			$extensions_valides = array('jpg', 'jpeg', 'png');
			//ici on récupere juste l'extension du nom de notre fichier
			$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

			if (in_array($extension_upload, $extensions_valides)){ 
				if ($_FILES['image']['error'] > 0){ 
					$_SESSION["msg"] = "Erreur lors du transfert de l'image";
					header("Location: nouvel_objet.php");
				}
				//ici on genere un nom aleatoire pour l'image
				$nom_img = md5(uniqid(rand(), true));
				$img = "../img/{$nom_img}.{$extension_upload}";
				//ici on déplace le fichier vers sa destination finale choisi juste au dessus le reste est semblable au formulaire d'inscription
				$resultat = move_uploaded_file($_FILES['image']['tmp_name'],$img);

				$connexion = mysqli_connect("localhost","root","","sys");
				//$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
				
				$requete_count = "SELECT * FROM objet";
				$res_count = mysqli_query($connexion, $requete_count);
				$id = mysqli_num_rows($res_count);
				++$id;
				$_SESSION["panier"][$id] = 0;
				$nom = $_POST["nom"];
				$prix = $_POST["prix"];
				$qte = $_POST["qte"];
				$desc = $_POST["desc"];
				$cat = $_POST["cat"];

				$requete = "INSERT INTO	objet VALUES('$id','$nom','$prix','$qte','$desc','$img','$cat')";
				mysqli_query($connexion, $requete);
				mysqli_close($connexion);
				header("Location: index.php");
			}else {	
				$_SESSION["msg"] = "Mauvais format d'image !";
				header("Location: nouvel_objet.php");
			}
		} else {
			$_SESSION["msg"] = "le prix et la quantité ne sont pas des chiffres !";
			header("Location: nouvel_objet.php");
		}
	} else {
	$_SESSION["msg"] = "il faut compléter tous les champs";
	header("Location: nouvel_objet.php");
	}
} else {
header("Location: nouvel_objet.php");
}
?>
