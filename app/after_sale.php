<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>
        Confirmer achat
    </title>

    <link rel="stylesheet" href="css/ticket.css"/>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script src='javascript/payement.js'></script>

  </head>
  
  <body>
    <?php
      if (isset($_POST['card_name']) &&
          isset($_POST['card_lastname']) &&
          isset($_POST['card_number']) &&
          isset($_POST['card_expiration']) &&
          isset($_POST['card_cvv'])
        )
      {
        $payement_name = $_POST['card_name'];
        preg_match("/^[A-Za-z]+[\- ]?[A-Za-z]+$/",
                    $payement_name, $name_match);
        if (count($name_match) != 1 ||
            $name_match[0] != $payement_name
          )
          die('How dare you modify my website?');

        $payement_lastname = $_POST['card_lastname'];
        preg_match("/^[A-Za-z]+[\- \']?[A-Za-z]+$/",
                    $payement_lastname, $lastname_match);
        if (count($lastname_match) != 1 ||
            $lastname_match[0] != $payement_lastname
          )
          die('How dare you modify my website?');

        $payement_number = $_POST['card_number'];
        preg_match("/^\d{16}$/", $payement_number, $number_match);
        if (count($number_match) != 1 ||
            $number_match[0] != $payement_number
          )
          die('How dare you modify my website?');

        $payement_expiration = $_POST['card_expiration'];
        preg_match("~^(\d{2})/(\d{2})$~",
                    $payement_expiration, $expiration_match);
        if (count($expiration_match) != 3 ||
            $expiration_match[0] != $payement_expiration ||
            ($expiration_match[1] < 1 || $expiration_match[1] > 12) ||
            (time() >= strtotime(
                        "20{$expiration_match[2]}-{$expiration_match[1]}"))
          )
          die('How dare you buy with an invalid card?');

        $payement_cvv = $_POST['card_cvv'];
        preg_match("/^\d{3}$/", $payement_cvv, $cvv_match);
        if (count($cvv_match) != 1 ||
            $cvv_match[0] != $payement_cvv
          )
          die('How dare you modify my website?');

        session_start();
        if (isset($_SESSION['name']) &&
            isset($_SESSION['last_name']) &&
            isset($_SESSION['age']) &&
            isset($_SESSION['email']) &&
            isset($_SESSION['reduction']) &&
            isset($_SESSION['one_way'])
          )
        {
          require_once "../conexion.php";
          require_once "sale_validator.php";

          $client_name = $_SESSION['name'];
          $client_lastname = $_SESSION['last_name'];
          $client_age = $_SESSION['age'];
          $client_email = $_SESSION['email'];

          $valid_client = new_client_validator($client_name, $client_lastname,
                                                $client_age, $client_email);

          if (!$valid_client)
            die('How dare you modify my website?');

          $client_name = ucwords(strtolower($client_name), " -");
          $client_name = mysqli_real_escape_string($conexion, $client_name);
          $client_lastname = ucwords(strtolower($client_lastname), " -");
          $client_lastname = mysqli_real_escape_string($conexion,
                                                          $client_lastname);
          $client_age = mysqli_real_escape_string($conexion, $client_age);
          $client_email = strtolower($client_email);
          $client_email = mysqli_real_escape_string($conexion, $client_email);

          $client_reduction = $_SESSION['reduction'];
          preg_match("/^\d{1,3}$/", $client_reduction, $reduction_match);
          if (count($reduction_match) != 1 ||
              $reduction_match[0] != $client_reduction ||
              ($reduction_match[0] > 100 || $reduction_match[0] < 0)
            )
          {
            die('How dare you modify my website?');
          }
          else
          {
            $client_reduction = mysqli_real_escape_string($conexion,
                                                        $client_reduction);
          }

          $valid_one_way = trip_validator($_SESSION['one_way']['stations'],
                                          $_SESSION['one_way']['date_dep'],
                                          $_SESSION['one_way']['heure_dep'],
                                          $_SESSION['one_way']['date_arr'],
                                          $_SESSION['one_way']['heure_arr'],
                                          $_SESSION['one_way']['trains'],
                                          $_SESSION['one_way']['times'],
                                          $_SESSION['one_way']['prix'],
                                          $conexion
                                        );

          if (!$valid_one_way)
          {
            die('Malheureusement, le billet que vous vouliez'
                  .' acheter n\'est plus disponible 1');
          }

          if (isset($_SESSION['return_way']))
          {
            $valid_return = trip_validator($_SESSION['return_way']['stations'],
                                            $_SESSION['return_way']['date_dep'],
                                            $_SESSION['return_way']['heure_dep'],
                                            $_SESSION['return_way']['date_arr'],
                                            $_SESSION['return_way']['heure_arr'],
                                            $_SESSION['return_way']['trains'],
                                            $_SESSION['return_way']['times'],
                                            $_SESSION['return_way']['prix'],
                                            $conexion
                                          );
            if (!$valid_return)
            {
              die('Malheureusement, le billet que vous vouliez'
                    .' acheter n\'est plus disponible 2');
            }
          }

          $client_exists = client_validator($conexion, $client_email,
                                            $client_name, $client_lastname,
                                            $client_age);
          if ($client_exists)
          {
            if ($client_exists === -1)
            {
              die('Données incorrectes ou mail utilisé par un autre '
                  .' client déjà enregistré. Vérifiez les informations '
                  .'saisies s\'il vous plaît ou contactez nous si '
                  .'le problème persiste');
            }
          }
          else
          {
            $new_client_query = "INSERT INTO client (email, nom, prenom, age) "
                                ."VALUES ('{$client_email}', '{$client_lastname}', "
                                ."'{$client_name}', {$client_age});";
            $insert_client = mysqli_query($conexion, $new_client_query);
            if (!$insert_client)
              die("Problème de conexion interne. Essayez plus tard s'il vous plaît");
          }

          $one_way_insert = insert_tickets_query($_SESSION['one_way'],
                                                  $client_email, $conexion);
          $ids_added = array();
          $insert_tickets = mysqli_query($conexion, $one_way_insert);
          if (!$insert_tickets)
            die("Problème de conexion interne. Essayez plus tard s'il vous plaît");
          else
          {
            $new_id = mysqli_insert_id($conexion);
            if ($new_id != 0)
            {
              $tickets_amount = count(array_unique($_SESSION['one_way']['trains']));
              $ids_added[] = [$new_id, $tickets_amount];
            }
          }

          if (isset($_SESSION['return_way']))
          {
            $one_way_insert = insert_tickets_query($_SESSION['return_way'],
                                                    $client_email, $conexion);
            $insert_tickets = mysqli_query($conexion, $one_way_insert);
            if (!$insert_tickets)
              die("Problème de conexion interne. Essayez plus tard s'il vous plaît");
            else
            {
              $new_id = mysqli_insert_id($conexion);
              if ($new_id != 0)
              {
                $tickets_amount = count(array_unique($_SESSION['return_way']['trains']));
                $ids_added[] = [$new_id, $tickets_amount];
              }
            }
          }

          $get_tickets_query = "SELECT * FROM billet WHERE ";
          if (count($ids_added) == 0)
          {
            die('Erreur inattendue');
          }
          elseif (count($ids_added) == 1)
          {
            $max_limit = $ids_added[0][0] + $ids_added[0][1];
            $get_tickets_query = $get_tickets_query
                            ."numero >= {$ids_added[0][0]} "
                                ."AND numero < $max_limit;";
          }
          elseif (count($ids_added) == 2)
          {
            $max_limit = $ids_added[0][0] + $ids_added[0][1];
            $get_tickets_query = $get_tickets_query
                            ."(numero >= {$ids_added[0][0]} "
                                ."AND numero < $max_limit) ";
            $max_limit = $ids_added[1][0] + $ids_added[1][1];
            $get_tickets_query = $get_tickets_query
                            ."OR (numero >= {$ids_added[1][0]} "
                                ."AND numero < $max_limit);";
          }

          $html_doc = '<H2>Merci pour acheter chez nous !</H2>'
                      .'<H4>Voici les informations de vos tickets</H4>';
          $get_tickets = mysqli_query($conexion, $get_tickets_query);
          if ($get_tickets)
          {
            $final_results = mysqli_fetch_assoc($get_tickets);
            while ($final_results)
            {
              $html_doc = $html_doc
                          .ticket_generator($final_results, $client_email,
                                            $client_name, $client_lastname);
              $final_results = mysqli_fetch_assoc($get_tickets);
            }
          }

          echo $html_doc;
        }
      }
    ?>
  </body>
</html>