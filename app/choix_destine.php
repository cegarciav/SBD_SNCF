<?php
include_once("conexion.php");
$req = "SELECT ville, nom FROM gare";
$sql = mysqli_query($conexion, $req);
?>


<!DOCTYPE html>
<html>
<body>
	<form action="show_trajectories.php" method="post">   <!-- show_trajectories.php -->
  	<div align="center"> 
  	<h1>Choisissez votre voyage</h1>                       
    <p> Gare de depart :
      <select name = "nom_dep" required >
        <option   value="0" >Selectionnez:</option>
        <?php
			while ($row=mysqli_fetch_array($sql))
			{
				echo '<option value="'.$row['nom'].'">'.$row['nom'].'</option>';
			}
        ?>
      </select>
    </p>
    <p> Gare d'arrivée : 
    	<select name = "nom_arr">
    		<option value="0">Selectionnez:</option>
	        <?php
	        	$sql = mysqli_query($conexion, $req);
				while ($row=mysqli_fetch_array($sql))
				{
					echo '<option value="'.$row['nom'].'">'.$row['nom'].'</option>';
				}
	        ?>
    	</select>
    </p>
    <p>
    	<input type="time" id="heure" name="heure">
    </p>
    <p>Date d'aller : 
    	<input type="date" id="date_dep" name="date_dep" required>
    </p>
    <p>Date de retour : 
    	<input type="date" id="date_arr" name="date_arr" required>
    </p>
    <button>Accepter</button>
  </div>
</body>