<?php

session_start();

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

//$idd = $_POST['ma'];   // department id
//echo "<script language='javascript'>alert('slow')</script>";
$users_arr = array();
//$users_arr["Materiel"] = array();
$reqmo = $con->query("select * from hp_examen as gp where gp.etatexamen=true") or die(mysqli_error($con));

while ($rowm = mysqli_fetch_assoc($reqmo)) {
    $ide = $rowm['idexamen'];
    $libe = $rowm['nomexamen'];
    $type = $rowm['typeexamen'];
    $prix = $rowm['prixexamen'];

    $users_arr[] = array("ide" => $ide, "libe" => $libe, "type" => $type, "prix" => $prix);
}

// encoding array to json format
echo json_encode($users_arr);
