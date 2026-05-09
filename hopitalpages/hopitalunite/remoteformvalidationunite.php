<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_conditionnement ") or die(mysqli_error($con));
$conditionnements = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $conditionnements[$i]["id"] = $rowpay["idconditionnement"];
    $conditionnements[$i]["conditionnement"] = $rowpay["libelleconditionnement"];
    $i = $i + 1;
}
if (isset($_POST['libconditionnementma'])) {
    $code = $_POST['libconditionnementma'];
    foreach ($conditionnements as $k => $v) {
        if ($code == $conditionnements[$k]["conditionnement"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['libconditionnemente'])) {
    $code = $_POST['libconditionnemente'];
    $id = $_POST['idconditionnement'];
    foreach ($conditionnements as $k => $v) {
        if ($code == $conditionnements[$k]["conditionnement"]) {
            if ($id != $conditionnements[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
