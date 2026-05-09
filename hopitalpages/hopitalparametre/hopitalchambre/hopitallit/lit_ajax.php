<?php

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idlit"]);
    $req = $con->query("select * from hp_lit as l left join hp_chambre as c on l.idchambre=c.idchambre "
            . "where l.idlit='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $con->query("update hp_lit set etatlit=1 where idlit='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Lit de Salle activé avec succès')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idchambre=' . $row["idchambre"] . '">');
}

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idlit"]);
    $req = $con->query("select * from hp_lit as l left join hp_chambre as c on l.idchambre=c.idchambre "
            . "where l.idlit='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $con->query("update hp_lit set etatlit=0 where idlit='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Lit de Salle désactivé avec succès')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idchambre=' . $row["idchambre"] . '">');
}

if (isset($_REQUEST["liberer"])) {
    $id = trim($_REQUEST["idlit"]);
    $req = $con->query("select * from hp_lit as l left join hp_chambre as c on l.idchambre=c.idchambre "
            . "where l.idlit='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $con->query("update hp_lit set statutlit=1 where idlit='" . $id . "' ") or die(mysqli_error($con));
    $con->query("update hp_chambre set etatchambre=1 where idchambre='" . $row["idchambre"] . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Lit de Salle liberée avec succès')</script>";
    $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idchambre=' . $row["idchambre"] . '">');
}

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idlit"]);
    $req = $con->query("select * from hp_lit_chambre where idlit='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_lit where idlit='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce Lit de Salle car il y a des Salles !!!')</script>";
        $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>