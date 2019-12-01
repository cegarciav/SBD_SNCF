<?php

  function ride_validator($one_way)
  {
    try
    {
      $one_way_decoded = (array) json_decode($one_way);
      if (isset($one_way_decoded['date_dep']))
      {
        preg_match("/^\d{4}-\d{2}-\d{2}$/",
                    $one_way_decoded['date_dep'], $match_date);
        if (count($match_date) != 1 || !strtotime($match_date[0]))
          return false;
      }
      else
        return false;

      if (isset($one_way_decoded['date_arr']))
      {
        preg_match("/^\d{4}-\d{2}-\d{2}$/",
                    $one_way_decoded['date_arr'], $match_date2);
        if (count($match_date2) != 1 || !strtotime($match_date2[0]))
          return false;
      }
      else
        return false;

      if (isset($one_way_decoded['heure_dep']))
      {
        preg_match("/^\d{2}:\d{2}:\d{2}$/",
                    $one_way_decoded['heure_dep'], $match_heure);
        if (count($match_heure) != 1 || !strtotime($match_heure[0]))
          return false;
      }
      else
        return false;

      if (isset($one_way_decoded['heure_arr']))
      {
        preg_match("/^\d{2}:\d{2}:\d{2}$/",
                    $one_way_decoded['heure_arr'], $match_heure2);
        if (count($match_heure2) != 1 || !strtotime($match_heure2[0]))
          return false;
      }
      else
        return false;

      if (strtotime($match_date[0].' '.$match_heure[0]) >=
          strtotime($match_date2[0].' '.$match_heure2[0]))
        return false;

      if (isset($one_way_decoded['stations']) &&
          isset($one_way_decoded['trains']) &&
          isset($one_way_decoded['times'])
          )
      {
        if (!(count($one_way_decoded['trains']) ==
                            count($one_way_decoded['times'])) ||
            count($one_way_decoded['stations']) !=
                            count($one_way_decoded['trains']) + 1
            )
          return false;
      }
      else
        return false;

      if (isset($one_way_decoded['duration']))
      {
        $last_time = count($one_way_decoded['times']) - 1;
        $last_time = $one_way_decoded['times'][$last_time][1];
        if ($one_way_decoded['duration'] !=
            $last_time - $one_way_decoded['times'][0][0]
          )
          return false;
      }
      else
        return false;
      
      if (isset($one_way_decoded['prix']))
      {
        preg_match("/^\d+$/",
                    $one_way_decoded['prix'], $match_prix);
        if (count($match_prix) != 1 || $match_prix[0] <= 0)
          return false;
      }
      else
        return false;
    }
    catch (Exception $exception)
    {
      return false;
    }

    return true;
  }

?>