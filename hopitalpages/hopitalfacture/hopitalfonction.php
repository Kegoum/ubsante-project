<?php

function lister_facture($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

//    $rsltfnp = $con->query("select * from hp_facture as f where f.montantfacture<>f.avancefacture order by f.datefacture desc ") or die(mysqli_error($con));
    $rsltfnp = $con->query("select * from hp_facture as f where f.etatfacture=false order by f.datefacture desc ") or die(mysqli_error($con));
    $nbfnp = mysqli_num_rows($rsltfnp);
//    $rsltfp = $con->query("select * from hp_facture as f where f.montantfacture=f.avancefacture order by f.datefacture desc") or die(mysqli_error($con));
//    $nbfp = mysqli_num_rows($rsltfp);
    ?>

    <?php
    if (($nbfnp != 0)) {
        while ($recfnp = mysqli_fetch_assoc($rsltfnp)) {
            $lignecaisse = $recfnp["avancefacture"];
            $mont = $recfnp["montantfacture"];
            ?>

            <tr >
                <td></td>
                <td><?php print nl2br(htmlspecialchars($recfnp["codefacture"])) ?></td>
                <td>
                    <?php
                    $patien = "";
                    $but = "";
                    $idssdoc=NULL;
                    if ($recfnp["idconsultation"] != NULL) {
                        $rsltniv = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idconsultation='" . $recfnp["idconsultation"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Consultation : ");
                        $but = "Consultation";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeconsultation"]));
                        $rsltnivea = $con->query("select * from hp_acte as c where "
                                        . "c.idacte='" . $recniv["idacte"] . "'") or die(mysqli_error($con));
                                $rowpcone = mysqli_fetch_assoc($rsltnivea);
                                ?> 
                                <?php
                                print nl2br(htmlspecialchars($rowpcone["libelleacte"]));
                    } else if ($recfnp["idexamenpatient"] != NULL) {
                        $rsltniv = $con->query("select * from hp_examen_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idexamenpatient='" . $recfnp["idexamenpatient"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Examen : ");
                        $but = "Examen";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeexamenpatient"]));
                        $rsltnive = $con->query("select * from hp_examen as c where "
                                        . "c.idexamen='" . $recniv["idexamen"] . "'") or die(mysqli_error($con));
                                $rowpexae = mysqli_fetch_assoc($rsltnive);
                                ?> 
                                <?php
                                print nl2br(htmlspecialchars($rowpexae["nomexamen"]));
                    } else if ($recfnp["idechographiepatient"] != NULL) {
                        $rsltniv = $con->query("select * from hp_echographie_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idechographiepatient='" . $recfnp["idechographiepatient"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Echographie : ");
                        $but = "Echographie";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeechographiepatient"]));
                                $rsltnivec = $con->query("select * from hp_echographie as c where "
                                        . "c.idechographie='" . $recniv["idechographie"] . "'") or die(mysqli_error($con));
                                $rowpeche = mysqli_fetch_assoc($rsltnivec);
                                ?> 
                                <?php
                                print nl2br(htmlspecialchars($rowpeche["nomechographie"]));
                    } else if ($recfnp["idactepatient"] != NULL) {
                        $rsltniv = $con->query("select * from hp_acte_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idactepatient='" . $recfnp["idactepatient"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Autre : ");
                        $but = "Autre";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeactepatient"]));
                        $rsltnivea = $con->query("select * from hp_acte as c where "
                                        . "c.idacte='" . $recniv["idacte"] . "'") or die(mysqli_error($con));
                                $rowpcone = mysqli_fetch_assoc($rsltnivea);
                                ?> 
                                <?php
                                print nl2br(htmlspecialchars($rowpcone["libelleacte"]));
                    } else if ($recfnp["idordonnance"] != NULL) {
                        $rsltniv = $con->query("select * from hp_ordonnance as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idordonnance='" . $recfnp["idordonnance"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Ordonance : ");
                        $but = "Ordonance";
                        $idssdoc=$recniv["idsousdossier"];
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeordonnance"]));
                    } else if ($recfnp["idsoinpatient"] != NULL) {
                        $rsltniv = $con->query("select * from hp_soin_patient as c left join hp_hospitalisation as h on "
                                . "c.idhospitalisation=h.idhospitalisation left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                                . "c.idsoinpatient='" . $recfnp["idsoinpatient"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Soin : ");
                        $but = "SOin";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codesoinpatient"]));
                        $rsltnivea = $con->query("select * from hp_soin as c where "
                                        . "c.idsoin='" . $recniv["idsoin"] . "'") or die(mysqli_error($con));
                                $rowpcone = mysqli_fetch_assoc($rsltnivea);
                                ?> 
                                <?php
                                print nl2br(htmlspecialchars($rowpcone["libellesoin"]));
                    }
                    ?>
                </td>
                <td><?php print $patien; ?></td>
                <td><?php print number_format((nl2br(htmlspecialchars($recfnp["montantfacture"]))), 0, '.', ' ') ?></td>
                <td><?php
                    if ($recfnp["avancefacture"] != NULL) {
                        print number_format((nl2br(htmlspecialchars($recfnp["avancefacture"]))), 0, '.', ' ');
                    }
                    ?></td>
                <td><?php print number_format((nl2br(htmlspecialchars($recfnp["montantfacture"] - $recfnp["avancefacture"]))), 0, '.', ' ') ?></td>
                <td>
                    <?php
                    if ($recfnp["avancefacture"] == NULL) {
                        ?>
                        <span alt="non" class="label-danger label"><i class="label label-danger">Impay&eacute;e</i></span>
                        <?php
                    } else {
                        if ($recfnp["etatfacture"]) {
                            ?>
                            <span alt="oui" class="label-success label"><i class="label label-success">Pay&eacute;e</i></span>
                            <?php
                        } else {
                            ?>
                            <span alt="non" class="label-warning label"><i class="label label-warning">Avanc&eacute;e</i></span>
                            <?php
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Caisse")))) {
                        if ($recfnp["idsoinpatient"] != NULL) {
                            ?> 
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsoin/hopitalediter/edit_soin') ?>&idsoinpatient=<?php echo $recfnp["idsoinpatient"] ?>">
                                <span title="modifier ce soin" alt="edit"><i class="glyphicon glyphicon-edit"></i></span>
                            </a>&nbsp;&nbsp; 
                            <?php
                        }
                    }
                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                        if ($lignecaisse != $mont) {
                            if ($recfnp["idsoinpatient"] != NULL) {
                                ?>
                                    <!--                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalfacturesoin/paie_facture_patient') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                                <span title="Payer une facture de ce patient" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                                            </a>-->
                                <?php
                            } else if ($recfnp["idordonnance"] != NULL) {
                                if ($idssdoc != NULL) {
                                ?>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalfactureordonnance/paie_facture_patient') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                    <span title="Payer une facture de ce patient" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                                </a>
                                <?php
                                }  else {
                                     ?>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalfactureordonnancec/paie_facture_patient') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                    <span title="Payer une facture de ce patient" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                                </a>
                                <?php
                                }
                            } else {
                                ?>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalajouter/paie_facture_patient') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                    <span title="Payer une facture de ce patient" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                                </a>
                                <?php
                            }
                        } else {
                            if ($but == "Consultation") {
                                ?>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/ajout_parametre_patient') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                    <span title="ajouter les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-bookmark"></i></span>
                                </a>&nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/lister_parametre_patient') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                    <span title="lister les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-list-alt"></i></span>
                                </a>
                                <?php
                                ?>
                                &nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/lister_consultation') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                    <span title="afficher cette consultations" alt="list"><i class="glyphicon glyphicon-list"></i></span>
                                </a>
                                <?php
                            }
                        }
                        ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/lister_recu') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                            <span title="liste des re&ccedil;us de cette facture" alt="ajouter"><i class="glyphicon glyphicon-list-alt"></i></span>
                        </a>
                        <?php
                    } else {
                        if ($lignecaisse != $mont) {
                            if (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Caisse")) {
                                if ($recfnp["idsoinpatient"] != NULL) {
                                    ?>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalfacturesoinpatient/paie_facture_patient') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                        <span title="Payer une facture de ce patient" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                                    </a>
                                    <?php
                                } else if ($recfnp["idordonnance"] != NULL) {
                                    ?>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalfactureordonnance/paie_facture_patient') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                        <span title="Payer une facture de ce patient" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalajouter/paie_facture_patient') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                        <span title="Payer une facture de ce patient" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                                    </a>
                                    <?php
                                }
                            }
                        } else {
                            if ($but == "Consultation") {
                                if (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Accueil")) {
                                    ?>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/ajout_parametre_patient') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                        <span title="ajouter les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-bookmark"></i></span>
                                    </a>&nbsp;&nbsp;
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/lister_parametre_patient') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                        <span title="lister les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-list-alt"></i></span>
                                    </a>
                                    <?php
                                }
                                if (($_SESSION["rolepersonnel"] == "Médecin")) {
                                    ?>
                                    &nbsp;&nbsp;
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/lister_consultation') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                        <span title="afficher cette consultations" alt="list"><i class="glyphicon glyphicon-list"></i></span>
                                    </a>
                                    <?php
                                }
                            }
                        }
                        if (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Caisse")) {
                            ?>
                            &nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/lister_recu') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                <span title="liste des re&ccedil;us de cette facture" alt="ajouter"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    ?>
                </td>
            </tr>
            <?php
        }
    }
}

function lister_factureold($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

//    $rsltfnp = $con->query("select * from hp_facture as f where f.montantfacture<>f.avancefacture order by f.datefacture desc ") or die(mysqli_error($con));
    $rsltfnp = $con->query("select * from hp_facture as f order by f.datefacture desc ") or die(mysqli_error($con));
    $nbfnp = mysqli_num_rows($rsltfnp);
//    $rsltfp = $con->query("select * from hp_facture as f where f.montantfacture=f.avancefacture order by f.datefacture desc") or die(mysqli_error($con));
//    $nbfp = mysqli_num_rows($rsltfp);
    ?>

    <?php
    if (($nbfnp != 0)) {
        while ($recfnp = mysqli_fetch_assoc($rsltfnp)) {
            $lignecaisse = $recfnp["avancefacture"];
            $mont = $recfnp["montantfacture"];
            ?>

            <tr >
                <td></td>
                <td><?php print nl2br(htmlspecialchars($recfnp["codefacture"])) ?></td>
                <td>
                    <?php
                    $patien = "";
                    $but = "";
                    if ($recfnp["idconsultation"] != NULL) {
                        $rsltniv = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idconsultation='" . $recfnp["idconsultation"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Consultation : ");
                        $but = "Consultation";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeconsultation"]));
                    } else if ($recfnp["idexamenpatient"] != NULL) {
                        $rsltniv = $con->query("select * from hp_examen_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idexamenpatient='" . $recfnp["idexamenpatient"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Examen : ");
                        $but = "Examen";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeexamenpatient"]));
                    } else if ($recfnp["idechographiepatient"] != NULL) {
                        $rsltniv = $con->query("select * from hp_echographie_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idechographiepatient='" . $recfnp["idechographiepatient"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Echographie : ");
                        $but = "Echographie";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeechographiepatient"]));
                    } else if ($recfnp["idactepatient"] != NULL) {
                        $rsltniv = $con->query("select * from hp_acte_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idactepatient='" . $recfnp["idactepatient"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Autre : ");
                        $but = "Autre";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeactepatient"]));
                    } else if ($recfnp["idordonnance"] != NULL) {
                        $rsltniv = $con->query("select * from hp_ordonnance as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                                . "c.idordonnance='" . $recfnp["idordonnance"] . "'") or die(mysqli_error($con));
                        $recniv = mysqli_fetch_assoc($rsltniv);
                        $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
                        print ("Ordonance : ");
                        $but = "Ordonance";
                        ?> 
                        <?php
                        print nl2br(htmlspecialchars($recniv["codeordonnance"]));
                    }
                    ?>
                </td>
                <td><?php print $patien; ?></td>
                <td><?php print number_format((nl2br(htmlspecialchars($recfnp["montantfacture"]))), 0, '.', ' ') ?></td>
                <td><?php
                    if ($recfnp["avancefacture"] != NULL) {
                        print number_format((nl2br(htmlspecialchars($recfnp["avancefacture"]))), 0, '.', ' ');
                    }
                    ?></td>
                <td><?php print number_format((nl2br(htmlspecialchars($recfnp["montantfacture"] - $recfnp["avancefacture"]))), 0, '.', ' ') ?></td>
                <td>
                    <?php
                    if ($recfnp["avancefacture"] == NULL) {
                        ?>
                        <span alt="non" class="label-danger label"><i class="label label-danger">Impay&eacute;e</i></span>
                        <?php
                    } else {
                        if ($recfnp["etatfacture"]) {
                            ?>
                            <span alt="oui" class="label-success label"><i class="label label-success">Pay&eacute;e</i></span>
                            <?php
                        } else {
                            ?>
                            <span alt="non" class="label-warning label"><i class="label label-warning">Avanc&eacute;e</i></span>
                            <?php
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                        if ($lignecaisse != $mont) {
                            ?>
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalajouter/paie_facture_patient') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                <span title="Payer une facture de ce patient" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                        } else {
                            if ($but == "Consultation") {
                                ?>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/ajout_parametre_patient') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                    <span title="ajouter les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-bookmark"></i></span>
                                </a>&nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/lister_parametre_patient') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                    <span title="lister les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-list-alt"></i></span>
                                </a>
                                <?php
                                ?>
                                &nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/lister_consultation') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                    <span title="afficher cette consultations" alt="list"><i class="glyphicon glyphicon-list"></i></span>
                                </a>
                                <?php
                            }
                        }
                        ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/lister_recu') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                            <span title="liste des re&ccedil;us de cette facture" alt="ajouter"><i class="glyphicon glyphicon-list-alt"></i></span>
                        </a>
                        <?php
                    } else {
                        if ($lignecaisse != $mont) {
                            if (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Caisse")) {
                                ?>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalajouter/paie_facture_patient') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                    <span title="Payer une facture de ce patient" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                                </a>
                                <?php
                            }
                        } else {
                            if ($but == "Consultation") {
                                if (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Accueil")) {
                                    ?>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/ajout_parametre_patient') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                        <span title="ajouter les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-bookmark"></i></span>
                                    </a>&nbsp;&nbsp;
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/lister_parametre_patient') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                        <span title="lister les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-list-alt"></i></span>
                                    </a>
                                    <?php
                                }
                                if (($_SESSION["rolepersonnel"] == "Médecin")) {
                                    ?>
                                    &nbsp;&nbsp;
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/lister_consultation') ?>&idconsultation=<?php echo $recfnp["idconsultation"] ?>">
                                        <span title="afficher cette consultations" alt="list"><i class="glyphicon glyphicon-list"></i></span>
                                    </a>
                                    <?php
                                }
                            }
                        }
                        if (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Caisse")) {
                            ?>
                            &nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/lister_recu') ?>&idfacture=<?php echo $recfnp["idfacture"] ?>">
                                <span title="liste des re&ccedil;us de cette facture" alt="ajouter"><i class="glyphicon glyphicon-list-alt"></i></span>
                            </a>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    ?>
                </td>
            </tr>
            <?php
        }
    }
}

function lister_recu($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $rsltfnp = $con->query("select * from hp_ligne_caisse as lc left join hp_facture as f on lc.idfacture=f.idfacture "
            . "where lc.idfacture='" . $id . "' order by lc.datelignecaisse desc ") or die(mysqli_error($con));
    $nbfnp = mysqli_num_rows($rsltfnp);
    ?>

    <?php
    if (($nbfnp != 0)) {
        while ($recfnp = mysqli_fetch_assoc($rsltfnp)) {
            $rsltfnpc = $con->query("select * from hp_caisse where idcaisse='" . $recfnp["idcaisse"] . "' ") or die(mysqli_error($con));
            $recfnpc = mysqli_fetch_assoc($rsltfnpc);
            $rsltfnpmp = $con->query("select * from hp_mode_paiement where idmodepaiement='" . $recfnp["idmodepaiement"] . "' ") or die(mysqli_error($con));
            $recfnpmp = mysqli_fetch_assoc($rsltfnpmp);
            ?>

            <tr >
                <td></td>
                <td><?php print nl2br(htmlspecialchars($recfnp["codelignecaisse"])) ?></td>
                <td><?php print number_format((nl2br(htmlspecialchars($recfnp["montantlignecaisse"]))), 0, '.', ' ') ?></td>
                <td><?php print nl2br(htmlspecialchars($recfnpc["nomcaisse"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recfnp["datejourlignecaisse"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recfnpmp["libellemodepaiement"])) ?></td>
                <td>
                    <?php
                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                        ?>
                        &nbsp;&nbsp;
                        <a href="hopitalpages/hopitalfacture/facture_patient_pdf.php?idlignecaisse=<?php echo $recfnp["idlignecaisse"] ?>" target="_blank">
                            <span title="Imprimer le Re&ccedil;u de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> </span>
                        </a>
                        <?php
                    } else {
                        if (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Caisse")) {
                            ?>
                            &nbsp;&nbsp;
                            <a href="hopitalpages/hopitalfacture/facture_patient_pdf.php?idlignecaisse=<?php echo $recfnp["idlignecaisse"] ?>" target="_blank">
                                <span title="Imprimer le Re&ccedil;u de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> </span>
                            </a>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    ?>
                </td>
            </tr>
            <?php
        }
    }
}

//fonction pour ajouter un facture
function inserer_facture_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $date = date('Y-m-d');
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');
        $but = "Facture";
        $ope = "Encaissement";
        $reqel = $con->query("select * from hp_facture where idfacture='" . $reg["1"]["idfacture"] . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($reqel);
        $iddoc = NULL;
        $patien = "";
        $idhosp = NULL;
        if ($row["idconsultation"] != NULL) {
            $rsltniv = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idconsultation='" . $row["idconsultation"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["idpatient"];
            $iddoc = $recniv["iddossier"];
        } else if ($row["idexamenpatient"] != NULL) {
            $rsltniv = $con->query("select * from hp_examen_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idexamenpatient='" . $row["idexamenpatient"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["idpatient"];
            $iddoc = $recniv["iddossier"];
            $idhosp = $recniv["idhospitalisation"];
        } else if ($row["idechographiepatient"] != NULL) {
            $rsltniv = $con->query("select * from hp_echographie_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idechographiepatient='" . $row["idechographiepatient"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["idpatient"];
            $iddoc = $recniv["iddossier"];
            $idhosp = $recniv["idhospitalisation"];
        } else if ($row["idactepatient"] != NULL) {
            $rsltniv = $con->query("select * from hp_acte_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idactepatient='" . $row["idactepatient"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["idpatient"];
            $iddoc = $recniv["iddossier"];
            $idhosp = $recniv["idhospitalisation"];
        } else if ($row["idordonnance"] != NULL) {
            $rsltniv = $con->query("select * from hp_ordonnance as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["idpatient"];
            $iddoc = $recniv["iddossier"];
            $idhosp = $recniv["idhospitalisation"];
        } else if ($row["idsoinpatient"] != NULL) {
            $rsltniv = $con->query("select * from hp_soin_patient as c left join hp_hospitalisation as h on "
                    . "c.idhospitalisation=h.idhospitalisation left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                    . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                    . "c.idsoinpatient='" . $row["idsoinpatient"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["idpatient"];
            $iddoc = $recniv["iddossier"];
            $idhosp = $recniv["idhospitalisation"];
        }


        $mnt = $row["avancefacture"] + $reg["1"]["montvers"];
        $paye = 0;
        if ($mnt >= $reg["1"]["montt"]) {
            $paye = 1;
        }

        if (($mnt) <= $reg["1"]["montt"]) {
            $req = $con->query("select * from hp_ligne_caisse as e where DAY(e.datelignecaisse)='" . $jou . "' "
                    . "and MONTH(e.datelignecaisse)='" . $moi . "' and YEAR(e.datelignecaisse)='" . $an . "'") or die(mysqli_error($con));
            $i = mysqli_num_rows($req);
            $numid = "FA" . $jou . $moi . $sand . sprintf("%05d", ($i + 1));

//                    echo "<script language='javascript'>alert($idtrfi)</script>";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_ligne_caisse(idfacture, idmodepaiement, codelignecaisse, butlignecaisse, operationlignecaisse, "
                                . "datejourlignecaisse, montantlignecaisse, datelignecaisse) values('" . $reg["1"]["idfacture"] . "', "
                                . "'" . $reg["1"]["paiement"] . "', '" . $numid . "','" . $but . "','" . $ope . "', '" . $reg["1"]["datejour"] . "', "
                                . "'" . $reg["1"]['montvers'] . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_ligne_caisse(idcomptepersonnel, idfacture, idcaisse, idmodepaiement, codelignecaisse, butlignecaisse, "
                                . "operationlignecaisse, datejourlignecaisse, montantlignecaisse, datelignecaisse) values('" . $_SESSION["idcomptepersonnel"] . "', "
                                . "'" . $reg["1"]["idfacture"] . "','" . $_SESSION["idcaisse"] . "','" . $reg["1"]["paiement"] . "', '" . $numid . "', "
                                . "'" . $but . "','" . $ope . "','" . $reg["1"]["datejour"] . "', '" . $reg["1"]['montvers'] . "', NOW())") or die(mysqli_error($con));
            }
            $reqcode = $con->query("select * from hp_ligne_caisse as v where v.codelignecaisse='" . $numid . "'") or die(mysqli_error($con));
            $rowcod = mysqli_fetch_assoc($reqcode);

            $con->query("update hp_facture set avancefacture='" . $mnt . "', etatfacture='" . $paye . "' where "
                            . "idfacture='" . $reg["1"]["idfacture"] . "'") or die(mysqli_error($con));
            $opr = "Caisse ";
            if ($idhosp != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $idhosp . "', '" . $reg["1"]['montvers'] . "', '" . $opr . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $idhosp . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $reg["1"]['montvers'] . "', '" . $opr . "', NOW())") or die(mysqli_error($con));
                }
            }
            if ($paye) {

                if ($row["idconsultation"] != NULL) {
                    $lieu = "Accueil";
                    $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $iddoc . "'") or die(mysqli_error($con));
                } else if ($row["idexamenpatient"] != NULL) {
                    $rsltniv = $con->query("select * from hp_examen_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                            . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                            . "c.idexamenpatient='" . $row["idexamenpatient"] . "'") or die(mysqli_error($con));
                    $recniv = mysqli_fetch_assoc($rsltniv);

                    $lieu = "Laboratoire";
                    $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $iddoc . "'") or die(mysqli_error($con));
                } else if ($row["idechographiepatient"] != NULL) {
                    $lieu = "Echographie";
                    $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $iddoc . "'") or die(mysqli_error($con));
                } else if ($row["idactepatient"] != NULL) {
                    $lieu = "Autre";
                    $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $iddoc . "'") or die(mysqli_error($con));
                } else if ($row["idordonnance"] != NULL) {

                    $paye2 = "Payée";
                    $etat2 = "En Cours";
                    $reqlo = $con->query("select * from hp_ligne_ordonnance as v where v.idordonnance='" . $row["idordonnance"] . "' "
                            . "and v.etatligneordonnance='" . $etat2 . "'") or die(mysqli_error($con));
                    while ($rowlo = mysqli_fetch_assoc($reqlo)) {
                        $con->query("update hp_ligne_ordonnance set etatligneordonnance='" . $paye2 . "' where "
                                        . "idligneordonnance='" . $rowlo["idligneordonnance"] . "'") or die(mysqli_error($con));
                    }
                    $con->query("update hp_ordonnance set etatordonnance='" . $paye2 . "' where "
                                    . "idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
                    $lieu = "Pharmacie";
                    $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $iddoc . "'") or die(mysqli_error($con));
                } else if ($row["idsoinpatient"] != NULL) {

                    $paye2 = 0;
                    $etat2 = "En Cours";
                    $reqlo = $con->query("select * from hp_ligne_soin_patient as v where v.idsoinpatient='" . $row["idsoinpatient"] . "' "
                            . "and v.etatlignesoinpatient='" . $etat2 . "'") or die(mysqli_error($con));
                    while ($rowlo = mysqli_fetch_assoc($reqlo)) {
                        $con->query("update hp_ligne_soin_patient set etatlignesoinpatient='" . $paye2 . "' where "
                                        . "idlignesoinpatient='" . $rowlo["idlignesoinpatient"] . "'") or die(mysqli_error($con));
                    }
                    $con->query("update hp_soin_patient set etatsoinpatient='" . $paye2 . "' where "
                                    . "idsoinpatient='" . $row["idsoinpatient"] . "'") or die(mysqli_error($con));
                    $lieu = "Pharmacie";
                    $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $iddoc . "'") or die(mysqli_error($con));
                }
            }
            $op = "Ajout";
            $ob = "Facture : " . $rowcod["codelignecaisse"] . " -> " . $rowcod["montantlignecaisse"];
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idpatient, operation, objet, datetrace) values('" . $patien . "', "
                                . "'" . $op . "', '" . $ob . "',NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idpatient, idcomptepersonnel, operation, objet, datetrace) "
                                . "values('" . $patien . "', '" . $_SESSION["idcomptepersonnel"] . "', '" . $op . "', "
                                . "'" . $ob . "',NOW())") or die(mysqli_error($con));
            }
            unset($_SESSION['formfacture']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            ?>

            <a href="hopitalpages/hopitalfacture/facture_patient_pdf.php?idlignecaisse=<?php echo $rowcod["idlignecaisse"] ?>" class="btn btn-lg btn-success" target="_blank">
                <span title="Imprimer le Re&ccedil;u de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le Re&ccedil;u</span>
            </a>
            <?php
        }
    }
}

//fonction pour ajouter un facture
function inserer_facture_ordonnance_patient($id, $montvers, $montt, $paiement, $datejour, $reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (isset($reg) && ($reg != NULL)) {
        $date = date('Y-m-d');
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');
        $but = "Facture";
        $ope = "Encaissement";
        $reqel = $con->query("select * from hp_facture where idfacture='" . $id . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($reqel);

        $rsltniv = $con->query("select * from hp_ordonnance as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                . "c.idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
        $recniv = mysqli_fetch_assoc($rsltniv);
        $patien = $recniv["idpatient"];
        $iddoc = $recniv["iddossier"];
        $idhosp = $recniv["idhospitalisation"];

        $mnt = $row["avancefacture"] + $montvers;
        $paye = 0;
        if ($mnt >= $montt) {
            $paye = 1;
        }

        if (($mnt) <= $montt) {
            $req = $con->query("select * from hp_ligne_caisse as e where DAY(e.datelignecaisse)='" . $jou . "' "
                    . "and MONTH(e.datelignecaisse)='" . $moi . "' and YEAR(e.datelignecaisse)='" . $an . "'") or die(mysqli_error($con));
            $i = mysqli_num_rows($req);
            $numid = "FA" . $jou . $moi . $sand . sprintf("%05d", ($i + 1));

//                    echo "<script language='javascript'>alert($idtrfi)</script>";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_ligne_caisse(idfacture, idmodepaiement, codelignecaisse, butlignecaisse, operationlignecaisse, "
                                . "datejourlignecaisse, montantlignecaisse, datelignecaisse) values('" . $id . "', "
                                . "'" . $paiement . "', '" . $numid . "','" . $but . "','" . $ope . "', '" . $datejour . "', "
                                . "'" . $montvers . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_ligne_caisse(idcomptepersonnel, idfacture, idcaisse, idmodepaiement, codelignecaisse, butlignecaisse, "
                                . "operationlignecaisse, datejourlignecaisse, montantlignecaisse, datelignecaisse) values('" . $_SESSION["idcomptepersonnel"] . "', "
                                . "'" . $id . "','" . $_SESSION["idcaisse"] . "','" . $paiement . "', '" . $numid . "', "
                                . "'" . $but . "','" . $ope . "','" . $datejour . "', '" . $montvers . "', NOW())") or die(mysqli_error($con));
            }
            
//echo "<script language='javascript'>alert('oookkkkoo')</script>";
            $reqcode = $con->query("select * from hp_ligne_caisse as v where v.codelignecaisse='" . $numid . "'") or die(mysqli_error($con));
            $rowcod = mysqli_fetch_assoc($reqcode);

            $con->query("update hp_facture set avancefacture='" . $mnt . "', etatfacture='" . $paye . "' where "
                            . "idfacture='" . $id . "'") or die(mysqli_error($con));
            foreach ($_SESSION["cart_prodvfactordo" . $id] as $prod) {
                $reqar = $con->query("select * from hp_ligne_ordonnance as lo left join hp_produit as p on lo.idproduit=p.idproduit "
                        . "where lo.idligneordonnance='" . $prod["idart"] . "'") or die(mysqli_error($con));

                $rowar = mysqli_fetch_assoc($reqar);
                $con->query("insert into hp_paie_ordonnance(idligneordonnance, idunite, idlignecaisse, stockpaieordonnance, "
                                . "prixpaieordonnance, datepaieordonnance) values('" . $prod["idart"] . "', "
                                . "'" . $prod["uniteart"] . "', '" . $rowcod["idlignecaisse"] . "', '" . $prod["qteart"] . "', "
                                . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));

                $slivre = $rowar["stockpaieligneordonnance"];
                if ($prod["uniteart"] != $rowar["idunite"]) {
                    $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowar["idunite"] . "' and "
                            . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                    $rowvv = mysqli_fetch_assoc($rsltuv2);
                    $rsltuv2b = $con->query("select * from hp_conversion where idunite='" . $prod["uniteart"] . "' and "
                            . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                    $rowvvb = mysqli_fetch_assoc($rsltuv2b);
                    if ($rowvvb["conversion"] != 0) {
                        $slivre = $rowar["stockpaieligneordonnance"] + (($prod["qteart"]) * ($rowvv["conversion"]) / $rowvvb["conversion"]);
                    }
                } else {
                    $slivre = $rowar["stockpaieligneordonnance"] + $prod["qteart"];
                }
                $etat3 = "En Cours";
                if ($slivre >= $rowar["stockligneordonnance"]) {
                    $etat3 = "Payée";
                }
//            if ($prod["stockok"]) {
                $rslt = $con->query("update hp_ligne_ordonnance set stockpaieligneordonnance='" . $slivre . "', "
                        . "etatligneordonnance='" . $etat3 . "' "
                        . "where idligneordonnance='" . $prod["idart"] . "'") or die(mysqli_error($con));
//            } else {
//                $rslt = $con->query("update hp_ligne_ordonnance set stockpaieligneordonnance='" . $slivre . "' "
//                        . "where idligneordonnance='" . $prod["idart"] . "'") or die(mysqli_error($con));
//            }
                $obj = "paie ordonnance " . $id . "-" . $prod["qteart"] . "-" . addslashes($prod["designationart"]);
                $op = "Paie Ordonnance";
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltvente = $con->query("insert into hp_trace(idproduit, objet, operation, "
                            . "datetrace) values('" . $rowar["idproduit"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltvente = $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, "
                            . "datetrace) values('" . $rowar["idproduit"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }



            $opr = "Caisse ";
            if ($idhosp != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $idhosp . "', '" . $montvers . "', '" . $opr . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $idhosp . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $montvers . "', '" . $opr . "', NOW())") or die(mysqli_error($con));
                }
            }
            if ($paye) {
                $paye2 = "Payée";
                $con->query("update hp_ordonnance set etatordonnance='" . $paye2 . "' where "
                                . "idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
                if($recniv["idpatient"]!=NULL){
                $lieu = "Pharmacie";
                $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $iddoc . "'") or die(mysqli_error($con));
            
                }
                }
            $op = "Ajout";
            $ob = "Facture : " . $rowcod["codelignecaisse"] . " -> " . $rowcod["montantlignecaisse"];
            if($recniv["idpatient"]!=NULL){
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idpatient, operation, objet, datetrace) values('" . $patien . "', "
                                . "'" . $op . "', '" . $ob . "',NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idpatient, idcomptepersonnel, operation, objet, datetrace) "
                                . "values('" . $patien . "', '" . $_SESSION["idcomptepersonnel"] . "', '" . $op . "', "
                                . "'" . $ob . "',NOW())") or die(mysqli_error($con));
            }
            }  else {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(operation, objet, datetrace) values("
                                . "'" . $op . "', '" . $ob . "',NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idcomptepersonnel, operation, objet, datetrace) "
                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $op . "', "
                                . "'" . $ob . "',NOW())") or die(mysqli_error($con));
            }
            }
            unset($_SESSION["cart_prodvfactordo" . $id]);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            ?>

            <a href="hopitalpages/hopitalfacture/facture_patient_pdf.php?idlignecaisse=<?php echo $rowcod["idlignecaisse"] ?>" class="btn btn-lg btn-success" target="_blank">
                <span title="Imprimer le Re&ccedil;u de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le Re&ccedil;u</span>
            </a>
            <?php
        }
    
    }
}

//fonction pour ajouter un facture
function inserer_facture_soin_patient($id, $montvers, $montt, $paiement, $datejour, $reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (isset($reg) && ($reg != NULL)) {
        $date = date('Y-m-d');
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');
        $but = "Facture";
        $ope = "Encaissement";
        $reqel = $con->query("select * from hp_facture where idfacture='" . $id . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($reqel);

        $rsltniv = $con->query("select * from hp_soin_patient as c left join hp_hospitalisation as h on "
                . "c.idhospitalisation=h.idhospitalisation "
                . "left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                . "c.idsoinpatient='" . $row["idsoinpatient"] . "'") or die(mysqli_error($con));
        $recniv = mysqli_fetch_assoc($rsltniv);
        $patien = $recniv["idpatient"];
        $iddoc = $recniv["iddossier"];
        $idhosp = $recniv["idhospitalisation"];


        $mnt = $row["avancefacture"] + $montvers;
        $paye = 0;
        if ($mnt >= $montt) {
            $paye = 1;
        }

        if (($mnt) <= $montt) {
            $req = $con->query("select * from hp_ligne_caisse as e where DAY(e.datelignecaisse)='" . $jou . "' "
                    . "and MONTH(e.datelignecaisse)='" . $moi . "' and YEAR(e.datelignecaisse)='" . $an . "'") or die(mysqli_error($con));
            $i = mysqli_num_rows($req);
            $numid = "FA" . $jou . $moi . $sand . sprintf("%05d", ($i + 1));

//                    echo "<script language='javascript'>alert($idtrfi)</script>";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_ligne_caisse(idfacture, idmodepaiement, codelignecaisse, butlignecaisse, operationlignecaisse, "
                                . "datejourlignecaisse, montantlignecaisse, datelignecaisse) values('" . $id . "', "
                                . "'" . $paiement . "', '" . $numid . "','" . $but . "','" . $ope . "', '" . $datejour . "', "
                                . "'" . $montvers . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_ligne_caisse(idcomptepersonnel, idfacture, idcaisse, idmodepaiement, codelignecaisse, butlignecaisse, "
                                . "operationlignecaisse, datejourlignecaisse, montantlignecaisse, datelignecaisse) values('" . $_SESSION["idcomptepersonnel"] . "', "
                                . "'" . $id . "','" . $_SESSION["idcaisse"] . "','" . $paiement . "', '" . $numid . "', "
                                . "'" . $but . "','" . $ope . "','" . $datejour . "', '" . $montvers . "', NOW())") or die(mysqli_error($con));
            }
            $reqcode = $con->query("select * from hp_ligne_caisse as v where v.codelignecaisse='" . $numid . "'") or die(mysqli_error($con));
            $rowcod = mysqli_fetch_assoc($reqcode);

            $con->query("update hp_facture set avancefacture='" . $mnt . "', etatfacture='" . $paye . "' where "
                            . "idfacture='" . $id . "'") or die(mysqli_error($con));
            foreach ($_SESSION["cart_prodvfactsopa" . $id] as $prod) {
                $reqar = $con->query("select * from hp_ligne_soin_patient as lo left join hp_produit as p on lo.idproduit=p.idproduit "
                        . "where lo.idlignesoinpatient='" . $prod["idart"] . "'") or die(mysqli_error($con));

                $rowar = mysqli_fetch_assoc($reqar);
                $con->query("insert into hp_paie_soin_patient(idlignesoinpatient, idunite, idlignecaisse, quantitepaiesoinpatient, "
                                . "prixpaiesoinpatient, datepaiesoinpatient) values('" . $prod["idart"] . "', "
                                . "'" . $prod["uniteart"] . "', '" . $rowcod["idlignecaisse"] . "', '" . $prod["qteart"] . "', "
                                . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));

                $slivre = $rowar["quantitepaielignesoinpatient"];
                if ($prod["uniteart"] != $rowar["idunitesoinpatient"]) {
                    $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowar["idunitesoinpatient"] . "' and "
                            . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                    $rowvv = mysqli_fetch_assoc($rsltuv2);
                    $rsltuv2b = $con->query("select * from hp_conversion where idunite='" . $prod["uniteart"] . "' and "
                            . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                    $rowvvb = mysqli_fetch_assoc($rsltuv2b);
                    if ($rowvvb["conversion"] != 0) {
                        $slivre = $rowar["quantitepaielignesoinpatient"] + (($prod["qteart"]) * ($rowvv["conversion"]) / $rowvvb["conversion"]);
                    }
                } else {
                    $slivre = $rowar["quantitepaielignesoinpatient"] + $prod["qteart"];
                }
                $etat3 = "En Cours";
                if ($slivre >= $rowar["quantitelignesoinpatient"]) {
                    $etat3 = "Payée";
                }
//            if ($prod["quantiteok"]) {
                $rslt = $con->query("update hp_ligne_soin_patient set quantitepaielignesoinpatient='" . $slivre . "', "
                        . "etatlignesoinpatient='" . $etat3 . "' "
                        . "where idlignesoinpatient='" . $prod["idart"] . "'") or die(mysqli_error($con));
//            } else {
//                $rslt = $con->query("update hp_ligne_soin_patient set quantitepaielignesoinpatient='" . $slivre . "' "
//                        . "where idlignesoinpatient='" . $prod["idart"] . "'") or die(mysqli_error($con));
//            }
                $obj = "paie soin patient " . $id . "-" . $prod["qteart"] . "-" . addslashes($prod["designationart"]);
                $op = "Paie Soin patient";
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltvente = $con->query("insert into hp_trace(idproduit, objet, operation, "
                            . "datetrace) values('" . $rowar["idproduit"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltvente = $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, "
                            . "datetrace) values('" . $rowar["idproduit"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }



            $opr = "Caisse ";
            if ($idhosp != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $idhosp . "', '" . $montvers . "', '" . $opr . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $idhosp . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $montvers . "', '" . $opr . "', NOW())") or die(mysqli_error($con));
                }
            }
            if ($paye) {
                $paye2 = "0";
                $con->query("update hp_soin_patient set etatsoinpatient='" . $paye2 . "' where "
                                . "idsoinpatient='" . $row["idsoinpatient"] . "'") or die(mysqli_error($con));
                $lieu = "Pharmacie";
                $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $iddoc . "'") or die(mysqli_error($con));
            }
            $op = "Ajout";
            $ob = "Facture : " . $rowcod["codelignecaisse"] . " -> " . $rowcod["montantlignecaisse"];
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idpatient, operation, objet, datetrace) values('" . $patien . "', "
                                . "'" . $op . "', '" . $ob . "',NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idpatient, idcomptepersonnel, operation, objet, datetrace) "
                                . "values('" . $patien . "', '" . $_SESSION["idcomptepersonnel"] . "', '" . $op . "', "
                                . "'" . $ob . "',NOW())") or die(mysqli_error($con));
            }
            unset($_SESSION["cart_prodvfactsopa" . $id]);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            ?>

            <a href="hopitalpages/hopitalfacture/facture_patient_pdf.php?idlignecaisse=<?php echo $rowcod["idlignecaisse"] ?>" class="btn btn-lg btn-success" target="_blank">
                <span title="Imprimer le Re&ccedil;u de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le Re&ccedil;u</span>
            </a>
            <?php
        }
    }elseif (isset($montvers) && ($montvers != NULL) && ($montvers != "")) {
        $date = date('Y-m-d');
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');
        $but = "Facture";
        $ope = "Encaissement";
        $reqel = $con->query("select * from hp_facture where idfacture='" . $id . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($reqel);

        $rsltniv = $con->query("select * from hp_soin_patient as c left join hp_hospitalisation as h on "
                . "c.idhospitalisation=h.idhospitalisation "
                . "left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                . "c.idsoinpatient='" . $row["idsoinpatient"] . "'") or die(mysqli_error($con));
        $recniv = mysqli_fetch_assoc($rsltniv);
        $patien = $recniv["idpatient"];
        $iddoc = $recniv["iddossier"];
        $idhosp = $recniv["idhospitalisation"];


        $mnt = $row["avancefacture"] + $montvers;
        $paye = 0;
        if ($mnt >= $montt) {
            $paye = 1;
        }

        if (($mnt) <= $montt) {
            $req = $con->query("select * from hp_ligne_caisse as e where DAY(e.datelignecaisse)='" . $jou . "' "
                    . "and MONTH(e.datelignecaisse)='" . $moi . "' and YEAR(e.datelignecaisse)='" . $an . "'") or die(mysqli_error($con));
            $i = mysqli_num_rows($req);
            $numid = "FA" . $jou . $moi . $sand . sprintf("%05d", ($i + 1));

//                    echo "<script language='javascript'>alert($idtrfi)</script>";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_ligne_caisse(idfacture, idmodepaiement, codelignecaisse, butlignecaisse, operationlignecaisse, "
                                . "datejourlignecaisse, montantlignecaisse, datelignecaisse) values('" . $id . "', "
                                . "'" . $paiement . "', '" . $numid . "','" . $but . "','" . $ope . "', '" . $datejour . "', "
                                . "'" . $montvers . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_ligne_caisse(idcomptepersonnel, idfacture, idcaisse, idmodepaiement, codelignecaisse, butlignecaisse, "
                                . "operationlignecaisse, datejourlignecaisse, montantlignecaisse, datelignecaisse) values('" . $_SESSION["idcomptepersonnel"] . "', "
                                . "'" . $id . "','" . $_SESSION["idcaisse"] . "','" . $paiement . "', '" . $numid . "', "
                                . "'" . $but . "','" . $ope . "','" . $datejour . "', '" . $montvers . "', NOW())") or die(mysqli_error($con));
            }
            $reqcode = $con->query("select * from hp_ligne_caisse as v where v.codelignecaisse='" . $numid . "'") or die(mysqli_error($con));
            $rowcod = mysqli_fetch_assoc($reqcode);

            $con->query("update hp_facture set avancefacture='" . $mnt . "', etatfacture='" . $paye . "' where "
                            . "idfacture='" . $id . "'") or die(mysqli_error($con));
            
            $opr = "Caisse ";
            if ($idhosp != NULL) {
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, montantregistrepatient, operationregistrepatient, "
                            . "dateregistrepatient) values('" . $idhosp . "', '" . $montvers . "', '" . $opr . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    $rsltreg = $con->query("insert into hp_registre_patient(idhospitalisation, idcomptepersonnel, montantregistrepatient, "
                            . "operationregistrepatient, dateregistrepatient) values('" . $idhosp . "', "
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $montvers . "', '" . $opr . "', NOW())") or die(mysqli_error($con));
                }
            }
            if ($paye) {
                $paye2 = "0";
                $con->query("update hp_soin_patient set etatsoinpatient='" . $paye2 . "' where "
                                . "idsoinpatient='" . $row["idsoinpatient"] . "'") or die(mysqli_error($con));
                $lieu = "Pharmacie";
                $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $iddoc . "'") or die(mysqli_error($con));
            }
            $op = "Ajout";
            $ob = "Facture : " . $rowcod["codelignecaisse"] . " -> " . $rowcod["montantlignecaisse"];
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idpatient, operation, objet, datetrace) values('" . $patien . "', "
                                . "'" . $op . "', '" . $ob . "',NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idpatient, idcomptepersonnel, operation, objet, datetrace) "
                                . "values('" . $patien . "', '" . $_SESSION["idcomptepersonnel"] . "', '" . $op . "', "
                                . "'" . $ob . "',NOW())") or die(mysqli_error($con));
            }
            $montvers="";
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            ?>

            <a href="hopitalpages/hopitalfacture/facture_patient_pdf.php?idlignecaisse=<?php echo $rowcod["idlignecaisse"] ?>" class="btn btn-lg btn-success" target="_blank">
                <span title="Imprimer le Re&ccedil;u de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le Re&ccedil;u</span>
            </a>
            <?php
        }
    }
}

function list_recupatient($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $date = date('Y-m-d');
    $reqa = $con->query("select * from hp_annee where libellean<='" . $date . "' and libellean2>='" . $date . "'") or die(mysqli_error($con));
    $rowa = mysqli_fetch_assoc($reqa);

    if ($rowa != NULL) {
        $rsltf = $con->query('select * from hp_ligne_caisse as v left join hp_facture as f on v.idfacture=f.idfacture '
                . 'left join hp_patient as e on e.idpatient=f.idpatient left join hp_niveauspecialite as c on '
                . 'c.idniveauspecialite=f.idniveauspecialite left join hp_specialite as sp on '
                . 'c.idspecialite=sp.idspecialite left join hp_filiere as s on sp.idfiliere=s.idfiliere left join '
                . 'hp_cycle as cy on s.idcycle=cy.idcycle where f.idannee=' . $rowa["idannee"] . ' and '
                . 'e.idpatient=' . $id . ' and f.statutfacture=true ') or die(mysqli_error($con));
        $nbf = mysqli_num_rows($rsltf);


        if ($nbf != 0) {
            while ($recf = mysqli_fetch_assoc($rsltf)) {
                $reqmp = $con->query("select * from hp_modepaiement as mp left join hp_banque as b on mp.idbanque=b.idbanque "
                        . "left join hp_campus as c on mp.idcampus=c.idcampus where mp.idmodepaiement='" . $recf["idmodepaiement"] . "'") or die(mysqli_error($con));
                $rowmp = mysqli_fetch_assoc($reqmp);
                ?>

                <tr >
                    <td><?php print nl2br(htmlspecialchars($recf["codelignecaisse"])) ?></td>
                    <td><?php print number_format((nl2br(htmlspecialchars($recf["montantlignecaisse"]))), 0, '.', ' '); ?></td>
                    <td><?php echo $rowmp["libellemodepaiement"]; ?> - <?php echo $rowmp["libellebanque"]; ?> - <?php echo $rowmp["libellecampus"]; ?></td>
                    <td><?php print nl2br(htmlspecialchars($recf["butlignecaisse"])) ?></td>
                    <td><?php print nl2br(htmlspecialchars($recf["datejourlignecaisse"])) ?></td>
                    <td>
                        <a href="hopitalpages/hopitalpatient/hopitalfacture/facture_patient_f_pdf.php?idlignecaisse=<?php echo $recf["idlignecaisse"] ?>" target="_blank">
                            <span title="Imprimer le Re&ccedil;u de l'patient" alt="editer"><i class="glyphicon glyphicon-file"></i> </span>
                        </a>
                    </td>
                </tr>  
                <?php
            }
        } else {
            ?>
            <!--<h3>Frais de scolarit&eacute;</h3>-->
            <?php
            if ((isset($_SESSION["hopitalrole"])) && ((($_SESSION["hopitalrole"] == "Super Administrateur") || ($_SESSION["hopitalrole"] == "Administrateur")) || ($_SESSION["hopitalrole"] == "Comptable"))) {
                ?>
                                                                                                                                        <!--                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalajouterold/inscrire_patient') ?>&patient=<?php echo $id ?>" class="btn btn-lg btn-success">
                                                                                                                                                <span title="Ajouter les factures de cet &Eacute;tudiant" alt="facture"><i class="glyphicon glyphicon-pencil"></i>Ajouter les factures</span>
                                                                                                                                            </a>-->
                <?php
            }
            ?>
            <?php
        }

        $rsltres = $con->query('select * from hp_reculoyer as v left join hp_loyer as f on v.idloyer=f.idloyer '
                . 'left join hp_chambrefacture as ffe on f.idchambrefacture=ffe.idchambrefacture left join '
                . 'hp_facture as fe on ffe.idfacture=fe.idfacture where fe.idannee=' . $rowa["idannee"] . ' '
                . 'and fe.idpatient=' . $id . ' and fe.statutfacture=true') or die(mysqli_error($con));
        $nbres = mysqli_num_rows($rsltres);


        if ($nbres != 0) {
            while ($recf = mysqli_fetch_assoc($rsltres)) {
                $reqmp = $con->query("select * from hp_modepaiement as mp left join hp_banque as b on mp.idbanque=b.idbanque "
                        . "left join hp_campus as c on mp.idcampus=c.idcampus where mp.idmodepaiement='" . $recf["idmodepaiement"] . "'") or die(mysqli_error($con));
                $rowmp = mysqli_fetch_assoc($reqmp);
                $rsltpr = $con->query("select * from hp_chambre as c left join hp_categoriechambre as ch on "
                        . "c.idcategoriechambre=ch.idcategoriechambre where c.idchambre='" . $recf["idchambre"] . "'") or die(mysqli_error($con));
                $rowre = mysqli_fetch_assoc($rsltpr);
                ?>

                <tr >
                    <td><?php print nl2br(htmlspecialchars($recf["codereculoyer"])) ?></td>
                    <td><?php print number_format((nl2br(htmlspecialchars($recf["montantreculoyer"]))), 0, '.', ' '); ?></td>
                    <td><?php echo $rowmp["libellemodepaiement"]; ?> - <?php echo $rowmp["libellebanque"]; ?> - <?php echo $rowmp["libellecampus"]; ?></td>
                    <td>
                        <?php print ((nl2br(htmlspecialchars($rowre["codechambre"])))) ?> - 
                        <?php print ((nl2br(htmlspecialchars($rowre["libellechambre"])))) ?>
                    </td>
                    <td><?php print nl2br(htmlspecialchars($recf["datejourreculoyer"])) ?></td>
                    <td>
                        <a href="hopitalpages/hopitalresidence/hopitalfacture/facture_residence_f_pdf.php?idreculoyer=<?php echo $recf["idreculoyer"] ?>" target="_blank">
                            <span title="Imprimer le Re&ccedil;u de la r&eacute;sidence de l'patient" alt="editer"><i class="glyphicon glyphicon-file"></i> </span>
                        </a>
                    </td>
                </tr>  
                <?php
            }
        }

        $rsltacc = $con->query('select * from hp_recuaccessoire as rl left join hp_accessoirepatient as l on '
                . 'rl.idaccessoirepatient=l.idaccessoirepatient  left join '
                . 'hp_facture as fe on l.idfacture=fe.idfacture where fe.idannee=' . $rowa["idannee"] . ' '
                . 'and fe.idpatient=' . $id . ' and fe.statutfacture=true ') or die(mysqli_error($con));
        $nbacc = mysqli_num_rows($rsltacc);

        if ($nbacc != 0) {
            while ($recf = mysqli_fetch_assoc($rsltacc)) {
                $reqmp = $con->query("select * from hp_modepaiement as mp left join hp_banque as b on mp.idbanque=b.idbanque "
                        . "left join hp_campus as c on mp.idcampus=c.idcampus where mp.idmodepaiement='" . $recf["idmodepaiement"] . "'") or die(mysqli_error($con));
                $rowmp = mysqli_fetch_assoc($reqmp);

//                $rsltpr = $con->query("select * from hp_ligneaccessoire as c left join hp_accessoire as ch on "
//            . "c.idaccessoire=ch.idaccessoire where c.idaccessoirepatient='" . $recf["idaccessoirepatient"] . "'") or die(mysqli_error($con));
                ?>

                <tr >
                    <td><?php print nl2br(htmlspecialchars($recf["coderecuaccessoire"])) ?></td>
                    <td><?php print number_format((nl2br(htmlspecialchars($recf["montantrecuaccessoire"]))), 0, '.', ' '); ?></td>
                    <td><?php echo $rowmp["libellemodepaiement"]; ?> - <?php echo $rowmp["libellebanque"]; ?> - <?php echo $rowmp["libellecampus"]; ?></td>
                    <td>
                        Accessoire
                    </td>
                    <td><?php print nl2br(htmlspecialchars($recf["datejourrecuaccessoire"])) ?></td>
                    <td>
                        <a href="hopitalpages/hopitalaccessoire/hopitalfacture/facture_accessoire_f_pdf.php?idrecuaccessoire=<?php echo $recf["idrecuaccessoire"] ?>" target="_blank">
                            <span title="Imprimer le Re&ccedil;u des accessoires de l'patient" alt="editer"><i class="glyphicon glyphicon-file"></i> </span>
                        </a>
                    </td>
                </tr>  
                <?php
            }
        }


        $rsltfrais = $con->query('select * from hp_recufraisexamen as rl left join hp_facturefraisexamen as l '
                . 'on rl.idfacturefraisexamen=l.idfacturefraisexamen left join '
                . 'hp_facture as fe on l.idfacture=fe.idfacture where fe.idannee=' . $rowa["idannee"] . ' '
                . 'and fe.idpatient=' . $id . ' and fe.statutfacture=true') or die(mysqli_error($con));
        $nbfrais = mysqli_num_rows($rsltfrais);

        if ($nbfrais != 0) {
            while ($recf = mysqli_fetch_assoc($rsltfrais)) {
                $reqmp = $con->query("select * from hp_modepaiement as mp left join hp_banque as b on mp.idbanque=b.idbanque "
                        . "left join hp_campus as c on mp.idcampus=c.idcampus where mp.idmodepaiement='" . $recf["idmodepaiement"] . "'") or die(mysqli_error($con));
                $rowmp = mysqli_fetch_assoc($reqmp);

                $rsltpr = $con->query("select * from hp_fraisexamen as c left join hp_niveau as ch on "
                        . "c.idniveau=ch.idniveau where c.idfraisexamen='" . $recf["idfraisexamen"] . "'") or die(mysqli_error($con));
                $rowre = mysqli_fetch_assoc($rsltpr);
                ?>

                <tr >
                    <td><?php print nl2br(htmlspecialchars($recf["coderecufraisexamen"])) ?></td>
                    <td><?php print number_format((nl2br(htmlspecialchars($recf["montantrecufraisexamen"]))), 0, '.', ' '); ?></td>
                    <td><?php echo $rowmp["libellemodepaiement"]; ?> - <?php echo $rowmp["libellebanque"]; ?> - <?php echo $rowmp["libellecampus"]; ?></td>
                    <td><?php echo $rowre["libellefraisexamen"]; ?> - <?php echo number_format(($rowre["montantfraisexamen"]), 0, '.', ' '); ?> F CFA</td>
                    <td><?php print nl2br(htmlspecialchars($recf["daterecufraisexamen"])) ?></td>
                    <td>
                        <a href="hopitalpages/hopitalfraisexamen/hopitalfacture/facture_fraisexamen_f_pdf.php?idrecufraisexamen=<?php echo $recf["idrecufraisexamen"] ?>" target="_blank">
                            <span title="Imprimer le Re&ccedil;u des frais d'examen de l'patient" alt="editer"><i class="glyphicon glyphicon-file"></i> </span>
                        </a>
                    </td>
                </tr>  

                <?php
            }
        }
    } else {
        echo "<script language='javascript'>$('div.alertannee').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les factures
function lister_facturennnn($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $date = date('Y-m-d');
    $reqa = $con->query("select * from hp_annee where libellean<='" . $date . "' and libellean2>='" . $date . "'") or die(mysqli_error($con));
    $rowa = mysqli_fetch_assoc($reqa);
    if ($rowa != NULL) {
        $rsltens = $con->query("select * from hp_patient as e left join hp_facture as f on e.idfacture=f.idfacture left join "
                . "hp_niveauspecialite as c on f.idniveauspecialite=c.idniveauspecialite where f.idannee='" . $rowa["idannee"] . "' "
                . "and f.statutfacture=true and e.archive=false order by e.nom asc "
                . "") or die(mysqli_error($con));
        while ($recens = mysqli_fetch_assoc($rsltens)) {

            $rsltniv = $con->query("select * from hp_niveau where idniveau='" . $recens["idniveau"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);

            $rsltspe = $con->query("select * from hp_specialite as sp left join hp_filiere as f on sp.idfiliere=f.idfiliere "
                    . "left join hp_cycle as se on f.idcycle=se.idcycle where "
                    . "sp.idspecialite='" . $recens["idspecialite"] . "'") or die(mysqli_error($con));
            $recspe = mysqli_fetch_assoc($rsltspe);
            ?>

            <tr >
                <td><input type="checkbox" name="tbadge[]" value="<?php echo $recens["idfacture"] ?>"/></td>
                <td>
                    <?php
                    if ($recens["photo"] != NULL) {
                        ?>
                        <img class="img-responsive img-rounded" src="hopitalupload/facture/photo/<?php print $recens["photo"] ?>" height="50" width="40"/>
                        <?php
                    } else {
                        ?>
                        photo
                        <?php
                    }
                    ?>
                </td>
                <td><?php print nl2br(htmlspecialchars($recens["matricule"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recens["nom"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recens["prenom"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recens["sexe"])) ?></td>
                <td>
                    <?php
                    print nl2br(htmlspecialchars($recniv["libelleniveau"]));
                    ?>
                </td>
                <td>
                    <?php
                    echo nl2br(htmlspecialchars($recspe["codefiliere"]));
                    ?> <?php
                    echo nl2br(htmlspecialchars($recspe["libellespecialite"]));
                    ?>
                </td>
                <td>
                    <?php
                    if ($recens["redouble"]) {
                        ?>
                        <span title="Redoublant " data-toggle="tooltip" alt="oui" class="label-warning label label-default">Oui</span>
                        <?php
                    } else {
                        ?>
                        <span title="Non redoublant " data-toggle="tooltip" alt="non" class="label-success label label-default">Non</span>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ((isset($_SESSION["hopitalrole"])) && ((($_SESSION["hopitalrole"] == "Super Administrateur") || ($_SESSION["hopitalrole"] == "Administrateur")) || ($_SESSION["hopitalrole"] == "Comptable"))) {
                        ?>
                        <?php
                        if ($recens["etat"]) {
                            ?>
                            <a data-toggle="tooltip" href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/facture_ajax'); ?>&idfacture=<?php echo $recens["idfacture"]; ?>&desactiver=desactiver' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cet facture ?'));" title="D&eacute;sactiver cet Etudiant "  >
                                <span alt="desactiver" class="label-success label label-default">Activer</span>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/facture_ajax'); ?>&idfacture=<?php echo $recens["idfacture"]; ?>&activer=activer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cet facture ?'));" title="Activer cet Etudiant" >
                                <span alt="activer" class="label-danger label label-default">D&eacute;sactiver</span>
                            </a>
                            <?php
                        }
                    } else {
                        if ($recens["etat"]) {
                            ?>
                            <span alt="desactiver" class="label-success label label-default">Activer</span>
                            <?php
                        } else {
                            ?>
                            <span alt="activer" class="label-danger label label-default">D&eacute;sactiver</span>
                            <?php
                        }
                    }
                    ?>
                </td>
                <td>

                    <a href="hopitalpages/hopitalfacture/hopitalfacture/facture_facture_inc_pdf.php?idfacture=<?php echo $recens["idfacture"] ?>" target="blank">
                        <span title="Imprimer le Recu" alt="editer"><i class="glyphicon glyphicon-file"></i> </span>
                    </a>
                </td>
            </tr>

            <?php
        }
    } else {
        echo "<script language='javascript'>$('div.alertannee').show('slow').delay(8000).hide('slow');</script>";
    }
}

function list_facture_paye($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $date = date('Y-m-d');
    $reqa = $con->query("select * from hp_annee where libellean<='" . $date . "' and libellean2>='" . $date . "'") or die(mysqli_error($con));
    $rowa = mysqli_fetch_assoc($reqa);
    if ($rowa != NULL) {
        $rsltd = $con->query('select * from hp_facture as f left join hp_patient as e on e.idpatient=f.idpatient left join '
                . 'hp_niveauspecialite as n '
                . 'on f.idniveauspecialite=n.idniveauspecialite where f.idannee=' . $rowa["idannee"] . ' '
                . 'and f.idniveauspecialite=' . $id . ' and f.paye=true and e.archive=false ') or die(mysqli_error($con));
        $nb = mysqli_num_rows($rsltd);
        if ($nb != 0) {
            ?>
            <table class="table table-striped table-bordered table-hover" id="dataTables-region">
                <thead>
                    <tr class="btn-primary">
                        <th style="width: 3%;text-align: center; border: solid 1px;">N&deg;</th>
                        <th style="width: 7%;text-align: center; border: solid 1px;">MATRICULE</th>
                        <th style="width: 9%;text-align: center; border: solid 1px;">NOM</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">FRAIS SCOLARIT&Eacute;</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">INSCRIPTION</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">MONTANT TOTAL &Agrave; PAYER</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">INSCRIPTION VERS&Eacute;E</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TRANCHE 1</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TRANCHE 2</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TRANCHE 3</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TRANCHE 4</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TOTAL FRAIS VERS&Eacute;</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">RESTE &Agrave; PAYER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nbe = 0;
                    $montfs = 0;
                    $monti = 0;
                    $monttap = 0;
                    $montiv = 0;
                    $lignecaisset1 = 0;
                    $lignecaisset2 = 0;
                    $lignecaisset3 = 0;
                    $lignecaisset4 = 0;
                    $monttfv = 0;
                    $montrap = 0;
                    while ($recd = mysqli_fetch_assoc($rsltd)) {
                        $nbe+=1;
                        $montfs += $recd["montant"];
                        $monti += $recd["montantinscription"];
                        $monttap = $recd["montant"] + $recd["montantinscription"];
                        $montiv += $recd["inscrit"];
                        $lignecaisset1 += $recd["lignecaisse1"];
                        $lignecaisset2 += $recd["lignecaisse2"];
                        $lignecaisset3 += $recd["lignecaisse3"];
                        $lignecaisset4 += $recd["lignecaisse4"];
                        $monttfv = $recd["inscrit"] + $recd["lignecaisse1"] + $recd["lignecaisse2"] + $recd["lignecaisse3"] + $recd["lignecaisse4"];
                        $montrap = $monttap - $monttfv;
                        ?>

                        <tr >
                            <td style="width: 3%;text-align: center; border: solid 1px;"><?php print $nbe ?></td>
                            <td style="width: 7%;text-align: center; border: solid 1px; text-align: center"><?php print nl2br(htmlspecialchars($recd["matricule"])) ?></td>
                            <td style="width: 9%;text-align: center; border: solid 1px; text-align: left"><?php print nl2br(htmlspecialchars($recd["nom"])) ?> <?php print nl2br(htmlspecialchars($recd["prenom"])) ?> </td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($recd["montant"]))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($recd["montantinscription"]))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($monttap))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($recd["inscrit"]))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($recd["lignecaisse1"]))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($recd["lignecaisse2"]))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($recd["lignecaisse3"]))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($recd["lignecaisse4"]))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($monttfv))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($montrap))), 0, '.', ' ') ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                    <tr >
                        <td style="width: 3%;text-align: center; border: solid 1px; text-align: center"></td>
                        <td style="width: 7%;text-align: center; border: solid 1px; text-align: center"></td>
                        <td style="width: 9%;text-align: center; border: solid 1px; text-align: center">Total</td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars(($montfs)))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($monti))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($montfs + $monti))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($montiv))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars(($lignecaisset1)))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars(($lignecaisset2)))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($lignecaisset3))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars($lignecaisset4))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars(($montiv + $lignecaisset1 + $lignecaisset2 + $lignecaisset3 + $lignecaisset4)))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars(($montfs + $monti) - ($montiv + $lignecaisset1 + $lignecaisset2 + $lignecaisset3 + $lignecaisset4)))), 0, '.', ' ') ?></td>
                    </tr>
                </tbody>
            </table>    
            <?php
        } else {
            ?>
            <div class="alert alert-warning">Aucune facture en r&egrave;gle pour l'instant</div>
            <?php
        }
    } else {
        echo "<script language='javascript'>$('div.alertannee').show('slow').delay(8000).hide('slow');</script>";
    }
}

