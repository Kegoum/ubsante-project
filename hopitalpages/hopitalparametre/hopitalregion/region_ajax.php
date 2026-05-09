<?php

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idregion"]);
    $req = $con->query("select * from hp_departement where idregion='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_region where idregion='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalregion/lister_region';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer cette région car il y a des Départements !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalregion/lister_region';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>