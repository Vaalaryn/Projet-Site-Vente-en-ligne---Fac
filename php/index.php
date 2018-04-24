<?php require("entete.php");
            $connexion = mysqli_connect("localhost","root","","sys");
            //$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
 ?>
    <!-- ce bloc div sert à tester si la personne a connecté son compte ou a rentré ses identifiants pour se connecter et contient le lien pour être redirigé vers l'inscription -->
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
		<!-- ce bloc sert à contenir les blocs menu et corps-->
    <div id="conteneur">
		<!--le bloc menu est divisé en 3 parties la recherche le menu des autres pages de site avec celles reservées à l'admin qui n'apparaissent qui si l'on est connecté au compte admin-->
      <div id="menu">
		   <!--la recherche permet de chercher un nom et/ou une catégorie dans la liste de produit-->
		  <h2>Recherche d'objet</h2>
		<form method="post" action="index.php"> 
		<input type="text" name="rech" placeholder="Rechercher ..." id="recherche"/>
		<?php require("categorie.php");?>
		<input type="submit" value="OK" class="bouton_recherche"/>
		</form>
		<hr/>
		<!--le menu sert a avoir acces au page suplementaires du site-->
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
		?>		<hr/>
		<!--le panier affiche la liste des objets ajoutés au panier et de leur quantité-->
		<h2>Panier</h2>
		<?php
		
		$id = 1;
		echo "<form method='post' action='achat.php'>";
		echo"<ul>";
		if(!empty($_SESSION["panier"])){
			while($obj = mysqli_fetch_array(mysqli_query($connexion, "SELECT * FROM objet WHERE id ='$id'"))){
				if($_SESSION["panier"][$id] > 0 AND !empty($_SESSION["panier"][$id])){
					echo "<li>{$obj['nom']} x".$_SESSION["panier"][$id]."</li>";
				}
				++$id;
			}	
			echo "</ul>";
		}
		echo " <input type='submit' value='Achat' class='bouton_recherche'/>";
		echo "</form>";
		?>
      </div>
		<!--le corps est la partie où l'on va afficher tous les produits-->
      <div id="corps">
            <?php
            $k = 1;
            //cette partie est en relation avec la partie recherche du menu c'est elle qui permet la sélection des produits dans la base de données
            if(isset($_POST["rech"]) && isset($_POST["cat"]) && $_POST["cat"] != "tout"){
				$r = $_POST["rech"];
				$c = $_POST["cat"];
				$requete = "SELECT * FROM objet WHERE nom LIKE '%".$r."%' AND cat = '$c'"; 
			} elseif(isset($_POST["rech"])) {
				$r = $_POST["rech"];
				$requete = "SELECT * FROM objet WHERE nom LIKE '%".$r."%'";
			}elseif(isset($_POST["cat"]) && $_POST["cat"] != "tout"){
				$c = $_POST["cat"];
				$requete = "SELECT * FROM objet WHERE cat = '$c'";
			}else{
				$requete = "SELECT * FROM objet";
			}
            $res = mysqli_query($connexion, $requete);
            //c'est cette partie qui affiche les produits
              while($obj = mysqli_fetch_array($res)){
				  if($obj["qte"] > 0){
                echo "<div class='obj'>";
                echo "<img src='{$obj['img']}' class='img_obj' alt='{$obj['nom']}'/>";
                echo "<p class='nom_obj'>{$obj['nom']}</p>";
                echo "<p class='prix_obj'>Prix : {$obj['prix']}€</p>";
                echo "<form method='post' action='produit.php'>";
                echo "<input type='hidden' name='id' value='$k'>";
                //renvoie à la fiche produit pour plus de détails sur le produit
                echo "<input type='submit' name='submit' value='Fiche Produit' class='fiche_produit'/>";
                //initialise le panier à 0
   				if(empty($_SESSION["panier"][$k])){
					$_SESSION["panier"][$k] = 0;
				}
                echo "<hr/>";
                echo "</form>";
                echo "</div>";
                }
                ++$k;
              }
            mysqli_close($connexion);
            ?>
      </div>
    </div>
<?php require("pied.php"); ?>
