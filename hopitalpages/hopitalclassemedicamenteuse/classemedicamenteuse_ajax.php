<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idclassemedicamenteuse"]);
    $con->query(" update hp_classemedicamenteuse set etatclassemedicamenteuse=0 where idclassemedicamenteuse='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Matériaux Désactivé avec succes')</script>";
    $pagp = 'sotcocogpages/sotcocogclassemedicamenteuse/lister_classemedicamenteuse';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idclassemedicamenteuse"]);
    $con->query(" update hp_classemedicamenteuse set etatclassemedicamenteuse=1 where idclassemedicamenteuse='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Matériaux Activé avec succes')</script>";
    $pagp = 'sotcocogpages/sotcocogclassemedicamenteuse/lister_classemedicamenteuse';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

?>