<?php
session_start();
?>

<?php

include_once("conexion.php");


	$username = $_POST["user"];
	$password = $_POST["password"];

	$sql = "SELECT * FROM admin WHERE user = ".$username;
	$reponse = mysqli_query($conexion, $sql);

	$rows = $sql->fetch_all();
	print_r($rows);




?>