<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idechographie"]);

    $con->query(" update hp_echographie set etatechographie=0 where idechographie='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Echographie Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalechographie/lister_echographie';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idechographie"]);
    $con->query(" update hp_echographie set etatechographie=1 where idechographie='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Echographie Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalechographie/lister_echographie';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idechographie"]);
    $req = $con->query("select * from hp_affectation where idechographie='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_echographie where idechographie='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalechographie/lister_echographie';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce echographie car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalechographie/lister_echographie';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>