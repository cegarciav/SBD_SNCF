<?php
include_once("conexion.php");
?>


<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style.css" type="text/css">
<head>
<h1 align="center">Données du client</h1>
</head>
<body>
	<form action="payement.php" method="post">   <!-- show_trajectories.php -->
  	<div align="center"> 
<p><label>Prénom :</label> <input style="width:250px;" type="text" id = "prenom" name="prenom" required></p>
<p><label>Nom : </label><input style="width:250px;" type="text" name="nom" required></p>
<p><label>Âge : </label><input style="width:250px;" type="number" name="age"required></p>
<p><label>email : </label><input style="width:250px;" type="text" name="email" required></p>
<p><button>Accepter</button></p>
</body>
</html>