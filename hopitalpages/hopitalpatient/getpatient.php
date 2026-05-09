<?php

session_start();

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$ma = $_POST['ma'];   // department id
//echo "<script language='javascript'>alert('slow')</script>";
$users_arr = array();
//$users_arr["Materiel"] = array();

$reqmo = $con->query("select * from hp_patient as e join hp_departement as d on e.residencepatient=d.iddepartement left "
        . "join hp_region as r on d.idregion=r.idregion where (e.idpatient='" . $ma . "')") or die(mysqli_error($con));
$nbm = mysqli_num_rows($reqmo);
if ($nbm != 0) {
    while ($rowm = mysqli_fetch_assoc($reqmo)) {

        $ide = $rowm['idpatient'];
        $code = $rowm['codepatient'];
        $nom = $rowm['nompatient'];
        $prenom = $rowm['prenompatient'];
        $tel = $rowm['telephonepatient'];
        $telpac = $rowm['telephonepacpatient'];
        $daten = $rowm['datenaissancepatient'];
        $lieun = $rowm['lieunaissancepatient'];
        $regid = $rowm['idregion'];
        $depid = $rowm['iddepartement'];
        $reg = $rowm['libelleregion'];
        $dep = $rowm['libelledepartement'];
        $sex = $rowm['sexepatient'];
        $prof = $rowm['professionpatient'];
        $sitmat = $rowm['situationmatrimonialepatient'];

        $users_arr[] = array("ide" => $ide, "code" => $code, "nom" => $nom, "prenom" => $prenom, "tel" => $tel, "telpac" => $telpac,
            "daten" => $daten, "lieun" => $lieun, "regid" => $regid, "reg" => $reg, "depid" => $depid,
            "dep" => $dep, "sex" => $sex, "prof" => $prof, "sitmat" => $sitmat);
    }
} else {
    $ide = NULL;
    $code = NULL;
    $nom = NULL;
    $prenom = NULL;
    $tel = NULL;
    $telpac = NULL;
    $daten = NULL;
    $lieun = NULL;
    $regid = NULL;
    $depid = NULL;
    $reg = NULL;
    $dep = NULL;
    $sex = NULL;
    $prof = NULL;
    $sitmat = NULL;

    $users_arr[] = array("ide" => $ide, "code" => $code, "nom" => $nom, "prenom" => $prenom, "tel" => $tel, "telpac" => $telpac,
        "daten" => $daten, "lieun" => $lieun, "regid" => $regid, "reg" => $reg, "depid" => $depid,
        "dep" => $dep, "sex" => $sex, "prof" => $prof, "sitmat" => $sitmat);
}

// encoding array to json format
echo json_encode($users_arr);
