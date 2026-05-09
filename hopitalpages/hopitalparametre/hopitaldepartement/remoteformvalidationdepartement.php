<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("select * from hp_departement as v left join hp_region as p on v.idregion=p.idregion ") or die(mysqli_error($con));
$departements = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $departements[$i]["id"] = $rowpay["iddepartement"];
    $departements[$i]["departement"] = $rowpay["libelledepartement"];
    $i = $i + 1;
}
if (isset($_POST['departement'])) {
    $code = ucwords($_POST['departement']);
    foreach ($departements as $k => $v) {
        if (($code == $departements[$k]["departement"])) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['departemente'])) {
    $code = ucwords($_POST['departemente']);
    $id = $_POST['iddepartement'];
    foreach ($departements as $k => $v) {
        if (($code == $departements[$k]["departement"])) {
            if ($id != $departements[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
