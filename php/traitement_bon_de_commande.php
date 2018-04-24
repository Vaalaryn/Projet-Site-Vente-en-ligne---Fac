<?php require("entete.php");
if(isset($_POST["submit"])) {
if($_SESSION["pseudo"] == "admin"){
//cette page permet la création du bon de commande pour le fournisseur. Elle marche comme la page traitement_achat.php
$connexion = mysqli_connect("localhost","root","","sys");
//$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
	
	$date = date("d-m-Y_H-i");
	$nom_commande = "../commande/commande_$date.txt";
	$commande = fopen($nom_commande,"w+");
	$id = 1;
	while($obj = mysqli_fetch_array(mysqli_query($connexion, "SELECT * FROM objet WHERE id ='$id'"))){
	if($_SESSION["commande"][$id] > 0){
		fwrite($commande, "\n {$obj['nom']} - quantite: ".$_SESSION["commande"][$id].";");
		//modifie la quantité pour rajouter du stock
 		$new_qte = $obj["qte"] + $_SESSION["commande"][$id];
 		$_SESSION["commande"][$id] = 0;
		mysqli_query($connexion, "UPDATE objet SET qte='$new_qte' WHERE id ='$id'");
	}
	++$id;
	}
	fclose($commande);
	echo "<p class='message_achat'>Achat effectuer</p>";
	echo "<a TARGET=_BLANK href='$nom_commande' class='message_achat'>Facture</a>";
	
echo "<form method='post' action='index.php'><input class='bouton_retour2' type='submit' value='Retour'/></form>";
}else {
		header("Location: index.php");
}
}else
{
		header("Location: index.php");
}

require("pied.php");?>
