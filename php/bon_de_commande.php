<?php require("entete.php");?>
    <!-- cette page est similaire à la page achat.php -->
    <div id="compte">
		<?php 
		if($_SESSION["pseudo"] != "admin"){
			header("Location: index.php");
		}
		if(isset($_SESSION["pseudo"]) AND !empty($_SESSION["pseudo"])){
			echo "<form method='post' action='deconnexion.php'>";
			$pseudo = $_SESSION["pseudo"];
			echo "<p>Bienvenue $pseudo</p>";
			echo "<input id='deco' value='Déconnexion' type='submit'/>";
			echo "</form>";
		}else {
			echo "<form method='post' action='connexion.php'>";
			echo "<input class='log' type='text' name='identifiant' placeholder='Pseudo'/>";
			echo "<input class='log' type='password' name='mdp' placeholder='Mot De Passe'/>";
			if(isset($_SESSION["msgco"]) && $_SESSION["msgco"] == "Connexion échouée"){
				echo "<p id='co2'>".$_SESSION["msgco"]."</p>";
			}
			echo"<input type='submit' value='OK' id='bouton_co'/></form>";
			$_SESSION["msg"] = " ";
			echo "<a id='co' href='inscription.php'><p>inscription</p></a>";
		}
		?>
		</div>
		
<div id="corps_achat">
	<form method="post" action="traitement_bon_de_commande.php">
	<table id="liste_achat">
		<tr>
		<th class="nom_achat">Nom</th>
		<th class="qte_achat">Quantité</th>
		</tr>
	<?php
	$connexion = mysqli_connect("localhost","root","","sys");
    //$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
    $id = 1;
    $tot = 0;
	if(!empty($_SESSION["commande"])){
		while($obj = mysqli_fetch_array(mysqli_query($connexion, "SELECT * FROM objet WHERE id ='$id'"))){
			if($_SESSION["commande"][$id] > 0 AND !empty($_SESSION["commande"][$id])){
				echo "<tr>";
				echo "<td class='nom_achat'>{$obj['nom']}</td>";
				echo "<td class='qte_achat'>".$_SESSION["commande"][$id]."</td>";
				echo "</tr>";
			}
			++$id;
		}	
	}
	echo "</table>";
	?>
	<input type="submit" name="submit" value="Acheter" id="achat"/>
	</form>
</div>
<form method="post" action="index.php"><input class="bouton_retour2" type="submit" value="Retour"/></form>
<?php require("pied.php");?>
