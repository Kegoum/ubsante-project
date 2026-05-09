<?php

//Gestion des pointage
function lister_personnel_pointage($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $rsltuser = $con->query("select * from hp_personnel as pe left join hp_affectation as af on "
            . "pe.idpersonnel=af.idpersonnel left join hp_service as s on af.idservice=s.idservice "
            . "where af.etataffectation=true ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["codepersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nompersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenompersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephonepersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["rolepersonnel"])) ?></td>
            <td><?php // print nl2br(htmlspecialchars($recuser["salaireaffectation"])) ?> / <?php // print nl2br(htmlspecialchars($recuser["typepaiement"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpointage/lister_pointage_personnel') ?>&idpersonnel=<?php echo $recuser["idpersonnel"] ?>">
                        <span title="Gérer les pointages de ce Personnel" alt="add"><i class="glyphicon glyphicon-list-alt"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <?php
                }
                ?>

            </td>
        </tr>

        <?php
    }
}

function insert_pointage_personnel($idens, $idmc, $datece, $heuredce, $heurefce, $nbheurepointage1, $nbheurepointage2, $typepaiement, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltspe1ut = $con->query("select * from hp_personnel as pe left join hp_affectation as af on "
            . "pe.idpersonnel=af.idpersonnel left join hp_service as s on af.idservice=s.idservice "
            . "where af.etataffectation=true and pe.idpersonnel='" . $idens . "'") or die(mysqli_error($con));
        $recut = mysqli_fetch_assoc($rsltspe1ut);
    $req = $con->query("select * from hp_pointage where datejourpointage = '" . $datece . "' AND ((heuredebutpointage <= '" . $heuredce . "' AND "
            . "heurefinpointage >= '" . $heuredce . "'  AND idaffectation ='" . $recut["idaffectation"] . "') "
            . "OR (heuredebutpointage <= '" . $heurefce . "' AND heurefinpointage >= '" . $heurefce . "'  AND idaffectation ='" . $recut["idaffectation"] . "'))") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        
        $and = date('Y');
        $sand = substr($and, 2);
        $co = strtoupper(substr($recut["codepersonnel"], 0, 2));
        $tail2 = (strlen($sand . $co));

        $chaine = $sand . $co;
        $numid = $sand . $co . sprintf("%03d", 1);

        $req = $con->query("select SUBSTR(e.codepointage, '" . ($tail2 + 1) . "',3) as mat from hp_pointage as e where "
                . "SUBSTR(e.codepointage, 1,'" . $tail2 . "')='" . $chaine . "' order by SUBSTR(e.codepointage, "
                . "'" . ($tail2 + 1) . "',3) asc") or die(mysqli_error($con));
        $i = mysqli_num_rows($req);
        if ($i != 0) {
            $matri33 = '';
            while ($ro = mysqli_fetch_assoc($req)) {
                $matri33 = ($ro["mat"]);
            }
            $numid = $sand . $co . sprintf("%03d", ($matri33 + 1));
        }
        $con->query("insert into hp_pointage(idaffectation, codepointage, datepointage, datejourpointage, heuredebutpointage, "
                . "heurefinpointage, nombreheurepointage, nombreheuredecimalepointage, typepointage) values("
                . "'" . $recut["idaffectation"] . "', '" . $numid . "', NOW(), '" . $datece . "', '" . $heuredce . "', "
                . "'" . $heurefce . "', '" . $nbheurepointage1 . "', '" . $nbheurepointage2 . "', '" . $typepaiement . "')") or die(mysqli_error($con));
       
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalpersonnel/hopitalpointage/lister_pointage_personnel';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idpersonnel=' . $idmc . '">');
    } else {
        echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_pointage_personnel($personnel, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltens = $con->query("select * from hp_pointage as p left join hp_affectation as a on p.idaffectation=a.idaffectation "
            . "left join hp_personnel as pe on a.idpersonnel=pe.idpersonnel where a.idpersonnel='" . $personnel . "' ") or die(mysqli_error($con));
    while ($recens = mysqli_fetch_assoc($rsltens)) {
        ?>

        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recens["codepointage"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["datejourpointage"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["heuredebutpointage"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["heurefinpointage"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["nombreheurepointage"])) ?></td>
             <td>
                <?php if ($recens["typepointage"]=="normal") { ?>
                    <span alt="Pay&eacute;" class="label-success label label-default">Normal</span>
                    <?php
                } else if ($recens["typepointage"]=="heuresup15") {
                    ?>
                    <span alt="Heure Suplémentaire 15&percnt;" class="label-warning label label-default">Heure Suplémentaire 15&percnt;</span>
                    <?php
                }else if ($recens["typepointage"]=="heuresup20") {
                    ?>
                    <span alt="Heure Suplémentaire 20&percnt;" class="label-warning label label-default">Heure Suplémentaire 20&percnt;</span>
                    <?php
                }else if ($recens["typepointage"]=="heuresup30") {
                    ?>
                    <span alt="Heure Suplémentaire 30&percnt;" class="label-warning label label-default">Heure Suplémentaire 30&percnt;</span>
                    <?php
                }else if ($recens["typepointage"]=="heuresup40") {
                    ?>
                    <span alt="Heure Suplémentaire 40&percnt;" class="label-warning label label-default">Heure Suplémentaire 40&percnt;</span>
                    <?php
                }else if ($recens["typepointage"]=="heuresup50") {
                    ?>
                    <span alt="Heure Suplémentaire 50&percnt;" class="label-warning label label-default">Heure Suplémentaire 50&percnt;</span>
                    <?php
                } else {
                    ?>
                    <span alt="Pay&eacute;" class="label-success label label-default">Normal</span>
                    <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (!$recens["payepointage"]) {
                    if ($recens["etatpointage"]) {
                        ?>
                        <a data-toggle="tooltip" href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpointage/pointage_ajax'); ?>&idpointage=<?php echo $recens["idpointage"]; ?>&desactiver=desactiver' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Annuler la validation de ces heures ?'));" title="Annuler la validation de ces heures "  >
                            <span alt="desactiver" class="label-success label label-default">Valid&eacute;</span>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a data-toggle="tooltip" href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpointage/pointage_ajax'); ?>&idpointage=<?php echo $recens["idpointage"]; ?>&activer=activer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Valider ces heures ?'));" title="Valider ces heures "  >
                            <span alt="activer" class="label-warning label label-default">Non valid&eacute;</span>
                        </a>
                        <?php
                    }
                } else {
                    if ($recens["etatpointage"]) {
                        ?>
                        <span alt="desactiver" class="label-success label label-default">Valid&eacute;</span>
                        <?php
                    } else {
                        ?>
                        <span alt="activer" class="label-warning label label-default">Non valid&eacute;</span>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
                <?php if ($recens["payepointage"]) { ?>
                    <span alt="Pay&eacute;" class="label-success label label-default">Pay&eacute;</span>
                    <?php
                } else {
                    ?>
                    <span alt="impay&eacute;" class="label-warning label label-default">Impay&eacute;</span>
                    <?php
                }
                ?>
            </td>
                <!--<td><?php // print nl2br(htmlspecialchars($recens["nombreheuredecimalepointage"]))    ?></td>-->
           <!--<td>-->
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <!--                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpointage/lister_personnel'); ?>&idpointage=<?php echo $recens["idpointage"] ?>">
                                    <span title="Modifier ce pointage" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                                </a>-->
                    <?php
                }
                ?>
            <!--</td>-->
        </tr>

        <?php
    }
}

function editer_pointage_personnel($idc, $idens, $datedce, $datefce, $nbheurepointage, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $datepointage = date('Y-m-d');
    $req = $con->query("select * from pointageeffectue where ((datedebutce <= '" . $datedce . "' AND datefince >= '" . $datedce . "'  AND idpersonnel ='" . $idens . "') "
            . "OR (datedebutce <= '" . $datefce . "' AND datefince >= '" . $datefce . "'  AND idpersonnel ='" . $idens . "'))") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $reqce = $con->query("select * from pointageeffectue where idpointage ='" . $idc . "'") or die(mysqli_error($con));
    $rowce = mysqli_fetch_assoc($reqce);
    $pointagee = $rowce["nbheurece"];
    $rowc = mysqli_fetch_assoc($req);
    if (($nb == 0) || (($nb != 0) && ($rowc["idpointage"] == $idc) )) {
        $rslt = $con->query("update pointageeffectue set datedebutce='" . $datedce . "',datefince='" . $datefce . "',"
                . "nbheurece='" . $nbheurepointage . "' where idpointage='" . $idc . "'") or die(mysqli_error($con));

        $reqe = $con->query("select * from personnel where idpersonnel='" . $idens . "'") or die(mysqli_error($con));
        $rowe = mysqli_fetch_assoc($reqe);
        $heurerest = $rowe["nbreheurerest"] - ($nbheurepointage - $pointagee);
        $reqc = $con->query("update personnel set nbreheurerest='" . $heurerest . "' where idpersonnel='" . $idens . "'") or die(mysqli_error($con));

        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertcemauv').show('slow').delay(8000).hide('slow');</script>";
    }
}
