<?php

function update_proprietaire_profil($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_proprietaire limit 0,1") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req);
        $pa = $row["motdepasseproprietaire"];
        if ($reg["1"]['motdepasse'] != NULL) {
            $pa = sha1($reg["1"]['motdepasse']);
        }
        $reqp = $con->query("select * from hp_compte_personnel where logincomptepersonnel='" . $reg["1"]['logine'] . "' and "
                . "motdepassecomptepersonnel='" . $pa . "'") or die(mysqli_error($con));
        $nbp = mysqli_num_rows($reqp);
        if ($nbp == 0) {
            $log = NULL;
            if ($reg["1"]['photoe'] != NULL) {

// on va vérifier que la nouvelle proprietaire n'existe pas déja
                if (!is_dir("hopitalupload/logo/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("hopitalupload/logo/", 0777);
// on fait une vérification sur la création pour le retour à l'proprietaire
                    if (is_dir("hopitalupload/logo/")) {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['photoe']['tmp_name'], "hopitalupload/logo/" . basename($reg["1"]['photoe']['name']));

                        $log = $reg["1"]['photoe']['name'];
                    } else {
                        echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                        $pagp = 'hopitalpages/hopitalparametre/hopitalproprietaire/edit_proprietaire';
                        die('<meta http-equiv="refresh" content="6 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre proprietaire </br> Veuillez contacter votre administrateur</p>";
                    }
                } else {

// On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($reg["1"]['photoe']['tmp_name'], "hopitalupload/logo/" . basename($reg["1"]['photoe']['name']));

                    $log = $reg["1"]['photoe']['name'];
                }
            }

            if ($log != NULL) {
                $con->query("update hp_proprietaire set nomproprietaire='" . addslashes($reg["1"]['nome']) . "', typeproprietaire='" . addslashes($reg["1"]['typee']) . "', "
                                . "telephoneproprietaire='" . $reg["1"]['tele'] . "', bpproprietaire='" . $reg["1"]['bp'] . "', emailproprietaire='" . $reg["1"]['emaile'] . "', "
                                . "iddepartement='" . $reg["1"]['iddepartement'] . "', siteproprietaire='" . $reg["1"]['site'] . "', loginproprietaire='" . $reg["1"]['logine'] . "', "
                                . "motdepasseproprietaire='" . $pa . "', datecreationproprietaire='" . $reg["1"]['datecreation'] . "', textehopital='" . addslashes($reg["1"]['texte']) . "', adressehopital='" . addslashes($reg["1"]['adresse']) . "', "
                                . "sloganproprietaire='" . $reg["1"]['slogan'] . "', nocontribuableproprietaire='" . $reg["1"]['nocontribuable'] . "', "
                                . "hopitalproprietaire='" . addslashes($reg["1"]['hopital']) . "', logoproprietaire='" . $log . "'"
                                . " where idproprietaire='" . $row['idproprietaire'] . "'") or die(mysqli_error($con));
                $reqperpro = "select * from hp_departement as d left join hp_region as r on d.idregion=r.idregion "
                        . "where d.iddepartement='" . $reg["1"]['iddepartement'] . "'";
                $reperpro = $con->query($reqperpro) or die(mysqli_error($con));
                $enregpp = mysqli_fetch_assoc($reperpro);
                $_SESSION["nomproprietaire"] = addslashes($reg["1"]['nome']);
                $_SESSION["typeproprietaire"] = addslashes($reg["1"]['typee']);
                $_SESSION["telephoneproprietaire"] = $reg["1"]['tele'];
                $_SESSION["emailproprietaire"] = $reg["1"]['emaile'];
                $_SESSION["hopitalproprietaire"] = addslashes($reg["1"]['hopital']);
                $_SESSION["bpproprietaire"] = $reg["1"]['bp'];
                $_SESSION["logoproprietaire"] = $log;
                $_SESSION["datecreationproprietaire"] = $reg["1"]['datecreation'];
                $_SESSION["idregion"] = $enregpp["idregion"];
                $_SESSION["coderegion"] = $enregpp["coderegion"];
                $_SESSION["libelleregion"] = $enregpp["libelleregion"];
                $_SESSION["cheflieuregion"] = $enregpp["cheflieuregion"];
                $_SESSION["iddepartement"] = $enregpp["iddepartement"];
                $_SESSION["libelledepartement"] = $enregpp["libelledepartement"];
                $_SESSION["cheflieudepartement"] = $enregpp["cheflieudepartement"];
                $_SESSION["loginproprietaire"] = $reg["1"]['logine'];
                $_SESSION["motdepasseproprietaire"] = $pa;
            } else {
                $con->query("update hp_proprietaire set nomproprietaire='" . addslashes($reg["1"]['nome']) . "', typeproprietaire='" . addslashes($reg["1"]['typee']) . "', "
                                . "telephoneproprietaire='" . $reg["1"]['tele'] . "', bpproprietaire='" . $reg["1"]['bp'] . "', emailproprietaire='" . $reg["1"]['emaile'] . "', "
                                . "iddepartement='" . $reg["1"]['iddepartement'] . "', siteproprietaire='" . $reg["1"]['site'] . "', loginproprietaire='" . $reg["1"]['logine'] . "', "
                                . "motdepasseproprietaire='" . $pa . "', datecreationproprietaire='" . $reg["1"]['datecreation'] . "', textehopital='" . addslashes($reg["1"]['texte']) . "', adressehopital='" . addslashes($reg["1"]['adresse']) . "', "
                                . "sloganproprietaire='" . $reg["1"]['slogan'] . "', nocontribuableproprietaire='" . $reg["1"]['nocontribuable'] . "', "
                                . "hopitalproprietaire='" . addslashes($reg["1"]['hopital']) . "' "
                                . " where idproprietaire='" . $row['idproprietaire'] . "'") or die(mysqli_error($con));
                $reqperpro = "select * from hp_departement as d left join hp_region as r on d.idregion=r.idregion "
                        . "where d.iddepartement='" . $reg["1"]['iddepartement'] . "'";
                $reperpro = $con->query($reqperpro) or die(mysqli_error($con));
                $enregpp = mysqli_fetch_assoc($reperpro);
                $_SESSION["nomproprietaire"] = addslashes($reg["1"]['nome']);
                $_SESSION["typeproprietaire"] = addslashes($reg["1"]['typee']);
                $_SESSION["telephoneproprietaire"] = $reg["1"]['tele'];
                $_SESSION["emailproprietaire"] = $reg["1"]['emaile'];
                $_SESSION["hopitalproprietaire"] = addslashes($reg["1"]['hopital']);
                $_SESSION["bpproprietaire"] = $reg["1"]['bp'];
                $_SESSION["datecreationproprietaire"] = $reg["1"]['datecreation'];
                $_SESSION["idregion"] = $enregpp["idregion"];
                $_SESSION["coderegion"] = $enregpp["coderegion"];
                $_SESSION["libelleregion"] = $enregpp["libelleregion"];
                $_SESSION["cheflieuregion"] = $enregpp["cheflieuregion"];
                $_SESSION["iddepartement"] = $enregpp["iddepartement"];
                $_SESSION["libelledepartement"] = $enregpp["libelledepartement"];
                $_SESSION["cheflieudepartement"] = $enregpp["cheflieudepartement"];
                $_SESSION["loginproprietaire"] = $reg["1"]['logine'];
                $_SESSION["motdepasseproprietaire"] = $pa;
            }
            unset($_SESSION['formproprietaireep']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalproprietaire/edit_proprietaire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalproprietaire/edit_proprietaire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}
