<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_pharmacie ") or die(mysqli_error($con));
$pharmacies = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $pharmacies[$i]["id"] = $rowpay["idpharmacie"];
    $pharmacies[$i]["code"] = $rowpay["codepharmacie"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($pharmacies as $k => $v) {
        if ($code == $pharmacies[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idpharmacie'];
//    echo $id;
    foreach ($pharmacies as $k => $v) {
        if ($code == $pharmacies[$k]["code"]) {
            if ($id != $pharmacies[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
