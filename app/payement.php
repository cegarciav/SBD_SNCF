<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>
        Confirmer achat
    </title>

    <link rel="stylesheet" href="css/trajectories.css"/>
    <link rel="stylesheet" href="css/payement.css"/>
    <script type="text/javascript" src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script type="text/javascript" src='javascript/payement.js'></script>

  </head>
  
  <body>

    <?php

      include_once("../conexion.php");
      require_once "sale_validator.php";

      if(isset($_POST['prenom']) &&
          isset($_POST['nom']) &&
          isset($_POST['email']) &&
          isset($_POST['age'])
        )
      {
        session_start();

        $name = $_POST['prenom'];
        $last_name = $_POST['nom'];
        $email = $_POST['email'];
        $age = $_POST['age'];

        $new_client_filter = new_client_validator($name, $last_name, $age, $email);
        if (!$new_client_filter)
          die('How dare you modify my website?');

        $name = ucwords(strtolower($name), " -");
        $name = mysqli_real_escape_string($conexion, $name);
        $lastname = ucwords(strtolower($last_name), " -");
        $last_name = mysqli_real_escape_string($conexion, $last_name);
        $email = strtolower($email);
        $email = mysqli_real_escape_string($conexion, $email);
        $age = mysqli_real_escape_string($conexion, $age); 

        $client_exists = client_validator($conexion, $email, $name,
                                          $last_name, $age);

        if ($client_exists)
        {
          if ($client_exists === -1)
          {
            die('Données incorrectes ou mail utilisé par un autre '
                .' client déjà enregistré. Vérifiez les informations '
                .'saisies s\'il vous plaît');
          }

          if (isset($_POST['reduction']))
          {
            $reduction = $_POST['reduction'];
            $reduction = mysqli_real_escape_string($conexion, $reduction);
            $reduction_exists = reduction_validator($conexion,
                                                    $reduction, $email);
            if ($reduction_exists === -1)
            {
              die('Vous êtes enregistré dans notre agence '
                    .'avec un autre type de reduction. Si c\'est une '
                    .'erreur de notre côté, contactez-nous s\'il vous plaît');
            }
          }
          else
            $reduction_exists = 0;

          $_SESSION['name'] = $name;
          $_SESSION['last_name'] = $last_name;
          $_SESSION['age'] = $age;
          $_SESSION['email'] = $email;
          $_SESSION['reduction'] = $reduction_exists;
        }

        else
        {
          $_SESSION['name'] = $name;
          $_SESSION['last_name'] = $last_name;
          $_SESSION['age'] = $age;
          $_SESSION['email'] = $email;
          if (isset($_POST['reduction']) && $_POST['reduction'] != '')
          {
            $html_alert = "<script type='text/javascript'>"
                            ."alert(\"Vous n'avez pas cette réduction "
                                    ."selon nos registres. Pour obtenir "
                                    ."une réduction, venez chez nous !\");"
                          ."</script>";
            echo $html_alert;
          }

          $_SESSION['reduction'] = 0;
        }

        if (isset($_SESSION['name']) &&
            isset($_SESSION['last_name']) &&
            isset($_SESSION['age']) &&
            isset($_SESSION['email']) &&
            isset($_SESSION['reduction'])
          )
        {
          require_once "rides_generator.php";
          if (isset($_SESSION['one_way']))
          {
            $total_price = $_SESSION['one_way']['prix'];

            $html_selling = "<div class='payement_body'>"
                              ."<div class='ticket_data'>"
                                ."<div class='selling_header'>"
                                  ."<div class='header_content'>"
                                    .$_SESSION['one_way']['stations'][0]
                                    ."<i class='fas fa-arrow-circle-right'></i>"
                                    .$_SESSION['one_way']
                                            ['stations']
                                              [count($_SESSION['one_way']
                                                            ['stations']) - 1]
                                  ."</div>"
                                  ."<div class='header_content'>"
                                    ."<i class='far fa-calendar-alt'></i>"
                                    .$_SESSION['one_way']['date_dep']
                                  ."</div>"
                                ."</div>";

            $html_selling = $html_selling
                              .show_ride($_SESSION['one_way']['heure_dep'],
                                        $_SESSION['one_way']['heure_arr'],
                                        $_SESSION['one_way']['duration'],
                                        $_SESSION['one_way']['prix'],
                                        $_SESSION['one_way']['trains'],
                                        $_SESSION['one_way']['times'],
                                        $_SESSION['one_way']['stations']
                                      );
            if (isset($_SESSION['return_way']))
            {
              $total_price = $total_price + $_SESSION['return_way']['prix'];

              $html_selling = $html_selling
                                ."<div class='selling_header'>"
                                  ."<div class='header_content'>"
                                  .$_SESSION['return_way']['stations'][0]
                                  ."<i class='fas fa-arrow-circle-right'></i>"
                                  .$_SESSION['return_way']
                                          ['stations']
                                            [count($_SESSION['return_way']
                                                          ['stations']) - 1]
                                  ."</div>"
                                  ."<div class='header_content'>"
                                    ."<i class='far fa-calendar-alt'></i>"
                                    .$_SESSION['return_way']['date_dep']
                                  ."</div>"
                                ."</div>";

              $html_selling = $html_selling
                                .show_ride($_SESSION['return_way']['heure_dep'],
                                            $_SESSION['return_way']['heure_arr'],
                                            $_SESSION['return_way']['duration'],
                                            $_SESSION['return_way']['prix'],
                                            $_SESSION['return_way']['trains'],
                                            $_SESSION['return_way']['times'],
                                            $_SESSION['return_way']['stations']
                                          );
            }

            $total_price = $total_price * (1 - $_SESSION['reduction'] / 100); 

            $html_selling = $html_selling
                              ."</div>" // closing ticket_data
                              ."<div class='payement_data'>"
                                ."<div class='payement_header'>"
                                  ."Vos données client"
                                ."</div>"
                                ."<div class='client_data'>"
                                  ."<H3>Votre nom</H3>"
                                  ."<p>{$_SESSION['name']} "
                                      .strtoupper($_SESSION['last_name'])."</p>"
                                  ."<H3>Votre âge</H3>"
                                  ."<p>{$_SESSION['age']}</p>"
                                  ."<H3>Votre email</H3>"
                                  ."<p>{$_SESSION['email']} "
                                ."</div>"
                                ."<div class='payement_header'>"
                                  ."Détails du paiement"
                                ."</div>"
                                ."<form action='after_sale.php' method='post' "
                                    ."onsubmit='return validate_payment()'>"
                                  ."<div class='card_data'>"
                                    ."<H3>Total à payer après reduction</H3>"
                                    ."<p class='total_price'>€{$total_price}</p>"
                                    ."<div class='client_name'>"
                                      ."<div class='client_name_block'>"
                                        ."Prénom"
                                        ."<input type='text' name='card_name'"
                                            ." value='{$_SESSION['name']}' required>"
                                      ."</div>"
                                      ."<div class='client_name_block'>"
                                        ."Nom"
                                        ."<input type='text' name='card_lastname'"
                                            ." value='{$_SESSION['last_name']}' required>"
                                      ."</div>"
                                    ."</div>"
                                    ."<div class='client_card'>"
                                      ."<div class='client_card_number'>"
                                        ."Numéro de carte"
                                        ."<input type='text' name='card_number' required>"
                                      ."</div>"
                                      ."<div class='client_card_expiration'>"
                                        ."Date d'expiration"
                                        ."<input type='text' name='card_expiration' "
                                            ."placeholder='MM/AA' required>"
                                      ."</div>"
                                      ."<div class='client_card_cvv'>"
                                        ."CVV"
                                        ."<input type='text' name='card_cvv' required>"
                                      ."</div>"
                                    ."</div>"
                                  ."</div>"
                                  ."<input class='pay_button' type='submit'"
                                        ." value='Payer maintenant €{$total_price}'>"
                                ."</form>"
                              ."</div>"
                            ."</div>"; // closing payment_body
            echo $html_selling;
          }
          else
          {
            die('How dare you modify my website?');
          }
        }
      }
    ?>
  </body>
</html>
