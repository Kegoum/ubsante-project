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
$req = $con->query("select * from hp_pointage as p left join hp_affectation as a on p.idaffectation=a.idaffectation "
        . "where p.idpointage='" . $idd . "' ") or die(mysqli_error($con));
$rowm = mysqli_fetch_array($req);
$idmo = $rowm['idpointage'];
$nbh = $rowm['nombreheuredecimalepointage'];
$prixu = $rowm['salaireaffectation'];

$users_arr = array("idmo" => $idmo, "nbh" => $nbh, "prixu" => $prixu);

// encoding array to json format
echo json_encode($users_arr);
