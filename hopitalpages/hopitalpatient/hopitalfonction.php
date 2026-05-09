<?php

function inserer_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    if (($reg != NULL) && isset($reg["1"])) {

        $nomp = addslashes($reg["1"]['nom']);
        $prenomp = addslashes($reg["1"]['prenom']);
        $idpat = ($reg["1"]['idpatient']);
        $rech = ($reg["1"]['recherche']);
        $telp = ($reg["1"]['tel']);
        $telpc = ($reg["1"]['telc']);
        $sexe = ($reg["1"]['sexe']);
        $datenais = ($reg["1"]['datenais']);
        $lieunais = addslashes($reg["1"]['lieunais']);
        $sitmat = addslashes($reg["1"]['sitmat']);
        $profession = addslashes($reg["1"]['profession']);
        $residence = addslashes($reg["1"]['residence']);
        $datej = ($reg["1"]['datejourp']);
        $heurej = ($reg["1"]['heurejourp']);
        $but = addslashes($reg["1"]['but']);
        $consultation = ($reg["1"]['consultation']);
        $montantc = ($reg["1"]['montantc']);
        $prenatale = ($reg["1"]['prenatale']);
        $montantcp = ($reg["1"]['montantcp']);
        $vaccin = ($reg["1"]['vaccin']);
        $montantv = ($reg["1"]['montantv']);
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');
        if (($rech == "") || ($rech == NULL)) {
//        $numid = "PA" . $jou . $moi . $sand . sprintf("%05d", 1);

            $req = $con->query("select * from hp_patient as e where DAY(e.datepatient)='" . $jou . "' and "
                    . "MONTH(e.datepatient)='" . $moi . "' and YEAR(e.datepatient)='" . $an . "'") or die(mysqli_error($con));
            $i = mysqli_num_rows($req);
            $numid = "PA" . $jou . $moi . $sand . sprintf("%05d", ($i + 1));
            if (($datenais != "") && ($datenais != NULL) && ($residence != "") && ($residence != NULL)) {
                $con->query("insert into hp_patient(nompatient, prenompatient, telephonepatient, telephonepacpatient, codepatient, "
                                . "sexepatient, datenaissancepatient, lieunaissancepatient, situationmatrimonialepatient, professionpatient, "
                                . "residencepatient, datepatient) values('" . $nomp . "', '" . $prenomp . "','" . $telp . "','" . $telpc . "', "
                                . "'" . $numid . "', '" . $sexe . "', '" . $datenais . "', '" . $lieunais . "', '" . $sitmat . "', "
                                . "'" . $profession . "', '" . $residence . "', NOW())") or die(mysqli_error($con));
            } else if (($datenais != "") && ($datenais != NULL)) {
                $con->query("insert into hp_patient(nompatient, prenompatient, telephonepatient, telephonepacpatient, codepatient, "
                                . "sexepatient, datenaissancepatient, lieunaissancepatient, situationmatrimonialepatient, professionpatient, "
                                . "datepatient) values('" . $nomp . "', '" . $prenomp . "','" . $telp . "','" . $telpc . "', "
                                . "'" . $numid . "', '" . $sexe . "', '" . $datenais . "', '" . $lieunais . "', '" . $sitmat . "', "
                                . "'" . $profession . "', NOW())") or die(mysqli_error($con));
            } else if (($residence != "") && ($residence != NULL)) {
                $con->query("insert into hp_patient(nompatient, prenompatient, telephonepatient, telephonepacpatient, codepatient, "
                                . "sexepatient, lieunaissancepatient, situationmatrimonialepatient, professionpatient, "
                                . "residencepatient, datepatient) values('" . $nomp . "', '" . $prenomp . "','" . $telp . "','" . $telpc . "', "
                                . "'" . $numid . "', '" . $sexe . "', '" . $lieunais . "', '" . $sitmat . "', "
                                . "'" . $profession . "', '" . $residence . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_patient(nompatient, prenompatient, telephonepatient, telephonepacpatient, codepatient, "
                                . "sexepatient, lieunaissancepatient, situationmatrimonialepatient, professionpatient, "
                                . "datepatient) values('" . $nomp . "', '" . $prenomp . "','" . $telp . "','" . $telpc . "', "
                                . "'" . $numid . "', '" . $sexe . "', '" . $lieunais . "', '" . $sitmat . "', "
                                . "'" . $profession . "', NOW())") or die(mysqli_error($con));
            }
            $resultat2 = $con->query("SELECT * FROM hp_patient where codepatient='" . $numid . "'") or die(mysqli_error($con));
            $row2 = mysqli_fetch_assoc($resultat2);
            $reqdoc = $con->query("select * from hp_dossier as e where DAY(e.datedossier)='" . $jou . "' and MONTH(e.datedossier)='" . $moi . "' and YEAR(e.datedossier)='" . $an . "'") or die(mysqli_error($con));
            $idoc = mysqli_num_rows($reqdoc);
            $numiddoc = "DOC" . $jou . $moi . $sand . sprintf("%05d", ($idoc + 1));
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_dossier(idpatient, codedossier, datedossier) values("
                                . "'" . $row2["idpatient"] . "', '" . $numiddoc . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_dossier(idcomptepersonnel, idpatient, codedossier, datedossier) values("
                                . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row2["idpatient"] . "', '" . $numiddoc . "', NOW())") or die(mysqli_error($con));
            }
            $resultat2d = $con->query("SELECT * FROM hp_dossier where codedossier='" . $numiddoc . "'") or die(mysqli_error($con));
            $row2d = mysqli_fetch_assoc($resultat2d);
            $coddoc = strtolower($numiddoc);
            if (!is_dir("hopitalupload/fichiers/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                @mkdir("hopitalupload/fichiers/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                if (!is_dir("hopitalupload/fichiers/" . $coddoc . "/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("hopitalupload/fichiers/" . $coddoc . "/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                }
            } else {
                if (!is_dir("hopitalupload/fichiers/" . $coddoc . "/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("hopitalupload/fichiers/" . $coddoc . "/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                }
            }

            $reqdocs = $con->query("select * from hp_sous_dossier as e where DAY(e.datesousdossier)='" . $jou . "' and "
                    . "MONTH(e.datesousdossier)='" . $moi . "' and YEAR(e.datesousdossier)='" . $an . "'") or die(mysqli_error($con));
            $idocs = mysqli_num_rows($reqdocs);
            $numiddocs = "DOCS" . $jou . $moi . $sand . sprintf("%05d", ($idocs + 1));
            $con->query("insert into hp_sous_dossier(iddossier, codesousdossier, datejoursousdossier, "
                            . "heurejoursousdossier, datesousdossier) values('" . $row2d["iddossier"] . "', "
                            . "'" . $numiddocs . "', '" . $datej . "', '" . $heurej . "', NOW())") or die(mysqli_error($con));
            $resultat2ds = $con->query("SELECT * FROM hp_sous_dossier where codesousdossier='" . $numiddocs . "'") or die(mysqli_error($con));
            $row2ds = mysqli_fetch_assoc($resultat2ds);
            $obj = "";
            if ($but == "Consultation") {
                $reqc = $con->query("select * from hp_consultation as e where DAY(e.dateconsultation)='" . $jou . "' and "
                        . "MONTH(e.dateconsultation)='" . $moi . "' and YEAR(e.dateconsultation)='" . $an . "'") or die(mysqli_error($con));
                $ic = mysqli_num_rows($reqc);
                $numidc = "CON" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $con->query("insert into hp_consultation(idsousdossier, codeconsultation, idacte, prixconsultation, "
                                    . "dateconsultation) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                    . "'" . $consultation . "', '" . $montantc . "', NOW())") or die(mysqli_error($con));
                } else {
                    $con->query("insert into hp_consultation(idcomptepersonnel, idsousdossier, codeconsultation, idacte, prixconsultation, "
                                    . "dateconsultation) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                    . "'" . $consultation . "', '" . $montantc . "', NOW())") or die(mysqli_error($con));
                }
                $resultat2c = $con->query("SELECT * FROM hp_consultation where codeconsultation='" . $numidc . "'") or die(mysqli_error($con));
                $row2c = mysqli_fetch_assoc($resultat2c);
                $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                        . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                $if = mysqli_num_rows($reqf);
                $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $con->query("insert into hp_facture(idconsultation, codefacture, montantfacture, datefacture) "
                                    . "values('" . $row2c["idconsultation"] . "', '" . $numidf . "', "
                                    . "'" . $montantc . "', NOW())") or die(mysqli_error($con));
                } else {
                    $con->query("insert into hp_facture(idcomptepersonnel, idconsultation, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idconsultation"] . "', '" . $numidf . "', "
                                    . "'" . $montantc . "', NOW())") or die(mysqli_error($con));
                }

                $obj = "Consultation " . $montantc;
            }
            if ($but == "Examen") {

                if (($reg["1"]['libexamen'] != '')) {
                    $reqtapq = $con->query("select * from hp_examen_patient where DATE(dateexamenpatient)=NOW() "
                            . "and idexamen='" . $reg["1"]["libexamen"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $reqc = $con->query("select * from hp_examen_patient as e where DAY(e.dateexamenpatient)='" . $jou . "' and "
                                . "MONTH(e.dateexamenpatient)='" . $moi . "' and YEAR(e.dateexamenpatient)='" . $an . "'") or die(mysqli_error($con));
                        $ic = mysqli_num_rows($reqc);
                        $numidc = "EXA" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_examen_patient(idsousdossier, codeexamenpatient, idexamen, montantexamenpatient, "
                                            . "dateexamenpatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libexamen"] . "', '" . $reg["1"]["prixexamen"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_examen_patient(idcomptepersonnel, idsousdossier, codeexamenpatient, idexamen, montantexamenpatient, "
                                            . "dateexamenpatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libexamen"] . "', '" . $reg["1"]["prixexamen"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $resultat2c = $con->query("SELECT * FROM hp_examen_patient where codeexamenpatient='" . $numidc . "'") or die(mysqli_error($con));
                        $row2c = mysqli_fetch_assoc($resultat2c);
                        $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                        $if = mysqli_num_rows($reqf);
                        $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_facture(idexamenpatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixexamen"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_facture(idcomptepersonnel, idexamenpatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixexamen"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $obj = "Examen " . $reg["1"]["prixexamen"];
                    }
                }

                for ($i = 0; $i < $reg["1"]["examennb"]; $i++) {
                    if (($reg["1"]["libexamen" . $i] != '')) {
                        $reqtapq = $con->query("select * from hp_examen_patient where DATE(dateexamenpatient)=NOW() "
                                . "and idexamen='" . $reg["1"]["libexamen" . $i] . "' ") or die(mysqli_error($con));
                        $nbtapq = mysqli_num_rows($reqtapq);
                        if ($nbtapq == 0) {
                            $reqc = $con->query("select * from hp_examen_patient as e where DAY(e.dateexamenpatient)='" . $jou . "' and "
                                    . "MONTH(e.dateexamenpatient)='" . $moi . "' and YEAR(e.dateexamenpatient)='" . $an . "'") or die(mysqli_error($con));
                            $ic = mysqli_num_rows($reqc);
                            $numidc = "EXA" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_examen_patient(idsousdossier, codeexamenpatient, idexamen, montantexamenpatient, "
                                                . "dateexamenpatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libexamen" . $i] . "', '" . $reg["1"]["prixexamen" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_examen_patient(idcomptepersonnel, idsousdossier, codeexamenpatient, idexamen, montantexamenpatient, "
                                                . "dateexamenpatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libexamen" . $i] . "', '" . $reg["1"]["prixexamen" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $resultat2c = $con->query("SELECT * FROM hp_examen_patient where codeexamenpatient='" . $numidc . "'") or die(mysqli_error($con));
                            $row2c = mysqli_fetch_assoc($resultat2c);
                            $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                    . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                            $if = mysqli_num_rows($reqf);
                            $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_facture(idexamenpatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixexamen" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_facture(idcomptepersonnel, idexamenpatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixexamen" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $obj = $obj . " ; Examen " . $reg["1"]["prixexamen" . $i];
                        }
                    }
                }
            }
            if ($but == "Echographie") {

                if (($reg["1"]['libechographie'] != '')) {
                    $reqtapq = $con->query("select * from hp_echographie_patient where DATE(dateechographiepatient)=NOW() "
                            . "and idechographie='" . $reg["1"]["libechographie"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $reqc = $con->query("select * from hp_echographie_patient as e where DAY(e.dateechographiepatient)='" . $jou . "' and "
                                . "MONTH(e.dateechographiepatient)='" . $moi . "' and YEAR(e.dateechographiepatient)='" . $an . "'") or die(mysqli_error($con));
                        $ic = mysqli_num_rows($reqc);
                        $numidc = "ECHO" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_echographie_patient(idsousdossier, codeechographiepatient, idechographie, montantechographiepatient, "
                                            . "dateechographiepatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libechographie"] . "', '" . $reg["1"]["prixechographie"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_echographie_patient(idcomptepersonnel, idsousdossier, codeechographiepatient, idechographie, montantechographiepatient, "
                                            . "dateechographiepatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libechographie"] . "', '" . $reg["1"]["prixechographie"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $resultat2c = $con->query("SELECT * FROM hp_echographie_patient where codeechographiepatient='" . $numidc . "'") or die(mysqli_error($con));
                        $row2c = mysqli_fetch_assoc($resultat2c);
                        $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                        $if = mysqli_num_rows($reqf);
                        $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_facture(idechographiepatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixechographie"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_facture(idcomptepersonnel, idechographiepatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixechographie"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $obj = "Echographie " . $reg["1"]["prixechographie"];
                    }
                }

                for ($i = 0; $i < $reg["1"]["echographienb"]; $i++) {
                    if (($reg["1"]["libechographie" . $i] != '')) {
                        $reqtapq = $con->query("select * from hp_echographie_patient where DATE(dateechographiepatient)=NOW() "
                                . "and idechographie='" . $reg["1"]["libechographie" . $i] . "' ") or die(mysqli_error($con));
                        $nbtapq = mysqli_num_rows($reqtapq);
                        if ($nbtapq == 0) {
                            $reqc = $con->query("select * from hp_echographie_patient as e where DAY(e.dateechographiepatient)='" . $jou . "' and "
                                    . "MONTH(e.dateechographiepatient)='" . $moi . "' and YEAR(e.dateechographiepatient)='" . $an . "'") or die(mysqli_error($con));
                            $ic = mysqli_num_rows($reqc);
                            $numidc = "ECHO" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_echographie_patient(idsousdossier, codeechographiepatient, idechographie, montantechographiepatient, "
                                                . "dateechographiepatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libechographie" . $i] . "', '" . $reg["1"]["prixechographie" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_echographie_patient(idcomptepersonnel, idsousdossier, codeechographiepatient, idechographie, montantechographiepatient, "
                                                . "dateechographiepatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libechographie" . $i] . "', '" . $reg["1"]["prixechographie" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $resultat2c = $con->query("SELECT * FROM hp_echographie_patient where codeechographiepatient='" . $numidc . "'") or die(mysqli_error($con));
                            $row2c = mysqli_fetch_assoc($resultat2c);
                            $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                    . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                            $if = mysqli_num_rows($reqf);
                            $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_facture(idechographiepatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixechographie" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_facture(idcomptepersonnel, idechographiepatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixechographie" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $obj = $obj . " ; Echographie " . $reg["1"]["prixechographie" . $i];
                        }
                    }
                }
            }
            if ($but == "Autre") {

                if (($reg["1"]['libacte'] != '')) {
                    $reqtapq = $con->query("select * from hp_acte_patient where DATE(dateactepatient)=NOW() "
                            . "and idacte='" . $reg["1"]["libacte"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $reqc = $con->query("select * from hp_acte_patient as e where DAY(e.dateactepatient)='" . $jou . "' and "
                                . "MONTH(e.dateactepatient)='" . $moi . "' and YEAR(e.dateactepatient)='" . $an . "'") or die(mysqli_error($con));
                        $ic = mysqli_num_rows($reqc);
                        $numidc = "ACT" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_acte_patient(idsousdossier, codeactepatient, idacte, prixactepatient, "
                                            . "dateactepatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libacte"] . "', '" . $reg["1"]["prixacte"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_acte_patient(idcomptepersonnel, idsousdossier, codeactepatient, idacte, prixactepatient, "
                                            . "dateactepatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libacte"] . "', '" . $reg["1"]["prixacte"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $resultat2c = $con->query("SELECT * FROM hp_acte_patient where codeactepatient='" . $numidc . "'") or die(mysqli_error($con));
                        $row2c = mysqli_fetch_assoc($resultat2c);
                        $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                        $if = mysqli_num_rows($reqf);
                        $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_facture(idactepatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixacte"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_facture(idcomptepersonnel, idactepatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixacte"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $obj = "Autre " . $reg["1"]["prixacte"];
                    }
                }

                for ($i = 0; $i < $reg["1"]["actenb"]; $i++) {
                    if (($reg["1"]["libacte" . $i] != '')) {
                        $reqtapq = $con->query("select * from hp_acte_patient where DATE(dateactepatient)=NOW() "
                                . "and idacte='" . $reg["1"]["libacte" . $i] . "' ") or die(mysqli_error($con));
                        $nbtapq = mysqli_num_rows($reqtapq);
                        if ($nbtapq == 0) {
                            $reqc = $con->query("select * from hp_acte_patient as e where DAY(e.dateactepatient)='" . $jou . "' and "
                                    . "MONTH(e.dateactepatient)='" . $moi . "' and YEAR(e.dateactepatient)='" . $an . "'") or die(mysqli_error($con));
                            $ic = mysqli_num_rows($reqc);
                            $numidc = "ACT" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_acte_patient(idsousdossier, codeactepatient, idacte, prixactepatient, "
                                                . "dateactepatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libacte" . $i] . "', '" . $reg["1"]["prixacte" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_acte_patient(idcomptepersonnel, idsousdossier, codeactepatient, idacte, prixactepatient, "
                                                . "dateactepatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libacte" . $i] . "', '" . $reg["1"]["prixacte" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $resultat2c = $con->query("SELECT * FROM hp_acte_patient where codeactepatient='" . $numidc . "'") or die(mysqli_error($con));
                            $row2c = mysqli_fetch_assoc($resultat2c);
                            $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                    . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                            $if = mysqli_num_rows($reqf);
                            $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_facture(idactepatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixacte" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_facture(idcomptepersonnel, idactepatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixacte" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $obj = $obj . " ; Autre " . $reg["1"]["prixacte" . $i];
                        }
                    }
                }
            }
            if ($but == "Ordonnance") {

                $reqc = $con->query("select * from hp_ordonnance as e where DAY(e.dateordonnance)='" . $jou . "' and "
                        . "MONTH(e.dateordonnance)='" . $moi . "' and YEAR(e.dateordonnance)='" . $an . "'") or die(mysqli_error($con));
                $ic = mysqli_num_rows($reqc);
                $numidc = "ORD" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $con->query("insert into hp_ordonnance(idsousdossier, codeordonnance, dateordonnance) "
                                    . "values('" . $row2ds["idsousdossier"] . "', "
                                    . "'" . $numidc . "', NOW())") or die(mysqli_error($con));
                } else {
                    $con->query("insert into hp_ordonnance(idcomptepersonnel, idsousdossier, codeordonnance, dateordonnance) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', "
                                    . "'" . $numidc . "', NOW())") or die(mysqli_error($con));
                }

                $resultat2c = $con->query("SELECT * FROM hp_ordonnance where codeordonnance='" . $numidc . "'") or die(mysqli_error($con));
                $row2c = mysqli_fetch_assoc($resultat2c);
                $pristord = 0;

                if (($reg["1"]['libordonnance'] != '')) {
                    $reqtapq = $con->query("select * from hp_ligne_ordonnance where idordonnance='" . $row2c["idordonnance"] . "' "
                            . "and idproduit='" . $reg["1"]["libordonnance"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $pristord = $pristord + ($reg["1"]["prixtordonnance"]);
                        $con->query("insert into hp_ligne_ordonnance(idproduit, idordonnance, idunite, stockligneordonnance, prixligneordonnance) "
                                        . "values('" . $reg["1"]["libordonnance"] . "', '" . $row2c["idordonnance"] . "', '" . $reg["1"]["uniteordonnance"] . "', "
                                        . "'" . $reg["1"]["qteordonnance"] . "', '" . $reg["1"]["prixuordonnance"] . "')") or die(mysqli_error($con));
                    }
                }
                for ($i = 0; $i < $reg["1"]["ordonnancenb"]; $i++) {
                    if (($reg["1"]["libordonnance" . $i] != '')) {
                        $reqtapq = $con->query("select * from hp_ligne_ordonnance where idordonnance='" . $row2c["idordonnance"] . "' "
                                . "and idproduit='" . $reg["1"]["libordonnance" . $i] . "' ") or die(mysqli_error($con));
                        $nbtapq = mysqli_num_rows($reqtapq);
                        if ($nbtapq == 0) {
                            $pristord = $pristord + ($reg["1"]["prixtordonnance" . $i]);
                            $con->query("insert into hp_ligne_ordonnance(idproduit, idordonnance, idunite, stockligneordonnance, prixligneordonnance) "
                                            . "values('" . $reg["1"]["libordonnance" . $i] . "', '" . $row2c["idordonnance"] . "', '" . $reg["1"]["uniteordonnance" . $i] . "', "
                                            . "'" . $reg["1"]["qteordonnance" . $i] . "', '" . $reg["1"]["prixuordonnance" . $i] . "')") or die(mysqli_error($con));
                        }
                    }
                }

                $con->query("update hp_ordonnance set montantordonnance='" . $pristord . "' where idordonnance='" . $row2c["idordonnance"] . "'") or die(mysqli_error($con));

                $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                        . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                $if = mysqli_num_rows($reqf);
                $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $con->query("insert into hp_facture(idordonnance, codefacture, montantfacture, datefacture) "
                                    . "values('" . $row2c["idordonnance"] . "', '" . $numidf . "', "
                                    . "'" . $pristord . "', NOW())") or die(mysqli_error($con));
                } else {
                    $con->query("insert into hp_facture(idcomptepersonnel, idordonnance, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idordonnance"] . "', '" . $numidf . "', "
                                    . "'" . $pristord . "', NOW())") or die(mysqli_error($con));
                }

                $obj = "Ordonnance " . $pristord;
            }
            $lieu = "Caisse";
            $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $row2d["iddossier"] . "'") or die(mysqli_error($con));

            $op = "Enregistrement";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idpatient, operation, objet, datetrace) "
                                . "values('" . $row2["idpatient"] . "', "
                                . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idcomptepersonnel, idpatient, operation, objet, datetrace) "
                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2["idpatient"] . "', "
                                . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
            }


            unset($_SESSION['formpatient']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/lister_patient';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $resultat2 = $con->query("SELECT * FROM hp_patient where idpatient='" . $idpat . "'") or die(mysqli_error($con));
            $row2 = mysqli_fetch_assoc($resultat2);

            $resultat2d = $con->query("SELECT * FROM hp_dossier where idpatient='" . $idpat . "'") or die(mysqli_error($con));
            $row2d = mysqli_fetch_assoc($resultat2d);

            $reqdocs = $con->query("select * from hp_sous_dossier as e where DAY(e.datesousdossier)='" . $jou . "' and "
                    . "MONTH(e.datesousdossier)='" . $moi . "' and YEAR(e.datesousdossier)='" . $an . "'") or die(mysqli_error($con));
            $idocs = mysqli_num_rows($reqdocs);
            $numiddocs = "DOCS" . $jou . $moi . $sand . sprintf("%05d", ($idocs + 1));
            $con->query("insert into hp_sous_dossier(iddossier, codesousdossier, datejoursousdossier, heurejoursousdossier, "
                            . "datesousdossier) values('" . $row2d["iddossier"] . "', '" . $numiddocs . "', '" . $datej . "', "
                            . "'" . $heurej . "', NOW())") or die(mysqli_error($con));
            $resultat2ds = $con->query("SELECT * FROM hp_sous_dossier where codesousdossier='" . $numiddocs . "'") or die(mysqli_error($con));
            $row2ds = mysqli_fetch_assoc($resultat2ds);
            $obj = "";

            if ($but == "Consultation") {
                $reqc = $con->query("select * from hp_consultation as e where DAY(e.dateconsultation)='" . $jou . "' and "
                        . "MONTH(e.dateconsultation)='" . $moi . "' and YEAR(e.dateconsultation)='" . $an . "'") or die(mysqli_error($con));
                $ic = mysqli_num_rows($reqc);
                $numidc = "CON" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $con->query("insert into hp_consultation(idsousdossier, codeconsultation, idacte, prixconsultation, "
                                    . "dateconsultation) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                    . "'" . $consultation . "', '" . $montantc . "', NOW())") or die(mysqli_error($con));
                } else {
                    $con->query("insert into hp_consultation(idcomptepersonnel, idsousdossier, codeconsultation, idacte, prixconsultation, "
                                    . "dateconsultation) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                    . "'" . $consultation . "', '" . $montantc . "', NOW())") or die(mysqli_error($con));
                }

                $resultat2c = $con->query("SELECT * FROM hp_consultation where codeconsultation='" . $numidc . "'") or die(mysqli_error($con));
                $row2c = mysqli_fetch_assoc($resultat2c);
                $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                        . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                $if = mysqli_num_rows($reqf);
                $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $con->query("insert into hp_facture(idconsultation, codefacture, montantfacture, datefacture) "
                                    . "values('" . $row2c["idconsultation"] . "', '" . $numidf . "', "
                                    . "'" . $montantc . "', NOW())") or die(mysqli_error($con));
                } else {
                    $con->query("insert into hp_facture(idcomptepersonnel, idconsultation, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idconsultation"] . "', '" . $numidf . "', "
                                    . "'" . $montantc . "', NOW())") or die(mysqli_error($con));
                }

                $obj = "Consultation " . $montantc;
            }
            if ($but == "Examen") {
// echo "<script language='javascript'>alert('slow')</script>";

                if (($reg["1"]['libexamen'] != '')) {
                    $reqtapq = $con->query("select * from hp_examen_patient where DATE(dateexamenpatient)=NOW() "
                            . "and idexamen='" . $reg["1"]["libexamen"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $reqc = $con->query("select * from hp_examen_patient as e where DAY(e.dateexamenpatient)='" . $jou . "' and "
                                . "MONTH(e.dateexamenpatient)='" . $moi . "' and YEAR(e.dateexamenpatient)='" . $an . "'") or die(mysqli_error($con));
                        $ic = mysqli_num_rows($reqc);
                        $numidc = "EXA" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_examen_patient(idsousdossier, codeexamenpatient, idexamen, montantexamenpatient, "
                                            . "dateexamenpatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libexamen"] . "', '" . $reg["1"]["prixexamen"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_examen_patient(idcomptepersonnel, idsousdossier, codeexamenpatient, idexamen, montantexamenpatient, "
                                            . "dateexamenpatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libexamen"] . "', '" . $reg["1"]["prixexamen"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $resultat2c = $con->query("SELECT * FROM hp_examen_patient where codeexamenpatient='" . $numidc . "'") or die(mysqli_error($con));
                        $row2c = mysqli_fetch_assoc($resultat2c);
                        $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                        $if = mysqli_num_rows($reqf);
                        $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_facture(idexamenpatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixexamen"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_facture(idcomptepersonnel, idexamenpatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixexamen"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $obj = "Examen " . $reg["1"]["prixexamen"];
                    }
                }

                for ($i = 0; $i < $reg["1"]["examennb"]; $i++) {
                    if (($reg["1"]["libexamen" . $i] != '')) {
                        $reqtapq = $con->query("select * from hp_examen_patient where DATE(dateexamenpatient)=NOW() "
                                . "and idexamen='" . $reg["1"]["libexamen" . $i] . "' ") or die(mysqli_error($con));
                        $nbtapq = mysqli_num_rows($reqtapq);
                        if ($nbtapq == 0) {
                            $reqc = $con->query("select * from hp_examen_patient as e where DAY(e.dateexamenpatient)='" . $jou . "' and "
                                    . "MONTH(e.dateexamenpatient)='" . $moi . "' and YEAR(e.dateexamenpatient)='" . $an . "'") or die(mysqli_error($con));
                            $ic = mysqli_num_rows($reqc);
                            $numidc = "EXA" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_examen_patient(idsousdossier, codeexamenpatient, idexamen, montantexamenpatient, "
                                                . "dateexamenpatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libexamen" . $i] . "', '" . $reg["1"]["prixexamen" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_examen_patient(idcomptepersonnel, idsousdossier, codeexamenpatient, idexamen, montantexamenpatient, "
                                                . "dateexamenpatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libexamen" . $i] . "', '" . $reg["1"]["prixexamen" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $resultat2c = $con->query("SELECT * FROM hp_examen_patient where codeexamenpatient='" . $numidc . "'") or die(mysqli_error($con));
                            $row2c = mysqli_fetch_assoc($resultat2c);
                            $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                    . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                            $if = mysqli_num_rows($reqf);
                            $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_facture(idexamenpatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixexamen" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_facture(idcomptepersonnel, idexamenpatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixexamen" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $obj = $obj . " ; Examen " . $reg["1"]["prixexamen" . $i];
                        }
                    }
                }
            }
            if ($but == "Echographie") {

                if (($reg["1"]['libechographie'] != '')) {
                    $reqtapq = $con->query("select * from hp_echographie_patient where DATE(dateechographiepatient)=NOW() "
                            . "and idechographie='" . $reg["1"]["libechographie"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $reqc = $con->query("select * from hp_echographie_patient as e where DAY(e.dateechographiepatient)='" . $jou . "' and "
                                . "MONTH(e.dateechographiepatient)='" . $moi . "' and YEAR(e.dateechographiepatient)='" . $an . "'") or die(mysqli_error($con));
                        $ic = mysqli_num_rows($reqc);
                        $numidc = "ECHO" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_echographie_patient(idsousdossier, codeechographiepatient, idechographie, montantechographiepatient, "
                                            . "dateechographiepatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libechographie"] . "', '" . $reg["1"]["prixechographie"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_echographie_patient(idcomptepersonnel, idsousdossier, codeechographiepatient, idechographie, montantechographiepatient, "
                                            . "dateechographiepatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libechographie"] . "', '" . $reg["1"]["prixechographie"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $resultat2c = $con->query("SELECT * FROM hp_echographie_patient where codeechographiepatient='" . $numidc . "'") or die(mysqli_error($con));
                        $row2c = mysqli_fetch_assoc($resultat2c);
                        $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                        $if = mysqli_num_rows($reqf);
                        $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_facture(idechographiepatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixechographie"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_facture(idcomptepersonnel, idechographiepatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixechographie"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $obj = "Echographie " . $reg["1"]["prixechographie"];
                    }
                }

                for ($i = 0; $i < $reg["1"]["echographienb"]; $i++) {
                    if (($reg["1"]["libechographie" . $i] != '')) {
                        $reqtapq = $con->query("select * from hp_echographie_patient where DATE(dateechographiepatient)=NOW() "
                                . "and idechographie='" . $reg["1"]["libechographie" . $i] . "' ") or die(mysqli_error($con));
                        $nbtapq = mysqli_num_rows($reqtapq);
                        if ($nbtapq == 0) {
                            $reqc = $con->query("select * from hp_echographie_patient as e where DAY(e.dateechographiepatient)='" . $jou . "' and "
                                    . "MONTH(e.dateechographiepatient)='" . $moi . "' and YEAR(e.dateechographiepatient)='" . $an . "'") or die(mysqli_error($con));
                            $ic = mysqli_num_rows($reqc);
                            $numidc = "ECHO" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_echographie_patient(idsousdossier, codeechographiepatient, idechographie, montantechographiepatient, "
                                                . "dateechographiepatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libechographie" . $i] . "', '" . $reg["1"]["prixechographie" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_echographie_patient(idcomptepersonnel, idsousdossier, codeechographiepatient, idechographie, montantechographiepatient, "
                                                . "dateechographiepatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libechographie" . $i] . "', '" . $reg["1"]["prixechographie" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $resultat2c = $con->query("SELECT * FROM hp_echographie_patient where codeechographiepatient='" . $numidc . "'") or die(mysqli_error($con));
                            $row2c = mysqli_fetch_assoc($resultat2c);
                            $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                    . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                            $if = mysqli_num_rows($reqf);
                            $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_facture(idechographiepatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixechographie" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_facture(idcomptepersonnel, idechographiepatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixechographie" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $obj = $obj . " ; Echographie " . $reg["1"]["prixechographie" . $i];
                        }
                    }
                }
            }
            if ($but == "Autre") {

                if (($reg["1"]['libacte'] != '')) {
                    $reqtapq = $con->query("select * from hp_acte_patient where DATE(dateactepatient)=NOW() "
                            . "and idacte='" . $reg["1"]["libacte"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $reqc = $con->query("select * from hp_acte_patient as e where DAY(e.dateactepatient)='" . $jou . "' and "
                                . "MONTH(e.dateactepatient)='" . $moi . "' and YEAR(e.dateactepatient)='" . $an . "'") or die(mysqli_error($con));
                        $ic = mysqli_num_rows($reqc);
                        $numidc = "ACT" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_acte_patient(idsousdossier, codeactepatient, idacte, prixactepatient, "
                                            . "dateactepatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libacte"] . "', '" . $reg["1"]["prixacte"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_acte_patient(idcomptepersonnel, idsousdossier, codeactepatient, idacte, prixactepatient, "
                                            . "dateactepatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                            . "'" . $reg["1"]["libacte"] . "', '" . $reg["1"]["prixacte"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $resultat2c = $con->query("SELECT * FROM hp_acte_patient where codeactepatient='" . $numidc . "'") or die(mysqli_error($con));
                        $row2c = mysqli_fetch_assoc($resultat2c);
                        $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                        $if = mysqli_num_rows($reqf);
                        $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                            $con->query("insert into hp_facture(idactepatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixacte"] . "', NOW())") or die(mysqli_error($con));
                        } else {
                            $con->query("insert into hp_facture(idcomptepersonnel, idactepatient, codefacture, montantfacture, datefacture) "
                                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                            . "'" . $reg["1"]["prixacte"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $obj = "Autre " . $reg["1"]["prixacte"];
                    }
                }

                for ($i = 0; $i < $reg["1"]["actenb"]; $i++) {
                    if (($reg["1"]["libacte" . $i] != '')) {
                        $reqtapq = $con->query("select * from hp_acte_patient where DATE(dateactepatient)=NOW() "
                                . "and idacte='" . $reg["1"]["libacte" . $i] . "' ") or die(mysqli_error($con));
                        $nbtapq = mysqli_num_rows($reqtapq);
                        if ($nbtapq == 0) {
                            $reqc = $con->query("select * from hp_acte_patient as e where DAY(e.dateactepatient)='" . $jou . "' and "
                                    . "MONTH(e.dateactepatient)='" . $moi . "' and YEAR(e.dateactepatient)='" . $an . "'") or die(mysqli_error($con));
                            $ic = mysqli_num_rows($reqc);
                            $numidc = "ACT" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_acte_patient(idsousdossier, codeactepatient, idacte, prixactepatient, "
                                                . "dateactepatient) values('" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libacte" . $i] . "', '" . $reg["1"]["prixacte" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_acte_patient(idcomptepersonnel, idsousdossier, codeactepatient, idacte, prixactepatient, "
                                                . "dateactepatient) values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', '" . $numidc . "', "
                                                . "'" . $reg["1"]["libacte" . $i] . "', '" . $reg["1"]["prixacte" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $resultat2c = $con->query("SELECT * FROM hp_acte_patient where codeactepatient='" . $numidc . "'") or die(mysqli_error($con));
                            $row2c = mysqli_fetch_assoc($resultat2c);
                            $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                    . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                            $if = mysqli_num_rows($reqf);
                            $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                                $con->query("insert into hp_facture(idactepatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixacte" . $i] . "', NOW())") or die(mysqli_error($con));
                            } else {
                                $con->query("insert into hp_facture(idcomptepersonnel, idactepatient, codefacture, montantfacture, datefacture) "
                                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                                . "'" . $reg["1"]["prixacte" . $i] . "', NOW())") or die(mysqli_error($con));
                            }

                            $obj = $obj . " ; Autre " . $reg["1"]["prixacte" . $i];
                        }
                    }
                }
            }
            if ($but == "Ordonnance") {

                $reqc = $con->query("select * from hp_ordonnance as e where DAY(e.dateordonnance)='" . $jou . "' and "
                        . "MONTH(e.dateordonnance)='" . $moi . "' and YEAR(e.dateordonnance)='" . $an . "'") or die(mysqli_error($con));
                $ic = mysqli_num_rows($reqc);
                $numidc = "ORD" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $con->query("insert into hp_ordonnance(idsousdossier, codeordonnance, dateordonnance) "
                                    . "values('" . $row2ds["idsousdossier"] . "', "
                                    . "'" . $numidc . "', NOW())") or die(mysqli_error($con));
                } else {
                    $con->query("insert into hp_ordonnance(idcomptepersonnel, idsousdossier, codeordonnance, dateordonnance) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', "
                                    . "'" . $numidc . "', NOW())") or die(mysqli_error($con));
                }

                $resultat2c = $con->query("SELECT * FROM hp_ordonnance where codeordonnance='" . $numidc . "'") or die(mysqli_error($con));
                $row2c = mysqli_fetch_assoc($resultat2c);
                $pristord = 0;

                if (($reg["1"]['libordonnance'] != '')) {
                    $reqtapq = $con->query("select * from hp_ligne_ordonnance where idordonnance='" . $row2c["idordonnance"] . "' "
                            . "and idproduit='" . $reg["1"]["libordonnance"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $pristord = $pristord + ($reg["1"]["prixtordonnance"]);
                        $con->query("insert into hp_ligne_ordonnance(idproduit, idordonnance, idunite, stockligneordonnance, prixligneordonnance) "
                                        . "values('" . $reg["1"]["libordonnance"] . "', '" . $row2c["idordonnance"] . "', '" . $reg["1"]["uniteordonnance"] . "', "
                                        . "'" . $reg["1"]["qteordonnance"] . "', '" . $reg["1"]["prixuordonnance"] . "')") or die(mysqli_error($con));
                    }
                }
                for ($i = 0; $i < $reg["1"]["ordonnancenb"]; $i++) {
                    if (($reg["1"]["libordonnance" . $i] != '')) {
                        $reqtapq = $con->query("select * from hp_ligne_ordonnance where idordonnance='" . $row2c["idordonnance"] . "' "
                                . "and idproduit='" . $reg["1"]["libordonnance" . $i] . "' ") or die(mysqli_error($con));
                        $nbtapq = mysqli_num_rows($reqtapq);
                        if ($nbtapq == 0) {
                            $pristord = $pristord + ($reg["1"]["prixtordonnance" . $i]);
                            $con->query("insert into hp_ligne_ordonnance(idproduit, idordonnance, idunite, stockligneordonnance, prixligneordonnance) "
                                            . "values('" . $reg["1"]["libordonnance" . $i] . "', '" . $row2c["idordonnance"] . "', '" . $reg["1"]["uniteordonnance" . $i] . "', "
                                            . "'" . $reg["1"]["qteordonnance" . $i] . "', '" . $reg["1"]["prixuordonnance" . $i] . "')") or die(mysqli_error($con));
                        }
                    }
                }

                $con->query("update hp_ordonnance set montantordonnance='" . $pristord . "' where idordonnance='" . $row2c["idordonnance"] . "'") or die(mysqli_error($con));

                $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                        . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                $if = mysqli_num_rows($reqf);
                $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $con->query("insert into hp_facture(idordonnance, codefacture, montantfacture, datefacture) "
                                    . "values('" . $row2c["idordonnance"] . "', '" . $numidf . "', "
                                    . "'" . $pristord . "', NOW())") or die(mysqli_error($con));
                } else {
                    $con->query("insert into hp_facture(idcomptepersonnel, idordonnance, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idordonnance"] . "', '" . $numidf . "', "
                                    . "'" . $pristord . "', NOW())") or die(mysqli_error($con));
                }

                $obj = "Ordonnance " . $pristord;
            }
            $lieu = "Caisse";
            $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $row2d["iddossier"] . "'") or die(mysqli_error($con));

            $op = "Admission";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idpatient, operation, objet, datetrace) "
                                . "values('" . $row2["idpatient"] . "', "
                                . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idcomptepersonnel, idpatient, operation, objet, datetrace) "
                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2["idpatient"] . "', "
                                . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
            }


            unset($_SESSION['formpatient']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/lister_patient';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

function inserer_patient_comptoir($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    if (($reg != NULL) && isset($reg["1"])) {

        $datej = ($reg["1"]['datejourp']);
        $heurej = ($reg["1"]['heurejourp']);
        $montanto = ($reg["1"]['montanto']);
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');

        $reqc = $con->query("select * from hp_ordonnance as e where DAY(e.dateordonnance)='" . $jou . "' and "
                . "MONTH(e.dateordonnance)='" . $moi . "' and YEAR(e.dateordonnance)='" . $an . "'") or die(mysqli_error($con));
        $ic = mysqli_num_rows($reqc);
        $numidc = "ORD" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $con->query("insert into hp_ordonnance(codeordonnance, dateordonnance) "
                            . "values('" . $numidc . "', NOW())") or die(mysqli_error($con));
        } else {
            $con->query("insert into hp_ordonnance(idcomptepersonnel, codeordonnance, dateordonnance) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $numidc . "', NOW())") or die(mysqli_error($con));
        }

        $resultat2c = $con->query("SELECT * FROM hp_ordonnance where codeordonnance='" . $numidc . "'") or die(mysqli_error($con));
        $row2c = mysqli_fetch_assoc($resultat2c);
        $pristord = 0;

        if (($reg["1"]['libordonnance'] != '')) {
            $reqtapq = $con->query("select * from hp_ligne_ordonnance where idordonnance='" . $row2c["idordonnance"] . "' "
                    . "and idproduit='" . $reg["1"]["libordonnance"] . "' ") or die(mysqli_error($con));
            $nbtapq = mysqli_num_rows($reqtapq);
            if ($nbtapq == 0) {
                $pristord = $pristord + ($reg["1"]["prixtordonnance"]);
                $con->query("insert into hp_ligne_ordonnance(idproduit, idordonnance, idunite, stockligneordonnance, prixligneordonnance) "
                                . "values('" . $reg["1"]["libordonnance"] . "', '" . $row2c["idordonnance"] . "', '" . $reg["1"]["uniteordonnance"] . "', "
                                . "'" . $reg["1"]["qteordonnance"] . "', '" . $reg["1"]["prixuordonnance"] . "')") or die(mysqli_error($con));
            }
        }
        for ($i = 0; $i < $reg["1"]["ordonnancenb"]; $i++) {
            if (($reg["1"]["libordonnance" . $i] != '')) {
                $reqtapq = $con->query("select * from hp_ligne_ordonnance where idordonnance='" . $row2c["idordonnance"] . "' "
                        . "and idproduit='" . $reg["1"]["libordonnance" . $i] . "' ") or die(mysqli_error($con));
                $nbtapq = mysqli_num_rows($reqtapq);
                if ($nbtapq == 0) {
                    $pristord = $pristord + ($reg["1"]["prixtordonnance" . $i]);
                    $con->query("insert into hp_ligne_ordonnance(idproduit, idordonnance, idunite, stockligneordonnance, prixligneordonnance) "
                                    . "values('" . $reg["1"]["libordonnance" . $i] . "', '" . $row2c["idordonnance"] . "', '" . $reg["1"]["uniteordonnance" . $i] . "', "
                                    . "'" . $reg["1"]["qteordonnance" . $i] . "', '" . $reg["1"]["prixuordonnance" . $i] . "')") or die(mysqli_error($con));
                }
            }
        }

        $con->query("update hp_ordonnance set montantordonnance='" . $pristord . "' where idordonnance='" . $row2c["idordonnance"] . "'") or die(mysqli_error($con));

        $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
        $if = mysqli_num_rows($reqf);
        $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $con->query("insert into hp_facture(idordonnance, codefacture, montantfacture, datefacture) "
                            . "values('" . $row2c["idordonnance"] . "', '" . $numidf . "', "
                            . "'" . $pristord . "', NOW())") or die(mysqli_error($con));
        } else {
            $con->query("insert into hp_facture(idcomptepersonnel, idordonnance, codefacture, montantfacture, datefacture) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idordonnance"] . "', '" . $numidf . "', "
                            . "'" . $pristord . "', NOW())") or die(mysqli_error($con));
        }

        $obj = "Ordonnance " . $pristord;


        $op = "Ordonnance Comptoir";
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $con->query("insert into hp_trace(operation, objet, datetrace) "
                            . "values('" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
        } else {
            $con->query("insert into hp_trace(idcomptepersonnel, operation, objet, datetrace) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', "
                            . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
        }


        unset($_SESSION['formpatientcomptoir']);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalpatient/lister_patient';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}

//fonction pour lister les patients
function lister_patient($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_patient as p left join hp_departement as d on p.residencepatient=d.iddepartement "
            . "left join hp_region as r on d.idregion=r.idregion") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td>
                <?php
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Directeur de Centre")))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitaldossierpatient/lister_dossier_patient') ?>&idpatient=<?php echo $recuser["idpatient"] ?>">
                        <span title="Ouvrir le dossier de ce Patient" ><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Infirmier") || ($_SESSION["rolepersonnel"] == "Accueil")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitaldossierpatient/lister_dossier_patient') ?>&idpatient=<?php echo $recuser["idpatient"] ?>">
                            <span title="Ouvrir le dossier de ce Patient" ><i class="glyphicon glyphicon-folder-open"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalediter/edit_patient'); ?>&idpatient=<?php echo $recuser["idpatient"]; ?>" >
                    <span title="Modifier ce patient" alt="list"><i class="glyphicon glyphicon-edit"></i></span>
                </a>

            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["codepatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nompatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenompatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephonepatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephonepacpatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["datenaissancepatient"])) ?></td>
            <td><?php echo($recuser["libelledepartement"]); ?> - <?php echo($recuser["libelleregion"]); ?></td>
            <td>
                <?php
                $rsltuserd = $con->query("select * from hp_dossier as p where p.idpatient='" . $recuser["idpatient"] . "'") or die(mysqli_error($con));
                $nbd = mysqli_num_rows($rsltuserd);
                if ($nbd != 0) {
                    $recuserd = mysqli_fetch_assoc($rsltuserd);
                    print nl2br(htmlspecialchars($recuserd["lieudossier"]));
                    if ($recuserd["lieudossier"] == "Accueil") {
                        if ((isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Accueil")))) {
                            ?>
                            &nbsp;&nbsp;
                    <!--                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalediter/edit_patient'); ?>&idpatient=<?php echo $recuser["idpatient"]; ?>" >
                                <span title="Modifier cet patient" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                            </a>-->
                            <?php
                        }
                    } else if ($recuserd["lieudossier"] == "Caisse") {
                        if ((isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Caisse")))) {
                            ?>&nbsp;&nbsp;
                    <!--                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/patient_ajax'); ?>&iddossier=<?php echo $recuserd["iddossier"]; ?>&validercaisse=validercaisse" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Valider ce dossier ?'));" >
                                <span title="Valider le dossier cet patient" alt="list"><i class="glyphicon glyphicon-folder-open"></i></span>
                            </a>-->
                            <?php
                        }
                    } else if ($recuserd["lieudossier"] == "Médecin") {
                        if ((isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin")))) {
                            ?>&nbsp;&nbsp;
                    <!--                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/patient_ajax'); ?>&iddossier=<?php echo $recuserd["iddossier"]; ?>&validermedecin=validermedecin" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Valider ce dossier ?'));" >
                                <span title="Valider le dossier cet patient" alt="list"><i class="glyphicon glyphicon-folder-open"></i></span>
                            </a>-->
                            <?php
                        }
                    }
                }
                ?>

            </td>
            <td>
                <?php
                $rsltuserds = $con->query("select * from hp_sous_dossier as sd left join hp_dossier as d on "
                        . "sd.iddossier=d.iddossier where d.idpatient='" . $recuser["idpatient"] . "' order by "
                        . "sd.datesousdossier desc limit 0,1") or die(mysqli_error($con));
                $nbds = mysqli_num_rows($rsltuserds);
                if ($nbds != 0) {
                    $recuserds = mysqli_fetch_assoc($rsltuserds);
                    print nl2br(htmlspecialchars($recuserds["datejoursousdossier"]));
                    ?> 
                    <?php
                    print nl2br(htmlspecialchars($recuserds["heurejoursousdossier"]));
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function update_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    if (($reg != NULL) && isset($reg["1"])) {

        $nomp = addslashes($reg["1"]['nom']);
        $prenomp = addslashes($reg["1"]['prenom']);
        $idpat = ($reg["1"]['idpatient']);
        $telp = ($reg["1"]['tel']);
        $telpc = ($reg["1"]['telc']);
        $sexe = ($reg["1"]['sexe']);
        $datenais = ($reg["1"]['datenais']);
        $lieunais = addslashes($reg["1"]['lieunais']);
        $sitmat = addslashes($reg["1"]['sitmat']);
        $profession = addslashes($reg["1"]['profession']);
        $residence = addslashes($reg["1"]['residence']);
        if (($datenais != "") && ($datenais != NULL)) {
            $con->query("update hp_patient set nompatient='" . $nomp . "', prenompatient='" . $prenomp . "', "
                            . "telephonepatient='" . $telp . "', telephonepacpatient='" . $telpc . "', sexepatient='" . $sexe . "', "
                            . "datenaissancepatient='" . $datenais . "', lieunaissancepatient='" . $lieunais . "', "
                            . "situationmatrimonialepatient='" . $sitmat . "', professionpatient='" . $profession . "', "
                            . "residencepatient='" . $residence . "' where idpatient='" . $idpat . "'") or die(mysqli_error($con));
        } else {
            $con->query("update hp_patient set nompatient='" . $nomp . "', prenompatient='" . $prenomp . "', "
                            . "telephonepatient='" . $telp . "', telephonepacpatient='" . $telpc . "', sexepatient='" . $sexe . "', "
                            . "lieunaissancepatient='" . $lieunais . "', situationmatrimonialepatient='" . $sitmat . "', "
                            . "professionpatient='" . $profession . "', residencepatient='" . $residence . "' where "
                            . "idpatient='" . $idpat . "'") or die(mysqli_error($con));
        }
        $obj = "Patient";
        $op = "Modification";
        if (isset($_SESSION["idcomptepersonnel"])) {
            $con->query("insert into hp_trace(idcomptepersonnel, idpatient, operation, objet, datetrace) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $idpat . "', "
                            . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
        } else {
            $con->query("insert into hp_trace(idpatient, operation, objet, datetrace) "
                            . "values('" . $idpat . "', "
                            . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION['formpatient']);
        echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalpatient/lister_patient';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}

//fonction pour lister les Patients
function lister_patient_hospitalisation($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_hospitalisation as h left join hp_sous_dossier as sd on "
            . "h.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier left join "
            . "hp_patient as p on d.idpatient=p.idpatient left join hp_departement as de on p.residencepatient=de.iddepartement "
            . "left join hp_region as r on de.idregion=r.idregion where h.sortiehospitalisation=false order by "
            . "h.datehospitalisation desc ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltpl = $con->query("select * from hp_deplacement_patient as dp left join hp_facture as f on "
                . "dp.iddeplacementpatient=f.iddeplacementpatient where dp.idhospitalisation='" . $recuser["idhospitalisation"] . "' "
                . "and dp.regledeplacementpatient=false order by dp.datedeplacementpatient desc limit 0,1 ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($rsltpl);
        $rsltpl2 = $con->query("select * from hp_deplacement_patient as dp left join hp_facture as f on "
                . "dp.iddeplacementpatient=f.iddeplacementpatient where dp.idhospitalisation='" . $recuser["idhospitalisation"] . "' "
                . "and dp.regledeplacementpatient=false order by dp.datedeplacementpatient desc limit 0,1") or die(mysqli_error($con));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);
        $today = date('Y-m-d H:i:s');
        $dif = dateDiff($rowpl["datedebutdeplacementpatient"], $today);
        ?>

        <tr >
            <td></td>
            <td>
                <?php
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Directeur de Centre")))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/editer_patient') ?>&patient=<?php echo $recuser["idpatient"] ?>">
                        <span title="Modifier ce Patient" ><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalhospitalisation/suivie_patient') ?>&idhospitalisation=<?php echo $recuser["idhospitalisation"] ?>">
                        <span title="Suivie de ce Patient" ><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitaldossierpatient/lister_dossier_patient') ?>&idpatient=<?php echo $recuser["idpatient"] ?>">
                        <span title="Ouvrir le dossier de ce Patient" ><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/deplacer_patient') ?>&patient=<?php echo $recuser["idpatient"] ?>">
                        <span title="D&eacute;placer ce Patient" ><i class="glyphicon glyphicon-move"></i></span>
                    </a>
                    <!--                    &nbsp;&nbsp;
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitaldossierpatient/ajouter_loyer_patient') ?>&patient=<?php echo $recuser["idpatient"] ?>">
                                            <span title="Ajouter les jours de ce Patient" ><i class="glyphicon glyphicon-plus"></i></span>
                                        </a>-->
                    <!--                    &nbsp;&nbsp;
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitaldossierpatient/ajout_versement_p') ?>&patient=<?php echo $recuser["idpatient"] ?>">
                                            <span title="Ajouter le versement de ce patient" ><i class="glyphicon glyphicon-credit-card"></i></span>
                                        </a>-->
                    &nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitaldossierpatient/affiche_registre') ?>&patient=<?php echo $recuser["idpatient"] ?>">
                        <span title="Afficher le registre de ce patient" ><i class="glyphicon glyphicon-book"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Infirmier")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalhospitalisation/suivie_patient') ?>&idhospitalisation=<?php echo $recuser["idhospitalisation"] ?>">
                            <span title="Suivie de ce Patient" ><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitaldossierpatient/lister_dossier_patient') ?>&idpatient=<?php echo $recuser["idpatient"] ?>">
                            <span title="Ouvrir le dossier de ce Patient" ><i class="glyphicon glyphicon-folder-open"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/deplacer_patient') ?>&patient=<?php echo $recuser["idpatient"] ?>">
                            <span title="D&eacute;placer ce Patient" ><i class="glyphicon glyphicon-move"></i></span>
                        </a>
                        <?php
                    }
                }
                if ($dif[0] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-primary">
                        <?php echo $dif[0] . "A " . $dif[1] . "M " . $dif[2] . "J " . $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[1] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-success">
                        <?php echo $dif[1] . "M " . $dif[2] . "J " . $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[2] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-info">
                        <?php echo $dif[2] . "J " . $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[3] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-warning">
                        <?php echo $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[4] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-danger">
                        <?php echo $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[5] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-danger">
                        <?php echo $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else {
                    if ($rowpl2["id_chambre"] != NULL) {
                        $reqch = $con->query("select * from hp_chambre as c left join hp_point_hotel as ph on "
                                . "c.id_point_hotel=ph.id_point_hotel left join hp_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowpl2["id_chambre"] . "' ")
                                or die(mysqli_error($con));
                        $rowch = mysqli_fetch_assoc($reqch);
                        ?>
                        &nbsp;&nbsp;
                        <a href="#" onclick=liberer_cha(<?php echo $rowch["id_chambre"] ?>)>
                            <label class="label-danger">
                                <?php echo "0S Liberer"; ?>
                            </label>
                        </a>
                        <?php
                    } else if ($rowpl2["id_studio"] != NULL) {
                        $reqst = $con->query("select * from hp_studio as s left join hp_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hp_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowpl2["id_studio"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;&nbsp;
                        <a href="#" onclick=liberer_std(<?php echo $rowst["id_studio"] ?>)>
                            <label class="label-danger">
                                <?php echo "0S Liberer"; ?>
                            </label>
                        </a>
                        <?php
                    } else if ($rowpl2["id_appartement"] != NULL) {
                        $reqap = $con->query("select * from hp_appartement as a left join hp_point_hotel as ph on "
                                . "a.id_point_hotel=ph.id_point_hotel left join hp_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowpl2["id_appartement"] . "' ")
                                or die(mysqli_error($con));
                        $rowap = mysqli_fetch_assoc($reqap);
                        ?>
                        &nbsp;&nbsp;
                        <a href="#" onclick=liberer_app(<?php echo $rowap["id_appartement"] ?>)>
                            <label class="label-danger">
                                <?php echo "0S Liberer"; ?>
                            </label>
                        </a>
                        <?php
                    } else if ($rowpl2["id_salle"] != NULL) {
                        $reqst = $con->query("select * from hp_salle as s left join hp_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hp_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowpl2["id_salle"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;&nbsp;
                        <a href="#" onclick=liberer_sal(<?php echo $rowst["id_salle"] ?>)>
                            <label class="label-danger">
                                <?php echo "0S Liberer"; ?>
                            </label>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
                <?php
                $reqch = $con->query("select * from hp_lit as l left join hp_chambre as c on l.idchambre=c.idchambre "
                        . "where l.idlit= '" . $rowpl2["idlit"] . "' ") or die(mysqli_error($con));
                $rowch = mysqli_fetch_assoc($reqch);
                ?>
                <?php print nl2br(htmlspecialchars($rowch["codechambre"])) ?> - <?php print nl2br(htmlspecialchars($rowch["codelit"])) ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["codepatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nompatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenompatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephonepatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephonepacpatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["datenaissancepatient"])) ?></td>
            <td><?php echo($recuser["libelledepartement"]); ?> - <?php echo($recuser["libelleregion"]); ?></td>
            <td>
                <?php
                $rsltuserd = $con->query("select * from hp_dossier as p where p.idpatient='" . $recuser["idpatient"] . "'") or die(mysqli_error($con));
                $nbd = mysqli_num_rows($rsltuserd);
                if ($nbd != 0) {
                    $recuserd = mysqli_fetch_assoc($rsltuserd);
                    print nl2br(htmlspecialchars($recuserd["lieudossier"]));
                    if ($recuserd["lieudossier"] == "Accueil") {
                        if ((isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Accueil")))) {
                            ?>
                            &nbsp;&nbsp;
                    <!--                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalediter/edit_patient'); ?>&idpatient=<?php echo $recuser["idpatient"]; ?>" >
                                <span title="Modifier cet patient" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                            </a>-->
                            <?php
                        }
                    } else if ($recuserd["lieudossier"] == "Caisse") {
                        if ((isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Caisse")))) {
                            ?>&nbsp;&nbsp;
                    <!--                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/patient_ajax'); ?>&iddossier=<?php echo $recuserd["iddossier"]; ?>&validercaisse=validercaisse" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Valider ce dossier ?'));" >
                                <span title="Valider le dossier cet patient" alt="list"><i class="glyphicon glyphicon-folder-open"></i></span>
                            </a>-->
                            <?php
                        }
                    } else if ($recuserd["lieudossier"] == "Médecin") {
                        if ((isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin")))) {
                            ?>&nbsp;&nbsp;
                    <!--                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/patient_ajax'); ?>&iddossier=<?php echo $recuserd["iddossier"]; ?>&validermedecin=validermedecin" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Valider ce dossier ?'));" >
                                <span title="Valider le dossier cet patient" alt="list"><i class="glyphicon glyphicon-folder-open"></i></span>
                            </a>-->
                            <?php
                        }
                    }
                }
                ?>

            </td>
        </tr>

        <?php
    }
}

function affiche_registre_patient($cl, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_registre_patient as rc left join hp_hospitalisation as pl on "
            . "rc.idhospitalisation=pl.idhospitalisation left join hp_sous_dossier as sd on "
            . "pl.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier left join "
            . "hp_patient as p on d.idpatient=p.idpatient left join hp_departement as de on p.residencepatient=de.iddepartement "
            . "left join hp_region as r on de.idregion=r.idregion  "
            . "where d.idpatient='" . $cl . "' order by rc.dateregistrepatient desc ") or die(mysqli_error($con));
    $tpaye = 0;
    $date = date('d-m-Y');
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateregistrepatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nompatient"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["prenompatient"])) ?>
                <?php print nl2br(htmlspecialchars($recuser["codepatient"])) ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["operationregistrepatient"])) ?></td>
            <td>
                <?php
                if ($recuser["operationregistrepatient"] == "Versement") {
                    print "-" . number_format($recuser["montantregistrepatient"], 0, ',', ' ');
                    $tpaye = $tpaye - $recuser["montantregistrepatient"];
                } else {
                    print number_format($recuser["montantregistrepatient"], 0, ',', ' ');
                    $tpaye = $tpaye + $recuser["montantregistrepatient"];
                }
                ?>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr >
        <td></td>
        <td><?php echo $date; ?></td>
        <td></td>
        <td></td>
        <td>
            <?php
            echo number_format($tpaye, 0, ',', ' ');
            ?>
        </td>
    </tr>
    <?php
}

//fonction pour deplacer une Patient
function deplacer_patient($id, $cha, $std, $app, $sal, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $reqpl = $con->query("select * from hp_deplacement_patient as dpl left join hp_hospitalisation as pl on "
            . "dpl.id_hospitalisation=pl.id_hospitalisation left join hp_recu as r on "
            . "dpl.id_deplacement_patient=r.id_deplacement_patient where pl.id_patient='" . $id . "' "
            . "and dpl.regle_dpl=false") or die(mysqli_error($con));
    $rowlo = mysqli_fetch_assoc($reqpl);
    $eta = 0;
    $reserve = 0;

    $datedpl21 = date("Y-m-d");
    $dif21 = dates_range(date('Y-m-d', strtotime($rowlo["date_debut_dpl"])), date('Y-m-d', strtotime($datedpl21)));
    $dif2 = $dif21 - 1;
    $prixpl2 = 0;

    $obh = "";
    if ($rowlo["id_chambre"] != NULL) {
        $reqch2 = $con->query("select * from hp_chambre where id_chambre= '" . $rowlo["id_chambre"] . "' ") or die(mysqli_error($con));
        $rowch2 = mysqli_fetch_assoc($reqch2);
        $obh = $rowch2["code_c"];
        if ($dif2 >= 0) {
            $prixpl2 = $dif2 * $rowch2["prix_c"];
        }
        $rsltch = $con->query("update hp_chambre set etat_c='" . $eta . "', reserve_c='" . $reserve . "' where id_chambre= '" . $rowlo["id_chambre"] . "' ") or die(mysqli_error($con));
    } else if ($rowlo["id_studio"] != NULL) {
        $reqch2 = $con->query("select * from hp_studio where id_studio= '" . $rowlo["id_studio"] . "' ") or die(mysqli_error($con));
        $rowch2 = mysqli_fetch_assoc($reqch2);
        $obh = $rowch2["code_s"];
        if ($dif2 >= 0) {
            $prixpl2 = $dif2 * $rowch2["prix_s"];
        }

        $reqst = $con->query("update hp_studio set etat_s='" . $eta . "', reserve_s='" . $reserve . "' where id_studio= '" . $rowlo["id_studio"] . "' ") or die(mysqli_error($con));
    } else if ($rowlo["id_appartement"] != NULL) {
        $reqch2 = $con->query("select * from hp_appartement where id_appartement= '" . $rowlo["id_appartement"] . "' ") or die(mysqli_error($con));
        $rowch2 = mysqli_fetch_assoc($reqch2);
        $obh = $rowch2["code_a"];
        if ($dif2 >= 0) {
            $prixpl2 = $dif2 * $rowch2["prix_a"];
        }
        $reqap = $con->query("update hp_appartement set etat_a='" . $eta . "', reserve_a='" . $reserve . "' where id_appartement= '" . $rowlo["id_appartement"] . "' ") or die(mysqli_error($con));
    } else if ($rowlo["id_salle"] != NULL) {
        $reqch2 = $con->query("select * from hp_salle where id_salle= '" . $rowlo["id_salle"] . "' ") or die(mysqli_error($con));
        $rowch2 = mysqli_fetch_assoc($reqch2);
        $obh = $rowch2["code_salle"];
        if ($dif2 >= 0) {
            $prixpl2 = $dif2 * $rowch2["prix_salle"];
        }
        $reqst = $con->query("update hp_salle set etat_salle='" . $eta . "', reserve_salle='" . $reserve . "' "
                . "where id_salle= '" . $rowlo["id_salle"] . "' ") or die(mysqli_error($con));
    }

    $rowplo = NULL;
    $op = "Déplacement";

    $occupe = 1;
    $datedpl2 = date("Y-m-d");
    $dif1 = dates_range(date('Y-m-d', strtotime($datedpl2)), date('Y-m-d', strtotime($rowlo["date_fin_dpl"])));
    $dif = $dif1 - 1;
    $prixpl = 0;

    if ($cha != NULL) {
        $reqch = $con->query("select * from hp_chambre where id_chambre= '" . $cha . "' ") or die(mysqli_error($con));
        $rowch = mysqli_fetch_assoc($reqch);
        $obh = $obh . "-->" . $rowch["code_c"];
        if ($dif >= 0) {
            $prixpl = $dif * $rowch["prix_c"];
        }
        if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rsltpl = $con->query("insert into hp_deplacement_patient(id_hospitalisation, id_chambre, receptionniste, "
                    . "prixunitairedeplacementpatient, prix_dpl, date_debut_dpl, date_fin_dpl, date_dpl) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $cha . "', '" . $_SESSION["id_compte_personnel"] . "', '" . $rowch["prix_c"] . "', "
                    . "'" . $prixpl . "', NOW(), '" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltpl = $con->query("insert into hp_deplacement_patient(id_hospitalisation, id_chambre, prixunitairedeplacementpatient, "
                    . "prix_dpl, date_debut_dpl, date_fin_dpl, date_dpl) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $cha . "', '" . $rowch["prix_c"] . "', '" . $prixpl . "', NOW(), "
                    . "'" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqpl = $con->query("select * from hp_deplacement_patient where "
                . "id_hospitalisation= '" . $rowlo["id_hospitalisation"] . "' and regle_dpl=false ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($reqpl);

        $rsltch = $con->query("update hp_chambre set etat_c='" . $occupe . "' where id_chambre= '" . $cha . "'") or die(mysqli_error($con));

        $rsltre = $con->query("insert into hp_recu(id_deplacement_patient, montant, date_debut_re, date_fin_re, date_recu) "
                . "values('" . $rowpl["id_deplacement_patient"] . "', '" . $prixpl . "', NOW(), "
                . "'" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        $prixregistre2 = $prixpl - $prixpl2;
        $prixregistre = 0;
        if ($prixregistre2 >= 0) {
            $prixregistre = $prixregistre2;
        }

        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hp_registre_patient(id_hospitalisation, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowlo["id_hospitalisation"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            if ($prixregistre >= 0) {
                $opv = "Versement";
                $rsltregv = $con->query("insert into hp_registre_patient(id_hospitalisation, montant_reg, operation_reg, date_registre) "
                        . "values('" . $rowlo["id_hospitalisation"] . "', '" . $prixregistre . "', '" . $opv . "', NOW())") or die(mysqli_error($con));
            }
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hp_registre_patient(id_hospitalisation, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            if ($prixregistre >= 0) {
                $opv = "Versement";
                $rsltregv = $con->query("insert into hp_registre_patient(id_hospitalisation, id_compte_personnel, montant_reg, "
                        . "operation_reg, date_registre) values('" . $rowlo["id_hospitalisation"] . "', "
                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixregistre . "', '" . $opv . "', NOW())") or die(mysqli_error($con));
            }
        }
        $reqplo = $con->query("select * from hp_deplacement_patient where "
                . "id_hospitalisation= '" . $rowlo["id_hospitalisation"] . "' and regle_dpl=false ") or die(mysqli_error($con));
        $rowplo = mysqli_fetch_assoc($reqplo);
    } else if ($std != NULL) {
        $reqst = $con->query("select * from hp_studio where id_studio= '" . $std . "' ") or die(mysqli_error($con));
        $rowst = mysqli_fetch_assoc($reqst);
        $obh = $obh . "-->" . $rowst["code_s"];
        if ($dif >= 0) {
            $prixpl = $dif * $rowst["prix_s"];
        }
        if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rsltpl = $con->query("insert into hp_deplacement_patient(id_hospitalisation, id_studio, receptionniste, "
                    . "prixunitairedeplacementpatient, prix_dpl, date_debut_dpl, date_fin_dpl, date_dpl) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $std . "', '" . $_SESSION["id_compte_personnel"] . "', '" . $rowst["prix_s"] . "', "
                    . "'" . $prixpl . "', NOW(), '" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltpl = $con->query("insert into hp_deplacement_patient(id_hospitalisation, id_studio, "
                    . "prixunitairedeplacementpatient, prix_dpl, date_debut_dpl, date_fin_dpl, date_dpl) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $std . "', '" . $rowst["prix_s"] . "', "
                    . "'" . $prixpl . "', NOW(), '" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqpl = $con->query("select * from hp_deplacement_patient where "
                . "id_hospitalisation= '" . $rowlo["id_hospitalisation"] . "' and regle_dpl=false ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($reqpl);

        $rsltch = $con->query("update hp_studio set etat_s='" . $occupe . "' where id_studio= '" . $std . "'") or die(mysqli_error($con));

        $rsltre = $con->query("insert into hp_recu(id_deplacement_patient, montant, date_debut_re, date_fin_re, date_recu) "
                . "values('" . $rowpl["id_deplacement_patient"] . "', '" . $prixpl . "', NOW(), "
                . "'" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        $prixregistre2 = $prixpl - $prixpl2;
        $prixregistre = 0;
        if ($prixregistre2 >= 0) {
            $prixregistre = $prixregistre2;
        }

        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hp_registre_patient(id_hospitalisation, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowlo["id_hospitalisation"] . "', '" . $prixregistre . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hp_registre_patient(id_hospitalisation, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixregistre . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $reqplo = $con->query("select * from hp_deplacement_patient where "
                . "id_hospitalisation= '" . $rowlo["id_hospitalisation"] . "' and regle_dpl=false ") or die(mysqli_error($con));
        $rowplo = mysqli_fetch_assoc($reqplo);
    } else if ($app != NULL) {
        $reqap = $con->query("select * from hp_appartement where id_appartement= '" . $app . "' ") or die(mysqli_error($con));
        $rowap = mysqli_fetch_assoc($reqap);
        $obh = $obh . "-->" . $rowap["code_a"];
        if ($dif >= 0) {
            $prixpl = $dif * $rowap["prix_a"];
        }
        if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rsltpl = $con->query("insert into hp_deplacement_patient(id_hospitalisation, id_appartement, receptionniste, "
                    . "prixunitairedeplacementpatient, prix_dpl, date_debut_dpl, date_fin_dpl, date_dpl) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $app . "', '" . $_SESSION["id_compte_personnel"] . "', '" . $rowap["prix_a"] . "', "
                    . "'" . $prixpl . "', NOW(), '" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltpl = $con->query("insert into hp_deplacement_patient(id_hospitalisation, id_appartement, "
                    . "prixunitairedeplacementpatient, prix_dpl, date_debut_dpl, date_fin_dpl, date_dpl) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $app . "', '" . $rowap["prix_a"] . "', "
                    . "'" . $prixpl . "', NOW(), '" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqpl = $con->query("select * from hp_deplacement_patient where "
                . "id_hospitalisation= '" . $rowlo["id_hospitalisation"] . "' and regle_dpl=false ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($reqpl);

        $rsltch = $con->query("update hp_appartement set etat_a='" . $occupe . "' where id_appartement= '" . $app . "'") or die(mysqli_error($con));

        $rsltre = $con->query("insert into hp_recu(id_deplacement_patient, montant, date_debut_re, date_fin_re, date_recu) "
                . "values('" . $rowpl["id_deplacement_patient"] . "', '" . $prixpl . "', NOW(), "
                . "'" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        $prixregistre2 = $prixpl - $prixpl2;
        $prixregistre = 0;
        if ($prixregistre2 >= 0) {
            $prixregistre = $prixregistre2;
        }

        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hp_registre_patient(id_hospitalisation, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowlo["id_hospitalisation"] . "', '" . $prixregistre . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hp_registre_patient(id_hospitalisation, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixregistre . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $reqplo = $con->query("select * from hp_deplacement_patient where "
                . "id_hospitalisation= '" . $rowlo["id_hospitalisation"] . "' and regle_dpl=false ") or die(mysqli_error($con));
        $rowplo = mysqli_fetch_assoc($reqplo);
    } else if ($sal != NULL) {
        $reqst = $con->query("select * from hp_salle where id_salle= '" . $sal . "' ") or die(mysqli_error($con));
        $rowst = mysqli_fetch_assoc($reqst);
        $obh = $obh . "-->" . $rowst["code_salle"];
        if ($dif >= 0) {
            $prixpl = $dif * $rowst["prix_salle"];
        }
        if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rsltpl = $con->query("insert into hp_deplacement_patient(id_hospitalisation, id_salle, receptionniste, "
                    . "prixunitairedeplacementpatient, prix_dpl, date_debut_dpl, date_fin_dpl, date_dpl) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $sal . "', '" . $_SESSION["id_compte_personnel"] . "', '" . $rowst["prix_salle"] . "', "
                    . "'" . $prixpl . "', NOW(), '" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltpl = $con->query("insert into hp_deplacement_patient(id_hospitalisation, id_salle, "
                    . "prixunitairedeplacementpatient, prix_dpl, date_debut_dpl, date_fin_dpl, date_dpl) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $sal . "', '" . $rowst["prix_salle"] . "', "
                    . "'" . $prixpl . "', NOW(), '" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqpl = $con->query("select * from hp_deplacement_patient where "
                . "id_hospitalisation= '" . $rowlo["id_hospitalisation"] . "' and regle_dpl=false ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($reqpl);

        $rsltch = $con->query("update hp_salle set etat_salle='" . $occupe . "' where id_salle= '" . $sal . "'") or die(mysqli_error($con));

        $rsltre = $con->query("insert into hp_recu(id_deplacement_patient, montant, date_debut_re, date_fin_re, date_recu) "
                . "values('" . $rowpl["id_deplacement_patient"] . "', '" . $prixpl . "', NOW(), "
                . "'" . $rowlo["date_fin_dpl"] . "', NOW())") or die(mysqli_error($con));
        $prixregistre2 = $prixpl - $prixpl2;
        $prixregistre = 0;
        if ($prixregistre2 >= 0) {
            $prixregistre = $prixregistre2;
        }

        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hp_registre_patient(id_hospitalisation, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowlo["id_hospitalisation"] . "', '" . $prixregistre . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hp_registre_patient(id_hospitalisation, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowlo["id_hospitalisation"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixregistre . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $reqplo = $con->query("select * from hp_deplacement_patient where "
                . "id_hospitalisation= '" . $rowlo["id_hospitalisation"] . "' and regle_dpl=false ") or die(mysqli_error($con));
        $rowplo = mysqli_fetch_assoc($reqplo);
    }
    $regle = 1;
    $rsltcpl = $con->query("update hp_deplacement_patient set regle_dpl='" . $regle . "', prix_dpl='" . $prixpl2 . "', "
            . "date_fin_dpl=NOW() where id_deplacement_patient= '" . $rowlo["id_deplacement_patient"] . "'") or die(mysqli_error($con));
    $reqplod = $con->query("select * from hp_deplacement_patient where "
            . "id_hospitalisation= '" . $rowlo["id_hospitalisation"] . "' ") or die(mysqli_error($con));
    $nbplod = mysqli_num_rows($reqplod);
    $log = "Logement";
    $depl = "Déplacement";
    if ($nbplod == 2) {
        $rsltcre = $con->query("update hp_registre_patient set montant_reg='" . $prixpl2 . "' where "
                . "id_hospitalisation='" . $rowlo["id_hospitalisation"] . "' and (operation_reg= '" . $log . "' "
                . ")") or die(mysqli_error($con));
    } else if ($nbplod == 3) {
        $rsltcre = $con->query("update hp_registre_patient set montant_reg='" . $prixpl2 . "' where "
                . "id_hospitalisation='" . $rowlo["id_hospitalisation"] . "' and (operation_reg='" . $depl . "')") or die(mysqli_error($con));
    }

    $reqr = $con->query("select * from hp_recu where id_deplacement_patient= '" . $rowplo["id_deplacement_patient"] . "' order by date_recu desc LIMIT 0,1") or die(mysqli_error($con));
    $rowr = mysqli_fetch_assoc($reqr);
    $oph = "Déplacement";
    if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
        $rslthisto = $con->query("insert into hp_historique(id_proprietaire, id_patient, operation_h, objet_h, date_histo) "
                . "values('" . $_SESSION["id_proprietaire"] . "', '" . $id . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
    } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
        $rslthisto = $con->query("insert into hp_historique(id_compte_personnel, id_patient, operation_h, objet_h, date_histo) "
                . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $id . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
    }
    echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    ?>
    <a href="hopitalpages/hopitalpatient/facture_patient_inc_pdf.php?recu=<?php echo $rowr["idfacture"] ?>" class="btn btn-lg btn-info" target="_blank">
        <span title="Imprimer la facture du patient" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
    </a>
    <?php
}

function lister_ordonnance($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_ordonnance as a order by a.dateordonnance desc") or
            die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeordonnance"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantordonnance"])) ?></td>
            <td>
                <?php
                if ($recuser["etatordonnance"] == "En Cours") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatordonnance"])) ?>" data-toggle="tooltip" alt="non" class="label-warning label"><?php print nl2br(htmlspecialchars($recuser["etatordonnance"])) ?></span>
                    <?php
                } else if ($recuser["etatordonnance"] == "Payée") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatordonnance"])) ?>" data-toggle="tooltip" alt="non" class="label-info label"><?php print nl2br(htmlspecialchars($recuser["etatordonnance"])) ?></span>
                    <?php
                } else if ($recuser["etatordonnance"] == "Livrée") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatordonnance"])) ?>" data-toggle="tooltip" alt="non" class="label-success label"><?php print nl2br(htmlspecialchars($recuser["etatordonnance"])) ?></span>
                    <?php
                } else {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatordonnance"])) ?>" data-toggle="tooltip" alt="non" class="label-danger label"><?php print nl2br(htmlspecialchars($recuser["etatordonnance"])) ?></span>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateordonnance"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/lister_ordonnance_ligne') ?>&ordonnance=<?php echo $recuser["idordonnance"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etatordonnance"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/commander_patient') ?>&ordonnance=<?php echo $recuser["idordonnance"] ?>">
                            <span title="Livrer cette Ordonnance" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Pharmacien")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/lister_ordonnance_ligne') ?>&ordonnance=<?php echo $recuser["idordonnance"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if (($recuser["etatordonnance"] == "Payée") || (($recuser["idhospitalisation"] != NULL) && ($recuser["etatordonnance"] != "Livrée"))) {
                            ?>
                            &nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/commander_patient') ?>&ordonnance=<?php echo $recuser["idordonnance"] ?>">
                                <span title="Livrer cette Ordonnance" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
                <!--                &nbsp;&nbsp;
                                <a href="hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/facture_ordonnance_pdf.php?ordonnance=<?php echo $recuser["idordonnance"] ?>" target="blank">
                                    <span title="Impriner le bon de ordonnance" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                                </a>
                                &nbsp;&nbsp;
                                <a href="hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/facture_ordonnance_excel.php?ordonnance=<?php echo $recuser["idordonnance"] ?>" target="blank">
                                    <span title="Exporter le bon de ordonnance" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                                </a>-->
            </td>
        </tr>
        <?php
    }
}

function lister_ordonnance_ligne($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_ligne_ordonnance as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
            . "lbl.idordonnance='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stockligneordonnance"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stocklivreligneordonnance"])) ?></td>
            <td>
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["idunite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["codeunite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixligneordonnance"])) ?></td>
            <td><?php print ($recuser["stockligneordonnance"] * $recuser["prixligneordonnance"]); ?></td>
            <td>
                <?php
                if ($recuser["etatligneordonnance"] == "En Cours") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatligneordonnance"])) ?>" data-toggle="tooltip" alt="non" class="label-warning label"><?php print nl2br(htmlspecialchars($recuser["etatligneordonnance"])) ?></span>
                    <?php
                } else if ($recuser["etatligneordonnance"] == "Payée") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatligneordonnance"])) ?>" data-toggle="tooltip" alt="non" class="label-info label"><?php print nl2br(htmlspecialchars($recuser["etatligneordonnance"])) ?></span>
                    <?php
                } else if ($recuser["etatligneordonnance"] == "Livrée") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatligneordonnance"])) ?>" data-toggle="tooltip" alt="non" class="label-success label"><?php print nl2br(htmlspecialchars($recuser["etatligneordonnance"])) ?></span>
                    <?php
                } else {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatligneordonnance"])) ?>" data-toggle="tooltip" alt="non" class="label-danger label"><?php print nl2br(htmlspecialchars($recuser["etatligneordonnance"])) ?></span>
                    <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Directeur de Centre")) {
                        ?>

                        <?php
                        if ($recuser["etatligneordonnance"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=livrer_bon_liv_pharmacie_ligne(<?php echo $recuser["idligneordonnance"] ?>)>
                                <span title="Livrer cette ligne de bon de ordonnance" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                        ?>

                        <?php
                        if ($recuser["etatligneordonnance"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=livrer_bon_liv_pharmacie_ligne(<?php echo $recuser["idligneordonnance"] ?>)>
                                <span title="Livrer cette ligne de bon de ordonnance" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["rolepersonnel"] == "Pharmacien")) {
                        ?>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function ajouter_commande_pharmacie_patient($cli, $prixtb, $com, $con) {
    if (($com != NULL)) {
        $rsltpl2 = $con->query("select * from hp_ordonnance as o left join hp_sous_dossier as sd on o.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                . "o.idordonnance='" . $cli . "'") or die(mysqli_error($con));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);
//        echo "<script language='javascript'>alert('ouppps')</script>";
        $an = date('Y');
        $obh = "";
        $etat = "Livrée";
        $numid = "LO" . date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hp_livraison_ordonnance where YEAR(datelivraisonordonnance)='" . $an . "'") or die(mysqli_error($con));
        $i = $reqte = mysqli_num_rows($req1);

        $numid = "LO" . date('Y', time()) . sprintf("%08d", ($i + 1));

//        if (isset($_SESSION["idcomptepersonnel"])) {
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltf = $con->query("insert into hp_livraison_ordonnance(idpharmacie, idordonnance, codelivraisonordonnance, "
                    . "montantlivraisonordonnance, datelivraisonordonnance) values('" . $_SESSION["idpharmacie"] . "', "
                    . "'" . $rowpl2["idordonnance"] . "', '" . $numid . "', '" . $prixtb . "', "
                    . "NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hp_livraison_ordonnance(idcomptepersonnel, idpharmacie, idordonnance, "
                    . "codelivraisonordonnance, montantlivraisonordonnance, datelivraisonordonnance) values("
                    . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $_SESSION["idpharmacie"] . "', "
                    . "'" . $rowpl2["idordonnance"] . "', '" . $numid . "', '" . $prixtb . "', "
                    . "NOW())") or die(mysqli_error($con));
        }

//        } else {
//            $rsltf = $con->query("insert into hp_livraison_ordonnance(idpharmacie, idordonnance, codelivraisonordonnance, "
//                    . "montantlivraisonordonnance, datelivraisonordonnance) values('" . $_SESSION["idpharmacie"] . "', "
//                    . "'" . $rowpl2["idordonnance"] . "', '" . $numid . "', '" . $prixtb . "', "
//                    . "NOW())") or die(mysqli_error($con));
//        }
        $rsltfa = $con->query("select * from hp_livraison_ordonnance where codelivraisonordonnance='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodlsosop" . $cli] as $prod) {
            $reqar = $con->query("select * from hp_boutique as mb left join hp_produit as a on "
                    . "mb.idproduit=a.idproduit where mb.idboutique='" . $prod["idbout"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);

            $con->query("insert into hp_ligne_livraison_ordonnance(idboutique, idlivraisonordonnance, idunite, stocklignelivraisonordonnance, "
                            . "prixlignelivraisonordonnance) values('" . $prod["idbout"] . "', '" . $rowfa["idlivraisonordonnance"] . "', "
                            . "'" . $prod["uniteartliv"] . "', '" . $prod["qteart"] . "', '" . $prod["prixartliv"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["prixartliv"] * $prod["qteart"]);
            $obh = $prod["qteart"] . "-" . addslashes($prod["designationart"]);

            $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $prod["uniteartliv"] . "' "
                    . "and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
            $npharmaciepa = mysqli_num_rows($rsltuarpa);

            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
            if ($npharmaciepa != 0) {
                $stockara = $rowarpa["stockconversion"] - $prod["qteart"];
                $rsltuarpapr = $con->query("select * from hp_conversion where idunite<>'" . $prod["uniteartliv"] . "' "
                        . "and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                while ($rowarpapr = mysqli_fetch_assoc($rsltuarpapr)) {
                    $stockarae = 0;
                    if ($rowarpa["stockconversion"] != 0) {
                        $stockarae = ($rowarpapr["stockconversion"] - (($prod["qteart"] * $rowarpapr["stockconversion"]) / $rowarpa["stockconversion"]));
                    }
                    $stockare = 0;
                    if ($stockarae >= 0) {
                        $stockare = $stockarae;
                    } else {
                        $stockare = 0;
                    }
                    $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockare . "' where "
                            . "idunite='" . $rowarpapr["idunite"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                }

                $stockarap = 0;
                if ($rowarpa["stockconversion"] != 0) {
                    $stockarap = $rowar["stockboutique"] - (($prod["qteart"] * $rowar["stockboutique"]) / ($rowarpa["stockconversion"]));
                }
                $stockar = 0;
                if ($stockara >= 0) {
                    $stockar = $stockara;
                } else {
                    $stockar = 0;
                }
                $stockarp = 0;
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }

                $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockar . "' where "
                        . "idunite='" . $prod["uniteartliv"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                $con->query("update hp_boutique set stockboutique='" . $stockarp . "' where "
                                . "idboutique='" . $prod["idbout"] . "'") or die(mysqli_error($con));
            } else {
                $stockarap = $rowar["stockboutique"] - $prod["qteart"];
                $stockarp = 0;
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }

                $rsltuarpap = $con->query("select * from hp_conversion where idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                while ($rowarpap = mysqli_fetch_assoc($rsltuarpap)) {
                    $stockara = ($rowarpap["stockconversion"] - ($prod["qteart"] * $rowarpap["conversion"]));
                    $stockar = 0;
                    if ($stockara >= 0) {
                        $stockar = $stockara;
                    } else {
                        $stockar = 0;
                    }
                    $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockar . "' where "
                            . "idunite='" . $rowarpap["idunite"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                }

                $con->query("update hp_boutique set stockboutique='" . $stockarp . "' where "
                                . "idboutique='" . $prod["idbout"] . "'") or die(mysqli_error($con));
            }
            $rsltpl2d = $con->query("select * from hp_ligne_ordonnance as o where "
                    . "o.idligneordonnance='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowpl2d = mysqli_fetch_assoc($rsltpl2d);
            $slivre = $rowpl2d["stocklivreligneordonnance"] + $prod["qteart"];
            if ($prod["stockok"]) {
                $rslt = $con->query("update hp_ligne_ordonnance set stocklivreligneordonnance='" . $slivre . "', "
                        . "etatligneordonnance='" . $etat . "' where idligneordonnance='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
                $rslt = $con->query("update hp_ligne_ordonnance set stocklivreligneordonnance='" . $slivre . "' "
                        . "where idligneordonnance='" . $prod["idart"] . "'") or die(mysqli_error($con));
            }

            $oph = "Ordonnace";
//            if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
//                $rslthisto = $con->query("insert into hp_trace(idproprietaire, idproduit, "
//                        . "idpatient, operation, objet, datetrace) values('" . $_SESSION["idproprietaire"] . "', "
//                        . "'" . $rowar["idproduit"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', "
//                        . "NOW())") or die(mysqli_error($con));
//            } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["idcomptepersonnel"])) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idproduit, "
                                . "idpatient, operation, objet, datetrace) values("
                                . "'" . $rowar["idproduit"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', "
                                . "NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idcomptepersonnel, idproduit, "
                                . "idpatient, operation, objet, datetrace) values('" . $_SESSION["idcomptepersonnel"] . "', "
                                . "'" . $rowar["idproduit"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', "
                                . "NOW())") or die(mysqli_error($con));
            }

//            }
        }


        $eta = "En Cours";
        $etap = "Payée";
        $reqarc = $con->query("select * from hp_ligne_ordonnance where idordonnance='" . $rowpl2["idordonnance"] . "' and "
                . "etatligneordonnance='" . $eta . "' or etatligneordonnance='" . $etap . "'") or die(mysqli_error($con));
        $npharmaciec = mysqli_num_rows($reqarc);
        if ($npharmaciec == 0) {
            $rslt = $con->query("update hp_ordonnance set etatordonnance='" . $etat . "' where "
                    . "idordonnance='" . $rowpl2["idordonnance"] . "'") or die(mysqli_error($con));
        }
        ?>
        <?php
        $op = "ordonance ";
        if ($rowpl2["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                        . "dateregistrepatient) values('" . $rowpl2["idhospitalisation"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                        . "operationregistrepatient, dateregistrepatient) values('" . $rowpl2["idhospitalisation"] . "', "
                        . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
        }

//        $contenu = NULL;
//        $op = "Bar";
//        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
//            $rsltreg = $con->query("insert into hp_registre_patient(id_ordonnance, montant_reg, operation_reg, date_registre) "
//                    . "values('" . $rowpl2["id_ordonnance"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
//            $rsltreg = $con->query("insert into hp_registre_patient(id_ordonnance, idcomptepersonnel, montant_reg, "
//                    . "operation_reg, date_registre) values('" . $rowpl2["id_ordonnance"] . "', "
//                    . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//        }
        unset($_SESSION["cart_prodlordp" . $cli]);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/facture_ordonnance_pdf.php?livraisonordonnance=<?php echo $rowfa["idlivraisonordonnance"] ?>" class="btn btn-lg btn-info" target="_blank">
            <span title="Imprimer la facture du patient" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function modifier_soin_patient($id, $prixtotal, $com, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($com != NULL)) {
        $an = date('Y');

        $etat = "Valider";

        $rsltplk = $con->query("select * from hp_soin_patient as c left join hp_hospitalisation as h on "
                . "c.idhospitalisation=h.idhospitalisation left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idsoinpatient='" . $id . "'") or die(mysqli_error($con));
        $rowservk = mysqli_fetch_assoc($rsltplk);

        $prixt = 0;
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvsoine" . $id] as $prod) {
            $reqar = $con->query("select * from hp_ligne_soin_patient as lbl left join hp_produit as a on "
                    . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie "
                    . "where lbl.idsoinpatient='" . $id . "' and lbl.idproduit='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $nbar = mysqli_num_rows($reqar);
            if ($nbar == 0) {
                $con->query("insert into hp_ligne_soin_patient(idsoinpatient, idunitesoinpatient, idproduit, quantitelignesoinpatient, "
                                . "prixlignesoinpatient, datelignesoinpatient) values('" . $rowservk["idsoinpatient"] . "', "
                                . "'" . $prod["uniteart"] . "', '" . $prod["idart"] . "', '" . $prod["qteart"] . "', "
                                . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
            } else {
                $rowar = mysqli_fetch_assoc($reqar);
                $con->query("update hp_ligne_soin_patient set idunitesoinpatient='" . $prod["uniteart"] . "', "
                                . "quantitelignesoinpatient='" . $prod["qteart"] . "', prixlignesoinpatient='" . $prod["prixart"] . "' "
                                . "where idlignesoinpatient='" . $rowar["idlignesoinpatient"] . "'") or die(mysqli_error($con));
            }

            $obj = "Soin " . $id . "-" . $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Modification soin";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, objet, operation, "
                        . "datetrace) values('" . $prod["idart"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, "
                        . "datetrace) values('" . $prod["idart"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
        }

        $con->query("update hp_soin_patient set prixsoinpatient='" . $prixtotal . "' where idsoinpatient='" . $id . "'") or die(mysqli_error($con));
        $con->query("update hp_facture set montantfacture='" . $prixtotal . "' where idsoinpatient='" . $id . "'") or die(mysqli_error($con));
        ?>
        <?php
        unset($_SESSION["cart_prodvsoine" . $id]);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalfacture/lister_facture';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function modifier_ordonnance($id, $prixtotal, $com, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($com != NULL)) {
        $an = date('Y');

        $etat = "Valider";

        $rsltplk = $con->query("select * from hp_ordonnance as c where "
                . "c.idordonnance='" . $id . "'") or die(mysqli_error($con));
        $rowservk = mysqli_fetch_assoc($rsltplk);
        $rsltplkf = $con->query("select * from hp_facture as c where "
                . "c.idordonnance='" . $id . "'") or die(mysqli_error($con));
        $rowservkf = mysqli_fetch_assoc($rsltplkf);
        $idf=$rowservkf["idfacture"];
 $con->query(" delete from hp_ligne_ordonnance where idordonnance='" . $id . "' ") or die(mysqli_error($con));
           
        $prixt = 0;
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvordoe" . $id] as $prod) {
            $reqar = $con->query("select * from hp_ligne_ordonnance as lbl left join hp_produit as a on "
                    . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie "
                    . "where lbl.idordonnance='" . $id . "' and lbl.idproduit='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $nbar = mysqli_num_rows($reqar);
            if ($nbar == 0) {
                $pod=$prod["idart"];
                echo "<script language='javascript'>alert($pod)</script>";
                $con->query("insert into hp_ligne_ordonnance(idordonnance, idunite, idproduit, stockligneordonnance, "
                                . "prixligneordonnance) values('" . $rowservk["idordonnance"] . "', "
                                . "'" . $prod["uniteart"] . "', '" . $prod["idart"] . "', '" . $prod["qteart"] . "', "
                                . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));
            } else {
                $rowar = mysqli_fetch_assoc($reqar);
                $con->query("update hp_ligne_ordonnance set idunite='" . $prod["uniteart"] . "', "
                                . "stockligneordonnance='" . $prod["qteart"] . "', prixligneordonnance='" . $prod["prixart"] . "' "
                                . "where idligneordonnance='" . $rowar["idligneordonnance"] . "'") or die(mysqli_error($con));
            }

            $obj = "Ordonnance " . $id . "-" . $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Modification ordonnance";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, objet, operation, "
                        . "datetrace) values('" . $prod["idart"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, "
                        . "datetrace) values('" . $prod["idart"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
        }

        $con->query("update hp_ordonnance set montantordonnance='" . $prixtotal . "' where idordonnance='" . $id . "'") or die(mysqli_error($con));
        $con->query("update hp_facture set montantfacture='" . $prixtotal . "' where idordonnance='" . $id . "'") or die(mysqli_error($con));
        ?>
        <?php
        unset($_SESSION["cart_prodvordoe" . $id]);
        unset($_SESSION["cart_prodvfactordo" . $idf]);
        echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalfacture/hopitalfactureordonnance/paie_facture_patient';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idfacture='.$rowservkf["idfacture"].'">');
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_soinpatient($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_soin_patient as a order by a.datesoinpatient desc") or
            die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codesoinpatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixsoinpatient"])) ?></td>
            <td>
                <?php
                if ($recuser["etatsoinpatient"] == "En Cours") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatsoinpatient"])) ?>" data-toggle="tooltip" alt="non" class="label-warning label"><?php print nl2br(htmlspecialchars($recuser["etatsoinpatient"])) ?></span>
                    <?php
                } else if ($recuser["etatsoinpatient"] == "Payé") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatsoinpatient"])) ?>" data-toggle="tooltip" alt="non" class="label-info label"><?php print nl2br(htmlspecialchars($recuser["etatsoinpatient"])) ?></span>
                    <?php
                } else if ($recuser["etatsoinpatient"] == "Livré") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatsoinpatient"])) ?>" data-toggle="tooltip" alt="non" class="label-success label"><?php print nl2br(htmlspecialchars($recuser["etatsoinpatient"])) ?></span>
                    <?php
                } else {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatsoinpatient"])) ?>" data-toggle="tooltip" alt="non" class="label-danger label"><?php print nl2br(htmlspecialchars($recuser["etatsoinpatient"])) ?></span>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["datesoinpatient"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsortiesoinpatient/lister_soinpatient_ligne') ?>&soinpatient=<?php echo $recuser["idsoinpatient"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etatsoinpatient"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsortiesoinpatient/sortiesoin_patient') ?>&soinpatient=<?php echo $recuser["idsoinpatient"] ?>">
                            <span title="Sortir les produits de ce soin" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Pharmacien")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsortiesoinpatient/lister_soinpatient_ligne') ?>&soinpatient=<?php echo $recuser["idsoinpatient"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if (($recuser["etatsoinpatient"] == "Payé") || (($recuser["idhospitalisation"] != NULL) && ($recuser["etatsoinpatient"] != "Livré"))) {
                            ?>
                            &nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsortiesoinpatient/sortiesoin_patient') ?>&soinpatient=<?php echo $recuser["idsoinpatient"] ?>">
                                <span title="Sortir les produits de ce soin" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
                <!--                &nbsp;&nbsp;
                                <a href="hopitalpages/hopitalpatient/hopitalsortiesoinpatient/facture_sortiesoin_pdf.php?soinpatient=<?php echo $recuser["idsoinpatient"] ?>" target="blank">
                                    <span title="Impriner le bon de soinpatient" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                                </a>
                                &nbsp;&nbsp;
                                <a href="hopitalpages/hopitalpatient/hopitalsortiesoinpatient/facture_sortiesoin_excel.php?soinpatient=<?php echo $recuser["idsoinpatient"] ?>" target="blank">
                                    <span title="Exporter le bon de soinpatient" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                                </a>-->
            </td>
        </tr>
        <?php
    }
}

function lister_soinpatient_ligne($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_ligne_soin_patient as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
            . "lbl.idsoinpatient='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["quantitelignesoinpatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["quantitelivrelignesoinpatient"])) ?></td>
            <td>
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["idunitesoinpatient"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["codeunite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixlignesoinpatient"])) ?></td>
            <td><?php print ($recuser["quantitelignesoinpatient"] * $recuser["prixlignesoinpatient"]); ?></td>
            <td>
                <?php
                if ($recuser["etatlignesoinpatient"] == "En Cours") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatlignesoinpatient"])) ?>" data-toggle="tooltip" alt="non" class="label-warning label"><?php print nl2br(htmlspecialchars($recuser["etatlignesoinpatient"])) ?></span>
                    <?php
                } else if ($recuser["etatlignesoinpatient"] == "Payé") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatlignesoinpatient"])) ?>" data-toggle="tooltip" alt="non" class="label-info label"><?php print nl2br(htmlspecialchars($recuser["etatlignesoinpatient"])) ?></span>
                    <?php
                } else if ($recuser["etatlignesoinpatient"] == "Livré") {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatlignesoinpatient"])) ?>" data-toggle="tooltip" alt="non" class="label-success label"><?php print nl2br(htmlspecialchars($recuser["etatlignesoinpatient"])) ?></span>
                    <?php
                } else {
                    ?>
                    <span title="<?php print nl2br(htmlspecialchars($recuser["etatlignesoinpatient"])) ?>" data-toggle="tooltip" alt="non" class="label-danger label"><?php print nl2br(htmlspecialchars($recuser["etatlignesoinpatient"])) ?></span>
                    <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Directeur de Centre")) {
                        ?>

                        <?php
                        if ($recuser["etatlignesoinpatient"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                    <!--                            <a href='#' onclick=livrer_bon_liv_pharmacie_ligne(<?php echo $recuser["idlignesoinpatient"] ?>)>
                                <span title="Livrer cette ligne de bon de soinpatient" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>-->
                            <?php
                        }
                    } else if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                        ?>

                        <?php
                        if ($recuser["etatlignesoinpatient"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                    <!--                            <a href='#' onclick=livrer_bon_liv_pharmacie_ligne(<?php echo $recuser["idlignesoinpatient"] ?>)>
                                <span title="Livrer cette ligne de bon de soinpatient" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>-->
                            <?php
                        }
                    } else if (($_SESSION["rolepersonnel"] == "Pharmacien")) {
                        ?>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function ajouter_sortiesoin_patient($cli, $prixtb, $com, $con) {
    if (($com != NULL)) {
        $rsltpl2 = $con->query("select * from hp_soin_patient as o left join hp_hospitalisation as h on "
                . "o.idhospitalisation=h.idhospitalisation left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                . "o.idsoinpatient='" . $cli . "'") or die(mysqli_error($con));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);
//        echo "<script language='javascript'>alert('ouppps')</script>";
        $an = date('Y');
        $obh = "";
        $etat = "Livré";
        $numid = "LO" . date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hp_sortie_soin where YEAR(datesortiesoin)='" . $an . "'") or die(mysqli_error($con));
        $i = $reqte = mysqli_num_rows($req1);

        $numid = "LO" . date('Y', time()) . sprintf("%08d", ($i + 1));

//        if (isset($_SESSION["idcomptepersonnel"])) {
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltf = $con->query("insert into hp_sortie_soin(idpharmacie, idsoinpatient, codesortiesoin, "
                    . "montantsortiesoin, datesortiesoin) values('" . $_SESSION["idpharmacie"] . "', "
                    . "'" . $rowpl2["idsoinpatient"] . "', '" . $numid . "', '" . $prixtb . "', "
                    . "NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hp_sortie_soin(idcomptepersonnel, idpharmacie, idsoinpatient, "
                    . "codesortiesoin, montantsortiesoin, datesortiesoin) values("
                    . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $_SESSION["idpharmacie"] . "', "
                    . "'" . $rowpl2["idsoinpatient"] . "', '" . $numid . "', '" . $prixtb . "', "
                    . "NOW())") or die(mysqli_error($con));
        }

//        } else {
//            $rsltf = $con->query("insert into hp_sortie_soin(idpharmacie, idsoinpatient, codesortiesoin, "
//                    . "montantsortiesoin, datesortiesoin) values('" . $_SESSION["idpharmacie"] . "', "
//                    . "'" . $rowpl2["idsoinpatient"] . "', '" . $numid . "', '" . $prixtb . "', "
//                    . "NOW())") or die(mysqli_error($con));
//        }
        $rsltfa = $con->query("select * from hp_sortie_soin where codesortiesoin='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodlsosop" . $cli] as $prod) {
            $reqar = $con->query("select * from hp_boutique as mb left join hp_produit as a on "
                    . "mb.idproduit=a.idproduit where mb.idboutique='" . $prod["idbout"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);

            $con->query("insert into hp_ligne_sortie_soin(idboutique, idsortiesoin, idunite, stocklignesortiesoin, "
                            . "prixlignesortiesoin) values('" . $prod["idbout"] . "', '" . $rowfa["idsortiesoin"] . "', "
                            . "'" . $prod["uniteartliv"] . "', '" . $prod["qteart"] . "', '" . $prod["prixartliv"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["prixartliv"] * $prod["qteart"]);
            $obh = $prod["qteart"] . "-" . addslashes($prod["designationart"]);

            $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $prod["uniteartliv"] . "' "
                    . "and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
            $npharmaciepa = mysqli_num_rows($rsltuarpa);

            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
            if ($npharmaciepa != 0) {
                $stockara = $rowarpa["stockconversion"] - $prod["qteart"];
                $rsltuarpapr = $con->query("select * from hp_conversion where idunite<>'" . $prod["uniteartliv"] . "' "
                        . "and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                while ($rowarpapr = mysqli_fetch_assoc($rsltuarpapr)) {
                    $stockarae = 0;
                    if ($rowarpa["stockconversion"] != 0) {
                        $stockarae = ($rowarpapr["stockconversion"] - (($prod["qteart"] * $rowarpapr["stockconversion"]) / $rowarpa["stockconversion"]));
                    }
                    $stockare = 0;
                    if ($stockarae >= 0) {
                        $stockare = $stockarae;
                    } else {
                        $stockare = 0;
                    }
                    $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockare . "' where "
                            . "idunite='" . $rowarpapr["idunite"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                }

                $stockarap = 0;
                if ($rowarpa["stockconversion"] != 0) {
                    $stockarap = $rowar["stockboutique"] - (($prod["qteart"] * $rowar["stockboutique"]) / ($rowarpa["stockconversion"]));
                }
                $stockar = 0;
                if ($stockara >= 0) {
                    $stockar = $stockara;
                } else {
                    $stockar = 0;
                }
                $stockarp = 0;
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }

                $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockar . "' where "
                        . "idunite='" . $prod["uniteartliv"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                $con->query("update hp_boutique set stockboutique='" . $stockarp . "' where "
                                . "idboutique='" . $prod["idbout"] . "'") or die(mysqli_error($con));
            } else {
                $stockarap = $rowar["stockboutique"] - $prod["qteart"];
                $stockarp = 0;
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }

                $rsltuarpap = $con->query("select * from hp_conversion where idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                while ($rowarpap = mysqli_fetch_assoc($rsltuarpap)) {
                    $stockara = ($rowarpap["stockconversion"] - ($prod["qteart"] * $rowarpap["conversion"]));
                    $stockar = 0;
                    if ($stockara >= 0) {
                        $stockar = $stockara;
                    } else {
                        $stockar = 0;
                    }
                    $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockar . "' where "
                            . "idunite='" . $rowarpap["idunite"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                }

                $con->query("update hp_boutique set stockboutique='" . $stockarp . "' where "
                                . "idboutique='" . $prod["idbout"] . "'") or die(mysqli_error($con));
            }
            $rsltpl2d = $con->query("select * from hp_ligne_soin_patient as o where "
                    . "o.idlignesoinpatient='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowpl2d = mysqli_fetch_assoc($rsltpl2d);
            $slivre = $rowpl2d["quantitelivrelignesoinpatient"] + $prod["qteart"];
            if ($prod["stockok"]) {
                $rslt = $con->query("update hp_ligne_soin_patient set quantitelivrelignesoinpatient='" . $slivre . "', "
                        . "etatlignesoinpatient='" . $etat . "' where idlignesoinpatient='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
                $rslt = $con->query("update hp_ligne_soin_patient set quantitelivrelignesoinpatient='" . $slivre . "' "
                        . "where idlignesoinpatient='" . $prod["idart"] . "'") or die(mysqli_error($con));
            }

            $oph = "Ordonnace";
//            if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
//                $rslthisto = $con->query("insert into hp_trace(idproprietaire, idproduit, "
//                        . "idpatient, operation, objet, datetrace) values('" . $_SESSION["idproprietaire"] . "', "
//                        . "'" . $rowar["idproduit"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', "
//                        . "NOW())") or die(mysqli_error($con));
//            } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["idcomptepersonnel"])) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idproduit, "
                                . "idpatient, operation, objet, datetrace) values("
                                . "'" . $rowar["idproduit"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', "
                                . "NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idcomptepersonnel, idproduit, "
                                . "idpatient, operation, objet, datetrace) values('" . $_SESSION["idcomptepersonnel"] . "', "
                                . "'" . $rowar["idproduit"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', "
                                . "NOW())") or die(mysqli_error($con));
            }

//            }
        }


        $eta = "En Cours";
        $etap = "Payé";
        $reqarc = $con->query("select * from hp_ligne_soin_patient where idsoinpatient='" . $rowpl2["idsoinpatient"] . "' and "
                . "etatlignesoinpatient='" . $eta . "' or etatlignesoinpatient='" . $etap . "'") or die(mysqli_error($con));
        $npharmaciec = mysqli_num_rows($reqarc);
        $nbp = $rowpl2["periodesoinpatientdeja"] + 1;
        $eta2 = "En Cours";
        if ($npharmaciec == 0) {

            if (($nbp) >= ($rowpl2["periodesoinpatient"])) {
                $eta2 = "Livré";
            }
        }
        $rslt = $con->query("update hp_soin_patient set periodesoinpatientdeja='" . $nbp . "', etatsoinpatient='" . $eta2 . "' where "
                . "idsoinpatient='" . $rowpl2["idsoinpatient"] . "'") or die(mysqli_error($con));
        ?>
        <?php
        $op = "Sortie Soin ";
        if ($rowpl2["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                        . "dateregistrepatient) values('" . $rowpl2["idhospitalisation"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                        . "operationregistrepatient, dateregistrepatient) values('" . $rowpl2["idhospitalisation"] . "', "
                        . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
        }

//        $contenu = NULL;
//        $op = "Bar";
//        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
//            $rsltreg = $con->query("insert into hp_registre_patient(id_soinpatient, montant_reg, operation_reg, date_registre) "
//                    . "values('" . $rowpl2["id_soinpatient"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
//            $rsltreg = $con->query("insert into hp_registre_patient(id_soinpatient, idcomptepersonnel, montant_reg, "
//                    . "operation_reg, date_registre) values('" . $rowpl2["id_soinpatient"] . "', "
//                    . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//        }
        unset($_SESSION["cart_prodlsosop" . $cli]);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hopitalpages/hopitalpatient/hopitalsortiesoinpatient/facture_sortiesoin_pdf.php?sortiesoin=<?php echo $rowfa["idsortiesoin"] ?>" class="btn btn-lg btn-info" target="_blank">
            <span title="Imprimer la facture du patient" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour modifier un prix de vente
function administrer_soin_patient($soinpa, $datef, $heuref, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltc = $con->query("select * from hp_soin_patient as c left join hp_hospitalisation as h on "
            . "c.idhospitalisation=h.idhospitalisation left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
            . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
            . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
            . "c.idsoinpatient='" . $soinpa . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rsltc);
    if (isset($_SESSION["idcomptepersonnel"])) {
//echo "<script language='javascript'>alert('slow')</script>";
        $con->query("insert into hp_administration_soin_patient(idcomptepersonnel, idsoinpatient, datejouradministrationsoinpatient, "
                . "heureadministrationsoinpatient, dateadministrationsoinpatient) values('" . $_SESSION["idcomptepersonnel"] . "', "
                . "'" . $soinpa . "', '" . $datef . "', '" . $heuref . "', NOW())") or die(mysqli_error($con));
        
    $nbp = $row["periodesoinpatientadmin"] + 1;
    $eta2 = "En Cours";
    if (($nbp) >= ($rowpl2["periodesoinpatient"])) {
        $eta2 = "Administré";
    }
    $con->query("update hp_soin_patient set periodesoinpatientadmin='" . $nbp . "', etatsoinpatient='" . $eta2 . "' where "
            . "idsoinpatient='" . $soinpa . "'") or die(mysqli_error($con));

    }
    $pag = 'hopitalpages/hopitalpatient/hopitalhospitalisation/suivie_patient';
    die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&idhospitalisation=' . $row["idhospitalisation"] . '">');
}
