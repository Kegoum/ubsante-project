<?php

//fonction pour ajouter un echographie
function inserer_echographie($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_echographie where codeechographie='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_echographie(idacte, idservice, nomechographie, codeechographie, prixechographie, typeechographie, resultatechographie, valeurminechographie, "
                            . "valeurmaxechographie, dateechographie) values('" . ($reg["1"]["acte"]) . "', '" . ($reg["1"]["service"]) . "', '" . addslashes($reg["1"]["echographie"]) . "', '" . $reg["1"]["codep"] . "', "
                            . "'" . $reg["1"]["montant"] . "', '" . addslashes($reg["1"]["type"]) . "', '" . addslashes($reg["1"]["resultat"]) . "', "
                            . "'" . ($reg["1"]["valmin"]) . "', '" . ($reg["1"]["valmax"]) . "', NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_echographie de la valeure {$reg["1"]["echographie"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formechographie']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalechographie/lister_echographie';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalechographie/hopitalajouter/ajout_echographie';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les echographies
function lister_echographie($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_echographie as p left join hp_service as s on p.idservice=s.idservice left join hp_acte as u on p.idacte=u.idacte ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idechographie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleacte"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeechographie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomechographie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixechographie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["typeechographie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["resultatechographie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["valeurminechographie"])) ?> 
            <td><?php print nl2br(htmlspecialchars($recuser["valeurmaxechographie"])) ?> 
            <td>
                <?php
                if ($recuser["etatechographie"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalechographie/echographie_ajax'); ?>&idechographie=<?php echo $recuser["idechographie"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cet Echographie ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalechographie/echographie_ajax'); ?>&idechographie=<?php echo $recuser["idechographie"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cet Echographie ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalechographie/hopitalediter/edit_echographie'); ?>&idechographie=<?php echo $recuser["idechographie"]; ?>" >
                    <span title="Modifier ce echographie" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                <!--                &nbsp;&nbsp;
                                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalechographie/echographie_ajax'); ?>&idechographie=<?php echo $recuser["idechographie"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce echographie ?'));" >
                                    <span title="Supprimer ce echographie " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_echographie($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_echographie where codeechographie='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_echographie set idacte='" . $reg["1"]["acte"] . "', idservice='" . $reg["1"]["service"] . "', codeechographie='" . $reg["1"]["codepe"] . "', nomechographie='" . addslashes($reg["1"]["echographiee"]) . "', "
                            . "prixechographie='" . ($reg["1"]["montant"]) . "', typeechographie='" . addslashes($reg["1"]["type"]) . "', "
                            . "resultatechographie='" . addslashes($reg["1"]["resultat"]) . "', valeurminechographie='" . ($reg["1"]["valmin"]) . "', "
                            . "valeurmaxechographie='" . ($reg["1"]["valmax"]) . "' where idechographie='" . $reg["1"]["idechographie"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_echographie de la valeure {$reg["1"]["echographie"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formechographiee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalechographie/lister_echographie';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idechographie"] != $reg["1"]["idechographie"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_echographie set idacte='" . $reg["1"]["acte"] . "', idservice='" . $reg["1"]["service"] . "', codeechographie='" . $reg["1"]["codepe"] . "', nomechographie='" . addslashes($reg["1"]["echographiee"]) . "', "
                            . "prixechographie='" . ($reg["1"]["montant"]) . "', typeechographie='" . addslashes($reg["1"]["type"]) . "', "
                            . "resultatechographie='" . addslashes($reg["1"]["resultat"]) . "', valeurminechographie='" . ($reg["1"]["valmin"]) . "', "
                            . "valeurmaxechographie='" . ($reg["1"]["valmax"]) . "' where idechographie='" . $reg["1"]["idechographie"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_echographie de la valeure {$reg["1"]["echographie"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formechographiee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalechographie/lister_echographie';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalechographie/hopitalediter/edit_echographie';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idechographie=' . $reg["1"]["idechographie"] . '">');
            }
        }
    }
}
