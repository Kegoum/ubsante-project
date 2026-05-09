<?php
if (isset($_REQUEST["soinpatient"])) {
    $id = $_REQUEST["soinpatient"];
    $_SESSION["session_prodslsosop" . $id] = 0;
    if (!empty($_SESSION["cart_prodlsosop" . $id])) {
//        $_SESSION["session_prodslsosop"] = count($_SESSION["cart_prodlsosop".$id]);
        foreach ($_SESSION["cart_prodlsosop" . $id] as $k => $v) {
            $_SESSION["session_prodslsosop" . $id] = $_SESSION["session_prodslsosop" . $id] + $_SESSION["cart_prodlsosop" . $id][$k]["qteart"];
        }
    }
    $rslt = $con->query("select * from hp_soin_patient as o left join hp_hospitalisation as h on "
            . "o.idhospitalisation=h.idhospitalisation left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
            . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
            . "o.idsoinpatient='" . $_REQUEST["soinpatient"] . "'") or die(mysqli_error($con));
    $rows = mysqli_fetch_assoc($rslt);
    $rsltbar = $con->query("select * from hp_ligne_soin_patient as lo left join hp_produit as a on "
            . "lo.idproduit=a.idproduit left join hp_categorie as c on "
            . "a.idcategorie=c.idcategorie where lo.idsoinpatient='" . $rows["idsoinpatient"] . "'") or die(mysqli_error($con));
    $nbbar = mysqli_num_rows($rsltbar);
    ?><br>
    <div class="row">
        <h2 class="page-header">Livraison des produits du soin <?php echo $rows["codesoinpatient"]; ?><br>
            doit :  
            <small> <?php echo $rows["nompatient"]; ?> <?php echo $rows["prenompatient"]; ?> - <?php echo $rows["codepatient"]; ?></small> </h2>  
    </div>
    <div class="row">
        <div class="col-sm-7">
             <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-chambre">
                    <thead>
                        <tr class="btn-primary">
                            <th>Code</th>
                            <th>D&eacute;signation</th>
                            <!--<th>Cat&eacute;gorie</th>-->
                            <th>Stock</th>
                            <th>Stock du soin</th>
                            <th>Prix Vente</th>
                            <th>Op&eacute;ration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($rsltbar)) {
                            ?>
                            <tr>
                                <td><?php print nl2br(htmlspecialchars($row["codeproduit"])) ?></td>
                                <td><?php print nl2br(htmlspecialchars($row["libelleproduit"])) ?></td>
                                <!--<td><?php // print nl2br(htmlspecialchars($row["libellecategorie"])) ?></td>-->
                                <td>
                                    <?php
                                    $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $row["idunitesoinpatient"] . "' and "
                                            . "idproduit='" . $row["idproduit"] . "'") or die(mysqli_error($con));
                                    $npharmaciepa = mysqli_num_rows($rsltuarpa);

                                    $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                                    if ($row["quantitelignesoinpatient"] > $row["stockproduit"]) {
                                        if ($npharmaciepa != 0) {
                                            if ($row["quantitelignesoinpatient"] > $rowarpa["stockconversion"]) {
                                                ?><b style="color: red"><?php
                                                print nl2br(htmlspecialchars($row["stockproduit"]));
                                                ?></b><?php
                                            } else {
                                                ?><b ><?php
                                                        print nl2br(htmlspecialchars($row["stockproduit"]));
                                                        ?></b><?php
                                            }
                                        } else {
                                            ?><b style="color: red"><?php
                                                print nl2br(htmlspecialchars($row["stockproduit"]));
                                                ?></b><?php
                                        }
                                    } else {
                                        ?><b><?php
                                                print nl2br(htmlspecialchars($row["stockproduit"]));
                                                ?></b><?php
                                    }
                                    ?> 
                                    &nbsp;
                                    <?php
                                    $rsltua = $con->query("select * from hp_unite where idunite='" . $row["uniteachatproduit"] . "'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_assoc($rsltua);
                                    print nl2br(htmlspecialchars($rowa["codeunite"]));
                                    ?>
                                </td>
                                <td>
                                    <?php print nl2br(htmlspecialchars($row["quantitelignesoinpatient"])); ?>
                                    &nbsp;
                                    <?php
                                    $rsltuab = $con->query("select * from hp_unite where idunite='" . $row["idunitesoinpatient"] . "'") or die(mysqli_error($con));
                                    $rowab = mysqli_fetch_assoc($rsltuab);
                                    print nl2br(htmlspecialchars($rowab["codeunite"]));
                                    ?>
                                </td>
                                <td><?php print nl2br(htmlspecialchars($row["prixventeproduit"])) ?></td>
                                <td>
                                    <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->

                                    <?php
                                    if (($row["etatlignesoinpatient"] == "Payé") || (($rows["idhospitalisation"] != NULL) && ($row["etatlignesoinpatient"] != "Livré"))) {
                                        if ($row["stockproduit"] > 0) {
                                            ?>
                                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsortiesoinpatient/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["idlignesoinpatient"]; ?>&soinpatient=<?php echo $_REQUEST["soinpatient"]; ?>" class="add-to-cart btn btn-primary" type="submit">
                                                    Ajouter
                                                </a>
                                                <?php
                                        } else {
                                               ?>
                                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalsortiesoinpatient/ajouter_commande') ?>&actionp=add&idp=<?php echo $row["idlignesoinpatient"]; ?>&soinpatient=<?php echo $_REQUEST["soinpatient"]; ?>" class="add-to-cart btn btn-primary" type="submit">
                                                    Commander
                                                </a>
                                                <?php
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
            </div>
        </div>
        <div class="col-sm-5 well">
            <span class="badge b">
                <?php
                if (isset($_SESSION["session_prodslsosop" . $id])) {
                    echo $_SESSION["session_prodslsosop" . $id];
                } else {
                    echo '0';
                }
                ?>
            </span><br>
            <?php
            include("hopitalpages/hopitalpatient/hopitalsortiesoinpatient/panier_menu.php");
            ?>
        </div>
    </div>
    <?php
}
?>