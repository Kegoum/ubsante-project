<?php

//fonction pour ajouter un categorie
function inserer_categorie($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_categorie where codecategorie='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_categorie(libellecategorie,codecategorie) "
                            . "values('" . addslashes($reg["1"]["categorie"]) . "', "
                            . "'" . $reg["1"]["codep"] . "')") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_categorie de la valeure {$reg["1"]["categorie"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formcategorie']);
            $pagp = 'hopitalpages/hopitalproduit/hopitalcategorie/lister_categorie';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalproduit/hopitalcategorie/hopitalajouter/ajout_categorie';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les categories
function lister_categorie($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_categorie ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idcategorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codecategorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategorie"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalcategorie/hopitalediter/edit_categorie'); ?>&idcategorie=<?php echo $recuser["idcategorie"]; ?>" >
                    <span title="Modifier cette D.C.I. /PRINCIPE ACTIF" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalcategorie/categorie_ajax'); ?>&idcategorie=<?php echo $recuser["idcategorie"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer cette D.C.I. /PRINCIPE ACTIF ?'));" >
                    <span title="Supprimer cette D.C.I. /PRINCIPE ACTIF " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_categorie($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_categorie where codecategorie='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_categorie set codecategorie='" . $reg["1"]["codepe"] . "', libellecategorie='" . addslashes($reg["1"]["categoriee"]) . "' "
                            . "where idcategorie='" . $reg["1"]["idcategorie"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_categorie de la valeure {$reg["1"]["categorie"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formcategoriee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalproduit/hopitalcategorie/lister_categorie';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idcategorie"] != $reg["1"]["idcategorie"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_categorie set codecategorie='" . $reg["1"]["codepe"] . "', libellecategorie='" . addslashes($reg["1"]["categoriee"]) . "' "
                                . "where idcategorie='" . $reg["1"]["idcategorie"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_categorie de la valeure {$reg["1"]["categorie"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formcategoriee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalproduit/hopitalcategorie/lister_categorie';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalproduit/hopitalcategorie/hopitalediter/edit_categorie';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idcategorie=' . $reg["1"]["idcategorie"] . '">');
            }
        }
    }
}

//fonction pour ajouter un valorisationstock
function inserer_valorisationstock($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_valorisation_stock where codevalorisationstock='" . $reg["1"]['codevalorisationstock'] . "' ") or die(mysqli_error($con));
        $row = mysqli_num_rows($req);
        if ($row == 0) {

            $con->query("insert into hp_valorisation_stock(codevalorisationstock, libellevalorisationstock, datevalorisationstock) "
                            . "values('" . addslashes($reg["1"]['codevalorisationstock']) . "', '" . addslashes($reg["1"]['libvalorisationstock']) . "', "
                            . "NOW())") or die(mysqli_error($con));

            unset($_SESSION['formvalorisationstock']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalproduit/hopitalvalorisation/lister_valorisation';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalproduit/hopitalvalorisation/hopitalajouter/ajout_valorisation';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les valorisationstocks
function lister_valorisationstock($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_valorisation_stock ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idvalorisationstock"])) ?></td>
            <td><?php print nl2br(($recuser["codevalorisationstock"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellevalorisationstock"])) ?></td>
            <td>
                <?php
                if ($recuser["etatvalorisationstock"]) {
                    ?>
                    <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalvalorisation/valorisation_ajax'); ?>&idvalorisationstock=<?php echo $recuser["idvalorisationstock"]; ?>&desactiver=desactiver' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cette Valorisation ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalvalorisation/valorisation_ajax'); ?>&idvalorisationstock=<?php echo $recuser["idvalorisationstock"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cette Valorisation ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["datevalorisationstock"])) ?></td>
            <td>
                <?php
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || ((($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Magasinier")))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalvalorisation/hopitalediter/edit_valorisation'); ?>&idvalorisationstock=<?php echo $recuser["idvalorisationstock"]; ?>" >
                        <span title="Modifier cette Valorisation" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function update_valorisationstock($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_valorisation_stock where libellevalorisationstock='" . $reg["1"]['libvalorisationstocke'] . "' ") or die(mysqli_error($con));
        $row = mysqli_num_rows($req);
        if ($row == 0) {
            $con->query("update hp_valorisation_stock set codevalorisationstock='" . addslashes($reg["1"]['codevalorisationstocke']) . "', "
                            . "libellevalorisationstock='" . addslashes($reg["1"]['libvalorisationstocke']) . "' "
                            . "where idvalorisationstock='" . ($reg["1"]['idvalorisationstock']) . "' ") or die(mysqli_error($con));

            unset($_SESSION['formvalorisationstocke']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalproduit/hopitalvalorisation/lister_valorisation';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $rowv = mysqli_fetch_assoc($req);
            if ($rowv["idvalorisationstock"] == $reg["1"]["idvalorisationstock"]) {

                $con->query("update hp_valorisation_stock set codevalorisationstock='" . addslashes($reg["1"]['codevalorisationstocke']) . "', "
                                . "libellevalorisationstock='" . addslashes($reg["1"]['libvalorisationstocke']) . "' "
                                . "where idvalorisationstock='" . ($reg["1"]['idvalorisationstock']) . "' ") or die(mysqli_error($con));

                unset($_SESSION['formvalorisationstocke']);
                echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalproduit/hopitalvalorisation/lister_valorisation';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalproduit/hopitalvalorisation/hopitalediter/edit_valorisation';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idvalorisationstock=' . $reg["1"]["idvalorisationstock"] . '">');
            }
        }
    }
}

//gestion des produits
function lister_produit($con, $id) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = NULL;
    if ($id != NULL) {
        $rsltuser = $con->query("select * from hp_produit as a left join hp_categorie as c on a.idcategorie=c.idcategorie "
                . "where a.idmagasin='" . $id . "' order by a.libelleproduit asc") or die(mysqli_error($con));
    } else {
        $rsltuser = $con->query("select * from hp_produit as a left join hp_categorie as c on a.idcategorie=c.idcategorie "
                . "order by a.libelleproduit asc") or die(mysqli_error($con));
    }
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediter/editer_produit') ?>&produit=<?php echo $recuser["idproduit"] ?>">
                    <span title="Modifier ce produit" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                </a>&nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalconversion/lister_conversion') ?>&produit=<?php echo $recuser["idproduit"] ?>">
                    <span title="G&eacute;rer les unit&eacute;s de conversion de ce produit" alt="conversion"><i class="glyphicon glyphicon-resize-full"></i></span>
                </a>&nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/produit_ajax'); ?>&idproduit=<?php echo $recuser["idproduit"]; ?>&supprimer=supprimer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce Produit ?'));">
                    <span title="Supprimer ce produit" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                </a>
            </td>
            <td>

                <?php
                if ($recuser["imageproduit"] != NULL) {
                    ?>
                    <img class="img-responsive img-rounded" src="hopitalupload/images/<?php print $recuser["imageproduit"] ?>" height="50" width="40"/>
                    <?php
                } else {
                    ?>

                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleproduit"])) ?></td>
            <td>
                <?php
                if ($recuser["stockminproduit"] >= $recuser["stockproduit"]) {
                    ?>
                    <b style="color: red">
                        <?php
                        print nl2br(htmlspecialchars($recuser["stockproduit"]));
                        ?>
                    </b>
                    <?php
                } else {
                    ?>
                    <b>
                        <?php
                        print nl2br(htmlspecialchars($recuser["stockproduit"]));
                        ?>
                    </b>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["stockminproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stockmaxproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixachatproduit"])) ?></td>
            <td>
                <?php
                print nl2br(htmlspecialchars($recuser["prixventeproduit"]));
                ?>
                <a href="#modaleditprvente" role="button" data-toggle="modal" data-id="<?php echo $recuser["idproduit"] ?>" class="prix-vente">
                    <span title="Modifier le prix de vente de cet produit" alt="editer"><i class="glyphicon glyphicon-credit-card"></i></span>
                </a>
                <?php
                ?>
            </td>
            <td>
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["uniteachatproduit"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["libelleunite"]));
                ?>
            </td>
            <td>
                <?php
                $rsltuv = $con->query("select * from hp_unite where idunite='" . $recuser["uniteventeproduit"] . "'") or die(mysqli_error($con));
                $rowv = mysqli_fetch_assoc($rsltuv);
                print nl2br(htmlspecialchars($rowv["libelleunite"]));
                ?>
            </td>
            <td>
                <?php
                $rsltus = $con->query("select * from hp_unite where idunite='" . $recuser["unitesortieproduit"] . "'") or die(mysqli_error($con));
                $rows = mysqli_fetch_assoc($rsltus);
                print nl2br(htmlspecialchars($rows["libelleunite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategorie"])) ?></td>
            <td>
                <?php
                if ($recuser["idclassemedicamenteuse"] != NULL) {
                    $rsltuserc = $con->query("select * from hp_classe_medicamenteuse as a "
                            . "where a.idclassemedicamenteuse='" . $recuser["idclassemedicamenteuse"] . "' ") or die(mysqli_error($con));
                    $recuserc = mysqli_fetch_assoc($rsltuserc);
                    print nl2br(htmlspecialchars($recuserc["libelleclassemedicamenteuse"]));
                }
                ?>
            </td>
            <td>
                <?php
                if ($recuser["idforme"] != NULL) {
                    $rsltuserc = $con->query("select * from hp_forme as a where a.idforme='" . $recuser["idforme"] . "' ") or die(mysqli_error($con));
                    $recuserc = mysqli_fetch_assoc($rsltuserc);
                    print nl2br(htmlspecialchars($recuserc["libelleforme"]));
                }
                ?>
                <?php
                if ($recuser["iddosage"] != NULL) {
                    $rsltuserc = $con->query("select * from hp_dosage as a "
                            . "where a.iddosage='" . $recuser["iddosage"] . "' ") or die(mysqli_error($con));
                    $recuserc = mysqli_fetch_assoc($rsltuserc);
                    print (", ");
                    print nl2br(htmlspecialchars($recuserc["libelledosage"]));
                }
                ?>
            </td>
            <td>
                <?php
                if ($recuser["idconditionnement"] != NULL) {
                    $rsltuserc = $con->query("select * from hp_conditionnement as a "
                            . "where a.idconditionnement='" . $recuser["idconditionnement"] . "' ") or die(mysqli_error($con));
                    $recuserc = mysqli_fetch_assoc($rsltuserc);
                    print nl2br(htmlspecialchars($recuserc["libelleconditionnement"]));
                }
                ?>
            </td>
            <td>
                <?php
                if ($recuser["idlaboratoireproduit"] != NULL) {
                    $rsltuserc = $con->query("select * from hp_laboratoire_produit as a "
                            . "where a.idlaboratoireproduit='" . $recuser["idlaboratoireproduit"] . "' ") or die(mysqli_error($con));
                    $recuserc = mysqli_fetch_assoc($rsltuserc);
                    print nl2br(htmlspecialchars($recuserc["libellelaboratoireproduit"]));
                }
                ?>
            </td>
            <td>
                <?php
                if ($recuser["etatproduit"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/produit_ajax'); ?>&idproduit=<?php echo $recuser["idproduit"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce Produit ?'));">
                        <span title="D&eacute;sactiver ce Produit" data-toggle="tooltip" alt="oui" class="label-success label"><i class="label label-success">Activ&eacute;</i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/produit_ajax'); ?>&idproduit=<?php echo $recuser["idproduit"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce Produit ?'));">
                        <span title="Activer ce Produit " data-toggle="tooltip" alt="non" class="label-warning label"><i class="label label-warning">D&eacute;sactiv&eacute;</i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateproduit"])) ?></td>
        </tr>
        <?php
    }
}

function inserer_produit($prod, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $desp = addslashes($prod["1"]["desp"]);
        $ca = $prod["1"]["cat"];
//        echo"<script language='javascript'>alert($ca)</script>";

        $req = $con->query("select * from hp_produit where codeproduit='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        $reqim = $con->query("select * from hp_produit where imageproduit='" . $prod["1"]["imagep"] . "'") or die(mysqli_error($con));
        $nbim = mysqli_num_rows($reqim);

        if (($nb == 0)) {
            $imageprod = NULL;
            if ($prod["1"]["imagep"] != "null") {
                if (($nbim == 0)) {
                    $imageprod = $prod["1"]["imagep"];
                }
            }
            $clase = "null";
            $fom = "null";
            $dosa = "null";
            $labo = "null";
            $cond = "null";
            if (($prod["1"]["classe"] != "")) {
                $clase = $prod["1"]["classe"];
            }
            if (($prod["1"]["forme"] != "")) {
                $fom = $prod["1"]["forme"];
            }
            if (($prod["1"]["dosage"] != "")) {
                $dosa = $prod["1"]["dosage"];
            }
            if (($prod["1"]["laboratoire"] != "")) {
                $labo = $prod["1"]["laboratoire"];
            }
            if (($prod["1"]["conditionnement"] != "")) {
                $cond = $prod["1"]["conditionnement"];
            }

            if (($prod["1"]["datefab"] != NULL) && ($prod["1"]["dateper"] != NULL)) {
                $con->query("insert into hp_produit(idclassemedicamenteuse, idconditionnement, iddosage, idforme, idlaboratoireproduit, "
                                . "idmagasin, idvalorisationstock, codeproduit, libelleproduit, imageproduit, idcategorie, stockproduit, "
                                . "stockminproduit, stockmaxproduit, prixachatproduit, uniteachatproduit, uniteventeproduit, unitesortieproduit, "
                                . "datefabricationproduit, dateperemptionproduit, dateproduit) values(" . $clase . ", " . $cond . ", " . $dosa . ", "
                                . "" . $fom . ", " . $labo . ", '" . $_SESSION["idmagasin"] . "', '" . $prod["1"]["valorisation"] . "', "
                                . "'" . $prod["1"]["codep"] . "', '" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', "
                                . "'" . $prod["1"]["qtes"] . "', '" . $prod["1"]["qtemin"] . "', '" . $prod["1"]["qtemax"] . "', "
                                . "'" . $prod["1"]["prixa"] . "', '" . $prod["1"]["unitea"] . "', '" . $prod["1"]["unitev"] . "', "
                                . "'" . $prod["1"]["unites"] . "', '" . $prod["1"]["datefab"] . "', '" . $prod["1"]["dateper"] . "', NOW())") or die(mysqli_error($con));
            } else if (($prod["1"]["datefab"] != NULL) && ($prod["1"]["dateper"] == NULL)) {
                $con->query("insert into hp_produit(idclassemedicamenteuse, idconditionnement, iddosage, idforme, idlaboratoireproduit, "
                                . "idmagasin, idvalorisationstock, codeproduit, libelleproduit, imageproduit, idcategorie, stockproduit, "
                                . "stockminproduit, stockmaxproduit, prixachatproduit, uniteachatproduit, uniteventeproduit, unitesortieproduit, "
                                . "datefabricationproduit, dateproduit) values(" . $clase . ", " . $cond . ", " . $dosa . ", " . $fom . ", " . $labo . ", "
                                . "'" . $_SESSION["idmagasin"] . "', '" . $prod["1"]["valorisation"] . "', '" . $prod["1"]["codep"] . "', "
                                . "'" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', '" . $prod["1"]["qtes"] . "', "
                                . "'" . $prod["1"]["qtemin"] . "', '" . $prod["1"]["qtemax"] . "', '" . $prod["1"]["prixa"] . "', "
                                . "'" . $prod["1"]["unitea"] . "', '" . $prod["1"]["unitev"] . "', '" . $prod["1"]["unites"] . "', "
                                . "'" . $prod["1"]["datefab"] . "', NOW())") or die(mysqli_error($con));
            } else if (($prod["1"]["datefab"] == NULL) && ($prod["1"]["dateper"] != NULL)) {
                $con->query("insert into hp_produit(idclassemedicamenteuse, idconditionnement, iddosage, idforme, idlaboratoireproduit, "
                                . "idmagasin, idvalorisationstock, codeproduit, libelleproduit, imageproduit, idcategorie, stockproduit, "
                                . "stockminproduit, stockmaxproduit, prixachatproduit, uniteachatproduit, uniteventeproduit, unitesortieproduit, "
                                . "dateperemptionproduit, dateproduit) values(" . $clase . ", " . $cond . ", " . $dosa . ", " . $fom . ", " . $labo . ", "
                                . "'" . $_SESSION["idmagasin"] . "', '" . $prod["1"]["valorisation"] . "', '" . $prod["1"]["codep"] . "', "
                                . "'" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', '" . $prod["1"]["qtes"] . "', "
                                . "'" . $prod["1"]["qtemin"] . "', '" . $prod["1"]["qtemax"] . "', '" . $prod["1"]["prixa"] . "', "
                                . "'" . $prod["1"]["unitea"] . "', '" . $prod["1"]["unitev"] . "', '" . $prod["1"]["unites"] . "', "
                                . "'" . $prod["1"]["dateper"] . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_produit(idclassemedicamenteuse, idconditionnement, iddosage, idforme, idlaboratoireproduit, "
                                . "idmagasin, idvalorisationstock, codeproduit, libelleproduit, imageproduit, idcategorie, stockproduit, "
                                . "stockminproduit, stockmaxproduit, prixachatproduit, uniteachatproduit, uniteventeproduit, unitesortieproduit, "
                                . "dateproduit) values(" . $clase . ", " . $cond . ", " . $dosa . ", " . $fom . ", " . $labo . ", "
                                . "'" . $_SESSION["idmagasin"] . "', '" . $prod["1"]["valorisation"] . "', '" . $prod["1"]["codep"] . "', "
                                . "'" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', '" . $prod["1"]["qtes"] . "', "
                                . "'" . $prod["1"]["qtemin"] . "', '" . $prod["1"]["qtemax"] . "', '" . $prod["1"]["prixa"] . "', "
                                . "'" . $prod["1"]["unitea"] . "', '" . $prod["1"]["unitev"] . "', '" . $prod["1"]["unites"] . "', NOW())") or die(mysqli_error($con));
            }

            $reqarph = $con->query("select * from hp_produit where codeproduit='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
            $rowarph = mysqli_fetch_assoc($reqarph);

            $an = date('Y');
            $etat = "Valider";
            $nomfour = "Inconnu";
            $idfourn = null;

            $rsltfour = $con->query("select * from hp_fournisseur where nomfournisseur='" . $nomfour . "'") or die(mysqli_error($con));
            $nbf = mysqli_num_rows($rsltfour);
            if ($nbf != 0) {
                $rowfour = mysqli_fetch_assoc($rsltfour);
                $idfourn = $rowfour["idfournisseur"];
            } else {
                $rsltfou = $con->query("insert into hp_fournisseur(nomfournisseur) values('" . $nomfour . "')") or die(mysqli_error($con));
                $rsltfour2 = $con->query("select * from hp_fournisseur where nomfournisseur='" . $nomfour . "'") or die(mysqli_error($con));
                $rowfour = mysqli_fetch_assoc($rsltfour2);
                $idfourn = $rowfour["idfournisseur"];
            }
            $rsltpl2c = $con->query("select * from hp_bon_commande where YEAR(dateboncommande)='" . $an . "'") or die(mysqli_error($con));
            $numidc = "C" . date('Y', time()) . sprintf("%08d", 1);
            $i = 0;
            while ($reqtec = mysqli_fetch_assoc($rsltpl2c)) {
                $i = $i + 1;
            }
            $numidc = "C" . date('Y', time()) . sprintf("%08d", ($i + 1));
//            if (isset($_SESSION["idmagasin"])) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_bon_commande(idmagasin, codeboncommande, "
                                . "montantboncommande, etatboncommande, dateboncommande) values("
                                . "'" . $_SESSION["idmagasin"] . "', '" . $numidc . "', '" . $prod["1"]["prixa"] . "', "
                                . "'" . $etat . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_bon_commande(idcomptepersonnel, idmagasin, codeboncommande, "
                                . "montantboncommande, etatboncommande, dateboncommande) values('" . $_SESSION["idcomptepersonnel"] . "', "
                                . "'" . $_SESSION["idmagasin"] . "', '" . $numidc . "', '" . $prod["1"]["prixa"] . "', "
                                . "'" . $etat . "', NOW())") or die(mysqli_error($con));
            }

//            }
            $rsltfac = $con->query("select * from hp_bon_commande where codeboncommande='" . $numidc . "'") or die(mysqli_error($con));
            $rowfac = mysqli_fetch_assoc($rsltfac);
            $con->query("insert into hp_ligne_bon_commande(idboncommande, idproduit, idunite, stockligneboncommande, "
                            . "stocklivreligneboncommande, prixligneboncommande, etatligneboncommande) values('" . $rowfac["idboncommande"] . "', "
                            . "'" . $rowarph["idproduit"] . "', '" . $prod["1"]["unitea"] . "', "
                            . "'" . $prod["1"]["qtes"] . "', '" . $prod["1"]["qtes"] . "', '" . $prod["1"]["prixa"] . "', '" . $etat . "')") or die(mysqli_error($con));

            $rsltpl2 = $con->query("select * from hp_bon_livraison where YEAR(datebonlivraison)='" . $an . "'") or die(mysqli_error($con));
            $obh = "";
            $numid = "L" . date('Y', time()) . sprintf("%08d", 1);
            $i = 0;
            while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
                $i = $i + 1;
            }
            $numid = "L" . date('Y', time()) . sprintf("%08d", ($i + 1));
//            if (isset($_SESSION["id_compte_personnel"])) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_bon_livraison(idboncommande, idmagasin, idfournisseur, codebonlivraison, "
                                . "montantbonlivraison, etatbonlivraison, datebonlivraison) values('" . $rowfac["idboncommande"] . "', "
                                . "'" . $_SESSION["idmagasin"] . "', '" . $idfourn . "', '" . $numid . "', '" . $prod["1"]["prixa"] . "', "
                                . "'" . $etat . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_bon_livraison(idboncommande, idcomptepersonnel, "
                                . "idmagasin, idfournisseur, codebonlivraison, montantbonlivraison, etatbonlivraison, datebonlivraison) values("
                                . "'" . $rowfac["idboncommande"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                                . "'" . $_SESSION["idmagasin"] . "', '" . $idfourn . "', '" . $numid . "', '" . $prod["1"]["prixa"] . "', "
                                . "'" . $etat . "', NOW())") or die(mysqli_error($con));
            }

//            }
            $rsltfa = $con->query("select * from hp_bon_livraison where codebonlivraison='" . $numid . "'") or die(mysqli_error($con));
            $rowfa = mysqli_fetch_assoc($rsltfa);
            $prixt = 0;
            $con->query("insert into hp_ligne_bon_livraison(idbonlivraison, idproduit, "
                            . "idunite, stocklignebonlivraison, prixachatlignebonlivraison, etatlignebonlivraison) "
                            . "values('" . $rowfa["idbonlivraison"] . "', '" . $rowarph["idproduit"] . "', "
                            . "'" . $prod["1"]["unitea"] . "', '" . $prod["1"]["qtes"] . "', '" . $prod["1"]["prixa"] . "', "
                            . "'" . $etat . "')") or die(mysqli_error($con));

            $obj = $prod["1"]["codep"] . "->" . $prod["1"]["qtes"] . "->" . $prod["1"]["prixa"];
            $op = "Ajout";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idproduit, objet, operation, datetrace) values("
                                . "'" . $rowarph["idproduit"] . "', '" . $obj . "', "
                                . "'" . $op . "', NOW())") or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, datetrace) values("
                                . "'" . $rowarph["idproduit"] . "', '" . $_SESSION["idcomptepersonnel"] . "', '" . $obj . "', "
                                . "'" . $op . "', NOW())") or die(mysqli_error($con));
            }


            unset($_SESSION['formproduit']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";

            $pag = 'hopitalpages/hopitalproduit/lister_produit';
            die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pag = 'hopitalpages/hopitalproduit/hopitalajouter/ajouter_produit';
            die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '">');
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
        $pag = 'hopitalpages/hopitalproduit/hopitalajouter/ajouter_produit';
        die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '">');
    }
}

function update_produit($prod, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $desp = addslashes($prod["1"]["desp"]);
        $req = $con->query("select * from hp_produit where codeproduit='" . $prod["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);

        if (($nb == 0)) {
            $imageprod = $prod["1"]["imagepstring"];
            if ($prod["1"]["imagep"] != "null") {
                $reqim = $con->query("select * from hp_produit where imageproduit='" . $prod["1"]["imagep"]['name'] . "'") or die(mysqli_error($con));
                $nbim = mysqli_num_rows($reqim);

                if (($nbim == 0)) {
                    if (!is_dir("hopitalupload/images/")) {

// puis on créer les 2 dossiers, qui contiendront les originaux et les miniatures
// avec tous les droits ( écriture, lecture , suppression )
                        @mkdir("hopitalupload/images/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                        if (is_dir("hopitalupload/images/")) {
// On peut valider le fichier et le stocker définitivement
                            move_uploaded_file($prod["1"]["imagep"]['tmp_name'], "hopitalupload/images/" . basename($prod["1"]["imagep"]['name']));

                            $imageprod = $prod["1"]["imagep"]['name'];
                        } else {
                            echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";

                            $pag = 'hopitalpages/hopitalproduit/hopitalediter/editer_produit';
                            die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '&produit=' . ($prod["1"]["idproduit"]) . '">');
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre boutique </br> Veuillez contacter votre administrateur</p>";
                        }
                    } else {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($prod["1"]["imagep"]['tmp_name'], "hopitalupload/images/" . basename($prod["1"]["imagep"]['name']));
                        $imageprod = $prod["1"]["imagep"]['name'];
                    }
                }
            }

            $clase = "null";
            $fom = "null";
            $dosa = "null";
            $labo = "null";
            $cond = "null";
            if (($prod["1"]["classe"] != "")) {
                $clase = $prod["1"]["classe"];
            }
            if (($prod["1"]["forme"] != "")) {
                $fom = $prod["1"]["forme"];
            }
            if (($prod["1"]["dosage"] != "")) {
                $dosa = $prod["1"]["dosage"];
            }
            if (($prod["1"]["laboratoire"] != "")) {
                $labo = $prod["1"]["laboratoire"];
            }
            if (($prod["1"]["conditionnement"] != "")) {
                $cond = $prod["1"]["conditionnement"];
            }

            if (($prod["1"]["datefab"] != NULL) && ($prod["1"]["dateper"] != NULL)) {
                $con->query("update hp_produit set idclassemedicamenteuse=" . $clase . ", idconditionnement=" . $cond . ", iddosage=" . $dosa . ", "
                                . "idforme=" . $fom . ", idlaboratoireproduit=" . $labo . ", "
                                . "idvalorisationstock='" . $prod["1"]["valorisation"] . "', codeproduit='" . $prod["1"]["codepe"] . "', "
                                . "libelleproduit='" . $desp . "', imageproduit='" . $imageprod . "', idcategorie='" . $prod["1"]["cat"] . "', "
                                . "stockminproduit='" . $prod["1"]["qtemin"] . "', stockmaxproduit='" . $prod["1"]["qtemax"] . "', prixachatproduit='" . $prod["1"]["prixa"] . "', "
                                . "uniteachatproduit='" . $prod["1"]["unitea"] . "', uniteventeproduit='" . $prod["1"]["unitev"] . "', "
                                . "unitesortieproduit='" . $prod["1"]["unites"] . "', datefabricationproduit='" . $prod["1"]["datefab"] . "', "
                                . "dateperemptionproduit='" . $prod["1"]["dateper"] . "' where idproduit='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
            } else if (($prod["1"]["datefab"] != NULL) && ($prod["1"]["dateper"] == NULL)) {
                $con->query("update hp_produit set idclassemedicamenteuse=" . $clase . ", idconditionnement=" . $cond . ", iddosage=" . $dosa . ", "
                                . "idforme=" . $fom . ", idlaboratoireproduit=" . $labo . ", "
                                . "idvalorisationstock='" . $prod["1"]["valorisation"] . "', codeproduit='" . $prod["1"]["codepe"] . "', "
                                . "libelleproduit='" . $desp . "', imageproduit='" . $imageprod . "', idcategorie='" . $prod["1"]["cat"] . "', "
                                . "stockminproduit='" . $prod["1"]["qtemin"] . "', stockmaxproduit='" . $prod["1"]["qtemax"] . "', prixachatproduit='" . $prod["1"]["prixa"] . "', "
                                . "uniteachatproduit='" . $prod["1"]["unitea"] . "', uniteventeproduit='" . $prod["1"]["unitev"] . "', "
                                . "unitesortieproduit='" . $prod["1"]["unites"] . "', datefabricationproduit='" . $prod["1"]["datefab"] . "' "
                                . " where idproduit='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
            } else if (($prod["1"]["datefab"] == NULL) && ($prod["1"]["dateper"] != NULL)) {
                $con->query("update hp_produit set idclassemedicamenteuse=" . $clase . ", idconditionnement=" . $cond . ", iddosage=" . $dosa . ", "
                                . "idforme=" . $fom . ", idlaboratoireproduit=" . $labo . ", "
                                . "idvalorisationstock='" . $prod["1"]["valorisation"] . "', codeproduit='" . $prod["1"]["codepe"] . "', "
                                . "libelleproduit='" . $desp . "', imageproduit='" . $imageprod . "', idcategorie='" . $prod["1"]["cat"] . "', "
                                . "stockminproduit='" . $prod["1"]["qtemin"] . "', stockmaxproduit='" . $prod["1"]["qtemax"] . "', prixachatproduit='" . $prod["1"]["prixa"] . "', "
                                . "uniteachatproduit='" . $prod["1"]["unitea"] . "', uniteventeproduit='" . $prod["1"]["unitev"] . "', "
                                . "unitesortieproduit='" . $prod["1"]["unites"] . "', dateperemptionproduit='" . $prod["1"]["dateper"] . "' "
                                . "where idproduit='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
            } else {
                $con->query("update hp_produit set idclassemedicamenteuse=" . $clase . ", idconditionnement=" . $cond . ", iddosage=" . $dosa . ", "
                                . "idforme=" . $fom . ", idlaboratoireproduit=" . $labo . ", "
                                . "idvalorisationstock='" . $prod["1"]["valorisation"] . "', codeproduit='" . $prod["1"]["codepe"] . "', "
                                . "libelleproduit='" . $desp . "', imageproduit='" . $imageprod . "', idcategorie='" . $prod["1"]["cat"] . "', "
                                . "stockminproduit='" . $prod["1"]["qtemin"] . "', stockmaxproduit='" . $prod["1"]["qtemax"] . "', prixachatproduit='" . $prod["1"]["prixa"] . "', "
                                . "uniteachatproduit='" . $prod["1"]["unitea"] . "', uniteventeproduit='" . $prod["1"]["unitev"] . "', "
                                . "unitesortieproduit='" . $prod["1"]["unites"] . "' where idproduit='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
            }

            $obj = $prod["1"]["codepe"];
//            $obj = $prod["1"]["codep"] . "->" . $prod["1"]["qtes"] . "->" . $prod["1"]["prixa"];
            $op = "Modification";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idproduit, objet, operation, datetrace) values("
                                . "'" . $prod["1"]["idproduit"] . "', '" . $obj . "', "
                                . "'" . $op . "', NOW())") or die(mysqli_error($con));
            } else {

                $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, datetrace) values("
                                . "'" . $prod["1"]["idproduit"] . "', '" . $_SESSION["idcomptepersonnel"] . "', '" . $obj . "', "
                                . "'" . $op . "', NOW())") or die(mysqli_error($con));
            }

            unset($_SESSION['formproduite']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";

            $pag = 'hopitalpages/hopitalproduit/lister_produit';
            die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '">');
        } else {
            $row = mysqli_fetch_assoc($req);
            if ($row["idproduit"] == $prod["1"]["idproduit"]) {
                $imageprod = $prod["1"]["imagepstring"];
                if ($prod["1"]["imagep"] != "null") {
                    $reqim = $con->query("select * from hp_produit where imageproduit='" . $prod["1"]["imagep"]['name'] . "'") or die(mysqli_error($con));
                    $nbim = mysqli_num_rows($reqim);

                    if (($nbim == 0)) {
                        if (!is_dir("hopitalupload/images/")) {

// puis on créer les 2 dossiers, qui contiendront les originaux et les miniatures
// avec tous les droits ( écriture, lecture , suppression )
                            @mkdir("hopitalupload/images/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                            if (is_dir("hopitalupload/images/")) {
// On peut valider le fichier et le stocker définitivement
                                move_uploaded_file($prod["1"]["imagep"]['tmp_name'], "hopitalupload/images/" . basename($prod["1"]["imagep"]['name']));

                                $imageprod = $prod["1"]["imagep"]['name'];
                            } else {
                                echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";

                                $pag = 'hopitalpages/hopitalproduit/hopitalediter/editer_produit';
                                die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '&produit=' . ($prod["1"]["idproduit"]) . '">');
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre boutique </br> Veuillez contacter votre administrateur</p>";
                            }
                        } else {
// On peut valider le fichier et le stocker définitivement
                            move_uploaded_file($prod["1"]["imagep"]['tmp_name'], "hopitalupload/images/" . basename($prod["1"]["imagep"]['name']));
                            $imageprod = $prod["1"]["imagep"]['name'];
                        }
                    }
                }

                $clase = "null";
                $fom = "null";
                $dosa = "null";
                $labo = "null";
                $cond = "null";
                if (($prod["1"]["classe"] != "")) {
                    $clase = $prod["1"]["classe"];
                }
                if (($prod["1"]["forme"] != "")) {
                    $fom = $prod["1"]["forme"];
                }
                if (($prod["1"]["dosage"] != "")) {
                    $dosa = $prod["1"]["dosage"];
                }
                if (($prod["1"]["laboratoire"] != "")) {
                    $labo = $prod["1"]["laboratoire"];
                }
                if (($prod["1"]["conditionnement"] != "")) {
                    $cond = $prod["1"]["conditionnement"];
                }

                if (($prod["1"]["datefab"] != NULL) && ($prod["1"]["dateper"] != NULL)) {
                    $con->query("update hp_produit set idclassemedicamenteuse=" . $clase . ", idconditionnement=" . $cond . ", iddosage=" . $dosa . ", "
                                    . "idforme=" . $fom . ", idlaboratoireproduit=" . $labo . ", "
                                    . "idvalorisationstock='" . $prod["1"]["valorisation"] . "', codeproduit='" . $prod["1"]["codepe"] . "', "
                                    . "libelleproduit='" . $desp . "', imageproduit='" . $imageprod . "', idcategorie='" . $prod["1"]["cat"] . "', "
                                    . "stockminproduit='" . $prod["1"]["qtemin"] . "', stockmaxproduit='" . $prod["1"]["qtemax"] . "', prixachatproduit='" . $prod["1"]["prixa"] . "', "
                                    . "uniteachatproduit='" . $prod["1"]["unitea"] . "', uniteventeproduit='" . $prod["1"]["unitev"] . "', "
                                    . "unitesortieproduit='" . $prod["1"]["unites"] . "', datefabricationproduit='" . $prod["1"]["datefab"] . "', "
                                    . "dateperemptionproduit='" . $prod["1"]["dateper"] . "' where idproduit='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
                } else if (($prod["1"]["datefab"] != NULL) && ($prod["1"]["dateper"] == NULL)) {
                    $con->query("update hp_produit set idclassemedicamenteuse=" . $clase . ", idconditionnement=" . $cond . ", iddosage=" . $dosa . ", "
                                    . "idforme=" . $fom . ", idlaboratoireproduit=" . $labo . ", "
                                    . "idvalorisationstock='" . $prod["1"]["valorisation"] . "', codeproduit='" . $prod["1"]["codepe"] . "', "
                                    . "libelleproduit='" . $desp . "', imageproduit='" . $imageprod . "', idcategorie='" . $prod["1"]["cat"] . "', "
                                    . "stockminproduit='" . $prod["1"]["qtemin"] . "', stockmaxproduit='" . $prod["1"]["qtemax"] . "', prixachatproduit='" . $prod["1"]["prixa"] . "', "
                                    . "uniteachatproduit='" . $prod["1"]["unitea"] . "', uniteventeproduit='" . $prod["1"]["unitev"] . "', "
                                    . "unitesortieproduit='" . $prod["1"]["unites"] . "', datefabricationproduit='" . $prod["1"]["datefab"] . "' "
                                    . " where idproduit='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
                } else if (($prod["1"]["datefab"] == NULL) && ($prod["1"]["dateper"] != NULL)) {
                    $con->query("update hp_produit set idclassemedicamenteuse=" . $clase . ", idconditionnement=" . $cond . ", iddosage=" . $dosa . ", "
                                    . "idforme=" . $fom . ", idlaboratoireproduit=" . $labo . ", "
                                    . "idvalorisationstock='" . $prod["1"]["valorisation"] . "', codeproduit='" . $prod["1"]["codepe"] . "', "
                                    . "libelleproduit='" . $desp . "', imageproduit='" . $imageprod . "', idcategorie='" . $prod["1"]["cat"] . "', "
                                    . "stockminproduit='" . $prod["1"]["qtemin"] . "', stockmaxproduit='" . $prod["1"]["qtemax"] . "', prixachatproduit='" . $prod["1"]["prixa"] . "', "
                                    . "uniteachatproduit='" . $prod["1"]["unitea"] . "', uniteventeproduit='" . $prod["1"]["unitev"] . "', "
                                    . "unitesortieproduit='" . $prod["1"]["unites"] . "', dateperemptionproduit='" . $prod["1"]["dateper"] . "' "
                                    . "where idproduit='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
                } else {
                    $con->query("update hp_produit set idclassemedicamenteuse=" . $clase . ", idconditionnement=" . $cond . ", iddosage=" . $dosa . ", "
                                    . "idforme=" . $fom . ", idlaboratoireproduit=" . $labo . ", "
                                    . "idvalorisationstock='" . $prod["1"]["valorisation"] . "', codeproduit='" . $prod["1"]["codepe"] . "', "
                                    . "libelleproduit='" . $desp . "', imageproduit='" . $imageprod . "', idcategorie='" . $prod["1"]["cat"] . "', "
                                    . "stockminproduit='" . $prod["1"]["qtemin"] . "', stockmaxproduit='" . $prod["1"]["qtemax"] . "', prixachatproduit='" . $prod["1"]["prixa"] . "', "
                                    . "uniteachatproduit='" . $prod["1"]["unitea"] . "', uniteventeproduit='" . $prod["1"]["unitev"] . "', "
                                    . "unitesortieproduit='" . $prod["1"]["unites"] . "' where idproduit='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
                }

                $obj = $prod["1"]["codepe"];
//            $obj = $prod["1"]["codep"] . "->" . $prod["1"]["qtes"] . "->" . $prod["1"]["prixa"];
                $op = "Modification";
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $con->query("insert into hp_trace(idproduit, objet, operation, datetrace) values("
                                    . "'" . $prod["1"]["idproduit"] . "', '" . $obj . "', "
                                    . "'" . $op . "', NOW())") or die(mysqli_error($con));
                } else {
                    $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, datetrace) values("
                                    . "'" . $prod["1"]["idproduit"] . "', '" . $_SESSION["idcomptepersonnel"] . "', '" . $obj . "', "
                                    . "'" . $op . "', NOW())") or die(mysqli_error($con));
                }

                unset($_SESSION['formproduite']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";

                $pag = 'hopitalpages/hopitalproduit/lister_produit';
                die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '">');
            } else {
                echo "<script language='javascript'>$('div.alertaddprdtmauv').show('slow').delay(8000).hide('slow');</script>";

                $pag = 'hopitalpages/hopitalproduit/hopitalediter/editer_produit';
                die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '&produit=' . ($prod["1"]["idproduit"]) . '">');
            }
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";

        $pag = 'hopitalpages/hopitalproduit/hopitalediter/editer_produit';
        die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '&produit=' . ($prod["1"]["idproduit"]) . '">');
    }
}

//fonction pour modifier un prix de vente
function update_prix_vente_produit($produitv, $prixvent, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
//    echo "<script language='javascript'>alert($produitv)</script>";
//    echo "<script language='javascript'>alert($prixvent)</script>";
//    echo "<script language='javascript'>alert('slow')</script>";
    $con->query("update hp_produit set prixventeproduit='" . $prixvent . "' where idproduit='" . $produitv . "'") or die(mysqli_error($con));

    $rsltuarpap = $con->query("select * from hp_conversion where idproduit='" . $produitv . "'") or die(mysqli_error($con));
    while ($rowarpap = mysqli_fetch_assoc($rsltuarpap)) {

        $prl2 = 0;
        if ($rowarpap["conversion"] != 0) {
            $prl2 = (($prixvent) / ($rowarpap["conversion"]));
        }
        $con->query("update hp_conversion set prixconversion='" . $prl2 . "' "
                        . "where idunite='" . $rowarpap["idunite"] . "' and idproduit='" . $produitv . "'") or die(mysqli_error($con));
    }
    $reqamb = $con->query("select * from hp_boutique as mb where mb.idproduit='" . $produitv . "'") or die(mysqli_error($con));
    while ($rowamb = mysqli_fetch_assoc($reqamb)) {
        $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowamb["iduniteboutique"] . "' "
                . "and idproduit='" . $produitv . "'") or die(mysqli_error($con));
        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
        $con->query("update hp_boutique set prixventeboutique='" . $rowarpa["prixconversion"] . "' where "
                        . "idboutique='" . $rowamb["idboutique"] . "'") or die(mysqli_error($con));
    }
    $pag = 'hopitalpages/hopitalproduit/lister_produit';
    die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '">');
}

function lister_unite_produit($idp, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_conversion as c left join hp_unite as u on "
            . "c.idunite=u.idunite where c.idproduit='" . $idp . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["conversion"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stockconversion"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixconversion"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleunite"])) ?></td>
            <td>
        <!--                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalconversion/hopitalajouter/ajouter_conversion') ?>&conversion=<?php echo $recuser["id_conversion"] ?>">
                    <span title="Modifier cette conversion" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                </a>-->
            </td>
        </tr>
        <?php
    }
}

function inserer_unite_produit($prod, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $idp = $prod["1"]["produit"];
        $reqta = $con->query("select * from hp_conversion where idproduit='" . $prod["1"]["produit"] . "' and idunite='" . $prod["1"]["unite"] . "'") or die(mysqli_error($con));
        $nbta = mysqli_num_rows($reqta);
        if ($nbta == 0) {
            $reqtar = $con->query("select * from hp_produit where "
                    . "idproduit='" . $prod["1"]["produit"] . "'") or die(mysqli_error($con));
            $rowa = mysqli_fetch_assoc($reqtar);
            $prixc = 0;
            if ($rowa["uniteachatproduit"] == $prod["1"]["unite"]) {
                $prixc = $rowa["prixventeproduit"];
            } else if ($prod["1"]["conver"] != 0) {
                $prixc = ceil(($rowa["prixventeproduit"] / $prod["1"]["conver"]));
            }
            $con->query("insert into hp_conversion(idunite, idproduit, conversion, "
                            . "stockconversion, prixconversion) values('" . $prod["1"]["unite"] . "', "
                            . "'" . $prod["1"]["produit"] . "', '" . $prod["1"]["conver"] . "', '" . $prod["1"]["stock"] . "', "
                            . "'" . $prixc . "')") or die(mysqli_error($con));
            unset($_SESSION['formprodunite']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalproduit/hopitalconversion/lister_conversion';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&produit=' . $idp . '">');
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalproduit/hopitalconversion/hopitalajouter/ajouter_conversion';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&produit=' . $idp . '">');
    }
}

//gestion des produits
function inserer_produit_livraison($prod, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $desp = addslashes($prod["1"]["desp"]);
        $quantitea = 0;
        $ca = $prod["1"]["cat"];
//        echo"<script language='javascript'>alert($ca)</script>";

        $req = $con->query("select * from hp_produit where code_produit='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        $reqim = $con->query("select * from hp_produit where image_produit='" . $prod["1"]["imagep"] . "'") or die(mysqli_error($con));
        $nbim = mysqli_num_rows($reqim);

        if (($nb == 0)) {
            $imageprod = NULL;
            if ($prod["1"]["imagep"] != "null") {
                if (($nbim == 0)) {
                    $imageprod = $prod["1"]["imagep"];
                }
            }

            if (isset($_SESSION["id_compte_personnel"])) {
                $rslta = $con->query("insert into hp_produit(id_compte_personnel, code_produit, libelle_produit, "
                        . "image_produit, id_categorie, id_fourniture, date_produit) values("
                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prod["1"]["codep"] . "', "
                        . "'" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', "
                        . "'" . $prod["1"]["four"] . "', NOW())") or die(mysqli_error($con));
            } else {
                $rslta = $con->query("insert into hp_produit(code_produit, libelle_produit, image_produit, "
                        . "id_categorie, id_fourniture, date_produit) values('" . $prod["1"]["codep"] . "', "
                        . "'" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', "
                        . "'" . $prod["1"]["four"] . "', NOW())") or die(mysqli_error($con));
            }
            $reqar = $con->query("select * from hp_produit where code_produit='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltaph = $con->query("insert into hp_produit_point_hopital(id_point_hopital, id_produit, "
                    . "stock_produit, stock_min_produit, stock_max_produit, prix_achat_produit, "
                    . "unite_achat_produit, unite_vente_produit, unite_sortie_produit, "
                    . "date_produit_ph) values('" . $_SESSION["id_point_hopital"] . "', '" . $rowar["id_produit"] . "', "
                    . "'" . $quantitea . "', '" . $prod["1"]["qtemin"] . "', '" . $prod["1"]["qtemax"] . "', "
                    . "'" . $prod["1"]["prixa"] . "', '" . $prod["1"]["unitea"] . "', "
                    . "'" . $prod["1"]["unitev"] . "', '" . $prod["1"]["unites"] . "', NOW())") or die(mysqli_error($con));
            $reqarph = $con->query("select * from hp_produit_point_hopital as aph left join hp_produit "
                    . "as a on aph.id_produit=a.id_produit left join hp_categorie as c on "
                    . "a.id_categorie=c.id_categorie left join hp_fourniture as f on "
                    . "a.id_fourniture=f.id_fourniture where aph.id_produit='" . $rowar["id_produit"] . "' "
                    . "and aph.id_point_hopital='" . $_SESSION["id_point_hopital"] . "'") or die(mysqli_error($con));
            $rowarph = mysqli_fetch_assoc($reqarph);
            if (($prod["1"]["linge"])) {
                $rsltal = $con->query("insert into hp_linge(id_produit_point_hopital, date_linge) "
                        . "values('" . $rowarph["id_produit_point_hopital"] . "', NOW())") or die(mysqli_error($con));
            }
            $obj = $prod["1"]["codep"] . "->" . $prod["1"]["prixa"];
            $op = "Ajout";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_historique(id_produit_point_hopital, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowarph["id_produit_point_hopital"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hp_historique(id_produit_point_hopital, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowarph["id_produit_point_hopital"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }

            unset($_SESSION['formproduit']);
            echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";

            $a = 'hopitalpages/economathopital/bonlivraisonhopital/livraison';
            $idlinge = NULL;
            $prixlinge = 0;
            $rsltlin = $con->query("select * from hp_linge where id_produit_point_hopital='" . $rowarph["id_produit_point_hopital"] . "'") or die(mysqli_error($con));
            $nblin = mysqli_num_rows($rsltlin);
            if ($nblin != 0) {
                $rowlin = mysqli_fetch_assoc($rsltlin);
                $idlinge = $rowlin["id_linge"];
                $prixlinge = $rowlin["prix_lavage_linge"];
            }
            $prodArray = array($rowarph["id_produit_point_hopital"] => array(
                    'idart' => $rowarph["id_produit_point_hopital"],
                    'idlingeart' => $idlinge,
                    'prixlingeart' => $prixlinge,
                    'designationart' => $rowarph["libelle_produit"],
                    'qteart' => 1,
                    'prixarta' => $rowarph["prix_achat_produit"],
                    'prixartv' => $rowarph["prix_vente_produit"],
                    'unitearta' => $rowarph["unite_achat_produit"],
                    'uniteartv' => $rowarph["unite_vente_produit"],
                    'unitearts' => $rowarph["unite_sortie_produit"]
            ));

            if (!empty($_SESSION["cart_prodvlex"])) {
                $f = FALSE;
                foreach ($_SESSION["cart_prodvlex"] as $k => $v) {
                    if (($_SESSION["cart_prodvlex"][$k]["idart"] == $_GET["idp"])) {
                        $f = TRUE;
                        $_SESSION["cart_prodvlex"][$k]["qteart"] = $_SESSION["cart_prodvlex"][$k]["qteart"] + 1;
                    }
                }
                if (!$f) {
                    $_SESSION["cart_prodvlex"] = array_merge($_SESSION["cart_prodvlex"], $prodArray);
                }
            } else {
                $_SESSION["cart_prodvlex"] = $prodArray;
            }

            if (isset($_SESSION["loginproprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '">');
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "DG")) {
                    die('<meta http-equiv="refresh" content="0; URL=indexdg.php?page=' . base64_encode($a) . '">');
                } else {
                    die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
                }
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddprdtmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
    }
}

//gestion des produits
function inserer_produit_commande($prod, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $desp = addslashes($prod["1"]["desp"]);
        $quantitea = 0;
        $ca = $prod["1"]["cat"];
//        echo"<script language='javascript'>alert($ca)</script>";

        $req = $con->query("select * from hp_produit where code_produit='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        $reqim = $con->query("select * from hp_produit where image_produit='" . $prod["1"]["imagep"] . "'") or die(mysqli_error($con));
        $nbim = mysqli_num_rows($reqim);

        if (($nb == 0)) {
            $imageprod = NULL;
            if ($prod["1"]["imagep"] != "null") {
                if (($nbim == 0)) {
                    $imageprod = $prod["1"]["imagep"];
                }
            }

            if (isset($_SESSION["id_compte_personnel"])) {
                $rslta = $con->query("insert into hp_produit(id_compte_personnel, code_produit, libelle_produit, "
                        . "image_produit, id_categorie, id_fourniture, date_produit) values("
                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prod["1"]["codep"] . "', "
                        . "'" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', "
                        . "'" . $prod["1"]["four"] . "', NOW())") or die(mysqli_error($con));
            } else {
                $rslta = $con->query("insert into hp_produit(code_produit, libelle_produit, image_produit, "
                        . "id_categorie, id_fourniture, date_produit) values('" . $prod["1"]["codep"] . "', "
                        . "'" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', "
                        . "'" . $prod["1"]["four"] . "', NOW())") or die(mysqli_error($con));
            }
            $reqar = $con->query("select * from hp_produit where code_produit='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltaph = $con->query("insert into hp_produit_point_hopital(id_point_hopital, id_produit, "
                    . "stock_produit, stock_min_produit, stock_max_produit, prix_achat_produit, "
                    . "unite_achat_produit, unite_vente_produit, unite_sortie_produit, "
                    . "date_produit_ph) values('" . $_SESSION["id_point_hopital"] . "', '" . $rowar["id_produit"] . "', "
                    . "'" . $quantitea . "', '" . $prod["1"]["qtemin"] . "', '" . $prod["1"]["qtemax"] . "', "
                    . "'" . $prod["1"]["prixa"] . "', '" . $prod["1"]["unitea"] . "', "
                    . "'" . $prod["1"]["unitev"] . "', '" . $prod["1"]["unites"] . "', NOW())") or die(mysqli_error($con));
            $reqarph = $con->query("select * from hp_produit_point_hopital as aph left join hp_produit "
                    . "as a on aph.id_produit=a.id_produit left join hp_categorie as c on "
                    . "a.id_categorie=c.id_categorie left join hp_fourniture as f on "
                    . "a.id_fourniture=f.id_fourniture where aph.id_produit='" . $rowar["id_produit"] . "' "
                    . "and aph.id_point_hopital='" . $_SESSION["id_point_hopital"] . "'") or die(mysqli_error($con));
            $rowarph = mysqli_fetch_assoc($reqarph);
            if (($prod["1"]["linge"])) {
                $rsltal = $con->query("insert into hp_linge(id_produit_point_hopital, date_linge) "
                        . "values('" . $rowarph["id_produit_point_hopital"] . "', NOW())") or die(mysqli_error($con));
            }
            $obj = $prod["1"]["codep"] . "->" . $prod["1"]["prixa"];
            $op = "Ajout";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_historique(id_produit_point_hopital, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowarph["id_produit_point_hopital"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hp_historique(id_produit_point_hopital, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowarph["id_produit_point_hopital"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }

            unset($_SESSION['formproduit']);
            echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";

            $a = 'hopitalpages/economathopital/boncommandehopital/commande';
            $idlinge = NULL;
            $prixlinge = 0;
            $rsltlin = $con->query("select * from hp_linge where id_produit_point_hopital='" . $rowarph["id_produit_point_hopital"] . "'") or die(mysqli_error($con));
            $nblin = mysqli_num_rows($rsltlin);
            if ($nblin != 0) {
                $rowlin = mysqli_fetch_assoc($rsltlin);
                $idlinge = $rowlin["id_linge"];
                $prixlinge = $rowlin["prix_lavage_linge"];
            }
            $prodArray = array($rowarph["id_produit_point_hopital"] => array(
                    'idart' => $rowarph["id_produit_point_hopital"],
                    'idlingeart' => $idlinge,
                    'prixlingeart' => $prixlinge,
                    'designationart' => $rowarph["libelle_produit"],
                    'qteart' => 1,
                    'prixarta' => $rowarph["prix_achat_produit"],
                    'prixartv' => $rowarph["prix_vente_produit"],
                    'unitearta' => $rowarph["unite_achat_produit"],
                    'uniteartv' => $rowarph["unite_vente_produit"],
                    'unitearts' => $rowarph["unite_sortie_produit"]
            ));

            if (!empty($_SESSION["cart_prodvcex"])) {
                $f = FALSE;
                foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                    if (($_SESSION["cart_prodvcex"][$k]["idart"] == $_GET["idp"])) {
                        $f = TRUE;
                        $_SESSION["cart_prodvcex"][$k]["qteart"] = $_SESSION["cart_prodvcex"][$k]["qteart"] + 1;
                    }
                }
                if (!$f) {
                    $_SESSION["cart_prodvcex"] = array_merge($_SESSION["cart_prodvcex"], $prodArray);
                }
            } else {
                $_SESSION["cart_prodvcex"] = $prodArray;
            }

            if (isset($_SESSION["loginproprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '">');
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "DG")) {
                    die('<meta http-equiv="refresh" content="0; URL=indexdg.php?page=' . base64_encode($a) . '">');
                } else {
                    die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
                }
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddprdtmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_produit_hopital($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_produit as a left join "
            . "hp_categorie as c on a.id_categorie=c.id_categorie left "
            . "join hp_fourniture as f on a.id_fourniture=f.id_fourniture "
            . "order by a.libelle_produit asc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_fourniture"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php
                if ($recuser["etat_produit"]) {
                    ?>
                    <a href='#' onclick=desactive_produit(<?php echo $recuser["id_produit"] ?>)>
                        <span title="Desactiver cet produit" alt="desactiver"><i class="glyphicon glyphicon-check"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href='#' onclick=active_produit(<?php echo $recuser["id_produit"] ?>)>
                        <span title="Activer cet produit" alt="activer"><i class="glyphicon glyphicon-move"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_produit"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltuserph = $con->query("select * from hp_produit_point_hopital as aph "
                            . "where aph.id_point_hopital='" . $_SESSION["id_point_hopital"] . "' and "
                            . "aph.id_produit='" . $recuser["id_produit"] . "'") or die(mysqli_error($con));
                    $nbph = mysqli_num_rows($rsltuserph);
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediter/editer_produit') ?>&produit=<?php echo $recuser["id_produit"] ?>">
                        <span title="Modifier cet produit" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_produit(<?php echo $recuser["id_produit"] ?>)>
                        <span title="Supprimer cet produit" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                    if (($nbph == 0)) {
                        ?>&nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalajouterph/ajouter_produit') ?>&produit=<?php echo $recuser["id_produit"] ?>">
                            <span title="Vendre cet produit" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        $rsltuserph = $con->query("select * from hp_produit_point_hopital as aph "
                                . "where aph.id_point_hopital='" . $_SESSION["id_point_hopital"] . "' and "
                                . "aph.id_produit='" . $recuser["id_produit"] . "'") or die(mysqli_error($con));
                        $nbph = mysqli_num_rows($rsltuserph);
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediter/editer_produit') ?>&produit=<?php echo $recuser["id_produit"] ?>">
                            <span title="Modifier cet produit" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href='#' onclick=del_produit(<?php echo $recuser["id_produit"] ?>)>
                            <span title="Supprimer cet produit" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                        if (($nbph == 0)) {
                            ?>&nbsp;&nbsp;
                            <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalajouterph/ajouter_produit') ?>&produit=<?php echo $recuser["id_produit"] ?>">
                                <span title="Vendre cet produit" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        $rsltuserph = $con->query("select * from hp_produit_point_hopital as aph "
                                . "where aph.id_point_hopital='" . $_SESSION["id_point_hopital"] . "' and "
                                . "aph.id_produit='" . $recuser["id_produit"] . "'") or die(mysqli_error($con));
                        $nbph = mysqli_num_rows($rsltuserph);
                        ?>
                        <?php
                        if (($_SESSION["id_compte_personnel"] == $recuser["id_compte_personnel"])) {
                            ?>
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediter/editer_produit') ?>&produit=<?php echo $recuser["id_produit"] ?>">
                                <span title="Modifier cet produit" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                            </a>
                            &nbsp;&nbsp;
                            <a href='#' onclick=del_produit(<?php echo $recuser["id_produit"] ?>)>
                                <span title="Supprimer cet produit" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                        if (($nbph == 0)) {
                            ?>&nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalajouterph/ajouter_produit') ?>&produit=<?php echo $recuser["id_produit"] ?>">
                                <span title="Vendre cet produit" alt="ajouter"><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <?php
                        }
                        ?>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_produit_alert($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_produit_point_hopital as aph left join hp_produit as a on "
            . "aph.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie left "
            . "join hp_fourniture as f on a.id_fourniture=f.id_fourniture where "
            . "aph.id_point_hopital='" . $id . "' and aph.stock_produit<aph.stock_min_produit "
            . "order by a.libelle_produit asc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_fourniture"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php
                if ($recuser["stock_min_produit"] >= $recuser["stock_produit"]) {
                    ?>
                    <b style="color: red">
                        <?php
                        print nl2br(htmlspecialchars($recuser["stock_produit"]));
                        ?>
                    </b>
                    <?php
                } else {
                    ?>
                    <b>
                        <?php
                        print nl2br(htmlspecialchars($recuser["stock_produit"]));
                        ?>
                    </b>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_achat_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_vente_produit"])) ?></td>
            <td>
                <?php
                $rsltul = $con->query("select * from hp_linge where id_produit_point_hopital='" . $recuser["id_produit_point_hopital"] . "'") or die(mysqli_error($con));
                $nbl = mysqli_num_rows($rsltul);
                if ($nbl != 0) {
                    $rowl = mysqli_fetch_assoc($rsltul);
                    print nl2br(htmlspecialchars($rowl["prix_lavage_linge"]));
                    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                        ?>
                        <a href="#modaleditprlavage" role="button" data-toggle="modal" data-id="<?php echo $recuser["id_produit_point_hopital"] ?>" class="prix-lavage">
                            <span title="Modifier le prix de lavage de ce linge" alt="editer"><i class="glyphicon glyphicon-credit-card"></i></span>
                        </a>
                        <?php
                    } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                        if (($_SESSION["code_service"] == "DG")) {
                            ?>
                            <a href="#modaleditprlavage" role="button" data-toggle="modal" data-id="<?php echo $recuser["id_produit_point_hopital"] ?>" class="prix-lavage">
                                <span title="Modifier le prix de lavage de ce linge" alt="editer"><i class="glyphicon glyphicon-credit-card"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
            <td>
                <?php
                $rsltua = $con->query("select * from hp_unite where id_unite='" . $recuser["unite_achat_produit"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["libelle_unite"]));
                ?>
            </td>
            <td>
                <?php
                $rsltuv = $con->query("select * from hp_unite where id_unite='" . $recuser["unite_vente_produit"] . "'") or die(mysqli_error($con));
                $rowv = mysqli_fetch_assoc($rsltuv);
                print nl2br(htmlspecialchars($rowv["libelle_unite"]));
                ?>
            </td>
            <td>
                <?php
                $rsltus = $con->query("select * from hp_unite where id_unite='" . $recuser["unite_sortie_produit"] . "'") or die(mysqli_error($con));
                $rows = mysqli_fetch_assoc($rsltus);
                print nl2br(htmlspecialchars($rows["libelle_unite"]));
                ?>
            </td>
            <td>
                <?php
                if ($recuser["etat_produit"]) {
                    ?>
                    <a href='#' onclick=desactive_produit(<?php echo $recuser["id_produit"] ?>)>
                        <span title="Desactiver cet produit" alt="desactiver"><i class="glyphicon glyphicon-check"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href='#' onclick=active_produit(<?php echo $recuser["id_produit"] ?>)>
                        <span title="Activer cet produit" alt="activer"><i class="glyphicon glyphicon-move"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_produit"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediter/editer_produit') ?>&produit=<?php echo $recuser["id_produit"] ?>">
                        <span title="Modifier cet produit" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_produit(<?php echo $recuser["id_produit"] ?>)>
                        <span title="Supprimer cet produit" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediter/editer_produit') ?>&produit=<?php echo $recuser["id_produit"] ?>">
                            <span title="Modifier cet produit" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href='#' onclick=del_produit(<?php echo $recuser["id_produit"] ?>)>
                            <span title="Supprimer cet produit" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <?php
                        if (($_SESSION["id_compte_personnel"] == $recuser["id_compte_personnel"])) {
                            ?>
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediter/editer_produit') ?>&produit=<?php echo $recuser["id_produit_point_hopital"] ?>">
                                <span title="Modifier cet produit" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediterph/editer_produit') ?>&produit=<?php echo $recuser["id_produit_point_hopital"] ?>">
                                <span title="Modifier cet produit" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                            </a>
                            <?php
                        }
                        ?>&nbsp;&nbsp;
                        <a href='#' onclick=del_produit(<?php echo $recuser["id_produit"] ?>)>
                            <span title="Supprimer cet produit" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_produit_mouvement($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_produit_point_hopital as aph left join hp_produit as a on "
            . "aph.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie left "
            . "join hp_fourniture as f on a.id_fourniture=f.id_fourniture "
            . "where aph.id_point_hopital='" . $id . "' order by a.libelle_produit asc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_produit"])) ?></td>
            <!--<td><?php // print nl2br(htmlspecialchars($recuser["libelle_fourniture"]))                                  ?></td>-->
            <!--<td><?php // print nl2br(htmlspecialchars($recuser["libelle_categorie"]))                                    ?></td>-->
            <!--<td>-->
            <?php
//                if ($recuser["stock_min_produit"] >= $recuser["stock_produit"]) {
            ?>
            <!--<b style="color: red">-->
            <?php
//                        print nl2br(htmlspecialchars($recuser["stock_produit"]));
            ?>
            <!--</b>-->
            <?php
//                } else {
            ?>
            <!--<b>-->
            <?php
//                        print nl2br(htmlspecialchars($recuser["stock_produit"]));
            ?>
            <!--</b>-->
            <?php
//                }
            ?>
            <!--</td>-->
        <!--            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_achat_produit"])) ?></td>
            <td>-->
            <?php
//                print nl2br(htmlspecialchars($recuser["prix_vente_produit"]));
            ?>
            <!--            </td>
                        <td>-->
            <?php
//                $rsltul = $con->query("select * from hp_linge where id_produit_point_hopital='" . $recuser["id_produit_point_hopital"] . "'") or die(mysqli_error($con));
//                $nbl = mysqli_num_rows($rsltul);
//                if ($nbl != 0) {
//                    $rowl = mysqli_fetch_assoc($rsltul);
//                    print nl2br(htmlspecialchars($rowl["prix_lavage_linge"]));
//                    
//                }
            ?>
            <!--            </td>
                        <td>-->
            <?php
//                $rsltua = $con->query("select * from hp_unite where id_unite='" . $recuser["unite_achat_produit"] . "'") or die(mysqli_error($con));
//                $rowa = mysqli_fetch_assoc($rsltua);
//                print nl2br(htmlspecialchars($rowa["libelle_unite"]));
            ?>
            <!--            </td>
                        <td>-->
            <?php
//                $rsltuv = $con->query("select * from hp_unite where id_unite='" . $recuser["unite_vente_produit"] . "'") or die(mysqli_error($con));
//                $rowv = mysqli_fetch_assoc($rsltuv);
//                print nl2br(htmlspecialchars($rowv["libelle_unite"]));
            ?>
            <!--            </td>
                        <td>-->
            <?php
//                $rsltus = $con->query("select * from hp_unite where id_unite='" . $recuser["unite_sortie_produit"] . "'") or die(mysqli_error($con));
//                $rows = mysqli_fetch_assoc($rsltus);
//                print nl2br(htmlspecialchars($rows["libelle_unite"]));
            ?>
            <!--            </td>
                        <td>-->
            <?php
//                if ($recuser["etat_produit"]) {
            ?>
            <!--                    <a href='#' onclick=desactive_produit(<?php echo $recuser["id_produit"] ?>)>
                                    <span title="Desactiver cet produit" alt="desactiver"><i class="glyphicon glyphicon-check"></i></span>
                                </a>-->
            <?php
//                } else {
            ?>
            <!--                    <a href='#' onclick=active_produit(<?php echo $recuser["id_produit"] ?>)>
                                    <span title="Activer cet produit" alt="activer"><i class="glyphicon glyphicon-move"></i></span>
                                </a>-->
            <?php
//                }
            ?>
            <!--</td>-->
            <!--<td><?php print nl2br(htmlspecialchars($recuser["date_produit"])) ?></td>-->
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/economathopital/mouvementproduithopital/mouvement_produit_hp_form') ?>&produit=<?php echo $recuser["id_produit_point_hopital"] ?>">
                        <span title="Mouvement de cet produit" alt="mouvement"><i class="glyphicon glyphicon-send"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/economathopital/mouvementproduithopital/mouvement_produit_hp_form') ?>&produit=<?php echo $recuser["id_produit_point_hopital"] ?>">
                            <span title="Mouvement de cet produit" alt="mouvement"><i class="glyphicon glyphicon-send"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hopitalpages/economathopital/mouvementproduithopital/mouvement_produit_hp_form') ?>&produit=<?php echo $recuser["id_produit_point_hopital"] ?>">
                            <span title="Mouvement de cet produit" alt="mouvement"><i class="glyphicon glyphicon-send"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function update_produit_ph($prod, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $rsltar = $con->query("select * from hp_produit_point_hopital as aph left join hp_produit as a on "
                . "aph.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie left "
                . "join hp_fourniture as f on a.id_fourniture=f.id_fourniture "
                . "where aph.id_produit_point_hopital='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
        $rowar = mysqli_fetch_assoc($rsltar);

        $rsltaph = $con->query("update hp_produit_point_hopital set stock_produit='" . $prod["1"]["qtes"] . "', "
                . "stock_min_produit='" . $prod["1"]["qtemin"] . "', stock_max_produit='" . $prod["1"]["qtemax"] . "', "
                . "prix_achat_produit='" . $prod["1"]["prixa"] . "', unite_achat_produit='" . $prod["1"]["unitea"] . "', "
                . "unite_vente_produit='" . $prod["1"]["unitev"] . "', unite_sortie_produit='" . $prod["1"]["unites"] . "' "
                . "where id_produit_point_hopital='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));

        if (($prod["1"]["linge"])) {
            $rsltl = $con->query("select * from hp_linge where id_produit_point_hopital='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
            $nbl = mysqli_num_rows($rsltl);
            if ($nbl == 0) {
                $rsltal = $con->query("insert into hp_linge(id_produit_point_hopital, date_linge) "
                        . "values('" . $prod["1"]["idproduit"] . "', NOW())") or die(mysqli_error($con));
            }
        } else {
            $rsltl = $con->query("select * from hp_linge where id_produit_point_hopital='" . $prod["1"]["idproduit"] . "'") or die(mysqli_error($con));
            $nbl = mysqli_num_rows($rsltl);
            if ($nbl != 0) {
                $rowl = mysqli_fetch_assoc($rsltl);
                $rslt = $con->query("delete from hp_linge where id_linge='" . $rowl["id_linge"] . "'") or die(mysqli_error($con));
            }
        }
        $obj = $rowar["code_produit"] . "->" . $prod["1"]["qtes"] . "->" . $prod["1"]["prixa"];
        $op = "Modification";
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltvente = $con->query("insert into hp_historique(id_produit_point_hopital, id_proprietaire, objet_h, operation_h, "
                    . "date_histo) values('" . $prod["1"]["idproduit"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                    . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            if (($_SESSION["code_service"] == "ECONO")) {
                $rsltvente = $con->query("insert into hp_historique(id_produit_point_hopital, id_compte_personnel, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["1"]["idproduit"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
        }
        unset($_SESSION['formproduiteph']);
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";

        $pag = 'hopitalpages/hopitalproduit/lister_produit';
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '">');
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            if (($_SESSION["code_service"] == "DG")) {
                die('<meta http-equiv="refresh" content="4; URL=indexdg.php?page=' . base64_encode($pag) . '">');
            } else if (($_SESSION["code_service"] == "ECONO")) {
                die('<meta http-equiv="refresh" content="4; URL=indexpersonnel.php?page=' . base64_encode($pag) . '">');
            }
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
    }
}
