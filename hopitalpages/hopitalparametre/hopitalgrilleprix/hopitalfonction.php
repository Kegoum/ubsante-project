<?php

//fonction pour ajouter un grilleprix
function inserer_grilleprix($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_grille_prix where designationgrilleprix='" . $reg["1"]["designationp"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_grille_prix(idacte, typegrilleprix, designationgrilleprix, categoriegrilleprix, montantgrilleprix) "
                            . "values('" . $reg["1"]["acte"] . "', '" . addslashes($reg["1"]["type"]) . "', '" . $reg["1"]["designationp"] . "', "
                    . "'" . addslashes($reg["1"]["categorie"]) . "', '" . addslashes($reg["1"]["montant"]) . "' )") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_grille_prix de la valeure {$reg["1"]["type"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formgrilleprix']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalgrilleprix/lister_grilleprix';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalgrilleprix/hopitalajouter/ajout_grilleprix';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les grilleprixs
function lister_grilleprix($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_grille_prix as gp left join hp_acte as a on gp.idacte=a.idacte left join "
            . "hp_service as c on a.idservice=c.idservice ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idgrilleprix"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["libelleacte"])) ?> - 
                <?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["designationgrilleprix"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["typegrilleprix"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td>
                <?php
                if ($recuser["etatgrilleprix"]) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalgrilleprix/grilleprix_ajax'); ?>&idgrilleprix=<?php echo $recuser["idgrilleprix"]; ?>&desactiver=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce prix ?'));">
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                    </a>
                            <?php
                } else {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalgrilleprix/grilleprix_ajax'); ?>&idgrilleprix=<?php echo $recuser["idgrilleprix"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce prix ?'));">
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalgrilleprix/hopitalediter/edit_grilleprix'); ?>&idgrilleprix=<?php echo $recuser["idgrilleprix"]; ?>" >
                    <span title="Modifier ce grilleprix" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
<!--                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalgrilleprix/grilleprix_ajax'); ?>&idgrilleprix=<?php echo $recuser["idgrilleprix"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce grilleprix ?'));" >
                    <span title="Supprimer ce grilleprix " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>-->
            </td>
        </tr>
        <?php
    }
}

function update_grilleprix($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_grille_prix where designationgrilleprix='" . $reg["1"]["designationpe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_grille_prix set idacte='" . $reg["1"]["acte"] . "', designationgrilleprix='" . addslashes($reg["1"]["designationpe"]) . "', "
                    . "typegrilleprix='" . addslashes($reg["1"]["typee"]) . "', montantgrilleprix='" . ($reg["1"]["montant"]) . "' "
                        . "where idgrilleprix='" . $reg["1"]["idgrilleprix"] . "'") or die(mysqli_error($con));
//             $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_grille_prix de la valeure {$reg["1"]["grilleprix"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formgrilleprixe']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalgrilleprix/lister_grilleprix';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idgrilleprix"] != $reg["1"]["idgrilleprix"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_grille_prix set idacte='" . $reg["1"]["acte"] . "', designationgrilleprix='" . addslashes($reg["1"]["designationpe"]) . "', "
                    . "typegrilleprix='" . addslashes($reg["1"]["typee"]) . "', montantgrilleprix='" . ($reg["1"]["montant"]) . "' "
                        . "where idgrilleprix='" . $reg["1"]["idgrilleprix"] . "'") or die(mysqli_error($con));
//          $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_grille_prix de la valeure {$reg["1"]["grilleprix"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formgrilleprixe']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalgrilleprix/lister_grilleprix';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalgrilleprix/hopitalediter/edit_grilleprix';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idgrilleprix=' . $reg["1"]["idgrilleprix"] . '">');
            }
        }
    }
}
