<?php

//fonction pour ajouter un magasin
function inserer_magasin($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_magasin where codemagasin='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_magasin(nommagasin,codemagasin, datemagasin) "
                            . "values('" . addslashes($reg["1"]["magasin"]) . "', '" . $reg["1"]["codep"] . "', "
                            . "NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_magasin de la valeure {$reg["1"]["magasin"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formmagasin']);
            $pagp = 'hopitalpages/hopitalmagasin/lister_magasin';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalmagasin/hopitalajouter/ajout_magasin';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les magasins
function lister_magasin($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_magasin ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idmagasin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codemagasin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nommagasin"])) ?></td>
            <td>
                <?php
                if ($recuser["etatmagasin"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/magasin_ajax'); ?>&idmagasin=<?php echo $recuser["idmagasin"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce Magasin ?'));">
                        <span title="D&eacute;sactiver ce magasin" data-toggle="tooltip" alt="oui" class="label-success label"><i class="label label-success">Activ&eacute;</i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/magasin_ajax'); ?>&idmagasin=<?php echo $recuser["idmagasin"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce Magasin ?'));">
                        <span title="Activer ce magasin " data-toggle="tooltip" alt="non" class="label-warning label"><i class="label label-warning">D&eacute;sactiv&eacute;</i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalediter/edit_magasin'); ?>&idmagasin=<?php echo $recuser["idmagasin"]; ?>" >
                    <span title="Modifier ce magasin" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                <!--                &nbsp;&nbsp;
                                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/magasin_ajax'); ?>&idmagasin=<?php echo $recuser["idmagasin"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce magasin ?'));" >
                                    <span title="Supprimer ce magasin " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_magasin($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_magasin where codemagasin='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_magasin set codemagasin='" . $reg["1"]["codepe"] . "', nommagasin='" . addslashes($reg["1"]["magasine"]) . "' "
                            . "where idmagasin='" . $reg["1"]["idmagasin"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_magasin de la valeure {$reg["1"]["magasin"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formmagasine']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalmagasin/lister_magasin';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idmagasin"] != $reg["1"]["idmagasin"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_magasin set codemagasin='" . $reg["1"]["codepe"] . "', nommagasin='" . addslashes($reg["1"]["magasine"]) . "' "
                                . "where idmagasin='" . $reg["1"]["idmagasin"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_magasin de la valeure {$reg["1"]["magasin"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formmagasine']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalmagasin/lister_magasin';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalmagasin/hopitalediter/edit_magasin';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idmagasin=' . $reg["1"]["idmagasin"] . '">');
            }
        }
    }
}

function lister_commande($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_bon_commande as a where a.idmagasin='" . $id . "' order by a.dateboncommande desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeboncommande"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantboncommande"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatboncommande"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateboncommande"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["idboncommande"] ?>">
                    <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                </a>
                <?php
                if ($recuser["etatboncommande"] == "En Cours") {
                    ?>
                    &nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["idboncommande"] ?>">
                        <span title="Receptionner la livraison de ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                }
                ?>
                &nbsp;&nbsp;
                <a href="hopitalpages/hopitalmagasin/hopitalboncommande/facture_commande_pdf.php?boncommande=<?php echo $recuser["idboncommande"] ?>" target="blank">
                    <span title="Impriner ce bon de commande" alt="print"><i class="fa fa-file-pdf-o"></i> </span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_ligne($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_ligne_bon_commande as lbl left join hp_produit as "
            . "a on lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
            . "lbl.idboncommande='" . $id . "'") or die(mysqli_error($con));
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
            <td><?php print nl2br(htmlspecialchars($recuser["stockligneboncommande"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stocklivreligneboncommande"])) ?></td>
            <td>
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["idunite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["codeunite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixligneboncommande"])) ?></td>
            <td><?php print ($recuser["stockligneboncommande"] * $recuser["prixligneboncommande"]); ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatligneboncommande"])) ?></td>

        </tr>
        <?php
    }
}

function ajouter_commande_externe($prixtotal, $com, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($com != NULL)) {
        $an = date('Y');
        $rsltpl2 = $con->query("select * from hp_bon_commande where YEAR(dateboncommande)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = "C" . date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = "C" . date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $con->query("insert into hp_bon_commande(idmagasin, codeboncommande, montantboncommande, dateboncommande) "
                            . "values('" . $_SESSION["idmagasin"] . "', '" . $numid . "', "
                            . "'" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        } else {
            $con->query("insert into hp_bon_commande(idcomptepersonnel, idmagasin, codeboncommande, montantboncommande, dateboncommande) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $_SESSION["idmagasin"] . "', '" . $numid . "', "
                            . "'" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hp_bon_commande where codeboncommande='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvcex"] as $prod) {
            $rsltreg = $con->query("insert into hp_ligne_bon_commande(idboncommande, idproduit, "
                    . "idunite, stockligneboncommande, prixligneboncommande) values('" . $rowfa["idboncommande"] . "', '" . $prod["idart"] . "', "
                    . "'" . $prod["unitearta"] . "', '" . $prod["qteart"] . "', '" . $prod["prixarta"] . "')") or die(mysqli_error($con));

            $prixt = $prixt + ($prod["prixarta"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Commande Externe";
//            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
//                $rsltvente = $con->query("insert into hp_historique(id_produit_point_hotel,  id_proprietaire, "
//                        . "objet_h, operation_h, date_histo) values('" . $prod["idart"] . "', "
//                        . "'" . $_SESSION["id_proprietaire"] . "', '" . $obj . "', '" . $op . "', NOW())")
//                        or die(mysqli_error($con));
//            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
//                if (($_SESSION["code_service"] == "ECONO")) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $con->query("insert into hp_trace(idproduit, objet, operation,datetrace) values('" . $prod["idart"] . "', "
                                . "'" . $obj . "', '" . $op . "', NOW())")
                        or die(mysqli_error($con));
            } else {
                $con->query("insert into hp_trace(idproduit, "
                                . "idcomptepersonnel, objet, operation,datetrace) values('" . $prod["idart"] . "', "
                                . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $obj . "', '" . $op . "', NOW())")
                        or die(mysqli_error($con));
            }

//                }
//            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvcex"]);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hopitalpages/hopitalmagasin/hopitalboncommande/facture_commande_pdf.php?boncommande=<?php echo $rowfa["idboncommande"] ?>" class="btn btn-lg btn-info" target="blank">
            <span title="Impriner le bon de commande" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de commande</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_livraison($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_bon_livraison as a where a.idmagasin='" . $id . "' and "
            . "a.idfournisseur is not null order by a.datebonlivraison desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltuserf = $con->query("select * from hp_fournisseur as a where a.idfournisseur='" . $recuser["idfournisseur"] . "'") or die(mysqli_error($con));
        $recuserf = mysqli_fetch_assoc($rsltuserf);
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuserf["nomfournisseur"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codebonlivraison"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantbonlivraison"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatbonlivraison"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["datebonlivraison"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraison/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etatbonlivraison"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href='#' onclick=valider_bon_liv(<?php echo $recuser["idbonlivraison"] ?>)>
                            <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraison/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatbonlivraison"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv(<?php echo $recuser["idbonlivraison"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraison/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatbonlivraison"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv(<?php echo $recuser["idbonlivraison"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || ((($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Magasinier")))) {
                ?>
                            
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraison/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                &nbsp;&nbsp;
                <?php
                }
                            ?>
                <a href="hopitalpages/hopitalmagasin/hopitalbonlivraison/facture_livraison_pdf.php?bonlivraison=<?php echo $recuser["idbonlivraison"] ?>" target="blank">
                    <span title="Impriner ce bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> </span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_ligne($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_ligne_bon_livraison as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
            . "lbl.idbonlivraison='" . $id . "'") or die(mysqli_error($con));
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
            <td><?php print nl2br(htmlspecialchars($recuser["stocklignebonlivraison"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixachatlignebonlivraison"])) ?></td>
            <td>
                <?php
                $rsltua = $con->query("select * from hp_unite where idunite='" . $recuser["idunite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["libelleunite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatlignebonlivraison"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    if ($recuser["etatlignebonlivraison"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href='#' onclick=valider_bon_liv_ligne(<?php echo $recuser["id_ligne_bon_livraison"] ?>)>
                            <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        if ($recuser["etatlignebonlivraison"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_ligne(<?php echo $recuser["id_ligne_bon_livraison"] ?>)>
                                <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        if ($recuser["etatlignebonlivraison"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_ligne(<?php echo $recuser["id_ligne_bon_livraison"] ?>)>
                                <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
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

function ajouter_livraisonc_bar($id, $prixtotal, $com, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "BAR";

        $rsltserv = $con->query("select * from service_point_hotel as spa left join hp_service as s on "
                . "spa.id_service=s.id_service where spa.id_point_hotel='" . $_SESSION["id_point_hotel"] . "' "
                . "and s.code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hp_bon_livraison_interne where YEAR(datebonlivraisoni)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));

        $rsltplk = $con->query("select * from hp_bon_commande_interne where id_bon_commande_interne='" . $id . "'") or die(mysqli_error($con));
        $rowservk = mysqli_fetch_assoc($rsltplk);
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hp_bon_livraison_interne(id_compte_personnel, id_point_hotel, "
                    . "id_bar, id_service_point_hotel, id_bon_commande_interne, codebonlivraisoni, montantbonlivraisoni, datebonlivraisoni) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $_SESSION["id_point_hotel"] . "', "
                    . "'" . $rowservk["id_bar"] . "', '" . $rowservk["id_service_point_hotel"] . "', '" . $id . "', "
                    . "'" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hp_bon_livraison_interne(id_point_hotel, id_bar, id_service_point_hotel, "
                    . "id_bon_commande_interne, codebonlivraisoni, montantbonlivraisoni, datebonlivraisoni) values('" . $_SESSION["id_point_hotel"] . "', "
                    . "'" . $rowservk["id_bar"] . "', '" . $rowservk["id_service_point_hotel"] . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', "
                    . "NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hp_bon_livraison_interne where codebonlivraisoni='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        $etat = "Valider";
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvlibc" . $id] as $prod) {
            $reqar = $con->query("select * from hp_ligne_bon_commande_interne as lbl left join hp_produit_point_hotel "
                    . "as aph on lbl.id_produit_point_hotel=aph.id_produit_point_hotel left join hp_produit as a on "
                    . "aph.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie left "
                    . "join hp_fourniture as f on a.id_fourniture=f.id_fourniture where "
                    . "lbl.id_ligne_bon_commande_interne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltreg = $con->query("insert into hp_ligne_bon_livraison_interne(idbonlivraison_interne, id_unite, "
                    . "id_produit_point_hotel, stocklignebonlivraisoni, prix_ventelignebonlivraisoni) values('" . $rowfa["idbonlivraison_interne"] . "', "
                    . "'" . $prod["uniteartliv"] . "', '" . $rowar["id_produit_point_hotel"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["prixartliv"] . "')") or die(mysqli_error($con));

            $rsltuarpa = $con->query("select * from hp_conversion where id_unite='" . $prod["uniteartliv"] . "' "
                    . "and id_produit_point_hotel='" . $rowar["id_produit_point_hotel"] . "'") or die(mysqli_error($con));
            $nbarpa = mysqli_num_rows($rsltuarpa);

            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
            if ($nbarpa != 0) {
                $stockara = $rowarpa["stock_conversion"] - $prod["qteart"];
                $rsltuarpapr = $con->query("select * from hp_conversion where id_unite<>'" . $prod["uniteartliv"] . "' "
                        . "and id_produit_point_hotel='" . $rowar["id_produit_point_hotel"] . "'") or die(mysqli_error($con));
                while ($rowarpapr = mysqli_fetch_assoc($rsltuarpapr)) {
                    $stockarae = 0;
                    if ($rowarpa["stock_conversion"] != 0) {
                        $stockarae = ($rowarpapr["stock_conversion"] - (($prod["qteart"] * $rowarpapr["stock_conversion"]) / $rowarpa["stock_conversion"]));
                    }
                    $stockare = 0;
                    if ($stockarae >= 0) {
                        $stockare = $stockarae;
                    } else {
                        $stockare = 0;
                    }
                    $rsltar = $con->query("update hp_conversion set stock_conversion='" . $stockare . "' where "
                            . "id_unite='" . $rowarpapr["id_unite"] . "' and id_produit_point_hotel='" . $rowar["id_produit_point_hotel"] . "'") or die(mysqli_error($con));
                }

                $stockarap = 0;
                if ($rowarpa["stock_conversion"] != 0) {
                    $stockarap = $rowar["stock_produit"] - (($prod["qteart"] * $rowar["stock_produit"]) / ($rowarpa["stock_conversion"]));
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

                $rsltar = $con->query("update hp_conversion set stock_conversion='" . $stockar . "' where "
                        . "id_unite='" . $prod["uniteartliv"] . "' "
                        . "and id_produit_point_hotel='" . $rowar["id_produit_point_hotel"] . "'") or die(mysqli_error($con));
                $rsltarp = $con->query("update hp_produit_point_hotel set stock_produit='" . $stockarp . "' where "
                        . "id_produit_point_hotel='" . $rowar["id_produit_point_hotel"] . "'") or die(mysqli_error($con));
            } else {
                $stockarap = $rowar["stock_produit"] - $prod["qteart"];
                $stockarp = 0;
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }

                $rsltuarpap = $con->query("select * from hp_conversion where "
                        . "id_produit_point_hotel='" . $rowar["id_produit_point_hotel"] . "'")
                        or die(mysqli_error($con));
                while ($rowarpap = mysqli_fetch_assoc($rsltuarpap)) {
                    $stockara = ($rowarpap["stock_conversion"] - ($prod["qteart"] * $rowarpap["conversion"]));
                    $stockar = 0;
                    if ($stockara >= 0) {
                        $stockar = $stockara;
                    } else {
                        $stockar = 0;
                    }
                    $rsltar = $con->query("update hp_conversion set stock_conversion='" . $stockar . "' where "
                            . "id_unite='" . $rowarpap["id_unite"] . "' and id_produit_point_hotel='" . $rowar["id_produit_point_hotel"] . "'") or die(mysqli_error($con));
                }


                $rsltarp = $con->query("update hp_produit_point_hotel set stock_produit='" . $stockarp . "' where "
                        . "id_produit_point_hotel='" . $rowar["id_produit_point_hotel"] . "'") or die(mysqli_error($con));
            }

            $slivre = $rowar["stock_livreligneboncommandei"] + $prod["qteart"];
            if ($prod["stockok"]) {
                $rslt = $con->query("update hp_ligne_bon_commande_interne set stock_livreligneboncommandei='" . $slivre . "', "
                        . "etatligneboncommandei='" . $etat . "' where id_ligne_bon_commande_interne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
                $rslt = $con->query("update hp_ligne_bon_commande_interne set stock_livreligneboncommandei='" . $slivre . "' "
                        . "where id_ligne_bon_commande_interne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            }


            $prixt = $prixt + ($prod["uniteartv"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_historique(id_produit_point_hotel, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowar["id_produit_point_hotel"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hp_historique(id_produit_point_hotel, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["id_produit_point_hotel"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        $eta = "En Cours";
        $reqarc = $con->query("select * from hp_ligne_bon_commande_interne where id_bon_commande_interne='" . $id . "' and "
                . "etatligneboncommandei='" . $eta . "'") or die(mysqli_error($con));
        $nbarc = mysqli_num_rows($reqarc);
        if ($nbarc == 0) {
            $rslt = $con->query("update hp_bon_commande_interne set id_compte_personnel_validec='" . $_SESSION["id_compte_personnel"] . "', "
                    . "etatboncommandei='" . $etat . "' where id_bon_commande_interne='" . $id . "'") or die(mysqli_error($con));
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlibc" . $id]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/barhotel/hopitalbonlivraisonc/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["idbonlivraison_interne"] ?>" class="btn btn-lg btn-info" target="blank">
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
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "DG")) {
                    ?>
                    <a href="indexdg.php?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/commande') ?>" class="btn btn-lg btn-info">
                        <span title="Commander" alt="editer">Voir la liste des produits &agrave; commander</span>
                    </a>
                    <?php
                } else if (($_SESSION["code_service"] == "ECONO")) {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/commande') ?>" class="btn btn-lg btn-info">
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

function lister_livraison_bar($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $codeb = "BAR";
//    $rsltserv = $con->query("select * from service_point_hotel as spa left join hp_service as s on "
//            . "spa.id_service=s.id_service where spa.id_point_hotel='" . $id . "' "
//            . "and s.code_service='" . $codeb . "'") or die(mysqli_error($con));
//    $rowserv = mysqli_fetch_assoc($rsltserv);
//    $rsltuser = $con->query("select * from hp_bon_livraison_interne as a left join service_point_hotel as sph on "
//            . "a.id_service_point_hotel=sph.id_service_point_hotel left join hp_service as c on "
//            . "sph.id_service=c.id_service where a.id_service_point_hotel='" . $rowserv["id_service_point_hotel"] . "' "
//            . "order by a.datebonlivraisoni desc") or die(mysqli_error($con));
    $rsltuser = $con->query("select * from hp_bon_livraison_interne as a left join service_point_hotel as sph on "
            . "a.id_service_point_hotel=sph.id_service_point_hotel left join hp_service as c on "
            . "sph.id_service=c.id_service where a.id_bar='" . $id . "' order by a.datebonlivraisoni desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codebonlivraisoni"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantbonlivraisoni"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatbonlivraisoni"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["datebonlivraisoni"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatbonlivraisoni"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_bar(<?php echo $recuser["idbonlivraison_interne"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="hotelpages/barhotel/hopitalbonlivraisonc/facture_livraison_pdf.php?bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>" target="blank">
                    <span title="Impriner le bon de livraison" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="hotelpages/barhotel/hopitalbonlivraisonc/facture_livraison_excel.php?bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>" target="blank">
                    <span title="Exporter le bon de livraison" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_bar_alert($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $etatc = "En Cours";
    $codeb = "BAR";
//    $rsltserv = $con->query("select * from service_point_hotel as spa left join hp_service as s on "
//            . "spa.id_service=s.id_service where spa.id_point_hotel='" . $id . "' "
//            . "and s.code_service='" . $codeb . "'") or die(mysqli_error($con));
//    $rowserv = mysqli_fetch_assoc($rsltserv);
//    $rsltuser = $con->query("select * from hp_bon_livraison_interne as a left join service_point_hotel as sph on "
//            . "a.id_service_point_hotel=sph.id_service_point_hotel left join hp_service as c on "
//            . "sph.id_service=c.id_service where a.etatbonlivraisoni='" . $etatc . "' and "
//            . "a.id_service_point_hotel='" . $rowserv["id_service_point_hotel"] . "'  order by a.datebonlivraisoni desc")
//            or die(mysqli_error($con));
    $rsltuser = $con->query("select * from hp_bon_livraison_interne as a left join service_point_hotel as sph on "
            . "a.id_service_point_hotel=sph.id_service_point_hotel left join hp_service as c on "
            . "sph.id_service=c.id_service where a.etatbonlivraisoni='" . $etatc . "' and a.id_bar='" . $id . "' order by "
            . "a.datebonlivraisoni desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codebonlivraisoni"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantbonlivraisoni"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatbonlivraisoni"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["datebonlivraisoni"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    } else if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatbonlivraisoni"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_bar(<?php echo $recuser["idbonlivraison_interne"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="hotelpages/barhotel/hopitalbonlivraisonc/facture_livraison_pdf.php?bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>" target="blank">
                    <span title="Impriner le bon de livraison" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="hotelpages/barhotel/hopitalbonlivraisonc/facture_livraison_excel.php?bonlivraison=<?php echo $recuser["idbonlivraison_interne"] ?>" target="blank">
                    <span title="Exporter le bon de livraison" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_bar_ligne($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_ligne_bon_livraison_interne as lbl left join hp_produit_point_hotel "
            . "as aph on lbl.id_produit_point_hotel=aph.id_produit_point_hotel left join hp_produit as a on "
            . "aph.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.idbonlivraison_interne='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stocklignebonlivraisoni"])) ?>
                <?php
                $rsltua = $con->query("select * from hp_unite where id_unite='" . $recuser["id_unite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["code_unite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_ventelignebonlivraisoni"])) ?></td>
            <td><?php print (($recuser["stocklignebonlivraisoni"] * $recuser["prix_ventelignebonlivraisoni"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatlignebonlivraisoni"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        ?>

                        <?php
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        ?>

                        <?php
                    } else if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <?php
                        if ($recuser["etatlignebonlivraisoni"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_bar_ligne(<?php echo $recuser["id_ligne_bon_livraison_interne"] ?>)>
                                <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
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

function lister_magasin_bar($id, $con) {
    $rsltuser = $con->query("select * from hp_magasin_bar as mb left join hp_bar as b on mb.id_bar=b.id_bar left "
            . "join hp_produit_point_hotel as aph on mb.id_produit_point_hotel=aph.id_produit_point_hotel left join "
            . "hp_produit as a on aph.id_produit=a.id_produit left join hp_categorie as c on "
            . "a.id_categorie=c.id_categorie where mb.id_bar='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <!--<td><?php // print nl2br(htmlspecialchars($recuser["nom_rest"]))                             ?></td>-->
            <td><?php print nl2br(htmlspecialchars($recuser["code_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stock_produit_mb"])) ?>
                <?php
                $rsltua = $con->query("select * from hp_unite where id_unite='" . $recuser["id_unite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["code_unite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_produit_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_produit_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_vente_produit_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_produit_mb"])) ?></td>
        </tr>
        <?php
    }
}

function lister_magasin_bar_alert($id, $con) {
    $rsltuser = $con->query("select * from hp_magasin_bar as mb left join hp_bar as b on mb.id_bar=b.id_bar left "
            . "join hp_produit_point_hotel as aph on mb.id_produit_point_hotel=aph.id_produit_point_hotel left join "
            . "hp_produit as a on aph.id_produit=a.id_produit left join hp_categorie as c on "
            . "a.id_categorie=c.id_categorie where mb.id_bar='" . $id . "' and mb.stock_produit_mb<mb.stock_min_produit_mb") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_rest"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stock_produit_mb"])) ?>
                <?php
                $rsltua = $con->query("select * from hp_unite where id_unite='" . $recuser["id_unite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["code_unite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_produit_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_produit_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_vente_produit_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_produit_mb"])) ?></td>
        </tr>
        <?php
    }
}

function ajouter_commande_bar($prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "BAR";
        $rsltserv = $con->query("select * from service_point_hotel as spa left join hp_service as s on "
                . "spa.id_service=s.id_service where spa.id_service_point_hotel='" . $_SESSION["id_service_point_hotel"] . "' "
                . "and s.code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hp_bon_commande_interne where YEAR(dateboncommandei)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hp_bon_commande_interne(id_compte_personnel, id_point_hotel, "
                    . "id_bar, id_service_point_hotel, codeboncommandei, montantboncommandei, dateboncommandei) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $_SESSION["id_point_hotel"] . "', "
                    . "'" . $_SESSION["id_bar"] . "', '" . $_SESSION["id_service_point_hotel"] . "', "
                    . "'" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hp_bon_commande_interne(id_point_hotel, id_service_point_hotel, "
                    . "codeboncommandei, montantboncommandei, dateboncommandei) values('" . $_SESSION["id_point_hotel"] . "', "
                    . "'" . $_SESSION["id_service_point_hotel"] . "', '" . $numid . "', '" . $prixtotal . "', "
                    . "NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hp_bon_commande_interne where codeboncommandei='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvcib"] as $prod) {
            $rsltreg = $con->query("insert into hp_ligne_bon_commande_interne(id_bon_commande_interne, id_unite, "
                    . "id_produit_point_hotel, stockligneboncommandei, prixligneboncommandei) values('" . $rowfa["id_bon_commande_interne"] . "', "
                    . "'" . $prod["idunit"] . "', '" . $prod["idart"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));

            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obj = $prod["qteart"] . " " . $prod["uniteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Commande Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_historique(id_produit_point_hotel, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                    $rsltvente = $con->query("insert into hp_historique(id_produit_point_hotel, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvcib"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/barhotel/boncommandehotel/facture_commande_pdf.php?boncommande=<?php echo $rowfa["id_bon_commande_interne"] ?>" class="btn btn-lg btn-info" target="blank">
            <span title="Impriner le bon de commande" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de commande</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_commande_bar($id, $con) {
    $codeb = "BAR";
//    $rsltserv = $con->query("select * from service_point_hotel as spa left join hp_service as s on "
//            . "spa.id_service=s.id_service where spa.id_point_hotel='" . $id . "' "
//            . "and s.code_service='" . $codeb . "'") or die(mysqli_error($con));
//    $rowserv = mysqli_fetch_assoc($rsltserv);
//    $rsltuser = $con->query("select * from hp_bon_commande_interne as a left join service_point_hotel as sph on "
//            . "a.id_service_point_hotel=sph.id_service_point_hotel left join hp_service as c on "
//            . "sph.id_service=c.id_service where a.id_service_point_hotel='" . $rowserv["id_service_point_hotel"] . "' "
//            . "order by a.dateboncommandei desc") or die(mysqli_error($con));
    $rsltuser = $con->query("select * from hp_bon_commande_interne as a left join service_point_hotel as sph on "
            . "a.id_service_point_hotel=sph.id_service_point_hotel left join hp_service as c on "
            . "sph.id_service=c.id_service where a.id_bar='" . $id . "' order by a.dateboncommandei desc") or
            die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeboncommandei"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantboncommandei"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatboncommandei"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateboncommandei"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etatboncommandei"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatboncommandei"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatboncommandei"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="hotelpages/barhotel/boncommandehotel/facture_commande_pdf.php?boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>" target="blank">
                    <span title="Impriner le bon de commande" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="hotelpages/barhotel/boncommandehotel/facture_commande_excel.php?boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>" target="blank">
                    <span title="Exporter le bon de commande" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_bar_alert($id, $con) {
    $etatc = "En Cours";
    $codeb = "BAR";
//    $rsltserv = $con->query("select * from service_point_hotel as spa left join hp_service as s on "
//            . "spa.id_service=s.id_service where spa.id_point_hotel='" . $id . "' "
//            . "and s.code_service='" . $codeb . "'") or die(mysqli_error($con));
//    $rowserv = mysqli_fetch_assoc($rsltserv);
//    $rsltuser = $con->query("select * from hp_bon_commande_interne as a left join service_point_hotel as sph on "
//            . "a.id_service_point_hotel=sph.id_service_point_hotel left join hp_service as c on "
//            . "sph.id_service=c.id_service where a.id_service_point_hotel='" . $rowserv["id_service_point_hotel"] . "' "
//            . "and a.etatboncommandei='" . $etatc . "' order by a.dateboncommandei desc") or die(mysqli_error($con));
    $rsltuser = $con->query("select * from hp_bon_commande_interne as a left join service_point_hotel as sph on "
            . "a.id_service_point_hotel=sph.id_service_point_hotel left join hp_service as c on "
            . "sph.id_service=c.id_service where a.id_bar='" . $id . "' and a.etatboncommandei='" . $etatc . "' order by "
            . "a.dateboncommandei desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltb = $con->query("select * from hp_bar where id_bar='" . $recuser["id_bar"] . "' ") or die(mysqli_error($con));
        $rowb = mysqli_fetch_assoc($rsltb);
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($rowb["nom_bar"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeboncommandei"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montantboncommandei"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatboncommandei"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateboncommandei"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etatboncommandei"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        ?>
                        <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatboncommandei"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etatboncommandei"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/hopitalbonlivraisonc/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="hotelpages/barhotel/boncommandehotel/facture_commande_pdf.php?boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>" target="blank">
                    <span title="Impriner le bon de commande" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="hotelpages/barhotel/boncommandehotel/facture_commande_excel.php?boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>" target="blank">
                    <span title="Exporter le bon de commande" alt="exporter"><i class="glyphicon glyphicon-export"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_bar_ligne($id, $con) {
    $rsltuser = $con->query("select * from hp_ligne_bon_commande_interne as lbl left join hp_produit_point_hotel "
            . "as aph on lbl.id_produit_point_hotel=aph.id_produit_point_hotel left join hp_produit as a on "
            . "aph.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_commande_interne='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stockligneboncommandei"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_livreligneboncommandei"])) ?></td>
            <td>
                <?php
                $rsltua = $con->query("select * from hp_unite where id_unite='" . $recuser["id_unite"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["code_unite"]));
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixligneboncommandei"])) ?></td>
            <td><?php print ($recuser["stockligneboncommandei"] * $recuser["prixligneboncommandei"]); ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etatligneboncommandei"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "DG")) {
                        ?>

                        <?php
                        if ($recuser["etatligneboncommandei"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=livrer_bon_liv_bar_ligne(<?php echo $recuser["id_ligne_bon_commande_interne"] ?>)>
                                <span title="Livrer cette ligne de bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["code_service"] == "ECONO")) {
                        ?>

                        <?php
                        if ($recuser["etatligneboncommandei"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=livrer_bon_liv_bar_ligne(<?php echo $recuser["id_ligne_bon_commande_interne"] ?>)>
                                <span title="Livrer cette ligne de bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    } else if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
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

function ajouter_livraison($prixtotal, $nomfour, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');
        $etat = "Valider";
        $nomfour = addslashes($nomfour);
        $idfourn = null;

        $rsltfour = $con->query("select * from hp_fournisseur where nom_fournisseur='" . $nomfour . "'") or die(mysqli_error($con));
        $nbf = mysqli_num_rows($rsltfour);
        if ($nbf != 0) {
            $rowfour = mysqli_fetch_assoc($rsltfour);
            $idfourn = $rowfour["id_fournisseur"];
        } else {
            $rsltfou = $con->query("insert into hp_fournisseur(nom_fournisseur) values('" . $nomfour . "')") or die(mysqli_error($con));
            $rsltfour2 = $con->query("select * from hp_fournisseur where nom_fournisseur='" . $nomfour . "'") or die(mysqli_error($con));
            $rowfour = mysqli_fetch_assoc($rsltfour2);
            $idfourn = $rowfour["id_fournisseur"];
        }
        $rsltpl2 = $con->query("select * from hp_bon_livraison where YEAR(datebonlivraison)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hp_bon_livraison(id_compte_personnel_validel, id_point_hotel, id_fournisseur, codebonlivraison, "
                    . "montantbonlivraison, etatbonlivraison, datebonlivraison) values('" . $_SESSION["id_compte_personnel"] . "', '" . $_SESSION["id_point_hotel"] . "', '" . $idfourn . "', "
                    . "'" . $numid . "', '" . $prixtotal . "', '" . $etat . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hp_bon_livraison(id_point_hotel, id_fournisseur, codebonlivraison, montantbonlivraison, etatbonlivraison, datebonlivraison) "
                    . "values('" . $_SESSION["id_point_hotel"] . "', '" . $idfourn . "', '" . $numid . "', '" . $prixtotal . "', '" . $etat . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hp_bon_livraison where codebonlivraison='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvlex"] as $prod) {
            $rsltreg = $con->query("insert into hp_ligne_bon_livraison(idbonlivraison, id_produit_point_hotel, "
                    . "id_unite, stocklignebonlivraison, prix_achatlignebonlivraison, prix_lavagelignebonlivraison, etatlignebonlivraison) "
                    . "values('" . $rowfa["idbonlivraison"] . "', '" . $prod["idart"] . "', "
                    . "'" . $prod["unitearta"] . "', '" . $prod["qteart"] . "', '" . $prod["prixarta"] . "', "
                    . "'" . $prod["prixlingeart"] . "', '" . $etat . "')") or die(mysqli_error($con));
            $reqar = $con->query("select * from hp_produit_point_hotel as aph left join hp_produit "
                    . "as a on aph.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie "
                    . "left join hp_fourniture as f on a.id_fourniture=f.id_fourniture where "
                    . "aph.id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $stockar = $rowar["stock_produit"] + $prod["qteart"];
            $rsltar = $con->query("update hp_produit_point_hotel set stock_produit='" . $stockar . "', "
                    . "unite_achat_produit='" . $prod["unitearta"] . "', prix_achat_produit='" . $prod["prixarta"] . "' "
                    . "where id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));

            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Externe";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_historique(id_produit_point_hotel, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hp_historique(id_produit_point_hotel, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlex"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hopitalpages/hopitalmagasin/hopitalbonlivraison/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["idbonlivraison"] ?>" class="btn btn-lg btn-info" target="blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_livraisonc_externe($id, $prixtotal, $transp, $nomfour, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');
        $nomfour = addslashes($nomfour);
        $idfourn = null;

        $etat = "Valider";
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
        $rsltpl2 = $con->query("select * from hp_bon_livraison where YEAR(datebonlivraison)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));

        $rsltplk = $con->query("select * from hp_bon_commande where idboncommande='" . $id . "'") or die(mysqli_error($con));
        $rowservk = mysqli_fetch_assoc($rsltplk);
//        if (isset($_SESSION["id_compte_personnel"])) {
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $con->query("insert into hp_bon_livraison(idmagasin, idfournisseur, idboncommande, codebonlivraison, "
                            . "montantbonlivraison, etatbonlivraison, datebonlivraison) values('" . $_SESSION["idmagasin"] . "', "
                            . "'" . $idfourn . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', '" . $etat . "', "
                            . "NOW())") or die(mysqli_error($con));
        } else {
            $con->query("insert into hp_bon_livraison(idcomptepersonnel, idmagasin, idfournisseur, "
                            . "idboncommande, codebonlivraison, montantbonlivraison, etatbonlivraison, datebonlivraison) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $_SESSION["idmagasin"] . "', "
                            . "'" . $idfourn . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', '" . $etat . "', "
                            . "NOW())") or die(mysqli_error($con));
        }

//        } else {
//            $rsltf = $con->query("insert into hp_bon_livraison(idmagasin, idfournisseur, idboncommande, "
//                    . "codebonlivraison, montantbonlivraison, etatbonlivraison, datebonlivraison) values('" . $_SESSION["idmagasin"] . "', "
//                    . "'" . $idfourn . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', '" . $etat . "', "
//                    . "NOW())") or die(mysqli_error($con));
//        }

        $rsltfa = $con->query("select * from hp_bon_livraison where codebonlivraison='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);

        $prixt = 0;
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvlebc" . $id] as $prod) {
            $reqar = $con->query("select * from hp_ligne_bon_commande as lbl left join hp_produit as a on "
                    . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie "
                    . "where lbl.idligneboncommande='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);

            $con->query("insert into hp_ligne_bon_livraison(idbonlivraison, idunite, idproduit, stocklignebonlivraison, "
                            . "prixachatlignebonlivraison, etatlignebonlivraison) values('" . $rowfa["idbonlivraison"] . "', "
                            . "'" . $prod["uniteartliv"] . "', '" . $rowar["idproduit"] . "', '" . $prod["qteart"] . "', "
                            . "'" . $prod["prixartliv"] . "', '" . $etat . "')") or die(mysqli_error($con));
            $p = $prod["prixartliv"];
            
            $qtel = $prod["qteart"];
            $prl = $prod["prixartliv"];
            if ($rowar["uniteachatproduit"] != $prod["uniteartliv"]) {
                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $prod["uniteartliv"] . "' and "
                        . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                $rowvv = mysqli_fetch_assoc($rsltuv2);
                $rsltuv2b = $con->query("select * from hp_conversion where idunite='" .$rowar["uniteachatproduit"] . "' and "
                        . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                $rowvvb = mysqli_fetch_assoc($rsltuv2b);
                if ($rowvv["conversion"] != 0) {
                    $qtel = (($prod["qteart"]) * ($rowvvb["conversion"]) / $rowvv["conversion"]);
                    $prl = (($prod["prixartliv"]) * ($rowvv["conversion"]));
                }
            }
           
            $stockarap = $rowar["stockproduit"] + $qtel;

            $reqarv = $con->query("select * from hp_valorisation_stock where idvalorisationstock='" . $rowar["idvalorisationstock"] . "'") or die(mysqli_error($con));
//            $nbv = mysqli_num_rows($reqarv);
            $rowarv = mysqli_fetch_assoc($reqarv);
            if ($rowarv["codevalorisationstock"] == "CUMPFE") {
                $x = 0;
                if ($prixtotal != 0) {
                    $x = ((($prod["qteart"] * $prod["prixartliv"]) * $transp) / $prixtotal);
                }
                $t = (($rowar["stockproduit"] * $rowar["prixventeproduit"]) + ($qtel * $prl)) + $x;

                $p = $t / $stockarap;
            }
            $stockarp = 0;
            if ($stockarap >= 0) {
                $stockarp = $stockarap;
            } else {
                $stockarp = 0;
            }

            $rsltuarpap = $con->query("select * from hp_conversion where idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
            while ($rowarpap = mysqli_fetch_assoc($rsltuarpap)) {
                $stockara = ($rowarpap["stockconversion"] + ($qtel * $rowarpap["conversion"]));
                $stockar = 0;
                if ($stockara >= 0) {
                    $stockar = $stockara;
                } else {
                    $stockar = 0;
                }
                $prl2=0;
                if($rowarpap["conversion"]!=0){
                $prl2 = (($p) / ($rowarpap["conversion"]));
                }
                $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockar . "', prixconversion='" . $prl2 . "' "
                        . "where idunite='" . $rowarpap["idunite"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
            }


            $con->query("update hp_produit set stockproduit='" . $stockarp . "', prixachatproduit='" . $prl . "', "
                            . "prixventeproduit='" . $p . "' where idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));

            $qtel3=0;
            if ($rowar["idunite"] != $prod["uniteartliv"]) {
                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $prod["uniteartliv"] . "' and "
                        . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                $rowvv = mysqli_fetch_assoc($rsltuv2);
                $rsltuv2b = $con->query("select * from hp_conversion where idunite='" .$rowar["idunite"] . "' and "
                        . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
                $rowvvb = mysqli_fetch_assoc($rsltuv2b);
                if ($rowvv["conversion"] != 0) {
                    $qtel3 = (($prod["qteart"]) * ($rowvvb["conversion"]) / $rowvv["conversion"]);
                }
            }
            $slivre = $rowar["stocklivreligneboncommande"] + $qtel3;
            if ($prod["stockok"]) {
                $rslt = $con->query("update hp_ligne_bon_commande set stocklivreligneboncommande='" . $slivre . "', "
                        . "etatligneboncommande='" . $etat . "' where idligneboncommande='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
                $rslt = $con->query("update hp_ligne_bon_commande set stocklivreligneboncommande='" . $slivre . "' "
                        . "where idligneboncommande='" . $prod["idart"] . "'") or die(mysqli_error($con));
            }

$rsltu = $con->query("select * from hp_unite where idunite='" . $prod["uniteartliv"] . "'") or die(mysqli_error($con));
                        $rowu = mysqli_fetch_assoc($rsltu);
            $obj = $qtel3 . "-" . addslashes($rowu["libelleunite"]) . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Externe";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, objet, operation, "
                        . "datetrace) values('" . $rowar["idproduit"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, "
                        . "datetrace) values('" . $rowar["idproduit"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
        }
        $eta = "En Cours";
        $reqarc = $con->query("select * from hp_ligne_bon_commande where idboncommande='" . $id . "' and "
                . "etatligneboncommande='" . $eta . "'") or die(mysqli_error($con));
        $nbarc = mysqli_num_rows($reqarc);
        if ($nbarc == 0) {
            $rslt = $con->query("update hp_bon_commande set etatboncommande='" . $etat . "' where idboncommande='" . $id . "'") or die(mysqli_error($con));
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlebc" . $id]);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hopitalpages/hopitalmagasin/hopitalbonlivraison/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["idbonlivraison"] ?>" class="btn btn-lg btn-info" target="blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>

        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_livraisonc_externeold($id, $prixtotal, $nomfour, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');
        $nomfour = addslashes($nomfour);
        $idfourn = null;

        $etat = "Valider";
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
        $rsltpl2 = $con->query("select * from hp_bon_livraison where YEAR(datebonlivraison)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));

        $rsltplk = $con->query("select * from hp_bon_commande where idboncommande='" . $id . "'") or die(mysqli_error($con));
        $rowservk = mysqli_fetch_assoc($rsltplk);
//        if (isset($_SESSION["id_compte_personnel"])) {
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $con->query("insert into hp_bon_livraison(idmagasin, idfournisseur, idboncommande, codebonlivraison, "
                            . "montantbonlivraison, etatbonlivraison, datebonlivraison) values('" . $_SESSION["idmagasin"] . "', "
                            . "'" . $idfourn . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', '" . $etat . "', "
                            . "NOW())") or die(mysqli_error($con));
        } else {
            $con->query("insert into hp_bon_livraison(idcomptepersonnel, idmagasin, idfournisseur, "
                            . "idboncommande, codebonlivraison, montantbonlivraison, etatbonlivraison, datebonlivraison) "
                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $_SESSION["idmagasin"] . "', "
                            . "'" . $idfourn . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', '" . $etat . "', "
                            . "NOW())") or die(mysqli_error($con));
        }

//        } else {
//            $rsltf = $con->query("insert into hp_bon_livraison(idmagasin, idfournisseur, idboncommande, "
//                    . "codebonlivraison, montantbonlivraison, etatbonlivraison, datebonlivraison) values('" . $_SESSION["idmagasin"] . "', "
//                    . "'" . $idfourn . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', '" . $etat . "', "
//                    . "NOW())") or die(mysqli_error($con));
//        }
        $rsltfa = $con->query("select * from hp_bon_livraison where codebonlivraison='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvlebc" . $id] as $prod) {
            $reqar = $con->query("select * from hp_ligne_bon_commande as lbl left join hp_produit as a on "
                    . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie "
                    . "where lbl.idligneboncommande='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltreg = $con->query("insert into hp_ligne_bon_livraison(idbonlivraison, idunite, idproduit, stocklignebonlivraison, "
                    . "prixachatlignebonlivraison, etatlignebonlivraison) values('" . $rowfa["idbonlivraison"] . "', "
                    . "'" . $prod["uniteartliv"] . "', '" . $rowar["idproduit"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["prixartliv"] . "', '" . $etat . "')") or die(mysqli_error($con));

            $stockarap = $rowar["stockproduit"] + $prod["qteart"];
            $stockarp = 0;
            if ($stockarap >= 0) {
                $stockarp = $stockarap;
            } else {
                $stockarp = 0;
            }

            $rsltuarpap = $con->query("select * from hp_conversion where "
                    . "idproduit='" . $rowar["idproduit"] . "'")
                    or die(mysqli_error($con));
            while ($rowarpap = mysqli_fetch_assoc($rsltuarpap)) {
                $stockara = ($rowarpap["stockconversion"] + ($prod["qteart"] * $rowarpap["conversion"]));
                $stockar = 0;
                if ($stockara >= 0) {
                    $stockar = $stockara;
                } else {
                    $stockar = 0;
                }
                $rsltar = $con->query("update hp_conversion set stockconversion='" . $stockar . "' where "
                        . "idunite='" . $rowarpap["idunite"] . "' and idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));
            }


            $rsltarp = $con->query("update hp_produit set stockproduit='" . $stockarp . "', "
                    . "prixachatproduit='" . $prod["prixartliv"] . "' where "
                    . "idproduit='" . $rowar["idproduit"] . "'") or die(mysqli_error($con));

            $slivre = $rowar["stocklivreligneboncommande"] + $prod["qteart"];
            if ($prod["stockok"]) {
                $rslt = $con->query("update hp_ligne_bon_commande set stocklivreligneboncommande='" . $slivre . "', "
                        . "etatligneboncommande='" . $etat . "' where idligneboncommande='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
                $rslt = $con->query("update hp_ligne_bon_commande set stocklivreligneboncommande='" . $slivre . "' "
                        . "where idligneboncommande='" . $prod["idart"] . "'") or die(mysqli_error($con));
            }


            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Externe";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, objet, operation, "
                        . "datetrace) values('" . $rowar["idproduit"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, "
                        . "datetrace) values('" . $rowar["idproduit"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
        }
        $eta = "En Cours";
        $reqarc = $con->query("select * from hp_ligne_bon_commande where idboncommande='" . $id . "' and "
                . "etatligneboncommande='" . $eta . "'") or die(mysqli_error($con));
        $nbarc = mysqli_num_rows($reqarc);
        if ($nbarc == 0) {
            $rslt = $con->query("update hp_bon_commande set etatboncommande='" . $etat . "' where idboncommande='" . $id . "'") or die(mysqli_error($con));
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlebc" . $id]);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hopitalpages/hopitalmagasin/hopitalbonlivraison/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["idbonlivraison"] ?>" class="btn btn-lg btn-info" target="blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>

        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_produit_avarie($id, $con) {
    $rsltuser = $con->query("select * from hp_produit_avarie as aa left join hp_produit_point_hotel as aph on "
            . "aa.id_produit_point_hotel=aph.id_produit_point_hotel where aph.id_point_hotel='" . $id . "' "
            . "order by aa.date_produit_avarie desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltserv = $con->query("select * from service_point_hotel as spa left join hp_service as s on "
                . "spa.id_service=s.id_service where spa.id_service_point_hotel='" . $recuser["id_service_point_hotel"] . "' "
                . "") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltar = $con->query("select * from hp_produit_point_hotel as aph left join hp_produit as a on "
                . "aph.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie left "
                . "join hp_fourniture as f on a.id_fourniture=f.id_fourniture where "
                . "aph.id_produit_point_hotel='" . $recuser["id_produit_point_hotel"] . "' "
                . "") or die(mysqli_error($con));
        $rowar = mysqli_fetch_assoc($rsltar);
        $rsltp = $con->query("select * from hp_compte_personnel as cp inner join hp_personnel as p on "
                . "cp.id_personnel=p.id_personnel where cp.id_compte_personnel='" . $recuser["id_compte_personnel"] . "' "
                . "") or die(mysqli_error($con));
        $rowp = mysqli_fetch_assoc($rsltp);
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($rowar["code_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($rowar["libelle_produit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($rowserv["nom_service"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($rowp["nom_pe"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stock_produit_avarie"])); ?>&nbsp;
                <?php
                $rsltua = $con->query("select * from hp_unite where id_unite='" . $recuser["id_unite"] . "'") or die(mysqli_error($con));
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

function ajouter_produit_avarie_economat($com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "ECONO";
        $rsltserv = $con->query("select * from service_point_hotel as spa left join hp_service as s on "
                . "spa.id_service=s.id_service where spa.id_point_hotel='" . $_SESSION["id_point_hotel"] . "' "
                . "and s.code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);

        foreach ($_SESSION["cart_prodvaae"] as $prod) {
            if ($prod["unitearts"] == $prod["uniteartv"]) {
                $reqar = $con->query("select * from hp_produit_point_hotel as aph left join hp_produit "
                        . "as a on aph.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie "
                        . "left join hp_fourniture as f on a.id_fourniture=f.id_fourniture where "
                        . "aph.id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));
                $rowar = mysqli_fetch_assoc($reqar);
                if (isset($_SESSION["id_compte_personnel"])) {
                    $rsltf = $con->query("insert into hp_produit_avarie(id_compte_personnel, id_produit_point_hotel, "
                            . "id_unite, id_service_point_hotel, stock_produit_avarie, prix_unitaire_produit_avarie, "
                            . "date_produit_avarie) values('" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $prod["idart"] . "', '" . $prod["unitearts"] . "', '" . $rowserv["id_service_point_hotel"] . "', "
                            . "'" . $prod["qteart"] . "', '" . $prod["prixarts"] . "', NOW())") or die(mysqli_error($con));
                } else {
                    $rsltf = $con->query("insert into hp_produit_avarie(id_produit_point_hotel, id_unite, "
                            . "id_service_point_hotel, stock_produit_avarie, prix_unitaire_produit_avarie, "
                            . "date_produit_avarie) values('" . $prod["idart"] . "', '" . $prod["unitearts"] . "', "
                            . "'" . $rowserv["id_service_point_hotel"] . "', '" . $prod["qteart"] . "', "
                            . "'" . $prod["prixarts"] . "', NOW())") or die(mysqli_error($con));
                }
                $rsltuarpa = $con->query("select * from hp_conversion where id_unite='" . $prod["unitearts"] . "' "
                        . "and id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));
                $nbarpa = mysqli_num_rows($rsltuarpa);

                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                if ($nbarpa != 0) {
                    $stockara = $rowarpa["stock_conversion"] - $prod["qteart"];
                    $rsltuarpapr = $con->query("select * from hp_conversion where id_unite<>'" . $prod["unitearts"] . "' "
                            . "and id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));
                    while ($rowarpapr = mysqli_fetch_assoc($rsltuarpapr)) {
                        $stockarae = 0;
                        if ($rowarpa["stock_conversion"] != 0) {
                            $stockarae = ($rowarpapr["stock_conversion"] - (($prod["qteart"] * $rowarpapr["stock_conversion"]) / $rowarpa["stock_conversion"]));
                        }
                        $stockare = 0;
                        if ($stockarae >= 0) {
                            $stockare = $stockarae;
                        } else {
                            $stockare = 0;
                        }
                        $rsltar = $con->query("update hp_conversion set stock_conversion='" . $stockare . "' where "
                                . "id_unite='" . $rowarpapr["id_unite"] . "' and id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));
                    }

                    $stockarap = 0;
                    if ($rowarpa["stock_conversion"] != 0) {
                        $stockarap = $rowar["stock_produit"] - (($prod["qteart"] * $rowar["stock_produit"]) / ($rowarpa["stock_conversion"]));
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

                    $rsltar = $con->query("update hp_conversion set stock_conversion='" . $stockar . "' where "
                            . "id_unite='" . $prod["unitearts"] . "' "
                            . "and id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));
                    $rsltarp = $con->query("update hp_produit_point_hotel set stock_produit='" . $stockarp . "' where "
                            . "id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));
                } else {
                    $stockarap = $rowar["stock_produit"] - $prod["qteart"];
                    $stockarp = 0;
                    if ($stockarap >= 0) {
                        $stockarp = $stockarap;
                    } else {
                        $stockarp = 0;
                    }

                    $rsltuarpap = $con->query("select * from hp_conversion where "
                            . "id_produit_point_hotel='" . $prod["idart"] . "'")
                            or die(mysqli_error($con));
                    while ($rowarpap = mysqli_fetch_assoc($rsltuarpap)) {
                        $stockara = ($rowarpap["stock_conversion"] - ($prod["qteart"] * $rowarpap["conversion"]));
                        $stockar = 0;
                        if ($stockara >= 0) {
                            $stockar = $stockara;
                        } else {
                            $stockar = 0;
                        }
                        $rsltar = $con->query("update hp_conversion set stock_conversion='" . $stockar . "' where "
                                . "id_unite='" . $rowarpap["id_unite"] . "' and id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));
                    }


                    $rsltarp = $con->query("update hp_produit_point_hotel set stock_produit='" . $stockarp . "' where "
                            . "id_produit_point_hotel='" . $prod["idart"] . "'") or die(mysqli_error($con));
                }

                $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
                $op = "Article avarie";
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltvente = $con->query("insert into hp_historique(id_produit_point_hotel, id_proprietaire, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        $rsltvente = $con->query("insert into hp_historique(id_produit_point_hotel, id_compte_personnel, objet_h, operation_h, "
                                . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                                . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                    }
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvaae"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}
