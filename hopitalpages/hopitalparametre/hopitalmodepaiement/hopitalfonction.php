<?php

//fonction pour ajouter un modepaiement
function inserer_modepaiement($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_mode_paiement where codemodepaiement='" . addslashes($reg["1"]["code"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_mode_paiement(codemodepaiement,libellemodepaiement) values('" . addslashes($reg["1"]["code"]) . "', "
                            . "'" . addslashes($reg["1"]["modepaiement"]) . "')") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_mode_paiement de la valeure {$reg["1"]["modepaiement"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formmodepaiement']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalmodepaiement/lister_modepaiement';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalajouter/ajout_modepaiement';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les modepaiements
function lister_modepaiement($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_mode_paiement as v ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idmodepaiement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codemodepaiement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellemodepaiement"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalediter/edit_modepaiement'); ?>&idmodepaiement=<?php echo $recuser["idmodepaiement"]; ?>" >
                        <span title="Modifier ce mode de paiement" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>
                    &nbsp;&nbsp;
                    <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalmodepaiement/modepaiement_ajax'); ?>&idmodepaiement=<?php echo $recuser["idmodepaiement"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce mode de paiement ?'));" >
                        <span title="Supprimer ce mode de paiement " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                    </a>
            </td>
        </tr>
        <?php
    }
}

function update_modepaiement($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_mode_paiement where codemodepaiement='" . addslashes($reg["1"]["codee"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_mode_paiement set codemodepaiement='" . addslashes($reg["1"]["codee"]) . "', libellemodepaiement='" . addslashes($reg["1"]["modepaiemente"]) . "' "
                            . "where idmodepaiement='" . $reg["1"]["idmodepaiement"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_mode_paiement de la valeure {$reg["1"]["modepaiement"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formmodepaiemente']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalmodepaiement/lister_modepaiement';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $rowv = mysqli_fetch_assoc($req);
            if ($rowv["idmodepaiement"] == $reg["1"]["idmodepaiement"]) {
                $con->query("update hp_mode_paiement set codemodepaiement='" . addslashes($reg["1"]["codee"]) . "', libellemodepaiement='" . addslashes($reg["1"]["modepaiemente"]) . "' "
                                . "where idmodepaiement='" . $reg["1"]["idmodepaiement"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_mode_paiement de la valeure {$reg["1"]["modepaiement"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formmodepaiemente']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalmodepaiement/lister_modepaiement';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalediter/edit_modepaiement';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idmodepaiement=' . $reg["1"]["idmodepaiement"] . '">');
            }
        }
    }
}
