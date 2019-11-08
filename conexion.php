<?php

$user = "root";
$password = "";
$server = "localhost";
$bdd = "cbtm";

$conexion = mysqli_connect( $server, $user, $password, $bdd ) or die ("No se ha podido conectar al servidor de Base de datos");

?>