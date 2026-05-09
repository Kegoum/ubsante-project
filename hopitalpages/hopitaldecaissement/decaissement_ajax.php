<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["iddecaissement"]);
    $con->query(" update hp_decaissement set etatdecaissement=0 where iddecaissement='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Décaissement Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalbudget/hopitaldecaissement/lister_decaissement';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["iddecaissement"]);
    $con->query(" update hp_decaissement set etatdecaissement=1 where iddecaissement='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Décaissement Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalbudget/hopitaldecaissement/lister_decaissement';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

?>