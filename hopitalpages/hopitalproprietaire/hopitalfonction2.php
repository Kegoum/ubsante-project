<?php

function update_proprietaire_profil($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $nomp = addslashes($reg["1"]['nome']);
        $prenomp = addslashes($reg["1"]['prenome']);
        $telp = ($reg["1"]['tele']);
        $login = ($reg["1"]['logine']);

        $reqpe = $con->query("select * from hp_proprietaire where idproprietaire= '" . $_SESSION["idproprietaire"] . "' ") or die(mysqli_error($con));
        $rowpe = mysqli_fetch_assoc($reqpe);
        $motdepasse1 = $rowpe["motdepasseproprietaire"];
        if ($reg["1"]['pass1e'] != NULL) {
            $motdepasse1 = sha1($reg["1"]['pass1e']);
        }
        $req = $con->query("select * from hp_compte_proprietaire where logincompteproprietaire= '" . $login . "' and motdepassecompteproprietaire= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $reqp = $con->query("select * from hp_proprietaire where loginproprietaire= '" . $login . "' and motdepasseproprietaire= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
            $nbp = mysqli_num_rows($reqp);
            if (($nbp == 0)) {
                $con->query("update hp_proprietaire set nomproprietaire='" . $nomp . "', telephoneproprietaire='" . $reg["1"]['tele'] . "', "
                                . "emailproprietaire='" . $reg["1"]['email'] . "', sitephoneproprietaire='" . $reg["1"]['site'] . "', "
                                . "bpproprietaire='" . $reg["1"]['bp'] . "', hopitalproprietaire='" . $reg["1"]['hopital'] . "', "
                                . "nomproprietaire='" . $reg["1"]['tele'] . "', telephoneproprietaire='" . $reg["1"]['tele'] . "', "
                                . "nomproprietaire='" . $reg["1"]['tele'] . "', telephoneproprietaire='" . $reg["1"]['tele'] . "', "
                                . "nomproprietaire='" . $reg["1"]['tele'] . "', telephoneproprietaire='" . $reg["1"]['tele'] . "' "
                                . "where idproprietaire='" . $rowpe["idproprietaire"] . "'") or die(mysqli_error($con));
                $con->query("update hp_compte_proprietaire set logincompteproprietaire='" . $reg["1"]['logine'] . "', motdepassecompteproprietaire='" . $motdepasse1 . "' "
                                . " where idcompteproprietaire='" . $reg["1"]['idcompteproprietaire'] . "'") or die(mysqli_error($con));
                $_SESSION["nomproprietaire"] = $nomp;
                $_SESSION["prenomproprietaire"] = $prenomp;
                $_SESSION["telephoneproprietaire"] = $reg["1"]['tele'];
                $_SESSION["logincompteproprietaire"] = $reg["1"]['logine'];
                $_SESSION["motdepassecompteproprietaire"] = $motdepasse1;

                unset($_SESSION['formproprietaireep']);
                echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalproprietaire/info_user';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                $rowv = mysqli_fetch_assoc($reqp);
                if ($rowv["idcompteproprietaire"] == $reg["1"]["idcompteproprietaire"]) {
                    $con->query("update hp_proprietaire set nomproprietaire='" . $nomp . "', prenomproprietaire='" . $prenomp . "', telephoneproprietaire='" . $reg["1"]['tele'] . "' "
                                . "where idproprietaire='" . $rowpe["idproprietaire"] . "'") or die(mysqli_error($con));
                $con->query("update hp_compte_proprietaire set logincompteproprietaire='" . $reg["1"]['logine'] . "', motdepassecompteproprietaire='" . $motdepasse1 . "' "
                                . " where idcompteproprietaire='" . $reg["1"]['idcompteproprietaire'] . "'") or die(mysqli_error($con));
                $_SESSION["nomproprietaire"] = $nomp;
                $_SESSION["prenomproprietaire"] = $prenomp;
                $_SESSION["telephoneproprietaire"] = $reg["1"]['tele'];
                $_SESSION["logincompteproprietaire"] = $reg["1"]['logine'];
                $_SESSION["motdepassecompteproprietaire"] = $motdepasse1;
                
                    unset($_SESSION['formproprietaireep']);
                    echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
                    $pagp = 'hopitalpages/hopitalproprietaire/info_user';

                    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page= $pagp ">');
                } else {
                    echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                    $pagp = 'hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire';
                    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idcompteproprietaire=' . $reg["1"]["idcompteproprietaire"] . '">');
                }
            }
        }
    }
}
