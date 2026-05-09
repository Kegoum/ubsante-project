<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_magasin ") or die(mysqli_error($con));
$magasins = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $magasins[$i]["id"] = $rowpay["idmagasin"];
    $magasins[$i]["code"] = $rowpay["codemagasin"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($magasins as $k => $v) {
        if ($code == $magasins[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idmagasin'];
//    echo $id;
    foreach ($magasins as $k => $v) {
        if ($code == $magasins[$k]["code"]) {
            if ($id != $magasins[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
