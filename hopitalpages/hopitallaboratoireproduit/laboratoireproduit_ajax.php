<?php

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idlaboratoireproduit"]);
    $reqp = $con->query("select * from hp_produit where idlaboratoireproduit='" . $id . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nbp == 0)) {
        $con->query(" delete from hp_laboratoire_produit where idlaboratoireproduit='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitallaboratoireproduit/lister_laboratoireproduit';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce Laboratoire car il y a des produits !!!')</script>";
        $pagp = 'hopitalpages/hopitallaboratoireproduit/lister_laboratoireproduit';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>