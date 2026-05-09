<?php

//fonction pour lister les familles
function lister_famille($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_classe_medicamenteuse ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idclassemedicamenteuse"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleclassemedicamenteuse"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfamille/hopitalediter/edit_famille'); ?>&idclassemedicamenteuse=<?php echo $recuser["idclassemedicamenteuse"]; ?>" >
                    <span title="Modifier cette famille" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfamille/famille_ajax'); ?>&idclassemedicamenteuse=<?php echo $recuser["idclassemedicamenteuse"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer cette famille ?'));" >
                    <span title="Supprimer cette famille " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_famille($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_classe_medicamenteuse where libelleclassemedicamenteuse='" . $reg["1"]["famillee"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_classe_medicamenteuse set libelleclassemedicamenteuse='" . addslashes($reg["1"]["famillee"]) . "' "
                            . "where idclassemedicamenteuse='" . $reg["1"]["idclassemedicamenteuse"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_famille de la valeure {$reg["1"]["famille"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formfamillee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalfamille/lister_famille';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idclassemedicamenteuse"] != $reg["1"]["idclassemedicamenteuse"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_classe_medicamenteuse set libelleclassemedicamenteuse='" . addslashes($reg["1"]["famillee"]) . "' "
                                . "where idclassemedicamenteuse='" . $reg["1"]["idclassemedicamenteuse"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_famille de la valeure {$reg["1"]["famille"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formfamillee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalfamille/lister_famille';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalfamille/hopitalediter/edit_famille';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idclassemedicamenteuse=' . $reg["1"]["idclassemedicamenteuse"] . '">');
            }
        }
    }
}
