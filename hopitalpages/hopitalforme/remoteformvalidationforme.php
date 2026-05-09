<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_forme ") or die(mysqli_error($con));
$formes = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $formes[$i]["id"] = $rowpay["idforme"];
    $formes[$i]["forme"] = $rowpay["libelleforme"];
    $i = $i + 1;
}
if (isset($_POST['libformema'])) {
    $code = $_POST['libformema'];
    foreach ($formes as $k => $v) {
        if ($code == $formes[$k]["forme"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['libformee'])) {
    $code = $_POST['libformee'];
    $id = $_POST['idforme'];
    foreach ($formes as $k => $v) {
        if ($code == $formes[$k]["forme"]) {
            if ($id != $formes[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
