<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_materiel ") or die(mysqli_error($con));
$materiels = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $materiels[$i]["id"] = $rowpay["idmateriel"];
    $materiels[$i]["libelle"] = $rowpay["libellemateriel"];
    $i = $i + 1;
}
if (isset($_POST['libelle'])) {
    $code = ucwords($_POST['libelle']);
    foreach ($materiels as $k => $v) {
        if ($code == $materiels[$k]["libelle"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['libellee'])) {
    $code = ucwords($_POST['libellee']);
    $id = $_POST['idmateriel'];
    foreach ($materiels as $k => $v) {
        if ($code == $materiels[$k]["libelle"]) {
            if ($id != $materiels[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
