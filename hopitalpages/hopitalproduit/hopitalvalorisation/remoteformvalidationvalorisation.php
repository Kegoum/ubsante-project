<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_valorisation_stock ") or die(mysqli_error($con));
$typeproduits = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $typeproduits[$i]["id"] = $rowpay["idvalorisationstock"];
    $typeproduits[$i]["code"] = $rowpay["codevalorisationstock"];
    $typeproduits[$i]["valorisationstock"] = $rowpay["libellevalorisationstock"];
    $i = $i + 1;
}
if (isset($_POST['codevalorisationstock'])) {
    $code = $_POST['codevalorisationstock'];
    foreach ($typeproduits as $k => $v) {
        if ($code == $typeproduits[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codevalorisationstocke'])) {
    $code = $_POST['codevalorisationstocke'];
    $id = $_POST['idvalorisationstock'];
    foreach ($typeproduits as $k => $v) {
        if ($code == $typeproduits[$k]["code"]) {
            if ($id != $typeproduits[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
