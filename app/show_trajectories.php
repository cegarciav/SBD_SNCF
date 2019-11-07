<?php

  if (isset($_POST["nom_dep"]) &&
    isset($_POST["nom_arr"]) &&
    isset($_POST["date_dep"]) &&
    isset($_POST["date_arr"])
    )
  {
    $start_name = $_POST["nom_dep"];
    $stop_name = $_POST["nom_arr"];
    $start_date = $_POST["date_dep"];
    $stop_date = $_POST["date_arr"];
  }
  else
  {
    echo "How dare you modify my website?";

  }


?>