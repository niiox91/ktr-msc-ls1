<?php
session_start();
if(!isset($_SESSION['pseudo'])){
    header("Refresh: 5; url=connexion.php");
    echo "Vous n'êtes pas connecté.";
    exit(0);
}
else{
    unset($_SESSION['pseudo']);
    header("Refresh: 5; url=./");
    echo "Vous avez été correctement déconnecté du site.<br><br><i>Redirection en cours, vers la page d'accueil...</i>";
}
?>