<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idacte"]);

    $con->query(" update hp_acte set etatacte=0 where idacte='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Acte Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalacte/lister_acte';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idacte"]);
    $con->query(" update hp_acte set etatacte=1 where idacte='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Acte Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalacte/lister_acte';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idacte"]);
    $req = $con->query("select * from hp_acte_patient where idacte='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $reqc = $con->query("select * from hp_consultation where idacte='" . $id . "'") or die(mysqli_error($con));
    $nbc = mysqli_num_rows($reqc);
    if (($nb == 0)) {
        $con->query(" delete from hp_acte where idacte='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalacte/lister_acte';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer cet Acte car il y a des pateints !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalacte/lister_acte';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>