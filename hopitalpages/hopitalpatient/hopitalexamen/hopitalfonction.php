<?php

function lister_examen_patient($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $rsltfnp = $con->query("select * from hp_examen_patient as lc left join hp_examen as f on lc.idexamen=f.idexamen "
            . "left join hp_laboratoire as l on f.idlaboratoire=l.idlaboratoire left join hp_service as u on "
            . "l.idservice=u.idservice order by lc.dateexamenpatient desc ") or die(mysqli_error($con));

    while ($recfnp = mysqli_fetch_assoc($rsltfnp)) {
        $req_fin = $con->query("select * from hp_sous_dossier as sd left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where sd.idsousdossier='" . $recfnp["idsousdossier"] . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);
        $rsltfnp2 = $con->query("select * from hp_facture where idexamenpatient='" . $recfnp["idexamenpatient"] . "' and "
                . "etatfacture=true ") or die(mysqli_error($con));
        $nbfnp = mysqli_num_rows($rsltfnp2);

//        print_r($recfnp);
        ?>

        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recfnp["codeexamenpatient"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recfnp["typeexamen"])) ?></td>
            <td>
                <?php echo $row["codepatient"]; ?> <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?>
            </td>
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
                if (($nbfnp != 0) || ($recfnp["idhospitalisation"] != NULL)) {
                    if ($recfnp["typeexamen"] == "Numération Formule Sanguine (NFS)") {
                        if (!$recfnp["etatexamenpatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Laborantin")))) {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalajouter/ajout_examen') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="executer cet examen" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeexamen"] == "Prélèvement Cervico-Vaginal: PCV") {
                        if (!$recfnp["etatexamenpatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Laborantin")))) {
                            
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalajouter/ajout_examen') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="executer cet examen" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeexamen"] == "Sérologie V.I.H") {
                        if (!$recfnp["etatexamenpatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Laborantin")))) {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/hopitalajouter/ajout_examen') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="executer cet examen" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeexamen"] == "Coprologie Parasitaire: Selles") {
                        if (!$recfnp["etatexamenpatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Laborantin")))) {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalajouter/ajout_examen') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="executer cet examen" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else if ($recfnp["typeexamen"] == "Sérologie de Widal et Felix") {
                        if (!$recfnp["etatexamenpatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Laborantin")))) {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/hopitalajouter/ajout_examen') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="executer cet examen" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/lister_resultat') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    } else {
                        if (!$recfnp["etatexamenpatient"]) {
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Laborantin")))) {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalautre/hopitalajouter/ajout_examen') ?>&idexamenpatient=<?php echo $recfnp["idexamenpatient"] ?>">
                                <span title="executer cet examen" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                            }
                        } else {
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
}

