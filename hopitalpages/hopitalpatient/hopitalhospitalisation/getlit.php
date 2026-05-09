<?php

session_start();

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$idd = $_POST['moid'];   // department id
$users_arr = array();
$req = $con->query("select * from hp_lit as l where l.idchambre='" . $idd . "' and l.etatlit=true and l.statutlit=true "
        . "") or die(mysqli_error($con));
while ($rowm = mysqli_fetch_array($req)) {
    $ide = $rowm['idlit'];
    $libe = $rowm['codelit'];

    $users_arr[] = array("ide" => $ide, "libe" => $libe);
}
// encoding array to json format
echo json_encode($users_arr);
