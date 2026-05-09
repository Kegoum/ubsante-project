<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idparametre"]);

    $con->query(" update hp_parametre set etatparametre=0 where idparametre='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Paramètre Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalparametre/lister_parametre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idparametre"]);
    $con->query(" update hp_parametre set etatparametre=1 where idparametre='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Paramètre Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalparametre/lister_parametre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idparametre"]);
    $req = $con->query("select * from hp_affectation where idparametre='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_parametre where idparametre='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalparametre/lister_parametre';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce parametre car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalparametre/lister_parametre';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>