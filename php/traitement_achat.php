<?php require("entete.php");

$connexion = mysqli_connect("localhost","root","","sys");
//$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
//cette page créée la facture et la stocke dans le dossier facture et met aussi à jour la base de données sur les quantités restantes
if(isset($_POST["submit"])) {
if(isset($_SESSION["pseudo"]) AND !empty($_SESSION["pseudo"])){
	
	$date = date("d-m-Y_H-i");
	$nom_facture = "../facture/".$_SESSION["pseudo"]."_$date.txt";
	$facture = fopen($nom_facture,"w+");
	
	$personne = mysqli_fetch_array(mysqli_query($connexion, "SELECT * FROM personne WHERE pseudo ='".$_SESSION["pseudo"]."'"));
	fwrite($facture,"{$personne["nom"]} {$personne["prenom"]}");
	fwrite($facture,"\n addresse: {$personne["adresse"]}");
	
	$id = 1;
	$tot = 0;
	while($obj = mysqli_fetch_array(mysqli_query($connexion, "SELECT * FROM objet WHERE id ='$id'"))){
	if($_SESSION["panier"][$id] > 0){
		$prix_tot = $_SESSION["panier"][$id] * $obj["prix"];
		$tot = $prix_tot + $tot;
		fwrite($facture, "\n {$obj['nom']} - quantite: ".$_SESSION["panier"][$id]." - prix: {$obj['prix']}E - prix total: {$prix_tot}E;");
		//modifie la quantité pour enlever ce que l'on à acheté du stock
 		$new_qte = $obj["qte"] - $_SESSION["panier"][$id];
 		$_SESSION["panier"][$id] = 0;
		mysqli_query($connexion, "UPDATE objet SET qte='$new_qte' WHERE id ='$id'");
	}
	++$id;
	}
	fwrite($facture, "\n total: {$tot}E");
	fclose($facture);
	
	echo "<p class='message_achat'>Achat effectuer</p>";
	echo "<a TARGET=_BLANK href='$nom_facture' class='message_achat'>Facture</a>";
}else{
	echo "<p class='message_achat'>Veuillez vous connecter pour finaliser votre achat</p>";
}
echo "<form method='post' action='index.php'><input class='bouton_retour2' type='submit' value='Retour'/></form>";
}else {
	header("Location: index.php");
}
require("pied.php");?>
