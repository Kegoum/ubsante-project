<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_laboratoire_produit ") or die(mysqli_error($con));
$laboratoireproduits = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $laboratoireproduits[$i]["id"] = $rowpay["idlaboratoireproduit"];
    $laboratoireproduits[$i]["laboratoireproduit"] = $rowpay["libellelaboratoireproduit"];
    $i = $i + 1;
}
if (isset($_POST['liblaboratoireproduitma'])) {
    $code = $_POST['liblaboratoireproduitma'];
    foreach ($laboratoireproduits as $k => $v) {
        if ($code == $laboratoireproduits[$k]["laboratoireproduit"]) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['liblaboratoireproduite'])) {
    $code = $_POST['liblaboratoireproduite'];
    $id = $_POST['idlaboratoireproduit'];
    foreach ($laboratoireproduits as $k => $v) {
        if ($code == $laboratoireproduits[$k]["laboratoireproduit"]) {
            if ($id != $laboratoireproduits[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}


echo json_encode(array(
    'valid' => $valid,
));
