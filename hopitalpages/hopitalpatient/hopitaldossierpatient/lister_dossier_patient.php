<?php
if ((isset($_REQUEST["idpatient"]))) {
//    $dated = $_POST["datedcp"];
//    $datef = $_POST["datefcp"];
    $id = $_REQUEST["idpatient"];
    $req_fin = $con->query("select * from hp_patient as p left join hp_dossier as d on p.idpatient=d.idpatient "
            . "where p.idpatient='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $tab = array();
    $j = 0;
    $i = 0;


    $rsltcons = $con->query("select *, cast(c.dateconsultation as DATE) as datec from hp_consultation as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "sd.iddossier='" . $row["iddossier"] . "' order by datec desc") or die(mysqli_error($con));

    $rsltexa = $con->query("select *, cast(c.dateexamenpatient as DATE) as datec from hp_examen_patient as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "sd.iddossier='" . $row["iddossier"] . "' order by datec desc") or die(mysqli_error($con));

    $rsltecho = $con->query("select *, cast(c.dateechographiepatient as DATE) as datec from hp_echographie_patient as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "sd.iddossier='" . $row["iddossier"] . "' order by datec desc") or die(mysqli_error($con));

    $rsltord = $con->query("select *, cast(c.dateordonnance as DATE) as datec from hp_ordonnance as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "sd.iddossier='" . $row["iddossier"] . "' order by datec desc") or die(mysqli_error($con));

    $rslthos = $con->query("select *, cast(c.datehospitalisation as DATE) as datec from hp_hospitalisation as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "sd.iddossier='" . $row["iddossier"] . "' order by datec desc") or die(mysqli_error($con));

    while ($rowlbl = mysqli_fetch_assoc($rsltcons)) {

        $rsltuarpa = $con->query("select * from hp_consultation as lc left join hp_acte as f on "
                . "lc.idacte=f.idacte left join hp_service as u on f.idservice=u.idservice where "
                . "lc.idconsultation='" . $rowlbl["idconsultation"] . "'") or die(mysqli_error($con));

        $rowarpa = mysqli_fetch_assoc($rsltuarpa);

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignedossier' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["idm"] = $rowarpa["idconsultation"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["typem"] = "Consultation";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["servicem"] = $rowarpa["nomservice"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["libellem"] = $rowarpa["libelleacte"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = $rowarpa["etatconsultation"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["butm"] = $rowarpa["butconsultation"];

        if (!empty($tab)) {
            $f = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;

                    $tab[$k]["lignedossier"][$i]["idm"] = $rowarpa["idconsultation"];
                    $tab[$k]["lignedossier"][$i]["typem"] = "Consultation";
                    $tab[$k]["lignedossier"][$i]["servicem"] = $rowarpa["nomservice"];
                    $tab[$k]["lignedossier"][$i]["libellem"] = $rowarpa["libelleacte"];
                    $tab[$k]["lignedossier"][$i]["etatm"] = $rowarpa["etatconsultation"];
                    $tab[$k]["lignedossier"][$i]["butm"] = $rowarpa["butconsultation"];
                    $i = $i + 1;
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
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
                'lignedossier' => array()
        ));

        $rowpl2 = mysqli_fetch_assoc($rsltpl2);
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
        $rsltuarpa = $con->query("select * from hp_soin_patient as lo left join hp_soin as a on "
                . "lo.idsoin=a.idsoin where lo.idhospitalisation='" . $rowlbl["idhospitalisation"] . "'") or die(mysqli_error($con));

        while ($rowarpa = mysqli_fetch_assoc($rsltuarpa)) {

            $eta = "Non adminitré";
            if (!$rowarpa["etatsoinpatient"]) {
                $eta = "Adminitré";
            }
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["idm"] = $rowarpa["idsoinpatient"];
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["typem"] = "Hospitalisation";
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["servicem"] = "Hospitalisation";
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["libellem"] = $rowarpa["datejoursoinpatient"] . " " . $rowarpa["heuresoinpatient"] . " " . $rowarpa["libellesoin"];
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = $eta;
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["butm"] = "Hospitalisation " . $lib;

            if (!empty($tab)) {
                $f = FALSE;
                $fm = FALSE;
                foreach ($tab as $k => $v) {
                    if (($tab[$k]["datem"] == $rowlbl["datec"])) {
                        $f = TRUE;
                        if (!$fm) {
                            $tab[$k]["lignedossier"][$i]["idm"] = $rowarpa["idsoinpatient"];
                            $tab[$k]["lignedossier"][$i]["typem"] = "Hospitalisation";
                            $tab[$k]["lignedossier"][$i]["servicem"] = "Hospitalisation";
                            $tab[$k]["lignedossier"][$i]["libellem"] = $rowarpa["datejoursoinpatient"] . " " . $rowarpa["heuresoinpatient"] . " " . $rowarpa["libellesoin"];
                            $tab[$k]["lignedossier"][$i]["etatm"] = $eta;
                            $tab[$k]["lignedossier"][$i]["butm"] = "Hospitalisation " . $lib;
                            $i = $i + 1;
//                print_r($i);
                        }
                    }
                }
                if (!$f) {
                    $tab = array_merge($tab, $prodArray);
                    $i = $i + 1;
                }
            } else {
                $tab = $prodArray;
                $i = $i + 1;
            }
        }
    }
    while ($rowlbl = mysqli_fetch_assoc($rsltexa)) {

        $rsltuarpa = $con->query("select * from hp_examen_patient as lc left join hp_examen as f on lc.idexamen=f.idexamen "
                . "left join hp_laboratoire as l on f.idlaboratoire=l.idlaboratoire left join hp_service as u on "
                . "l.idservice=u.idservice where "
                . "lc.idexamenpatient='" . $rowlbl["idexamenpatient"] . "'") or die(mysqli_error($con));

        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
        $rsltfnp2 = $con->query("select * from hp_facture where idexamenpatient='" . $rowarpa["idexamenpatient"] . "' and "
                . "etatfacture=true ") or die(mysqli_error($con));
        $nbfnp = mysqli_num_rows($rsltfnp2);
        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignedossier' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["idm"] = $rowarpa["idexamenpatient"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["typem"] = "Examen";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["servicem"] = $rowarpa["nomservice"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["libellem"] = $rowarpa["typeexamen"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = "En Cours";
        if ($nbfnp != 0) {
            if (!$rowarpa["etatexamenpatient"]) {
                $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = "Payé";
            } else {
                $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = "Réalisé";
            }
        } else {
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = "Impayé";
        }
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["butm"] = $rowarpa["butexamenpatient"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    if (!$fm) {
                        $tab[$k]["lignedossier"][$i]["idm"] = $rowarpa["idexamenpatient"];
                        $tab[$k]["lignedossier"][$i]["typem"] = "Examen";
                        $tab[$k]["lignedossier"][$i]["servicem"] = $rowarpa["nomservice"];
                        $tab[$k]["lignedossier"][$i]["libellem"] = $rowarpa["typeexamen"];
                        $tab[$k]["lignedossier"][$i]["etatm"] = "En Cours";
                        if ($nbfnp != 0) {
                            if (!$rowarpa["etatexamenpatient"]) {
                                $tab[$k]["lignedossier"][$i]["etatm"] = "Payé";
                            } else {
                                $tab[$k]["lignedossier"][$i]["etatm"] = "Réalisé";
                            }
                        } else {
                            $tab[$k]["lignedossier"][$i]["etatm"] = "Impayé";
                        }
                        $tab[$k]["lignedossier"][$i]["butm"] = $rowarpa["butexamenpatient"];
                        $i = $i + 1;
//                print_r($i);
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }
    while ($rowlbl = mysqli_fetch_assoc($rsltecho)) {

        $rsltuarpa = $con->query("select * from hp_echographie_patient as ep left join hp_echographie as e on ep.idechographie=e.idechographie "
                . "left join hp_acte as a on e.idacte=a.idacte left join hp_service as s on "
                . "e.idservice=s.idservice where "
                . "ep.idechographiepatient='" . $rowlbl["idechographiepatient"] . "'") or die(mysqli_error($con));

        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
        $rsltfnp2 = $con->query("select * from hp_facture where idechographiepatient='" . $rowarpa["idechographiepatient"] . "' and "
                . "etatfacture=true ") or die(mysqli_error($con));
        $nbfnp = mysqli_num_rows($rsltfnp2);
        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignedossier' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["idm"] = $rowarpa["idechographiepatient"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["typem"] = "Echographie";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["servicem"] = "Echographie";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["libellem"] = $rowarpa["typeechographie"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = "En Cours";
        if ($nbfnp != 0) {
            if (!$rowarpa["etatechographiepatient"]) {
                $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = "Payé";
            } else {
                $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = "Réalisé";
            }
        } else {
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = "Impayé";
        }
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["butm"] = $rowarpa["butechographiepatient"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    if (!$fm) {
                        $tab[$k]["lignedossier"][$i]["idm"] = $rowarpa["idechographiepatient"];
                        $tab[$k]["lignedossier"][$i]["typem"] = "Echographie";
                        $tab[$k]["lignedossier"][$i]["servicem"] = "Echographie";
                        $tab[$k]["lignedossier"][$i]["libellem"] = $rowarpa["typeechographie"];
                        $tab[$k]["lignedossier"][$i]["etatm"] = "En Cours";
                        if ($nbfnp != 0) {
                            if (!$rowarpa["etatechographiepatient"]) {
                                $tab[$k]["lignedossier"][$i]["etatm"] = "Payé";
                            } else {
                                $tab[$k]["lignedossier"][$i]["etatm"] = "Réalisé";
                            }
                        } else {
                            $tab[$k]["lignedossier"][$i]["etatm"] = "Impayé";
                        }
                        $tab[$k]["lignedossier"][$i]["butm"] = $rowarpa["butechographiepatient"];
                        $i = $i + 1;
//                print_r($i);
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }
    while ($rowlbl = mysqli_fetch_assoc($rsltord)) {

        $rsltuarpa = $con->query("select * from hp_ligne_ordonnance as lo left join hp_produit as a on "
                . "lo.idproduit=a.idproduit left join hp_categorie as c on "
                . "a.idcategorie=c.idcategorie where "
                . "lo.idordonnance='" . $rowlbl["idordonnance"] . "'") or die(mysqli_error($con));

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignedossier' => array()
        ));

        while ($rowarpa = mysqli_fetch_assoc($rsltuarpa)) {
            $rsltua = $con->query("select * from hp_unite where idunite='" . $rowarpa["idunite"] . "'") or die(mysqli_error($con));
            $rowa = mysqli_fetch_assoc($rsltua);
            $lib = $rowarpa["stockligneordonnance"] . " " . $rowa["codeunite"] . " de " . $rowarpa["libelleproduit"];

            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["idm"] = $rowarpa["idproduit"];
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["typem"] = "Ordonance";
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["servicem"] = "Pharmacie";
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["libellem"] = $lib;
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["etatm"] = $rowarpa["etatligneordonnance"];
            $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["butm"] = "Ordonance";

            if (!empty($tab)) {
                $f = FALSE;
                $fm = FALSE;
                foreach ($tab as $k => $v) {
                    if (($tab[$k]["datem"] == $rowlbl["datec"])) {
                        $f = TRUE;
                        if (!$fm) {
                            $tab[$k]["lignedossier"][$i]["idm"] = $rowarpa["idproduit"];
                            $tab[$k]["lignedossier"][$i]["typem"] = "Ordonance";
                            $tab[$k]["lignedossier"][$i]["servicem"] = "Pharmacie";
                            $tab[$k]["lignedossier"][$i]["libellem"] = $lib;
                            $tab[$k]["lignedossier"][$i]["etatm"] = $rowarpa["etatligneordonnance"];
                            $tab[$k]["lignedossier"][$i]["butm"] = "Ordonance";
                            $i = $i + 1;
//                print_r($i);
                        }
                    }
                }
                if (!$f) {
                    $tab = array_merge($tab, $prodArray);
                    $i = $i + 1;
                }
            } else {
                $tab = $prodArray;
                $i = $i + 1;
            }
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

                                <h1>
                                    Dossier de 
                                    <?php echo $row["codepatient"]; ?> <?php echo $row["nompatient"]; ?> <?php
                                    echo $row["prenompatient"];
                                    ?>
                                </h1>
                            </div>
                        </div>

                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                            <thead>
                                <tr>
                                    <th data-field="state" data-checkbox="true"></th>
                                    <th>Date</th>
                                    <th>Service</th>
                                    <th>Libell&eacute;</th>
                                    <th>But</th>
                                    <th>Etat</th>
                                    <th>Op&eacute;ration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($tab as $prod) {
//                            print_r($prod);
                                    foreach ($prod["lignedossier"] as $prodm) {
                                        ?>
                                        <tr >
                                            <td></td>
                                            <td><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["servicem"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["butm"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["etatm"])) ?></td>
                                            <td>
                                                <?php
                                                if ($prodm["typem"] == "Hospitalisation") {
                                                    if ($prodm["etatm"] == "Non adminitré") {
                                                        if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Caisse")))) {
                                                            ?> 
<!--                                                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsoin/hopitalediter/edit_soin') ?>&idsoinpatient=<?php echo $prodm["idm"] ?>">
                                                                <span title="modifier ce soin" alt="edit"><i class="glyphicon glyphicon-edit"></i></span>
                                                            </a>&nbsp;&nbsp; -->
                                                            <?php
                                                        }
                                                        if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Infirmier")))) {
                                                            ?> 
                                                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsoin/hopitaladministrer/ajout_soin') ?>&idsoinpatient=<?php echo $prodm["idm"] ?>">
                                                                <span title="Administrer ce soin" alt="diag"><i class="glyphicon glyphicon-check"></i></span>
                                                            </a>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?> 
                    <!--                                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/dossier_patient') ?>&idconsultation=<?php echo $prodm["idm"] ?>">
                                                            <span title="Afficher le d&eacute;tail de cette consultation" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                                        </a>-->
                                                        <?php
                                                    }
                                                }
                                                if (($prodm["typem"] == "Consultation") || ($prodm["typem"] == "Hospitalisation")) {
                                                    ?>
                                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/ajout_parametre_patient') ?>&idconsultation=<?php echo $prodm["idm"] ?>">
                                                        <span title="ajouter les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-bookmark"></i></span>
                                                    </a>&nbsp;&nbsp;
                                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/lister_parametre_patient') ?>&idconsultation=<?php echo $prodm["idm"] ?>">
                                                        <span title="lister les parametres de ce patient" alt="ajouter"><i class="glyphicon glyphicon-list-alt"></i></span>
                                                    </a>&nbsp;&nbsp;
                                                    <?php
                                                }
                                                if ((isset($_SESSION["rolepersonnel"])) && ($_SESSION["rolepersonnel"] != "Infirmier") && ($_SESSION["rolepersonnel"] != "Accueil")) {
                                                    if ($prodm["typem"] == "Consultation") {
                                                        if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin")))) {
                                                            if ($prodm["etatm"] == "En Cours") {
                                                                ?> 
                                                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation') ?>&idconsultation=<?php echo $prodm["idm"] ?>">
                                                                    <span title="diagnostiquer cette consultation" alt="diag"><i class="glyphicon glyphicon-plus"></i></span>
                                                                </a>
                                                                <?php
                                                            } else {
                                                                ?> 
                                                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/dossier_patient') ?>&idconsultation=<?php echo $prodm["idm"] ?>">
                                                                    <span title="Afficher le d&eacute;tail de cette consultation" alt="diag"><i class="glyphicon glyphicon-list-alt"></i></span>
                                                                </a>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    if ($prodm["typem"] == "Examen") {
                                                        $rsltfnp = $con->query("select * from hp_examen_patient as lc left join hp_examen as f on lc.idexamen=f.idexamen "
                                                                . "left join hp_laboratoire as l on f.idlaboratoire=l.idlaboratoire left join hp_service as u on "
                                                                . "l.idservice=u.idservice where idexamenpatient='" . $prodm["idm"] . "' ") or die(mysqli_error($con));

                                                        $recfnp = mysqli_fetch_assoc($rsltfnp);
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
                                                    if ($prodm["typem"] == "Echographie") {
                                                        $rsltfnp = $con->query("select * from hp_echographie_patient as ep left join hp_echographie as e on ep.idechographie=e.idechographie "
                                                                . "left join hp_acte as a on e.idacte=a.idacte left join hp_service as s on "
                                                                . "e.idservice=s.idservice where idechographiepatient='" . $prodm["idm"] . "' ") or die(mysqli_error($con));

                                                        $recfnp = mysqli_fetch_assoc($rsltfnp);
                                                        if ($recfnp["typeechographie"] == "Obstétricale 2 3") {
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
                                                        } else if ($recfnp["typeechographie"] == "Obstétricale 1") {
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
                                                }
                                                if ($prodm["typem"] == "Ordonance") {
                                                    
                                                }
                                                ?> 
                                            </td>
                                        </tr>
            <?php
        }
    }
    ?>
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>
        </div>       
    </div>
    <?php
}
?>