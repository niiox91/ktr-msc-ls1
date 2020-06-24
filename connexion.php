<?php
session_start();
?><!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="main.css">
        <meta name="description" content="">
        <title>Connexion</title>
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <?php include('navbar.php'); ?>
        <h1>Se connecter</h1>
        <br>
        <?php
        if(isset($_SESSION['pseudo'])){
            echo "Vous êtes déjà connecté, vous pouvez accéder à l'espace membre en <a href='profil.php'>cliquant ici</a>.";
        } else {
            if(isset($_POST['valider'])){
                if(!isset($_POST['pseudo'],$_POST['mdp'])){
                    echo "Un des champs n'est pas reconnu.";
                } else {
                    $mysqli=mysqli_connect('localhost','root','','epitech');
                    if(!$mysqli) {
                        echo "Erreur connexion BDD";
                    } else {
                        $Pseudo=htmlentities($_POST['pseudo'],ENT_QUOTES,"UTF-8");
                        $Mdp=md5($_POST['mdp']);
                        $req=mysqli_query($mysqli,"SELECT * FROM membres WHERE pseudo='$Pseudo' AND mdp='$Mdp'");
                        if(mysqli_num_rows($req)!=1){
                            echo "Pseudo ou mot de passe incorrect.";
                        } else {
                            $_SESSION['pseudo']=$Pseudo;
                            echo "Vous êtes connecté avec succès $Pseudo! Vous pouvez accéder à l'espace membre en <a href='profil.php'>cliquant ici</a>.";
                            $TraitementFini=true;
                        }
                    }
                }
            }
            if(!isset($TraitementFini)){
                ?>
                <form method="post" action="connexion.php">
                    <p>Pseudo</p>
                    <input type="text" name="pseudo" placeholder="Votre pseudo..." required>
                    <p>Mot de passe</p>
                    <input type="password" name="mdp" placeholder="Votre mot de passe..." required><br><br>
                    <input type="submit" name="valider" value="Connexion!">
                </form>
                <?php
            }
        }
        ?>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>