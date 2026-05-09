<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_classe_medicamenteuse ") or die(mysqli_error($con));
$classemedicamenteuses = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $classemedicamenteuses[$i]["id"] = $rowpay["idclassemedicamenteuse"];
    $classemedicamenteuses[$i]["classemedicamenteuse"] = $rowpay["libelleclassemedicamenteuse"];
    $i = $i + 1;
}
if (isset($_POST['libfamillema'])) {
    $code = $_POST['libfamillema'];
    foreach ($classemedicamenteuses as $k => $v) {
        if ($code == $classemedicamenteuses[$k]["classemedicamenteuse"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['libfamillee'])) {
    $code = $_POST['libfamillee'];
    $id = $_POST['idclassemedicamenteuse'];
    foreach ($classemedicamenteuses as $k => $v) {
        if ($code == $classemedicamenteuses[$k]["classemedicamenteuse"]) {
            if ($id != $classemedicamenteuses[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
