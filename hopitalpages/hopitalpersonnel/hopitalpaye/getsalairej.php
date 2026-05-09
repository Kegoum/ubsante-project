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
$req = $con->query("select * from hp_personnel as pe left join hp_affectation as af on "
            . "pe.idpersonnel=af.idpersonnel left join hp_service as s on af.idservice=s.idservice "
            . "where af.etataffectation=true and pe.idpersonnel='" . $idd . "' ") or die(mysqli_error($con));
$rowm = mysqli_fetch_array($req);
$prixu = $rowm['salaireaffectation'];

$users_arr = array("prixu" => $prixu);

// encoding array to json format
echo json_encode($users_arr);
