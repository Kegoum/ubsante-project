<?php
if (isset($_REQUEST["ordonnance"])) {
    $id = $_REQUEST["ordonnance"];
    $_SESSION["session_prodslordp" . $id] = 0;
    if (!empty($_SESSION["cart_prodlordp" . $id])) {
//        $_SESSION["session_prodslordp"] = count($_SESSION["cart_prodlordp".$id]);
        foreach ($_SESSION["cart_prodlordp" . $id] as $k => $v) {
            $_SESSION["session_prodslordp" . $id] = $_SESSION["session_prodslordp" . $id] + $_SESSION["cart_prodlordp" . $id][$k]["qteart"];
        }
    }
    $rslt = $con->query("select * from hp_ordonnance as o left join hp_sous_dossier as sd on o.idsousdossier=sd.idsousdossier "
            . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
            . "o.idordonnance='" . $_REQUEST["ordonnance"] . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rsltbar = $con->query("select * from hp_ligne_ordonnance as lo left join hp_produit as a on "
            . "lo.idproduit=a.idproduit left join hp_categorie as c on "
            . "a.idcategorie=c.idcategorie where lo.idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
    $nbbar = mysqli_num_rows($rsltbar);
    ?><br>
    <div class="row">
        <h2 class="page-header">Livraison de l'ordonnance <?php echo $row["codeordonnance"]; ?><br>
            doit :  
            <small> <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?> - <?php echo $row["codepatient"]; ?></small> </h2>  
    </div>
    <div class="row">
        <div class="col-sm-7">
             <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-chambre">
                    <thead>
                        <tr class="btn-primary">
                            <th>Code</th>
                            <th>D&eacute;signation</th>
                            <th>Cat&eacute;gorie</th>
                            <th>Stock</th>
                            <th>Stock Command&eacute;</th>
                            <th>Prix Achat</th>
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
                                <td><?php print nl2br(htmlspecialchars($row["libellecategorie"])) ?></td>
                                <td>
                                    <?php
                                    $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $row["idunite"] . "' and "
                                            . "idproduit='" . $row["idproduit"] . "'") or die(mysqli_error($con));
                                    $npharmaciepa = mysqli_num_rows($rsltuarpa);

                                    $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                                    if ($row["stockligneordonnance"] > $row["stockproduit"]) {
                                        if ($npharmaciepa != 0) {
                                            if ($row["stockligneordonnance"] > $rowarpa["stockconversion"]) {
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
                                    <?php print nl2br(htmlspecialchars($row["stockligneordonnance"])); ?>
                                    &nbsp;
                                    <?php
                                    $rsltuab = $con->query("select * from hp_unite where idunite='" . $row["idunite"] . "'") or die(mysqli_error($con));
                                    $rowab = mysqli_fetch_assoc($rsltuab);
                                    print nl2br(htmlspecialchars($rowab["codeunite"]));
                                    ?>
                                </td>
                                <td><?php print nl2br(htmlspecialchars($row["prixachatproduit"])) ?></td>
                                <td><?php print nl2br(htmlspecialchars($row["prixventeproduit"])) ?></td>
                                <td>
                                    <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->

                                    <?php
                                    if ($row["etatligneordonnance"] == "Payée") {
                                        if ($row["stockproduit"] > 0) {
                                            ?>
                                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["idligneordonnance"]; ?>&ordonnance=<?php echo $_REQUEST["ordonnance"]; ?>" class="add-to-cart btn btn-primary" type="submit">
                                                    Ajouter
                                                </a>
                                                <?php
                                        } else {
                                               ?>
                                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/ajouter_commande') ?>&actionp=add&idp=<?php echo $row["idligneordonnance"]; ?>&ordonnance=<?php echo $_REQUEST["ordonnance"]; ?>" class="add-to-cart btn btn-primary" type="submit">
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
                if (isset($_SESSION["session_prodslordp" . $id])) {
                    echo $_SESSION["session_prodslordp" . $id];
                } else {
                    echo '0';
                }
                ?>
            </span><br>
            <?php
            include("hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/panier_menu.php");
            ?>
        </div>
    </div>
    <?php
}
?>