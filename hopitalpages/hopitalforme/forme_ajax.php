<?php

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idforme"]);
    $reqp = $con->query("select * from hp_produit where idforme='" . $id . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nbp == 0)) {
        $con->query(" delete from hp_forme where idforme='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalforme/lister_forme';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer cette forme car il y a des produits !!!')</script>";
        $pagp = 'hopitalpages/hopitalforme/lister_forme';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>