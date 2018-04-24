<?php require("entete.php"); ?>
    <div id="conteneur">
      <div id="corps_produit">
      <?php
      if(isset($_POST["submit"])) {
      //sur cette page, on voit la fiche détaillée du produit selectioné sur l'index
      if(isset($_POST['id'])){
			$id = $_POST['id'];
		}else {
			$id = $_SESSION["id"];
		}
        $connexion = mysqli_connect("localhost","root","","sys");
        //$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
        $requete = "SELECT * FROM objet WHERE id = '$id'";
        $res = mysqli_query($connexion, $requete);
        while($obj = mysqli_fetch_array($res)){
          echo "<img src='{$obj['img']}' id='img' alt='img_produit'/>";
          echo "<p id='nom_produit'>{$obj['nom']}</p>";
          echo "<hr/>";
          echo "<fieldset>
            <legend>Prix</legend>
            <p>{$obj['prix']}€</p>
          </fieldset>";
          echo "<fieldset>
            <legend>Restant</legend>
            <p>{$obj['qte']}</p>
          </fieldset>";
          echo "<form method='post' action='formulaire_panier.php'>";
          echo "<fieldset>
          <legend>Achat</legend>
			<input type='number' name='qte' id='quantite' max='{$obj['qte']}' min='0'/>
            <input type='hidden' name='id2' value='$id'/>
            <input id='bouton_achat' type='submit' value='acheter'/>
          </fieldset>";
          echo "</form>";
          echo "<p id='description_t'>Description : </p>";
          echo "<p id='description'>{$obj['desc']}</p>";
          echo "<form method='post' action='index.php'><input type='submit' class='bouton_retour'  value='Retour'/></form>
        </div>";
        }
        mysqli_close($connexion);
		}else {
			header("Location: index.php");
		}
      ?>
    </div>
<?php require("pied.php"); ?>
