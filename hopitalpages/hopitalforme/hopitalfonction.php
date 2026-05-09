<?php

//fonction pour lister les formes
function lister_forme($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_forme ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idforme"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleforme"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalforme/hopitalediter/edit_forme'); ?>&idforme=<?php echo $recuser["idforme"]; ?>" >
                    <span title="Modifier cette forme" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalforme/forme_ajax'); ?>&idforme=<?php echo $recuser["idforme"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer cette forme ?'));" >
                    <span title="Supprimer cette forme " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_forme($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_forme where libelleforme='" . $reg["1"]["formee"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_forme set libelleforme='" . addslashes($reg["1"]["formee"]) . "' "
                            . "where idforme='" . $reg["1"]["idforme"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_forme de la valeure {$reg["1"]["forme"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formformee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalforme/lister_forme';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idforme"] != $reg["1"]["idforme"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_forme set libelleforme='" . addslashes($reg["1"]["formee"]) . "' "
                                . "where idforme='" . $reg["1"]["idforme"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_forme de la valeure {$reg["1"]["forme"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formformee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalforme/lister_forme';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalforme/hopitalediter/edit_forme';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idforme=' . $reg["1"]["idforme"] . '">');
            }
        }
    }
}
