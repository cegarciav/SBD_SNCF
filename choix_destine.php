<?php

include_once("conexion.php");
$req = "SELECT ville FROM gare";
$sql = mysqli_query($conexion, $req);
$options="";
while ($row=mysqli_fetch_array($sql))
{
$name=$row["ville"];
$options.="<OPTION VALUE=\"$name\">".$name.'</option>';
echo $name;
}

?>
<select>


</select>

<select>


</select>