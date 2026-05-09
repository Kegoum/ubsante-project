<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_acte ") or die(mysqli_error($con));
$actes = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $actes[$i]["id"] = $rowpay["idacte"];
    $actes[$i]["designation"] = $rowpay["libelleacte"];
    $i = $i + 1;
}

if (isset($_POST['designationp'])) {
    $designation = strtoupper($_POST['designationp']);
    foreach ($actes as $k => $v) {
        if ($designation == $actes[$k]["designation"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['designationpe'])) {
    $designation = strtoupper($_POST['designationpe']);
    $id = $_POST['idacte'];
//    echo $id;
    foreach ($actes as $k => $v) {
        if ($designation == $actes[$k]["designation"]) {
            if ($id != $actes[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
