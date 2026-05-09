<?php

//fonction pour ajouter un service
function inserer_service($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_service where codeservice='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_service(nomservice,codeservice, domaineservice, telephoneservice, localservice) "
                            . "values('" . addslashes($reg["1"]["service"]) . "', '" . $reg["1"]["codep"] . "', "
                    . "'" . addslashes($reg["1"]["domaine"]) . "', '" . addslashes($reg["1"]["tel"]) . "', "
                    . "'" . addslashes($reg["1"]["local"]) . "')") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_service de la valeure {$reg["1"]["service"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formservice']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalservice/lister_service';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalservice/hopitalajouter/ajout_service';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les services
function lister_service($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_service ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["domaineservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephoneservice"])) ?></td>
            <td>
                <?php
                if ($recuser["localservice"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalservice/service_ajax'); ?>&idservice=<?php echo $recuser["idservice"]; ?>&delocaliser=delocaliser" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Délocaliser ce Service ?'));">
                        <span title="D&eacute;localiser ce service" data-toggle="tooltip" alt="oui" class="label-success label">Local</span>
                    </a>
                            <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalservice/service_ajax'); ?>&idservice=<?php echo $recuser["idservice"]; ?>&localiser=localiser" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Localiser ce Service ?'));">
                        <span title="Localiser ce service " data-toggle="tooltip" alt="non" class="label-warning label">Multiple</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <?php
                if ($recuser["etatservice"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalservice/service_ajax'); ?>&idservice=<?php echo $recuser["idservice"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce Service ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                            <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalservice/service_ajax'); ?>&idservice=<?php echo $recuser["idservice"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce Service ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalservice/hopitalediter/edit_service'); ?>&idservice=<?php echo $recuser["idservice"]; ?>" >
                    <span title="Modifier ce service" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
<!--                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalservice/service_ajax'); ?>&idservice=<?php echo $recuser["idservice"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce service ?'));" >
                    <span title="Supprimer ce service " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_service($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_service where codeservice='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_service set codeservice='" . $reg["1"]["codepe"] . "', nomservice='" . addslashes($reg["1"]["servicee"]) . "', "
                            . "domaineservice='" . addslashes($reg["1"]["domainee"]) . "', telephoneservice='" . ($reg["1"]["tel"]) . "', "
                    . "localservice='" . ($reg["1"]["local"]) . "' where idservice='" . $reg["1"]["idservice"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_service de la valeure {$reg["1"]["service"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formservicee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalservice/lister_service';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idservice"] != $reg["1"]["idservice"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_service set codeservice='" . $reg["1"]["codepe"] . "', nomservice='" . addslashes($reg["1"]["servicee"]) . "', "
                                . "domaineservice='" . addslashes($reg["1"]["domainee"]) . "', telephoneservice='" . ($reg["1"]["tel"]) . "', "
                    . "localservice='" . ($reg["1"]["local"]) . "' where idservice='" . $reg["1"]["idservice"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_service de la valeure {$reg["1"]["service"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formservicee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalservice/lister_service';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalservice/hopitalediter/edit_service';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idservice=' . $reg["1"]["idservice"] . '">');
            }
        }
    }
}
