<?php

session_start();

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

//echo "<script language='javascript'>alert('slow')</script>";
$users_arr = array();
//$users_arr["Materiel"] = array();
$reqmo = $con->query("select * from hp_produit where etatproduit=true order by "
        . "libelleproduit asc") or die(mysqli_error($con));

while ($rowm = mysqli_fetch_assoc($reqmo)) {
    $ide = $rowm['idproduit'];
    $code = $rowm['codeproduit'];
    $libe = $rowm['libelleproduit'];

    $users_arr[] = array("ide" => $ide, "code" => $code, "libe" => $libe);
}

// encoding array to json format
echo json_encode($users_arr);
