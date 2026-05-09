<?php

//fonction pour ajouter un laboratoire
function inserer_laboratoire($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_laboratoire where codelaboratoire='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_laboratoire(idservice, nomlaboratoire, codelaboratoire, butlaboratoire) "
                    . "values('" . ($reg["1"]["service"]) . "', '" . addslashes($reg["1"]["laboratoire"]) . "', '" . $reg["1"]["codep"] . "', "
                            . "'" . addslashes($reg["1"]["but"]) . "')") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_laboratoire de la valeure {$reg["1"]["laboratoire"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formlaboratoire']);
            $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/lister_laboratoire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalajouter/ajout_laboratoire';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les laboratoires
function lister_laboratoire($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_laboratoire as p left join hp_service as s on p.idservice=s.idservice") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idlaboratoire"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codelaboratoire"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomlaboratoire"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["butlaboratoire"])) ?></td>
            <td>
                <?php
                if ($recuser["etatlaboratoire"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/laboratoire_ajax'); ?>&idlaboratoire=<?php echo $recuser["idlaboratoire"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cet Examen ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/laboratoire_ajax'); ?>&idlaboratoire=<?php echo $recuser["idlaboratoire"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cet Examen ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalediter/edit_laboratoire'); ?>&idlaboratoire=<?php echo $recuser["idlaboratoire"]; ?>" >
                    <span title="Modifier ce laboratoire" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                <!--                &nbsp;&nbsp;
                                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/laboratoire_ajax'); ?>&idlaboratoire=<?php echo $recuser["idlaboratoire"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce laboratoire ?'));" >
                                    <span title="Supprimer ce laboratoire " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_laboratoire($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_laboratoire where codelaboratoire='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_laboratoire set idservice='" . $reg["1"]["service"] . "', codelaboratoire='" . $reg["1"]["codepe"] . "', "
                    . "nomlaboratoire='" . addslashes($reg["1"]["laboratoiree"]) . "', butlaboratoire='" . addslashes($reg["1"]["but"]) . "' "
                    . "where idlaboratoire='" . $reg["1"]["idlaboratoire"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_laboratoire de la valeure {$reg["1"]["laboratoire"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formlaboratoiree']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/lister_laboratoire';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idlaboratoire"] != $reg["1"]["idlaboratoire"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_laboratoire set idservice='" . $reg["1"]["service"] . "', codelaboratoire='" . $reg["1"]["codepe"] . "', "
                    . "nomlaboratoire='" . addslashes($reg["1"]["laboratoiree"]) . "', butlaboratoire='" . addslashes($reg["1"]["but"]) . "' "
                    . "where idlaboratoire='" . $reg["1"]["idlaboratoire"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_laboratoire de la valeure {$reg["1"]["laboratoire"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formlaboratoiree']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/lister_laboratoire';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalediter/edit_laboratoire';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idlaboratoire=' . $reg["1"]["idlaboratoire"] . '">');
            }
        }
    }
}

//fonction pour ajouter un nfs
function inserer_nfs($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_ligne_nfs where codelignenfs='" . addslashes($reg["1"]["code"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_ligne_nfs(idunite, codelignenfs, libellelignenfs, 29jourminlignenfs, 29jourmaxlignenfs, "
                    . "6anminlignenfs, 6anmaxlignenfs, adultefemmeminlignenfs, adultefemmemaxlignenfs, adultehommeminlignenfs, "
                    . "adultehommemaxlignenfs) values('" . ($reg["1"]["unite"]) . "', '" . addslashes($reg["1"]["code"]) . "', "
                    . "'" . addslashes($reg["1"]["nfs"]) . "', '" . ($reg["1"]["valmin29"]) . "', "
                            . "'" . ($reg["1"]["valmax29"]) . "', '" . ($reg["1"]["valmin6"]) . "', "
                            . "'" . ($reg["1"]["valmax6"]) . "', '" . ($reg["1"]["valminf"]) . "', "
                            . "'" . ($reg["1"]["valmaxf"]) . "', '" . ($reg["1"]["valminh"]) . "', "
                            . "'" . ($reg["1"]["valmaxh"]) . "')") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_ligne_nfs de la valeure {$reg["1"]["nfs"]}',now())") or die(mysqli_error($con));
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
    $rsltuser = $con->query("select * from hp_ligne_nfs as p left join hp_unite as u on p.idunite=u.idunite ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idlignenfs"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codelignenfs"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellelignenfs"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["29jourminlignenfs"])) ?> - 
                    <?php print nl2br(htmlspecialchars($recuser["29jourmaxlignenfs"])) ?>  
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> 
            </td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["6anminlignenfs"])) ?> - 
                    <?php print nl2br(htmlspecialchars($recuser["6anmaxlignenfs"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> 
            </td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["adultefemmeminlignenfs"])) ?> - 
                    <?php print nl2br(htmlspecialchars($recuser["adultefemmemaxlignenfs"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> 
            </td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["adultehommeminlignenfs"])) ?> - 
                    <?php print nl2br(htmlspecialchars($recuser["adultehommemaxlignenfs"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> 
            </td>
            <td>
                <?php
                if ($recuser["etatlignenfs"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/nfs_ajax'); ?>&idlignenfs=<?php echo $recuser["idlignenfs"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce Paramètre ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/nfs_ajax'); ?>&idlignenfs=<?php echo $recuser["idlignenfs"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce Paramètre ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/hopitalediter/edit_nfs'); ?>&idlignenfs=<?php echo $recuser["idlignenfs"]; ?>" >
                    <span title="Modifier ce param&egrave;tre" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                <!--                &nbsp;&nbsp;
                                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/nfs_ajax'); ?>&idlignenfs=<?php echo $recuser["idlignenfs"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce nfs ?'));" >
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

        $req = $con->query("select * from hp_ligne_nfs where codelignenfs='" . addslashes($reg["1"]["codee"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_ligne_nfs set idunite='" . $reg["1"]["unite"] . "', codelignenfs='" . addslashes($reg["1"]["codee"]) . "', "
                    . "libellelignenfs='" . addslashes($reg["1"]["nfse"]) . "', 29jourminlignenfs='" . ($reg["1"]["valmin29"]) . "', "
                    . "29jourmaxlignenfs='" . ($reg["1"]["valmax29"]) . "', 6anminlignenfs='" . ($reg["1"]["valmin6"]) . "', "
                    . "6anmaxlignenfs='" . ($reg["1"]["valmax6"]) . "', adultefemmeminlignenfs='" . ($reg["1"]["valminf"]) . "', "
                    . "adultefemmemaxlignenfs='" . ($reg["1"]["valmaxf"]) . "', adultehommeminlignenfs='" . ($reg["1"]["valminh"]) . "', "
                    . "adultehommemaxlignenfs='" . ($reg["1"]["valmaxh"]) . "' where idlignenfs='" . $reg["1"]["idlignenfs"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_ligne_nfs de la valeure {$reg["1"]["nfs"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formnfse']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/lister_nfs';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idlignenfs"] != $reg["1"]["idlignenfs"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                 $con->query("update hp_ligne_nfs set idunite='" . $reg["1"]["unite"] . "', codelignenfs='" . addslashes($reg["1"]["codee"]) . "', "
                    . "libellelignenfs='" . addslashes($reg["1"]["nfse"]) . "', 29jourminlignenfs='" . ($reg["1"]["valmin29"]) . "', "
                    . "29jourmaxlignenfs='" . ($reg["1"]["valmax29"]) . "', 6anminlignenfs='" . ($reg["1"]["valmin6"]) . "', "
                    . "6anmaxlignenfs='" . ($reg["1"]["valmax6"]) . "', adultefemmeminlignenfs='" . ($reg["1"]["valminf"]) . "', "
                    . "adultefemmemaxlignenfs='" . ($reg["1"]["valmaxf"]) . "', adultehommeminlignenfs='" . ($reg["1"]["valminh"]) . "', "
                    . "adultehommemaxlignenfs='" . ($reg["1"]["valmaxh"]) . "' where idlignenfs='" . $reg["1"]["idlignenfs"] . "'") or die(mysqli_error($con));
//           $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_ligne_nfs de la valeure {$reg["1"]["nfs"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formnfse']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/lister_nfs';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/hopitalediter/edit_nfs';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idlignenfs=' . $reg["1"]["idlignenfs"] . '">');
            }
        }
    }
}
