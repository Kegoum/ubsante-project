<?php

//fonction pour ajouter un unite
function inserer_unite($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_unite where codeunite='" . $reg["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_unite(libelleunite,codeunite) "
                            . "values('" . addslashes($reg["1"]["unite"]) . "', "
                            . "'" . $reg["1"]["codep"] . "')") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_unite de la valeure {$reg["1"]["unite"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formunite']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalunite/lister_unite';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalunite/hopitalajouter/ajout_unite';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les unites
function lister_unite($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_unite ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idunite"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codeunite"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelleunite"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalunite/hopitalediter/edit_unite'); ?>&idunite=<?php echo $recuser["idunite"]; ?>" >
                    <span title="Modifier cette unit&eacute;" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalunite/unite_ajax'); ?>&idunite=<?php echo $recuser["idunite"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer cette unité ?'));" >
                    <span title="Supprimer cette unit&eacute; " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_unite($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_unite where codeunite='" . $reg["1"]["codepe"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_unite set codeunite='" . $reg["1"]["codepe"] . "', libelleunite='" . addslashes($reg["1"]["unitee"]) . "' "
                    . "where idunite='" . $reg["1"]["idunite"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_unite de la valeure {$reg["1"]["unite"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formunitee']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalunite/lister_unite';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idunite"] != $reg["1"]["idunite"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_unite set codeunite='" . $reg["1"]["codepe"] . "', libelleunite='" . addslashes($reg["1"]["unitee"]) . "' "
                        . "where idunite='" . $reg["1"]["idunite"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_unite de la valeure {$reg["1"]["unite"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formunitee']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalunite/lister_unite';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalunite/hopitalediter/edit_unite';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idunite=' . $reg["1"]["idunite"] . '">');
            }
        }
    }
}
