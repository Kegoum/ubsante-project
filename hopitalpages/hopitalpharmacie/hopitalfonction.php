<?php

//fonction pour ajouter un pharmacie
function inserer_pharmacie($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_pharmacie where codepharmacie='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_pharmacie(nompharmacie,codepharmacie, datepharmacie) "
                            . "values('" . addslashes($reg["1"]["pharmacie"]) . "', '" . $reg["1"]["codep"] . "', "
                            . "NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_pharmacie de la valeure {$reg["1"]["pharmacie"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formpharmacie']);
            $pagp = 'hopitalpages/hopitalpharmacie/lister_pharmacie';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpharmacie/hopitalajouter/ajout_pharmacie';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les pharmacies
function lister_pharmacie($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_pharmacie ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idpharmacie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codepharmacie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nompharmacie"])) ?></td>
            <td>
                <?php
                if ($recuser["etatpharmacie"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/pharmacie_ajax'); ?>&idpharmacie=<?php echo $recuser["idpharmacie"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cette Pharmacie ?'));">
                        <span title="D&eacute;sactiver cette pharmacie" data-toggle="tooltip" alt="oui" class="label-success label"><i class="label label-success">Activ&eacute;</i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/pharmacie_ajax'); ?>&idpharmacie=<?php echo $recuser["idpharmacie"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cette Pharmacie ?'));">
                        <span title="Activer cette pharmacie " data-toggle="tooltip" alt="non" class="label-warning label"><i class="label label-warning">D&eacute;sactiv&eacute;</i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalediter/edit_pharmacie'); ?>&idpharmacie=<?php echo $recuser["idpharmacie"]; ?>" >
                    <span title="Modifier cette pharmacie" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                <!--                &nbsp;&nbsp;
                                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/pharmacie_ajax'); ?>&idpharmacie=<?php echo $recuser["idpharmacie"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce pharmacie ?'));" >
                                    <span title="Supprimer cette pharmacie " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                                </a>-->
                <?php
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || ((($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Accueil") || ($_SESSION["rolepersonnel"] == "Magasinier")))) {
                    ?>&nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalmagasin/lister_magasin'); ?>&pharmacie=<?php echo $recuser["idpharmacie"] ?>">
                        <span title="Magasin de cette pharmacie" alt="magasin"><i class="glyphicon glyphicon-home"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraison/lister_livraison'); ?>&pharmacie=<?php echo $recuser["idpharmacie"] ?>">
                        <span title="Bon de livraison de cette pharmacie" alt="bon livraison"><i class="glyphicon glyphicon-import"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalboncommande/lister_commande'); ?>&pharmacie=<?php echo $recuser["idpharmacie"] ?>">
                        <span title="Bon de commande de cette pharmacie" alt="editer"><i class="glyphicon glyphicon-export"></i></span>
                    </a>

                    <?php
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function update_pharmacie($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_pharmacie where codepharmacie='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_pharmacie set codepharmacie='" . $reg["1"]["codepe"] . "', nompharmacie='" . addslashes($reg["1"]["pharmaciee"]) . "' "
                            . "where idpharmacie='" . $reg["1"]["idpharmacie"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_pharmacie de la valeure {$reg["1"]["pharmacie"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formpharmaciee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpharmacie/lister_pharmacie';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idpharmacie"] != $reg["1"]["idpharmacie"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_pharmacie set codepharmacie='" . $reg["1"]["codepe"] . "', nompharmacie='" . addslashes($reg["1"]["pharmaciee"]) . "' "
                                . "where idpharmacie='" . $reg["1"]["idpharmacie"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_pharmacie de la valeure {$reg["1"]["pharmacie"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formpharmaciee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalpharmacie/lister_pharmacie';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalpharmacie/hopitalediter/edit_pharmacie';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idpharmacie=' . $reg["1"]["idpharmacie"] . '">');
            }
        }
    }
}

function lister_boutique($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_boutique as mb left join hp_pharmacie as b on mb.idpharmacie=b.idpharmacie left "
            . "join hp_produit as a on mb.idproduit=a.idproduit left join hp_categorie as c on "
            . "a.idcategorie=c.idcategorie where mb.idpharmacie='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <!--<td><?php // print nl2br(htmlspecialchars($recuser["nom_rest"]))                                 ?></td>-->
            <td><?php print nl2br(htmlspecialchars($recuser["codeproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategorie"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stockboutique"])) ?>
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["iduniteboutique"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["codeunite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["stockminboutique"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stockmaxboutique"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixventeboutique"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatboutique"])) ?></td>
        </tr>
        <?php
    }
}

function lister_commande_pharmacie($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_bon_commande_interne as a left join hp_pharmacie as c on "
            . "a.idpharmacie=c.idpharmacie where a.idpharmacie='" . $id . "' order by a.dateboncommandeinterne desc") or
            die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeboncommandeinterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantboncommandeinterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatboncommandeinterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateboncommandeinterne"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalboncommande/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etatboncommandeiinterne"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalboncommande/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatboncommandeinterne"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="hopitalpages/hopitalpharmacie/hopitalboncommande/facture_commande_pdf.php?boncommande=<?php echo $recuser["idboncommandeinterne"] ?>" target="blank">
                    <span title="Impriner le bon de commande" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="hopitalpages/hopitalpharmacie/hopitalboncommande/facture_commande_excel.php?boncommande=<?php echo $recuser["idboncommandeinterne"] ?>" target="blank">
                    <span title="Exporter le bon de commande" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_pharmacie_ligne($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_ligne_bon_commande_interne as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
            . "lbl.idboncommandeinterne='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stockligneboncommandeinterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stocklivreligneboncommandeinterne"])) ?></td>
            <td>
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["idunite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["codeunite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixligneboncommandeinterne"])) ?></td>
            <td><?php print ($recuser["stockligneboncommandeinterne"] * $recuser["prixligneboncommandeinterne"]); ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatligneboncommandeinterne"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Directeur de Centre")) {
                        ?>

                        <?php
                        if ($recuser["etatligneboncommandei"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=livrer_bon_liv_pharmacie_ligne(<?php echo $recuser["idligneboncommandeinterne"] ?>)>
                                <span title="Livrer cette ligne de bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                        ?>

                        <?php
                        if ($recuser["etatligneboncommandeinterne"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=livrer_bon_liv_pharmacie_ligne(<?php echo $recuser["idligneboncommandeinterne"] ?>)>
                                <span title="Livrer cette ligne de bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["rolepersonnel"] == "Pharmacien")) {
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

function ajouter_commande_pharmacie($prixtotal, $com, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($com != NULL)) {
        $an = date('Y');

        $rsltserv = $con->query("select * from hp_pharmacie as s where s.idpharmacie='" . $_SESSION["idpharmacie"] . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hp_bon_commande_interne where YEAR(dateboncommandeinterne)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = "CI" . date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = "CI" . date('Y', time()) . sprintf("%08d", ($i + 1));
//        if (isset($_SESSION["idcomptepersonnel"])) {
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $con->query("insert into hp_bon_commande_interne(idpharmacie, codeboncommandeinterne, "
                        . "montantboncommandeinterne, dateboncommandeinterne) values("
                        . "'" . $_SESSION["idpharmacie"] . "', '" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        }else{
            $con->query("insert into hp_bon_commande_interne(idcomptepersonnel, idpharmacie, codeboncommandeinterne, "
                        . "montantboncommandeinterne, dateboncommandeinterne) values('" . $_SESSION["idcomptepersonnel"] . "', "
                        . "'" . $_SESSION["idpharmacie"] . "', '" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        }
        
//        } else {
//            $rsltf = $con->query("insert into hp_bon_commande_interne(idpharmacie, id_pharmacie_point_hopital, "
//                    . "codeboncommandei, montantboncommandei, dateboncommandei) values('" . $_SESSION["idpharmacie"] . "', "
//                    . "'" . $_SESSION["id_pharmacie_point_hopital"] . "', '" . $numid . "', '" . $prixtotal . "', "
//                    . "NOW())") or die(mysqli_error($con));
//        }
        $rsltfa = $con->query("select * from hp_bon_commande_interne where codeboncommandeinterne='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvcib"] as $prod) {
            $con->query("insert into hp_ligne_bon_commande_interne(idboncommandeinterne, idunite, idproduit, "
                            . "stockligneboncommandeinterne, prixligneboncommandeinterne) values('" . $rowfa["idboncommandeinterne"] . "', "
                            . "'" . $prod["idunit"] . "', '" . $prod["idart"] . "', '" . $prod["qteart"] . "', "
                            . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));

            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obj = $prod["qteart"] . " " . $prod["uniteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Commande Interne";
//            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
//                $rsltvente = $con->query("insert into hp_historique(idproduit, id_proprietaire, objet_h, operation_h, "
//                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
//                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
//                if (($_SESSION["code_pharmacie"] == "RESTO") || ($_SESSION["code_pharmacie"] == "BARESTO")) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idproduit, objet, operation, datetrace) "
                            . "values('" . $prod["idart"] . "', '" . $obj . "', "
                            . "'" . $op . "', NOW())") or die(mysqli_error($con));
            }else{
                $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, datetrace) "
                            . "values('" . $prod["idart"] . "', '" . $_SESSION["idcomptepersonnel"] . "', '" . $obj . "', "
                            . "'" . $op . "', NOW())") or die(mysqli_error($con));
            }
            
//                }
//            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvcib"]);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hopitalpages/hopitalpharmacie/hopitalboncommande/facture_commande_pdf.php?boncommande=<?php echo $rowfa["idboncommandeinterne"] ?>" class="btn btn-lg btn-info" target="blank">
            <span title="Impriner le bon de commande" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de commande</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_livraisonc_pharmacie($id, $prixtotal, $com, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($com != NULL)) {
        $an = date('Y');


        $rsltpl2 = $con->query("select * from hp_bon_livraison_interne where YEAR(datebonlivraisoninterne)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = "LI" . date('Y', time()) . sprintf("%08d", 1);
        $i = mysqli_num_rows($rsltpl2);
        $numid = "LI" . date('Y', time()) . sprintf("%08d", ($i + 1));

        $rsltplk = $con->query("select * from hp_bon_commande_interne where idboncommandeinterne='" . $id . "'") or die(mysqli_error($con));
        $rowservk = mysqli_fetch_assoc($rsltplk);
//        if (isset($_SESSION["idcomptepersonnel"])) {
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $con->query("insert into hp_bon_livraison_interne(idpharmacie, idmagasin, idboncommandeinterne, "
                        . "codebonlivraisoninterne, montantbonlivraisoninterne, datebonlivraisoninterne) values("
                        . "'" . $rowservk["idpharmacie"] . "', '" . $_SESSION["idmagasin"] . "', "
                        . "'" . $id . "', '" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        }else{
            $con->query("insert into hp_bon_livraison_interne(idcomptepersonnel, idpharmacie, idmagasin, idboncommandeinterne, "
                        . "codebonlivraisoninterne, montantbonlivraisoninterne, datebonlivraisoninterne) values("
                        . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $rowservk["idpharmacie"] . "', '" . $_SESSION["idmagasin"] . "', "
                        . "'" . $id . "', '" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        }
        
//        } else {
//            $rsltf = $con->query("insert into hp_bon_livraison_interne(idpharmacie, id_pharmacie, id_pharmacie_point_hopital, "
//                    . "idboncommandeinterne, codebonlivraisoninterne, montantbonlivraisoninterne, datebonlivraisoninterne) values('" . $_SESSION["idpharmacie"] . "', "
//                    . "'" . $rowservk["id_pharmacie"] . "', '" . $rowservk["id_pharmacie_point_hopital"] . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', "
//                    . "NOW())") or die(mysqli_error($con));
//        }
        $rsltfa = $con->query("select * from hp_bon_livraison_interne where codebonlivraisoninterne='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        $etat = "Valider";
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvlibc" . $id] as $prod) {
            $reqar = $con->query("select * from hp_ligne_bon_commande_interne as lbl left join hp_produit as a on "
                    . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
                    . "lbl.idligneboncommandeinterne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $con->query("insert into hp_ligne_bon_livraison_interne(idbonlivraisoninterne, idunite, idproduit, "
                            . "stocklignebonlivraisoninterne, prixventelignebonlivraisoninterne) values('" . $rowfa["idbonlivraisoninterne"] . "', "
                            . "'" . $prod["uniteartliv"] . "', '" . $rowar["idproduit"] . "', '" . $prod["qteart"] . "', "
                            . "'" . $prod["prixartliv"] . "')") or die(mysqli_error($con));

            $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $prod["uniteartliv"] . "' "
                    . "and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
            $npharmaciepa = mysqli_num_rows($rsltuarpa);

            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
            if ($npharmaciepa != 0) {
                $stockara = $rowarpa["stockconversion"] - $prod["qteart"];
                $rsltuarpapr = $con->query("select * from hp_conversion where idunite<>'" . $prod["uniteartliv"] . "' "
                        . "and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                while ($rowarpapr = mysqli_fetch_assoc($rsltuarpapr)) {
                    $stockarae = 0;
                    if ($rowarpa["stockconversion"] != 0) {
                        $stockarae = ($rowarpapr["stockconversion"] - (($prod["qteart"] * $rowarpapr["stockconversion"]) / $rowarpa["stockconversion"]));
                    }
                    $stockare = 0;
                    if ($stockarae >= 0) {
                        $stockare = $stockarae;
                    } else {
                        $stockare = 0;
                    }
                    $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockare . "' where "
                            . "idunite='" . $rowarpapr["idunite"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                }

                $stockarap = 0;
                if ($rowarpa["stockconversion"] != 0) {
                    $stockarap = $rowar["stockproduit"] - (($prod["qteart"] * $rowar["stockproduit"]) / ($rowarpa["stockconversion"]));
                }
                $stockar = 0;
                if ($stockara >= 0) {
                    $stockar = $stockara;
                } else {
                    $stockar = 0;
                }
                $stockarp = 0;
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }

                $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockar . "' where "
                        . "idunite='" . $prod["uniteartliv"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                $rsltarp = $con->query("update hp_produit set stockproduit='" . $stockarp . "' where "
                        . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
            } else {
                $stockarap = $rowar["stockproduit"] - $prod["qteart"];
                $stockarp = 0;
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }

                $rsltuarpap = $con->query("select * from hp_conversion where idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                while ($rowarpap = mysqli_fetch_assoc($rsltuarpap)) {
                    $stockara = ($rowarpap["stockconversion"] - ($prod["qteart"] * $rowarpap["conversion"]));
                    $stockar = 0;
                    if ($stockara >= 0) {
                        $stockar = $stockara;
                    } else {
                        $stockar = 0;
                    }
                    $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockar . "' where "
                            . "idunite='" . $rowarpap["idunite"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                }


                $rsltarp = $con->query("update hp_produit set stockproduit='" . $stockarp . "' where "
                        . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
            }

            $slivre = $rowar["stocklivreligneboncommandeinterne"] + $prod["qteart"];
            if ($prod["stockok"]) {
                $rslt = $con->query("update hp_ligne_bon_commande_interne set stocklivreligneboncommandeinterne='" . $slivre . "', "
                        . "etatligneboncommandeinterne='" . $etat . "' where idligneboncommandeinterne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
                $rslt = $con->query("update hp_ligne_bon_commande_interne set stocklivreligneboncommandeinterne='" . $slivre . "' "
                        . "where idligneboncommandeinterne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            }


            $prixt = $prixt + ($prod["uniteartv"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Interne";
//            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
//                $rsltvente = $con->query("insert into hp_historique(idproduit, id_proprietaire, objet_h, operation_h, "
//                        . "date_histo) values('" . $rowar["idproduit"] . "', '" . $_SESSION["id_proprietaire"] . "', "
//                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
//                if (($_SESSION["rolepersonnel"] == "Magasinier")) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idproduit, objet, operation, "
                            . "datetrace) values('" . $rowar["idproduit"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }else{
                $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, "
                            . "datetrace) values('" . $rowar["idproduit"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
            
//                }
//            }
        }
        $eta = "En Cours";
        $reqarc = $con->query("select * from hp_ligne_bon_commande_interne where idboncommandeinterne='" . $id . "' and "
                . "etatligneboncommandeinterne='" . $eta . "'") or die(mysqli_error($con));
        $npharmaciec = mysqli_num_rows($reqarc);
        if ($npharmaciec == 0) {
            $rslt = $con->query("update hp_bon_commande_interne set etatboncommandeinterne='" . $etat . "' where "
                    . "idboncommandeinterne='" . $id . "'") or die(mysqli_error($con));
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlibc" . $id]);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["idbonlivraisoninterne"] ?>" class="btn btn-lg btn-info" target="blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>

        <?php
        if (!empty($_SESSION["cart_prodvcex"])) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                ?>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/commande') ?>" class="btn btn-lg btn-info">
                    <span title="Commander" alt="editer">Voir la liste des produits &agrave; commander</span>
                </a>
                <?php
            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                if (($_SESSION["rolepersonnel"] == "Directeur de Centre")) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/commande') ?>" class="btn btn-lg btn-info">
                        <span title="Commander" alt="editer">Voir la liste des produits &agrave; commander</span>
                    </a>
                    <?php
                } else if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/commande') ?>" class="btn btn-lg btn-info">
                        <span title="Commander" alt="editer">Voir la liste des produits &agrave; commander</span>
                    </a>
                    <?php
                }
            }
            ?>
            <?php
        }
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_livraison_pharmacie($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $rsltuser = $con->query("select * from hp_bon_livraison_interne as a left join hp_pharmacie as c on "
            . "a.idpharmacie=c.idpharmacie where a.idpharmacie='" . $id . "' order by a.datebonlivraisoninterne desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codebonlivraisoninterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantbonlivraisoninterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatbonlivraisoninterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["datebonlivraisoninterne"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Directeur de Centre")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["rolepersonnel"] == "Pharmacien")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatbonlivraisoninterne"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/pharmacie_ajax'); ?>&idbonlivraisoninterne=<?php echo $recuser["idbonlivraisoninterne"]; ?>&validerlivraison=validerlivraison" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Valider cette Livraison ?'));">
                                <span title="Valider ce bon de livraison" data-toggle="tooltip" alt="oui"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            
                            <?php
                        }
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/facture_livraison_pdf.php?bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>" target="blank">
                    <span title="Impriner le bon de livraison" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/facture_livraison_excel.php?bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>" target="blank">
                    <span title="Exporter le bon de livraison" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_pharmacie_alert($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $etatc = "En Cours";
    $codeb = "BAR";
//    $rsltserv = $con->query("select * from pharmacie_point_hopital as spa left join hp_pharmacie as s on "
//            . "spa.id_pharmacie=s.id_pharmacie where spa.idpharmacie='" . $id . "' "
//            . "and s.code_pharmacie='" . $codeb . "'") or die(mysqli_error($con));
//    $rowserv = mysqli_fetch_assoc($rsltserv);
//    $rsltuser = $con->query("select * from hp_bon_livraison_interne as a left join pharmacie_point_hopital as sph on "
//            . "a.id_pharmacie_point_hopital=sph.id_pharmacie_point_hopital left join hp_pharmacie as c on "
//            . "sph.id_pharmacie=c.id_pharmacie where a.etatbonlivraisoninterne='" . $etatc . "' and "
//            . "a.id_pharmacie_point_hopital='" . $rowserv["id_pharmacie_point_hopital"] . "'  order by a.datebonlivraisoninterne desc")
//            or die(mysqli_error($con));
    $rsltuser = $con->query("select * from hp_bon_livraison_interne as a left join pharmacie_point_hopital as sph on "
            . "a.id_pharmacie_point_hopital=sph.id_pharmacie_point_hopital left join hp_pharmacie as c on "
            . "sph.id_pharmacie=c.id_pharmacie where a.etatbonlivraisoninterne='" . $etatc . "' and a.id_pharmacie='" . $id . "' order by "
            . "a.datebonlivraisoninterne desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codebonlivraisoninterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantbonlivraisoninterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatbonlivraisoninterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["datebonlivraisoninterne"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Directeur de Centre")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["rolepersonnel"] == "Pharmacien")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatbonlivraisoninterne"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_pharmacie(<?php echo $recuser["idbonlivraisoninterne"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/facture_livraison_pdf.php?bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>" target="blank">
                    <span title="Impriner le bon de livraison" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/facture_livraison_excel.php?bonlivraison=<?php echo $recuser["idbonlivraisoninterne"] ?>" target="blank">
                    <span title="Exporter le bon de livraison" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_pharmacie_ligne($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_ligne_bon_livraison_interne as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
            . "lbl.idbonlivraisoninterne='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategorie"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stocklignebonlivraisoninterne"])) ?>
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["idunite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["codeunite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixventelignebonlivraisoninterne"])) ?></td>
            <td><?php print (($recuser["stocklignebonlivraisoninterne"] * $recuser["prixventelignebonlivraisoninterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatlignebonlivraisoninterne"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Directeur de Centre")) {
                        ?>

                        <?php
                    } else if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                        ?>

                        <?php
                    } else if (($_SESSION["rolepersonnel"] == "Pharmacien")) {
                        ?>
                        <?php
                        if ($recuser["etatlignebonlivraisoninterne"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/pharmacie_ajax'); ?>&idlignebonlivraisoninterne=<?php echo $recuser["idlignebonlivraisoninterne"]; ?>&validerlivraisonligne=validerlivraisonligne" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Valider cette Livraison ?'));">
                                <span title="Valider cette livraison" data-toggle="tooltip" alt="oui"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_boutique_alert($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_boutique as mb left join hp_pharmacie as b on mb.id_pharmacie=b.id_pharmacie left "
            . "join hp_produit_point_hopital as aph on mb.idproduit=aph.idproduit left join "
            . "hp_produit as a on aph.idproduit=a.idproduit left join hp_categorie as c on "
            . "a.idcategorie=c.idcategorie where mb.id_pharmacie='" . $id . "' and mb.stockboutique<mb.stock_minboutique") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_rest"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategorie"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stockboutique"])) ?>
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["idunite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["codeunite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_minboutique"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_maxboutique"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_venteboutique"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatboutique"])) ?></td>
        </tr>
        <?php
    }
}

function lister_commande_pharmacie_alert($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $etatc = "En Cours";
    $codeb = "BAR";
//    $rsltserv = $con->query("select * from pharmacie_point_hopital as spa left join hp_pharmacie as s on "
//            . "spa.id_pharmacie=s.id_pharmacie where spa.idpharmacie='" . $id . "' "
//            . "and s.code_pharmacie='" . $codeb . "'") or die(mysqli_error($con));
//    $rowserv = mysqli_fetch_assoc($rsltserv);
//    $rsltuser = $con->query("select * from hp_bon_commande_interne as a left join pharmacie_point_hopital as sph on "
//            . "a.id_pharmacie_point_hopital=sph.id_pharmacie_point_hopital left join hp_pharmacie as c on "
//            . "sph.id_pharmacie=c.id_pharmacie where a.id_pharmacie_point_hopital='" . $rowserv["id_pharmacie_point_hopital"] . "' "
//            . "and a.etatboncommandeinterne='" . $etatc . "' order by a.dateboncommandeinterne desc") or die(mysqli_error($con));
    $rsltuser = $con->query("select * from hp_bon_commande_interne as a left join pharmacie_point_hopital as sph on "
            . "a.id_pharmacie_point_hopital=sph.id_pharmacie_point_hopital left join hp_pharmacie as c on "
            . "sph.id_pharmacie=c.id_pharmacie where a.id_pharmacie='" . $id . "' and a.etatboncommandeinterne='" . $etatc . "' order by "
            . "a.dateboncommandeinterne desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltb = $con->query("select * from hp_pharmacie where id_pharmacie='" . $recuser["id_pharmacie"] . "' ") or die(mysqli_error($con));
        $rowb = mysqli_fetch_assoc($rsltb);
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($rowb["nom_pharmacie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeboncommandeinterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantboncommandeinterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatboncommandeinterne"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateboncommandeinterne"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalboncommande/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etatboncommandeinterne"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Directeur de Centre")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalboncommande/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatboncommandeinterne"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalboncommande/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatboncommandeinterne"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["rolepersonnel"] == "Pharmacien")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalboncommande/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["idboncommandeinterne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="hopitalpages/hopitalpharmacie/hopitalboncommande/facture_commande_pdf.php?boncommande=<?php echo $recuser["idboncommandeinterne"] ?>" target="blank">
                    <span title="Impriner le bon de commande" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="hopitalpages/hopitalpharmacie/hopitalboncommande/facture_commande_excel.php?boncommande=<?php echo $recuser["idboncommandeinterne"] ?>" target="blank">
                    <span title="Exporter le bon de commande" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_produit_avarie_pharmacie($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_produit_avarie as aa where aa.id_pharmacie='" . $id . "' "
            . "order by aa.date_produit_avarie desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltserv = $con->query("select * from pharmacie_point_hopital as spa left join hp_pharmacie as s on "
                . "spa.id_pharmacie=s.id_pharmacie where spa.id_pharmacie_point_hopital='" . $recuser["id_pharmacie_point_hopital"] . "' "
                . "") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltar = $con->query("select * from hp_produit_point_hopital as aph left join hp_produit as a on "
                . "aph.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie left "
                . "join hp_fourniture as f on a.id_fourniture=f.id_fourniture where "
                . "aph.idproduit='" . $recuser["idproduit"] . "' "
                . "") or die(mysqli_error($con));
        $rowar = mysqli_fetch_assoc($rsltar);
        $rsltp = $con->query("select * from hp_compte_personnel as cp inner join hp_personnel as p on "
                . "cp.id_personnel=p.id_personnel where cp.idcomptepersonnel='" . $recuser["idcomptepersonnel"] . "' "
                . "") or die(mysqli_error($con));
        $rowp = mysqli_fetch_assoc($rsltp);
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?> </td>
            <td><?php print nl2br(htmlspecialchars($rowar["codeproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($rowar["libelleproduit"])) ?></td>
            <!--<td><?php print nl2br(htmlspecialchars($rowserv["nom_pharmacie"])) ?></td>-->
            <td><?php print nl2br(htmlspecialchars($rowp["nom_pe"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stockproduit_avarie"])); ?>&nbsp;
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["idunite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["libelle_unite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_unitaire_produit_avarie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_produit_avarie"])) ?></td>

        </tr>
        <?php
    }
}

function ajouter_produit_avarie_pharmacie($id, $com, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "BAR";
        $rsltserv = $con->query("select * from pharmacie_point_hopital as spa left join hp_pharmacie as s on "
                . "spa.id_pharmacie=s.id_pharmacie where spa.idpharmacie='" . $_SESSION["idpharmacie"] . "' "
                . "and s.code_pharmacie='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);

        foreach ($_SESSION["cart_prodvaaba"] as $prod) {
            if ($prod["unitearts"] == $prod["uniteartv"]) {
                $reqar = $con->query("select * from hp_boutique as mb left join hp_pharmacie as b on mb.id_pharmacie=b.id_pharmacie left "
                        . "join hp_produit_point_hopital as aph on mb.idproduit=aph.idproduit left join "
                        . "hp_produit as a on aph.idproduit=a.idproduit left join hp_categorie as c on "
                        . "a.idcategorie=c.idcategorie where mb.id_boutique='" . $prod["idart"] . "'") or die(mysqli_error($con));
                $rowar = mysqli_fetch_assoc($reqar);
                if (isset($_SESSION["idcomptepersonnel"])) {
                    $rsltf = $con->query("insert into hp_produit_avarie(idcomptepersonnel, idproduit, "
                            . "idunite, id_pharmacie_point_hopital, id_pharmacie, stockproduit_avarie, prix_unitaire_produit_avarie, "
                            . "date_produit_avarie) values('" . $_SESSION["idcomptepersonnel"] . "', "
                            . "'" . $rowar["idproduit"] . "', '" . $prod["unitearts"] . "', "
                            . "'" . $_SESSION["id_pharmacie_point_hopital"] . "', '" . $id . "', '" . $prod["qteart"] . "', "
                            . "'" . $prod["prixarts"] . "', NOW())") or die(mysqli_error($con));
                } else {
                    $rsltf = $con->query("insert into hp_produit_avarie(idproduit, idunite, "
                            . "id_pharmacie_point_hopital, id_pharmacie, stockproduit_avarie, prix_unitaire_produit_avarie, "
                            . "date_produit_avarie) values('" . $rowar["idproduit"] . "', "
                            . "'" . $prod["unitearts"] . "', '" . $_SESSION["id_pharmacie_point_hopital"] . "', '" . $id . "', "
                            . "'" . $prod["qteart"] . "', '" . $prod["prixarts"] . "', NOW())") or die(mysqli_error($con));
                }

                $stockarap = $rowar["stockboutique"] - $prod["qteart"];
                $stockarp = 0;
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }

                $rsltarp = $con->query("update hp_boutique set stockboutique='" . $stockarp . "' where "
                        . "id_boutique='" . $prod["idart"] . "'") or die(mysqli_error($con));

                $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
                $op = "Article avarie";
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltvente = $con->query("insert into hp_historique(idproduit, id_proprietaire, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["idproduit"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Magasinier")) {
                        $rsltvente = $con->query("insert into hp_historique(idproduit, idcomptepersonnel, objet_h, operation_h, "
                                . "date_histo) values('" . $rowar["idproduit"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                                . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                    }
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvaaba"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}
