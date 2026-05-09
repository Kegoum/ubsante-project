<?php

session_start();

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../../hopitalconnexion/connexion.php');

$idd = $_POST['idaf'];   // department id
$typ = "Normal";
//echo "<script language='javascript'>alert('slow')</script>";

$users_arr = array();

$rsltm = $con->query("select * from hp_pointage as c left join hp_affectation as eg on c.idaffectation=eg.idaffectation "
        . "where c.idaffectation='" . $idd . "' and c.typepointage='" . $typ . "' and c.etatpointage=true and c.payepointage=false ") or die(mysqli_error($con));

while ($rowm = mysqli_fetch_assoc($rsltm)) {
    
    $idmo = $rowm['idpointage'];
    $lib = $rowm['datejourpointage'];
    $hdeb = $rowm['heuredebutpointage'];
    $hfin = $rowm['heurefinpointage'];

    $users_arr[] = array("idmo" => $idmo, "lib" => $lib, "hdeb" => $hdeb, "hfin" => $hfin);
}
// encoding array to json format
echo json_encode($users_arr);
