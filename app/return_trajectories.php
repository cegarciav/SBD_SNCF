<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>
      Choisissez le retour
    </title>

    <link rel="stylesheet" href="css/trajectories.css" />
    <script type="text/javascript" src="javascript/trip_details.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    <script type="text/javascript">
      var one_way = {};
    </script>

  </head>
  
  <body>
<?php

  if (isset($_POST['one_way']) &&
      isset($_POST['return_date']) &&
      session_start()
    )
  {
    if (isset($_SESSION['return_way']))
    {
      unset($_SESSION['return_way']);
    }
    require_once "../conexion.php";
    require_once "ride_validator.php";
    $one_way = $_POST['one_way'];
    if (ride_validator($one_way))
    {
      $one_way_decoded = (array) json_decode($one_way);
      $_SESSION['one_way'] = $one_way_decoded;
    }
    else
      die('How dare you modify my website?');

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

    if (isset($one_way_decoded['date_arr']) &&
        strtotime($return_date) == strtotime($one_way_decoded['date_arr'])
      )
    {
      $minimum_time = $one_way_decoded['heure_arr'];
      $minimum_time = mysqli_real_escape_string($conexion, $minimum_time);
    }
    elseif (isset($one_way_decoded['date_arr']) &&
            strtotime($return_date) > strtotime($one_way_decoded['date_arr'])
          )
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
      $header = "<div class='selling_header'>"
                  ."<div class='header_content'>"
                    .$_SESSION['real_end']
                    ."<i class='fas fa-arrow-circle-right'></i>"
                    .$_SESSION['real_start']
                  ."</div>"
                  ."<div class='header_content'>"
                    ."<i class='far fa-calendar-alt'></i>"
                    .$return_date
                  ."</div>"
                  ."<div class='header_content'>"
                    ."<i class='far fa-clock'></i>"
                    .$minimum_time
                  ."</div>"
                ."</div>";

      echo $header;
      $json_trips = json_encode($valid_trips);
      echo "<script type='text/javascript'>"
              ."var one_way = {$json_trips};"
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
