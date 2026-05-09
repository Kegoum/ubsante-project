
<?php
if ((isset($_REQUEST["dated"])) && (isset($_REQUEST["datef"]))) {

    $dated = addslashes($_REQUEST["dated"]);
    $datef = addslashes($_REQUEST["datef"]);

    $datedd = explode('-', $dated);
    $datede = $datedd[2] . "-" . $datedd[1] . "-" . $datedd[0];

    $datedf = explode('-', $datef);
    $datefe = $datedf[2] . "-" . $datedf[1] . "-" . $datedf[0];

    $encais1 = 0;
    $decais1 = 0;

    $soldei = 0;
    $encais = 0;
    $decais = 0;

    $tabc = array();
    $ic = 0;

    $tabordo = array();
    $iordo = 0;

    $eta = "Actif";
    $ope = "Encaissement";
    $opd = "Décaissement";
    $rsltconsi = $con->query("select *, cast(lc.datejourlignecaisse as DATE) as datec from hp_ligne_caisse as lc left join hp_caisse "
            . "as c on lc.idcaisse=c.idcaisse where (cast(lc.datejourlignecaisse as DATE) < '" . $dated . "') "
            . "and lc.paiementlignecaisse='" . $eta . "'") or die(mysqli_error($con));
    while ($row = mysqli_fetch_assoc($rsltconsi)) {
        if ($row["operationlignecaisse"] == "Encaissement") {
            $soldei = $soldei + $row["montantlignecaisse"];
        } else {
            $soldei = $soldei - $row["montantlignecaisse"];
        }
    }
    $rsltcons = $con->query("select *, cast(lc.datejourlignecaisse as DATE) as datec from hp_ligne_caisse as lc left join hp_caisse "
            . "as c on lc.idcaisse=c.idcaisse where (cast(lc.datejourlignecaisse as DATE) BETWEEN '" . $dated . "' and '" . $datef . "') "
            . "and lc.paiementlignecaisse='" . $eta . "' and lc.operationlignecaisse='" . $ope . "' order by datec desc") or die(mysqli_error($con));

    $rsltord = $con->query("select *, cast(lc.datejourlignecaisse as DATE) as datec from hp_ligne_caisse as lc left join hp_caisse "
            . "as c on lc.idcaisse=c.idcaisse where (cast(lc.datejourlignecaisse as DATE) BETWEEN '" . $dated . "' and '" . $datef . "') "
            . "and lc.paiementlignecaisse='" . $eta . "' and lc.operationlignecaisse='" . $opd . "' order by datec desc") or die(mysqli_error($con));

    while ($rowlbl = mysqli_fetch_assoc($rsltcons)) {

        $rsltuarpa = $con->query("select * from hp_facture as lc where "
                . "lc.idfacture='" . $rowlbl["idfacture"] . "'") or die(mysqli_error($con));
        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
        $but = "";
        if ($rowarpa["idconsultation"] != NULL) {
            $but = "Consultation";
        } else if ($rowarpa["idexamenpatient"] != NULL) {
            $but = "Examen";
        } else if ($rowarpa["idechographiepatient"] != NULL) {
            $but = "Echographie";
        } else if ($rowarpa["idactepatient"] != NULL) {
            $but = "Autre";
        } else if ($rowarpa["idordonnance"] != NULL) {
            $but = "Ordonance";
        }

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["referencem"] = "";
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["libellem"] = $but;
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["montant"] = $rowlbl["montantlignecaisse"];
        $encais1 = $encais1 + $rowlbl["montantlignecaisse"];
        if (!empty($tabc)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabc as $k => $v) {
                if (($tabc[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabc[$k]["lignefinance"] as $km => $vm) {
                        if (($tabc[$k]["lignefinance"][$km]["libellem"] == $but)) {
                            $fm = TRUE;
                            $tabc[$k]["lignefinance"][$km]["montant"] = $tabc[$k]["lignefinance"][$km]["montant"] + $rowlbl["montantlignecaisse"];
                        }
                    }

                    if (!$fm) {
                        $tabc[$k]["lignefinance"][$ic]["referencem"] = "";
                        $tabc[$k]["lignefinance"][$ic]["libellem"] = $but;
                        $tabc[$k]["lignefinance"][$ic]["montant"] = $rowlbl["montantlignecaisse"];
                        $ic = $ic + 1;
                    }
                }
            }
            if (!$f) {
                $tabc = array_merge($tabc, $prodArray);
                $ic = $ic + 1;
            }
        } else {
            $tabc = $prodArray;
            $ic = $ic + 1;
        }
    }
    while ($rowlbl = mysqli_fetch_assoc($rsltord)) {

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["referencem"] = $rowlbl["codelignecaisse"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["libellem"] = $rowlbl["butlignecaisse"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["montant"] = $rowlbl["montantlignecaisse"];
        $decais1 = $decais1 + $rowlbl["montantlignecaisse"];

        if (!empty($tabordo)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabordo as $k => $v) {
                if (($tabordo[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabordo[$k]["lignefinance"] as $km => $vm) {
                        if (($tabordo[$k]["lignefinance"][$km]["referencem"] == $rowlbl["codelignecaisse"])) {
                            $fm = TRUE;
                            $tabordo[$k]["lignefinance"][$km]["montant"] = $tabordo[$k]["lignefinance"][$km]["montant"] + $rowlbl["montantlignecaisse"];
                        }
                    }

                    if (!$fm) {
                        $tabordo[$k]["lignefinance"][$iordo]["referencem"] = $rowlbl["codelignecaisse"];
                        $tabordo[$k]["lignefinance"][$iordo]["libellem"] = $rowlbl["butlignecaisse"];
                        $tabordo[$k]["lignefinance"][$iordo]["montant"] = $rowlbl["montantlignecaisse"];
                        $iordo = $iordo + 1;
//                print_r($iordo);
                    }
                }
            }
            if (!$f) {
                $tabordo = array_merge($tabordo, $prodArray);
                $iordo = $iordo + 1;
            }
        } else {
            $tabordo = $prodArray;
            $iordo = $iordo + 1;
        }
    }
    $soldef1 = $soldei + $encais1 - $decais1;
    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Le journal de caisse du <?php echo $dated ?> au <?php echo $datef ?></h1>
                                <a href="hopitalpages/hopitalfinance/hopitaljournalcaisse/print_journalcaisse_p_pdf.php?dated=<?php echo $dated ?>&datef=<?php echo $datef ?>" class="btn btn-lg btn-success" target="_blank">
                                    <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
                                </a>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div id="toolbar">
                                    <select class="form-control dt-tb">
                                        <option value="">Exporter</option>
                                        <option value="all">Exporter Tout</option>
                                        <option value="selected">Exporter la Selection</option>
                                    </select>
                                </div>
                                <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                    <thead>    
                                        <tr> 
                                            <th style="width: 15%;text-align: left; border: solid 1px;">Solde initial :</th>
                                            <th style="width: 25%;text-align: right; border: solid 1px;"><b><?php echo number_format($soldei, 0, ',', ' '); ?></b></th>
                                            <th style="width: 40%;text-align: center; border: solid 1px;"></th>
                                            <th style="width: 20%;text-align: center; border: solid 1px;"></th>
                                        </tr>    
                                        <tr> 
                                            <th style="width: 15%;text-align: left; border: solid 1px;">Encaissement :</th>
                                            <th style="width: 25%;text-align: right; border: solid 1px;"><b><?php echo number_format($encais1, 0, ',', ' '); ?></b></th>
                                            <th style="width: 40%;text-align: center; border: solid 1px;"></th>
                                            <th style="width: 20%;text-align: center; border: solid 1px;"></th>
                                        </tr>    
                                        <tr> 
                                            <th style="width: 15%;text-align: left; border: solid 1px;">Decaissement :</th>
                                            <th style="width: 25%;text-align: right; border: solid 1px;"><b><?php echo number_format($decais1, 0, ',', ' '); ?></b></th>
                                            <th style="width: 40%;text-align: center; border: solid 1px;"></th>
                                            <th style="width: 20%;text-align: center; border: solid 1px;"></th>
                                        </tr>    
                                        <tr> 
                                            <th style="width: 15%;text-align: left; border: solid 1px;">Solde final :</th>
                                            <th style="width: 25%;text-align: right; border: solid 1px;"><b><?php echo number_format($soldef1, 0, ',', ' '); ?></b></th>
                                            <th style="width: 40%;text-align: center; border: solid 1px;"></th>
                                            <th style="width: 20%;text-align: center; border: solid 1px;"></th>
                                        </tr>     
                                        <tr> 
                                            <th colspan="4" style="width: 100%;text-align: center; border: solid 1px;">&nbsp;</th>
                                        </tr>
                                        <tr style=" background: #cbcaca;"> 
                                            <th style="width: 15%;text-align: center; border: solid 1px;">Date</th>
                                            <th style="width: 25%;text-align: center; border: solid 1px;">Reference</th>
                                            <th style="width: 40%;text-align: center; border: solid 1px;">Libelle</th>
                                            <th style="width: 20%;text-align: center; border: solid 1px;">Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="background-color: #eee">
                                            <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;"><b>Solde initial</b></td>
                                            <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                                            <td style="width: 20%;text-align: right; border: solid 1px;"><b><?php echo number_format($soldei, 0, ',', ' '); ?></b></td>
                                        </tr>
                                        <?php
                                        if ($ic != 0) {
                                            ?>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;"><b>Encaissement</b></td>
                                                <td style="width: 25%;text-align: center; border: solid 1px;"></td>
                                                <td style="width: 40%;text-align: center; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: center; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                            foreach ($tabc as $prod) {
//                            print_r($prod);
                                                foreach ($prod["lignefinance"] as $prodm) {
                                                    ?>
                                                    <tr >
                                                        <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                                        <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["referencem"])) ?></td>
                                                        <td style="width: 40%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montant"], 0, ',', ' '); ?></td>
                                                    </tr>
                                                    <?php
                                                    $encais = $encais + $prodm["montant"];
                                                }
                                            }
                                            ?>
                                            <tr style="background-color: #eee">
                                                <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;"><b>Total Encaissement</b></td>
                                                <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><b><?php echo number_format($encais, 0, ',', ' '); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%;text-align: right; border: solid 1px;">&nbsp;</td>
                                                <td style="width: 25%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($iordo != 0) {
                                            ?>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;"><b>D&eacute;caissement</b></td>
                                                <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                            foreach ($tabordo as $prod) {
//                            print_r($prod);
                                                foreach ($prod["lignefinance"] as $prodm) {
                                                    ?>
                                                    <tr >
                                                        <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                                        <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["referencem"])) ?></td>
                                                        <td style="width: 40%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montant"], 0, ',', ' '); ?></td>

                                                    </tr>
                                                    <?php
                                                    $decais = $decais + $prodm["montant"];
                                                }
                                            }
                                            ?>
                                            <tr style="background-color: #eee">
                                                <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;"><b>Total D&eacute;caissement</b></td>
                                                <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><b><?php echo number_format($decais, 0, ',', ' '); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                                                <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td style="width: 15%;text-align: right; border: solid 1px;">&nbsp;</td>
                                            <td style="width: 25%;text-align: right; border: solid 1px;"></td>
                                            <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                                            <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                        </tr>
                                        <?php
                                        $soldef = $soldei + $encais - $decais;
                                        ?>
                                        <tr style="background-color: #eee">
                                            <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;"><b>Solde final</b></td>
                                            <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                                            <td style="width: 20%;text-align: right; border: solid 1px;"><b><?php echo number_format($soldef, 0, ',', ' '); ?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <a href="hopitalpages/hopitalfinance/hopitaljournalcaisse/print_journalcaisse_p_pdf.php?dated=<?php echo $dated ?>&datef=<?php echo $datef ?>" class="btn btn-lg btn-success" target="_blank">
                            <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
