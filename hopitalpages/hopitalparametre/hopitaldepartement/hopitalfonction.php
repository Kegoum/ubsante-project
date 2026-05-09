<?php

//fonction pour ajouter un departement
function inserer_departement($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_departement as v left join hp_region as p on v.idregion=p.idregion where "
                . "v.libelledepartement='" . addslashes($reg["1"]["departement"]) . "' "
                . "") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_departement(libelledepartement,cheflieudepartement,idregion) "
                    . "values('" . addslashes($reg["1"]["departement"]) . "', '" . addslashes($reg["1"]["cheflieu"]) . "', "
                    . "'" . $reg["1"]["region"] . "')") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_departement de la valeure {$reg["1"]["departement"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formdepartement']);
            $pagp = 'hopitalpages/hopitalparametre/hopitaldepartement/lister_departement';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitaldepartement/hopitalajouter/ajout_departement';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les departements
function lister_departement($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_departement as v left join hp_region as p on v.idregion=p.idregion "
            . "") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["iddepartement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelledepartement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["cheflieudepartement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleregion"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldepartement/hopitalediter/edit_departement'); ?>&iddepartement=<?php echo $recuser["iddepartement"]; ?>" >
                    <span title="Modifier ce departement" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldepartement/departement_ajax'); ?>&iddepartement=<?php echo $recuser["iddepartement"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce Département ?'));" >
                        <span title="Supprimer ce departement " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_departement($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_departement as v left join hp_region as p on v.idregion=p.idregion where "
                . "v.libelledepartement='" . addslashes($reg["1"]["departemente"]) . "' "
                . "") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_departement set idregion='" . $reg["1"]["regione"] . "', libelledepartement='" . addslashes($reg["1"]["departemente"]) . "', "
                    . "cheflieudepartement='" . addslashes($reg["1"]["cheflieue"]) . "' where iddepartement='" . $reg["1"]["iddepartement"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_departement de la valeure {$reg["1"]["departement"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formdepartemente']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitaldepartement/lister_departement';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $rowv = mysqli_fetch_assoc($req);
            if ($rowv["iddepartement"] == $reg["1"]["iddepartement"]) {
                $con->query("update hp_departement set idregion='" . $reg["1"]["regione"] . "', libelledepartement='" . addslashes($reg["1"]["departemente"]) . "', "
                        . "cheflieudepartement='" . addslashes($reg["1"]["cheflieue"]) . "' where iddepartement='" . $reg["1"]["iddepartement"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_departement de la valeure {$reg["1"]["departement"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formdepartemente']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitaldepartement/lister_departement';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitaldepartement/hopitalediter/edit_departement';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&iddepartement=' . $reg["1"]["iddepartement"] . '">');
            }
        }
    }
}
