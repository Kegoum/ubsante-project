<?php
if ($_REQUEST["idordonnance"]) {
    $idc = $_REQUEST["idordonnance"];
    $rsltc = $con->query("select * from hp_ordonnance as c where "
            . "c.idordonnance='" . $_REQUEST["idordonnance"] . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rsltc);
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
                                        Modification de l'ordonnance : <?php
                                        echo $row["codeordonnance"];
                                        ?> 
                                    </h1>

                                    <!--<div class="alert alert-info"><em style="color: #FC331C">Veuillez cocher les lignes a remplir</em></div>-->
                                </div>
                            </div>

                            <br>
                            <!-- Static Table Start -->
                            <div class="data-table-area mg-b-15" id="divprod">

                                <?php
                                $_SESSION["session_prodsordoe" . $idc] = 0;
                                if (!empty($_SESSION["cart_prodvordoe" . $idc])) {
//                                    echo "<script language='javascript'>alert('slow1')</script>";
                                    $_SESSION["deja"] = true;
//        $_SESSION["session_prodsordoe".$idc] = count($_SESSION["cart_prodvordoe".$idc]);
                                    foreach ($_SESSION["cart_prodvordoe" . $idc] as $k => $v) {
                                        $_SESSION["session_prodsordoe" . $idc] = $_SESSION["session_prodsordoe" . $idc] + $_SESSION["cart_prodvordoe" . $idc][$k]["qteart"];
                                    }
                                } else {
                                    if (!isset($_SESSION["deja"])) {
//                                        echo "<script language='javascript'>alert('slow2')</script>";
                                        $rsltm = $con->query("select * from hp_ligne_ordonnance as ls left join hp_produit as a on "
                                                . "ls.idproduit=a.idproduit where ls.idordonnance='" . $idc . "'") or die(mysqli_error($con));
                                        $nbls = mysqli_num_rows($rsltm);
                                        if ($nbls == 0) {
//                                            echo "<script language='javascript'>alert('slow3')</script>";
//                                            echo "<script language='javascript'>alert('slow1')</script>";
                                            $_SESSION["deja"] = true;
                                        } else {
//                                            echo "<script language='javascript'>alert('slow4')</script>";
//                                            echo "<script language='javascript'>alert($nbls)</script>";
                                            while ($rowls = mysqli_fetch_assoc($rsltm)) {
//                                                echo "<script language='javascript'>alert('slow5')</script>";
                                                $rsltuserb = $con->query("select SUM(mb.stockboutique) as stock from hp_boutique as mb where "
                                                        . "mb.idproduit='" . $rowls["idproduit"] . "' group by mb.idproduit") or die(mysqli_error($con));
                                                $nbb = mysqli_num_rows($rsltuserb);
                                                $qte = 0;
                                                $qtes = 0;
                                                $rsltuv2b = $con->query("select * from hp_conversion where idunite='" . $rowls["idunite"] . "' and "
                                                        . "idproduit='" . $rowls["idproduit"] . "'") or die(mysqli_error($con));
                                                $rowvvb = mysqli_fetch_assoc($rsltuv2b);

                                                $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowls["uniteventeproduit"] . "' "
                                                        . "and idproduit='" . $rowls["idproduit"] . "'") or die(mysqli_error($con));
                                                $npharmaciepa = mysqli_num_rows($rsltuarpa);
                                                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                                                if ($nbb != 0) {
//                                                    echo "<script language='javascript'>alert('slow6')</script>";
                                                    $recuserb = mysqli_fetch_assoc($rsltuserb);
                                                    if ($rowarpa["conversion"] != 0) {
                                                        $qtes = $qtes + (($recuserb["stock"]) * ($rowvvb["conversion"] / $rowarpa["conversion"]));
                                                    }
                                                }
                                                if ($rowls["stockligneordonnance"] > $qtes) {
//                                                    echo "<script language='javascript'>alert('slow7')</script>";
                                                    $rsltuserp = $con->query("select * from hp_produit as a left join hp_categorie as c on "
                                                            . "a.idcategorie=c.idcategorie where a.idproduit='" . $rowls["idproduit"] . "'") or die(mysqli_error($con));
                                                    $nbp = mysqli_num_rows($rsltuserp);
                                                    if ($nbp != 0) {
//                                                        echo "<script language='javascript'>alert('slow8')</script>";
                                                        $recuserp = mysqli_fetch_assoc($rsltuserp);
                                                        if ($rowarpa["conversion"] != 0) {
                                                            $qtes = $qtes + (($rowarpa["stockconversion"]) * ($rowvvb["conversion"] / $rowarpa["conversion"]));
                                                        }
                                                    }
                                                }
                                                if ($rowls["stockligneordonnance"] > $qtes) {
                                                    $qte = $qtes;
                                                } else {
                                                    $qte = $rowls["stockligneordonnance"];
                                                }

//                                                echo "<script language='javascript'>alert('slow')</script>";
                                                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowls["idunite"] . "' and "
                                                        . "idproduit='" . $rowls["idproduit"] . "'") or die(mysqli_error($con));
                                                $rowvv = mysqli_fetch_assoc($rsltuv2);
                                                $pr = ($rowvv["prixconversion"]);

                                                $prodArray = array($rowls["idproduit"] => array(
                                                        'idart' => $rowls["idproduit"],
                                                        'designationart' => $rowls["libelleproduit"],
                                                        'qteart' => $qte,
                                                        'prixart' => $pr,
                                                        'uniteart' => $rowls["idunite"]
                                                ));
                                                if (!empty($_SESSION["cart_prodvordoe" . $idc])) {
                                                    $_SESSION["cart_prodvordoe" . $idc] = array_merge($_SESSION["cart_prodvordoe" . $idc], $prodArray);
                                                } else {
                                                    $_SESSION["cart_prodvordoe" . $idc] = $prodArray;
                                                }
                                            }
                                            foreach ($_SESSION["cart_prodvordoe" . $idc] as $k => $v) {
                                                $_SESSION["session_prodsordoe" . $idc] = $_SESSION["session_prodsordoe" . $idc] + $_SESSION["cart_prodvordoe" . $idc][$k]["qteart"];
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
                                                                    if (isset($_SESSION["cart_prodvordoe" . $idc])) {
                                                                        foreach ($_SESSION["cart_prodvordoe" . $idc] as $k => $v) {
                                                                            if (($_SESSION["cart_prodvordoe" . $idc][$k]["idart"] == $rowpr["idproduit"])) {
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
                                                                                    <a  type="submit" name="envoiproduitpanier" href="<?php echo $url ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalordonnance/hopitalediter/ajouter_panier') ?>&actionp=add&idp=<?php echo $rowpr["idproduit"]; ?>&idordonnance=<?php echo $_REQUEST["idordonnance"]; ?>" title="Ajouter ce produit dans les ordonnances" class="btn-xs btn-primary" style="color: white;" >
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
                                                if (isset($_SESSION["session_prodsordoe" . $idc])) {
                                                    echo $_SESSION["session_prodsordoe" . $idc];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </span><br>
                                            <?php
                                            include("hopitalpages/hopitalpatient/hopitalordonnance/hopitalediter/panier_menu.php");
                                            ?>
                                            <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalordonnance/hopitalediter/edit_ordonnance'); ?>&idordonnance=<?php echo $_REQUEST["idordonnance"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>-->

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