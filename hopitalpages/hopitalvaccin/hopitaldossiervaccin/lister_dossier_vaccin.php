<?php
if ((isset($_REQUEST["idvaccin"]))) {
//    $dated = $_POST["datedcp"];
//    $datef = $_POST["datefcp"];
    $id = $_REQUEST["idvaccin"];
    $req_fin = $con->query("select * from hp_vaccin as p where p.idvaccin='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $tab = array();
    $j = 0;
    $i = 0;


    $rsltcons = $con->query("select *, cast(c.datejouradministrationvaccin as DATE) as datec from hp_administration_vaccin as c "
            . "where c.idvaccin='" . $row["idvaccin"] . "' order by datec desc") or die(mysqli_error($con));

    $rsltexa = $con->query("select *, cast(c.datejourrendezvousvaccin as DATE) as datec from hp_rendez_vous_vaccin as c "
            . "where c.idvaccin='" . $row["idvaccin"] . "' order by datec desc") or die(mysqli_error($con));

    while ($rowlbl = mysqli_fetch_assoc($rsltcons)) {

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignedossier' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["idm"] = $rowlbl["idadministrationvaccin"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["typem"] = "Administration";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["dateexe"] = $rowlbl["datejouradministrationvaccin"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["libellem"] = $rowlbl["vaccinadministrationvaccin"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["masse"] = $rowlbl["masseadministrationvaccin"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["taille"] = $rowlbl["tailleadministrationvaccin"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["ctete"] = $rowlbl["circonferenceteteadministrationvaccin"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["cbras"] = $rowlbl["circonferencebrasadministrationvaccin"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    if (!$fm) {
                        $tab[$k]["lignedossier"][$i]["idm"] = $rowlbl["idadministrationvaccin"];
                        $tab[$k]["lignedossier"][$i]["typem"] = "Administration";
                        $tab[$k]["lignedossier"][$i]["dateexe"] = $rowlbl["datejouradministrationvaccin"];
                        $tab[$k]["lignedossier"][$i]["libellem"] = $rowlbl["vaccinadministrationvaccin"];
                        $tab[$k]["lignedossier"][$i]["masse"] = $rowlbl["masseadministrationvaccin"];
                        $tab[$k]["lignedossier"][$i]["taille"] = $rowlbl["tailleadministrationvaccin"];
                        $tab[$k]["lignedossier"][$i]["ctete"] = $rowlbl["circonferenceteteadministrationvaccin"];
                        $tab[$k]["lignedossier"][$i]["cbras"] = $rowlbl["circonferencebrasadministrationvaccin"];

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

    while ($rowlbl = mysqli_fetch_assoc($rsltexa)) {

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignedossier' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["idm"] = $rowlbl["idrendezvousvaccin"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["typem"] = "Rendez-vous";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["dateexe"] = $rowlbl["dateexecutionrendezvousvaccin"];
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["libellem"] = "";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["masse"] = "";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["taille"] = "";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["ctete"] = "";
        $prodArray[$rowlbl["datec"]]["lignedossier"][$i]["cbras"] = "";

        if (!empty($tab)) {
            $f = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;

                    $tab[$k]["lignedossier"][$i]["idm"] = $rowlbl["idrendezvousvaccin"];
                    $tab[$k]["lignedossier"][$i]["typem"] = "Rendez-vous";
                    $tab[$k]["lignedossier"][$i]["dateexe"] = $rowlbl["dateexecutionrendezvousvaccin"];
                    $tab[$k]["lignedossier"][$i]["libellem"] = "";
                    $tab[$k]["lignedossier"][$i]["masse"] = "";
                    $tab[$k]["lignedossier"][$i]["taille"] = "";
                    $tab[$k]["lignedossier"][$i]["ctete"] = "";
                    $tab[$k]["lignedossier"][$i]["cbras"] = "";
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
                                    <?php echo $row["numerovaccin"]; ?> <?php echo $row["nomvaccin"]; ?>
                                </h1>
                            </div>
                        </div>

                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                            <thead>
                                <tr>
                                    <th data-field="state" data-checkbox="true"></th>
                                    <th>Date</th>
                                    <th>But</th>
                                    <th>Libell&eacute;</th>
                                    <th>date ex&eacute;cution</th>
                                    <th>Masse</th>
                                    <th>Taille</th>
                                    <th>Circonf&eacute;rence t&ecirc;te</th>
                                    <th>Circonf&eacute;rence bras</th>
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
                                            <td><?php print nl2br(htmlspecialchars($prodm["typem"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["dateexe"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["masse"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["taille"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["ctete"])) ?></td>
                                            <td><?php print nl2br(htmlspecialchars($prodm["cbras"])) ?></td>
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