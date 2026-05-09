<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_categorie_chambre ") or die(mysqli_error($con));
$categoriechambres = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $categoriechambres[$i]["id"] = $rowpay["idcategoriechambre"];
    $categoriechambres[$i]["libelle"] = $rowpay["libellecategoriechambre"];
    $i = $i + 1;
}
if (isset($_POST['libelle'])) {
    $code = ucwords($_POST['libelle']);
    foreach ($categoriechambres as $k => $v) {
        if ($code == $categoriechambres[$k]["libelle"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['libellee'])) {
    $code = ucwords($_POST['libellee']);
    $id = $_POST['idcategoriechambre'];
    foreach ($categoriechambres as $k => $v) {
        if ($code == $categoriechambres[$k]["libelle"]) {
            if ($id != $categoriechambres[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
