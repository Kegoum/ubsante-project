<?php
if ((isset($_POST["datedcp"])) && (isset($_POST["datefcp"]))) {
    $dated = $_POST["datedcp"];
    $datef = $_POST["datefcp"];
    $montanttotalc = 0;
    $montanttotalp = 0;
    $montanttotaln = 0;

    $tabc = array();
    $ic = 0;
    $montantcc = 0;
    $montantpc = 0;
    $montantnc = 0;

    $tabcp = array();
    $icp = 0;
    $montantccp = 0;
    $montantpcp = 0;
    $montantncp = 0;

    $tabvac = array();
    $ivac = 0;
    $montantcvac = 0;
    $montantpvac = 0;
    $montantnvac = 0;

    $tabexa = array();
    $iexa = 0;
    $montantcexa = 0;
    $montantpexa = 0;
    $montantnexa = 0;

    $tabecho = array();
    $iecho = 0;
    $montantcecho = 0;
    $montantpecho = 0;
    $montantnecho = 0;

    $tabordo = array();
    $iordo = 0;
    $montantcordo = 0;
    $montantpordo = 0;
    $montantnordo = 0;

    $taba = array();
    $ia = 0;
    $montantca = 0;
    $montantpa = 0;
    $montantna = 0;

    $tabhos = array();
    $ihos = 0;
    $montantchos = 0;
    $montantphos = 0;
    $montantnhos = 0;

    $rsltcons = $con->query("select *, cast(c.dateconsultation as DATE) as datec from hp_consultation as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.dateconsultation as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    $rsltexa = $con->query("select *, cast(c.dateexamenpatient as DATE) as datec from hp_examen_patient as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.dateexamenpatient as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    $rsltecho = $con->query("select *, cast(c.dateechographiepatient as DATE) as datec from hp_echographie_patient as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.dateechographiepatient as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    $rsltord = $con->query("select *, cast(c.dateordonnance as DATE) as datec from hp_ordonnance as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.dateordonnance as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    $rslthos = $con->query("select *, cast(c.datehospitalisation as DATE) as datec from hp_hospitalisation as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.datehospitalisation as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    while ($rowlbl = mysqli_fetch_assoc($rsltcons)) {

        $rsltuarpa = $con->query("select * from hp_consultation as lc left join hp_acte as f on "
                . "lc.idacte=f.idacte left join hp_service as u on f.idservice=u.idservice where "
                . "lc.idconsultation='" . $rowlbl["idconsultation"] . "'") or die(mysqli_error($con));
        $rowarpa = mysqli_fetch_assoc($rsltuarpa);

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.idconsultation='" . $rowlbl["idconsultation"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["idm"] = $rowarpa["idconsultation"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["servicem"] = $rowarpa["nomservice"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["libellem"] = $rowarpa["libelleacte"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["montantc"] = $rowarpf["montantfacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["montantp"] = $rowarpf["avancefacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

        if (!empty($tabc)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabc as $k => $v) {
                if (($tabc[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabc[$k]["lignefinance"] as $km => $vm) {
                        if (($tabc[$k]["lignefinance"][$km]["libellem"] == $rowarpa["libelleacte"])) {
                            $fm = TRUE;
                            $tabc[$k]["lignefinance"][$km]["montantc"] = $tabc[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                            $tabc[$k]["lignefinance"][$km]["montantp"] = $tabc[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                            $tabc[$k]["lignefinance"][$km]["montantn"] = $tabc[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                        }
                    }

                    if (!$fm) {
                        $tabc[$k]["lignefinance"][$ic]["idm"] = $rowarpa["idconsultation"];
                        $tabc[$k]["lignefinance"][$ic]["servicem"] = $rowarpa["nomservice"];
                        $tabc[$k]["lignefinance"][$ic]["libellem"] = $rowarpa["libelleacte"];
                        $tabc[$k]["lignefinance"][$ic]["montantc"] = $rowarpf["montantfacture"];
                        $tabc[$k]["lignefinance"][$ic]["montantp"] = $rowarpf["avancefacture"];
                        $tabc[$k]["lignefinance"][$ic]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
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
    while ($rowlbl = mysqli_fetch_assoc($rsltexa)) {

        $rsltuarpa = $con->query("select * from hp_examen_patient as lc left join hp_examen as f on lc.idexamen=f.idexamen "
                . "left join hp_laboratoire as l on f.idlaboratoire=l.idlaboratoire left join hp_service as u on "
                . "l.idservice=u.idservice where "
                . "lc.idexamenpatient='" . $rowlbl["idexamenpatient"] . "'") or die(mysqli_error($con));

        $rowarpa = mysqli_fetch_assoc($rsltuarpa);

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.idexamenpatient='" . $rowlbl["idexamenpatient"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $rsltfnp2 = $con->query("select * from hp_facture where idexamenpatient='" . $rowarpa["idexamenpatient"] . "' and "
                . "etatfacture=true ") or die(mysqli_error($con));
        $nbfnp = mysqli_num_rows($rsltfnp2);
        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["idm"] = $rowarpa["idexamenpatient"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["servicem"] = $rowarpa["nomservice"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["libellem"] = $rowarpa["typeexamen"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["montantc"] = $rowarpf["montantfacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["montantp"] = $rowarpf["avancefacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

        if (!empty($tabexa)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabexa as $k => $v) {
                if (($tabexa[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabexa[$k]["lignefinance"] as $km => $vm) {
                        if (($tabexa[$k]["lignefinance"][$km]["libellem"] == $rowarpa["typeexamen"])) {
                            $fm = TRUE;
                            $tabexa[$k]["lignefinance"][$km]["montantc"] = $tabexa[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                            $tabexa[$k]["lignefinance"][$km]["montantp"] = $tabexa[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                            $tabexa[$k]["lignefinance"][$km]["montantn"] = $tabexa[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                        }
                    }

                    if (!$fm) {
                        $tabexa[$k]["lignefinance"][$iexa]["idm"] = $rowarpa["idexamenpatient"];
                        $tabexa[$k]["lignefinance"][$iexa]["servicem"] = $rowarpa["nomservice"];
                        $tabexa[$k]["lignefinance"][$iexa]["libellem"] = $rowarpa["typeexamen"];
                        $tabexa[$k]["lignefinance"][$iexa]["montantc"] = $rowarpf["montantfacture"];
                        $tabexa[$k]["lignefinance"][$iexa]["montantp"] = $rowarpf["avancefacture"];
                        $tabexa[$k]["lignefinance"][$iexa]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
                        $iexa = $iexa + 1;
//                print_r($iexa);
                    }
                }
            }
            if (!$f) {
                $tabexa = array_merge($tabexa, $prodArray);
                $iexa = $iexa + 1;
            }
        } else {
            $tabexa = $prodArray;
            $iexa = $iexa + 1;
        }
    }
    while ($rowlbl = mysqli_fetch_assoc($rsltecho)) {

        $rsltuarpa = $con->query("select * from hp_echographie_patient as ep left join hp_echographie as e on ep.idechographie=e.idechographie "
                . "left join hp_acte as a on e.idacte=a.idacte left join hp_service as s on "
                . "e.idservice=s.idservice where "
                . "ep.idechographiepatient='" . $rowlbl["idechographiepatient"] . "'") or die(mysqli_error($con));

        $rowarpa = mysqli_fetch_assoc($rsltuarpa);

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.idechographiepatient='" . $rowlbl["idechographiepatient"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $rsltfnp2 = $con->query("select * from hp_facture where idechographiepatient='" . $rowarpa["idechographiepatient"] . "' and "
                . "etatfacture=true ") or die(mysqli_error($con));
        $nbfnp = mysqli_num_rows($rsltfnp2);
        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["idm"] = $rowarpa["idechographiepatient"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["servicem"] = "Echographie";
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["libellem"] = $rowarpa["typeechographie"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["montantc"] = $rowarpf["montantfacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["montantp"] = $rowarpf["avancefacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

        if (!empty($tabecho)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabecho as $k => $v) {
                if (($tabecho[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabecho[$k]["lignefinance"] as $km => $vm) {
                        if (($tabecho[$k]["lignefinance"][$km]["libellem"] == $rowarpa["typeechographie"])) {
                            $fm = TRUE;
                            $tabecho[$k]["lignefinance"][$km]["montantc"] = $tabecho[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                            $tabecho[$k]["lignefinance"][$km]["montantp"] = $tabecho[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                            $tabecho[$k]["lignefinance"][$km]["montantn"] = $tabecho[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                        }
                    }

                    if (!$fm) {
                        $tabecho[$k]["lignefinance"][$iecho]["idm"] = $rowarpa["idechographiepatient"];
                        $tabecho[$k]["lignefinance"][$iecho]["servicem"] = "Echographie";
                        $tabecho[$k]["lignefinance"][$iecho]["libellem"] = $rowarpa["typeechographie"];
                        $tabecho[$k]["lignefinance"][$iecho]["montantc"] = $rowarpf["montantfacture"];
                        $tabecho[$k]["lignefinance"][$iecho]["montantp"] = $rowarpf["avancefacture"];
                        $tabecho[$k]["lignefinance"][$iecho]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
                        $iecho = $iecho + 1;
//                print_r($iecho);
                    }
                }
            }
            if (!$f) {
                $tabecho = array_merge($tabecho, $prodArray);
                $iecho = $iecho + 1;
            }
        } else {
            $tabecho = $prodArray;
            $iecho = $iecho + 1;
        }
    }
    while ($rowlbl = mysqli_fetch_assoc($rsltord)) {

        $rsltuarpa = $con->query("select * from hp_ligne_ordonnance as lo left join hp_produit as a on "
                . "lo.idproduit=a.idproduit left join hp_categorie as c on "
                . "a.idcategorie=c.idcategorie where "
                . "lo.idordonnance='" . $rowlbl["idordonnance"] . "'") or die(mysqli_error($con));

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.idordonnance='" . $rowlbl["idordonnance"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        while ($rowarpa = mysqli_fetch_assoc($rsltuarpa)) {
            $rsltua = $con->query("select * from hp_unite where idunite='" . $rowarpa["idunite"] . "'") or die(mysqli_error($con));
            $rowa = mysqli_fetch_assoc($rsltua);

            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["idm"] = $rowarpa["idproduit"];
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["servicem"] = "Pharmacie";
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["libellem"] = $rowarpa["libelleproduit"];
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["montantc"] = $rowarpf["montantfacture"];
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["montantp"] = $rowarpf["avancefacture"];
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

            if (!empty($tabordo)) {
                $f = FALSE;
                $fm = FALSE;
                foreach ($tabordo as $k => $v) {
                    if (($tabordo[$k]["datem"] == $rowlbl["datec"])) {
                        $f = TRUE;
                        foreach ($tabordo[$k]["lignefinance"] as $km => $vm) {
                            if (($tabordo[$k]["lignefinance"][$km]["libellem"] == $rowarpa["libelleproduit"])) {
                                $fm = TRUE;
                                $tabordo[$k]["lignefinance"][$km]["montantc"] = $tabordo[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                                $tabordo[$k]["lignefinance"][$km]["montantp"] = $tabordo[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                                $tabordo[$k]["lignefinance"][$km]["montantn"] = $tabordo[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                            }
                        }

                        if (!$fm) {
                            $tabordo[$k]["lignefinance"][$iordo]["idm"] = $rowarpa["idproduit"];
                            $tabordo[$k]["lignefinance"][$iordo]["servicem"] = "Pharmacie";
                            $tabordo[$k]["lignefinance"][$iordo]["libellem"] = $rowarpa["libelleproduit"];
                            $tabordo[$k]["lignefinance"][$iordo]["montantc"] = $rowarpf["montantfacture"];
                            $tabordo[$k]["lignefinance"][$iordo]["montantp"] = $rowarpf["avancefacture"];
                            $tabordo[$k]["lignefinance"][$iordo]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
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
    }
    while ($rowlbl = mysqli_fetch_assoc($rslthos)) {

        $rsltpl = $con->query("select * from hp_deplacement_patient as dp left join hp_facture as f on "
                . "dp.iddeplacementpatient=f.iddeplacementpatient where dp.idhospitalisation='" . $rowlbl["idhospitalisation"] . "' "
                . "and dp.regledeplacementpatient=false order by dp.datedeplacementpatient desc limit 0,1 ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($rsltpl);

        $rsltpl2 = $con->query("select * from hp_deplacement_patient as dp left join hp_facture as f on "
                . "dp.iddeplacementpatient=f.iddeplacementpatient where dp.idhospitalisation='" . $rowlbl["idhospitalisation"] . "' "
                . "and dp.regledeplacementpatient=false order by dp.datedeplacementpatient desc  limit 0,1") or die(mysqli_error($con));
        $today = date('Y-m-d H:i:s');

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.iddeplacementpatient='" . $rowpl2["iddeplacementpatient"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $dif = dateDiff($rowpl2["datedebutdeplacementpatient"], $today);
        $reqch = $con->query("select * from hp_lit as l left join hp_chambre as c on l.idchambre=c.idchambre "
                . "where l.idlit= '" . $rowpl2["idlit"] . "' ") or die(mysqli_error($con));
        $rowch = mysqli_fetch_assoc($reqch);

        $lib = $rowlbl["datedebuthospitalisation"] . " - " . $rowlbl["datefinhospitalisation"] . "  " . $rowch["codechambre"] . " - " .
                $rowch["codelit"];
        $etar = "Non réglée";
        $etas = "En Cours";
        if ($rowlbl["reglehospitalisation"]) {
            $etar = "Réglée";
        }
        if ($rowlbl["sortiehospitalisation"]) {
            $etas = "Sortie";
        }
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["idm"] = $rowlbl["idhospitalisation"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["servicem"] = "Hospitalisation";
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["libellem"] = $lib;
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["montantc"] = $rowarpf["montantfacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["montantp"] = $rowarpf["avancefacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

        if (!empty($tabhos)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabhos as $k => $v) {
                if (($tabhos[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabhos[$k]["lignefinance"] as $km => $vm) {
                        if (($tabhos[$k]["lignefinance"][$km]["libellem"] == $rowarpa["libelleacte"])) {
                            $fm = TRUE;
                            $tabhos[$k]["lignefinance"][$km]["montantc"] = $tabhos[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                            $tabhos[$k]["lignefinance"][$km]["montantp"] = $tabhos[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                            $tabhos[$k]["lignefinance"][$km]["montantn"] = $tabhos[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                        }
                    }

                    if (!$fm) {
                        $tabhos[$k]["lignefinance"][$ihos]["idm"] = $rowlbl["idhospitalisation"];
                        $tabhos[$k]["lignefinance"][$ihos]["servicem"] = "Hospitalisation";
                        $tabhos[$k]["lignefinance"][$ihos]["libellem"] = $lib;
                        $tabhos[$k]["lignefinance"][$ihos]["montantc"] = $rowarpf["montantfacture"];
                        $tabhos[$k]["lignefinance"][$ihos]["montantp"] = $rowarpf["avancefacture"];
                        $tabhos[$k]["lignefinance"][$ihos]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
                        $ihos = $ihos + 1;
//                print_r($ihos);
                    }
                }
            }
            if (!$f) {
                $tabhos = array_merge($tabhos, $prodArray);
                $ihos = $ihos + 1;
            }
        } else {
            $tabhos = $prodArray;
            $ihos = $ihos + 1;
        }
    }
    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Finances du <?php echo $dated ?> au <?php echo $datef ?></h1>
                                <a href="hopitalpages/hopitalfinance/print_finance_p_pdf.php?dated=<?php echo $dated ?>&datef=<?php echo $datef ?>" class="btn btn-lg btn-success" target="_blank">
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
                                        <tr style=" background: #cbcaca;"> 
                                            <th style="width: 15%;text-align: center; border: solid 1px;">Date</th>
                                            <th style="width: 25%;text-align: center; border: solid 1px;">Objet</th>
                                            <th style="width: 20%;text-align: center; border: solid 1px;">Finance total</th>
                                            <th style="width: 20%;text-align: center; border: solid 1px;">Finance r&eacute;gl&eacute;e</th>
                                            <th style="width: 20%;text-align: center; border: solid 1px;">Finance non r&eacute;gl&eacute;e</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($ic != 0) {
                                            ?>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">Concultation</td>
                                                <td style="width: 25%;text-align: center; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: center; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: center; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: center; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                            foreach ($tabc as $prod) {
//                            print_r($prod);
                                                foreach ($prod["lignefinance"] as $prodm) {
                                                    ?>
                                                    <tr >
                                                        <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                                        <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                                                    </tr>
                                                    <?php
                                                    $montantcc = $montantcc + $prodm["montantc"];
                                                    $montantpc = $montantpc + $prodm["montantp"];

                                                    $montanttotalc = $montanttotalc + $prodm["montantc"];
                                                    $montanttotalp = $montanttotalp + $prodm["montantp"];
                                                }
                                            }
                                            $montantnc = $montantcc - $montantpc;
                                            ?>
                                            <tr style="background-color: #eee">
                                                <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Concultation</td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantcc, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantpc, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnc, 0, ',', ' '); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%;text-align: right; border: solid 1px;">&nbsp;</td>
                                                <td style="width: 25%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($iexa != 0) {
                                            ?>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">Examen</td>
                                                <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                            foreach ($tabexa as $prod) {
//                            print_r($prod);
                                                foreach ($prod["lignefinance"] as $prodm) {
                                                    ?>
                                                    <tr >
                                                        <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                                        <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                                                    </tr>
                                                    <?php
                                                    $montantcexa = $montantcexa + $prodm["montantc"];
                                                    $montantpexa = $montantpexa + $prodm["montantp"];

                                                    $montanttotalc = $montanttotalc + $prodm["montantc"];
                                                    $montanttotalp = $montanttotalp + $prodm["montantp"];
                                                }
                                            }
                                            $montantnexa = $montantcexa - $montantpexa;
                                            ?>
                                            <tr style="background-color: #eee">
                                                <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Examen</td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantcexa, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantpexa, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnexa, 0, ',', ' '); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                                                <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($iecho != 0) {
                                            ?>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">Echographie</td>
                                                <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                            foreach ($tabecho as $prod) {
//                            print_r($prod);
                                                foreach ($prod["lignefinance"] as $prodm) {
                                                    ?>
                                                    <tr >
                                                        <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                                        <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                                                    </tr>
                                                    <?php
                                                    $montantcecho = $montantcecho + $prodm["montantc"];
                                                    $montantpecho = $montantpecho + $prodm["montantp"];

                                                    $montanttotalc = $montanttotalc + $prodm["montantc"];
                                                    $montanttotalp = $montanttotalp + $prodm["montantp"];
                                                }
                                            }
                                            $montantnecho = $montantcecho - $montantpecho;
                                            ?>
                                            <tr style="background-color: #eee">
                                                <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Echographie</td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantcecho, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantpecho, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnecho, 0, ',', ' '); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                                                <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($iordo != 0) {
                                            ?>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">Ordonance</td>
                                                <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                            foreach ($tabordo as $prod) {
//                            print_r($prod);
                                                foreach ($prod["lignefinance"] as $prodm) {
                                                    ?>
                                                    <tr >
                                                        <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                                        <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                                                    </tr>
                                                    <?php
                                                    $montantcordo = $montantcordo + $prodm["montantc"];
                                                    $montantpordo = $montantpordo + $prodm["montantp"];

                                                    $montanttotalc = $montanttotalc + $prodm["montantc"];
                                                    $montanttotalp = $montanttotalp + $prodm["montantp"];
                                                }
                                            }
                                            $montantnordo = $montantcordo - $montantpordo;
                                            ?>
                                            <tr style="background-color: #eee">
                                                <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Ordonance</td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantcordo, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantpordo, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnordo, 0, ',', ' '); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                                                <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($ihos != 0) {
                                            ?>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">Hospitalisation</td>
                                                <td style="width: 22%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                            foreach ($tabhos as $prod) {
//                            print_r($prod);
                                                foreach ($prod["lignefinance"] as $prodm) {
                                                    ?>
                                                    <tr >
                                                        <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                                        <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                                                    </tr>
                                                    <?php
                                                    $montantchos = $montantchos + $prodm["montantc"];
                                                    $montantphos = $montantphos + $prodm["montantp"];

                                                    $montanttotalc = $montanttotalc + $prodm["montantc"];
                                                    $montanttotalp = $montanttotalp + $prodm["montantp"];
                                                }
                                            }
                                            $montantnhos = $montantchos - $montantphos;
                                            ?>
                                            <tr style="background-color: #eee">
                                                <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Hospitalisation</td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantchos, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantphos, 0, ',', ' '); ?></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnhos, 0, ',', ' '); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                                                <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                                <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        <tr>
                                            <td style="width: 15%;text-align: right; border: solid 1px;">&nbsp;</td>
                                            <td style="width: 25%;text-align: right; border: solid 1px;"></td>
                                            <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                            <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                                        </tr>
                                        <?php
                                        $montanttotaln = $montanttotalc - $montanttotalp;
                                        ?>
                                        <tr style="background-color: #eee">
                                            <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Finance</td>
                                            <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montanttotalc, 0, ',', ' '); ?></td>
                                            <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montanttotalp, 0, ',', ' '); ?></td>
                                            <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montanttotaln, 0, ',', ' '); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <a href="hopitalpages/hopitalfinance/print_finance_p_pdf.php?dated=<?php echo $dated ?>&datef=<?php echo $datef ?>" class="btn btn-lg btn-success" target="_blank">
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
