<?php

session_start();

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$code = $_POST['code'];
$designation = $_POST['designation'];

$req = $con->query("select * from hp_categorie where codecategorie='" . addslashes($code) . "' ") or die(mysqli_error($con));
$row = mysqli_num_rows($req);
if ($row == 0) {
    $con->query("insert into hp_categorie(codecategorie, libellecategorie) values('" . addslashes($code) . "', '" . addslashes($designation) . "')") or die(mysqli_error($con));
    $return_arr = array();
// get average
    $reqm = $con->query("select * from hp_categorie where codecategorie='" . addslashes($code) . "' ") or die(mysqli_error($con));
    while ($rowm = mysqli_fetch_array($reqm)) {
            $idmat = $rowm['idcategorie'];
            $des = $rowm['libellecategorie'];

//    $return_arr = array("iddetail" => $iddetail);
            $return_arr[] = array("idmat" => $idmat, "des" => $des);
    }
    echo json_encode($return_arr);
} else {
    echo "<script language='javascript'>alert('Informations invalides')</script>";
}
