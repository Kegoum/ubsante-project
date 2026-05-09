<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_categorie ") or die(mysqli_error($con));
$categories = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $categories[$i]["id"] = $rowpay["idcategorie"];
    $categories[$i]["code"] = $rowpay["codecategorie"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($categories as $k => $v) {
        if ($code == $categories[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idcategorie'];
//    echo $id;
    foreach ($categories as $k => $v) {
        if ($code == $categories[$k]["code"]) {
            if ($id != $categories[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
