<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_caisse ") or die(mysqli_error($con));
$caisses = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $caisses[$i]["id"] = $rowpay["idcaisse"];
    $caisses[$i]["code"] = $rowpay["codecaisse"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($caisses as $k => $v) {
        if ($code == $caisses[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idcaisse'];
//    echo $id;
    foreach ($caisses as $k => $v) {
        if ($code == $caisses[$k]["code"]) {
            if ($id != $caisses[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
