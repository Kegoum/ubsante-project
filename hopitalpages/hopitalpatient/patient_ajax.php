<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idhopital"]);

    $con->query(" update hp_hopital set etathopital=0 where idhopital='" . $id . "' ") or die(mysqli_error($con));
    $reqold = $con->query("select * from hp_hopital where idhopital='" . $id . "'") or die(mysqli_error($con));
    $rowold = mysqli_fetch_assoc($reqold);
    $ancrole = $rowold["rolehopital"];
    if (($ancrole == "Administrateur")) {
        $con->query("update hp_administrateur set etatadministrateur=0 where idhopital='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Maire de Ville")) {
        $con->query("update hp_maire_ville set etatmaireville=0 where idhopital='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Maire de Commune")) {
        $con->query("update hp_maire_commune set etatmairecommune=0 where idhopital='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Agent de Commune")) {
        $con->query("update hp_agent_commune set etatagentcommune=0 where idhopital='" . $id . "'") or die(mysqli_error($con));
    }
    echo "<script language='javascript'>alert('Utilisateur Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalhopital/lister_hopital';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idhopital"]);
    $con->query(" update hp_hopital set etathopital=1 where idhopital='" . $id . "' ") or die(mysqli_error($con));
    $reqold = $con->query("select * from hp_hopital where idhopital='" . $id . "'") or die(mysqli_error($con));
    $rowold = mysqli_fetch_assoc($reqold);
    $ancrole = $rowold["rolehopital"];
    if (($ancrole == "Administrateur")) {
        $con->query("update hp_administrateur set etatadministrateur=1 where idhopital='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Maire de Ville")) {
        $con->query("update hp_maire_ville set etatmaireville=1 where idhopital='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Maire de Commune")) {
        $con->query("update hp_maire_commune set etatmairecommune=1 where idhopital='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Agent de Commune")) {
        $con->query("update hp_agent_commune set etatagentcommune=1 where idhopital='" . $id . "'") or die(mysqli_error($con));
    }
    echo "<script language='javascript'>alert('Utilisateur Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalhopital/lister_hopital';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
?>