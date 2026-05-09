<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idservice"]);

    $con->query(" update hp_service set etatservice=0 where idservice='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Service Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalservice/lister_service';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idservice"]);
    $con->query(" update hp_service set etatservice=1 where idservice='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Service Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalservice/lister_service';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
if (isset($_REQUEST["delocaliser"])) {
    $id = trim($_REQUEST["idservice"]);

    $con->query(" update hp_service set localservice=0 where idservice='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Service Délocalisé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalservice/lister_service';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["localiser"])) {
    $id = trim($_REQUEST["idservice"]);
    $con->query(" update hp_service set localservice=1 where idservice='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Service Localisé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalservice/lister_service';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idservice"]);
    $req = $con->query("select * from hp_affectation where idservice='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_service where idservice='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalservice/lister_service';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce service car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalservice/lister_service';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>