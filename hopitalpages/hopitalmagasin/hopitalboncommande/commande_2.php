<?php
    $_SESSION["session_prodsvcex"] = 0;
    if (!empty($_SESSION["cart_prodvcex"])) {
//        $_SESSION["session_prodsvcex"] = count($_SESSION["cart_prodvcex".$id]);
        foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
            $_SESSION["session_prodsvcex"] = $_SESSION["session_prodsvcex"] + $_SESSION["cart_prodvcex"][$k]["qteart"];
        }
    }
    $rslt = $con->query("select * from hp_article_point_hotel as aph left join hp_article as a on "
            . "aph.id_article=a.id_article left join hp_categorie as c on a.id_categorie=c.id_categorie ") 
            or die(mysqli_error($con));
    ?><br>
    <div class="row">
        <h2 class="page-header">Commande Externe </h2>  
    </div>
    <div class="row">
        <div class="col-sm-9 well">
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-chambre">
                <thead>
                    <tr class="btn-success">
                        <th>Code</th>
                        <th>D&eacute;signation</th>
                        <th>Cat&eacute;gorie</th>
                        <th>Stock</th>
                        <th>Stock min</th>
                        <th>Stock max</th>
                        <th>Prix achat</th>
                        <th>Prix vente</th>
                        <th>Prix lavage</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($rslt)) {
                        ?>
                        <tr>
                            <td><?php print nl2br(htmlspecialchars($row["code_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["libelle_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["libelle_categorie"])) ?></td>
                            <td>
                                <?php 
                                    if ($row["stock_min_article"]>=$row["stock_article"]){
                                        ?>
                                <b style="color: red">
                                <?php
                                print nl2br(htmlspecialchars($row["stock_article"])); 
                                ?>
                                </b>
                                <?php
                                    }else{
                                        ?>
                                <b>
                                <?php
                                print nl2br(htmlspecialchars($row["stock_article"])); 
                                ?>
                                </b>
                                <?php
                                    }
                                    ?>&nbsp;
                                <?php
                                $rsltua = $con->query("select * from hp_unite where id_unite='" . $row["unite_achat_article"] . "'") or die(mysqli_error($con));
                                $rowa = mysqli_fetch_assoc($rsltua);
                                print nl2br(htmlspecialchars($rowa["libelle_unite"]));
                                ?>
                            </td>
                            <td><?php print nl2br(htmlspecialchars($row["stock_min_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["stock_max_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["prix_achat_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["prix_vente_article"])) ?></td>
                            <td>
                            <?php
                                $rsltl = $con->query("select * from hp_linge where "
                                        . "id_article_point_hotel='" . $row["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                                $rowl = mysqli_fetch_assoc($rsltl);
                                print nl2br(htmlspecialchars($rowl["prix_lavage_linge"]));
                                ?>
                            </td>
                            <td>
                                <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->

                                <?php
                                if (isset($_SESSION["loginproprietaire"])) {
                                    ?>
                                    <a href="indexadmin.php?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article_point_hotel"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                } else if (($_SESSION["code_service"] == "DG")) {
                                    ?>
                                    <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article_point_hotel"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article_point_hotel"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
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
        <div class="col-sm-3 well">
            <span class="badge b">
                <?php
                if (isset($_SESSION["session_prodsvcex"])) {
                    echo $_SESSION["session_prodsvcex"];
                } else {
                    echo '0';
                }
                ?>
            </span>
        <a href="#modalfromarticle" role="button" data-toggle="modal" class="pull-right">
            <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
        </a>
        <?php
        include("hopitalpages/hopitalmagasin/hopitalboncommande/hotelajouter/ajouter_produit.php");
        ?>
            <br>
            <br>
            <?php
            include("hopitalpages/hopitalmagasin/hopitalboncommande/panier_menu.php");
            ?>
        </div>
    </div>