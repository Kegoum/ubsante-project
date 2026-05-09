<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idlaboratoire"]);

    $con->query(" update hp_laboratoire set etatlaboratoire=0 where idlaboratoire='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Examen Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/lister_laboratoire';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idlaboratoire"]);
    $con->query(" update hp_laboratoire set etatlaboratoire=1 where idlaboratoire='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Examen Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/lister_laboratoire';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idlaboratoire"]);
    $req = $con->query("select * from hp_affectation where idlaboratoire='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_laboratoire where idlaboratoire='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/lister_laboratoire';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce laboratoire car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/lister_laboratoire';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>