<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_chambre ") or die(mysqli_error($con));
$chambres = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $chambres[$i]["id"] = $rowpay["idchambre"];
    $chambres[$i]["code"] = $rowpay["codechambre"];
    $i = $i + 1;
}
if (isset($_POST['code'])) {
    $code = $_POST['code'];
    foreach ($chambres as $k => $v) {
        if ($code == $chambres[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codee'])) {
    $code = $_POST['codee'];
    $id = $_POST['idchambre'];
    foreach ($chambres as $k => $v) {
        if ($code == $chambres[$k]["code"]) {
            if ($id != $chambres[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
