<?php
  include_once("../conexion.php");
  require_once "ride_validator.php";
  if (isset($_POST['one_way']) &&
      session_start()
      ):
    $one_way = $_POST['one_way'];
    if (ride_validator($one_way))
    {
      $one_way_decoded = (array) json_decode($one_way);
      if (isset($_SESSION['one_way']))
      {
        $_SESSION['return_way'] = $one_way_decoded;
      }
      else
      {
        $_SESSION['one_way'] = $one_way_decoded;
      }
    }
    else
      die('How dare you modify my website?');

    if (mysqli_connect_error())
    {
      die("Erreur de connexion interne");
    }

    $reductions = "SELECT type FROM reduction;";
    $reductions_request = mysqli_query($conexion, $reductions);
    if ($reductions_request):
      $reductions_result = mysqli_fetch_assoc($reductions_request);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>
      Insérez vos données
  </title>
  <script type="text/javascript" src='javascript/client.js'></script>
</head>
<body>
  <h1 align="center">Données du client</h1>
	<form action="payement.php" method="post" onsubmit="return valid_client()">
  	<div align="center"> 
      <p>
        Prénom : 
        <input type="text" id="prenom" name="prenom" required>
      </p>
      <p>
        Nom : 
        <input type="text" id="nom" name="nom" required>
      </p>
      <p>
        Âge : 
        <input type="number" id ="age" name="age" required>
      </p>
      <p>
        Email : 
        <input type="text" id="email" name="email" required>
      </p>
      <p>
        Réduction : 
        <select name="reduction" id="reduction">
          <option value=""></option>
          <?php
            while ($reductions_result)
            {
              $type = $reductions_result['type'];
              $cap_type = ucfirst($type);
              echo "<option value='".$type."'>".$cap_type."</option>";
              $reductions_result = mysqli_fetch_assoc($reductions_request);
            }
            try
            {
              mysqli_free_result($reductions_request);
            }
            catch (Exception $excep) {}
          ?>
        </select>
      </p>
      <p>
        <button>Accepter</button>
      </p>
    </div>
  </form>
</body>
</html>

<?php
    endif;
  else:
    die('How dare you modify my website');
  endif;
?>
