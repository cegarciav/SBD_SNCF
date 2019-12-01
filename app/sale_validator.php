<?php

  function trip_validator($stations, $date_dep, $heure_dep,
                          $date_arr, $heure_arr, $trains,
                          $times, $prix, $conexion)
  {
    $start_name = mysqli_real_escape_string($conexion, $stations[0]);
    $start_date = mysqli_real_escape_string($conexion, $date_dep);
    $start_time = mysqli_real_escape_string($conexion, $heure_dep);

    $last_station = count($stations) - 1;
    $last_station = $stations[$last_station];
    $stop_name = mysqli_real_escape_string($conexion, $last_station);

    $one_way_query = "CALL Station2Station('{$start_name}', '{$start_date}', "
                      ."'{$start_time}', '{$stop_name}');";
    $one_way_request = mysqli_query($conexion, $one_way_query);
    if ($one_way_request)
      $one_way_results = mysqli_fetch_assoc($one_way_request);
    else
      die('Erreur inattendue');

    $one_way_trains = '';
    foreach ($trains as $train)
    {
      $one_way_trains = $one_way_trains.$train.'.';
    }

    $one_way_stations = '';
    foreach ($stations as $station)
    {
      $one_way_stations = $one_way_stations.$station.'.';
    }

    $one_way_times = '';
    foreach ($times as $time)
    {
      $one_way_times = $one_way_times.$time[0].'_'.$time[1].'.';
    }

    $valid_trip = false;
    while ($one_way_results)
    {
      $valid_trip = ($one_way_results['heure_dep'] == $start_time) &&
                    ($one_way_results['date_arr'] == $date_arr) &&
                    ($one_way_results['heure_arr'] == $heure_arr) &&
                    ($one_way_results['prix'] == $prix) &&
                    ($one_way_results['trains_string'] == $one_way_trains) &&
                    ($one_way_results['path_string'] == $one_way_stations) &&
                    ($one_way_results['time_string'] == $one_way_times);
      if ($valid_trip)
      {
        try
        {
          mysqli_free_result($one_way_request);
          mysqli_next_result($conexion);
        }
        catch (Exception $excep){}
        break;
      }
      $one_way_results = mysqli_fetch_assoc($one_way_request);
    }

    return $valid_trip; 
  }

  function client_validator($conexion, $email, $name,
                            $last_name, $age)
  {
    $check_client = "SELECT * FROM client "
                    ."WHERE email='{$email}';";

    $client_exists = mysqli_query($conexion, $check_client);
    if ($client_exists)
      $exists_result = mysqli_fetch_assoc($client_exists);
    else
      die('Erreur inattendue');
    try
    {
      mysqli_free_result($client_exists);
    }
    catch (Exception $excep){}

    if ($exists_result)
    {
      if ($exists_result['nom'] == $last_name &&
          $exists_result['prenom'] == $name &&
          $exists_result['age'] == $age
        )
        return true;
      else
        return -1;
    }

    return false;
  }

  function reduction_validator($conexion, $reduction, $email)
  {
    $check_reduction = "SELECT P.email, R.type, R.pourcentage "
                          ."FROM possede AS P, reduction AS R "
                          ."WHERE P.email='{$email}' "
                          ."AND R.type = P.type;";
    $reduction_exists = mysqli_query($conexion, $check_reduction);
    if ($reduction_exists)
      $reduction_result = mysqli_fetch_assoc($reduction_exists);
    else
      die('Erreur inattendue');
    try
    {
      mysqli_free_result($reduction_exists);
    }
    catch (Exception $excep){}

    if ($reduction_result)
    {
      if ($reduction_result['type'] == $reduction)
        return $reduction_result['pourcentage'];
      else
        return -1;
    }

    return 0;
  }

  function new_reduction_validator($conexion, $type)
  {
    $check_reduction = "SELECT pourcentage "
                        ."FROM reduction "
                        ."WHERE type = '{$type}'";
    $reduction_exists = mysqli_query($conexion, $check_reduction);
    if ($reduction_exists)
      $reduction_result = mysqli_fetch_assoc($reduction_exists);
    else
      die('Erreur inattendue');

    try
    {
      mysqli_free_result($reduction_exists);
    }
    catch (Exception $excep){}

    if ($reduction_result)
    {
      return $reduction_result['pourcentage'];
    }
    
    return -1;
  }

  function new_client_validator($name, $last_name, $age, $email)
  {
    preg_match("/^[A-Za-z]+[\- ]?[A-Za-z]+$/",
                $name, $name_match);
    if (count($name_match) != 1 ||
        $name_match[0] != $name
      )
      return false;

    preg_match("/^[A-Za-z]+[\- \']?[A-Za-z]+$/",
                $last_name, $lastname_match);
    if (count($lastname_match) != 1 ||
        $lastname_match[0] != $last_name
      )
      return false;

    preg_match("/^\d{1,3}$/", $age, $age_match);
    if (count($age_match) != 1 ||
        $age_match[0] != $age ||
        ($age_match[0] > 150 || $age_match[0] < 0)
      )
      return false;

    preg_match("~^[A-Za-z\d][A-Za-z\.\_\d\-]+[A-Za-z\d]@"
              ."[A-Za-z\d][A-Za-z\.\_\d\-]+[A-Za-z\d]\.[A-Za-z]+$~",
                $email, $email_match);
    if (count($email_match) != 1 ||
        $email_match[0] != $email
      )
      return false;

    return true;
  }

  function insert_tickets_query($trip_data, $client_email, $conexion)
  {
    $new_ticket_query = "INSERT INTO billet (prix, email, nb_train, "
                              ."nom_arr, date_arr, heure_arr, nom_dep, "
                              ."date_dep, heure_dep) "
                        ."VALUES";
    $start_time = $trip_data['date_dep'].' '
                  .$trip_data['heure_dep'];
    $time_difference = strtotime($start_time) -
                          $trip_data['times'][0][0];

    $current_train = $trip_data['trains'][0];
    $last_change = 0;
    foreach ($trip_data['trains'] as $index => $train)
    {
      if ($train != $current_train)
      {
        $curr_timestamp_st = $trip_data['times'][$last_change][0]
                                + $time_difference;
        $curr_start_date = date('Y-m-d', $curr_timestamp_st);
        $curr_start_time = date('H:i:s', $curr_timestamp_st);
        $curr_start_name = $trip_data['stations'][$last_change];

        $curr_timestamp_end = $trip_data['times'][$index - 1][1]
                                  + $time_difference;
        $curr_end_date = date('Y-m-d', $curr_timestamp_end);
        $curr_end_time = date('H:i:s', $curr_timestamp_end);
        $curr_end_name = $trip_data['stations'][$index];

        $price_query = "CALL Station2Station('{$curr_start_name}', "
                        ."'{$curr_start_date}', '{$curr_start_time}', "
                        ."'{$curr_end_name}')";
        $request = mysqli_query($conexion, $price_query);
        if ($request)
          $final_results = mysqli_fetch_assoc($request);
        else
          die('Erreur inattendue');
        $curr_price = -1;
        while ($final_results)
        {
          $valid_trip = ($final_results['heure_dep'] == $curr_start_time) &&
                        ($final_results['date_arr'] == $curr_end_date) &&
                        ($final_results['heure_arr'] == $curr_end_time);
          if ($valid_trip)
          {
            $curr_price = $final_results['prix'];
            try
            {
              mysqli_free_result($request);
              mysqli_next_result($conexion);
            }
            catch (Exception $excep)
            {}
            break;
          }
          $final_results = mysqli_fetch_assoc($one_way_request);
        }

        if ($curr_price > 0)
        {
          $new_ticket_query = $new_ticket_query.
                              " ({$curr_price}, '{$client_email}', "
                              ."{$current_train}, '{$curr_end_name}', "
                              ."'{$curr_end_date}', '{$curr_end_time}', "
                              ."'{$curr_start_name}', '{$curr_start_date}', "
                              ."'{$curr_start_time}'),";
        }
        else
          die('Erreur inattendue');

        $current_train = $train;
        $last_change = $index;
      }
    }

    $curr_timestamp_st = $trip_data['times'][$last_change][0]
                            + $time_difference;
    $curr_start_date = date('Y-m-d', $curr_timestamp_st);
    $curr_start_time = date('H:i:s', $curr_timestamp_st);
    $curr_start_name = $trip_data['stations'][$last_change];

    $curr_timestamp_end = $trip_data['times'][$index][1]
                              + $time_difference;
    $curr_end_date = date('Y-m-d', $curr_timestamp_end);
    $curr_end_time = date('H:i:s', $curr_timestamp_end);
    $curr_end_name = $trip_data['stations'][$index + 1];

    $price_query = "CALL Station2Station('{$curr_start_name}', "
                    ."'{$curr_start_date}', '{$curr_start_time}', "
                    ."'{$curr_end_name}')";
    $request = mysqli_query($conexion, $price_query);
    if ($request)
      $final_results = mysqli_fetch_assoc($request);
    else
      die('Erreur inattendue');
    $curr_price = -1;
    while ($final_results)
    {
      $valid_trip = ($final_results['heure_dep'] == $curr_start_time) &&
                    ($final_results['date_arr'] == $curr_end_date) &&
                    ($final_results['heure_arr'] == $curr_end_time);
      if ($valid_trip)
      {
        $curr_price = $final_results['prix'];
        try
        {
          mysqli_free_result($request);
          mysqli_next_result($conexion);
        }
        catch (Exception $excep){}
        break;
      }
      $final_results = mysqli_fetch_assoc($one_way_request);
    }

    if ($curr_price > 0)
    {
      $new_ticket_query = $new_ticket_query.
                          " ({$curr_price}, '{$client_email}', "
                          ."{$current_train}, '{$curr_end_name}', "
                          ."'{$curr_end_date}', '{$curr_end_time}', "
                          ."'{$curr_start_name}', '{$curr_start_date}', "
                          ."'{$curr_start_time}');";
    }
    else
      die('Erreur inattendue');

    return $new_ticket_query;
  }

  function ticket_generator($ticket, $user_mail,
                            $user_name, $user_lastname)
  {
    $whole_name = strtoupper($user_lastname);
    $whole_name = $user_name.' '.$whole_name;
    $html_body = "<div class='ticket_box'>"
                  ."<div class='row_info'>"
                    ."<div class='ticket_info'>"
                      ."<div class='ticket_data'>"
                        ."BilletID : ".$ticket['numero']
                      ."</div>"
                      ."<div class='ticket_data'>"
                        ."Train : ".$ticket['nb_train']
                      ."</div>"
                    ."</div>"
                    ."<div class='user_info'>"
                      ."<div class='user_data'>"
                        .$whole_name
                      ."</div>"
                      ."<div class='user_data'>"
                        .$user_mail
                      ."</div>"
                    ."</div>"
                  ."</div>"
                  ."<div class='row_info'>"
                    ."<div class='header_station'>"
                    ."</div>"
                    ."<div class='nom_station'>"
                      ."Gare"
                    ."</div>"
                    ."<div class='date_station'>"
                      ."Date"
                    ."</div>"
                    ."<div class='time_station'>"
                      ."Heure"
                    ."</div>"
                  ."</div>"
                  ."<div class='row_info'>"
                    ."<div class='header_station'>"
                      ."Départ : "
                    ."</div>"
                    ."<div class='nom_station'>"
                      .$ticket['nom_dep']
                    ."</div>"
                    ."<div class='date_station'>"
                      .$ticket['date_dep']
                    ."</div>"
                    ."<div class='time_station'>"
                      .$ticket['heure_dep']
                    ."</div>"
                  ."</div>"
                  ."<div class='row_info'>"
                    ."<div class='header_station'>"
                      ."Arrivée : "
                    ."</div>"
                    ."<div class='nom_station'>"
                      .$ticket['nom_arr']
                    ."</div>"
                    ."<div class='date_station'>"
                      .$ticket['date_arr']
                    ."</div>"
                    ."<div class='time_station'>"
                      .$ticket['heure_arr']
                    ."</div>"
                  ."</div>"
                  ."<div class='row_info'>"
                    ."<div class='price_info'>"
                      ."Coût : €".$ticket['prix']
                    ."</div>"
                  ."</div>"
                ."</div>";

    return $html_body;
  }

?>