<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_service ") or die(mysqli_error($con));
$services = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $services[$i]["id"] = $rowpay["idservice"];
    $services[$i]["code"] = $rowpay["codeservice"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($services as $k => $v) {
        if ($code == $services[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idservice'];
//    echo $id;
    foreach ($services as $k => $v) {
        if ($code == $services[$k]["code"]) {
            if ($id != $services[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
