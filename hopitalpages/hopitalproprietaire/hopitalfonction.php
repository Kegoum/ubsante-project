<?php

//parametre de l'proprietaire
function update_proprietaire_old($id, $nom1, $tell, $emaill, $site1, $bp1, $login, $pass1, $hopital1, $creation, $type, $slogan1, $nocontribuable, $texte1, $adresse1, $logoa, $logon, $filigranea4pa, $filigranea4pn, $filigranea4la, $filigranea4ln, $filigranea5pa, $filigranea5pn, $filigranea5la, $filigranea5ln, $con) {

    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $nom = addslashes($nom1);
    $tel = addslashes($tell);
    $email = addslashes($emaill);
    $site = addslashes($site1);
    $bp = addslashes($bp1);
    $hopital = addslashes($hopital1);
    $slogan = addslashes($slogan1);
    $texte = addslashes($texte1);
    $adresse = addslashes($adresse1);
    $motdepasse1 = NULL;
    $reqpe = $con->query("select * from hp_proprietaire where idproprietaire= '" . $_SESSION["idproprietaire"] . "' ") or die(mysqli_error($con));
    $rowpe = mysqli_fetch_assoc($reqpe);
    $motdepasse1 = $rowpe["motdepasseproprietaire"];
    if ($pass1 != NULL) {
        $motdepasse1 = sha1($pass1);
    }
    $reqp = $con->query("select * from hp_compte_personnel where logincomptepersonnel= '" . $login . "' and motdepassecomptepersonnel= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nbp == 0)) {
        $req = $con->query("select * from hp_proprietaire where loginproprietaire= '" . $login . "' and motdepasseproprietaire= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {

            if ($logon != NULL) {
                if ($logoa != NULL) {
                    unlink("hopitalupload/logo/" . $logoa);
                }
                move_uploaded_file($_FILES['logon']['tmp_name'], "hopitalupload/logo/" . basename($_FILES['logon']['name']));
            } else {
                move_uploaded_file($_FILES['logon']['tmp_name'], "hopitalupload/logo/" . basename($_FILES['logon']['name']));
            }

            if ($filigranea4pn != NULL) {
                if ($filigranea4pa != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea4pa);
                }
                move_uploaded_file($_FILES['filigranea4pn']['tmp_name'], "hopitalupload/logo/filigranea4p.png");

                $filigranea4pn = "filigranea4p.png";
            } else {
                $filigranea4pn = $filigranea4pa;
            }
            if ($filigranea4ln != NULL) {
                if ($filigranea4la != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea4la);
                }
                move_uploaded_file($_FILES['filigranea4ln']['tmp_name'], "hopitalupload/logo/filigranea4l.png");

                $filigranea4ln = "filigranea4l.png";
            } else {
                $filigranea4ln = $filigranea4la;
            }
            if ($filigranea5pn != NULL) {
                if ($filigranea5pa != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea5pa);
                }
                move_uploaded_file($_FILES['filigranea5pn']['tmp_name'], "hopitalupload/logo/filigranea5p.png");

                $filigranea5pn = "filigranea5p.png";
            } else {
                $filigranea5pn = $filigranea5pa;
            }
            if ($filigranea5ln != NULL) {
                if ($filigranea5la != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea5la);
                }
                move_uploaded_file($_FILES['filigranea5ln']['tmp_name'], "hopitalupload/logo/filigranea5l.png");

                $filigranea5ln = "filigranea5l.png";
            } else {
                $filigranea5ln = $filigranea5la;
            }
            $logon = $_FILES['logon']['name'];
            $rslt = $con->query("update hp_proprietaire set loginproprietaire='" . $login . "', "
                    . "motdepasseproprietaire='" . $motdepasse1 . "', nomproprietaire='" . $nom . "', "
                    . "telephoneproprietaire='" . $tel . "', emailproprietaire='" . $email . "', siteproprietaire='" . $site . "', "
                    . "bpproprietaire='" . $bp . "', hopitalproprietaire='" . $hopital . "', datecreationproprietaire='" . $creation . "', "
                    . "typeproprietaire='" . $type . "', sloganproprietaire='" . $slogan . "', "
                    . "nocontribuableproprietaire='" . $nocontribuable . "', texteproprietaire='" . $texte . "', "
                    . "adresseproprietaire='" . $adresse . "', logoproprietaire='" . $logon . "', filigranea4p='" . $filigranea4pn . "', "
                    . "filigranea4l='" . $filigranea4ln . "', "
                    . "filigranea5p='" . $filigranea5pn . "', filigranea5l='" . $filigranea5ln . "' where "
                    . "idproprietaire='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalproprietaire/proprietaire';
            die('<meta http-equiv="refresh" content="6 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
//echo "bon";
        } else {
            $row = mysqli_fetch_assoc($req);
            if ($row["idproprietaire"] == $id) {
                
            if ($logon != NULL) {
                if ($logoa != NULL) {
                    unlink("hopitalupload/logo/" . $logoa);
                }
                move_uploaded_file($_FILES['logon']['tmp_name'], "hopitalupload/logo/" . basename($_FILES['logon']['name']));
            } else {
                move_uploaded_file($_FILES['logon']['tmp_name'], "hopitalupload/logo/" . basename($_FILES['logon']['name']));
            }

            if ($filigranea4pn != NULL) {
                if ($filigranea4pa != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea4pa);
                }
                move_uploaded_file($_FILES['filigranea4pn']['tmp_name'], "hopitalupload/logo/filigranea4p.png");

                $filigranea4pn = "filigranea4p.png";
            } else {
                $filigranea4pn = $filigranea4pa;
            }
            if ($filigranea4ln != NULL) {
                if ($filigranea4la != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea4la);
                }
                move_uploaded_file($_FILES['filigranea4ln']['tmp_name'], "hopitalupload/logo/filigranea4l.png");

                $filigranea4ln = "filigranea4l.png";
            } else {
                $filigranea4ln = $filigranea4la;
            }
            if ($filigranea5pn != NULL) {
                if ($filigranea5pa != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea5pa);
                }
                move_uploaded_file($_FILES['filigranea5pn']['tmp_name'], "hopitalupload/logo/filigranea5p.png");

                $filigranea5pn = "filigranea5p.png";
            } else {
                $filigranea5pn = $filigranea5pa;
            }
            if ($filigranea5ln != NULL) {
                if ($filigranea5la != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea5la);
                }
                move_uploaded_file($_FILES['filigranea5ln']['tmp_name'], "hopitalupload/logo/filigranea5l.png");

                $filigranea5ln = "filigranea5l.png";
            } else {
                $filigranea5ln = $filigranea5la;
            }
            $logon = $_FILES['logon']['name'];
            $rslt = $con->query("update hp_proprietaire set loginproprietaire='" . $login . "', "
                    . "motdepasseproprietaire='" . $motdepasse1 . "', nomproprietaire='" . $nom . "', "
                    . "telephoneproprietaire='" . $tel . "', emailproprietaire='" . $email . "', siteproprietaire='" . $site . "', "
                    . "bpproprietaire='" . $bp . "', hopitalproprietaire='" . $hopital . "', datecreationproprietaire='" . $creation . "', "
                    . "typeproprietaire='" . $type . "', sloganproprietaire='" . $slogan . "', "
                    . "nocontribuableproprietaire='" . $nocontribuable . "', texteproprietaire='" . $texte . "', "
                    . "adresseproprietaire='" . $adresse . "', logoproprietaire='" . $logon . "', filigranea4p='" . $filigranea4pn . "', "
                    . "filigranea4l='" . $filigranea4ln . "', "
                    . "filigranea5p='" . $filigranea5pn . "', filigranea5l='" . $filigranea5ln . "' where "
                    . "idproprietaire='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalproprietaire/proprietaire';
            die('<meta http-equiv="refresh" content="6 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalproprietaire/proprietaire';
                die('<meta http-equiv="refresh" content="6 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            }
        }
    } else {
        echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalproprietaire/proprietaire';
        die('<meta http-equiv="refresh" content="6 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}

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
            
    
            $logon=$reg["1"]['photoe'];
            $filigranea4pn=$reg["1"]['filigranea4pn'];
            $filigranea4ln=$reg["1"]['filigranea4ln'];
            $filigranea5pn=$reg["1"]['filigranea5pn'];
            $filigranea5ln=$reg["1"]['filigranea5ln'];
            $logoa=$reg["1"]['photostring'];
            $filigranea4pa=$reg["1"]['filigranea4pa'];
            $filigranea4la=$reg["1"]['filigranea4la'];
            $filigranea5pa=$reg["1"]['filigranea5pa'];
            $filigranea5la=$reg["1"]['filigranea5la'];
            if ($logon != NULL) {
                if ($logoa != NULL) {
                    unlink("hopitalupload/logo/" . $logoa);
                }
               
// on va vérifier que la nouvelle proprietaire n'existe pas déja
                if (!is_dir("hopitalupload/logo/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("hopitalupload/logo/", 0777);
// on fait une vérification sur la création pour le retour à l'proprietaire
                    if (is_dir("hopitalupload/logo/")) {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['photoe']['tmp_name'], "hopitalupload/logo/" . basename($reg["1"]['photoe']['name']));

                        $logon = $reg["1"]['photoe']['name'];
                    } else {
                        echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                            $pagp = 'hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idproprietaire='.$reg["1"]["idproprietaire"].'">');
        
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre proprietaire </br> Veuillez contacter votre administrateur</p>";
                    }
                } else {

// On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($reg["1"]['photoe']['tmp_name'], "hopitalupload/logo/" . basename($reg["1"]['photoe']['name']));

                    $logon = $reg["1"]['photoe']['name'];
                }
            }else{
                $logon=$logoa;
            }

            if ($filigranea4pn != NULL) {
                if ($filigranea4pa != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea4pa);
                }
                
// on va vérifier que la nouvelle proprietaire n'existe pas déja
                if (!is_dir("hopitalupload/logo/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("hopitalupload/logo/", 0777);
// on fait une vérification sur la création pour le retour à l'proprietaire
                    if (is_dir("hopitalupload/logo/")) {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['filigranea4pn']['tmp_name'], "hopitalupload/logo/filigranea4p.png");

                    } else {
                        echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                            $pagp = 'hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idproprietaire='.$reg["1"]["idproprietaire"].'">');
        
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre proprietaire </br> Veuillez contacter votre administrateur</p>";
                    }
                } else {

// On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($reg["1"]['filigranea4pn']['tmp_name'], "hopitalupload/logo/filigranea4p.png");

                }
                $filigranea4pn = "filigranea4p.png";
            } else {
                $filigranea4pn = $filigranea4pa;
            }
            if ($filigranea4ln != NULL) {
                if ($filigranea4la != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea4la);
                }
               
