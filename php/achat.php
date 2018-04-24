<?php require("entete.php");?>
    
    <div id="compte">
		<?php 
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
		<!-- affiche l'ensemble du panier avec le détail des prix et du total à payer -->
<div id="corps_achat">
	<form method="post" action="traitement_achat.php">
	<table id="liste_achat">
		<tr>
		<th class="nom_achat">Nom</th>
		<th class="qte_achat">Quantité</th>
		<th class="prix_u_achat">Prix unité</th>
		<th class="prix_t_achat">Prix total</th>
		</tr>
	<?php
	$connexion = mysqli_connect("localhost","root","","sys");
    //$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
    $id = 1;
    $tot = 0;
	if(!empty($_SESSION["panier"])){
		while($obj = mysqli_fetch_array(mysqli_query($connexion, "SELECT * FROM objet WHERE id ='$id'"))){
			if($_SESSION["panier"][$id] > 0 AND !empty($_SESSION["panier"][$id])){
				echo "<tr>";
				echo "<td class='nom_achat'>{$obj['nom']}</td>";
				echo "<td class='qte_achat'>".$_SESSION["panier"][$id]."</td>";
				echo "<td class='prix_u_achat'>{$obj['prix']} €</td>";
				$prix_t = $_SESSION["panier"][$id] * $obj['prix'];
				$tot = $tot + $prix_t;
				echo "<td class='prix_t_achat'>$prix_t €</td>";
				echo "</tr>";
			}
			++$id;
		}	
	}
	echo "</table>";
	echo "<p class='prix_t'>Prix total : $tot €</p>";
	?>
	<input type="submit" name="submit" value="Acheter" id="achat"/>
	</form>
</div>
<form method="post" action="index.php"><input class="bouton_retour2" type="submit" value="Retour"/></form>
<?php require("pied.php");?>
