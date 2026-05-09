<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_region ") or die(mysqli_error($con));
$regions = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $regions[$i]["id"] = $rowpay["idregion"];
    $regions[$i]["code"] = $rowpay["coderegion"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($regions as $k => $v) {
        if ($code == $regions[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idregion'];
//    echo $id;
    foreach ($regions as $k => $v) {
        if ($code == $regions[$k]["code"]) {
            if ($id != $regions[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
