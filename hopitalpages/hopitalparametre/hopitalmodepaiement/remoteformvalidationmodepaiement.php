<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_mode_paiement ") or die(mysqli_error($con));
$modepaiements = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $modepaiements[$i]["id"] = $rowpay["idmodepaiement"];
    $modepaiements[$i]["code"] = $rowpay["codemodepaiement"];
    $i = $i + 1;
}
if (isset($_POST['code'])) {
    $code = $_POST['code'];
    foreach ($modepaiements as $k => $v) {
        if ($code == $modepaiements[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codee'])) {
    $code = $_POST['codee'];
    $id = $_POST['idmodepaiement'];
    foreach ($modepaiements as $k => $v) {
        if ($code == $modepaiements[$k]["code"]) {
            if ($id != $modepaiements[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
