<?php

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["iddosage"]);
    $reqp = $con->query("select * from hp_produit where iddosage='" . $id . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nbp == 0)) {
        $con->query(" delete from hp_dosage where iddosage='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitaldosage/lister_dosage';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce dosage car il y a des produits !!!')</script>";
        $pagp = 'hopitalpages/hopitaldosage/lister_dosage';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>