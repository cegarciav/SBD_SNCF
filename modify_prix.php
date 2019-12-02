<?php
include_once("../conexion.php");

if(isset($_GET['edit']))
{
    $_GET['edit'] = mysqli_real_escape_string($conexion, $_GET['edit']);
    $req = "SELECT b.numero, c.prenom, c.nom, b.nom_dep, b.nom_arr, b.date_dep, b.date_arr, b.prix FROM billet b, client c WHERE b.numero = ".$_GET['edit']." AND b.email = c.email";
    $sql = mysqli_query($conexion, $req);
    if ($sql)
        $rows = mysqli_fetch_all($sql);
    else
        die('Erreur inattendue');
    $row = [];
    foreach($rows as $index => $valor)
    {
        array_push($row, $valor);
    }
    try
    {
        mysqli_free_result($sql);
    }
    catch (Exception $excep){}

}
?>


<!DOCTYPE html>
<html>

<script type="text/javascript">
    function validate()
    {
        if(confirm("Vous êtes sûr de vouloir modifier le prix de ce billet ?"))
            return true;
        return false;
    }
</script>
<head>
    <title></title>
</head>
<body>
    <form action="gestion_billets.php" method="post" onsubmit="return validate()">
    <div>
            <table>
                <tr>
                    <th>Numéro</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Départ</th>
                    <th>Destine</th>
                    <th>Date départ</th>
                    <th>Date retour</th>
                    <th>Prix</th>
                </tr>
                <?php foreach($row as $i){
                    echo "<tr>";
                    foreach($i as $j){
                    echo "
                        <td>".$j."</td>";
                    }
                    echo "</tr>";
                }
                ?>

            </table>
        </div>
        <div>
            Nouveau prix : 
            <input type="number" name="prix_n" min="0" required>
            <button type="submit">Accepter</button>
            <input type="hidden" value="<?php echo $_GET['edit']; ?>" name="nb_billet">
        </div>

</body>
</html>