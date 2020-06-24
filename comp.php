<?php
session_start();
$mysqli=mysqli_connect('localhost','root','','epitech');
if(!$mysqli) {
    echo "Erreur connexion BDD";
    exit(0);
}
?>
<!DOCTYPE HTML>
<html>
    <head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="main.css">
		<meta name="description" content="">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<title>Compagnies</title>
    </head>
    <body>
	<?php include('navbar.php');
	$bdd = new PDO('mysql:host=localhost;dbname=epitech;charset=utf8', 'root', '');
	$reponse = $bdd->query('SELECT * FROM membres');
	while ($donnees = $reponse->fetch())
	{
	?>
		<p>
		<strong>Companie</strong> : <?php echo $donnees['company']; ?><br />
		<strong>Directeur</strong> : <?php echo $donnees['nameusr']; ?><br />
		<strong>mail</strong> : <?php echo $donnees['mail']; ?><br />
		<strong>tel</strong> : <?php echo $donnees['phone']; ?><br />
	</p>
	<?php
	}

	$reponse->closeCursor();

	?>
    </body>
</html>