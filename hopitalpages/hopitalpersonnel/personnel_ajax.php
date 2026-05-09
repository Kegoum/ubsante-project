<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idutilisateur"]);

    $con->query(" update hp_utilisateur set etatutilisateur=0 where idutilisateur='" . $id . "' ") or die(mysqli_error($con));
    $reqold = $con->query("select * from hp_utilisateur where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    $rowold = mysqli_fetch_assoc($reqold);
    $ancrole = $rowold["roleutilisateur"];
    if (($ancrole == "Administrateur")) {
        $con->query("update hp_administrateur set etatadministrateur=0 where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Maire de Ville")) {
        $con->query("update hp_maire_ville set etatmaireville=0 where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Maire de Commune")) {
        $con->query("update hp_maire_commune set etatmairecommune=0 where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Agent de Commune")) {
        $con->query("update hp_agent_commune set etatagentcommune=0 where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    }
    echo "<script language='javascript'>alert('Utilisateur Désactivé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalutilisateur/lister_utilisateur';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idutilisateur"]);
    $con->query(" update hp_utilisateur set etatutilisateur=1 where idutilisateur='" . $id . "' ") or die(mysqli_error($con));
    $reqold = $con->query("select * from hp_utilisateur where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    $rowold = mysqli_fetch_assoc($reqold);
    $ancrole = $rowold["roleutilisateur"];
    if (($ancrole == "Administrateur")) {
        $con->query("update hp_administrateur set etatadministrateur=1 where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Maire de Ville")) {
        $con->query("update hp_maire_ville set etatmaireville=1 where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Maire de Commune")) {
        $con->query("update hp_maire_commune set etatmairecommune=1 where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    } else if (($ancrole == "Agent de Commune")) {
        $con->query("update hp_agent_commune set etatagentcommune=1 where idutilisateur='" . $id . "'") or die(mysqli_error($con));
    }
    echo "<script language='javascript'>alert('Utilisateur Activé avec succes')</script>";
    $pagp = 'hopitalpages/hopitalutilisateur/lister_utilisateur';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}
?>