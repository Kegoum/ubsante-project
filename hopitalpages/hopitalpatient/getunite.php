<?php

session_start();

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$idd = $_POST['moid'];   // department id
$users_arr = array();
$req = $con->query("select * from hp_conversion as c left join hp_unite as u on c.idunite=u.idunite where "
        . "c.idproduit='" . $idd . "' ") or die(mysqli_error($con));
while ($rowm = mysqli_fetch_array($req)) {
    $ide = $rowm['idunite'];
    $libe = $rowm['libelleunite'];

    $users_arr[] = array("ide" => $ide, "libe" => $libe);
}
// encoding array to json format
echo json_encode($users_arr);
