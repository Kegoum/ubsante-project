<?php

//fonction pour ajouter un examen
function inserer_examen($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_examen where codeexamen='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_examen(idunite, idlaboratoire, nomexamen, codeexamen, prixexamen, typeexamen, resultatexamen, valeurminexamen, "
                            . "valeurmaxexamen, dateexamen) values('" . ($reg["1"]["unite"]) . "', '" . ($reg["1"]["laboratoire"]) . "', '" . addslashes($reg["1"]["examen"]) . "', '" . $reg["1"]["codep"] . "', "
                            . "'" . $reg["1"]["montant"] . "', '" . addslashes($reg["1"]["type"]) . "', '" . addslashes($reg["1"]["resultat"]) . "', "
                            . "'" . ($reg["1"]["valmin"]) . "', '" . ($reg["1"]["valmax"]) . "', NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_examen de la valeure {$reg["1"]["examen"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formexamen']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalexamen/lister_examen';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalexamen/hopitalajouter/ajout_examen';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les examens
function lister_examen($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_examen as p left join hp_laboratoire as l on p.idlaboratoire=l.idlaboratoire "
            . "left join hp_service as s on l.idservice=s.idservice left join hp_unite as u on p.idunite=u.idunite ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idexamen"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomlaboratoire"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeexamen"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomexamen"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixexamen"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["typeexamen"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["resultatexamen"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["valeurminexamen"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> </td>
            <td><?php print nl2br(htmlspecialchars($recuser["valeurmaxexamen"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> </td>
            <td>
                <?php
                if ($recuser["etatexamen"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalexamen/examen_ajax'); ?>&idexamen=<?php echo $recuser["idexamen"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cet Examen ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalexamen/examen_ajax'); ?>&idexamen=<?php echo $recuser["idexamen"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cet Examen ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalexamen/hopitalediter/edit_examen'); ?>&idexamen=<?php echo $recuser["idexamen"]; ?>" >
                    <span title="Modifier ce examen" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                <!--                &nbsp;&nbsp;
                                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalexamen/examen_ajax'); ?>&idexamen=<?php echo $recuser["idexamen"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce examen ?'));" >
                                    <span title="Supprimer ce examen " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_examen($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_examen where codeexamen='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_examen set idunite='" . $reg["1"]["unite"] . "', idlaboratoire='" . $reg["1"]["laboratoire"] . "', codeexamen='" . $reg["1"]["codepe"] . "', nomexamen='" . addslashes($reg["1"]["examene"]) . "', "
                            . "prixexamen='" . ($reg["1"]["montant"]) . "', typeexamen='" . addslashes($reg["1"]["type"]) . "', "
                            . "resultatexamen='" . addslashes($reg["1"]["resultat"]) . "', valeurminexamen='" . ($reg["1"]["valmin"]) . "', "
                            . "valeurmaxexamen='" . ($reg["1"]["valmax"]) . "' where idexamen='" . $reg["1"]["idexamen"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_examen de la valeure {$reg["1"]["examen"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formexamene']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalexamen/lister_examen';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idexamen"] != $reg["1"]["idexamen"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_examen set idunite='" . $reg["1"]["unite"] . "', idlaboratoire='" . $reg["1"]["laboratoire"] . "', codeexamen='" . $reg["1"]["codepe"] . "', nomexamen='" . addslashes($reg["1"]["examene"]) . "', "
                            . "prixexamen='" . ($reg["1"]["montant"]) . "', typeexamen='" . addslashes($reg["1"]["type"]) . "', "
                            . "resultatexamen='" . addslashes($reg["1"]["resultat"]) . "', valeurminexamen='" . ($reg["1"]["valmin"]) . "', "
                            . "valeurmaxexamen='" . ($reg["1"]["valmax"]) . "' where idexamen='" . $reg["1"]["idexamen"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_examen de la valeure {$reg["1"]["examen"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formexamene']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalexamen/lister_examen';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalexamen/hopitalediter/edit_examen';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idexamen=' . $reg["1"]["idexamen"] . '">');
            }
        }
    }
}
