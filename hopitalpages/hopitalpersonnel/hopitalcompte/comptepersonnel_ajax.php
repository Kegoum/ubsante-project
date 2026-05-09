<?php

if (isset($_REQUEST["desactiverc"])) {
    $id = trim($_REQUEST["idcomptepersonnel"]);

    $con->query(" update hp_compte_personnel set etatcomptepersonnel=0 where idcomptepersonnel='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Compte personnel Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activerc"])) {
    $id = trim($_REQUEST["idcomptepersonnel"]);
    $con->query(" update hp_compte_personnel set etatcomptepersonnel=1 where idcomptepersonnel='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Compte personnel Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
?>