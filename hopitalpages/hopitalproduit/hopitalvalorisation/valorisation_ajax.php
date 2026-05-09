<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idvalorisationstock"]);
    $con->query(" update hp_valorisation_stock set etatvalorisationstock=0 where idvalorisationstock='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Valorisation Désactivée avec succes')</script>";
    $pagp = 'hopitalpages/hopitalproduit/hopitalvalorisation/lister_valorisation';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idvalorisationstock"]);
    $con->query(" update hp_valorisation_stock set etatvalorisationstock=1 where idvalorisationstock='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Valorisation Activée avec succes')</script>";
    $pagp = 'hopitalpages/hopitalproduit/hopitalvalorisation/lister_valorisation';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

?>