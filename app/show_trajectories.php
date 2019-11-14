<?php

  if (
      isset($_GET["nom_dep"]) &&
      isset($_GET["nom_arr"]) &&
      isset($_GET["date_dep"]) &&
      isset($_GET["date_arr"]) &&
      isset($_GET["heure"])
    )
  {
    $start_name = $_GET["nom_dep"];
    $stop_name = $_GET["nom_arr"];
    $start_date = $_GET["date_dep"];
    $stop_date = $_GET["date_arr"];
    $minimum_time = $_GET["heure"];

    require_once "../conexion.php";

    if (mysqli_connect_error())
    {
      die("Erreur de connexion interne");
    }

    $query = "SELECT A.nom, G.ville, A.date "
              ."FROM arret as A, gare as G "
              ."WHERE G.nom = A.nom;";

    $request = mysqli_query($conexion, $query);

    while ($result = mysqli_fetch_assoc($request))
    {
      print_r($result);
    }

  }
  else
  {
    die("How dare you modify my website?");
  }

?>
