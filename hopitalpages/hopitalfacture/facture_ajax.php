<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idmagasin"]);

    $con->query(" update hp_magasin set etatmagasin=0 where idmagasin='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Magasin Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalmagasin/lister_magasin';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idmagasin"]);
    $con->query(" update hp_magasin set etatmagasin=1 where idmagasin='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Magasin Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalmagasin/lister_magasin';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idmagasin"]);
    $req = $con->query("select * from hp_affectation where idmagasin='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_magasin where idmagasin='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalmagasin/lister_magasin';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce magasin car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalmagasin/lister_magasin';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>