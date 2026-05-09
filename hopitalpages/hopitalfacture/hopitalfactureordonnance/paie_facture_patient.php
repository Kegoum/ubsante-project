<?php
if ($_REQUEST["idfacture"]) {
    $idc = $_REQUEST["idfacture"];
    $req_fin = $con->query("select * from hp_facture as f where f.idfacture='" . $idc . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $versement = $row["avancefacture"];
    $mrest = $row["montantfacture"] - $versement;

    $rsltc = $con->query("select * from hp_ordonnance as c where "
            . "c.idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
    $rowo = mysqli_fetch_assoc($rsltc);
    $patient = NULL;
    if ($rowo["idsousdossier"] != NULL) {
        $rsltcp = $con->query("select * from hp_sous_dossier as sd left join hp_dossier as d on sd.iddossier=d.iddossier "
                . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
                . "p.residencepatient=dp.iddepartement where sd.idsousdossier='" . $rowo["idsousdossier"] . "'") or die(mysqli_error($con));
        $patient = mysqli_fetch_assoc($rsltcp);
    }
    ?>

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
                                        Cr&eacute;er un Paiement de la facture : <?php echo $row["codefacture"] ?> 
                                        <?php
                                        if ($patient != NULL) {
                                            ?>
                                            de : <?php
                                            echo $patient["codepatient"];
                                            ?> <?php echo $patient["nompatient"]; ?> <?php
                                            echo $patient["prenompatient"];
                                        }
                                        ?>
                                    </h1>
                                    <!--<div class="alert alert-info"><em style="color: #FC331C">Veuillez cocher les lignes a remplir</em></div>-->
                                </div>
                            </div>

                            <br>
                            <!-- Static Table Start -->
                            <div class="data-table-area mg-b-15" id="divprod">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalordonnance/hopitalediter/edit_ordonnance') ?>&idordonnance=<?php echo $row["idordonnance"] ?>" class="pull-right btn-primary">
                                    <span title="modifier cet Ordonnance" alt="edit"><i class="glyphicon glyphicon-edit"></i> Modifier</span>
                                </a>&nbsp;&nbsp; 
                                <?php
                                $_SESSION["session_prodsfactordo" . $idc] = 0;
                                if (!empty($_SESSION["cart_prodvfactordo" . $idc])) {
//        $_SESSION["session_prodsfactordo".$idc] = count($_SESSION["cart_prodvfactordo".$idc]);
                                    foreach ($_SESSION["cart_prodvfactordo" . $idc] as $k => $v) {
                                        $_SESSION["session_prodsfactordo" . $idc] = $_SESSION["session_prodsfactordo" . $idc] + $_SESSION["cart_prodvfactordo" . $idc][$k]["qteart"];
                                    }
                                }
                                ?>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                            <div class="sparkline13-list">
                                                <div class="sparkline13-hd">
                                                    <div class="main-sparkline13-hd">
                                                        <h1>Liste <span class="table-project-n">des produits de l'ordonnance</span></h1>
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
                                                                    <th>Quantit&eacute;</th>
                                                                    <th>Prix</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                $rsltm = $con->query("select * from hp_ligne_ordonnance as lo left join hp_produit as p on lo.idproduit=p.idproduit "
                                                                        . "where lo.idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
                                                                while ($rowpr = mysqli_fetch_assoc($rsltm)) {
                                                                    $rsltmu = $con->query("select * from hp_unite where idunite='" . $rowpr["idunite"] . "'") or die(mysqli_error($con));
                                                                    $rowpru = mysqli_fetch_assoc($rsltmu);
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php print nl2br(htmlspecialchars($rowpr["libelleproduit"])) ?></td>
                                                                        <td>
                                                                            <div class="input-group-btn">
                                                                                <a  type="submit" name="envoiproduitpanier" href="<?php echo $url ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalfactureordonnance/ajouter_panier') ?>&actionp=add&idp=<?php echo $rowpr["idligneordonnance"]; ?>&idfacture=<?php echo $_REQUEST["idfacture"]; ?>" title="Ajouter ce produit dans le panier" class="btn-xs btn-primary" style="color: white;" >
                                                                                    <i class="glyphicon glyphicon-plus"></i> Ajouter
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?php print nl2br(htmlspecialchars($rowpr["stockligneordonnance"])) ?> 
                                                                            <?php print nl2br(htmlspecialchars($rowpru["codeunite"])) ?>
                                                                        </td>
                                                                        <td><?php print nl2br(htmlspecialchars($rowpr["prixligneordonnance"])) ?> F CFA</td>
                                                                    </tr>
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
                                                if (isset($_SESSION["session_prodsfactordo" . $idc])) {
                                                    echo $_SESSION["session_prodsfactordo" . $idc];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </span><br>
                                            <?php
                                            include("hopitalpages/hopitalfacture/hopitalfactureordonnance/panier_menu.php");
                                            ?>
                                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalfactureordonnance/paie_facture_patient'); ?>&idfacture=<?php echo $_REQUEST["idfacture"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Static Table End -->
                            <br>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}