function inserer_nfs_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_examen(idexamenpatient, idlaboratoire, interpretationresultatexamen, dateresultatexamen) "
                            . "values('" . $idep . "', '" . $reg["1"]["laboratoire"] . "', '" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rownfs = NULL;
        $reqnf = $con->query("select * from hp_nfs where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_nfs(idresultatexamen, idlaboratoire, interpretationnfs) "
                            . "values('" . $rowre["idresultatexamen"] . "', '" . $reg["1"]["laboratoire"] . "', "
                            . "'" . addslashes($reg["1"]["interpretation"]) . "')") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_nfs where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rownfs = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_nfs set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationnfs='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_nfs where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rownfs = mysqli_fetch_array($reqmc2);
        }
        for ($i = 0; $i < $reg["1"]["nbexamen"]; $i++) {
            if (in_array($i, $reg[1]['tligne[]'])) {
                $id = $reg["1"]["idlignenfs" . $i];
                $valeur = $reg["1"]["valeur" . $i];

                $reqmc = $con->query("select * from hp_detail_nfs as n where n.idnfs='" . $rownfs["idnfs"] . "' "
                        . "and n.idlignenfs='" . $id . "' ") or die(mysqli_error($con));
                $nbmc = mysqli_num_rows($reqmc);
                if ($nbmc == 0) {
                    $rsltn = $con->query("insert into hp_detail_nfs(idnfs, idlignenfs, valeurdetailnfs) "
                            . "values('" . $rownfs["idnfs"] . "', '" . $id . "', '" . $valeur . "')") or die(mysqli_error($con));

                    $op = "Execution";
                    $obj = "Examen " . $row["codeexamenpatient"];

                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                        $con->query("insert into hp_trace(idpatient, operation, objet, datetrace) "
                                        . "values('" . $row["idpatient"] . "', "
                                        . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
                    } else {
                        $con->query("insert into hp_trace(idcomptepersonnel, idpatient, operation, objet, datetrace) "
                                        . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row["idpatient"] . "', "
                                        . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
                    }
                } else {
                    $rowmc1 = mysqli_fetch_assoc($reqmc);

                    $rsltn = $con->query("update hp_detail_nfs set idnfs=" . $rownfs["idnfs"] . ", "
                            . "idlignenfs='" . $id . "', valeurdetailnfs='" . $valeur . "' where "
                            . "iddetailnfs='" . $rowmc1["iddetailnfs"] . "'") or die(mysqli_error($con));
                }
            }
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "Examen ";
        if ($row["idhospitalisation"] != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalajouter/ajout_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamennfs']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function update_nfs_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idenfs = $reg["1"]["idnfs"];
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rownfs = NULL;
        $reqnf = $con->query("select * from hp_nfs where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_nfs set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationnfs='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_nfs where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rownfs = mysqli_fetch_array($reqmc2);
        }
        for ($i = 0; $i < $reg["1"]["nbexamen"]; $i++) {
            if (in_array($i, $reg[1]['tligne[]'])) {
                $id = $reg["1"]["idlignenfs" . $i];
                $valeur = $reg["1"]["valeur" . $i];

                $reqmc = $con->query("select * from hp_detail_nfs as n where n.idnfs='" . $rownfs["idnfs"] . "' "
                        . "and n.idlignenfs='" . $id . "' ") or die(mysqli_error($con));
                $nbmc = mysqli_num_rows($reqmc);
                if ($nbmc == 0) {
                    $rsltn = $con->query("insert into hp_detail_nfs(idnfs, idlignenfs, valeurdetailnfs) "
                            . "values('" . $rownfs["idnfs"] . "', '" . $id . "', '" . $valeur . "')") or die(mysqli_error($con));

                    $op = "Execution";
                    $obj = "Examen " . $row["codeexamenpatient"];

                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                        $con->query("insert into hp_trace(idpatient, operation, objet, datetrace) "
                                        . "values('" . $row["idpatient"] . "', "
                                        . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
                    } else {
                        $con->query("insert into hp_trace(idcomptepersonnel, idpatient, operation, objet, datetrace) "
                                        . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row["idpatient"] . "', "
                                        . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
                    }
                } else {
                    $rowmc1 = mysqli_fetch_assoc($reqmc);

                    $rsltn = $con->query("update hp_detail_nfs set idnfs=" . $rownfs["idnfs"] . ", "
                            . "idlignenfs='" . $id . "', valeurdetailnfs='" . $valeur . "' where "
                            . "iddetailnfs='" . $rowmc1["iddetailnfs"] . "'") or die(mysqli_error($con));
                }
            }
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalediter/edit_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idnfs=' . $idenfs . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamennfse']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function inserer_pcv_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_examen(idexamenpatient, idlaboratoire, interpretationresultatexamen, dateresultatexamen) "
                            . "values('" . $idep . "', '" . $reg["1"]["laboratoire"] . "', '" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowpcv = NULL;
        $reqnf = $con->query("select * from hp_pcv where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_pcv(idresultatexamen, idlaboratoire, aspectcolpcv, quantitepcv, consistancepcv, "
                            . "odeurpcv, couleurpcv, trichomonaspcv, levurespcv, leucocytepcv, hematiepcv, cluepcv, cellulepcv, "
                            . "coccinegatifpcv, coccipositifpcv, bacillesnegatifpcv, bacillespositifpcv, typeflorepcv, interpretationpcv) "
                            . "values('" . $rowre["idresultatexamen"] . "', '" . $reg["1"]["laboratoire"] . "', "
                            . "'" . addslashes($reg["1"]["col"]) . "', '" . ($reg["1"]["leucqte"]) . "', "
                            . "'" . addslashes($reg["1"]["leuccons"]) . "', '" . addslashes($reg["1"]["leucodeur"]) . "', "
                            . "'" . addslashes($reg["1"]["leuccouleur"]) . "', '" . addslashes($reg["1"]["etattv"]) . "', "
                            . "'" . addslashes($reg["1"]["etatlev"]) . "', '" . addslashes($reg["1"]["etatleuc"]) . "', "
                            . "'" . addslashes($reg["1"]["etathema"]) . "', '" . addslashes($reg["1"]["etatcc"]) . "', "
                            . "'" . addslashes($reg["1"]["etatce"]) . "', '" . addslashes($reg["1"]["colorcgn"]) . "', "
                            . "'" . addslashes($reg["1"]["colorcgp"]) . "', '" . addslashes($reg["1"]["colorbgn"]) . "', "
                            . "'" . addslashes($reg["1"]["colorbgp"]) . "', '" . addslashes($reg["1"]["flore"]) . "', "
                            . "'" . addslashes($reg["1"]["interpretation"]) . "')") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_pcv where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowpcv = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_pcv set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationpcv='" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "aspectcolpcv='" . addslashes($reg["1"]["col"]) . "', "
                            . "quantitepcv='" . addslashes($reg["1"]["leucqte"]) . "', consistancepcv='" . addslashes($reg["1"]["leuccons"]) . "', "
                            . "odeurpcv='" . addslashes($reg["1"]["leucodeur"]) . "', couleurpcv='" . addslashes($reg["1"]["leuccouleur"]) . "', "
                            . "trichomonaspcv='" . addslashes($reg["1"]["etattv"]) . "', levurespcv='" . addslashes($reg["1"]["etatlev"]) . "', "
                            . "leucocytepcv='" . addslashes($reg["1"]["etatleuc"]) . "', hematiepcv='" . addslashes($reg["1"]["etathema"]) . "', "
                            . "cluepcv='" . addslashes($reg["1"]["etatcc"]) . "', cellulepcv='" . addslashes($reg["1"]["etatce"]) . "', "
                            . "coccinegatifpcv='" . addslashes($reg["1"]["colorcgn"]) . "', "
                            . "coccipositifpcv='" . addslashes($reg["1"]["colorcgp"]) . "', "
                            . "bacillesnegatifpcv='" . addslashes($reg["1"]["colorbgn"]) . "', "
                            . "bacillespositifpcv='" . addslashes($reg["1"]["colorbgp"]) . "', "
                            . "typeflorepcv='" . addslashes($reg["1"]["flore"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_pcv where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowpcv = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "Examen ";
        if ($row["idhospitalisation"] != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalajouter/ajout_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamenpcv']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function update_pcv_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idepcv = $reg["1"]["idpcv"];
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowpcv = NULL;
        $reqnf = $con->query("select * from hp_pcv where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_pcv set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationpcv='" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "aspectcolpcv='" . addslashes($reg["1"]["col"]) . "', "
                            . "quantitepcv='" . addslashes($reg["1"]["leucqte"]) . "', consistancepcv='" . addslashes($reg["1"]["leuccons"]) . "', "
                            . "odeurpcv='" . addslashes($reg["1"]["leucodeur"]) . "', couleurpcv='" . addslashes($reg["1"]["leuccouleur"]) . "', "
                            . "trichomonaspcv='" . addslashes($reg["1"]["etattv"]) . "', levurespcv='" . addslashes($reg["1"]["etatlev"]) . "', "
                            . "leucocytepcv='" . addslashes($reg["1"]["etatleuc"]) . "', hematiepcv='" . addslashes($reg["1"]["etathema"]) . "', "
                            . "cluepcv='" . addslashes($reg["1"]["etatcc"]) . "', cellulepcv='" . addslashes($reg["1"]["etatce"]) . "', "
                            . "coccinegatifpcv='" . addslashes($reg["1"]["colorcgn"]) . "', "
                            . "coccipositifpcv='" . addslashes($reg["1"]["colorcgp"]) . "', "
                            . "bacillesnegatifpcv='" . addslashes($reg["1"]["colorbgn"]) . "', "
                            . "bacillespositifpcv='" . addslashes($reg["1"]["colorbgp"]) . "', "
                            . "typeflorepcv='" . addslashes($reg["1"]["flore"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_pcv where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowpcv = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalediter/edit_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idpcv=' . $idepcv . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamenpcve']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function inserer_vih_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_examen(idexamenpatient, idlaboratoire, interpretationresultatexamen, dateresultatexamen) "
                            . "values('" . $idep . "', '" . $reg["1"]["laboratoire"] . "', '" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowvih = NULL;
        $reqnf = $con->query("select * from hp_vih where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_vih(idresultatexamen, idlaboratoire, methodevih, resultatvih, interpretationvih) "
                            . "values('" . $rowre["idresultatexamen"] . "', '" . $reg["1"]["laboratoire"] . "', "
                            . "'" . addslashes($reg["1"]["methode"]) . "', '" . ($reg["1"]["resultat"]) . "', "
                            . "'" . addslashes($reg["1"]["interpretation"]) . "')") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_vih where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowvih = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_vih set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationvih='" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "methodevih='" . addslashes($reg["1"]["methode"]) . "', "
                            . "resultatvih='" . addslashes($reg["1"]["resultat"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_vih where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowvih = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "Examen ";
        if ($row["idhospitalisation"] != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/hopitalajouter/ajout_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamenvih']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function update_vih_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idevih = $reg["1"]["idvih"];
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowvih = NULL;
        $reqnf = $con->query("select * from hp_vih where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_vih set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationvih='" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "methodevih='" . addslashes($reg["1"]["methode"]) . "', "
                            . "resultatvih='" . addslashes($reg["1"]["resultat"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_vih where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowvih = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/hopitalediter/edit_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idvih=' . $idevih . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamenvihe']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function inserer_coprologie_parasitaire_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_examen(idexamenpatient, idlaboratoire, interpretationresultatexamen, dateresultatexamen) "
                            . "values('" . $idep . "', '" . $reg["1"]["laboratoire"] . "', '" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowcoprologie_parasitaire = NULL;
        $reqnf = $con->query("select * from hp_coprologie_parasitaire where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_coprologie_parasitaire(idresultatexamen, idlaboratoire, glairecoprologieparasitaire, consistancecoprologieparasitaire, "
                            . "odeurcoprologieparasitaire, couleurcoprologieparasitaire, sangcoprologieparasitaire, parasiteadultecoprologieparasitaire, "
                    . "debrisalimentairecoprologieparasitaire, digestioncoprologieparasitaire, trichomonascoprologieparasitaire, levurescoprologieparasitaire, "
                    . "parasitecoprologieparasitaire, leucocytecoprologieparasitaire, hematiecoprologieparasitaire, "
                    . "cluecoprologieparasitaire, cellulecoprologieparasitaire, "
                            . "cristauxcoprologieparasitaire, interpretationcoprologieparasitaire) "
                            . "values('" . $rowre["idresultatexamen"] . "', '" . $reg["1"]["laboratoire"] . "', "
                            . "'" . addslashes($reg["1"]["glaire"]) . "', "
                            . "'" . addslashes($reg["1"]["cons"]) . "', '" . addslashes($reg["1"]["odeur"]) . "', "
                            . "'" . addslashes($reg["1"]["couleur"]) . "', '" . addslashes($reg["1"]["sang"]) . "', "
                            . "'" . addslashes($reg["1"]["parasiteadulte"]) . "', '" . addslashes($reg["1"]["debris"]) . "', "
                            . "'" . addslashes($reg["1"]["digestion"]) . "', '" . addslashes($reg["1"]["etattv"]) . "', "
                            . "'" . addslashes($reg["1"]["etatlev"]) . "', '" . addslashes($reg["1"]["parasite"]) . "', "
                            . "'" . addslashes($reg["1"]["clue"]) . "', '" . addslashes($reg["1"]["leucocyte"]) . "', "
                            . "'" . addslashes($reg["1"]["hematie"]) . "', '" . addslashes($reg["1"]["cellule"]) . "', "
                            . "'" . addslashes($reg["1"]["cristaux"]) . "', "
                            . "'" . addslashes($reg["1"]["interpretation"]) . "')") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_coprologie_parasitaire where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowcoprologie_parasitaire = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_coprologie_parasitaire set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationcoprologieparasitaire='" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "glairecoprologieparasitaire='" . addslashes($reg["1"]["glaire"]) . "', consistancecoprologieparasitaire='" . addslashes($reg["1"]["cons"]) . "', "
                            . "odeurcoprologieparasitaire='" . addslashes($reg["1"]["odeur"]) . "', couleurcoprologieparasitaire='" . addslashes($reg["1"]["couleur"]) . "', "
                            . "sangcoprologieparasitaire='" . addslashes($reg["1"]["sang"]) . "', parasiteadultecoprologieparasitaire='" . addslashes($reg["1"]["parasiteadulte"]) . "', "
                            . "debrisalimentairecoprologieparasitaire='" . addslashes($reg["1"]["debris"]) . "', digestioncoprologieparasitaire='" . addslashes($reg["1"]["digestion"]) . "', "
                            . "trichomonascoprologieparasitaire='" . addslashes($reg["1"]["etattv"]) . "', levurescoprologieparasitaire='" . addslashes($reg["1"]["etatlev"]) . "', "
                            . "parasitecoprologieparasitaire='" . addslashes($reg["1"]["parasite"]) . "', "
                            . "leucocytecoprologieparasitaire='" . addslashes($reg["1"]["leucocyte"]) . "', "
                            . "hematiecoprologieparasitaire='" . addslashes($reg["1"]["hematie"]) . "', "
                            . "cluecoprologieparasitaire='" . addslashes($reg["1"]["clue"]) . "', cellulecoprologieparasitaire='" . addslashes($reg["1"]["cellule"]) . "', "
                            . "cristauxcoprologieparasitaire='" . addslashes($reg["1"]["cristaux"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_coprologie_parasitaire where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowcoprologie_parasitaire = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "Examen ";
        if ($row["idhospitalisation"] != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalajouter/ajout_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamencoprologie_parasitaire']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function update_coprologie_parasitaire_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idecpp = $reg["1"]["idcoprologieparasitaire"];
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowcoprologie_parasitaire = NULL;
        $reqnf = $con->query("select * from hp_coprologie_parasitaire where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_coprologie_parasitaire set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationcoprologieparasitaire='" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "glairecoprologieparasitaire='" . addslashes($reg["1"]["glaire"]) . "', consistancecoprologieparasitaire='" . addslashes($reg["1"]["cons"]) . "', "
                            . "odeurcoprologieparasitaire='" . addslashes($reg["1"]["odeur"]) . "', couleurcoprologieparasitaire='" . addslashes($reg["1"]["couleur"]) . "', "
                            . "sangcoprologieparasitaire='" . addslashes($reg["1"]["sang"]) . "', parasiteadultecoprologieparasitaire='" . addslashes($reg["1"]["parasiteadulte"]) . "', "
                            . "debrisalimentairecoprologieparasitaire='" . addslashes($reg["1"]["debris"]) . "', digestioncoprologieparasitaire='" . addslashes($reg["1"]["digestion"]) . "', "
                            . "trichomonascoprologieparasitaire='" . addslashes($reg["1"]["etattv"]) . "', levurescoprologieparasitaire='" . addslashes($reg["1"]["etatlev"]) . "', "
                            . "parasitecoprologieparasitaire='" . addslashes($reg["1"]["parasite"]) . "', "
                            . "leucocytecoprologieparasitaire='" . addslashes($reg["1"]["leucocyte"]) . "', "
                            . "hematiecoprologieparasitaire='" . addslashes($reg["1"]["hematie"]) . "', "
                            . "cluecoprologieparasitaire='" . addslashes($reg["1"]["clue"]) . "', cellulecoprologieparasitaire='" . addslashes($reg["1"]["cellule"]) . "', "
                            . "cristauxcoprologieparasitaire='" . addslashes($reg["1"]["cristaux"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_coprologie_parasitaire where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowcoprologie_parasitaire = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalediter/edit_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&coprologieparasitaire=' . $idecpp . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamencoprologie_parasitairee']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function inserer_serologie_widal_felix_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_examen(idexamenpatient, idlaboratoire, interpretationresultatexamen, dateresultatexamen) "
                            . "values('" . $idep . "', '" . $reg["1"]["laboratoire"] . "', '" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowserologie_widal_felix = NULL;
        $reqnf = $con->query("select * from hp_serologie_widal_felix where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf == 0) {
            $con->query("insert into hp_serologie_widal_felix(idresultatexamen, idlaboratoire, toserologiewidalfelix, thserologiewidalfelix, "
                            . "aoserologiewidalfelix, ahserologiewidalfelix, boserologiewidalfelix, bhserologiewidalfelix, "
                    . "coserologiewidalfelix, chserologiewidalfelix, interpretationserologiewidalfelix) "
                            . "values('" . $rowre["idresultatexamen"] . "', '" . $reg["1"]["laboratoire"] . "', "
                            . "'" . addslashes($reg["1"]["swfto"]) . "', "
                            . "'" . addslashes($reg["1"]["swfth"]) . "', '" . addslashes($reg["1"]["swfao"]) . "', "
                            . "'" . addslashes($reg["1"]["swfah"]) . "', '" . addslashes($reg["1"]["swfbo"]) . "', "
                            . "'" . addslashes($reg["1"]["swfbh"]) . "', '" . addslashes($reg["1"]["swfco"]) . "', "
                            . "'" . addslashes($reg["1"]["swfch"]) . "', '" . addslashes($reg["1"]["interpretation"]) . "')") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_serologie_widal_felix where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowserologie_widal_felix = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_serologie_widal_felix set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationserologiewidalfelix='" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "toserologiewidalfelix='" . addslashes($reg["1"]["swfto"]) . "', thserologiewidalfelix='" . addslashes($reg["1"]["swfth"]) . "', "
                            . "aoserologiewidalfelix='" . addslashes($reg["1"]["swfao"]) . "', ahserologiewidalfelix='" . addslashes($reg["1"]["swfah"]) . "', "
                            . "boserologiewidalfelix='" . addslashes($reg["1"]["swfbo"]) . "', bhserologiewidalfelix='" . addslashes($reg["1"]["swfbh"]) . "', "
                            . "coserologiewidalfelix='" . addslashes($reg["1"]["swfco"]) . "', chserologiewidalfelix='" . addslashes($reg["1"]["swfch"]) . "' "
                            . " where idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_serologie_widal_felix where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowserologie_widal_felix = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "Examen ";
        if ($row["idhospitalisation"] != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/hopitalajouter/ajout_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamenserologie_widal_felix']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function update_serologie_widal_felix_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $ideswf = $reg["1"]["idserologiewidalfelix"];
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre != 0) {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationresultatexamen='" . addslashes($reg["1"]["interpretation"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $rowserologie_widal_felix = NULL;
        $reqnf = $con->query("select * from hp_serologie_widal_felix where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
        $nbnf = mysqli_num_rows($reqnf);
        if ($nbnf != 0) {
            $rowre2 = mysqli_fetch_array($reqnf);
            $con->query("update hp_serologie_widal_felix set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "interpretationserologiewidalfelix='" . addslashes($reg["1"]["interpretation"]) . "', "
                            . "toserologiewidalfelix='" . addslashes($reg["1"]["swfto"]) . "', thserologiewidalfelix='" . addslashes($reg["1"]["swfth"]) . "', "
                            . "aoserologiewidalfelix='" . addslashes($reg["1"]["swfao"]) . "', ahserologiewidalfelix='" . addslashes($reg["1"]["swfah"]) . "', "
                            . "boserologiewidalfelix='" . addslashes($reg["1"]["swfbo"]) . "', bhserologiewidalfelix='" . addslashes($reg["1"]["swfbh"]) . "', "
                            . "coserologiewidalfelix='" . addslashes($reg["1"]["swfco"]) . "', chserologiewidalfelix='" . addslashes($reg["1"]["swfch"]) . "' "
                            . " where idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_serologie_widal_felix where idresultatexamen='" . $rowre["idresultatexamen"] . "'") or die(mysqli_error($con));
            $rowserologie_widal_felix = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/hopitalediter/edit_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idserologiewidalfelix=' . $ideswf . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamenserologie_widal_felixe']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function inserer_autre_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_examen(idexamenpatient, idlaboratoire, conteneurresultatexamen, dateresultatexamen) "
                            . "values('" . $idep . "', '" . $reg["1"]["laboratoire"] . "', '" . addslashes($reg["1"]["resultat"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "conteneurresultatexamen='" . addslashes($reg["1"]["resultat"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        $op = "Examen ";
        if ($row["idhospitalisation"] != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $row["idhospitalisation"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $row["idhospitalisation"] . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $row["montantexamenpatient"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
        }

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalautre/hopitalajouter/ajout_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        } else {
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamenautre']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalautre/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}

function update_autre_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $eta = 1;
        $idere = $reg["1"]["idresultatexamen"];
        $idep = $reg["1"]["idexamenpatient"];

        $err = FALSE;
        $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
                . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req_fin);

        $rowre = NULL;
        $reqmc = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $nbre = mysqli_num_rows($reqmc);
        if ($nbre == 0) {
            $con->query("insert into hp_resultat_examen(idexamenpatient, idlaboratoire, conteneurresultatexamen, dateresultatexamen) "
                            . "values('" . $idep . "', '" . $reg["1"]["laboratoire"] . "', '" . addslashes($reg["1"]["resultat"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        } else {
            $rowre2 = mysqli_fetch_array($reqmc);
            $con->query("update hp_resultat_examen set idlaboratoire='" . $reg["1"]["laboratoire"] . "', "
                            . "conteneurresultatexamen='" . addslashes($reg["1"]["resultat"]) . "' where "
                            . "idresultatexamen='" . $rowre2["idresultatexamen"] . "'") or die(mysqli_error($con));
            $reqmc2 = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
            $rowre = mysqli_fetch_array($reqmc2);
        }

        $con->query("update hp_examen_patient set orientationexamenpatient='" . $reg["1"]["orientation"] . "', "
                        . "dateprelevementexamenpatient='" . $reg["1"]["prelevement"] . "', "
                        . "prescriptionexamenpatient='" . $reg["1"]["prescription"] . "', etatexamenpatient=1 where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalautre/hopitalediter/edit_examen';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idresultatexamen=' . $idere . '">');
        } else {
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamenautree']);
            $pagp = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalautre/lister_resultat';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamenpatient=' . $idep . '">');
        }
    }
}
