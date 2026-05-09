<?php

//fonction pour ajouter un region
function inserer_region($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_region where coderegion='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_region(libelleregion,coderegion, cheflieuregion) "
                            . "values('" . addslashes($reg["1"]["region"]) . "', "
                            . "'" . $reg["1"]["codep"] . "', '" . addslashes($reg["1"]["cheflieu"]) . "')") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_region de la valeure {$reg["1"]["region"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formregion']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalregion/lister_region';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalregion/hopitalajouter/ajout_region';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les regions
function lister_region($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_region ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idregion"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["coderegion"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleregion"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["cheflieuregion"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalregion/hopitalediter/edit_region'); ?>&idregion=<?php echo $recuser["idregion"]; ?>" >
                    <span title="Modifier cette r&eacute;gion" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalregion/lister_departement'); ?>&idregion=<?php echo $recuser["idregion"]; ?>" >
                    <span title="Lister les Villes de cette r&eacute;gion" alt="departement"><i class="glyphicon glyphicon-list-alt"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalregion/region_ajax'); ?>&idregion=<?php echo $recuser["idregion"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer cette R&eacute;gion ?'));" >
                    <span title="Supprimer cette r&eacute;gion " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_region($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_region where coderegion='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_region set coderegion='" . $reg["1"]["codepe"] . "', libelleregion='" . addslashes($reg["1"]["regione"]) . "', "
                            . "cheflieuregion='" . addslashes($reg["1"]["cheflieue"]) . "' where idregion='" . $reg["1"]["idregion"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_region de la valeure {$reg["1"]["region"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formregione']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalregion/lister_region';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idregion"] != $reg["1"]["idregion"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_region set coderegion='" . $reg["1"]["codepe"] . "', libelleregion='" . addslashes($reg["1"]["regione"]) . "', "
                                . "cheflieuregion='" . addslashes($reg["1"]["cheflieue"]) . "' where idregion='" . $reg["1"]["idregion"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_region de la valeure {$reg["1"]["region"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formregione']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalregion/lister_region';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalregion/hopitalediter/edit_region';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idregion=' . $reg["1"]["idregion"] . '">');
            }
        }
    }
}

//fonction pour lister les departements
function lister_departement_region($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_departement as v left join hp_region as p on v.idregion=p.idregion where v.idregion='" . $id . "'") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["iddepartement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelledepartement"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldepartement/hopitalediter/edit_departement'); ?>&iddepartement=<?php echo $recuser["iddepartement"]; ?>" >
                    <span title="Modifier cette departement" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldepartement/departement_ajax'); ?>&iddepartement=<?php echo $recuser["iddepartement"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer cette Ville ?'));" >
                    <span title="Supprimer cette Ville " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}
