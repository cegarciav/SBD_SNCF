<?php
  include_once("../conexion.php");

  $req = "SELECT DISTINCT ville FROM gare;";
  $sql = mysqli_query($conexion, $req);
  if ($sql)
    $rows = mysqli_fetch_all($sql);
  else
    die('Erreur inattendue');

  $row = [];
  foreach($rows as $index => $valor)
  {
    array_push($row, $valor[0]." (Toutes les gares)");
  }
  try
  {
    mysqli_free_result($sql);
  }
  catch (Exception $excep){}

  $req = "SELECT nom FROM gare;";
  $sql = mysqli_query($conexion, $req);
  if ($sql)
    $rows = mysqli_fetch_all($sql);
  else
    die('Erreur inattendue');

  foreach($rows as $index => $valor)
  {
    array_push($row, $valor[0]);
  }
  try
  {
    mysqli_free_result($sql);
  }
  catch (Exception $excep){}
?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript" src="javascript/trip_search.js"></script>
</head>

<body>
  <div class = "choix">
    <div class = "text">
      <h2>Choisissez votre voyage</h2>
      <!--Make sure the form has the autocomplete function switched off:-->
      <form autocomplete="off" action="show_trajectories.php" onsubmit="return valider_dates()" method="post">
        <p>
          <div class="autocomplete" style="width:300px;">Gare de depart : 
            <input id="nom_dep" type="text" name="nom_dep" placeholder="Gare de départ" required> 
          </div>
        </p>
        <p>
          <div class="autocomplete" style="width:300px;">Gare d'arrivée : 
            <input id="nom_arr" type="text" name="nom_arr" placeholder="Gare d'arrivée" required>
          </div>
        </p>
        <p>
          Heure :
          <input  type="time" id="heure" name="heure">
        </p>
        <p>
          <input type="checkbox" name = "allers" id="allers" onchange="retour_on()">
            Aller simple
        </p>
        <p style="width:150px;">
          Date d'aller : 
          <input type="date" id="date_dep" name="date_dep" required min=<?php echo date('Y-m-d');?>>
        </p>
        <p style="width:150px;">Date de retour : 
          <input type="date" id="date_arr" name="date_arr" required min =<?php echo date('Y-m-d');?>>
        </p>
        <button type="submit">Accepter</button>
      </form>
    </div>
  </div>

  <script type="text/javascript">
    var paradas = '<?php echo json_encode($row); ?>';
    var parada = JSON.parse(paradas);
    autocomplete(document.getElementById("nom_dep"), parada);
    autocomplete(document.getElementById("nom_arr"), parada);
  </script>

</body>
</html>
