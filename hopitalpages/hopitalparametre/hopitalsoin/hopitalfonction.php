<?php

//fonction pour ajouter un soin
function inserer_soin($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_soin where libellesoin='" . addslashes($reg["1"]["libelle"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $an = date('Y');
            $req1 = $con->query("select * from hp_soin where YEAR(datesoin)='" . $an . "' order by datesoin desc") or die(mysqli_error($con));
            $ia = mysqli_num_rows($req1);
            $numid = "S" . date('Y', time()) . sprintf("%04d", ($ia + 1));
            $con->query("insert into hp_soin(idacte, codesoin, libellesoin, montantsoin, datesoin) values('" . ($reg["1"]["acte"]) . "', "
                    . "'" . $numid . "', '" . addslashes($reg["1"]["libelle"]) . "', '" . ($reg["1"]["montant"]) . "', "
                            . "NOW())") or die(mysqli_error($con));
            $reqefa = $con->query("select * from hp_soin where libellesoin='" . addslashes($reg["1"]["libelle"]) . "'") or die(mysqli_error($con));
            $rowefa = mysqli_fetch_assoc($reqefa);

            if (($reg["1"]['liblignesoin'] != '')) {
                $reqtapq = $con->query("select * from hp_ligne_soin where idsoin='" . $rowefa["idsoin"] . "' "
                        . "and idproduit='" . $reg["1"]["liblignesoin"] . "' ") or die(mysqli_error($con));
                $nbtapq = mysqli_num_rows($reqtapq);
                if ($nbtapq == 0) {
                    $con->query("insert into hp_ligne_soin(idproduit, idsoin, idunite, quantitelignesoin, datelignesoin) "
                                    . "values('" . $reg["1"]["liblignesoin"] . "', '" . $rowefa["idsoin"] . "', '" . $reg["1"]["unitelignesoin"] . "', "
                                    . "'" . $reg["1"]["qtelignesoin"] . "', NOW())") or die(mysqli_error($con));
                }
            }

            for ($i = 0; $i < $reg["1"]["nblignesoin"]; $i++) {
                if (($reg["1"]["liblignesoin" . $i] != '')) {
                    $reqtapq = $con->query("select * from hp_ligne_soin where idsoin='" . $rowefa["idsoin"] . "' "
                        . "and idproduit='" . $reg["1"]["liblignesoin" . $i] . "' ") or die(mysqli_error($con));
                $nbtapq = mysqli_num_rows($reqtapq);
                if ($nbtapq == 0) {
                    $con->query("insert into hp_ligne_soin(idproduit, idsoin, idunite, quantitelignesoin, datelignesoin) "
                                    . "values('" . $reg["1"]["liblignesoin" . $i] . "', '" . $rowefa["idsoin"] . "', "
                            . "'" . $reg["1"]["unitelignesoin" . $i] . "', '" . $reg["1"]["qtelignesoin" . $i] . "', "
                            . "NOW())") or die(mysqli_error($con));
                }
                }
            }


//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_soin de la valeure {$reg["1"]["soin"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formsoin']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalsoin/lister_soin';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalsoin/hopitalajouter/ajout_soin';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les soins
function lister_soin($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_soin as s left join hp_acte as a on s.idacte=a.idacte ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idsoin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleacte"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codesoin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellesoin"])) ?></td>
            <td>
                <?php
                if ($recuser["etatsoin"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalsoin/soin_ajax'); ?>&idsoin=<?php echo $recuser["idsoin"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce Soin ?'));">
                        <span title="D&eacute;sactiver ce soin" data-toggle="tooltip" alt="oui" class="label-success label"><i class="label label-success">Activ&eacute;</i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalsoin/soin_ajax'); ?>&idsoin=<?php echo $recuser["idsoin"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce Soin ?'));">
                        <span title="Activer ce soin " data-toggle="tooltip" alt="non" class="label-warning label"><i class="label label-warning">D&eacute;sactiv&eacute;</i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalsoin/hopitalediter/edit_soin'); ?>&idsoin=<?php echo $recuser["idsoin"]; ?>" >
                    <span title="Modifier ce soin" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalsoin/hopitalproduit/lister_produit'); ?>&idsoin=<?php echo $recuser["idsoin"]; ?>" >
                    <span title="Lister les produits de ce soin" alt="editer"><i class="glyphicon glyphicon-list-alt"></i></span>
                </a>
                <!--                &nbsp;&nbsp;
                                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalsoin/soin_ajax'); ?>&idsoin=<?php echo $recuser["idsoin"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce soin ?'));" >
                                    <span title="Supprimer ce soin " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                                </a>-->
            </td>
        </tr>
        <?php
    }
}

//gestion des produits
function lister_produit_soin($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_ligne_soin as ls left join hp_produit as a on ls.idproduit=a.idproduit left "
            . "join hp_categorie as c on a.idcategorie=c.idcategorie where ls.idsoin='" . $id . "' order by a.libelleproduit asc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td>
<!--                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediterph/editer_produit') ?>&produit=<?php echo $recuser["idproduit"] ?>">
                    <span title="Modifier ce produit" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                </a>&nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalconversion/lister_conversion') ?>&produit=<?php echo $recuser["idproduit"] ?>">
                    <span title="G&eacute;rer les unit&eacute;s de conversion de ce produit" alt="conversion"><i class="glyphicon glyphicon-resize-full"></i></span>
                </a>&nbsp;&nbsp;-->
        <!--                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/produit_ajax'); ?>&idproduit=<?php echo $recuser["idproduit"]; ?>&supprimer=supprimer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce Produit ?'));">
                    <span title="Supprimer ce produit" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                </a>-->
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategorie"])) ?></td>
            <td>
                <?php
                $rsltuvv = $con->query("select * from hp_conversion where idunite='" . $recuser["idunite"] . "' and "
                            . "idproduit='" . $recuser["idproduit"] . "'") or die(mysqli_error($con));
                $rowvv = mysqli_fetch_assoc($rsltuvv);
                print nl2br(htmlspecialchars($rowvv["prixconversion"]));
                ?>
            </td>
            <td>
                <?php
                $rsltuv = $con->query("select * from hp_unite where idunite='" . $recuser["uniteventeproduit"] . "'") or die(mysqli_error($con));
                $rowv = mysqli_fetch_assoc($rsltuv);
                print nl2br(htmlspecialchars($rowv["libelleunite"]));
                ?>
            </td>
        </tr>
        <?php
    }
}

function update_soin($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_soin where codesoin='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_soin set codesoin='" . $reg["1"]["codepe"] . "', nomsoin='" . addslashes($reg["1"]["soine"]) . "' "
                            . "where idsoin='" . $reg["1"]["idsoin"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_soin de la valeure {$reg["1"]["soin"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formsoine']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalsoin/lister_soin';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idsoin"] != $reg["1"]["idsoin"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_soin set codesoin='" . $reg["1"]["codepe"] . "', nomsoin='" . addslashes($reg["1"]["soine"]) . "' "
                                . "where idsoin='" . $reg["1"]["idsoin"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_soin de la valeure {$reg["1"]["soin"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formsoine']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalsoin/lister_soin';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalsoin/hopitalediter/edit_soin';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idsoin=' . $reg["1"]["idsoin"] . '">');
            }
        }
    }
}
