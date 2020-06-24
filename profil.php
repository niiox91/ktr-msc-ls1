<?php
session_start();
if(!isset($_SESSION['pseudo'])){
    header("Refresh: 5; url=connexion.php");
    echo "Vous devez vous connecter pour accéder à votre espace membre.<br><br><i>Redirection en cours, vers la page de connexion...</i>";
    exit(0);
}
$Pseudo=$_SESSION['pseudo'];
$mysqli=mysqli_connect('localhost','root','','epitech');
if(!$mysqli) {
    echo "Erreur connexion BDD";
    exit(0);
}
$req=mysqli_query($mysqli,"SELECT * FROM membres WHERE pseudo='$Pseudo'");
$info=mysqli_fetch_assoc($req);
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="main.css">
		<meta name="description" content="">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<title>My profile</title>
    </head>
    <body>
		<?php include('navbar.php'); ?>
        <h1>Espace membre</h1>
        Pour modifier vos informations, <a href="profil.php?modifier">cliquez ici</a>
        <br>
        Pour vous déconnecter, <a href="deco.php">cliquez ici</a>
		<br>
		Ajouter une carte, <a href="add.php">cliquez ici</a>
        <hr/>
        <?php
        if(isset($_GET['modifier'])){
            ?>
            <h1>Modification du compte</h1>
            Choisissez une option: 
            <p>
                <a href="profil.php?modifier=mail">Modifier l'adresse mail</a>
                <br>
                <a href="profil.php?modifier=mdp">Modifier le mot de passe</a>
            </p>
            <hr/>
            <?php
            if($_GET['modifier']=="mail"){
                echo "<p>Renseignez le formulaire ci-dessous pour modifier vos informations:</p>";
                if(isset($_POST['valider'])){
                    if(!isset($_POST['mail'])){
                        echo "Le champ mail n'est pas reconnu.";
                    } else {
                        if(!preg_match("#^[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?@[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?\.[a-z]{2,30}$#i",$_POST['mail'])){
                            echo "L'adresse mail est incorrecte.";
                        } else {
                            if(mysqli_query($mysqli,"UPDATE membres SET mail='".htmlentities($_POST['mail'],ENT_QUOTES,"UTF-8")."' WHERE pseudo='$Pseudo'")){
                                echo "Adresse mail {$_POST['mail']} modifiée avec succès!";
                                $TraitementFini=true;
                            } else {
                                echo "Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.";
                            }
                        }
                    }
                }
                if(!isset($TraitementFini)){
                    ?>
                    <br>
                    <form method="post" action="profil.php?modifier=mail">
                        <input type="email" name="mail" value="<?php echo $info['mail']; ?>" required>
                        <input type="submit" name="valider" value="Valider la modification">
                    </form>
                    <?php
                }
            } elseif($_GET['modifier']=="mdp"){
                echo "<p>Renseignez le formulaire ci-dessous pour modifier vos informations:</p>";
                if(isset($_POST['valider'])){
                    if(!isset($_POST['nouveau_mdp'],$_POST['confirmer_mdp'],$_POST['mdp'])){
                        echo "Un des champs n'est pas reconnu.";
                    } else {
                        if($_POST['nouveau_mdp']!=$_POST['confirmer_mdp']){
                            echo "Les mots de passe ne correspondent pas.";
                        } else {
                            $Mdp=md5($_POST['mdp']);
                            $NouveauMdp=md5($_POST['nouveau_mdp']);
                            $req=mysqli_query($mysqli,"SELECT * FROM membres WHERE pseudo='$Pseudo' AND mdp='$Mdp'");
                            if(mysqli_num_rows($req)!=1){
                                echo "Mot de passe actuel incorrect.";
                            } else {
                                if(mysqli_query($mysqli,"UPDATE membres SET mdp='$NouveauMdp' WHERE pseudo='$Pseudo'")){
                                    echo "Mot de passe modifié avec succès!";
                                } else {
                                    echo "Une erreur est survenue, merci de réessayer ou contactez-nous si le problème persiste.";
                                }
                            }
                        }
                    }
                }
                if(!isset($TraitementFini)){
                    ?>
                    <br>
                    <form method="post" action="profil.php?modifier=mdp">
						<p>Mot de passe</p>
						<input type="password" name="mdp" placeholder="Votre mot de passe actuel..." required><br>
						<p>Nouveau mot de passe</p>
                        <input type="password" name="nouveau_mdp" placeholder="Nouveau mot de passe..." required><br>
						<p>Confirmer mot de passe</p>
                        <input type="password" name="confirmer_mdp" placeholder="Confirmer nouveau passe..." required><br><br>
                        <input type="submit" name="valider" value="Valider la modification">
                    </form>
                    <?php
                }
            }
        }
        ?>
    </body>
</html>