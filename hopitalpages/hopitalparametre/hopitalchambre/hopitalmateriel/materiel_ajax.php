<?php

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idmateriel"]);
    
        $con->query("update hp_materiel set etatmateriel=1 where idmateriel='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Matériel de Salle activée avec succès')</script>";
       $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/lister_materiel';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    
}

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idmateriel"]);
    
        $con->query("update hp_materiel set etatmateriel=0 where idmateriel='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Matériel de Salle désactivée avec succès')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/lister_materiel';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    
}

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idmateriel"]);
    $req = $con->query("select * from hp_materiel_chambre where idmateriel='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_materiel where idmateriel='" . $id . "' ") or die(mysqli_error($con));
        
    echo "<script language='javascript'>alert('Suppression terminée')</script>";
$pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/lister_materiel';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {
    	
    echo "<script language='javascript'>alert('Impossible de surprimer ce Matériel de Salle car il y a des Salles !!!')</script>";
$pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/lister_materiel';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>