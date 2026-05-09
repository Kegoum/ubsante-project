<?php

//fonction pour lister les conditionnements
function lister_conditionnement($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_conditionnement ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idconditionnement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleconditionnement"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalconditionnement/hopitalediter/edit_conditionnement'); ?>&idconditionnement=<?php echo $recuser["idconditionnement"]; ?>" >
                    <span title="Modifier ce conditionnement" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalconditionnement/conditionnement_ajax'); ?>&idconditionnement=<?php echo $recuser["idconditionnement"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce Conditionnement ?'));" >
                    <span title="Supprimer ce conditionnement " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_conditionnement($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_conditionnement where libelleconditionnement='" . $reg["1"]["conditionnemente"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_conditionnement set libelleconditionnement='" . addslashes($reg["1"]["conditionnemente"]) . "' "
                            . "where idconditionnement='" . $reg["1"]["idconditionnement"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_conditionnement de la valeure {$reg["1"]["conditionnement"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formconditionnemente']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalconditionnement/lister_conditionnement';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idconditionnement"] != $reg["1"]["idconditionnement"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_conditionnement set libelleconditionnement='" . addslashes($reg["1"]["conditionnemente"]) . "' "
                                . "where idconditionnement='" . $reg["1"]["idconditionnement"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_conditionnement de la valeure {$reg["1"]["conditionnement"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formconditionnemente']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalconditionnement/lister_conditionnement';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalconditionnement/hopitalediter/edit_conditionnement';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idconditionnement=' . $reg["1"]["idconditionnement"] . '">');
            }
        }
    }
}
