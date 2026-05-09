<?php

//fonction pour ajouter un acte
function inserer_acte($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_acte where codeacte='" . $reg["1"]["code"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_acte(idservice, typeacte, categorieacte, codeacte, libelleacte, descriptionacte, prixacte) "
                            . "values('" . ($reg["1"]["service"]) . "', '" . addslashes($reg["1"]["type"]) . "', '" . addslashes($reg["1"]["categorie"]) . "', "
                    . "'" . addslashes($reg["1"]["code"]) . "', '" . $reg["1"]["designationp"] . "', "
                    . "'" . addslashes($reg["1"]["description"]) . "', '" . ($reg["1"]["montant"]) . "' )") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_acte de la valeure {$reg["1"]["type"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formacte']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalacte/lister_acte';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalacte/hopitalajouter/ajout_acte';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les actes
function lister_acte($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_acte as gp left join hp_service as s on gp.idservice=s.idservice") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idacte"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeacte"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleacte"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["typeacte"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["categorieacte"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixacte"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["descriptionacte"])) ?></td>
            <td>
                <?php
                if ($recuser["etatacte"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalacte/acte_ajax'); ?>&idacte=<?php echo $recuser["idacte"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cet acte ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                            <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalacte/acte_ajax'); ?>&idacte=<?php echo $recuser["idacte"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cet acte ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalacte/hopitalediter/edit_acte'); ?>&idacte=<?php echo $recuser["idacte"]; ?>" >
                    <span title="Modifier cet acte" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
<!--                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalacte/acte_ajax'); ?>&idacte=<?php echo $recuser["idacte"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce acte ?'));" >
                    <span title="Supprimer ce acte " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_acte($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_acte where codeacte='" . $reg["1"]["codee"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
           $con->query("update hp_acte set idservice='" . ($reg["1"]["service"]) . "', codeacte='" . addslashes($reg["1"]["codee"]) . "', libelleacte='" . addslashes($reg["1"]["designationpe"]) . "', "
                    . "typeacte='" . addslashes($reg["1"]["typee"]) . "', categorieacte='" . addslashes($reg["1"]["categoriee"]) . "', "
                        . "descriptionacte='" . addslashes($reg["1"]["descriptione"]) . "', prixacte='" . ($reg["1"]["montant"]) . "' "
                        . "where idacte='" . $reg["1"]["idacte"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_acte de la valeure {$reg["1"]["acte"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formactee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalacte/lister_acte';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idacte"] != $reg["1"]["idacte"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_acte set idservice='" . ($reg["1"]["service"]) . "', codeacte='" . addslashes($reg["1"]["codee"]) . "', libelleacte='" . addslashes($reg["1"]["designationpe"]) . "', "
                    . "typeacte='" . addslashes($reg["1"]["typee"]) . "', categorieacte='" . addslashes($reg["1"]["categoriee"]) . "', "
                        . "descriptionacte='" . addslashes($reg["1"]["descriptione"]) . "', prixacte='" . ($reg["1"]["montant"]) . "' "
                        . "where idacte='" . $reg["1"]["idacte"] . "'") or die(mysqli_error($con));
//          $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_acte de la valeure {$reg["1"]["acte"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formactee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalacte/lister_acte';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalacte/hopitalediter/edit_acte';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idacte=' . $reg["1"]["idacte"] . '">');
            }
        }
    }
}
