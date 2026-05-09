<?php

//fonction pour lister les dosages
function lister_dosage($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_dosage ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["iddosage"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelledosage"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldosage/hopitalediter/edit_dosage'); ?>&iddosage=<?php echo $recuser["iddosage"]; ?>" >
                    <span title="Modifier ce dosage" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldosage/dosage_ajax'); ?>&iddosage=<?php echo $recuser["iddosage"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce dosage ?'));" >
                    <span title="Supprimer ce dosage " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_dosage($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_dosage where libelledosage='" . $reg["1"]["dosagee"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_dosage set libelledosage='" . addslashes($reg["1"]["dosagee"]) . "' "
                            . "where iddosage='" . $reg["1"]["iddosage"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_dosage de la valeure {$reg["1"]["dosage"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formdosagee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitaldosage/lister_dosage';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["iddosage"] != $reg["1"]["iddosage"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_dosage set libelledosage='" . addslashes($reg["1"]["dosagee"]) . "' "
                                . "where iddosage='" . $reg["1"]["iddosage"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_dosage de la valeure {$reg["1"]["dosage"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formdosagee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitaldosage/lister_dosage';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitaldosage/hopitalediter/edit_dosage';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&iddosage=' . $reg["1"]["iddosage"] . '">');
            }
        }
    }
}
