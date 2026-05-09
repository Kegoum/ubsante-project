<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_parametre ") or die(mysqli_error($con));
$parametres = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $parametres[$i]["id"] = $rowpay["idparametre"];
    $parametres[$i]["code"] = $rowpay["codeparametre"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($parametres as $k => $v) {
        if ($code == $parametres[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idparametre'];
//    echo $id;
    foreach ($parametres as $k => $v) {
        if ($code == $parametres[$k]["code"]) {
            if ($id != $parametres[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
