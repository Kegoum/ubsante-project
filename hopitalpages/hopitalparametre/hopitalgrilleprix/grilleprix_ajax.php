<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idgrilleprix"]);

    $con->query(" update hp_grille_prix set etatgrilleprix=0 where idgrilleprix='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Prix Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalgrilleprix/lister_grilleprix';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idgrilleprix"]);
    $con->query(" update hp_grille_prix set etatgrilleprix=1 where idgrilleprix='" . $id . "' ") or die(mysqli_error($con));
    
    echo "<script language='javascript'>alert('Prix Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalgrilleprix/lister_grilleprix';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idgrilleprix"]);
    $req = $con->query("select * from hp_affectation where idgrilleprix='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_grille_prix where idgrilleprix='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalgrilleprix/lister_grilleprix';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce grilleprix car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalgrilleprix/lister_grilleprix';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>