<?php

  function generate_rides($valid_trips, $action,
                          $arrive=NULL, $start_name=NULL,
                          $stop_name=NULL)
  {
    $html_dco = "";
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

      $html_doc = $html_doc
                    ."<div class='trip_box'>"
                      ."<div class='ticket_details'>"
                        ."<div class='schedule_details'>"
                          ."<div class='station_details'>"
                            ."<div class='time'>"
                              .$current_trip['heure_dep']
                            ."</div>" // close start_time
                            ."<div class='position'>"
                              .$current_trip['stations'][0]
                            ."</div>" // close start_position
                          ."</div>" // close start_details
                          ."<div class='duration'>"
                            .$duration
                          ."</div>" // close duration
                          ."<div class='station_details'>"
                            ."<div class='time'>"
                              .$current_trip['heure_arr']
                            ."</div>" // close stop_time
                            ."<div class='position'>"
                              .$current_trip['stations']
                                      [count($current_trip['stations']) - 1]
                            ."</div>" // close stop_position
                          ."</div>" // close stop_details
                        ."</div>" // close schedule_details
                        ."<div class='sell_details'>"
                          ."<div class='price_details'>"
                            ."NOT YET"
                          ."</div>" // close price_details
                          ."<button class='sell_button' id='{$id_trip}' "
                                ." onclick={$onclick_function}>"
                            ."Ajouter à la liste"
                          ."</button>" // close sell_button
                        ."</div>"
                      ."</div>" // close ticket_details
                      ."<div class='train_details'>"
                        ."<button class='train_button'>"
                          ."{$changes} Corresp. >"
                        ."</button>"
                        ."<div class='train_content'>";

      $current_train = $current_trip['trains'][0];
      $html_doc = $html_doc
                    ."<div class='ride_detail'>"
                      ."<div class='ride_gare'>Gare : "
                              ."{$current_trip['stations'][0]}</div>"
                      ."<div class='ride_train'>Train : "
                              ."{$current_train}</div>"
                      ."<div class='ride_hour'>Heure : "
                              ."{$current_trip['heure_dep']}</div>"
                    ."</div>";
      foreach ($current_trip['trains'] as $index_train => $train)
      {
        if ($train != $current_train)
        {
          $time_down = date('H:i:s', $current_trip['times'][$index_train - 1][1]);
          $time_up = date('H:i:s', $current_trip['times'][$index_train][0]);
          $time2wait = $current_trip['times'][$index_train][0]
                        - $current_trip['times'][$index_train - 1][1];
          $hours2wait = intdiv($time2wait, (60 * 60));
          $minutes2wait = intdiv($time2wait, 60) - $hours2wait * 60;
          $waiting_time = $hours2wait.'h'.$minutes2wait;

          $html_doc = $html_doc
                        ."<div class='ride_detail'>"
                          ."<div class='ride_gare'>Gare : "
                                ."{$current_trip['stations'][$index_train]}</div>"
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
                                ."{$current_trip['stations'][$index_train]}</div>"
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
                                  ."{$current_trip['stations'][$index_train + 1]}</div>"
                            ."<div class='ride_train'>Train : "
                                  ."{$train}</div>"
                            ."<div class='ride_hour'>Heure : "
                                  ."{$current_trip['heure_arr']}</div>"
                          ."</div>"
                        ."</div>" // close train_content
                      ."</div>" // close train_details
                    ."</div>"; // close trip_box
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
    $start_result = mysqli_fetch_assoc($start_request);
    $stop_request = mysqli_query($conexion, $stop_position);
    $stop_result = mysqli_fetch_assoc($stop_request);

    if($start_result)
    {
      if ($start_result['nom'] == $start_name && $stop_result)
      {
        if ($stop_result['nom'] == $stop_name)
        {
          $get_paths = "SELECT date_dep, heure_dep, date_arr, heure_arr, "
                              ."trains_string, path_string, time_string "
                        ."FROM all_trajectories "
                        ."WHERE nom_dep = '{$start_name}' "
                        ."AND nom_arr = '{$stop_name}' "
                        ."AND date_dep = '{$start_date}' "
                        ."AND heure_dep >= '{$minimum_time}' "
                        ."ORDER BY path_string, heure_dep, heure_arr;";
        }
        elseif ($stop_result['ville'] == $stop_name)
        {
          $get_paths = "SELECT date_dep, heure_dep, date_arr, heure_arr, "
                              ."trains_string, path_string, time_string "
                        ."FROM all_trajectories "
                        ."WHERE nom_dep = '{$start_name}' "
                        ."AND nom_arr IN ("
                          ."SELECT nom FROM gare "
                            ."WHERE ville = '{$stop_name}'"
                        .") AND date_dep = '{$start_date}' "
                        ."AND heure_dep >= '{$minimum_time}' "
                        ."ORDER BY path_string, heure_dep, heure_arr;";
        }
      }

      elseif ($start_result['ville'] == $start_name && $stop_result)
      {
        if ($stop_result['nom'] == $stop_name)
        {
          $get_paths = "SELECT date_dep, heure_dep, date_arr, heure_arr, "
                              ."trains_string, path_string, time_string "
                        ."FROM all_trajectories "
                        ."WHERE nom_dep IN ("
                          ."SELECT nom FROM gare "
                            ."WHERE ville = '{$start_name}'"
                        .") AND nom_arr = '{$stop_name}' "
                        ."AND date_dep = '{$start_date}' "
                        ."AND heure_dep >= '{$minimum_time}' "
                        ."ORDER BY path_string, heure_dep, heure_arr;";
        }
        elseif ($stop_result['ville'] == $stop_name)
        {
          $get_paths = "SELECT date_dep, heure_dep, date_arr, heure_arr, "
                              ."trains_string, path_string, time_string "
                        ."FROM all_trajectories "
                        ."WHERE nom_dep IN ("
                          ."SELECT nom FROM gare "
                            ."WHERE ville = '{$start_name}'"
                        .") AND nom_arr IN ("
                          ."SELECT nom FROM gare "
                            ."WHERE ville = '{$stop_name}'"
                        .") AND date_dep = '{$start_date}' "
                        ."AND heure_dep >= '{$minimum_time}' "
                        ."ORDER BY path_string, heure_dep, heure_arr;";
        }
      }

      if (isset($get_paths))
      {
        $request = mysqli_query($conexion, $get_paths);
        $final_results = mysqli_fetch_assoc($request);

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
                                'duration' => $duration
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

        return $valid_trips;
      }
    }
  }
?>
