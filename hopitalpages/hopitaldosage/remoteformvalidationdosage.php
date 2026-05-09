<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_dosage ") or die(mysqli_error($con));
$dosages = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $dosages[$i]["id"] = $rowpay["iddosage"];
    $dosages[$i]["dosage"] = $rowpay["libelledosage"];
    $i = $i + 1;
}
if (isset($_POST['libdosagema'])) {
    $code = $_POST['libdosagema'];
    foreach ($dosages as $k => $v) {
        if ($code == $dosages[$k]["dosage"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['libdosagee'])) {
    $code = $_POST['libdosagee'];
    $id = $_POST['iddosage'];
    foreach ($dosages as $k => $v) {
        if ($code == $dosages[$k]["dosage"]) {
            if ($id != $dosages[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
