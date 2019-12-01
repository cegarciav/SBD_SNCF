<?php

  function generate_rides($valid_trips, $action,
                          $arrive=NULL, $start_name=NULL,
                          $stop_name=NULL)
  {
    $html_doc = "";
    foreach ($valid_trips as $id_trip => $current_trip)
    {
      $days = intdiv($current_trip['duration'], (60 * 60 * 24));
      $hours = intdiv($current_trip['duration'], (60 * 60)) - $days * 24;
      $minutes = intdiv($current_trip['duration'], 60) - $days * 24 - $hours * 60;
      $duration = $hours.'h'.$minutes;
      if ($days > 0)
      {
        $duration = $days.'d'.$duration;
      }
      $changes = count(array_unique($current_trip['trains'])) - 1;

      if (!is_null($arrive) &&
          !is_null($start_name) &&
          !is_null($stop_name) &&
          $action == 'return_trajectories.php'
        )
      {
        $onclick_function = "'post_choice(\"{$action}\", "
                                          ."this.id, "
                                          ."\"{$arrive}\", "
                                          ."\"{$start_name}\", "
                                          ."\"{$stop_name}\""
                                          .")'";
      }
      else
      {
        $onclick_function = "'post_choice(\"{$action}\", "
                                          ."this.id)'"; 
      }

      $new_html = show_ride($current_trip['heure_dep'],
                            $current_trip['heure_arr'],
                            $current_trip['duration'],
                            $current_trip['prix'],
                            $current_trip['trains'],
                            $current_trip['times'],
                            $current_trip['stations'],
                            $id_trip, $onclick_function);
      $html_doc = $html_doc.$new_html;
    }

    return $html_doc;
  }


  function get_trips($start_name, $stop_name,
                      $conexion, $start_date, $minimum_time)
  {
    $start_position = "SELECT nom, ville FROM gare "
                        ."WHERE ville = '{$start_name}' "
                        ."OR nom = '{$start_name}';";
    $stop_position = "SELECT nom, ville FROM gare "
                        ."WHERE ville = '{$stop_name}' "
                        ."OR nom = '{$stop_name}';";

    $start_request = mysqli_query($conexion, $start_position);
    if ($start_request)
      $start_result = mysqli_fetch_assoc($start_request);
    else
      die('Erreur inattendue');
    try
    {
      mysqli_free_result($start_request);
    }
    catch (Exception $excep){}
    $stop_request = mysqli_query($conexion, $stop_position);
    if ($stop_request)
      $stop_result = mysqli_fetch_assoc($stop_request);
    else
      die('Erreur inattendue');
    try
    {
      mysqli_free_result($stop_request);
    }
    catch (Exception $excep){}

    if($start_result)
    {
      if ($start_result['nom'] == $start_name && $stop_result)
      {
        if ($stop_result['nom'] == $stop_name)
        {
          $get_paths = "CALL Station2Station('{$start_name}', '{$start_date}', "
                        ."'{$minimum_time}', '{$stop_name}')";
        }
        elseif ($stop_result['ville'] == $stop_name)
        {
          $get_paths = "CALL Station2City('{$start_name}', '{$start_date}', "
                        ."'{$minimum_time}', '{$stop_name}')";
        }
      }

      elseif ($start_result['ville'] == $start_name && $stop_result)
      {
        if ($stop_result['nom'] == $stop_name)
        {
          $get_paths = "CALL City2Station('{$start_name}', '{$start_date}', "
                        ."'{$minimum_time}', '{$stop_name}')";
        }
        elseif ($stop_result['ville'] == $stop_name)
        {
          $get_paths = "CALL City2City('{$start_name}', '{$start_date}', "
                        ."'{$minimum_time}', '{$stop_name}')";
        }
      }

      if (isset($get_paths))
      {
        $request = mysqli_query($conexion, $get_paths);
        if ($request)
          $final_results = mysqli_fetch_assoc($request);
        else
          die('Erreur inattendue');

        $valid_trips = array();
        while ($final_results)
        {
          $times = explode('.',
                            substr($final_results['time_string'], 0, -1)
                          );
          foreach ($times as $index => $ride)
          {
            $times[$index] = explode('_', $ride);
          }
          $duration = $times[$index][1] - $times[0][0];

          $stations = substr($final_results['path_string'], 0, -1);
          $current_key = $stations.$final_results['heure_dep'];
          $stations = explode('.', $stations);

          $trains = substr($final_results['trains_string'], 0, -1);
          $trains = explode('.', $trains);

          if (!array_key_exists($current_key, $valid_trips))
          {
            $valid_trips[$current_key] = 
                              [
                                'date_dep' => $final_results['date_dep'],
                                'heure_dep' => $final_results['heure_dep'],
                                'date_arr' => $final_results['date_arr'],
                                'heure_arr' => $final_results['heure_arr'],
                                'stations' => $stations,
                                'trains' => $trains,
                                'times' => $times,
                                'duration' => $duration,
                                'prix' => $final_results['prix']
                              ];
          }

          else
          {
            if ($duration < $valid_trips[$current_key]['duration'])
            {
              $valid_trips[$current_key] = 
                                [
                                  'date_dep' => $final_results['date_dep'],
                                  'heure_dep' => $final_results['heure_dep'],
                                  'date_arr' => $final_results['date_arr'],
                                  'heure_arr' => $final_results['heure_arr'],
                                  'stations' => $stations,
                                  'trains' => $trains,
                                  'times' => $times,
                                  'duration' => $duration
                                ];
            }
          }

          $final_results = mysqli_fetch_assoc($request);
        }
        try
        {
          mysqli_free_result($request);
          mysqli_next_result($conexion);
        }
        catch (Exception $excep){}

        return $valid_trips;
      }
    }
  }


  function show_ride($start_time, $end_time, $duration, $price,
                      $trains, $times, $stations, $id_trip='',
                      $function_str='')
  {

    $html_doc = '';
    $days = intdiv($duration, (60 * 60 * 24));
    $hours = intdiv($duration, (60 * 60)) - $days * 24;
    $minutes = intdiv($duration, 60) - $days * 24 - $hours * 60;
    $duration_str = $hours.'h'.$minutes;
    if ($days > 0)
    {
      $duration_str = $days.'d'.$duration_str;
    }
    $changes = count(array_unique($trains)) - 1;

    if ($id_trip != '' && $function_str != '')
    {
      $sell_button = "<button class='sell_button' id='{$id_trip}'"
                              ." onclick={$function_str}>"
                          ."Ajouter à la liste"
                        ."</button>"; // close sell_button
    }
    else
    {
      $sell_button = '';
    }

    $html_doc = $html_doc
                  ."<div class='trip_box'>"
                    ."<div class='ticket_details'>"
                      ."<div class='schedule_details'>"
                        ."<div class='station_details'>"
                          ."<div class='time'>"
                            .$start_time
                          ."</div>" // close start_time
                          ."<div class='position'>"
                            .$stations[0]
                          ."</div>" // close start_position
                        ."</div>" // close start_details
                        ."<div class='duration'>"
                          .$duration_str
                        ."</div>" // close duration
                        ."<div class='station_details'>"
                          ."<div class='time'>"
                            .$end_time
                          ."</div>" // close stop_time
                          ."<div class='position'>"
                            .$stations[count($stations) - 1]
                          ."</div>" // close stop_position
                        ."</div>" // close stop_details
                      ."</div>" // close schedule_details
                      ."<div class='sell_details'>"
                        ."<div class='price_details'>"
                          ."€{$price}"
                        ."</div>" // close price_details
                        .$sell_button
                      ."</div>"
                    ."</div>" // close ticket_details
                    ."<div class='train_details'>"
                      ."<button class='train_button'>"
                        ."{$changes} Corresp. >"
                      ."</button>"
                      ."<div class='train_content'>";

    $current_train = $trains[0];
    $html_doc = $html_doc
                  ."<div class='ride_detail'>"
                    ."<div class='ride_gare'>Gare : "
                            ."{$stations[0]}</div>"
                    ."<div class='ride_train'>Train : "
                            ."{$current_train}</div>"
                    ."<div class='ride_hour'>Heure : "
                            ."{$start_time}</div>"
                  ."</div>";
    foreach ($trains as $index_train => $train)
    {
      if ($train != $current_train)
      {
        $time_down = date('H:i:s', $times[$index_train - 1][1]);
        $time_up = date('H:i:s', $times[$index_train][0]);
        $time2wait = $times[$index_train][0]
                      - $times[$index_train - 1][1];
        $hours2wait = intdiv($time2wait, (60 * 60));
        $minutes2wait = intdiv($time2wait, 60) - $hours2wait * 60;
        $waiting_time = $hours2wait.'h'.$minutes2wait;

        $html_doc = $html_doc
                      ."<div class='ride_detail'>"
                        ."<div class='ride_gare'>Gare : "
                              ."{$stations[$index_train]}</div>"
                        ."<div class='ride_train'>Train : "
                              ."{$current_train}</div>"
                        ."<div class='ride_hour'>Heure : "
                              ."{$time_down}</div>"
                      ."</div>"
                      ."<div class='train_change'>"
                        ."Correspondance : {$waiting_time}"
                      ."</div>"
                      ."<div class='ride_detail'>"
                        ."<div class='ride_gare'>Gare : "
                              ."{$stations[$index_train]}</div>"
                        ."<div class='ride_train'>Train : "
                              ."{$train}</div>"
                        ."<div class='ride_hour'>Heure : "
                              ."{$time_up}</div>"
                      ."</div>";
          $current_train = $train;
      }
    }

    $html_doc = $html_doc
                        ."<div class='ride_detail'>"
                          ."<div class='ride_gare'>Gare : "
                                ."{$stations[$index_train + 1]}</div>"
                          ."<div class='ride_train'>Train : "
                                ."{$train}</div>"
                          ."<div class='ride_hour'>Heure : "
                                ."{$end_time}</div>"
                        ."</div>"
                      ."</div>" // close train_content
                    ."</div>" // close train_details
                  ."</div>"; // close trip_box

    return $html_doc;
  }

?>
