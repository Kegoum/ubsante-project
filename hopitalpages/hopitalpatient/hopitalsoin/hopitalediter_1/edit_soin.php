<?php
if ($_REQUEST["idsoinpatient"]) {
    $idc = $_REQUEST["idsoinpatient"];
    $rsltc = $con->query("select * from hp_soin_patient as c left join hp_hospitalisation as h on "
            . "c.idhospitalisation=h.idhospitalisation left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
            . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
            . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
            . "c.idsoinpatient='" . $_REQUEST["idsoinpatient"] . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rsltc);

    $rsltso = $con->query("select * from hp_soin as c where c.idsoin='" . $row["idsoin"] . "'") or die(mysqli_error($con));
    $rowso = mysqli_fetch_assoc($rsltso);
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
                                        Modification des soins de : <?php
                                        echo $row["codepatient"];
                                        ?> <?php echo $row["nompatient"]; ?> <?php
                                        echo $row["prenompatient"];
                                        ?>
                                    </h1>
                                    <h1>
                                        <?php echo $rowso["libellesoin"]; ?>
                                    </h1>

                                    <!--<div class="alert alert-info"><em style="color: #FC331C">Veuillez cocher les lignes a remplir</em></div>-->
                                </div>
                            </div>

                            <br>
                            <!-- Static Table Start -->
                            <div class="data-table-area mg-b-15" id="divprod">

                                <?php
                                $_SESSION["session_prodssoine" . $idc] = 0;
                                if (!empty($_SESSION["cart_prodvsoine" . $idc])) {
                                    $_SESSION["deja"] = true;
//        $_SESSION["session_prodssoine".$idc] = count($_SESSION["cart_prodvsoine".$idc]);
                                    foreach ($_SESSION["cart_prodvsoine" . $idc] as $k => $v) {
                                        $_SESSION["session_prodssoine" . $idc] = $_SESSION["session_prodssoine" . $idc] + $_SESSION["cart_prodvsoine" . $idc][$k]["qteart"];
                                    }
                                } else {
                                    if (!isset($_SESSION["deja"])) {
                                        $rsltm = $con->query("select * from hp_ligne_soin as ls left join hp_produit as a on "
                                                . "ls.idproduit=a.idproduit where ls.idsoin='" . $row["idsoin"] . "'") or die(mysqli_error($con));
                                        $nbls = mysqli_num_rows($rsltm);
                                        if ($nbls == 0) {
//                                            echo "<script language='javascript'>alert('slow1')</script>";
                                            $_SESSION["deja"] = true;
                                        } else {
//                                            echo "<script language='javascript'>alert($nbls)</script>";
                                            while ($rowls = mysqli_fetch_assoc($rsltm)) {
//                                                echo "<script language='javascript'>alert('slow')</script>";
                                                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowls["idunite"] . "' and "
                                                        . "idproduit='" . $rowls["idproduit"] . "'") or die(mysqli_error($con));
                                                $rowvv = mysqli_fetch_assoc($rsltuv2);
                                                $pr = ($rowvv["prixconversion"]);

                                                $prodArray = array($rowls["idproduit"] => array(
                                                        'idart' => $rowls["idproduit"],
                                                        'designationart' => $rowls["libelleproduit"],
                                                        'qteart' => $rowls["quantitelignesoin"],
                                                        'prixart' => $pr,
                                                        'uniteart' => $rowls["idunite"]
                                                ));
                                                if (!empty($_SESSION["cart_prodvsoine" . $idc])) {
                                                    $_SESSION["cart_prodvsoine" . $idc] = array_merge($_SESSION["cart_prodvsoine" . $idc], $prodArray);
                                                } else {
                                                    $_SESSION["cart_prodvsoine" . $idc] = $prodArray;
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                            <div class="sparkline13-list">
                                                <div class="sparkline13-hd">
                                                    <div class="main-sparkline13-hd">
                                                        <h1>Liste <span class="table-project-n">des produits de Soin</span></h1>
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
                                                                        <!--<th>Quantit&eacute;</th>-->
                                                                    <!--<th>Unit&eacute;</th>-->
                                                                    <th>Op&eacute;ration</th>
                                                                    <th>Prix</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                $rsltm = $con->query("select * from hp_produit where etatproduit=true") or die(mysqli_error($con));
                                                                while ($rowpr = mysqli_fetch_assoc($rsltm)) {
                                                                    $fa = FALSE;
                                                                    if (isset($_SESSION["cart_prodvsoine" . $idc])) {
                                                                        foreach ($_SESSION["cart_prodvsoine" . $idc] as $k => $v) {
                                                                            if (($_SESSION["cart_prodvsoine" . $idc][$k]["idart"] == $rowpr["idproduit"])) {
                                                                                $fa = TRUE;
                                                                            }
                                                                        }
                                                                    }
                                                                    if (!$fa) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php print nl2br(htmlspecialchars($rowpr["libelleproduit"])) ?></td>
                                                                            <td>
                                                                                <div class="input-group-btn">
                                                                                    <a  type="submit" name="envoiproduitpanier" href="<?php echo $url ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsoin/hopitalediter/ajouter_panier') ?>&actionp=add&idp=<?php echo $rowpr["idproduit"]; ?>&idsoinpatient=<?php echo $_REQUEST["idsoinpatient"]; ?>" title="Ajouter ce produit dans les soins" class="btn-xs btn-primary" style="color: white;" >
                                                                                        <i class="glyphicon glyphicon-plus"></i> Ajouter
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                            <td><?php print nl2br(htmlspecialchars($rowpr["prixventeproduit"])) ?> F CFA</td>
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
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 well">
                                            <span class="badge b">
                                                <?php
                                                if (isset($_SESSION["session_prodssoine" . $idc])) {
                                                    echo $_SESSION["session_prodssoine" . $idc];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </span><br>
                                            <?php
                                            include("hopitalpages/hopitalpatient/hopitalsoin/hopitalediter/panier_menu.php");
                                            ?>
                                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsoin/hopitalediter/edit_soin'); ?>&idsoinpatient=<?php echo $_REQUEST["idsoinpatient"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>-->

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