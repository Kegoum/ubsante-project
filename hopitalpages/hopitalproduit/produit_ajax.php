<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idproduit"]);

    $con->query(" update hp_produit set etatproduit=0 where idproduit='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Produit Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalproduit/lister_produit';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idproduit"]);
    $con->query(" update hp_produit set etatproduit=1 where idproduit='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Produit Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalproduit/lister_produit';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idproduit"]);
    $req = $con->query("select * from hp_boutique where idproduit='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $req = $con->query("select * from hp_conversion where idproduit='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $req = $con->query("select * from hp_ligne_bon_commande where idproduit='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $req = $con->query("select * from hp_ligne_bon_commande_interne where idproduit='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $req = $con->query("select * from hp_ligne_bon_livraison where idproduit='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $req = $con->query("select * from hp_ligne_bon_livraison_interne where idproduit='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $req = $con->query("select * from hp_ligne_ordonnance where idproduit='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $reqpa = $con->query("select * from hp_produit_avarie where idproduit='" . $id . "'") or die(mysqli_error($con));
    $nbpa = mysqli_num_rows($reqpa);
    if (($nb == 0)) {
        $con->query(" delete from hp_produit where idproduit='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalproduit/lister_produit';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce produit car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalproduit/lister_produit';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>