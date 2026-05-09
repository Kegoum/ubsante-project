<?php

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["iddepartement"]);
    $req = $con->query("select * from hp_proprietaire where iddepartement='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    
    if (($nb == 0)) {
        $con->query(" delete from hp_departement where iddepartement='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitaldepartement/lister_departement';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce Département car il y a des proprietaires !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitaldepartement/lister_departement';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>