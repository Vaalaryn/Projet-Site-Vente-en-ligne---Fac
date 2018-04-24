<?php
	session_start();
	// ce test permet de savoir si l'on vient bien d'un bouton submit et non d'autre part
	if(isset($_POST["submit"])) {
		//celui-ci permet de savoir si tous les champs sont bien remplis
		if(isset($_POST["nom"]) && isset($_POST["prenom"])
			&& !empty($_POST["nom"]) && !empty($_POST["prenom"])
			&& isset($_POST["mdp"]) && isset($_POST["c_mdp"])
			&& !empty($_POST["mdp"]) && !empty($_POST["c_mdp"])
			&& isset($_POST["addr"]) && isset($_POST["email"])
			&& !empty($_POST["addr"]) && !empty($_POST["email"])
			&& isset($_POST["pseudo"]) && !empty($_POST["pseudo"])) {
		  //le test-ci permet de comparer et de vérifier que le mots de passe et sa confirmation correspondent
        if($_POST["mdp"] == $_POST["c_mdp"]){
			//ici le test permet de savoir si le nom et prénom sont bien composés de lettres
          if(ctype_alpha($_POST["nom"]) && ctype_alpha($_POST["prenom"])) {
			
            $connexion = mysqli_connect("localhost","root","","sys");
            //$connexion = mysqli_connect("inf-mysql.univ-rouen.fr","bitotbri","30031997","bitotbri");
            $pseudo = $_POST["pseudo"];
 			$requete_pseudo = "SELECT * FROM personne WHERE pseudo = '".$pseudo."'";
 			$res_pseudo = mysqli_query($connexion, $requete_pseudo);
 			$num_pseudo = mysqli_num_rows($res);
 			
 			$email = $_POST["email"];
			$requete_mail = "SELECT * FROM personne WHERE email = '".$email."'";
 			$res_mail = mysqli_query($connexion, $requete_mail);
 			$num_mail = mysqli_num_rows($res_mail);
 			//ce test permet de savoir si le pseudo ou le mail est déjà present dans la base de données
 			if($num_pseudo > 0){
					$_SESSION["msg"] = "ce pseudo existe déjà !";
			}elseif($num_mail > 0){
					$_SESSION["msg"] = "cet e-mail existe déjà !";
			}else{

            $_SESSION["pseudo"] = $_POST["pseudo"];
			//ensuite ici si tout les tests ont reussi, on enregistre la personne dans la base de données
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $mdp = $_POST["mdp"];
            $addr = $_POST["addr"];
            $requete = "INSERT INTO personne VALUES('$pseudo','$nom','$prenom','$mdp','$email','$addr')";
            mysqli_query($connexion, $requete);
            mysqli_close($connexion);
            //$_SESSION["msg"] permet de renvoyer un message en cas de réussite ou d'erreur 
			$_SESSION["msg"] = "Inscription reussi";
			}
			//cette instruction permet de renvoyer automatiquement vers la page désirée
			header("Location: inscription.php");
			} else {
				$_SESSION["msg"] = "les caractères ne sont pas des lettres !";
				header("Location: inscription.php");
            }
        } else {
          $_SESSION["msg"] = "les mots de passe ne correspondent pas";
          header("Location: inscription.php");
        }
				} else {
			$_SESSION["msg"] = "il faut compléter tous les champs";
			header("Location: inscription.php");
		}
	} else {
		header("Location: inscription.php");
	}
?>
