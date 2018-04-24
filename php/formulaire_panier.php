<?php 
session_start();
?>
<?php
	//ce formulaire est identique à celui de commande
	$id = $_POST["id2"];
	$qte = $_POST["qte"];
	$_SESSION["panier"][$id] = $qte;
	header("Location: index.php");
?>
