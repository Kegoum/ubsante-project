<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_lit ") or die(mysqli_error($con));
$lits = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $lits[$i]["id"] = $rowpay["idlit"];
    $lits[$i]["libelle"] = $rowpay["libellelit"];
    $i = $i + 1;
}
if (isset($_POST['libelle'])) {
    $code = ucwords($_POST['libelle']);
    foreach ($lits as $k => $v) {
        if ($code == $lits[$k]["libelle"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['libellee'])) {
    $code = ucwords($_POST['libellee']);
    $id = $_POST['idlit'];
    foreach ($lits as $k => $v) {
        if ($code == $lits[$k]["libelle"]) {
            if ($id != $lits[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
