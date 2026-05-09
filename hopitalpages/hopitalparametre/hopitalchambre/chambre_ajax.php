<?php

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idchambre"]);
    $con->query("update hp_chambre set etatchambre=1 where idchambre='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Salle Libérée avec succès')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/lister_chambre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idchambre"]);
    $con->query("update hp_chambre set etatchambre=0 where idchambre='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Salle désactivée avec succès')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/lister_chambre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idchambre"]);
    $req = $con->query("select * from hp_specialite where idchambre='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_chambre where idchambre='" . $id . "' ") or die(mysqli_error($con));
        
    echo "<script language='javascript'>alert('Suppression terminée')</script>";
$pagp = 'hopitalpages/hopitalparametre/hopitalchambre/lister_chambre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {
    	
    echo "<script language='javascript'>alert('Impossible de surprimer cette filière car il y a des Specialites !!!')</script>";
$pagp = 'hopitalpages/hopitalparametre/hopitalchambre/lister_chambre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>