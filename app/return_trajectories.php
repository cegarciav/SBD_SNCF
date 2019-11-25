<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>
        Choisissez l'aller
    </title>

    <link rel="stylesheet" href="css/trajectories.css" />
    <script type="text/javascript" src="javascript/trip_details.js"></script>

    <script type="text/javascript">
      var one_way = {};
      var return_way = {};
    </script>

  </head>
  
  <body>
<?php

  if (isset($_POST['one_way']) &&
      isset($_POST['return_date'])
    )
  {
    require_once "../conexion.php";
    $one_way = $_POST['one_way'];
    $one_way_decoded = (array) json_decode($one_way);
    $return_date = $_POST['return_date'];
    $return_date = mysqli_real_escape_string($conexion, $return_date);
    $start_name = $_POST['start_name'];
    $start_name = mysqli_real_escape_string($conexion, $start_name);
    $stop_name = $_POST['stop_name'];
    $stop_name = mysqli_real_escape_string($conexion, $stop_name);

    if (mysqli_connect_error())
    {
      die("Erreur de connexion interne");
    }

    if (strtotime($return_date) == strtotime($one_way_decoded['date_arr']))
    {
      $minimum_time = $one_way_decoded['heure_arr'];
    }
    elseif (strtotime($return_date) > strtotime($one_way_decoded['date_arr']))
    {
      $minimum_time = '00:00:00'; 
    }
    else
    {
      die("How dare you modify my website?");
    }

    require_once 'rides_generator.php';
    $valid_trips = get_trips($stop_name, $start_name,
                              $conexion, $return_date, $minimum_time);

    if ($valid_trips)
    {
      $json_trips = json_encode($valid_trips);
      echo $one_way;
      echo "<script type='text/javascript'>"
              ."var one_way = {$one_way};"
              ."var return_way = {$json_trips};"
              ."alert(JSON.stringify(return_way));"
            ."</script>";
      echo generate_rides($valid_trips, 'donnees_client.php');
    }
  }
  else
  {
    die("How dare you modify my website?");
  }
?>
  </body>
</html>
