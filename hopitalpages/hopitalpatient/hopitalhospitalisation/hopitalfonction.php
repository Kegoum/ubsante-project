<?php

function inserer_consultation($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $err = false;
        $idc = $reg["1"]["idconsultation"];
        $eta = 1;
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');
        $con->query("update hp_consultation set butconsultation='" . $reg["1"]["but"] . "', signeconsultation='" . $reg["1"]["signe"] . "', "
                        . "symptomeconsultation='" . $reg["1"]["symptome"] . "', diagnostiqueconsultation='" . $reg["1"]["diagnostique"] . "' "
                        . "where idconsultation='" . $reg["1"]["idconsultation"] . "'") or die(mysqli_error($con));
        $resultat2ds = $con->query("SELECT * FROM hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier where c.idconsultation='" . $reg["1"]["idconsultation"] . "'") or die(mysqli_error($con));
        $row2ds = mysqli_fetch_assoc($resultat2ds);
//        echo "<script language='javascript'>alert($datej)</script>";
        if ($reg["2"]["decisionordonnance"]) {
            $reqc = $con->query("select * from hp_ordonnance as e where DAY(e.dateordonnance)='" . $jou . "' and "
                    . "MONTH(e.dateordonnance)='" . $moi . "' and YEAR(e.dateordonnance)='" . $an . "'") or die(mysqli_error($con));
            $ic = mysqli_num_rows($reqc);
            $numidc = "ORD" . $jou . $moi . $sand . sprintf("%05d", ($ic + 1));
            $con->query("insert into hp_ordonnance(idcomptepersonnel, idsousdossier, idconsultation, codeordonnance, dateordonnance) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2ds["idsousdossier"] . "', "
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
                    $con->query("insert into hp_examen_patient(idcomptepersonnel, idsousdossier, idconsultation, codeexamenpatient, idexamen, "
                                    . "montantexamenpatient, dateexamenpatient) values('" . $_SESSION["idcomptepersonnel"] . "', "
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
        if ($reg["2"]["decisionhospitalisation"]) {
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
                                    . "datesoinpatient) values('" . $hos["idart"] . "', '" . $rowpl["idhospitalisation"] . "', '" . $numidfs . "', "
                                    . "'" . $hos["prixart"] . "', NOW(), NOW())") or die(mysqli_error($con));

                    $reqdpls = $con->query("select * from hp_soin_patient where codesoinpatient= '" . $numidfs . "'") or die(mysqli_error($con));
                    $rowdpls = mysqli_fetch_assoc($reqdpls);

                    $reqf = $con->query("select * from hp_facture as e where DAY(e.datefacture)='" . $jou . "' and "
                            . "MONTH(e.datefacture)='" . $moi . "' and YEAR(e.datefacture)='" . $an . "'") or die(mysqli_error($con));
                    $if = mysqli_num_rows($reqf);
                    $numidf = "F" . $jou . $moi . $sand . sprintf("%05d", ($if + 1));
                    $con->query("insert into hp_facture(idcomptepersonnel, idsoinpatient, codefacture, montantfacture, datefacture) "
                                    . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $rowdpls["idsoinpatient"] . "', '" . $numidf . "', "
                                    . "'" . $hos["prixart"] . "', NOW())") or die(mysqli_error($con));
                    $op = "SOIN PATIENT";
                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                        $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                                . "dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', '" . $hos["prixart"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                    } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                        $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                                . "operationregistrepatient, dateregistrepatient) values('" . $rowpl["idhospitalisation"] . "', "
                                . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $hos["prixart"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                    }
                    $obj = "Hospitalisation " . $hos["prixart"];
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
            unset($_SESSION["session_prodshos" . $idc]);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalconsultation/lister_consultation';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

function lister_consultation($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $rsltfnp = $con->query("select * from hp_consultation as lc left join hp_grille_prix as f on "
            . "lc.idgrilleprix=f.idgrilleprix left join hp_service as u on f.categoriegrilleprix=u.idservice where "
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
                <?php // print nl2br(htmlspecialchars($recfnp["traitementconsultation"]))     ?> 
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                    <span title="dagnostiquer cette consultations" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}
