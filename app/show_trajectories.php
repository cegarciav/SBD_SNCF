<?php

  if (
      isset($_POST["nom_dep"]) &&
      isset($_POST["nom_arr"]) &&
      isset($_POST["date_dep"]) &&
      isset($_POST["date_arr"]) &&
      isset($_POST["heure"])
    )
  {
    $start_name = $_POST["nom_dep"];
    $stop_name = $_POST["nom_arr"];
    $start_date = $_POST["date_dep"];
    $stop_date = $_POST["date_arr"];
    $minimum_time = $_POST["heure"];

    

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
