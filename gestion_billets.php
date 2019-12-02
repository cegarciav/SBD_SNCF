<?php
include_once("../conexion.php");

if(isset($_GET['sup']))
{
    $_GET['sup'] = $nb_billet;
    $_GET['sup'] = mysqli_real_escape_string($conexion, $nb_billet);
    $req_email = "SELECT email FROM billet WHERE numero = ".$nb_billet;
    $sql_email = mysqli_query($conexion, $req_email);
    if ($sql_email)
        $resp = mysqli_fetch_assoc($sql_email);
    else
        die('Erreur inattendue');
    $req_count = "SELECT COUNT(*) AS quantite FROM billet WHERE email = '".$resp['email']."'";
    $sql_count = mysqli_query($conexion, $req_count);
    if ($sql_count)
        $resp_count = mysqli_fetch_assoc($sql_count);
    else
        die('Erreur inattendue');

    $req_sup = "DELETE FROM billet WHERE numero = ".$nb_billet;
    $sql_sup = mysqli_query($conexion, $req_sup);
    if ($sql_sup){}
    else
        die('Erreur inattendue');
    if($resp_count['quantite'] == 1)
    {
        $req_client = "DELETE FROM client WHERE email = '".$resp['email']."'";
        $sql_client = mysqli_query($conexion, $req_client);
        if ($sql_client){}
        else
            die('Erreur inattendue');
    }
    $_GET['sup'] = "";

}

if(isset($_POST['prix_n']))
{
    $prix_n = $_POST['prix_n'];
    $prix_n = mysqli_real_escape_string($conexion, $prix_n);
    $req = "UPDATE billet SET prix = ".$prix_n." WHERE numero = ".$_POST['nb_billet'];
    $sql = mysqli_query($conexion, $req);
    if ($sql)
        {}
    else
        die('Erreur inattendue');
    $_POST['prix_n'] = "";
    $_POST['nb_billet'] = "";

}

$req = "SELECT b.numero, c.prenom, c.nom, b.nom_dep, b.nom_arr, b.date_dep, b.date_arr, b.prix FROM billet b, client c WHERE b.email = c.email";
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

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>

<script type="text/javascript">
    function validate_sure(){
        if (confirm("Vous êtes sur de suprimer ce billet ?"))
            return true;
        return false;
    }

</script>
<body>

    <form action="gestion_billets.php" method="post">
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
                    <th>Action</th>
                </tr>
                <?php foreach($row as $i){
                    echo "<tr>";
                    foreach($i as $j){
                    echo "
                        <td>".$j."</td>";
                    }
                    echo "<td><a href='gestion_billets.php?sup=".$i['0']."' onclick='return validate_sure();'><img src='images/suprimir.svg' style='width:15px;height:15px' alt='Suprimer' /></a>
                    <a href='modify_prix.php?edit=".$i['0']."'><img src='images/edit.svg' style='width:15px;height:15px' alt='Editer' /></a></td>";
                }
                ?>

            </table>
        </div>

    </form>

</body>
</html>