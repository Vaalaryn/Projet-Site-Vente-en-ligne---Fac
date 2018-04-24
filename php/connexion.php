
<?php 
	session_start();
	?>
	
<?php
	//cette page permet de tester si le pseudo et le mot de passe correspondent au même compte
	 $connexion = mysqli_connect("localhost","root","","sys");
	//$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
	$pseudo = $_POST['identifiant'];
	$mdp = $_POST['mdp'];
	$requete = "SELECT * FROM personne WHERE pseudo = '$pseudo' AND mdp = '$mdp'";
	$res = mysqli_query($connexion, $requete);
	$compte = mysqli_fetch_array($res);
	if(!empty($compte)){
		$_SESSION["pseudo"] = $pseudo;
	}else{
		$_SESSION["msgco"] = "Connexion échouée";
	}
	header("Location: index.php");
?>
