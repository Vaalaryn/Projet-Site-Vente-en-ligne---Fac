<?php 
require("entete.php"); 
$connexion = mysqli_connect("localhost","root","","sys");
//$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
if($_SESSION["pseudo"] != "admin"){
	header("Location: index.php");
}
?>		<!-- cette page est identique à celle de l'index la seule partie qui change est la partie affichage des produits et le panier -->
	    <div id="compte">
		<?php 
		if(isset($_SESSION["pseudo"])){
			echo "<form method='post' action='deconnexion.php'>";
			$pseudo = $_SESSION["pseudo"];
			echo "<p>Bienvenue $pseudo</p>";
			echo "<input id='deco' value='Déconnexion' type='submit'/>";
			echo "</form>";
		}else {
			echo "<form method='post' action='connexion.php'>";
			echo "<input class='log' type='text' name='identifiant' placeholder='Identifiant'/>";
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
    <div id="conteneur">

      <div id="menu">
		  <h2>Recherche d'objet</h2>
		<form method="post" action="commande.php"> 
		<input type="text" name="rech" placeholder="Rechercher ..." id="recherche"/>
		<?php require("categorie.php");?>
		<input type="submit" value="OK" class="bouton_recherche"/>
		</form>
		<hr/>
		<h2>Menu</h2>
		<?php 
		echo "<ul>";
		echo "<li ><a class='lien' href='index.php'>Accueil</a></li>";
		if(isset($_SESSION["pseudo"])){
			if($_SESSION["pseudo"] == "admin"){
				echo "<li ><a class='lien' href='commande.php'>Commander au fournisseur</a></li>";
				echo "<li ><a class='lien' href='nouvel_objet.php'>Ajouter un objet</a></li>";
			}
		}
		echo "</ul>";
		?>
		<hr/>
		<!-- fonctionne comme le panier de l'index-->
		<h2>Commande aux Fournisseur</h2>
		<?php
		$id = 1;
		echo "<form method='post' action='bon_de_commande.php'>";
		echo"<ul>";
		if(!empty($_SESSION["commande"]) AND isset($_SESSION["commande"])){
		while($obj = mysqli_fetch_array(mysqli_query($connexion, "SELECT * FROM objet WHERE id ='$id'"))){
			if($_SESSION["commande"][$id] > 0){
				echo "<li>{$obj['nom']} x".$_SESSION["commande"][$id]."</li>";
			}
			++$id;
		}
		echo "</ul>";
		echo "<input type='submit' value='Commander' class='bouton_recherche'/>";
           echo "</form>";
		}
		?>
      </div>
      <div id="corps">

            <?php
            $k = 1;
            if(isset($_POST["rech"]) && isset($_POST["cat"]) && $_POST["cat"] != "tout"){
				$r = $_POST["rech"];
				$c = $_POST["cat"];
				$requete = "SELECT * FROM objet WHERE nom LIKE '%".$r."%' AND cat = '$c'"; 
			}elseif(isset($_POST["rech"])) {
				$r = $_POST["rech"];
				$requete = "SELECT * FROM objet WHERE nom LIKE '%".$r."%'";
			}elseif(isset($_POST["cat"]) && $_POST["cat"] != "tout"){
				$c = $_POST["cat"];
				$requete = "SELECT * FROM objet WHERE cat = '$c'";
			}else{
				$requete = "SELECT * FROM objet";
			}
            $res = mysqli_query($connexion, $requete);
              while($obj = mysqli_fetch_array($res)){
                echo "<div class='obj'>";
                echo "<img src='{$obj['img']}' class='img_obj' alt='{$obj['nom']}'/>";
                echo "<p class='nom_obj'>{$obj['nom']}</p>";
                echo "<p class='prix_obj'>Prix : {$obj['prix']}€</p>";
                echo "<form method='post' action='formulaire_commande.php'>";
                echo "<input type='hidden' name='id' value='$k'>";
				if(empty($_SESSION["commande"][$k])){
					$_SESSION["commande"][$k] = 0;
				}
				//c'est cette partie qui change au lieu de renvoyer sur la page produit elle renvoie au formulaire de commande qui permet d'ajouter le produit et la quantite choisi a la commande au fournisseur
                echo "<input type='text' name='qte' class='qte_commande_produit'/>";
				echo "<input type='submit' class='commande_produit' value='ajouter'/>";
                echo "<hr/>";
                echo "</form>";
                echo "</div>";
                ++$k;
              }
            mysqli_close($connexion);
            ?>
      </div>
    </div>
<?php require("pied.php"); ?>
