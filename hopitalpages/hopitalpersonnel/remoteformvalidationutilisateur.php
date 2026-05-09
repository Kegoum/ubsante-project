<?php

// This is a sample PHP script which demonstrates the 'remote' validator
// To make it work, point the web server to root Bootstrap Validate directory
// and open the remote.html file:


header('Content-type: application/json');


//sleep(5);
include('../../hopitalconnexion/connexion.php');

$valid = true;

$rsltpay = $con->query("SELECT * FROM hp_utilisateur ") or die(mysqli_error($con));
$utilisateurs = array();
$i = 0;
while ($rowpay = mysqli_fetch_array($rsltpay)) {
    $utilisateurs[$i]["id"] = $rowpay["iduser"];
    $utilisateurs[$i]["email"] = $rowpay["emailuser"];
    $utilisateurs[$i]["pass"] = $rowpay["passuser"];
    $i = $i + 1;
}

if (isset($_POST['email'])) {
    $code = $_POST['email'];
    $code2 = sha1($_POST['pass1']);
    foreach ($utilisateurs as $k => $v) {
        if (($code == $utilisateurs[$k]["email"]) && ($code2 == $utilisateurs[$k]["pass"])) {
            $valid = false;
            break;
        }
    }
} else if (isset($_POST['pass1'])) {
    $code = $_POST['email'];
    $code2 = sha1($_POST['pass1']);
    foreach ($utilisateurs as $k => $v) {
        if (($code == $utilisateurs[$k]["email"]) && ($code2 == $utilisateurs[$k]["pass"])) {
            $valid = false;
            break;
        }
    }
}


if (isset($_POST['emaile'])) {
    $id = $_POST['idutilisateur'];
    $code = $_POST['emaile'];
    $code2 = sha1($_POST['pass1e']);
    foreach ($utilisateurs as $k => $v) {
        if (($code == $utilisateurs[$k]["email"]) && ($code2 == $utilisateurs[$k]["pass"])) {
            if ($id != $utilisateurs[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
} else if (isset($_POST['pass1e'])) {
    $id = $_POST['idutilisateur'];
    $code = $_POST['emaile'];
    $code2 = sha1($_POST['pass1e']);
    foreach ($utilisateurs as $k => $v) {
        if (($code == $utilisateurs[$k]["email"]) && ($code2 == $utilisateurs[$k]["pass"])) {
            if ($id != $utilisateurs[$k]["id"]) {
                $valid = false;
                break;
            }
        }
    }
}

echo json_encode(array(
    'valid' => $valid,
));
