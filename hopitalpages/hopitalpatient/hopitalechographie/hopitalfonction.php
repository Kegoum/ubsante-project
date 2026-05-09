<?php

function lister_echographie_patient($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $rsltfnp = $con->query("select * from hp_echographie_patient as ep left join hp_echographie as e on ep.idechographie=e.idechographie "
            . "left join hp_acte as a on e.idacte=a.idacte left join hp_service as s on "
            . "e.idservice=s.idservice order by ep.dateechographiepatient desc ") or die(mysqli_error($con));

    while ($recfnp = mysqli_fetch_assoc($rsltfnp)) {
        $req_fin = $con->query("select * from hp_sous_dossier as sd left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where sd.idsousdossier='" . $recfnp["idsousdossier"] . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);
        $rsltfnp2 = $con->query("select * from hp_facture where idechographiepatient='" . $recfnp["idechographiepatient"] . "' and "
                . "etatfacture=true ") or die(mysqli_error($con));
        $nbfnp = mysqli_num_rows($rsltfnp2);

//        print_r($recfnp);
        ?>

        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recfnp["codeechographiepatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recfnp["nomechographie"])) ?></td>
            <td>
                <?php echo $row["codepatient"]; ?> <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?>
            </td>
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
                if (($nbfnp != 0) || ($recfnp["idhospitalisation"] != NULL)) {
                    if ($recfnp["typeechographie"] == "Obstétricale 1") {
                        if (!$recfnp["etatechographiepatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                        
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/hopitalajouter/ajout_echographie') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="executer cet echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeechographie"] == "Obstétricale 2 3") {
                        if (!$recfnp["etatechographiepatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                        
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalajouter/ajout_echographie') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="executer cet echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeechographie"] == "Pelvienne") {
                        if (!$recfnp["etatechographiepatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                        
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/hopitalajouter/ajout_echographie') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="executer cet echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeechographie"] == "Testiculaire") {
                        if (!$recfnp["etatechographiepatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                        ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitaltesticulaire/hopitalajouter/ajout_echographie') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="executer cet echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitaltesticulaire/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeechographie"] == "Mammaire") {
                        if (!$recfnp["etatechographiepatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                        ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalmammaire/hopitalajouter/ajout_echographie') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="executer cet echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalmammaire/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeechographie"] == "Abdomino - Pelvienne") {
                        if (!$recfnp["etatechographiepatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                        ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/hopitalajouter/ajout_echographie') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="executer cet echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeechographie"] == "Abdominale") {
                        if (!$recfnp["etatechographiepatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                        ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominale/hopitalajouter/ajout_echographie') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="executer cet echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominale/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeechographie"] == "Partie Molle") {
                        if (!$recfnp["etatechographiepatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                        ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalpartiemolle/hopitalajouter/ajout_echographie') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="executer cet echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalpartiemolle/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else {
                        if (!$recfnp["etatechographiepatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                        ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalautre/hopitalajouter/ajout_echographie') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
                                <span title="executer cet echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalautre/lister_resultat') ?>&idechographiepatient=<?php echo $recfnp["idechographiepatient"] ?>">
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
}

function inserer_obstetricale_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_echographie(idechographiepatient, dateresultatechographie) "
                            . "values('" . $idep . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowobstetricale = NULL;
        $reqnf = $con->query("select * from hp_obstetricale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_obstetricale(idresultatechographie, datejourobstetricale, heureobstetricale, localisationobstetricale, "
                            . "nombrefoetusobstetricale, bipobstetricale, pcobstetricale, paobstetricale, activitecardiaqueobstetricale, "
                            . "mouvementactifobstetricale, semaineobstetricale, jourobstetricale, dpaobstetricale, datedernierregleobstetricale, "
                            . "poidsfoetalobstetricale, frequencecardiaqueobstetricale, longueurfemoraleobstetricale, rcfobstetricale, "
                            . "morphologieobstetricale, liquideamniostiqueobstetricale, quantiteliquideobstetricale, placentainsertionobstetricale, "
                            . "placentaechostructureobstetricale, presentationobstetricale, colobstetricale, collongueurobstetricale, sexeobstetricale, "
                            . "conclusionobstetricale, dateobstetricale) values('" . $rowre["idresultatechographie"] . "', '" . ($reg["1"]["datejour"]) . "', "
                            . "'" . ($reg["1"]["heurejour"]) . "', '" . addslashes($reg["1"]["localisation"]) . "', '" . ($reg["1"]["nbfoetus"]) . "', "
                            . "'" . ($reg["1"]["bip"]) . "', '" . ($reg["1"]["pc"]) . "', '" . ($reg["1"]["pa"]) . "', '" . ($reg["1"]["ac"]) . "', "
                            . "'" . ($reg["1"]["mouvement"]) . "', '" . ($reg["1"]["semaine"]) . "', '" . ($reg["1"]["jour"]) . "', "
                            . "'" . ($reg["1"]["dpa"]) . "', '" . ($reg["1"]["ddr"]) . "', '" . ($reg["1"]["poids"]) . "', "
                            . "'" . ($reg["1"]["frequencecardiaque"]) . "', '" . addslashes($reg["1"]["longueurfemorale"]) . "', '" . ($reg["1"]["rcf"]) . "', "
                            . "'" . addslashes($reg["1"]["morphologie"]) . "', '" . addslashes($reg["1"]["liqam"]) . "', '" . ($reg["1"]["qte"]) . "', "
                            . "'" . addslashes($reg["1"]["placentai"]) . "', '" . addslashes($reg["1"]["placentae"]) . "', "
                            . "'" . addslashes($reg["1"]["presentation"]) . "', '" . ($reg["1"]["col1"]) . "', '" . addslashes($reg["1"]["col2"]) . "', "
                            . "'" . addslashes($reg["1"]["sexe"]) . "', '" . addslashes($reg["1"]["conclusion"]) . "', NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_obstetricale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowobstetricale = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_obstetricale set datejourobstetricale='" . ($reg["1"]["datejour"]) . "', "
                            . "heureobstetricale='" . addslashes($reg["1"]["heurejour"]) . "', "
                            . "localisationobstetricale='" . addslashes($reg["1"]["localisation"]) . "', nombrefoetusobstetricale='" . ($reg["1"]["nbfoetus"]) . "', "
                            . "bipobstetricale='" . ($reg["1"]["bip"]) . "', pcobstetricale='" . ($reg["1"]["pc"]) . "', paobstetricale='" . ($reg["1"]["pa"]) . "', "
                            . "activitecardiaqueobstetricale='" . ($reg["1"]["ac"]) . "', mouvementactifobstetricale='" . ($reg["1"]["mouvement"]) . "', "
                            . "semaineobstetricale='" . ($reg["1"]["semaine"]) . "', jourobstetricale='" . ($reg["1"]["jour"]) . "', "
                            . "datedernierregleobstetricale='" . ($reg["1"]["ddr"]) . "', dpaobstetricale='" . ($reg["1"]["dpa"]) . "', poidsfoetalobstetricale='" . ($reg["1"]["poids"]) . "', "
                            . "frequencecardiaqueobstetricale='" . ($reg["1"]["frequencecardiaque"]) . "', longueurfemoraleobstetricale='" . ($reg["1"]["longueurfemorale"]) . "', "
                            . "rcfobstetricale='" . ($reg["1"]["rcf"]) . "', morphologieobstetricale='" . addslashes($reg["1"]["morphologie"]) . "', "
                            . "liquideamniostiqueobstetricale='" . addslashes($reg["1"]["liqam"]) . "', quantiteliquideobstetricale='" . ($reg["1"]["qte"]) . "', "
                            . "placentainsertionobstetricale='" . addslashes($reg["1"]["placentai"]) . "', "
                            . "placentaechostructureobstetricale='" . addslashes($reg["1"]["placentae"]) . "', "
                            . "presentationobstetricale='" . addslashes($reg["1"]["presentation"]) . "', "
                            . "colobstetricale='" . addslashes($reg["1"]["col1"]) . "', "
                            . "collongueurobstetricale='" . addslashes($reg["1"]["col2"]) . "', "
                            . "sexeobstetricale='" . addslashes($reg["1"]["sexe"]) . "', conclusionobstetricale='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_obstetricale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowobstetricale = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "echographie ";
        if ($row["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            
            }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieobstetricale']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function update_obstetricale_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $ideo = $reg["1"]["idobstetricale"];
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowobstetricale = NULL;
        $reqnf = $con->query("select * from hp_obstetricale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_obstetricale set datejourobstetricale='" . ($reg["1"]["datejour"]) . "', "
                            . "heureobstetricale='" . addslashes($reg["1"]["heurejour"]) . "', "
                            . "localisationobstetricale='" . addslashes($reg["1"]["localisation"]) . "', nombrefoetusobstetricale='" . ($reg["1"]["nbfoetus"]) . "', "
                            . "bipobstetricale='" . ($reg["1"]["bip"]) . "', pcobstetricale='" . ($reg["1"]["pc"]) . "', paobstetricale='" . ($reg["1"]["pa"]) . "', "
                            . "activitecardiaqueobstetricale='" . ($reg["1"]["ac"]) . "', mouvementactifobstetricale='" . ($reg["1"]["mouvement"]) . "', "
                            . "semaineobstetricale='" . ($reg["1"]["semaine"]) . "', jourobstetricale='" . ($reg["1"]["jour"]) . "', "
                            . "datedernierregleobstetricale='" . ($reg["1"]["ddr"]) . "', dpaobstetricale='" . ($reg["1"]["dpa"]) . "', poidsfoetalobstetricale='" . ($reg["1"]["poids"]) . "', "
                            . "frequencecardiaqueobstetricale='" . ($reg["1"]["frequencecardiaque"]) . "', longueurfemoraleobstetricale='" . ($reg["1"]["longueurfemorale"]) . "', "
                            . "rcfobstetricale='" . ($reg["1"]["rcf"]) . "', morphologieobstetricale='" . addslashes($reg["1"]["morphologie"]) . "', "
                            . "liquideamniostiqueobstetricale='" . addslashes($reg["1"]["liqam"]) . "', quantiteliquideobstetricale='" . ($reg["1"]["qte"]) . "', "
                            . "placentainsertionobstetricale='" . addslashes($reg["1"]["placentai"]) . "', "
                            . "placentaechostructureobstetricale='" . addslashes($reg["1"]["placentae"]) . "', "
                            . "presentationobstetricale='" . addslashes($reg["1"]["presentation"]) . "', "
                            . "colobstetricale='" . addslashes($reg["1"]["col1"]) . "', "
                            . "collongueurobstetricale='" . addslashes($reg["1"]["col2"]) . "', "
                            . "sexeobstetricale='" . addslashes($reg["1"]["sexe"]) . "', conclusionobstetricale='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_obstetricale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowobstetricale = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalediter/edit_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idobstetricale=' . $ideo . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieobstetricalee']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function inserer_obstetricale1_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_echographie(idechographiepatient, dateresultatechographie) "
                            . "values('" . $idep . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowobstetricale1 = NULL;
        $reqnf = $con->query("select * from hp_obstetricale_1 where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_obstetricale_1(idresultatechographie, datejourobstetricale1, heureobstetricale1, gravideobstetricale1, "
                            . "localisationobstetricale1, nombrefoetusobstetricale1, vitaliteobstetricale1, activitecardiaqueobstetricale1, "
                            . "mouvementactifobstetricale1, semaineobstetricale1, jourobstetricale1, dpaobstetricale1, datedernierregleobstetricale1, "
                            . "poidsobstetricale1, frequencecardiaqueobstetricale1, longueursacobstetricale1, longueurcranioobstetricale1, "
                            . "trophoblasteobstetricale1, colobstetricale1, collongueurobstetricale1, ovairedroitobstetricale1, ovairegaucheobstetricale1, epanchementobstetricale1, "
                            . "vessieobstetricale1, conclusionobstetricale1, dateobstetricale1) values('" . $rowre["idresultatechographie"] . "', '" . ($reg["1"]["datejour"]) . "', "
                            . "'" . ($reg["1"]["heurejour"]) . "', '" . addslashes($reg["1"]["gravide"]) . "', '" . addslashes($reg["1"]["localisation"]) . "', "
                            . "'" . ($reg["1"]["nbfoetus"]) . "', '" . addslashes($reg["1"]["vitalite"]) . "', '" . ($reg["1"]["ac"]) . "', '" . ($reg["1"]["mouvement"]) . "', "
                            . "'" . ($reg["1"]["semaine"]) . "', '" . ($reg["1"]["jour"]) . "', '" . ($reg["1"]["dpa"]) . "', '" . ($reg["1"]["ddr"]) . "', '" . ($reg["1"]["poids"]) . "', "
                            . "'" . ($reg["1"]["frequencecardiaque"]) . "', '" . ($reg["1"]["longueursac"]) . "', '" . ($reg["1"]["longueurcranio"]) . "', "
                            . "'" . addslashes($reg["1"]["trophoblaste"]) . "', '" . addslashes($reg["1"]["col1"]) . "', '" . ($reg["1"]["col2"]) . "', '" . addslashes($reg["1"]["ovaired"]) . "', "
                            . "'" . addslashes($reg["1"]["ovaireg"]) . "', '" . addslashes($reg["1"]["epanchement"]) . "', '" . ($reg["1"]["vessie"]) . "', "
                            . "'" . addslashes($reg["1"]["conclusion"]) . "', NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_obstetricale_1 where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowobstetricale1 = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_obstetricale_1 set datejourobstetricale1='" . ($reg["1"]["datejour"]) . "', heureobstetricale1='" . addslashes($reg["1"]["heurejour"]) . "', "
                            . "gravideobstetricale1='" . addslashes($reg["1"]["gravide"]) . "', localisationobstetricale1='" . addslashes($reg["1"]["localisation"]) . "', "
                            . "nombrefoetusobstetricale1='" . ($reg["1"]["nbfoetus"]) . "', vitaliteobstetricale1='" . addslashes($reg["1"]["vitalite"]) . "', "
                            . "activitecardiaqueobstetricale1='" . ($reg["1"]["ac"]) . "', mouvementactifobstetricale1='" . ($reg["1"]["mouvement"]) . "', "
                            . "semaineobstetricale1='" . ($reg["1"]["semaine"]) . "', jourobstetricale1='" . ($reg["1"]["jour"]) . "', "
                            . "datedernierregleobstetricale1='" . ($reg["1"]["ddr"]) . "', dpaobstetricale1='" . ($reg["1"]["dpa"]) . "', "
                            . "poidsobstetricale1='" . ($reg["1"]["poids"]) . "', frequencecardiaqueobstetricale1='" . ($reg["1"]["frequencecardiaque"]) . "', "
                            . "longueursacobstetricale1='" . ($reg["1"]["longueursac"]) . "', longueurcranioobstetricale1='" . ($reg["1"]["longueurcranio"]) . "', "
                            . "trophoblasteobstetricale1='" . addslashes($reg["1"]["trophoblaste"]) . "', colobstetricale1='" . addslashes($reg["1"]["col1"]) . "', "
                            . "collongueurobstetricale1='" . addslashes($reg["1"]["col2"]) . "', "
                            . "ovairedroitobstetricale1='" . addslashes($reg["1"]["ovaired"]) . "', ovairegaucheobstetricale1='" . addslashes($reg["1"]["ovaireg"]) . "', "
                            . "epanchementobstetricale1='" . addslashes($reg["1"]["epanchement"]) . "', "
                            . "vessieobstetricale1='" . addslashes($reg["1"]["vessie"]) . "', conclusionobstetricale1='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_obstetricale_1 where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowobstetricale1 = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "echographie ";
        if ($row["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            
            }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieobstetricale1']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function update_obstetricale1_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $ideo = $reg["1"]["idobstetricale1"];
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowobstetricale1 = NULL;
        $reqnf = $con->query("select * from hp_obstetricale_1 where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_obstetricale_1 set datejourobstetricale1='" . ($reg["1"]["datejour"]) . "', heureobstetricale1='" . addslashes($reg["1"]["heurejour"]) . "', "
                            . "gravideobstetricale1='" . addslashes($reg["1"]["gravide"]) . "', localisationobstetricale1='" . addslashes($reg["1"]["localisation"]) . "', "
                            . "nombrefoetusobstetricale1='" . ($reg["1"]["nbfoetus"]) . "', vitaliteobstetricale1='" . addslashes($reg["1"]["vitalite"]) . "', "
                            . "activitecardiaqueobstetricale1='" . ($reg["1"]["ac"]) . "', mouvementactifobstetricale1='" . ($reg["1"]["mouvement"]) . "', "
                            . "semaineobstetricale1='" . ($reg["1"]["semaine"]) . "', jourobstetricale1='" . ($reg["1"]["jour"]) . "', "
                            . "datedernierregleobstetricale1='" . ($reg["1"]["ddr"]) . "', dpaobstetricale1='" . ($reg["1"]["dpa"]) . "', "
                            . "poidsobstetricale1='" . ($reg["1"]["poids"]) . "', frequencecardiaqueobstetricale1='" . ($reg["1"]["frequencecardiaque"]) . "', "
                            . "longueursacobstetricale1='" . ($reg["1"]["longueursac"]) . "', longueurcranioobstetricale1='" . ($reg["1"]["longueurcranio"]) . "', "
                            . "trophoblasteobstetricale1='" . addslashes($reg["1"]["trophoblaste"]) . "', colobstetricale1='" . addslashes($reg["1"]["col1"]) . "', "
                            . "collongueurobstetricale1='" . addslashes($reg["1"]["col2"]) . "', "
                            . "ovairedroitobstetricale1='" . addslashes($reg["1"]["ovaired"]) . "', ovairegaucheobstetricale1='" . addslashes($reg["1"]["ovaireg"]) . "', "
                            . "epanchementobstetricale1='" . addslashes($reg["1"]["epanchement"]) . "', "
                            . "vessieobstetricale1='" . addslashes($reg["1"]["vessie"]) . "', conclusionobstetricale1='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_obstetricale_1 where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowobstetricale1 = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/hopitalediter/edit_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idobstetricale1=' . $ideo . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieobstetricale1e']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function inserer_pelvienne_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_echographie(idechographiepatient, conclusionresultatechographie, dateresultatechographie) "
                            . "values('" . $idep . "', '" . addslashes($reg["1"]["conclusion"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowpelvienne = NULL;
        $reqnf = $con->query("select * from hp_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_pelvienne(idresultatechographie, datejourpelvienne, uterusgravidepelvienne, "
                            . "uterustaillepelvienne, uteruscontourpelvienne, uterusmyometrepelvienne, "
                            . "uterusendometrepelvienne, uteruslumierecervicopelvienne, uteruscolpelvienne, ovairedroitpelvienne, "
                            . "ovairegauchepelvienne, anomaliepelvienne, epanchementpelvienne, vessiepelvienne, conclusionpelvienne, "
                            . "datepelvienne) values('" . $rowre["idresultatechographie"] . "', '" . ($reg["1"]["datejour"]) . "', "
                            . "'" . addslashes($reg["1"]["ugravide"]) . "', '" . addslashes($reg["1"]["utaille"]) . "', '" . addslashes($reg["1"]["ucontour"]) . "', "
                            . "'" . addslashes($reg["1"]["umyometre"]) . "', '" . addslashes($reg["1"]["uendometre"]) . "', "
                            . "'" . addslashes($reg["1"]["ulumiere"]) . "', '" . addslashes($reg["1"]["ucol"]) . "', '" . addslashes($reg["1"]["ovaired"]) . "', "
                            . "'" . addslashes($reg["1"]["ovaireg"]) . "', '" . addslashes($reg["1"]["anomalie"]) . "', '" . addslashes($reg["1"]["epanchement"]) . "', "
                            . "'" . addslashes($reg["1"]["vessie"]) . "', '" . addslashes($reg["1"]["conclusion"]) . "', NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowpelvienne = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_pelvienne set datejourpelvienne='" . ($reg["1"]["datejour"]) . "', uterusgravidepelvienne='" . addslashes($reg["1"]["ugravide"]) . "', "
                            . "uterustaillepelvienne='" . addslashes($reg["1"]["utaille"]) . "', uteruscontourpelvienne='" . addslashes($reg["1"]["ucontour"]) . "', "
                            . "uterusmyometrepelvienne='" . addslashes($reg["1"]["umyometre"]) . "', "
                            . "uterusendometrepelvienne='" . addslashes($reg["1"]["uendometre"]) . "', uteruslumierecervicopelvienne='" . addslashes($reg["1"]["ulumiere"]) . "', "
                            . "uteruscolpelvienne='" . addslashes($reg["1"]["ucol"]) . "', ovairedroitpelvienne='" . addslashes($reg["1"]["ovaired"]) . "', "
                            . "ovairegauchepelvienne='" . addslashes($reg["1"]["ovaireg"]) . "', anomaliepelvienne='" . addslashes($reg["1"]["anomalie"]) . "', "
                            . "epanchementpelvienne='" . addslashes($reg["1"]["epanchement"]) . "', vessiepelvienne='" . addslashes($reg["1"]["vessie"]) . "', "
                            . "conclusionpelvienne='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowpelvienne = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "echographie ";
        if ($row["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            
            }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographiepelvienne']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function update_pelvienne_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idepe = $reg["1"]["idpelvienne"];
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowpelvienne = NULL;
        $reqnf = $con->query("select * from hp_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_pelvienne set datejourpelvienne='" . ($reg["1"]["datejour"]) . "', uterusgravidepelvienne='" . addslashes($reg["1"]["ugravide"]) . "', "
                            . "uterustaillepelvienne='" . addslashes($reg["1"]["utaille"]) . "', uteruscontourpelvienne='" . addslashes($reg["1"]["ucontour"]) . "', "
                            . "uterusmyometrepelvienne='" . addslashes($reg["1"]["umyometre"]) . "', "
                            . "uterusendometrepelvienne='" . addslashes($reg["1"]["uendometre"]) . "', uteruslumierecervicopelvienne='" . addslashes($reg["1"]["ulumiere"]) . "', "
                            . "uteruscolpelvienne='" . addslashes($reg["1"]["ucol"]) . "', ovairedroitpelvienne='" . addslashes($reg["1"]["ovaired"]) . "', "
                            . "ovairegauchepelvienne='" . addslashes($reg["1"]["ovaireg"]) . "', anomaliepelvienne='" . addslashes($reg["1"]["anomalie"]) . "', "
                            . "epanchementpelvienne='" . addslashes($reg["1"]["epanchement"]) . "', "
                            . "vessiepelvienne='" . addslashes($reg["1"]["vessie"]) . "', "
                            . "conclusionpelvienne='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowpelvienne = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/hopitalediter/edit_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idpelvienne=' . $idepe . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographiepelviennee']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function inserer_testiculaire_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_echographie(idechographiepatient, conclusionresultatechographie, dateresultatechographie) "
                            . "values('" . $idep . "', '" . addslashes($reg["1"]["conclusion"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowtesticulaire = NULL;
        $reqnf = $con->query("select * from hp_testiculaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_testiculaire(idresultatechographie, datejourtesticulaire, commentaire1testiculaire, "
                            . "testiculedroittesticulaire, testiculegauchetesticulaire, epididymedroittesticulaire, "
                            . "epididymegauchetesticulaire, commentaire2testiculaire, conclusiontesticulaire, "
                            . "datetesticulaire) values('" . $rowre["idresultatechographie"] . "', '" . ($reg["1"]["datejour"]) . "', "
                            . "'" . addslashes($reg["1"]["commentaire1"]) . "', '" . addslashes($reg["1"]["testiculed"]) . "', "
                            . "'" . addslashes($reg["1"]["testiculeg"]) . "', "
                            . "'" . addslashes($reg["1"]["epididymed"]) . "', '" . addslashes($reg["1"]["epididymeg"]) . "', "
                            . "'" . addslashes($reg["1"]["commentaire2"]) . "', '" . addslashes($reg["1"]["conclusion"]) . "', NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_testiculaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowtesticulaire = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_testiculaire set datejourtesticulaire='" . ($reg["1"]["datejour"]) . "', "
                            . "commentaire1testiculaire='" . addslashes($reg["1"]["commentaire1"]) . "', "
                            . "testiculedroittesticulaire='" . addslashes($reg["1"]["testiculed"]) . "', "
                            . "testiculegauchetesticulaire='" . addslashes($reg["1"]["testiculeg"]) . "', "
                            . "epididymedroittesticulaire='" . addslashes($reg["1"]["epididymed"]) . "', "
                            . "epididymegauchetesticulaire='" . addslashes($reg["1"]["epididymeg"]) . "', "
                            . "commentaire2testiculaire='" . addslashes($reg["1"]["commentaire2"]) . "', "
                            . "conclusiontesticulaire='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_testiculaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowtesticulaire = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "echographie ";
        if ($row["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            
            }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitaltesticulaire/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographietesticulaire']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitaltesticulaire/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function update_testiculaire_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idepe = $reg["1"]["idtesticulaire"];
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowtesticulaire = NULL;
        $reqnf = $con->query("select * from hp_testiculaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_testiculaire set datejourtesticulaire='" . ($reg["1"]["datejour"]) . "', "
                            . "commentaire1testiculaire='" . addslashes($reg["1"]["commentaire1"]) . "', "
                            . "testiculedroittesticulaire='" . addslashes($reg["1"]["testiculed"]) . "', "
                            . "testiculegauchetesticulaire='" . addslashes($reg["1"]["testiculeg"]) . "', "
                            . "epididymedroittesticulaire='" . addslashes($reg["1"]["epididymed"]) . "', "
                            . "epididymegauchetesticulaire='" . addslashes($reg["1"]["epididymeg"]) . "', "
                            . "commentaire2testiculaire='" . addslashes($reg["1"]["commentaire2"]) . "', "
                            . "conclusiontesticulaire='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_testiculaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowtesticulaire = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitaltesticulaire/hopitalediter/edit_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idtesticulaire=' . $idepe . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographietesticulairee']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitaltesticulaire/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function inserer_mammaire_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_echographie(idechographiepatient, conclusionresultatechographie, dateresultatechographie) "
                            . "values('" . $idep . "', '" . addslashes($reg["1"]["conclusion"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowmammaire = NULL;
        $reqnf = $con->query("select * from hp_mammaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_mammaire(idresultatechographie, datejourmammaire, physiquemammaire, "
                            . "sonographiquemammaire, conclusionmammaire, "
                            . "datemammaire) values('" . $rowre["idresultatechographie"] . "', '" . ($reg["1"]["datejour"]) . "', "
                            . "'" . addslashes($reg["1"]["physique"]) . "', '" . addslashes($reg["1"]["sonographique"]) . "', "
                            . "'" . addslashes($reg["1"]["conclusion"]) . "', NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_mammaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowmammaire = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_mammaire set datejourmammaire='" . ($reg["1"]["datejour"]) . "', "
                            . "physiquemammaire='" . addslashes($reg["1"]["physique"]) . "', "
                            . "sonographiquemammaire='" . addslashes($reg["1"]["sonographique"]) . "', "
                            . "conclusionmammaire='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_mammaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowmammaire = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "echographie ";
        if ($row["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            
            }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalmammaire/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographiemammaire']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalmammaire/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function update_mammaire_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idepe = $reg["1"]["idmammaire"];
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowmammaire = NULL;
        $reqnf = $con->query("select * from hp_mammaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_mammaire set datejourmammaire='" . ($reg["1"]["datejour"]) . "', "
                            . "physiquemammaire='" . addslashes($reg["1"]["physique"]) . "', "
                            . "sonographiquemammaire='" . addslashes($reg["1"]["sonographique"]) . "', "
                            . "conclusionmammaire='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_mammaire where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowmammaire = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalmammaire/hopitalediter/edit_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idmammaire=' . $idepe . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographiemammairee']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalmammaire/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function inserer_abdominopelvienne_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_echographie(idechographiepatient, conclusionresultatechographie, dateresultatechographie) "
                            . "values('" . $idep . "', '" . addslashes($reg["1"]["conclusion"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowabdominopelvienne = NULL;
        $reqnf = $con->query("select * from hp_abdomino_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_abdomino_pelvienne(idresultatechographie, datejourabdominopelvienne, abdominaleabdominopelvienne, "
                            . "pelvienneabdominopelvienne, conclusionabdominopelvienne, "
                            . "dateabdominopelvienne) values('" . $rowre["idresultatechographie"] . "', '" . ($reg["1"]["datejour"]) . "', "
                            . "'" . addslashes($reg["1"]["abdominale"]) . "', '" . addslashes($reg["1"]["pelvienne"]) . "', "
                            . "'" . addslashes($reg["1"]["conclusion"]) . "', NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_abdomino_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowabdominopelvienne = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_abdomino_pelvienne set datejourabdominopelvienne='" . ($reg["1"]["datejour"]) . "', "
                            . "abdominaleabdominopelvienne='" . addslashes($reg["1"]["abdominale"]) . "', "
                            . "pelvienneabdominopelvienne='" . addslashes($reg["1"]["pelvienne"]) . "', "
                            . "conclusionabdominopelvienne='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_abdomino_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowabdominopelvienne = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "echographie ";
        if ($row["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            
            }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieabdominopelvienne']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function update_abdominopelvienne_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idepe = $reg["1"]["idabdominopelvienne"];
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowabdominopelvienne = NULL;
        $reqnf = $con->query("select * from hp_abdomino_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_abdomino_pelvienne set datejourabdominopelvienne='" . ($reg["1"]["datejour"]) . "', "
                            . "abdominaleabdominopelvienne='" . addslashes($reg["1"]["abdominale"]) . "', "
                            . "pelvienneabdominopelvienne='" . addslashes($reg["1"]["pelvienne"]) . "', "
                            . "conclusionabdominopelvienne='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_abdomino_pelvienne where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowabdominopelvienne = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/hopitalediter/edit_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idabdominopelvienne=' . $idepe . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieabdominopelviennee']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function inserer_abdominale_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_echographie(idechographiepatient, conclusionresultatechographie, dateresultatechographie) "
                            . "values('" . $idep . "', '" . addslashes($reg["1"]["conclusion"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowabdominale = NULL;
        $reqnf = $con->query("select * from hp_abdominale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_abdominale(idresultatechographie, datejourabdominale, resultatabdominale, "
                            . "conclusionabdominale, "
                            . "dateabdominale) values('" . $rowre["idresultatechographie"] . "', '" . ($reg["1"]["datejour"]) . "', "
                            . "'" . addslashes($reg["1"]["resultat"]) . "', "
                    . "'" . addslashes($reg["1"]["conclusion"]) . "', NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_abdominale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowabdominale = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_abdominale set datejourabdominale='" . ($reg["1"]["datejour"]) . "', "
                            . "resultatabdominale='" . addslashes($reg["1"]["resultat"]) . "', "
                            . "conclusionabdominale='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_abdominale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowabdominale = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "echographie ";
        if ($row["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            
            }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominale/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieabdominale']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominale/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function update_abdominale_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idepe = $reg["1"]["idabdominale"];
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowabdominale = NULL;
        $reqnf = $con->query("select * from hp_abdominale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_abdominale set datejourabdominale='" . ($reg["1"]["datejour"]) . "', "
                            . "resultatabdominale='" . addslashes($reg["1"]["resultat"]) . "', "
                            . "conclusionabdominale='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_abdominale where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowabdominale = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominale/hopitalediter/edit_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idabdominale=' . $idepe . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieabdominalee']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominale/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function inserer_partiemolle_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_echographie(idechographiepatient, conclusionresultatechographie, dateresultatechographie) "
                            . "values('" . $idep . "', '" . addslashes($reg["1"]["conclusion"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowpartiemolle = NULL;
        $reqnf = $con->query("select * from hp_partie_molle where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_partie_molle(idresultatechographie, datejourpartiemolle, resultatpartiemolle, "
                            . "conclusionpartiemolle, "
                            . "datepartiemolle) values('" . $rowre["idresultatechographie"] . "', '" . ($reg["1"]["datejour"]) . "', "
                            . "'" . addslashes($reg["1"]["resultat"]) . "', "
                    . "'" . addslashes($reg["1"]["conclusion"]) . "', NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_partie_molle where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowpartiemolle = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_partie_molle set datejourpartiemolle='" . ($reg["1"]["datejour"]) . "', "
                            . "resultatpartiemolle='" . addslashes($reg["1"]["resultat"]) . "', "
                            . "conclusionpartiemolle='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_partie_molle where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowpartiemolle = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "echographie ";
        if ($row["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            
            }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalpartiemolle/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographiepartiemolle']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalpartiemolle/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function update_partiemolle_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idepe = $reg["1"]["idpartiemolle"];
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowpartiemolle = NULL;
        $reqnf = $con->query("select * from hp_partie_molle where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_partie_molle set datejourpartiemolle='" . ($reg["1"]["datejour"]) . "', "
                            . "resultatpartiemolle='" . addslashes($reg["1"]["resultat"]) . "', "
                            . "conclusionpartiemolle='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_partie_molle where idresultatechographie='" . $rowre["idresultatechographie"] . "'") or die(mysqli_error($con));
            $rowpartiemolle = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalpartiemolle/hopitalediter/edit_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idpartiemolle=' . $idepe . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographiepartiemollee']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalpartiemolle/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function inserer_autre_echo_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_echographie(idechographiepatient, conclusionresultatechographie, dateresultatechographie) "
                            . "values('" . $idep . "', '" . addslashes($reg["1"]["conclusion"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conteneurresultatechographie='" . addslashes($reg["1"]["resultat"]) . "', "
                    . "conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "echographie ";
        if ($row["idhospitalisation"] != NULL) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantechographiepatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            
            }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalautre/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieautre']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalautre/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}

function update_autre_echo_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idepe = $reg["1"]["idautre"];
        $idep = $reg["1"]["idechographiepatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_echographie set conteneurresultatechographie='" . addslashes($reg["1"]["resultat"]) . "', "
                    . "conclusionresultatechographie='" . addslashes($reg["1"]["conclusion"]) . "' where "
                            . "idresultatechographie='" . $rowre2["idresultatechographie"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_echographie where idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_echographie_patient set indicationechographiepatient='" . addslashes($reg["1"]["indication"]) . "', "
                        . "prescripteurechographiepatient='" . addslashes($reg["1"]["prescripteur"]) . "', etatechographiepatient=1 where "
                        . "idechographiepatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalautre/hopitalediter/edit_echographie';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idautre=' . $idepe . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographieautree']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalautre/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographiepatient=' . $idep . '">');
        }
    }
}
