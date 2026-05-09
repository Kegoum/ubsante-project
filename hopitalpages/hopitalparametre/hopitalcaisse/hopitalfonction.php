<?php

//fonction pour ajouter un caisse
function inserer_caisse($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_caisse where codecaisse='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_caisse(nomcaisse,codecaisse, datecaisse) "
                            . "values('" . addslashes($reg["1"]["caisse"]) . "', '" . $reg["1"]["codep"] . "', "
                    . "NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_caisse de la valeure {$reg["1"]["caisse"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formcaisse']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalcaisse/lister_caisse';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalcaisse/hopitalajouter/ajout_caisse';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les caisses
function lister_caisse($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_caisse ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idcaisse"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codecaisse"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomcaisse"])) ?></td>
            <td>
                <?php
                if ($recuser["etatcaisse"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalcaisse/caisse_ajax'); ?>&idcaisse=<?php echo $recuser["idcaisse"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cette Caisse ?'));">
                        <span title="D&eacute;sactiver cette caisse" data-toggle="tooltip" alt="oui" class="label-success label"><i class="label label-success">Activ&eacute;</i></span>
                    </a>
                            <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalcaisse/caisse_ajax'); ?>&idcaisse=<?php echo $recuser["idcaisse"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cette Caisse ?'));">
                        <span title="Activer cette caisse " data-toggle="tooltip" alt="non" class="label-warning label"><i class="label label-warning">D&eacute;sactiv&eacute;</i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalcaisse/hopitalediter/edit_caisse'); ?>&idcaisse=<?php echo $recuser["idcaisse"]; ?>" >
                    <span title="Modifier cette caisse" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
<!--                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalcaisse/caisse_ajax'); ?>&idcaisse=<?php echo $recuser["idcaisse"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce caisse ?'));" >
                    <span title="Supprimer cette caisse " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_caisse($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_caisse where codecaisse='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_caisse set codecaisse='" . $reg["1"]["codepe"] . "', nomcaisse='" . addslashes($reg["1"]["caissee"]) . "' "
                    . "where idcaisse='" . $reg["1"]["idcaisse"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_caisse de la valeure {$reg["1"]["caisse"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formcaissee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalcaisse/lister_caisse';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idcaisse"] != $reg["1"]["idcaisse"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_caisse set codecaisse='" . $reg["1"]["codepe"] . "', nomcaisse='" . addslashes($reg["1"]["caissee"]) . "' "
                        . "where idcaisse='" . $reg["1"]["idcaisse"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_caisse de la valeure {$reg["1"]["caisse"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formcaissee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalcaisse/lister_caisse';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalcaisse/hopitalediter/edit_caisse';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idcaisse=' . $reg["1"]["idcaisse"] . '">');
            }
        }
    }
}
