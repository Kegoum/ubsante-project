<?php

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idcategoriechambre"]);
    
        $con->query("update hp_categorie_chambre set etatcategoriechambre=1 where idcategoriechambre='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Catégorie de Salle activée avec succès')</script>";
       $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/lister_categoriechambre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    
}

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idcategoriechambre"]);
    
        $con->query("update hp_categorie_chambre set etatcategoriechambre=0 where idcategoriechambre='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Catégorie de Salle désactivée avec succès')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/lister_categoriechambre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    
}

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idcategoriechambre"]);
    $req = $con->query("select * from hp_chambre where idcategoriechambre='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_categorie_chambre where idcategoriechambre='" . $id . "' ") or die(mysqli_error($con));
        
    echo "<script language='javascript'>alert('Suppression terminée')</script>";
$pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/lister_categoriechambre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {
    	
    echo "<script language='javascript'>alert('Impossible de surprimer cette Catégorie de Salle car il y a des Salles !!!')</script>";
$pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/lister_categoriechambre';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>