<?php

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idcategorie"]);
    $reqp = $con->query("select * from hp_produit where idcategorie='" . $id . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nbp == 0)) {
        $con->query(" delete from hp_categorie where idcategorie='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalproduit/hopitalcategorie/lister_categorie';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer cette D.C.I. /PRINCIPE ACTIF car il y a des produits ou des examens !!!')</script>";
        $pagp = 'hopitalpages/hopitalproduit/hopitalcategorie/lister_categorie';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>