<?php
include_once("conexion.php");
if(isset($_POST['prenom']) &&
	isset($_POST['nom']) &&
	isset($_POST['email']) &&
	isset($_POST['age']))
{
	$req = "INSERT INTO client (nom, prenom, age, email) VALUES ('".$_POST['nom']."', '".$_POST['prenom']."', ".$_POST['age'].", '".$_POST['email']."')";
	$sql = mysqli_query($conexion, $req);
	if(!$sql)
		die("Erreur lors de l'introduction des données du client");
}


?>