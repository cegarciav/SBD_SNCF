<?php
include_once("conexion.php");
$req = "SELECT ville FROM gare";
$sql = mysqli_query($conexion, $req);
$rows = $sql->fetch_all();
$row = [];
foreach($rows as $index => $valor)
{
  array_push($row, $valor[0]);
}
?>

<script type="text/javascript">
    
    function valider_dates(){
        var startDt=document.getElementById("date_dep").value;
        var finDt=document.getElementById("date_arr").value;
        if(startDt>finDt)
        {
            alert("La date de retour doit être superieur à la date d'aller.");
            return false;
        }
        else return true;
    }

</script>



<!DOCTYPE html>
<html>
<link rel="stylesheet" href="style.css" type="text/css">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>     
<body>
<div class = "choix">
    <div class = "text">
<h2>Choisissez votre voyage</h2>
<!--Make sure the form has the autocomplete function switched off:-->
<form autocomplete="off" action="prueba.php" onsubmit="return valider_dates()" method="post">
    <p>
  <div class="autocomplete" style="width:300px;">Gare de depart : 
    <input id="nom_dep" type="text" name="myCountry" placeholder="Gare de départ" required> 
  </div>
  </p>
  <p>
  <div class="autocomplete" style="width:300px;">Gare d'arrivée : 
    <input id="nom_arr" type="text" name="myCountry" placeholder="Gare d'arrivée" required>
  </div>
  </p>
  <p>Heure :
        <input  type="time" id="heure" name="heure">
    </p>
    <p style="width:150px;">Date d'aller : 
        <input type="date" id="date_dep" name="date_dep" required min=<?php
         echo date('Y-m-d');
     ?>>
    </p>
    <p style="width:150px;">Date de retour : 
        <input type="date" id="date_arr" name="date_arr" required>
    </p>
    <button type="submit">Accepter</button>
</div>
</div>
</form>

<script type="text/javascript">

    function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

var paradas = '<?php echo json_encode($row); ?>';
var parada = JSON.parse(paradas);
autocomplete(document.getElementById("nom_dep"), parada);
autocomplete(document.getElementById("nom_arr"), parada);



</script>

</body>

