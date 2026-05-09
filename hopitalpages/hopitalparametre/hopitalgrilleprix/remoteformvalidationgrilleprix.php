<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_grille_prix ") or die(mysqli_error($con));
$grilleprixs = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $grilleprixs[$i]["id"] = $rowpay["idgrilleprix"];
    $grilleprixs[$i]["designation"] = $rowpay["designationgrilleprix"];
    $i = $i + 1;
}

if (isset($_POST['designationp'])) {
    $designation = strtoupper($_POST['designationp']);
    foreach ($grilleprixs as $k => $v) {
        if ($designation == $grilleprixs[$k]["designation"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['designationpe'])) {
    $designation = strtoupper($_POST['designationpe']);
    $id = $_POST['idgrilleprix'];
//    echo $id;
    foreach ($grilleprixs as $k => $v) {
        if ($designation == $grilleprixs[$k]["designation"]) {
            if ($id != $grilleprixs[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
