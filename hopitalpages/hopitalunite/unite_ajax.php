<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idconditionnement"]);
    $con->query(" update hp_conditionnement set etatconditionnement=0 where idconditionnement='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Matériaux Désactivé avec succes')</script>";
    $pagp = 'sotcocogpages/sotcocogconditionnement/lister_conditionnement';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idconditionnement"]);
    $con->query(" update hp_conditionnement set etatconditionnement=1 where idconditionnement='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Matériaux Activé avec succes')</script>";
    $pagp = 'sotcocogpages/sotcocogconditionnement/lister_conditionnement';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

?>