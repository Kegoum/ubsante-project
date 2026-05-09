<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_unite ") or die(mysqli_error($con));
$unites = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $unites[$i]["id"] = $rowpay["idunite"];
    $unites[$i]["code"] = $rowpay["codeunite"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($unites as $k => $v) {
        if ($code == $unites[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idunite'];
//    echo $id;
    foreach ($unites as $k => $v) {
        if ($code == $unites[$k]["code"]) {
            if ($id != $unites[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
