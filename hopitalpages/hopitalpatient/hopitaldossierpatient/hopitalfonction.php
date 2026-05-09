<?php

function lister_dossier_patient($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $date = date('Y-m-d');
    $req_fin = $con->query("select * from hp_patient as p left join hp_dossier as d on p.idpatient=d.idpatient "
            . "where p.idpatient='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $rsltcp = $con->query("select * from hp_parametre_patient as c left join hp_parametre as sd on "
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
                <?php print nl2br(htmlspecialchars($recfnp["datejourparametrepatient"])) ?> -->
                <?php print nl2br(htmlspecialchars($recfnp["heureparametrepatient"])) ?>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9">
                <?php print nl2br(htmlspecialchars($recfnp["libelleparametre"])) ?> : 
                <?php print nl2br(htmlspecialchars($recfnp["valeurparametrepatient"])) ?> 
                <?php print nl2br(htmlspecialchars($recfnp["codeunite"])) ?> 
                (<?php print nl2br(htmlspecialchars($recfnp["valeurminparametre"])) ?> - 
                <?php print nl2br(htmlspecialchars($recfnp["valeurmaxparametre"])) ?> 
                <?php print nl2br(htmlspecialchars($recfnp["codeunite"])) ?> )
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
                                if ($recfnp["typeechographie"] == "Obstétricale") {
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
