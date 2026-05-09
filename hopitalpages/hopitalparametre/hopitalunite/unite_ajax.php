<?php

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idunite"]);
    $req = $con->query("select * from hp_examen where idunite='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $reqp = $con->query("select * from hp_produit where idunite='" . $id . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nb == 0) && ($nbp == 0)) {
        $con->query(" delete from hp_unite where idunite='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalunite/lister_unite';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer cette unité car il y a des produits ou des examens !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalunite/lister_unite';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>