<?php

//fonction pour lister les decaissements
function lister_decaissement_caisse($id, $con) {
    //echo "<script language='javascript'>alert('slow')</script>";
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $eta = "Actif";
    $ope = "Décaissement";
    $rsltuser = NULL;
    if ($id != NULL) {
        $rsltuser = $con->query("select * from hp_ligne_caisse as lc where "
                . "lc.idcaisse='" . $id . "' and lc.paiementlignecaisse='" . $eta . "' and lc.operationlignecaisse='" . $ope . "' ") or die(mysqli_error($con));
    } else {
        $rsltuser = $con->query("select * from hp_ligne_caisse as lc where "
                . "lc.idcaisse is null and lc.paiementlignecaisse='" . $eta . "' and lc.operationlignecaisse='" . $ope . "' ") or die(mysqli_error($con));
    }
    $nb = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $nb = $nb + 1;
        ?>
        <tr >
            <td></td>
            <td>
                <?php print $nb; ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["datejourlignecaisse"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["butlignecaisse"])) ?></td>
            <td><?php print number_format(($recuser["montantlignecaisse"]), 0, ',', ' ') ?></td>
            <td>
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldecaissement/hopitalediter/edit_decaissement'); ?>&idlignecaisse=<?php echo $recuser["idlignecaisse"]; ?>" >
                    <span title="Modifier ce d&eacute;caissement" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

//fonction pour ajouter un decaissement
function inserer_decaissement($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
// echo "<script language='javascript'>alert('slow')</script>";
        $idu = $reg["1"]['idcaisse'];

        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');
        $ope = "Décaissement";
        $req = $con->query("select * from hp_ligne_caisse as e where DAY(e.datelignecaisse)='" . $jou . "' "
                . "and MONTH(e.datelignecaisse)='" . $moi . "' and YEAR(e.datelignecaisse)='" . $an . "'") or die(mysqli_error($con));
        $i = mysqli_num_rows($req);
        $numid = "FA" . $jou . $moi . $sand . sprintf("%05d", ($i + 1));

//                    echo "<script language='javascript'>alert($idtrfi)</script>";
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $con->query("insert into hp_ligne_caisse(codelignecaisse, butlignecaisse, operationlignecaisse, "
                            . "datejourlignecaisse, montantlignecaisse, datelignecaisse) values('" . $numid . "', "
                            . "'" . addslashes($reg["1"]["but"]) . "','" . $ope . "', '" . $reg["1"]["datejour"] . "', "
                            . "'" . $reg["1"]['montvers'] . "', NOW())") or die(mysqli_error($con));
        } else {
            $con->query("insert into hp_ligne_caisse(idcomptepersonnel, idcaisse, codelignecaisse, butlignecaisse, "
                            . "operationlignecaisse, datejourlignecaisse, montantlignecaisse, datelignecaisse) values("
                            . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $_SESSION["idcaisse"] . "', '" . $numid . "', "
                            . "'" . addslashes($reg["1"]["but"]) . "','" . $ope . "','" . $reg["1"]["datejour"] . "', "
                            . "'" . $reg["1"]['montvers'] . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION['formdecaissement']);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitaldecaissement/lister_decaissement';
        if ($idu != NULL) {
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idcaisse=' . $idu . '">');
        } else {
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

function update_decaissement($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $req = $con->query("select * from hp_ligne_caisse as e where idlignecaisse='" . $reg["1"]["idlignecaisse"] . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($req);
        $con->query("update hp_ligne_caisse set butlignecaisse='" . addslashes($reg["1"]["but"]) . "', "
                        . "datejourlignecaisse='" . $reg["1"]["datejour"] . "', montantlignecaisse='" . $reg["1"]['montvers'] . "' "
                        . "where idlignecaisse='" . $reg["1"]["idlignecaisse"] . "'") or die(mysqli_error($con));
        unset($_SESSION['formdecaissemente']);
        echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitaldecaissement/lister_decaissement';
        if ($row["idcaisse"] != NULL) {
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idcaisse=' . $row["idcaisse"] . '">');
        } else {
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}
