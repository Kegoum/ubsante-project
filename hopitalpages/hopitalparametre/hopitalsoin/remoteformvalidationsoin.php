<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_soin ") or die(mysqli_error($con));
$soins = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $soins[$i]["id"] = $rowpay["idsoin"];
    $soins[$i]["code"] = $rowpay["codesoin"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($soins as $k => $v) {
        if ($code == $soins[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idsoin'];
//    echo $id;
    foreach ($soins as $k => $v) {
        if ($code == $soins[$k]["code"]) {
            if ($id != $soins[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
