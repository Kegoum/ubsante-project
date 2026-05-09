<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idexamen"]);

    $con->query(" update hp_examen set etatexamen=0 where idexamen='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Examen Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalexamen/lister_examen';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idexamen"]);
    $con->query(" update hp_examen set etatexamen=1 where idexamen='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Examen Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalexamen/lister_examen';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idexamen"]);
    $req = $con->query("select * from hp_affectation where idexamen='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_examen where idexamen='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalexamen/lister_examen';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce examen car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalexamen/lister_examen';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>