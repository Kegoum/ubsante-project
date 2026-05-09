<?php

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idmodepaiement"]);
    $req = $con->query("select * from hp_ligne_caisse where idmodepaiement='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_mode_paiement where idmodepaiement='" . $id . "' ") or die(mysqli_error($con));
        
    echo "<script language='javascript'>alert('Suppression terminée')</script>";
$pagp = 'hopitalpages/hopitalparametre/hopitalmodepaiement/lister_modepaiement';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {
    	
    echo "<script language='javascript'>alert('Impossible de surprimer ce mode de paiement car il y a des factures !!!')</script>";
$pagp = 'hopitalpages/hopitalparametre/hopitalmodepaiement/lister_modepaiement';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>