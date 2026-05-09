<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_echographie ") or die(mysqli_error($con));
$echographies = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $echographies[$i]["id"] = $rowpay["idechographie"];
    $echographies[$i]["code"] = $rowpay["codeechographie"];
    $i = $i + 1;
}

if (isset($_POST['codep'])) {
    $code = strtoupper($_POST['codep']);
    foreach ($echographies as $k => $v) {
        if ($code == $echographies[$k]["code"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['codepe'])) {
    $code = strtoupper($_POST['codepe']);
    $id = $_POST['idechographie'];
//    echo $id;
    foreach ($echographies as $k => $v) {
        if ($code == $echographies[$k]["code"]) {
            if ($id != $echographies[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