// on va vérifier que la nouvelle proprietaire n'existe pas déja
                if (!is_dir("hopitalupload/logo/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("hopitalupload/logo/", 0777);
// on fait une vérification sur la création pour le retour à l'proprietaire
                    if (is_dir("hopitalupload/logo/")) {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['filigranea4ln']['tmp_name'], "hopitalupload/logo/filigranea4l.png");

                    } else {
                        echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                            $pagp = 'hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idproprietaire='.$reg["1"]["idproprietaire"].'">');
        
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre proprietaire </br> Veuillez contacter votre administrateur</p>";
                    }
                } else {

// On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($reg["1"]['filigranea4ln']['tmp_name'], "hopitalupload/logo/filigranea4l.png");

                }
                $filigranea4ln = "filigranea4l.png";
            } else {
                $filigranea4ln = $filigranea4la;
            }
            if ($filigranea5pn != NULL) {
                if ($filigranea5pa != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea5pa);
                }
                
// on va vérifier que la nouvelle proprietaire n'existe pas déja
                if (!is_dir("hopitalupload/logo/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("hopitalupload/logo/", 0777);
// on fait une vérification sur la création pour le retour à l'proprietaire
                    if (is_dir("hopitalupload/logo/")) {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['filigranea5pn']['tmp_name'], "hopitalupload/logo/filigranea5p.png");

                    } else {
                        echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                            $pagp = 'hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idproprietaire='.$reg["1"]["idproprietaire"].'">');
        
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre proprietaire </br> Veuillez contacter votre administrateur</p>";
                    }
                } else {

// On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($reg["1"]['filigranea5pn']['tmp_name'], "hopitalupload/logo/filigranea5p.png");

                }
                $filigranea5pn = "filigranea5p.png";
            } else {
                $filigranea5pn = $filigranea5pa;
            }
            if ($filigranea5ln != NULL) {
                if ($filigranea5la != NULL) {
                    unlink("hopitalupload/logo/" . $filigranea5la);
                }
               
// on va vérifier que la nouvelle proprietaire n'existe pas déja
                if (!is_dir("hopitalupload/logo/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("hopitalupload/logo/", 0777);
// on fait une vérification sur la création pour le retour à l'proprietaire
                    if (is_dir("hopitalupload/logo/")) {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['filigranea5ln']['tmp_name'], "hopitalupload/logo/filigranea5l.png");

                    } else {
                        echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                            $pagp = 'hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idproprietaire='.$reg["1"]["idproprietaire"].'">');
        
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre proprietaire </br> Veuillez contacter votre administrateur</p>";
                    }
                } else {

// On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($reg["1"]['filigranea5ln']['tmp_name'], "hopitalupload/logo/filigranea5l.png");

                }
                $filigranea5ln = "filigranea5l.png";
            } else {
                $filigranea5ln = $filigranea5la;
            }
            if ($logon != NULL) {
                $con->query("update hp_proprietaire set nomproprietaire='" . addslashes($reg["1"]['nome']) . "', airesanteproprietaire='" . addslashes($reg["1"]['airesante']) . "', typeproprietaire='" . addslashes($reg["1"]['typee']) . "', "
                                . "telephoneproprietaire='" . $reg["1"]['tele'] . "', bpproprietaire='" . $reg["1"]['bp'] . "', emailproprietaire='" . $reg["1"]['emaile'] . "', "
                                . "iddepartement='" . $reg["1"]['iddepartement'] . "', arrondissementproprietaire='" . $reg["1"]['arrondissement'] . "', districtproprietaire='" . $reg["1"]['district'] . "', siteproprietaire='" . $reg["1"]['site'] . "', loginproprietaire='" . $reg["1"]['logine'] . "', "
                                . "motdepasseproprietaire='" . $pa . "', datecreationproprietaire='" . $reg["1"]['datecreation'] . "', textehopital='" . addslashes($reg["1"]['texte']) . "', adressehopital='" . addslashes($reg["1"]['adresse']) . "', "
                                . "sloganproprietaire='" . $reg["1"]['slogan'] . "', nocontribuableproprietaire='" . $reg["1"]['nocontribuable'] . "', "
                                . "hopitalproprietaire='" . addslashes($reg["1"]['hopital']) . "', logoproprietaire='" . $logon . "', filigranea5p='" . $filigranea5pn . "', filigranea5l='" . $filigranea5ln . "', filigranea4p='" . $filigranea4pn . "', filigranea4l='" . $filigranea4ln . "'"
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
                $con->query("update hp_proprietaire set nomproprietaire='" . addslashes($reg["1"]['nome']) . "',airesanteproprietaire='" . addslashes($reg["1"]['airesante']) . "', typeproprietaire='" . addslashes($reg["1"]['typee']) . "', "
                                . "telephoneproprietaire='" . $reg["1"]['tele'] . "', bpproprietaire='" . $reg["1"]['bp'] . "', emailproprietaire='" . $reg["1"]['emaile'] . "', "
                                . "iddepartement='" . $reg["1"]['iddepartement'] . "', arrondissementproprietaire='" . $reg["1"]['arrondissement'] . "', districtproprietaire='" . $reg["1"]['district'] . "', siteproprietaire='" . $reg["1"]['site'] . "', loginproprietaire='" . $reg["1"]['logine'] . "', "
                                . "motdepasseproprietaire='" . $pa . "', datecreationproprietaire='" . $reg["1"]['datecreation'] . "', textehopital='" . addslashes($reg["1"]['texte']) . "', adressehopital='" . addslashes($reg["1"]['adresse']) . "', "
                                . "sloganproprietaire='" . $reg["1"]['slogan'] . "', nocontribuableproprietaire='" . $reg["1"]['nocontribuable'] . "', "
                                . "hopitalproprietaire='" . addslashes($reg["1"]['hopital']) . "', filigranea5p='" . $filigranea5pn . "', filigranea5l='" . $filigranea5ln . "', filigranea4p='" . $filigranea4pn . "', filigranea4l='" . $filigranea4ln . "' "
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
            $pagp = 'hopitalpages/hopitalproprietaire/info_user';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idproprietaire='.$reg["1"]["idproprietaire"].'">');
        }
    }
}
