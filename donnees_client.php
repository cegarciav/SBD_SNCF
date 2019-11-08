<?php
include_once("conexion.php");
?>


<!DOCTYPE html>
<html>
<head>
<h1 align="center">Données du client</h1>
</head>
<body>
	<form action="payement.php" method="post">   <!-- show_trajectories.php -->
  	<div align="center"> 
<p>Prénom : <input type="text" id = "prenom" name="prenom" required></p>
<p>Nom : <input type="text" name="nom" required></p>
<p>Âge : <input type="number" name="age"required></p>
<p>email : <input type="text" name="email" required></p>
<p><button>Accepter</button></p>
</body>
</html>