function list_facture_npaye($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $date = date('Y-m-d');
    $reqa = $con->query("select * from hp_annee where libellean<='" . $date . "' and libellean2>='" . $date . "'") or die(mysqli_error($con));
    $rowa = mysqli_fetch_assoc($reqa);
    if ($rowa != NULL) {
        $rsltd = $con->query('select * from hp_facture as f left join hp_patient as e on e.idpatient=f.idpatient left join '
                . 'hp_niveauspecialite as n '
                . 'on f.idniveauspecialite=n.idniveauspecialite where f.idannee=' . $rowa["idannee"] . ' '
                . 'and f.idniveauspecialite=' . $id . ' and f.paye=false and e.archive=false ') or die(mysqli_error($con));
        $nb = mysqli_num_rows($rsltd);
        if ($nb != 0) {
            ?>
            <table class="table table-striped table-bordered table-hover" id="dataTables-region">
                <thead>
                    <tr class="btn-primary">
                        <th style="width: 3%;text-align: center; border: solid 1px;">N&deg;</th>
                        <th style="width: 7%;text-align: center; border: solid 1px;">MATRICULE</th>
                        <th style="width: 9%;text-align: center; border: solid 1px;">NOM</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">FRAIS SCOLARIT&Eacute;</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">INSCRIPTION</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">MONTANT TOTAL &Agrave; PAYER</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">INSCRIPTION VERS&Eacute;E</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TRANCHE 1</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TRANCHE 2</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TRANCHE 3</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TRANCHE 4</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">TOTAL FRAIS VERS&Eacute;</th>
                        <th style="width: 8%;text-align: center; border: solid 1px;">RESTE &Agrave; PAYER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nbe = 0;
                    $montfs = 0;
                    $monti = 0;
                    $monttap = 0;
                    $montiv = 0;
                    $lignecaisset1 = 0;
                    $lignecaisset2 = 0;
                    $lignecaisset3 = 0;
                    $lignecaisset4 = 0;
                    $monttfv = 0;
                    $montrap = 0;
                    while ($recd = mysqli_fetch_assoc($rsltd)) {
                        $nbe+=1;
                        $montfs += $recd["montant"];
                        $monti += $recd["montantinscription"];
                        $monttap = $recd["montant"] + $recd["montantinscription"];
                        $montiv += $recd["inscrit"];
                        $lignecaisset1 += $recd["lignecaisse1"];
                        $lignecaisset2 += $recd["lignecaisse2"];
                        $lignecaisset3 += $recd["lignecaisse3"];
                        $lignecaisset4 += $recd["lignecaisse4"];
                        $monttfv = $recd["inscrit"] + $recd["lignecaisse1"] + $recd["lignecaisse2"] + $recd["lignecaisse3"] + $recd["lignecaisse4"];
                        $montrap = $monttap - $monttfv;
                        ?>

                        <tr >
                            <td style="width: 3%;text-align: center; border: solid 1px;"><?php print $nbe ?></td>
                            <td style="width: 7%;text-align: center; border: solid 1px; text-align: center"><?php print nl2br(htmlspecialchars($recd["matricule"])) ?></td>
                            <td style="width: 9%;text-align: center; border: solid 1px; text-align: left"><?php print nl2br(htmlspecialchars($recd["nom"])) ?> <?php print nl2br(htmlspecialchars($recd["prenom"])) ?> </td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($recd["montant"])))))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($recd["montantinscription"])))))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($monttap)))))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($recd["inscrit"])))))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($recd["lignecaisse1"])))))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($recd["lignecaisse2"])))))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($recd["lignecaisse3"])))))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($recd["lignecaisse4"])))))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($monttfv)))))), 0, '.', ' ') ?></td>
                            <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((nl2br(htmlspecialchars($montrap)))))), 0, '.', ' ') ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                    <tr >
                        <td style="width: 3%;text-align: center; border: solid 1px; text-align: center"></td>
                        <td style="width: 7%;text-align: center; border: solid 1px; text-align: center"></td>
                        <td style="width: 9%;text-align: center; border: solid 1px; text-align: center">Total</td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars(($montfs)))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars(($monti)))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars(($montfs + $monti)))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars(($montiv)))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print (number_format((nl2br(htmlspecialchars(($lignecaisset1)))), 0, '.', ' ')) ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print (number_format((nl2br(htmlspecialchars(($lignecaisset2)))), 0, '.', ' ')) ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print (number_format((nl2br(htmlspecialchars(($lignecaisset3)))), 0, '.', ' ')) ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print (number_format((nl2br(htmlspecialchars(($lignecaisset4)))), 0, '.', ' ')) ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((($montiv + $lignecaisset1 + $lignecaisset2 + $lignecaisset3 + $lignecaisset4))))), 0, '.', ' ') ?></td>
                        <td style="width: 8%;text-align: center; border: solid 1px; text-align: right"><?php print number_format((nl2br(htmlspecialchars((($montfs + $monti) - ($montiv + $lignecaisset1 + $lignecaisset2 + $lignecaisset3 + $lignecaisset4))))), 0, '.', ' ') ?></td>
                    </tr>
                </tbody>
            </table>    
            <?php
        } else {
            ?>
            <div class="alert alert-warning">Aucune facture insolvable pour l'instant</div>
            <?php
        }
    } else {
        echo "<script language='javascript'>$('div.alertannee').show('slow').delay(8000).hide('slow');</script>";
    }
}
