<?php

//fonction pour ajouter un parametre
function inserer_parametre($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_parametre where libelleparametre='" . addslashes($reg["1"]["parametre"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_parametre(idunite, libelleparametre, valeurminparametre, valeurmaxparametre, dateparametre) "
                            . "values('" . ($reg["1"]["unite"]) . "', '" . addslashes($reg["1"]["parametre"]) . "', '" . ($reg["1"]["valmin"]) . "', "
                            . "'" . ($reg["1"]["valmax"]) . "', NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_parametre de la valeure {$reg["1"]["parametre"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formparametre']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalparametre/lister_parametre';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalparametre/hopitalajouter/ajout_parametre';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les parametres
function lister_parametre($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_parametre as p left join hp_unite as u on p.idunite=u.idunite ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idparametre"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleparametre"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["valeurminparametre"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> 
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["valeurmaxparametre"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?> 
            </td>
            <td>
                <?php
                if ($recuser["etatparametre"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalparametre/parametre_ajax'); ?>&idparametre=<?php echo $recuser["idparametre"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce Paramètre ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalparametre/parametre_ajax'); ?>&idparametre=<?php echo $recuser["idparametre"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce Paramètre ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalparametre/hopitalediter/edit_parametre'); ?>&idparametre=<?php echo $recuser["idparametre"]; ?>" >
                    <span title="Modifier ce param&egrave;tre" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                <!--                &nbsp;&nbsp;
                                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalparametre/parametre_ajax'); ?>&idparametre=<?php echo $recuser["idparametre"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce parametre ?'));" >
                                    <span title="Supprimer ce paramètre " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_parametre($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_parametre where libelleparametre='" . addslashes($reg["1"]["parametree"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_parametre set idunite='" . $reg["1"]["unite"] . "', libelleparametre='" . addslashes($reg["1"]["parametree"]) . "', "
                            . " valeurminparametre='" . ($reg["1"]["valmin"]) . "', valeurmaxparametre='" . ($reg["1"]["valmax"]) . "' where "
                            . "idparametre='" . $reg["1"]["idparametre"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_parametre de la valeure {$reg["1"]["parametre"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formparametree']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalparametre/lister_parametre';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idparametre"] != $reg["1"]["idparametre"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_parametre set idunite='" . $reg["1"]["unite"] . "', libelleparametre='" . addslashes($reg["1"]["parametree"]) . "', "
                                . " valeurminparametre='" . ($reg["1"]["valmin"]) . "', valeurmaxparametre='" . ($reg["1"]["valmax"]) . "' where "
                                . "idparametre='" . $reg["1"]["idparametre"] . "'") or die(mysqli_error($con));
//          $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_parametre de la valeure {$reg["1"]["parametre"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formparametree']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalparametre/lister_parametre';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalparametre/hopitalediter/edit_parametre';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idparametre=' . $reg["1"]["idparametre"] . '">');
            }
        }
    }
}
