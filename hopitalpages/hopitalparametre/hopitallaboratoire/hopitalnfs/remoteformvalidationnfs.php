<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_nfs ") or die(mysqli_error($con));
$nfss = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $nfss[$i]["id"] = $rowpay["idlignenfs"];
    $nfss[$i]["code"] = $rowpay["codligneenfs"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($nfss as $k => $v) {
        if ($code == $nfss[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idnfs'];
//    echo $id;
    foreach ($nfss as $k => $v) {
        if ($code == $nfss[$k]["code"]) {
            if ($id != $nfss[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
