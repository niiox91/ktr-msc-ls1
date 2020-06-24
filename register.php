<!DOCTYPE HTML>
<html>
    <head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="main.css">
		<meta name="description" content="">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<title>Inscription</title>
    </head>
    <body>
        <?php
        if(isset($_POST['valider'])){
            if(!isset($_POST['pseudo'],$_POST['mdp'],$_POST['mail'])){
                echo "Un des champs n'est pas reconnu.";
            } else {
                if(!preg_match("#^[a-z0-9]{1,15}$#",$_POST['pseudo'])){
                    echo "Le pseudo est incorrect, doit contenir seulement des lettres minuscules et/ou des chiffres, d'une longueur minimum de 1 caractère et de 15 maximum.";
                } else {
                    if(strlen($_POST['mdp'])<5 or strlen($_POST['mdp'])>15){
                        echo "Le mot de passe doit être d'une longueur minimum de 5 caractères et de 15 maximum.";
                    } else {
                        if(!preg_match("#^[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?@[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?\.[a-z]{2,30}$#i",$_POST['mail'])){
                            echo "L'adresse mail est incorrecte.";
                        } else {
                            if(strlen($_POST['mail'])<7 or strlen($_POST['mail'])>50){
                                echo "Le mail doit être d'une longueur minimum de 7 caractères et de 50 maximum.";
                            } else {
                                $mysqli=mysqli_connect('localhost','root','','epitech');
                                if(!$mysqli) {
                                    echo "Erreur connexion BDD";
                                } else {
									$Pseudo=htmlentities($_POST['pseudo'],ENT_QUOTES,"UTF-8");
									$Name=htmlentities($_POST['nameusr'],ENT_QUOTES,"UTF-8");
									$Company=htmlentities($_POST['company'],ENT_QUOTES,"UTF-8");
                                    $Mdp=md5($_POST['mdp']);
									$Mail=htmlentities($_POST['mail'],ENT_QUOTES,"UTF-8");
									$Phone=htmlentities($_POST['phone'],ENT_QUOTES,"UTF-8");
                                    if(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM membres WHERE pseudo='$Pseudo'"))!=0){
                                        echo "Ce pseudo est déjà utilisé par un autre membre, veuillez en choisir une autre svp.";
                                    } else {
										   if(mysqli_query($mysqli,"INSERT INTO membres SET pseudo='$Pseudo', nameusr='$Name', company='$Company', mdp='$Mdp', mail='$Mail',phone='$Phone'")){
                                           echo "Inscrit avec succès! Vous pouvez vous connecter: <a href='connexion.php'>Cliquez ici</a>.";
                                           $TraitementFini=true;
											} else {
												echo "Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.";
											}
										}
                                }
                            }
                        }
                    }
                }
            }
		}
		
        if(!isset($TraitementFini)){
            ?>
			<?php include('navbar.php'); ?>
            <br>
			<h1>Inscription</h1>
            <form method="post" action="register.php">
				<p>Pseudo</p>
                <input type="text" name="pseudo" placeholder="Votre pseudo..." required>
				<p>Nom Prénom</p>
                <input type="text" name="nameusr" placeholder="Votre nom complet..." required>
				<p>Compangnie</p>
				<input type="text" name="company" placeholder="Votre company..." required>
				<p>Mot de passe</p>
                <input type="password" name="mdp" placeholder="Votre mot de passe..." required>
				<p>Email</p>
                <input type="email" name="mail" placeholder="Votre mail..." required>
				<p>Téléphone</p>
				<input type="text" name="phone" placeholder="Votre tel..." required><br><br>
                <input type="submit" name="valider" value="Envoyer">
            </form>
            <?php
        }
        ?>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>