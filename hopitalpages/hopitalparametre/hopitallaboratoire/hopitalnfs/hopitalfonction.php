<?php

//fonction pour ajouter un nfs
function inserer_nfs($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_nfs where libellenfs='" . addslashes($reg["1"]["nfs"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_nfs(idunite, libellenfs, valeurminnfs, valeurmaxnfs, datenfs) "
                            . "values('" . ($reg["1"]["unite"]) . "', '" . addslashes($reg["1"]["nfs"]) . "', '" . ($reg["1"]["valmin"]) . "', "
                            . "'" . ($reg["1"]["valmax"]) . "', NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_nfs de la valeure {$reg["1"]["nfs"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formnfs']);
            $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/lister_nfs';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/hopitalajouter/ajout_nfs';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les nfss
function lister_nfs($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_nfs as p left join hp_unite as u on p.idunite=u.idunite ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idnfs"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellenfs"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["valeurminnfs"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> 
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["valeurmaxnfs"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> 
            </td>
            <td>
                <?php
                if ($recuser["etatnfs"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/nfs_ajax'); ?>&idnfs=<?php echo $recuser["idnfs"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce Paramètre ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/nfs_ajax'); ?>&idnfs=<?php echo $recuser["idnfs"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce Paramètre ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/hopitalediter/edit_nfs'); ?>&idnfs=<?php echo $recuser["idnfs"]; ?>" >
                    <span title="Modifier ce param&egrave;tre" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                <!--                &nbsp;&nbsp;
                                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/nfs_ajax'); ?>&idnfs=<?php echo $recuser["idnfs"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce nfs ?'));" >
                                    <span title="Supprimer ce paramètre " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_nfs($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_nfs where libellenfs='" . addslashes($reg["1"]["nfse"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_nfs set idunite='" . $reg["1"]["unite"] . "', libellenfs='" . addslashes($reg["1"]["nfse"]) . "', "
                            . " valeurminnfs='" . ($reg["1"]["valmin"]) . "', valeurmaxnfs='" . ($reg["1"]["valmax"]) . "' where "
                            . "idnfs='" . $reg["1"]["idnfs"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_nfs de la valeure {$reg["1"]["nfs"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formnfse']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/lister_nfs';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idnfs"] != $reg["1"]["idnfs"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_nfs set idunite='" . $reg["1"]["unite"] . "', libellenfs='" . addslashes($reg["1"]["nfse"]) . "', "
                                . " valeurminnfs='" . ($reg["1"]["valmin"]) . "', valeurmaxnfs='" . ($reg["1"]["valmax"]) . "' where "
                                . "idnfs='" . $reg["1"]["idnfs"] . "'") or die(mysqli_error($con));
//          $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_nfs de la valeure {$reg["1"]["nfs"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formnfse']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/lister_nfs';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/hopitalediter/edit_nfs';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idnfs=' . $reg["1"]["idnfs"] . '">');
            }
        }
    }
}
