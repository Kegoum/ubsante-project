<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idlignenfs"]);

    $con->query(" update hp_ligne_nfs set etatlignenfs=0 where idlignenfs='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Paramètre Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitallignenfs/lister_lignenfs';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idlignenfs"]);
    $con->query(" update hp_ligne_nfs set etatlignenfs=1 where idlignenfs='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Paramètre Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitallignenfs/lister_lignenfs';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idlignenfs"]);
    $req = $con->query("select * from hp_affectation where idlignenfs='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_ligne_nfs where idlignenfs='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitallignenfs/lister_lignenfs';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce lignenfs car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitallignenfs/lister_lignenfs';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>