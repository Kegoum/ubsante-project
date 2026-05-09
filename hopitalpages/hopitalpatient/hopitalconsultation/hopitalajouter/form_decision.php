<script>

    $(document).ready(function () {
//        choixDecision(document.formconsultation.decision.value);
    });
    function CocheTout(ref, name) {
        var form = ref;

        while (form.parentNode && form.nodeName.toLowerCase() != 'form') {
            form = form.parentNode;
        }

        var elements = form.getElementsByTagName('input');

        for (var i = 0; i < elements.length; i++) {
            if (elements[i].type == 'checkbox' && elements[i].name == name) {
                elements[i].checked = ref.checked;
            }
        }
    }

</script>
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>
                                    Consultation de : <?php
                                    echo $row["codepatient"];
                                    ?> <?php echo $row["nompatient"]; ?> <?php
                                    echo $row["prenompatient"];
                                    ?>
                                </h1>

                                <!--<div class="alert alert-info"><em style="color: #FC331C">Veuillez cocher les lignes a remplir</em></div>-->
                            </div>
                        </div>
                        <!--<form id="ajout_param" name="formconsultation" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">-->
                        <?php
                        if ($_SESSION['formconsultation'][2]["decisionexamen"]) {
                            ?>
                            Examen
                            <!-- Static Table Start -->
                            <div class="data-table-area mg-b-15" id="divprod">

                                <?php
                                $_SESSION["session_prodsexa" . $idc] = 0;
                                if (!empty($_SESSION["cart_prodvexa" . $idc])) {
//        $_SESSION["session_prodsexa".$idc] = count($_SESSION["cart_prodvexa".$idc]);
                                    foreach ($_SESSION["cart_prodvexa" . $idc] as $k => $v) {
                                        $_SESSION["session_prodsexa" . $idc] = $_SESSION["session_prodsexa" . $idc] + $_SESSION["cart_prodvexa" . $idc][$k]["qteart"];
                                    }
                                }
                                $rslte = $con->query("select * from hp_examen as a left join hp_unite as u on a.idunite=u.idunite ")
                                        or die(mysqli_error($con));
                                ?>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                            <div class="sparkline13-list">
                                                <div class="sparkline13-hd">
                                                    <div class="main-sparkline13-hd">
                                                        <h1>Liste <span class="table-project-n">des Examens</span></h1>
                                                    </div>
                                                </div>
                                                <div class="sparkline13-graph">
                                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                                               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <!--<input onclick="CocheTout(this, 'tprod[]');" type="checkbox" />--> 
                                                                        D&eacute;signation
                                                                    </th>
                                                                    <th>Op&eacute;ration</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($rslte)) {
                                                                    ?>
                                                                    <!--<form method="post" name="frmCartAddp" id="frmCartAddp" action="" >-->

                                                                    <tr>

                                                                        <td><?php print nl2br(htmlspecialchars($row["nomexamen"])) ?></td>

                                                                        <td>
                                                                            <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->
                                                                            <!--                                                                                <a href="" class="add-to-cart btn btn-primary btn-xs" style="color: white;" type="submit">
                                                                                                                                                                Ajouter
                                                                                                                                                            </a>-->
                                                                            <div class="input-group-btn">
                                                                                <a  type="submit" name="envoiexamenpanier" href="<?php echo $url ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajouter_panier_examen') ?>&actionp=add&idp=<?php echo $row["idexamen"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" title="Ajouter ce examen dans l'examen" class="btn-xs btn-primary" style="color: white;" >
                                                                                    <i class="glyphicon glyphicon-plus"></i> Ajouter
                                                                                </a>
                                                                            </div>

                                                                        </td>
                                                                    </tr>
                                                                    <!--</form>-->
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 well">
                                            <span class="badge b">
                                                <?php
                                                if (isset($_SESSION["session_prodsexa" . $idc])) {
                                                    echo $_SESSION["session_prodsexa" . $idc];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </span><br>
                                            <?php
                                            include("hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/panier_menu_examen.php");
                                            ?>
                                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Static Table End -->
                            <?php
                        }
                        if ($_SESSION['formconsultation'][2]["decisionordonnance"]) {
                            ?>
                            Ordonnance
                            <!-- Static Table Start -->
                            <div class="data-table-area mg-b-15" id="divprod">

                                <?php
                                $_SESSION["session_prodsord" . $idc] = 0;
                                if (!empty($_SESSION["cart_prodvord" . $idc])) {
//        $_SESSION["session_prodsord".$idc] = count($_SESSION["cart_prodvord".$idc]);
                                    foreach ($_SESSION["cart_prodvord" . $idc] as $k => $v) {
                                        $_SESSION["session_prodsord" . $idc] = $_SESSION["session_prodsord" . $idc] + $_SESSION["cart_prodvord" . $idc][$k]["qteart"];
                                    }
                                }
                                $rslt = $con->query("select * from hp_produit as a left join hp_categorie as c on a.idcategorie=c.idcategorie left join hp_unite as u on a.uniteventeproduit=u.idunite ")
                                        or die(mysqli_error($con));
                                ?>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                            <div class="sparkline13-list">
                                                <div class="sparkline13-hd">
                                                    <div class="main-sparkline13-hd">
                                                        <h1>Liste <span class="table-project-n">des Produits</span></h1>
                                                    </div>
                                                </div>
                                                <div class="sparkline13-graph">
                                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                                               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <!--<input onclick="CocheTout(this, 'tprod[]');" type="checkbox" />--> 
                                                                        D&eacute;signation
                                                                    </th>
    <!--                                                                    <th>Quantit&eacute;</th>
                                                                    <th>Unit&eacute;</th>-->
                                                                    <th>Op&eacute;ration</th>
                                                                    <th>Cat&eacute;gorie</th>
                                                                    <th>Stock Magasin</th>
                                                                    <th>Stock Pharmacie</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($rslt)) {
                                                                    $rsltm = $con->query("select SUM(mb.stockboutique) as stock from hp_boutique as mb left join hp_produit as a on "
                                                                            . "mb.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
                                                                            . "mb.idproduit='" . $row["idproduit"] . "' group by mb.idproduit") or die(mysqli_error($con));
                                                                    $nbm = mysqli_num_rows($rsltm);
                                                                    ?>
                                                                    <!--<form method="post" name="frmCartAddp" id="frmCartAddp" action="" >-->

                                                                    <tr>

                                                                        <td><?php print nl2br(htmlspecialchars($row["libelleproduit"])) ?></td>

                                                                        <td>
                                                                            <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->
                                                                            <!--                                                                                <a href="" class="add-to-cart btn btn-primary btn-xs" style="color: white;" type="submit">
                                                                                                                                                                Ajouter
                                                                                                                                                            </a>-->
                                                                            <div class="input-group-btn">
                                                                                <a  type="submit" name="envoiproduitpanier" href="<?php echo $url ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajouter_panier_ordonnance') ?>&actionp=add&idp=<?php echo $row["idproduit"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" title="Ajouter ce produit dans l'ordonnance" class="btn-xs btn-primary" style="color: white;" >
                                                                                    <i class="glyphicon glyphicon-plus"></i> Ajouter
                                                                                </a>
                                                                            </div>

                                                                        </td>
                                                                        <td><?php print nl2br(htmlspecialchars($row["libellecategorie"])) ?></td>
                                                                        <td>
                                                                            <?php print nl2br(htmlspecialchars($row["stockproduit"])); ?>
                                                                            <?php
                                                                            $rsltua = $con->query("select * from hp_unite where idunite='" . $row["uniteachatproduit"] . "'") or die(mysqli_error($con));
                                                                            $rowa = mysqli_fetch_assoc($rsltua);
                                                                            print nl2br(htmlspecialchars($rowa["codeunite"]));
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if ($nbm != 0) {
                                                                                $rowm = mysqli_fetch_assoc($rsltm);
                                                                                ?>
                                                                                <b>
                                                                                    <?php
                                                                                    print nl2br(htmlspecialchars($rowm["stock"]));
                                                                                    ?>
                                                                                </b> 
                                                                                <?php
                                                                                $rsltuv = $con->query("select * from hp_unite where idunite='" . $row["uniteventeproduit"] . "'") or die(mysqli_error($con));
                                                                                $rowv = mysqli_fetch_assoc($rsltuv);
                                                                                print nl2br(htmlspecialchars($rowv["codeunite"]));
                                                                            }
                                                                            ?> <?php
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <!--</form>-->
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 well">
                                            <span class="badge b">
                                                <?php
                                                if (isset($_SESSION["session_prodsord" . $idc])) {
                                                    echo $_SESSION["session_prodsord" . $idc];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </span><br>
                                            <?php
                                            include("hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/panier_menu_ordonnance.php");
                                            ?>
                                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Static Table End -->
                            <?php
                        }
                        if ($_SESSION['formconsultation'][2]["decisionhospitalisation"]) {
                            ?>
                            Hospitalisation
                            <br>
                            <!-- Static Table Start -->
                            <div class="data-table-area mg-b-15" id="divprod">

                                <?php
                                $_SESSION["session_prodshos" . $idc] = 0;
                                if (!empty($_SESSION["cart_prodvhos" . $idc])) {
//        $_SESSION["session_prodshos".$idc] = count($_SESSION["cart_prodvhos".$idc]);
                                    foreach ($_SESSION["cart_prodvhos" . $idc] as $k => $v) {
                                        $_SESSION["session_prodshos" . $idc] = $_SESSION["session_prodshos" . $idc] + $_SESSION["cart_prodvhos" . $idc][$k]["qteart"];
                                    }
                                }
                                $rslts = $con->query("select * from hp_soin as a where etatsoin=true ") or die(mysqli_error($con));
                                ?>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="sparkline13-list">
                                                <div class="sparkline13-hd">
                                                    <div class="main-sparkline13-hd">
                                                        <h1>Liste <span class="table-project-n">des Soins</span></h1>
                                                    </div>
                                                </div>
                                                <div class="sparkline13-graph">
                                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                                               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <!--<input onclick="CocheTout(this, 'tprod[]');" type="checkbox" />--> 
                                                                        D&eacute;signation
                                                                    </th>
    <!--                                                                    <th>Quantit&eacute;</th>
                                                                    <th>Unit&eacute;</th>-->
                                                                    <th>Op&eacute;ration</th>
                                                                    <th>Prix</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($rslts)) {
                                                                    $rsltm = $con->query("select * from hp_ligne_soin as ls left join hp_produit as a on "
                                                                            . "ls.idproduit=a.idproduit where ls.idsoin='" . $row["idsoin"] . "'") or die(mysqli_error($con));
                                                                    $prils = 0;
                                                                    while ($rows = mysqli_fetch_assoc($rsltm)) {
                                                                        $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rows["idunite"] . "' and "
                                                                                . "idproduit='" . $rows["idproduit"] . "'") or die(mysqli_error($con));
                                                                        $rowvv = mysqli_fetch_assoc($rsltuv2);
                                                                        $prils = $prils + ($rows["quantitelignesoin"] * $rowvv["prixconversion"]);
                                                                    }
                                                                    $pri = $row["montantsoin"] + $prils;
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php print nl2br(htmlspecialchars($row["libellesoin"])) ?></td>
                                                                        <td>
                                                                            <div class="input-group-btn">
                                                                                <a  type="submit" name="envoiproduitpanier" href="<?php echo $url ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajouter_panier_hospitalisation') ?>&actionp=add&idp=<?php echo $row["idsoin"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" title="Ajouter ce soin dans l'hospitalisation" class="btn-xs btn-primary" style="color: white;" >
                                                                                    <i class="glyphicon glyphicon-plus"></i> Ajouter
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                        <td><?php echo $pri ?> F CFA</td>
                                                                    </tr>
                                                                    <!--</form>-->
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 well">
                                            <span class="badge b">
                                                <?php
                                                if (isset($_SESSION["session_prodshos" . $idc])) {
                                                    echo $_SESSION["session_prodshos" . $idc];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </span><br>
                                            <?php
                                            include("hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/panier_menu_hospitalisation.php");
                                            ?>
                                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Static Table End -->
                            <?php
                        }
                        ?>
                            
                        <?php
                        if ($_SESSION['formconsultation'][2]["decisionechographie"]) {
                            ?>
                            Echgraphie
                            <!-- Static Table Start -->
                            <div class="data-table-area mg-b-15" id="divprod">

                                <?php
                                $_SESSION["session_prodsecho" . $idc] = 0;
                                if (!empty($_SESSION["cart_prodvecho" . $idc])) {
//        $_SESSION["session_prodsecho".$idc] = count($_SESSION["cart_prodvecho".$idc]);
                                    foreach ($_SESSION["cart_prodvecho" . $idc] as $k => $v) {
                                        $_SESSION["session_prodsecho" . $idc] = $_SESSION["session_prodsecho" . $idc] + $_SESSION["cart_prodvecho" . $idc][$k]["qteart"];
                                    }
                                }
                                 $rsltbvaec = $con->query("select * from hp_echographie as gp where gp.etatechographie=true ") or die(mysqli_error($con));
                                ?>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                            <div class="sparkline13-list">
                                                <div class="sparkline13-hd">
                                                    <div class="main-sparkline13-hd">
                                                        <h1>Liste <span class="table-project-n">des Echographies</span></h1>
                                                    </div>
                                                </div>
                                                <div class="sparkline13-graph">
                                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                                               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <!--<input onclick="CocheTout(this, 'tprod[]');" type="checkbox" />--> 
                                                                        D&eacute;signation
                                                                    </th>
                                                                    <th>Op&eacute;ration</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($rsltbvaec)) {
                                                                    ?>
                                                                    <!--<form method="post" name="frmCartAddp" id="frmCartAddp" action="" >-->

                                                                    <tr>

                                                                        <td><?php echo($row["nomechographie"]); ?> - <?php echo($row["prixechographie"]); ?> </td>

                                                                        <td>
                                                                            <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->
                                                                            <!--                                                                                <a href="" class="add-to-cart btn btn-primary btn-xs" style="color: white;" type="submit">
                                                                                                                                                                Ajouter
                                                                                                                                                            </a>-->
                                                                            <div class="input-group-btn">
                                                                                <a  type="submit" name="envoiechographiepanier" href="<?php echo $url ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajouter_panier_echographie') ?>&actionp=add&idp=<?php echo $row["idechographie"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" title="Ajouter cet echographie dans les echographies" class="btn-xs btn-primary" style="color: white;" >
                                                                                    <i class="glyphicon glyphicon-plus"></i> Ajouter
                                                                                </a>
                                                                            </div>

                                                                        </td>
                                                                    </tr>
                                                                    <!--</form>-->
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 well">
                                            <span class="badge b">
                                                <?php
                                                if (isset($_SESSION["session_prodsecho" . $idc])) {
                                                    echo $_SESSION["session_prodsecho" . $idc];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </span><br>
                                            <?php
                                            include("hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/panier_menu_echographie.php");
                                            ?>
                                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Static Table End -->
                            <?php
                        }
                        ?>
                            
                              
                        <?php
                        if ($_SESSION['formconsultation'][2]["decisionacte"]) {
                            ?>
                            Autre
                            <!-- Static Table Start -->
                            <div class="data-table-area mg-b-15" id="divprod">

                                <?php
                                $_SESSION["session_prodsact" . $idc] = 0;
                                if (!empty($_SESSION["cart_prodvact" . $idc])) {
//        $_SESSION["session_prodsact".$idc] = count($_SESSION["cart_prodvact".$idc]);
                                    foreach ($_SESSION["cart_prodvact" . $idc] as $k => $v) {
                                        $_SESSION["session_prodsact" . $idc] = $_SESSION["session_prodsact" . $idc] + $_SESSION["cart_prodvact" . $idc][$k]["qteart"];
                                    }
                                }
                                $consua = "Soins";
                                $consupa = "Consultation";
                                $consuva = "Vaccination";
                                $consuvea = "Hospitalisation";
                                $consuveaec = "Echographie";
                                $rsltbva = $con->query("select * from hp_acte as gp left join hp_service as s on gp.idservice=s.idservice where "
                                        . "(gp.categorieacte<>'" . $consua . "' and gp.categorieacte<>'" . $consupa . "' and "
                                        . "gp.categorieacte<>'" . $consuva . "' and gp.categorieacte<>'" . $consuvea . "' "
                                        . " and gp.categorieacte<>'" . $consuveaec . "') "
                                        . " and gp.etatacte=true ") or die(mysqli_error($con));
                                ?>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                            <div class="sparkline13-list">
                                                <div class="sparkline13-hd">
                                                    <div class="main-sparkline13-hd">
                                                        <h1>Liste <span class="table-project-n">des Actes</span></h1>
                                                    </div>
                                                </div>
                                                <div class="sparkline13-graph">
                                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                                               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <!--<input onclick="CocheTout(this, 'tprod[]');" type="checkbox" />--> 
                                                                        D&eacute;signation
                                                                    </th>
                                                                    <th>Op&eacute;ration</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($rsltbva)) {
                                                                    ?>
                                                                    <!--<form method="post" name="frmCartAddp" id="frmCartAddp" action="" >-->

                                                                    <tr>

                                                                        <td><?php print nl2br(htmlspecialchars($row["libelleacte"])) ?></td>

                                                                        <td>
                                                                            <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->
                                                                            <!--                                                                                <a href="" class="add-to-cart btn btn-primary btn-xs" style="color: white;" type="submit">
                                                                                                                                                                Ajouter
                                                                                                                                                            </a>-->
                                                                            <div class="input-group-btn">
                                                                                <a  type="submit" name="envoiactepanier" href="<?php echo $url ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajouter_panier_acte') ?>&actionp=add&idp=<?php echo $row["idacte"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" title="Ajouter cet acte dans les actes" class="btn-xs btn-primary" style="color: white;" >
                                                                                    <i class="glyphicon glyphicon-plus"></i> Ajouter
                                                                                </a>
                                                                            </div>

                                                                        </td>
                                                                    </tr>
                                                                    <!--</form>-->
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 well">
                                            <span class="badge b">
                                                <?php
                                                if (isset($_SESSION["session_prodsact" . $idc])) {
                                                    echo $_SESSION["session_prodsact" . $idc];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </span><br>
                                            <?php
                                            include("hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/panier_menu_acte.php");
                                            ?>
                                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Static Table End -->
                            <?php
                        }
                        ?>
                        <form id="ajout_param" name="formconsultation" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <div class="row">

                                <?php
                                if ($_SESSION['formconsultation'][2]["decisionhospitalisation"]) {
                                    ?>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <div class="chosen-select-single">
                                            <label class="control-label" >Salle </label>
                                            <?php
                                            $rsltpmo1 = $con->query("select * from hp_chambre as ch left join hp_categorie_chambre as cc on "
                                                    . "ch.idcategoriechambre=cc.idcategoriechambre where ch.etatchambre=true and ch.statutchambre=true") or die(mysqli_error($con));
                                            ?>
                                            <select data-placeholder="Choisissez une Salle..." name="salle" id="salle2"  class=" chosen-select form-control">
                                                <option value="">Choisissez une Salle</option>

                                                <?php
                                                while ($rowmo = mysqli_fetch_assoc($rsltpmo1)) {
                                                    $rsltuser = $con->query("select * from hp_lit as l where l.idchambre='" . $rowmo["idchambre"] . "' and "
                                                            . "l.etatlit=true and l.statutlit=true ") or die(mysqli_error($con));
                                                    $nbl = mysqli_num_rows($rsltuser);
                                                    if ($nbl != 0) {
                                                        ?>
                                                        <option value="<?php echo($rowmo["idchambre"]); ?>" <?php if ($_SESSION['formconsultation'][NUM_PAGE]['salle'] == $rowmo["idchambre"]) { ?> selected <?php } ?>><?php echo($rowmo["codechambre"]); ?> - <?php echo($rowmo["placechambre"]); ?> place(s) - <?php echo number_format((nl2br(htmlspecialchars(($rowmo["prixcategoriechambre"])))), 0, '.', ' '); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                        <div class="chosen-select-single">
                                            <label class="control-label" >Lit </label>
                                            <select data-placeholder="Choisissez un Lit ..." name="lit" id="lit"  class=" form-control">
                                                <option value="">Choisissez un Lit</option>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <button type="submit"  title="Enregistrer et imprimer la facture" class="btn btn-primary pull-right">
                                        <span title="Enregistrer " alt="vois"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                                        Enregistrer
                                    </button>
                                </div>
                            </div>

                        </form>

                        <br>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
        $('#ajout_param').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                valeurmin: {
                    message: 'Nom de l\'param invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le valeurmin de l\'param est obligatoire'
                        }
                    }
                },
                valeurmax: {
                    message: 'Prevaleurmin de l\'param invalide',
                    validators: {
                    }
                },
                photo: {
                    validators: {
                        file: {
//                        extension: 'png',
//                        extension: {'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF'},
//                        extension: ('png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF'),
//                        extension: ('png', 'JPEG'),
//                        maxSize: 5*1024*1024,
                            message: 'Veuillez choisir une taille inferieur à 5M'
                        }
                    }
                }
            }
        });
        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_param').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_param').data('bootstrapValidator').resetForm(true);
//    });
    });


    function raz(liste)
    {
        d = document.formconsultation.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formconsultation.elements[liste].options[t] = null;
    }

    $(document).ready(function () {
        $("#salle2").change(function () {
//            alert('ff');
            var moid = $(this).val();
//            alert(moid);
            raz("lit");
            $.ajax({
                url: 'hopitalpages/hopitalpatient/hopitalconsultation/getlit.php',
                type: 'post',
                data: {moid: moid},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        var servi = lib.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formconsultation.elements["lit"].options[document.formconsultation.elements["lit"].length] = new_options;

                    }
                }
            });
        });
    });


</script>
