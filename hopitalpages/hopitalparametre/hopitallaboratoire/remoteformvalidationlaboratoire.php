<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_laboratoire ") or die(mysqli_error($con));
$laboratoires = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $laboratoires[$i]["id"] = $rowpay["idlaboratoire"];
    $laboratoires[$i]["code"] = $rowpay["codelaboratoire"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($laboratoires as $k => $v) {
        if ($code == $laboratoires[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idlaboratoire'];
//    echo $id;
    foreach ($laboratoires as $k => $v) {
        if ($code == $laboratoires[$k]["code"]) {
            if ($id != $laboratoires[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
