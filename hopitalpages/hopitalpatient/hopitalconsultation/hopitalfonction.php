<?php

function inserer_consultation($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $err = false;
        $idc = $reg["1"]["idconsultation"];
        $eta = 1;
        $etac = "Examen";
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');

        if (!($reg["2"]["decisionexamen"]) && !($reg["2"]["decisionacte"]) && !($reg["2"]["decisionacte"]) && !($reg["2"]["decisionhospitalisation"])) {
            $etac = "Consulter";
        }
        $con->query("update hp_consultation set butconsultation='" . addslashes($reg["1"]["but"]) . "', histoireconsultation='" . addslashes($reg["1"]["histoireconsultation"]) . "', "
                        . "immunoallergiqueconsultation='" . addslashes($reg["1"]["immunoallergiqueconsultation"]) . "', medicoconsultation='" . addslashes($reg["1"]["medicoconsultation"]) . "' "
                        . ", natauxconsultation='" . addslashes($reg["1"]["natauxconsultation"]) . "', chirurgieconsultation='" . addslashes($reg["1"]["chirurgieconsultation"]) . "', "
                        . "vaccinconsultation='" . addslashes($reg["1"]["vaccinconsultation"]) . "', gynecoobstetriqueconsultation='" . addslashes($reg["1"]["gynecoobstetriqueconsultation"]) . "' "
                        . ", toxicoconsultation='" . addslashes($reg["1"]["toxicoconsultation"]) . "', environnementconsultation='" . addslashes($reg["1"]["environnementconsultation"]) . "', "
                        . "antefamilialeconsultation='" . addslashes($reg["1"]["antefamilialeconsultation"]) . "', examenphysiqueconsultation='" . addslashes($reg["1"]["examenphysiqueconsultation"]) . "' "
                        . ", automedicationconsultation='" . addslashes($reg["1"]["automedicationconsultation"]) . "', diagnostiqueconsultation='" . addslashes($reg["1"]["diagnostique"]) . "' "
                        . ", etatconsultation='" . $etac . "' "
                        . "where idconsultation='" . $reg["1"]["idconsultation"] . "'") or die(mysqli_error($con));
        $resultat2ds = $con->query("SELECT * FROM hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier where c.idconsultation='" . $reg["1"]["idconsultation"] . "'") or die(mysqli_error($con));
        $row2ds = mysqli_fetch_assoc($resultat2ds);
//        echo "<script language='javascript'>alert($datej)</script>";
        $rowpl = NULL;
        if ($reg["2"]["decisionhospitalisation"]) {
            $resultat2ca = $con->query("SELECT * FROM hp_hospitalisation as h left join hp_sous_dossier as sd on "
                    . "h.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier  where "
                    . "d.idpatient='" . $row2ds["idpatient"] . "' and h.sortiehospitalisation=false") or die(mysqli_error($con));
            $nbla = mysqli_num_rows($resultat2ca);
            if ($nbla == 0) {
                $reqc = $con->query("select * from hp_hospitalisation as e where DAY(e.datehospitalisation)='" . $jou . "' and "
                        . "MONTH(e.datehospitalisation)='" . $moi . "' and YEAR(e.datehospitalisation)='" . $an . "'") or die(mysqli_error($con));
                $ic = mysqli_num_rows($reqc);
                $numidc = "HOS" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                $con->query("insert into hp_hospitalisation(idcomptepersonnel, idsousdossier, idconsultation, codehospitalisation, "
                                . "datedebuthospitalisation, heuredebuthospitalisation, datehospitalisation) "
                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', "
                                . "'" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', NOW(), NOW(), NOW())") or die(mysqli_error($con));
                $resultat2c = $con->query("SELECT * FROM hp_hospitalisation where codehospitalisation='" . $numidc . "'") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($resultat2c);
                $occupe = 0;
                $op = "Hospitalisation";
                $contenu = NULL;
                $reqch = $con->query("select * from hp_chambre as ch left join hp_categorie_chambre as cc on "
                        . "ch.idcategoriechambre=cc.idcategoriechambre where "
                        . "ch.idchambre= '" . $reg["3"]["salle"] . "' ") or die(mysqli_error($con));
                $rowch = mysqli_fetch_assoc($reqch);
                $obh = $rowch["codechambre"];
                $reql = $con->query("select * from hp_lit where idlit= '" . $reg["3"]["lit"] . "' ") or die(mysqli_error($con));
                $rowl = mysqli_fetch_assoc($reql);
                $obh = $obh . " " . $rowch["codechambre"] . " " . $rowl["codelit"];


                $prixupl = $rowch["prixcategoriechambre"];

                $prixpl = $prixupl;
                if (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["idcomptepersonnel"])) {
                    $rsltdpl = $con->query("insert into hp_deplacement_patient(idhospitalisation, idlit, idcomptepersonnel, "
                            . "prixunitairedeplacementpatient, prixdeplacementpatient, datedebutdeplacementpatient, "
                            . "heuredebutdeplacementpatient, datedeplacementpatient) values("
                            . "'" . $rowpl["idhospitalisation"] . "', '" . $reg["3"]["lit"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $prixupl . "', '" . $prixpl . "', "
                            . "NOW(), NOW(), NOW())") or die(mysqli_error($con));
                } else {
                    $rsltdpl = $con->query("insert into hp_deplacement_patient(idhospitalisation, idlit, "
                            . "prixunitairedeplacementpatient, prixdeplacementpatient, datedebutdeplacementpatient, "
                            . "heuredebutdeplacementpatient, datedeplacementpatient) values('" . $rowpl["idhospitalisation"] . "', "
                            . "'" . $reg["3"]["lit"] . "', '" . $prixupl . "', '" . $prixpl . "', "
                            . "NOW(), NOW(), NOW())") or die(mysqli_error($con));
                }
                $reqdpl = $con->query("select * from hp_deplacement_patient where idhospitalisation= '" . $rowpl["idhospitalisation"] . "' "
                        . "order by datedeplacementpatient desc limit 0,1 ") or die(mysqli_error($con));
                $rowdpl = mysqli_fetch_assoc($reqdpl);

                $con->query("update hp_lit set etatlit='" . $occupe . "' "
                                . "where idlit= '" . $reg["3"]["lit"] . "'") or die(mysqli_error($con));
                $req = $con->query("select * from hp_lit as l where l.idchambre='" . $reg["3"]["salle"] . "' and l.etatlit=true and l.statutlit=true "
                        . "") or die(mysqli_error($con));
                $nbm = mysqli_num_rows($req);
                if ($nbm == 0) {
                    $con->query("update hp_chambre set etatchambre='" . $occupe . "' "
                                    . "where idchambre= '" . $reg["3"]["salle"] . "'") or die(mysqli_error($con));
                }
                $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                        . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                $if = mysqli_num_rows($reqf);
                $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                $con->query("insert into hp_facture(idcomptepersonnel, iddeplacementpatient, codefacture, montantfacture, datefacture) "
                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $rowdpl["iddeplacementpatient"] . "', '" . $numidf . "', "
                                . "'" . $prixpl . "', NOW())") or die(mysqli_error($con));

                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
                $pristhos = 0;
                if (isset($_SESSION["cart_prodvhos" . $idc])) {
                    foreach ($_SESSION["cart_prodvhos" . $idc] as $hos) {
                        $reqf = $con->query("select * from hp_soin_patient as e where DAY(e.datesoinpatient)='" . $jou . "' and "
                                . "MONTH(e.datesoinpatient)='" . $moi . "' and YEAR(e.datesoinpatient)='" . $an . "'") or die(mysqli_error($con));
                        $ifs = mysqli_num_rows($reqf);
                        $numidfs = "SP" . $jou . $moi . $sand . sprintf("%05d", ($ifs + 1));
                        $con->query("insert into hp_soin_patient(idsoin, idhospitalisation, codesoinpatient, prixsoinpatient, datejoursoinpatient, "
                                        . "heuresoinpatient, dosagesoinpatient, intervallesoinpatient, periodesoinpatient, datesoinpatient) values('" . $hos["idart"] . "', '" . $rowpl["idhospitalisation"] . "', '" . $numidfs . "', "
                                        . "'" . $hos["prixart"] . "', '" . $hos["dateart"] . "', '" . $hos["heureart"] . "', '" . $hos["dosageart"] . "', '" . $hos["intervalleart"] . "', '" . $hos["periodeart"] . "', NOW())") or die(mysqli_error($con));

                        $reqdpls = $con->query("select * from hp_soin_patient where codesoinpatient= '" . $numidfs . "'") or die(mysqli_error($con));
                        $rowdpls = mysqli_fetch_assoc($reqdpls);

                        $reqls = $con->query("select * from hp_ligne_soin where idsoin= '" . $rowdpls["idsoin"] . "'") or die(mysqli_error($con));
                        while ($rowls = mysqli_fetch_assoc($reqls)) {
                            $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowls["idunite"] . "' and "
                                    . "idproduit='" . $rowls["idproduit"] . "'") or die(mysqli_error($con));
                            $rowvv = mysqli_fetch_assoc($rsltuv2);
                            $con->query("insert into hp_ligne_soin_patient(idproduit, idsoinpatient, idunitesoinpatient, quantitelignesoinpatient, "
                                            . "prixlignesoinpatient, datelignesoinpatient) values('" . $rowls["idproduit"] . "', '" . $rowdpls["idsoinpatient"] . "', "
                                            . "'" . $rowls["idunite"] . "', '" . $rowls["quantitelignesoin"] . "', '" . $rowvv["prixconversion"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $reqfa = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                        $if = mysqli_num_rows($reqfa);
                        $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                        $con->query("insert into hp_facture(idcomptepersonnel, idsoinpatient, codefacture, montantfacture, datefacture) "
                                        . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $rowdpls["idsoinpatient"] . "', '" . $numidf . "', "
                                        . "'" . $hos["prixart"] . "', NOW())") or die(mysqli_error($con));
                        $op = "SOIN PATIENT";
//                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
//                        $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
//                                . "dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', '" . $hos["prixart"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//                    } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
//                        $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
//                                . "operationregistrepatient, dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', "
//                                . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $hos["prixart"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//                    }
                        $obj = "Hospitalisation " . $hos["prixart"];
                    }
                }
            } else {
                $rowpl = mysqli_fetch_assoc($resultat2ca);
                echo "<script language='javascript'>$('div.addhosko').show('slow').delay(8000).hide('slow');</script>";
            }
        }

        $idhosp = "null";
        if ($rowpl != NULL) {
            $idhosp = $rowpl["idhospitalisation"];
        }
        if ($reg["2"]["decisionordonnance"]) {
            $reqc = $con->query("select * from hp_ordonnance as e where DAY(e.dateordonnance)='" . $jou . "' and "
                    . "MONTH(e.dateordonnance)='" . $moi . "' and YEAR(e.dateordonnance)='" . $an . "'") or die(mysqli_error($con));
            $ic = mysqli_num_rows($reqc);
            $numidc = "ORD" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
            $con->query("insert into hp_ordonnance(idcomptepersonnel, idhospitalisation, idsousdossier, idconsultation, codeordonnance, dateordonnance) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', " . $idhosp . ", '" . $row2ds["idsousdossier"] . "', "
                            . "'" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', NOW())") or die(mysqli_error($con));
            $resultat2c = $con->query("SELECT * FROM hp_ordonnance where codeordonnance='" . $numidc . "'") or die(mysqli_error($con));
            $row2c = mysqli_fetch_assoc($resultat2c);
            $pristord = 0;
            if (isset($_SESSION["cart_prodvord" . $idc])) {
                foreach ($_SESSION["cart_prodvord" . $idc] as $ord) {
                    $pristord = $pristord + ($ord["qteart"] * $ord["prixart"]);
                    $con->query("insert into hp_ligne_ordonnance(idproduit, idordonnance, idunite, stockligneordonnance, prixligneordonnance) "
                                    . "values('" . $ord["idart"] . "', '" . $row2c["idordonnance"] . "', '" . $ord["idunit"] . "', '" . $ord["qteart"] . "', "
                                    . "'" . $ord["prixart"] . "')") or die(mysqli_error($con));
                }
            }
            $con->query("update hp_ordonnance set montantordonnance='" . $pristord . "' where idordonnance='" . $row2c["idordonnance"] . "'") or die(mysqli_error($con));

            $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                    . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
            $if = mysqli_num_rows($reqf);
            $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
            $con->query("insert into hp_facture(idcomptepersonnel, idordonnance, codefacture, montantfacture, datefacture) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idordonnance"] . "', '" . $numidf . "', "
                            . "'" . $pristord . "', NOW())") or die(mysqli_error($con));
            $obj = "Ordonnance " . $pristord;
        }
        if ($reg["2"]["decisionexamen"]) {
            if (isset($_SESSION["cart_prodvexa" . $idc])) {
                foreach ($_SESSION["cart_prodvexa" . $idc] as $prod) {
                    $reqc = $con->query("select * from hp_examen_patient as e where DAY(e.dateexamenpatient)='" . $jou . "' and "
                            . "MONTH(e.dateexamenpatient)='" . $moi . "' and YEAR(e.dateexamenpatient)='" . $an . "'") or die(mysqli_error($con));
                    $ic = mysqli_num_rows($reqc);
                    $numidc = "EXA" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                    $con->query("insert into hp_examen_patient(idcomptepersonnel, idhospitalisation, idsousdossier, idconsultation, codeexamenpatient, idexamen, "
                                    . "montantexamenpatient, dateexamenpatient) values('" . $_SESSION["idcomptepersonnel"] . "', " . $idhosp . ", "
                                    . "'" . $row2ds["idsousdossier"] . "', '" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', "
                                    . "'" . $prod["idart"] . "', '" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $resultat2c = $con->query("SELECT * FROM hp_examen_patient where codeexamenpatient='" . $numidc . "'") or die(mysqli_error($con));
                    $row2c = mysqli_fetch_assoc($resultat2c);
                    $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                            . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                    $if = mysqli_num_rows($reqf);
                    $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                    $con->query("insert into hp_facture(idcomptepersonnel, idexamenpatient, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                    . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $obj = "Examen " . $prod["prixart"];
                }
            }
        }
        if ($reg["2"]["decisionechographie"]) {
            if (isset($_SESSION["cart_prodvecho" . $idc])) {
                foreach ($_SESSION["cart_prodvecho" . $idc] as $prod) {
                    $reqc = $con->query("select * from hp_echographie_patient as e where DAY(e.dateechographiepatient)='" . $jou . "' and "
                            . "MONTH(e.dateechographiepatient)='" . $moi . "' and YEAR(e.dateechographiepatient)='" . $an . "'") or die(mysqli_error($con));
                    $ic = mysqli_num_rows($reqc);
                    $numidc = "ECHO" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                    $con->query("insert into hp_echographie_patient(idcomptepersonnel, idhospitalisation, idsousdossier, idconsultation, codeechographiepatient, idechographie, "
                                    . "montantechographiepatient, dateechographiepatient) values('" . $_SESSION["idcomptepersonnel"] . "', " . $idhosp . ", "
                                    . "'" . $row2ds["idsousdossier"] . "', '" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', "
                                    . "'" . $prod["idart"] . "', '" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $resultat2c = $con->query("SELECT * FROM hp_echographie_patient where codeechographiepatient='" . $numidc . "'") or die(mysqli_error($con));
                    $row2c = mysqli_fetch_assoc($resultat2c);
                    $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                            . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                    $if = mysqli_num_rows($reqf);
                    $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                    $con->query("insert into hp_facture(idcomptepersonnel, idechographiepatient, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                    . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $obj = "Examen " . $prod["prixart"];
                }
            }
        }
        if ($reg["2"]["decisionacte"]) {
            if (isset($_SESSION["cart_prodvact" . $idc])) {
                foreach ($_SESSION["cart_prodvact" . $idc] as $prod) {
                    $reqc = $con->query("select * from hp_acte_patient as e where DAY(e.dateactepatient)='" . $jou . "' and "
                            . "MONTH(e.dateactepatient)='" . $moi . "' and YEAR(e.dateactepatient)='" . $an . "'") or die(mysqli_error($con));
                    $ic = mysqli_num_rows($reqc);
                    $numidc = "ACT" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                    $con->query("insert into hp_acte_patient(idcomptepersonnel, idhospitalisation, idsousdossier, idconsultation, codeactepatient, idacte, "
                                    . "prixactepatient, dateactepatient) values('" . $_SESSION["idcomptepersonnel"] . "', " . $idhosp . ", "
                                    . "'" . $row2ds["idsousdossier"] . "', '" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', "
                                    . "'" . $prod["idart"] . "', '" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $resultat2c = $con->query("SELECT * FROM hp_acte_patient where codeactepatient='" . $numidc . "'") or die(mysqli_error($con));
                    $row2c = mysqli_fetch_assoc($resultat2c);
                    $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                            . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                    $if = mysqli_num_rows($reqf);
                    $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                    $con->query("insert into hp_facture(idcomptepersonnel, idactepatient, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                    . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $obj = $prod["designationart"] . " " . $prod["prixart"];
                }
            }
        }
        $lieu = "Caisse";
        $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $row2ds["iddossier"] . "'") or die(mysqli_error($con));

        $op = "Consultation";
        $con->query("insert into hp_trace(idcomptepersonnel, idpatient, operation, objet, datetrace) "
                        . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idpatient"] . "', "
                        . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idconsultation=' . $idc . '">');
        } else {
            unset($_SESSION['formconsultation']);
            unset($_SESSION["session_prodsord" . $idc]);
            unset($_SESSION["session_prodsexa" . $idc]);
            unset($_SESSION["session_prodsecho" . $idc]);
            unset($_SESSION["session_prodshos" . $idc]);

            if ($reg["2"]["decisionhospitalisation"]) {
                if ($rowpl != NULL) {
                    ?>
                    <a href="hopitalpages/hopitalpatient/hopitalconsultation/carnet_patient_pdf.php?idhospitalisation=<?php echo $rowpl["idhospitalisation"] ?>" class="btn btn-lg btn-success" target="_blank">
                        <span title="Imprimer le Carnet de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le Carnet</span>
                    </a>
                    <?php
                }
            }
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalconsultation/lister_consultation';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idconsultation=' . $idc . '">');
        }
    }
}

function inserer_consultation_plan($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $err = false;
        $idc = $reg["1"]["idconsultation"];
        $eta = 1;
        $etac = "Consulter";
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');

        if (!($reg["1"]["decisionexamen"]) && !($reg["1"]["decisionacte"]) && !($reg["1"]["decisionechographie"]) && !($reg["1"]["decisionhospitalisation"])) {
            $etac = "Terminer";
        }
        $con->query("update hp_consultation set etatconsultation='" . $etac . "' "
                        . "where idconsultation='" . $reg["1"]["idconsultation"] . "'") or die(mysqli_error($con));
        $resultat2ds = $con->query("SELECT * FROM hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier where c.idconsultation='" . $reg["1"]["idconsultation"] . "'") or die(mysqli_error($con));
        $row2ds = mysqli_fetch_assoc($resultat2ds);
//        echo "<script language='javascript'>alert($datej)</script>";

        $rowpl = NULL;
        if ($reg["1"]["decisionhospitalisation"]) {
            $resultat2ca = $con->query("SELECT * FROM hp_hospitalisation as h left join hp_sous_dossier as sd on "
                    . "h.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier  where "
                    . "d.idpatient='" . $row2ds["idpatient"] . "' and h.sortiehospitalisation=false") or die(mysqli_error($con));
            $nbla = mysqli_num_rows($resultat2ca);
            if ($nbla == 0) {
                $reqc = $con->query("select * from hp_hospitalisation as e where DAY(e.datehospitalisation)='" . $jou . "' and "
                        . "MONTH(e.datehospitalisation)='" . $moi . "' and YEAR(e.datehospitalisation)='" . $an . "'") or die(mysqli_error($con));
                $ic = mysqli_num_rows($reqc);
                $numidc = "HOS" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                $con->query("insert into hp_hospitalisation(idcomptepersonnel, idsousdossier, idconsultation, codehospitalisation, "
                                . "datedebuthospitalisation, heuredebuthospitalisation, datehospitalisation) "
                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', "
                                . "'" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', NOW(), NOW(), NOW())") or die(mysqli_error($con));
                $resultat2c = $con->query("SELECT * FROM hp_hospitalisation where codehospitalisation='" . $numidc . "'") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($resultat2c);
                $occupe = 0;
                $op = "Hospitalisation";
                $contenu = NULL;
                $reqch = $con->query("select * from hp_chambre as ch left join hp_categorie_chambre as cc on "
                        . "ch.idcategoriechambre=cc.idcategoriechambre where "
                        . "ch.idchambre= '" . $reg["2"]["salle"] . "' ") or die(mysqli_error($con));
                $rowch = mysqli_fetch_assoc($reqch);
                $obh = $rowch["codechambre"];
                $reql = $con->query("select * from hp_lit where idlit= '" . $reg["2"]["lit"] . "' ") or die(mysqli_error($con));
                $rowl = mysqli_fetch_assoc($reql);
                $obh = $obh . " " . $rowch["codechambre"] . " " . $rowl["codelit"];


                $prixupl = $rowch["prixcategoriechambre"];

                $prixpl = $prixupl;
                if (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["idcomptepersonnel"])) {
                    $rsltdpl = $con->query("insert into hp_deplacement_patient(idhospitalisation, idlit, idcomptepersonnel, "
                            . "prixunitairedeplacementpatient, prixdeplacementpatient, datedebutdeplacementpatient, "
                            . "heuredebutdeplacementpatient, datedeplacementpatient) values("
                            . "'" . $rowpl["idhospitalisation"] . "', '" . $reg["2"]["lit"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $prixupl . "', '" . $prixpl . "', "
                            . "NOW(), NOW(), NOW())") or die(mysqli_error($con));
                } else {
                    $rsltdpl = $con->query("insert into hp_deplacement_patient(idhospitalisation, idlit, "
                            . "prixunitairedeplacementpatient, prixdeplacementpatient, datedebutdeplacementpatient, "
                            . "heuredebutdeplacementpatient, datedeplacementpatient) values('" . $rowpl["idhospitalisation"] . "', "
                            . "'" . $reg["2"]["lit"] . "', '" . $prixupl . "', '" . $prixpl . "', "
                            . "NOW(), NOW(), NOW())") or die(mysqli_error($con));
                }
                $reqdpl = $con->query("select * from hp_deplacement_patient where idhospitalisation= '" . $rowpl["idhospitalisation"] . "' "
                        . "order by datedeplacementpatient desc limit 0,1 ") or die(mysqli_error($con));
                $rowdpl = mysqli_fetch_assoc($reqdpl);

                $con->query("update hp_lit set etatlit='" . $occupe . "' "
                                . "where idlit= '" . $reg["2"]["lit"] . "'") or die(mysqli_error($con));
                $req = $con->query("select * from hp_lit as l where l.idchambre='" . $reg["2"]["salle"] . "' and l.etatlit=true and l.statutlit=true "
                        . "") or die(mysqli_error($con));
                $nbm = mysqli_num_rows($req);
                if ($nbm == 0) {
                    $con->query("update hp_chambre set etatchambre='" . $occupe . "' "
                                    . "where idchambre= '" . $reg["2"]["salle"] . "'") or die(mysqli_error($con));
                }
                $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                        . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                $if = mysqli_num_rows($reqf);
                $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                $con->query("insert into hp_facture(idcomptepersonnel, iddeplacementpatient, codefacture, montantfacture, datefacture) "
                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $rowdpl["iddeplacementpatient"] . "', '" . $numidf . "', "
                                . "'" . $prixpl . "', NOW())") or die(mysqli_error($con));

                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
                $pristhos = 0;
                if (isset($_SESSION["cart_prodvhosplan" . $idc])) {
                    foreach ($_SESSION["cart_prodvhosplan" . $idc] as $hos) {
                        $reqf = $con->query("select * from hp_soin_patient as e where DAY(e.datesoinpatient)='" . $jou . "' and "
                                . "MONTH(e.datesoinpatient)='" . $moi . "' and YEAR(e.datesoinpatient)='" . $an . "'") or die(mysqli_error($con));
                        $ifs = mysqli_num_rows($reqf);
                        $numidfs = "SP" . $jou . $moi . $sand . sprintf("%05d", ($ifs + 1));
                        $con->query("insert into hp_soin_patient(idsoin, idhospitalisation, codesoinpatient, prixsoinpatient, datejoursoinpatient, "
                                        . "heuresoinpatient, dosagesoinpatient, intervallesoinpatient, periodesoinpatient, datesoinpatient) values('" . $hos["idart"] . "', '" . $rowpl["idhospitalisation"] . "', '" . $numidfs . "', "
                                        . "'" . $hos["prixart"] . "', '" . $hos["dateart"] . "', '" . $hos["heureart"] . "', '" . $hos["dosageart"] . "', '" . $hos["intervalleart"] . "', '" . $hos["periodeart"] . "', NOW())") or die(mysqli_error($con));

                        $reqdpls = $con->query("select * from hp_soin_patient where codesoinpatient= '" . $numidfs . "'") or die(mysqli_error($con));
                        $rowdpls = mysqli_fetch_assoc($reqdpls);

                        $reqls = $con->query("select * from hp_ligne_soin where idsoin= '" . $rowdpls["idsoin"] . "'") or die(mysqli_error($con));
                        while ($rowls = mysqli_fetch_assoc($reqls)) {
                            $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowls["idunite"] . "' and "
                                    . "idproduit='" . $rowls["idproduit"] . "'") or die(mysqli_error($con));
                            $rowvv = mysqli_fetch_assoc($rsltuv2);
                            $con->query("insert into hp_ligne_soin_patient(idproduit, idsoinpatient, idunitesoinpatient, quantitelignesoinpatient, "
                                            . "prixlignesoinpatient, datelignesoinpatient) values('" . $rowls["idproduit"] . "', '" . $rowdpls["idsoinpatient"] . "', "
                                            . "'" . $rowls["idunite"] . "', '" . $rowls["quantitelignesoin"] . "', '" . $rowvv["prixconversion"] . "', NOW())") or die(mysqli_error($con));
                        }

                        $reqfa = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                                . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                        $if = mysqli_num_rows($reqfa);
                        $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                        $con->query("insert into hp_facture(idcomptepersonnel, idsoinpatient, codefacture, montantfacture, datefacture) "
                                        . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $rowdpls["idsoinpatient"] . "', '" . $numidf . "', "
                                        . "'" . $hos["prixart"] . "', NOW())") or die(mysqli_error($con));
                        $op = "SOIN PATIENT";
//                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
//                        $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
//                                . "dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', '" . $hos["prixart"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//                    } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
//                        $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
//                                . "operationregistrepatient, dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', "
//                                . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $hos["prixart"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//                    }
                        $obj = "Hospitalisation " . $hos["prixart"];
                    }
                }
            } else {
                echo "<script language='javascript'>$('div.addhosko').show('slow').delay(8000).hide('slow');</script>";
            }
        }
        $idhosp = "null";
        if ($rowpl != NULL) {
            $idhosp = $rowpl["idhospitalisation"];
        } else {
            $resultat2dsc = $con->query("SELECT * FROM hp_hospitalisation where idconsultation='" . $reg["1"]["idconsultation"] . "'") or die(mysqli_error($con));
            $nbco = mysqli_num_rows($resultat2dsc);
            if ($nbco != 0) {
                $row2dsc = mysqli_fetch_assoc($resultat2dsc);
                $idhosp = $row2dsc["idhospitalisation"];
            }
        }
        if ($reg["1"]["decisionordonnance"]) {
            $reqc = $con->query("select * from hp_ordonnance as e where DAY(e.dateordonnance)='" . $jou . "' and "
                    . "MONTH(e.dateordonnance)='" . $moi . "' and YEAR(e.dateordonnance)='" . $an . "'") or die(mysqli_error($con));
            $ic = mysqli_num_rows($reqc);
            $numidc = "ORD" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
            $con->query("insert into hp_ordonnance(idcomptepersonnel, idhospitalisation, idsousdossier, idconsultation, codeordonnance, dateordonnance) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', " . $idhosp . ", '" . $row2ds["idsousdossier"] . "', "
                            . "'" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', NOW())") or die(mysqli_error($con));
            $resultat2c = $con->query("SELECT * FROM hp_ordonnance where codeordonnance='" . $numidc . "'") or die(mysqli_error($con));
            $row2c = mysqli_fetch_assoc($resultat2c);
            $pristord = 0;
            if (isset($_SESSION["cart_prodvordplan" . $idc])) {
                foreach ($_SESSION["cart_prodvordplan" . $idc] as $ord) {
                    $pristord = $pristord + ($ord["qteart"] * $ord["prixart"]);
                    $con->query("insert into hp_ligne_ordonnance(idproduit, idordonnance, idunite, stockligneordonnance, prixligneordonnance) "
                                    . "values('" . $ord["idart"] . "', '" . $row2c["idordonnance"] . "', '" . $ord["idunit"] . "', '" . $ord["qteart"] . "', "
                                    . "'" . $ord["prixart"] . "')") or die(mysqli_error($con));
                }
            }
            $con->query("update hp_ordonnance set montantordonnance='" . $pristord . "' where idordonnance='" . $row2c["idordonnance"] . "'") or die(mysqli_error($con));

            $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                    . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
            $if = mysqli_num_rows($reqf);
            $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
            $con->query("insert into hp_facture(idcomptepersonnel, idordonnance, codefacture, montantfacture, datefacture) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idordonnance"] . "', '" . $numidf . "', "
                            . "'" . $pristord . "', NOW())") or die(mysqli_error($con));
            $obj = "Ordonnance " . $pristord;
        }
        if ($reg["1"]["decisionexamen"]) {
            if (isset($_SESSION["cart_prodvexaplan" . $idc])) {
                foreach ($_SESSION["cart_prodvexaplan" . $idc] as $prod) {
                    $reqc = $con->query("select * from hp_examen_patient as e where DAY(e.dateexamenpatient)='" . $jou . "' and "
                            . "MONTH(e.dateexamenpatient)='" . $moi . "' and YEAR(e.dateexamenpatient)='" . $an . "'") or die(mysqli_error($con));
                    $ic = mysqli_num_rows($reqc);
                    $numidc = "EXA" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                    $con->query("insert into hp_examen_patient(idcomptepersonnel, idhospitalisation, idsousdossier, idconsultation, codeexamenpatient, idexamen, "
                                    . "montantexamenpatient, dateexamenpatient) values('" . $_SESSION["idcomptepersonnel"] . "', " . $idhosp . ", "
                                    . "'" . $row2ds["idsousdossier"] . "', '" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', "
                                    . "'" . $prod["idart"] . "', '" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $resultat2c = $con->query("SELECT * FROM hp_examen_patient where codeexamenpatient='" . $numidc . "'") or die(mysqli_error($con));
                    $row2c = mysqli_fetch_assoc($resultat2c);
                    $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                            . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                    $if = mysqli_num_rows($reqf);
                    $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                    $con->query("insert into hp_facture(idcomptepersonnel, idexamenpatient, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idexamenpatient"] . "', '" . $numidf . "', "
                                    . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $obj = "Examen " . $prod["prixart"];
                }
            }
        }
        if ($reg["1"]["decisionechographie"]) {
            if (isset($_SESSION["cart_prodvechoplan" . $idc])) {
                foreach ($_SESSION["cart_prodvechoplan" . $idc] as $prod) {
                    $reqc = $con->query("select * from hp_echographie_patient as e where DAY(e.dateechographiepatient)='" . $jou . "' and "
                            . "MONTH(e.dateechographiepatient)='" . $moi . "' and YEAR(e.dateechographiepatient)='" . $an . "'") or die(mysqli_error($con));
                    $ic = mysqli_num_rows($reqc);
                    $numidc = "ECHO" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                    $con->query("insert into hp_echographie_patient(idcomptepersonnel, idhospitalisation, idsousdossier, idconsultation, codeechographiepatient, idechographie, "
                                    . "montantechographiepatient, dateechographiepatient) values('" . $_SESSION["idcomptepersonnel"] . "', " . $idhosp . ", "
                                    . "'" . $row2ds["idsousdossier"] . "', '" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', "
                                    . "'" . $prod["idart"] . "', '" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $resultat2c = $con->query("SELECT * FROM hp_echographie_patient where codeechographiepatient='" . $numidc . "'") or die(mysqli_error($con));
                    $row2c = mysqli_fetch_assoc($resultat2c);
                    $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                            . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                    $if = mysqli_num_rows($reqf);
                    $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                    $con->query("insert into hp_facture(idcomptepersonnel, idechographiepatient, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idechographiepatient"] . "', '" . $numidf . "', "
                                    . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $obj = "Examen " . $prod["prixart"];
                }
            }
        }
        if ($reg["1"]["decisionacte"]) {
            if (isset($_SESSION["cart_prodvactplan" . $idc])) {
                foreach ($_SESSION["cart_prodvactplan" . $idc] as $prod) {
                    $reqc = $con->query("select * from hp_acte_patient as e where DAY(e.dateactepatient)='" . $jou . "' and "
                            . "MONTH(e.dateactepatient)='" . $moi . "' and YEAR(e.dateactepatient)='" . $an . "'") or die(mysqli_error($con));
                    $ic = mysqli_num_rows($reqc);
                    $numidc = "ACT" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
                    $con->query("insert into hp_acte_patient(idcomptepersonnel, idhospitalisation, idsousdossier, idconsultation, codeactepatient, idacte, "
                                    . "prixactepatient, dateactepatient) values('" . $_SESSION["idcomptepersonnel"] . "', " . $idhosp . ", "
                                    . "'" . $row2ds["idsousdossier"] . "', '" . $reg["1"]["idconsultation"] . "', '" . $numidc . "', "
                                    . "'" . $prod["idart"] . "', '" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $resultat2c = $con->query("SELECT * FROM hp_acte_patient where codeactepatient='" . $numidc . "'") or die(mysqli_error($con));
                    $row2c = mysqli_fetch_assoc($resultat2c);
                    $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                            . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                    $if = mysqli_num_rows($reqf);
                    $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                    $con->query("insert into hp_facture(idcomptepersonnel, idactepatient, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2c["idactepatient"] . "', '" . $numidf . "', "
                                    . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $obj = $prod["designationart"] . " " . $prod["prixart"];
                }
            }
        }
        $lieu = "Caisse";
        $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $row2ds["iddossier"] . "'") or die(mysqli_error($con));

        $op = "Consultation";
        $con->query("insert into hp_trace(idcomptepersonnel, idpatient, operation, objet, datetrace) "
                        . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idpatient"] . "', "
                        . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idconsultation=' . $idc . '">');
        } else {
            unset($_SESSION['formconsultationplan']);
            unset($_SESSION["session_prodsordplan" . $idc]);
            unset($_SESSION["session_prodsexaplan" . $idc]);
            unset($_SESSION["session_prodsechoplan" . $idc]);
            unset($_SESSION["session_prodshosplan" . $idc]);

            if ($reg["1"]["decisionhospitalisation"]) {
                if ($rowpl != NULL) {
                    ?>
                    <a href="hopitalpages/hopitalpatient/hopitalconsultation/carnet_patient_pdf.php?idhospitalisation=<?php echo $rowpl["idhospitalisation"] ?>" class="btn btn-lg btn-success" target="_blank">
                        <span title="Imprimer le Carnet de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le Carnet</span>
                    </a>
                    <?php
                }
            }
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalconsultation/lister_consultation';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idconsultation=' . $idc . '">');
        }
    }
}

function lister_consultation($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $rsltfnp = $con->query("select * from hp_consultation as lc left join hp_acte as f on "
            . "lc.idacte=f.idacte left join hp_service as u on f.idservice=u.idservice where "
            . "lc.idconsultation='" . $id . "' order by lc.dateconsultation desc ") or die(mysqli_error($con));

    while ($recfnp = mysqli_fetch_assoc($rsltfnp)) {
//        print_r($recfnp);
        ?>

        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recfnp["codeconsultation"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recfnp["butconsultation"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recfnp["diagnostiqueconsultation"])) ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recfnp["resultatconsultation"])) ?> 
            </td>
            <td><?php print nl2br(htmlspecialchars($recfnp["traitementconsultation"])) ?> 
            </td>
            <td>
                <?php // print nl2br(htmlspecialchars($recfnp["traitementconsultation"]))       ?> 
            </td>
            <td>
                <?php
                if ($recfnp["etatconsultation"] == "En Cours") {
                    ?> 
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                        <span title="dagnostiquer cette consultation" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                    </a>
                    <?php
                } else {
                    ?> 
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/dossier_patient') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                        <span title="Afficher le d&eacute;tail de cette consultation" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                    </a>
                    <?php
                }
                ?> 
            </td>
        </tr>
        <?php
    }
}

function lister_dossier_consultation($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $date = date('Y-m-d');

    $rsltcp = $con->query("select * from hp_parametre_patient as c left join hp_parametre as sd on "
            . "c.idparametre=sd.idparametre left join hp_unite as d on sd.idunite=d.idunite where "
            . "c.idconsultation='" . $id . "'") or die(mysqli_error($con));
    $nbf = 0;
    $rsltfnpc = $con->query("select * from hp_consultation as lc left join hp_acte as f on "
            . "lc.idacte=f.idacte left join hp_service as u on f.idservice=u.idservice where "
            . "lc.idconsultation='" . $id . "' order by lc.dateconsultation desc ") or die(mysqli_error($con));

    $recfnp = mysqli_fetch_assoc($rsltfnpc);
    ?>
    1 - Motif consultation : <?php print nl2br(htmlspecialchars($recfnp["butconsultation"])) ?><br>
    2 - Histoire de la maladie actuelle : <?php echo $recfnp["histoireconsultation"]; ?><br>
    3 - Autom&eacute;dication : <?php echo $recfnp["automedicationconsultation"]; ?><br>
    4 - Ant&eacute;c&eacute;dents personnels <br>
    &nbsp;&nbsp;&nbsp;4.1 - M&eacute;dico-m&eacute;dicamenteux : <?php echo $recfnp["medicoconsultation"]; ?><br>
    &nbsp;&nbsp;&nbsp;4.2 - Immunoallergiques : <?php echo $recfnp["immunoallergiqueconsultation"]; ?><br>
    &nbsp;&nbsp;&nbsp;4.3 - Chirurgicaux : <?php echo $recfnp["chirurgieconsultation"]; ?><br>
    &nbsp;&nbsp;&nbsp;4.4 - Ant&eacute;nataux / nataux / Postnataux / D&eacute;veloppement psychomoteur / Alimentation : <?php echo $recfnp["natauxconsultation"]; ?><br>
    &nbsp;&nbsp;&nbsp;4.5 - Etat vaccinal : <?php echo $recfnp["vaccinconsultation"]; ?><br>
    &nbsp;&nbsp;&nbsp;4.6 - Gyn&eacute;cologiques et Obst&eacute;tricaux : <?php echo $recfnp["gynecoobstetriqueconsultation"]; ?><br>
    &nbsp;&nbsp;&nbsp;4.7 - Toxicologiques : <?php echo $recfnp["toxicoconsultation"]; ?><br>
    &nbsp;&nbsp;&nbsp;4.8 - Environnementaux : <?php echo $recfnp["environnementconsultation"]; ?><br>
    5 - Ant&eacute;c&eacute;dents Familiaux : <?php echo $recfnp["antefamilialeconsultation"]; ?><br>
    6 - Examen physique : <?php echo $recfnp["examenphysiqueconsultation"]; ?><br>
    7 - Diagnostique : <?php print nl2br(htmlspecialchars($recfnp["diagnostiqueconsultation"])) ?>
    <br>
    R&eacute;sultat : <?php print nl2br(htmlspecialchars($recfnp["resultatconsultation"])) ?> 
    <br>
    Traitement : <?php print nl2br(htmlspecialchars($recfnp["traitementconsultation"])) ?> 

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <b>  Param&egrave;tre </b>
        </div>
    </div>
    <?php
    while ($recfnpa = mysqli_fetch_assoc($rsltcp)) {
        ?>
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-3">
                <?php print nl2br(htmlspecialchars($recfnpa["datejourparametrepatient"])) ?> -->
                <?php print nl2br(htmlspecialchars($recfnpa["heureparametrepatient"])) ?>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9">
                <?php print nl2br(htmlspecialchars($recfnpa["libelleparametre"])) ?> : 
                <?php print nl2br(htmlspecialchars($recfnpa["valeurparametrepatient"])) ?> 
                <?php print nl2br(htmlspecialchars($recfnpa["codeunite"])) ?> 
                (<?php print nl2br(htmlspecialchars($recfnpa["valeurminparametre"])) ?> - 
                <?php print nl2br(htmlspecialchars($recfnpa["valeurmaxparametre"])) ?> 
                <?php print nl2br(htmlspecialchars($recfnpa["codeunite"])) ?> )
            </div>
        </div>
        <?php
    }

    $rsltfnpep = $con->query("select * from hp_examen_patient as lc left join hp_examen as f on lc.idexamen=f.idexamen "
            . "left join hp_laboratoire as l on f.idlaboratoire=l.idlaboratoire left join hp_service as u on "
            . "l.idservice=u.idservice where lc.idconsultation='" . $id . "' order by lc.dateexamenpatient desc ") or die(mysqli_error($con));
    $nbep = mysqli_num_rows($rsltfnpep);

    if ($nbep != 0) {
        ?>
        <br><br>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h5>Liste des examens du patient </h5>
            </div>
        </div>
        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>But</th>
                    <th>R&eacute;sultat</th>
                    <th>Valeur</th>
                    <th>Etat</th>
                    <th>Op&eacute;ration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($recfnp = mysqli_fetch_assoc($rsltfnpep)) {

                    $rsltfnp2 = $con->query("select * from hp_facture where idexamenpatient='" . $recfnp["idexamenpatient"] . "' and "
                            . "etatfacture=true ") or die(mysqli_error($con));
                    $nbfnp = mysqli_num_rows($rsltfnp2);

//        print_r($recfnp);
                    ?>

                    <tr >
                        <td></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["codeexamenpatient"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["typeexamen"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["butexamenpatient"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["resultatexamenpatient"])) ?> 
                        </td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["valeurexamenpatient"])) ?> 
                        </td>
                        <td>
                            <?php
                            if ($nbfnp != 0) {
                                ?>
                                <span alt="oui" class="label-success label"><i class="label label-success">Pay&eacute;e</i></span>
                                <?php
                            } else {
                                ?>
                                <span alt="non" class="label-danger label"><i class="label label-danger">Impay&eacute;e</i></span>
                                <?php
                            }
                            ?> 
                        </td>
                        <td>
                            <?php
                            if ($nbfnp != 0) {
                                if ($recfnp["typeexamen"] == "Numération Formule Sanguine (NFS)") {
                                    if ($recfnp["etatexamenpatient"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeexamen"] == "Prélèvement Cervico-Vaginal: PCV") {
                                    if ($recfnp["etatexamenpatient"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeexamen"] == "Sérologie V.I.H") {
                                    if ($recfnp["etatexamenpatient"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeexamen"] == "Coprologie Parasitaire: Selles") {
                                    if ($recfnp["etatexamenpatient"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeexamen"] == "Sérologie de Widal et Felix") {
                                    if ($recfnp["etatexamenpatient"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else {
                                    if ($recfnp["etatexamenpatient"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalautre/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                }
                            }
                            ?> 
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>    
        <?php
    } else {
        ?>
        <br><br>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h5>Liste des examens du patient </h5>
            </div>
        </div>
        <?php
        if ((isset($_SESSION["issamrole"])) && ((($_SESSION["issamrole"] == "Super Administrateur") || ($_SESSION["issamrole"] == "Administrateur")) || ($_SESSION["issamrole"] == "Comptable"))) {
            ?>
                                    <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalautre/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">-->
            <span title="Attribuer un examen" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
            <!--</a>-->
            <?php
        }
        ?>

        <?php
    }

    $rsltfnpecp = $con->query("select * from hp_echographie_patient as ep left join hp_echographie as e on ep.idechographie=e.idechographie "
            . "left join hp_acte as a on e.idacte=a.idacte left join hp_service as s on "
            . "e.idservice=s.idservice where ep.idconsultation='" . $id . "' order by ep.dateechographiepatient desc ") or die(mysqli_error($con));
    $nbecp = mysqli_num_rows($rsltfnpecp);

    if ($nbecp != 0) {
        ?>
        <br><br>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h5>Liste des &eacute;chographies du patient </h5>
            </div>
        </div>
        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>But</th>
                    <th>R&eacute;sultat</th>
                    <th>Valeur</th>
                    <th>Etat</th>
                    <th>Op&eacute;ration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($recfnp = mysqli_fetch_assoc($rsltfnpecp)) {

                    $rsltfnp2 = $con->query("select * from hp_facture where idechographiepatient='" . $recfnp["idechographiepatient"] . "' and "
                            . "etatfacture=true ") or die(mysqli_error($con));
                    $nbfnp = mysqli_num_rows($rsltfnp2);

//        print_r($recfnp);
                    ?>

                    <tr >
                        <td></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["codeechographiepatient"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["nomechographie"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["butechographiepatient"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["resultatechographiepatient"])) ?> 
                        </td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["valeurechographiepatient"])) ?> 
                        </td>
                        <td>
                            <?php
                            if ($nbfnp != 0) {
                                ?>
                                <span alt="oui" class="label-success label"><i class="label label-success">Pay&eacute;e</i></span>
                                <?php
                            } else {
                                ?>
                                <span alt="non" class="label-danger label"><i class="label label-danger">Impay&eacute;e</i></span>
                                <?php
                            }
                            ?> 
                        </td>
                        <td>
                            <?php
                            if ($nbfnp != 0) {
                                if ($recfnp["typeechographie"] == "Obstétricale 2 3") {
                                    if ($recfnp["etatechographiepatient"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                            <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeechographie"] == "Pelvienne") {
                                    if ($recfnp["etatechographiepatient"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                            <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                }
                            }
                            ?> 
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>    
        <?php
    } else {
        ?>
        <br><br>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h5>Liste des echographies du patient </h5>
            </div>
        </div>
        <?php
        if ((isset($_SESSION["issamrole"])) && ((($_SESSION["issamrole"] == "Super Administrateur") || ($_SESSION["issamrole"] == "Administrateur")) || ($_SESSION["issamrole"] == "Comptable"))) {
            ?>
                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">-->
            <span title="Attribuer un echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
            <!--</a>-->
            <?php
        }
        ?>

        <?php
    }
}
