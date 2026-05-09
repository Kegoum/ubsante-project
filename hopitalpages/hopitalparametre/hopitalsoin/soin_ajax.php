<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idsoin"]);

    $con->query(" update hp_soin set etatsoin=0 where idsoin='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Soin Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalsoin/lister_soin';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idsoin"]);
    $con->query(" update hp_soin set etatsoin=1 where idsoin='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Soin Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalsoin/lister_soin';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idsoin"]);
    $req = $con->query("select * from hp_affectation where idsoin='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_soin where idsoin='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalsoin/lister_soin';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce soin car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalsoin/lister_soin';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>