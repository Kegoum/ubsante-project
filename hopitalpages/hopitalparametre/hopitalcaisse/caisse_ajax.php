<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idcaisse"]);

    $con->query(" update hp_caisse set etatcaisse=0 where idcaisse='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Caisse Désactivée avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalcaisse/lister_caisse';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idcaisse"]);
    $con->query(" update hp_caisse set etatcaisse=1 where idcaisse='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Caisse Activée avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalcaisse/lister_caisse';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idcaisse"]);
    $req = $con->query("select * from hp_affectation where idcaisse='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_caisse where idcaisse='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalcaisse/lister_caisse';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce caisse car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalcaisse/lister_caisse';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>