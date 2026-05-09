<?php

function inserer_parametre_patient($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $err = false;
        $date = date('Y-m-d');
        $eta = 1;
        $idcons = $reg["1"]["idconsultation"];
        $datej = $reg["1"]["datejour"];
        $heurej = $reg["1"]["heurejour"];
//        echo "<script language='javascript'>alert($datej)</script>";

        for ($i = 0; $i < $reg["1"]["nbparametre"]; $i++) {
            if (in_array($i, $reg[1]['tparam[]'])) {
                $id = $reg["1"]["parametre" . $i];
                $param = addslashes($reg["1"]["param" . $i]);
                $reqmc = $con->query("select * from hp_parametre_patient where idconsultation='" . $idcons . "' and "
                        . "idparametre='" . $id . "' and datejourparametrepatient='" . $datej . "' "
                        . "and heureparametrepatient='" . $heurej . "'") or die(mysqli_error($con));
                $nbmc = mysqli_num_rows($reqmc);
                if ($nbmc == 0) {
                    $rsltn = $con->query("insert into hp_parametre_patient(idconsultation, idparametre, valeurparametrepatient, "
                            . "datejourparametrepatient, heureparametrepatient, dateparametrepatient) values('" . $idcons . "', "
                            . "'" . $id . "', '" . $param . "', '" . $datej . "', '" . $heurej . "', NOW())") or die(mysqli_error($con));
                    $op = "Ajout";
                    $ob = "Parametre patient";
//                    $rsltt = $con->query("insert into smstrace(idparametre, iduser, operation, objet, date) values('" . $id . "', "
//                                . "'" . $_SESSION["idutilisateur"] . "', '" . $op . "', '" . $ob . "', NOW())") or die(mysqli_error($con));
//                    echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
//                    $pagp = 'hopitalpages/hopitalpatient/lister_patient';
//                    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
                } else {
                    $err = true;
                }
            }
        }
        $resultat2d = $con->query("SELECT * FROM hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . " where c.idconsultation='" . $reg["1"]["idconsultation"] . "'") or die(mysqli_error($con));
        $row2d = mysqli_fetch_assoc($resultat2d);
        $lieu = "Medécin";
        $con->query("update hp_dossier set lieudossier='" . $lieu . "' where iddossier='" . $row2d["iddossier"] . "'") or die(mysqli_error($con));

        if ($err) {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/ajout_param_matiere';
            die('<meta http-equiv="refresh" content="5 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idconsultation=' . $idcons . '">');
        } else {
            unset($_SESSION['formparametrepatient']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpatient/hopitalparametre/lister_parametre_patient';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idconsultation=' . $idcons . '">');
        }
    }
}

function lister_parametre_patient($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $rsltfnp = $con->query("select * from hp_parametre_patient as lc left join hp_parametre as f on lc.idparametre=f.idparametre "
            . "left join hp_unite as u on f.idunite=u.idunite where lc.idconsultation='" . $id . "' "
            . "order by lc.datejourparametrepatient desc ") or die(mysqli_error($con));
    $nbfnp = mysqli_num_rows($rsltfnp);
    ?>

    <?php
    if (($nbfnp != 0)) {
        while ($recfnp = mysqli_fetch_assoc($rsltfnp)) {
            ?>

            <tr >
                <td></td>
                <td><?php print nl2br(htmlspecialchars($recfnp["datejourparametrepatient"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recfnp["heureparametrepatient"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recfnp["libelleparametre"])) ?></td>
                <td>
                    <?php print nl2br(htmlspecialchars($recfnp["valeurminparametre"])) ?> 
                    <?php print nl2br(htmlspecialchars($recfnp["codeunite"])) ?> 
                </td>
                <td><?php print nl2br(htmlspecialchars($recfnp["valeurmaxparametre"])) ?> 
                    <?php print nl2br(htmlspecialchars($recfnp["codeunite"])) ?> 
                </td>
                <td><?php print nl2br(htmlspecialchars($recfnp["valeurparametrepatient"])) ?> 
                    <?php print nl2br(htmlspecialchars($recfnp["codeunite"])) ?> 
                </td>
            </tr>
            <?php
        }
    }
}
