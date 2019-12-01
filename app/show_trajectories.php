<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>
        Choisissez l'aller
    </title>

    <link rel="stylesheet" href="css/trajectories.css" />
    <script type="text/javascript" src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script type="text/javascript" src="javascript/trip_details.js"></script>

    <script type="text/javascript">
      var one_way = {};
    </script>

  </head>
  
  <body>
<?php

  if (
      isset($_POST["nom_dep"]) &&
      isset($_POST["nom_arr"]) &&
      isset($_POST["date_dep"]) &&
      isset($_POST["heure"]) &&
      session_start()
    )
  {
    if (isset($_SESSION['one_way']))
    {
      unset($_SESSION['one_way']);
    }

    if (isset($_SESSION['return_way']))
    {
      unset($_SESSION['return_way']);
    }

    require_once "../conexion.php";

    $start_name = $_POST["nom_dep"];
    $_SESSION['real_start'] = $_POST["nom_dep"];
    $start_name = preg_replace('~ \(.+\)~', '', $start_name);
    $start_name = mysqli_real_escape_string($conexion, $start_name);
    $stop_name = $_POST["nom_arr"];
    $_SESSION['real_end'] = $_POST["nom_arr"];
    $stop_name = preg_replace('~ \(.+\)~', '', $stop_name);
    $stop_name = mysqli_real_escape_string($conexion, $stop_name);
    $start_date = $_POST["date_dep"];
    $start_date = mysqli_real_escape_string($conexion, $start_date);
    $minimum_time = $_POST["heure"];
    $minimum_time = mysqli_real_escape_string($conexion, $minimum_time);
    if (strlen($minimum_time) == 0)
    {
      $minimum_time = '00:00';
    }
    $minimum_time = $minimum_time.':00';

    if (mysqli_connect_error())
    {
      die("Erreur de connexion interne");
    }

    require_once "rides_generator.php";

    $valid_trips = get_trips($start_name, $stop_name,
                              $conexion, $start_date, $minimum_time);

    if ($valid_trips):

      $header = "<div class='selling_header'>"
                  ."<div class='header_content'>"
                    .$_SESSION['real_start']
                    ."<i class='fas fa-arrow-circle-right'></i>"
                    .$_SESSION['real_end']
                  ."</div>"
                  ."<div class='header_content'>"
                    ."<i class='far fa-calendar-alt'></i>"
                    .$start_date
                  ."</div>"
                  ."<div class='header_content'>"
                    ."<i class='far fa-clock'></i>"
                    .$minimum_time
                  ."</div>"
                ."</div>";

      echo $header;
      $json_trips = json_encode($valid_trips);
      echo "<script type='text/javascript'>"
              ."var one_way = $json_trips;"
            ."</script>";


      if (!isset($_POST['allers']) &&
          isset($_POST['date_arr'])
        )
      {
        $stop_date = $_POST["date_arr"];
        $stop_date = mysqli_real_escape_string($conexion, $stop_date);
        echo generate_rides($valid_trips,
                              'return_trajectories.php', $stop_date,
                                $start_name, $stop_name);
      }
      else
      {
        echo generate_rides($valid_trips, 'donnees_client.php');
      }
    endif;

  }
  else
  {
    die("How dare you modify my website?");
  }
?>
  </body>
</html>
