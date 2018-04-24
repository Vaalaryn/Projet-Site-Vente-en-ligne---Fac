<?php 
session_start();
?>
<?php
	//cette page permet de remplir la partie commande au fournisseur
	$id = $_POST["id"];
	$qte = $_POST["qte"];
	$_SESSION["commande"][$id] = $qte;
	header("Location: commande.php");
?>
