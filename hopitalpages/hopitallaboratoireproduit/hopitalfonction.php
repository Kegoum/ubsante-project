<?php

//fonction pour lister les laboratoireproduits
function lister_laboratoireproduit($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_laboratoire_produit ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idlaboratoireproduit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellelaboratoireproduit"])) ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitallaboratoireproduit/hopitalediter/edit_laboratoireproduit'); ?>&idlaboratoireproduit=<?php echo $recuser["idlaboratoireproduit"]; ?>" >
                    <span title="Modifier ce laboratoire" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitallaboratoireproduit/laboratoireproduit_ajax'); ?>&idlaboratoireproduit=<?php echo $recuser["idlaboratoireproduit"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce laboratoire ?'));" >
                    <span title="Supprimer ce laboratoire " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_laboratoireproduit($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_laboratoire_produit where libellelaboratoireproduit='" . $reg["1"]["laboratoireproduite"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_laboratoire_produit set libellelaboratoireproduit='" . addslashes($reg["1"]["laboratoireproduite"]) . "' "
                            . "where idlaboratoireproduit='" . $reg["1"]["idlaboratoireproduit"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_laboratoireproduit de la valeure {$reg["1"]["laboratoireproduit"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formlaboratoireproduite']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitallaboratoireproduit/lister_laboratoireproduit';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $ok = true;
            while ($rowv = mysqli_fetch_assoc($req)) {
                if ($rowv["idlaboratoireproduit"] != $reg["1"]["idlaboratoireproduit"]) {
                    $ok = FALSE;
                }
            }
            if ($ok) {
                $con->query("update hp_laboratoire_produit set libellelaboratoireproduit='" . addslashes($reg["1"]["laboratoireproduite"]) . "' "
                                . "where idlaboratoireproduit='" . $reg["1"]["idlaboratoireproduit"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_laboratoireproduit de la valeure {$reg["1"]["laboratoireproduit"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formlaboratoireproduite']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitallaboratoireproduit/lister_laboratoireproduit';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitallaboratoireproduit/hopitalediter/edit_laboratoireproduit';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idlaboratoireproduit=' . $reg["1"]["idlaboratoireproduit"] . '">');
            }
        }
    }
}
