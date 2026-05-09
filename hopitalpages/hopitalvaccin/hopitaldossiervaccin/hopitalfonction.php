<?php

function lister_dossier_vaccin($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $date = date('Y-m-d');
    $req_fin = $con->query("select * from hp_vaccin as p left join hp_dossier as d on p.idvaccin=d.idvaccin "
            . "where p.idvaccin='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $rsltcp = $con->query("select * from hp_parametre_vaccin as c left join hp_parametre as sd on "
            . "c.idparametre=sd.idparametre left join hp_unite as d on sd.idunite=d.idunite where "
            . "c.idconsultation='" . $id . "'") or die(mysqli_error($con));
    $nbf = 0;
    $rsltfnpc = $con->query("select * from hp_consultation as lc left join hp_acte as f on "
            . "lc.idacte=f.idacte left join hp_service as u on f.idservice=u.idservice where "
            . "lc.idconsultation='" . $id . "' order by lc.dateconsultation desc ") or die(mysqli_error($con));

    $recfnp = mysqli_fetch_assoc($rsltfnpc);
    ?>
    But : 
    <?php print nl2br(htmlspecialchars($recfnp["butconsultation"])) ?><br>
    Diagnostique : 
    <?php print nl2br(htmlspecialchars($recfnp["diagnostiqueconsultation"])) ?>
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
    while ($recfnp = mysqli_fetch_assoc($rsltcp)) {
        ?>
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-3">
                <?php print nl2br(htmlspecialchars($recfnp["datejourparametrevaccin"])) ?> -->
                <?php print nl2br(htmlspecialchars($recfnp["heureparametrevaccin"])) ?>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9">
                <?php print nl2br(htmlspecialchars($recfnp["libelleparametre"])) ?> : 
                <?php print nl2br(htmlspecialchars($recfnp["valeurparametrevaccin"])) ?> 
                <?php print nl2br(htmlspecialchars($recfnp["codeunite"])) ?> 
                (<?php print nl2br(htmlspecialchars($recfnp["valeurminparametre"])) ?> - 
                <?php print nl2br(htmlspecialchars($recfnp["valeurmaxparametre"])) ?> 
                <?php print nl2br(htmlspecialchars($recfnp["codeunite"])) ?> )
            </div>
        </div>
        <?php
    }

    $rsltfnpep = $con->query("select * from hp_examen_vaccin as lc left join hp_examen as f on lc.idexamen=f.idexamen "
            . "left join hp_laboratoire as l on f.idlaboratoire=l.idlaboratoire left join hp_service as u on "
            . "l.idservice=u.idservice where lc.idconsultation='" . $id . "' order by lc.dateexamenvaccin desc ") or die(mysqli_error($con));
    $nbep = mysqli_num_rows($rsltfnpep);

    if ($nbep != 0) {
        ?>
        <br><br>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h5>Liste des examens du vaccin </h5>
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

                    $rsltfnp2 = $con->query("select * from hp_facture where idexamenvaccin='" . $recfnp["idexamenvaccin"] . "' and "
                            . "etatfacture=true ") or die(mysqli_error($con));
                    $nbfnp = mysqli_num_rows($rsltfnp2);

//        print_r($recfnp);
                    ?>

                    <tr >
                        <td></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["codeexamenvaccin"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["typeexamen"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["butexamenvaccin"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["resultatexamenvaccin"])) ?> 
                        </td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["valeurexamenvaccin"])) ?> 
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
                                    if ($recfnp["etatexamenvaccin"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalexamen/hopitalnfs/lister_resultat') ?>&idexamenvaccin=<?php echo $recfnp["idexamenvaccin"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeexamen"] == "Prélèvement Cervico-Vaginal: PCV") {
                                    if ($recfnp["etatexamenvaccin"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalexamen/hopitalpcv/lister_resultat') ?>&idexamenvaccin=<?php echo $recfnp["idexamenvaccin"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeexamen"] == "Sérologie V.I.H") {
                                    if ($recfnp["etatexamenvaccin"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalexamen/hopitalvih/lister_resultat') ?>&idexamenvaccin=<?php echo $recfnp["idexamenvaccin"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeexamen"] == "Coprologie Parasitaire: Selles") {
                                    if ($recfnp["etatexamenvaccin"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalexamen/hopitalcoprologie_parasitaire/lister_resultat') ?>&idexamenvaccin=<?php echo $recfnp["idexamenvaccin"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeexamen"] == "Sérologie de Widal et Felix") {
                                    if ($recfnp["etatexamenvaccin"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalexamen/hopitalserologie_widal_felix/lister_resultat') ?>&idexamenvaccin=<?php echo $recfnp["idexamenvaccin"] ?>">
                                            <span title="Afficher le resultat de cet examen" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else {
                                    if ($recfnp["etatexamenvaccin"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalexamen/hopitalautre/lister_resultat') ?>&idexamenvaccin=<?php echo $recfnp["idexamenvaccin"] ?>">
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
                <h5>Liste des examens du vaccin </h5>
            </div>
        </div>
        <?php
        if ((isset($_SESSION["issamrole"])) && ((($_SESSION["issamrole"] == "Super Administrateur") || ($_SESSION["issamrole"] == "Administrateur")) || ($_SESSION["issamrole"] == "Comptable"))) {
            ?>
                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalexamen/hopitalautre/lister_resultat') ?>&idexamenvaccin=<?php echo $recfnp["idexamenvaccin"] ?>">-->
            <span title="Attribuer un examen" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
            <!--</a>-->
            <?php
        }
        ?>

        <?php
    }

    $rsltfnpecp = $con->query("select * from hp_echographie_vaccin as ep left join hp_echographie as e on ep.idechographie=e.idechographie "
            . "left join hp_acte as a on e.idacte=a.idacte left join hp_service as s on "
            . "e.idservice=s.idservice where ep.idconsultation='" . $id . "' order by ep.dateechographievaccin desc ") or die(mysqli_error($con));
    $nbecp = mysqli_num_rows($rsltfnpecp);

    if ($nbecp != 0) {
        ?>
        <br><br>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h5>Liste des &eacute;chographies du vaccin </h5>
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

                    $rsltfnp2 = $con->query("select * from hp_facture where idechographievaccin='" . $recfnp["idechographievaccin"] . "' and "
                            . "etatfacture=true ") or die(mysqli_error($con));
                    $nbfnp = mysqli_num_rows($rsltfnp2);

//        print_r($recfnp);
                    ?>

                    <tr >
                        <td></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["codeechographievaccin"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["nomechographie"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["butechographievaccin"])) ?></td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["resultatechographievaccin"])) ?> 
                        </td>
                        <td><?php print nl2br(htmlspecialchars($recfnp["valeurechographievaccin"])) ?> 
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
                                if ($recfnp["typeechographie"] == "Obstétricale") {
                                    if ($recfnp["etatechographievaccin"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalechographie/hopitalobstetricale/lister_resultat') ?>&idechographievaccin=<?php echo $recfnp["idechographievaccin"] ?>">
                                            <span title="Afficher le resultat de cet echographie" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                        </a>
                                        <?php
                                    }
                                } else if ($recfnp["typeechographie"] == "Pelvienne") {
                                    if ($recfnp["etatechographievaccin"]) {
                                        ?> 
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalechographie/hopitalpelvienne/lister_resultat') ?>&idechographievaccin=<?php echo $recfnp["idechographievaccin"] ?>">
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
                <h5>Liste des echographies du vaccin </h5>
            </div>
        </div>
        <?php
        if ((isset($_SESSION["issamrole"])) && ((($_SESSION["issamrole"] == "Super Administrateur") || ($_SESSION["issamrole"] == "Administrateur")) || ($_SESSION["issamrole"] == "Comptable"))) {
            ?>
                    <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalechographie/hopitalpelvienne/lister_resultat') ?>&idechographievaccin=<?php echo $recfnp["idechographievaccin"] ?>">-->
            <span title="Attribuer un echographie" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
            <!--</a>-->
            <?php
        }
        ?>

        <?php
    }
}

function administrer_vaccin($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $err = false;
        $date = date('Y-m-d');
        $eta = 1;
        $idv = $reg["1"]["idvaccin"];
        $datej = $reg["1"]["datejour"];
        $dater = $reg["1"]["daterdv"];
        $masse = $reg["1"]["masse"];
        $taille = $reg["1"]["taille"];
        $ctete = $reg["1"]["ctete"];
        $cbras = $reg["1"]["cbras"];
//        echo "<script language='javascript'>alert($datej)</script>";

        $ie = $reg["1"]['nbvaccin'];
        if (($ie != 0)) {
            for ($je = 0; $je < $ie; $je++) {
                $vacci = $reg["1"]['vaccin'][$je];
                $reqmc = $con->query("select * from hp_administration_vaccin where idvaccin='" . $idv . "' and "
                        . "vaccinadministrationvaccin='" . $vacci . "'") or die(mysqli_error($con));
                $nbmc = mysqli_num_rows($reqmc);
                if ($nbmc == 0) {
                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                        $rsltn = $con->query("insert into hp_administration_vaccin(idvaccin, datejouradministrationvaccin, vaccinadministrationvaccin, "
                                . "masseadministrationvaccin, tailleadministrationvaccin, circonferenceteteadministrationvaccin, "
                                . "circonferencebrasadministrationvaccin, dateadministrationvaccin) values('" . $idv . "','" . $datej . "', "
                                . "'" . $vacci . "', '" . $masse . "', '" . $taille . "', '" . $ctete . "', '" . $cbras . "', NOW())") or die(mysqli_error($con));
                    } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                        $rsltn = $con->query("insert into hp_administration_vaccin(idvaccin, idcomptepersonnel, datejouradministrationvaccin, vaccinadministrationvaccin, "
                                . "masseadministrationvaccin, tailleadministrationvaccin, circonferenceteteadministrationvaccin, "
                                . "circonferencebrasadministrationvaccin, dateadministrationvaccin) values('" . $idv . "', '" . $_SESSION["idcomptepersonnel"] . "','" . $datej . "', "
                                . "'" . $vacci . "', '" . $masse . "', '" . $taille . "', '" . $ctete . "', '" . $cbras . "', NOW())") or die(mysqli_error($con));
                    }
                    $con->query("update hp_vaccin set $vacci='" . $datej . "' where idvaccin='" . $idv . "'") or die(mysqli_error($con));

                    $op = "Administration";
                    $ob = "Vaccin";
//                    $rsltt = $con->query("insert into smstrace(idparametre, iduser, operation, objet, date) values('" . $id . "', "
//                                . "'" . $_SESSION["idutilisateur"] . "', '" . $op . "', '" . $ob . "', NOW())") or die(mysqli_error($con));
//                    echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
//                    $pagp = 'hopitalpages/hopitalpatient/lister_patient';
//                    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
                } else {
                    $err = true;
                }
            }
        }
        $rsltn = $con->query("insert into hp_rendez_vous_vaccin(idvaccin, datejourrendezvousvaccin, "
                . "daterendezvousvaccin) values('" . $idv . "', '" . $dater . "', NOW())") or die(mysqli_error($con));


        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalvaccin/hopitaldossiervaccin/hopitaladministrer/administrer_vaccin';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idvaccin=' . $idv . '">');
        } else {
            unset($_SESSION['formadministrevaccin']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalvaccin/hopitaldossiervaccin/lister_dossier_vaccin';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idvaccin=' . $idv . '">');
        }
    }
}
