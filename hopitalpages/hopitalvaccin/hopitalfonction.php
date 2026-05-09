<?php

function inserer_vaccin($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    if (($reg != NULL) && isset($reg["1"])) {

        $sexe = ($reg["1"]['sexe']);
        $nomp = addslashes($reg["1"]['nom']);
        $datenais = ($reg["1"]['datenais']);
        $quartier = addslashes($reg["1"]['quartier']);
        $nomparent = addslashes($reg["1"]['nomparent']);
        $telpc = ($reg["1"]['telc']);
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');

//        $numid = "PA" . $jou . $moi . $sand . sprintf("%05d", 1);

        $req = $con->query("select * from hp_vaccin as e where DAY(e.datevaccin)='" . $jou . "' and "
                . "MONTH(e.datevaccin)='" . $moi . "' and YEAR(e.datevaccin)='" . $an . "'") or die(mysqli_error($con));
        $i = mysqli_num_rows($req);
        $numid = "VAC" . $jou . $moi . $sand . sprintf("%05d", ($i + 1));
        if (($datenais != "") && ($datenais != NULL)) {
            $con->query("insert into hp_vaccin(numerovaccin, sexevaccin, nomvaccin, datenaissancevaccin, "
                            . "quartiervaccin, nomparentvaccin, contactvaccin, datevaccin) values('" . $numid . "', "
                            . "'" . $sexe . "', '" . $nomp . "', '" . $datenais . "', '" . $quartier . "', '" . $nomparent . "', "
                            . "'" . $telpc . "', NOW())") or die(mysqli_error($con));
        } else {
            $con->query("insert into hp_vaccin(numerovaccin, sexevaccin, nomvaccin, quartiervaccin, nomparentvaccin, "
                            . "contactvaccin, datevaccin) values('" . $numid . "', '" . $sexe . "', '" . $nomp . "', "
                            . "'" . $quartier . "', '" . $nomparent . "', '" . $telpc . "', NOW())") or die(mysqli_error($con));
        }
        $resultat2 = $con->query("SELECT * FROM hp_vaccin where numerovaccin='" . $numid . "'") or die(mysqli_error($con));
        $row2 = mysqli_fetch_assoc($resultat2);

//            $op = "Enregistrement";
//            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
//                $con->query("insert into hp_trace(idvaccin, operation, objet, datetrace) "
//                                . "values('" . $row2["idvaccin"] . "', "
//                                . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
//            } else {
//                $con->query("insert into hp_trace(idcomptepersonnel, idvaccin, operation, objet, datetrace) "
//                                . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $row2["idvaccin"] . "', "
//                                . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
//            }


        unset($_SESSION['formvaccin']);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalvaccin/lister_vaccin';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}

//fonction pour lister les vaccins
function lister_vaccin($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_vaccin as v left join hp_acte as a on v.idacte=a.idacte "
            . "where v.archivevaccin=false") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td>
                <?php
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Directeur de Centre")))) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitaldossiervaccin/lister_dossier_vaccin') ?>&idvaccin=<?php echo $recuser["idvaccin"] ?>">
                        <span title="Ouvrir le dossier de ce Vaccin" ><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                    if (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Sage Femme")) {
                        ?>
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitaldossiervaccin/lister_dossier_vaccin') ?>&idvaccin=<?php echo $recuser["idvaccin"] ?>">
                            <span title="Ouvrir le dossier de ce Vaccin" ><i class="glyphicon glyphicon-folder-open"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
                &nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalediter/edit_vaccin'); ?>&idvaccin=<?php echo $recuser["idvaccin"]; ?>" >
                    <span title="Modifier ce vaccin" alt="list"><i class="glyphicon glyphicon-edit"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitaldossiervaccin/hopitaladministrer/administrer_vaccin'); ?>&idvaccin=<?php echo $recuser["idvaccin"]; ?>" >
                    <span title="Administrer ce vaccin" alt="add"><i class="glyphicon glyphicon-plus"></i></span>
                </a>

            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["numerovaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["sexevaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomvaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["datenaissancevaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["quartiervaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomparentvaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["contactvaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["bcgvaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["polio0vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["polio1vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["polio2vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["polio3vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vpivaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["penta1vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["penta2vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["penta3vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["pneumo1vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["pneumo2vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["pneumo3vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["rota1vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["rota2vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["var1vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["var2vaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vaavaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita6mvaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita1avaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita1a6mvaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita2avaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita2a6mvaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita3avaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita3a6mvaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita4avaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita4a6mvaccin"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["vita5avaccin"])) ?></td>
        </tr>
        <?php
    }
}

function update_vaccin($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    if (($reg != NULL) && isset($reg["1"])) {
        $idv = ($reg["1"]['idvaccin']);
        $sexe = ($reg["1"]['sexe']);
        $nomp = addslashes($reg["1"]['nom']);
        $datenais = ($reg["1"]['datenais']);
        $quartier = addslashes($reg["1"]['quartier']);
        $nomparent = addslashes($reg["1"]['nomparent']);
        $telpc = ($reg["1"]['telc']);
        if (($datenais != "") && ($datenais != NULL)) {
            $con->query("update hp_vaccin set sexevaccin='" . $sexe . "', nomvaccin='" . $nomp . "', datenaissancevaccin='" . $datenais . "', "
                            . "quartiervaccin='" . $quartier . "', nomparentvaccin='" . $nomparent . "', contactvaccin='" . $telpc . "' "
                    . "where idvaccin='" . $idv . "'") or die(mysqli_error($con));
        } else {
            $con->query("update hp_vaccin set sexevaccin='" . $sexe . "', nomvaccin='" . $nomp . "', "
                            . "quartiervaccin='" . $quartier . "', nomparentvaccin='" . $nomparent . "', contactvaccin='" . $telpc . "' "
                    . "where idvaccin='" . $idv . "'") or die(mysqli_error($con));
        }
//        $obj = "Vaccin";
//        $op = "Modification";
//        if (isset($_SESSION["idcomptepersonnel"])) {
//            $con->query("insert into hp_trace(idcomptepersonnel, idvaccin, operation, objet, datetrace) "
//                            . "values('" . $_SESSION["idcomptepersonnel"] . "', '" . $idpat . "', "
//                            . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
//        } else {
//            $con->query("insert into hp_trace(idvaccin, operation, objet, datetrace) "
//                            . "values('" . $idpat . "', "
//                            . "'" . $op . "', '" . $obj . "', NOW())") or die(mysqli_error($con));
//        }
        unset($_SESSION['formvaccine']);
        echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalvaccin/lister_vaccin';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}

function modifier_soin_vaccin($id, $prixtotal, $com, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($com != NULL)) {
        $an = date('Y');

        $etat = "Valider";

        $rsltplk = $con->query("select * from hp_soin_vaccin as c left join hp_hospitalisation as h on "
                . "c.idhospitalisation=h.idhospitalisation left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_vaccin as p on d.idvaccin=p.idvaccin left join "
                . "hp_departement as dp on p.residencevaccin=dp.iddepartement where "
                . "c.idsoinvaccin='" . $id . "'") or die(mysqli_error($con));
        $rowservk = mysqli_fetch_assoc($rsltplk);

        $prixt = 0;
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvsoine" . $id] as $prod) {
            $reqar = $con->query("select * from hp_ligne_soin_vaccin as lbl left join hp_produit as a on "
                    . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie "
                    . "where lbl.idsoinvaccin='" . $id . "' and lbl.idproduit='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $nbar = mysqli_num_rows($reqar);
            if ($nbar == 0) {
                $con->query("insert into hp_ligne_soin_vaccin(idsoinvaccin, idunitesoinvaccin, idproduit, quantitelignesoinvaccin, "
                                . "prixlignesoinvaccin, datelignesoinvaccin) values('" . $rowservk["idsoinvaccin"] . "', "
                                . "'" . $prod["uniteart"] . "', '" . $prod["idart"] . "', '" . $prod["qteart"] . "', "
                                . "'" . $prod["prixart"] . "', NOW())") or die(mysqli_error($con));
            } else {
                $rowar = mysqli_fetch_assoc($reqar);
                $con->query("update hp_ligne_soin_vaccin set idunitesoinvaccin='" . $prod["uniteart"] . "', "
                                . "quantitelignesoinvaccin='" . $prod["qteart"] . "', prixlignesoinvaccin='" . $prod["prixart"] . "' "
                                . "where idlignesoinvaccin='" . $rowar["idlignesoinvaccin"] . "'") or die(mysqli_error($con));
            }

            $obj = "Soin " . $id . "-" . $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Modification soin";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, objet, operation, "
                        . "datetrace) values('" . $prod["idart"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                $rsltvente = $con->query("insert into hp_trace(idproduit, idcomptepersonnel, objet, operation, "
                        . "datetrace) values('" . $prod["idart"] . "', '" . $_SESSION["idcomptepersonnel"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
        }

        $con->query("update hp_soin_vaccin set prixsoinvaccin='" . $prixtotal . "' where idsoinvaccin='" . $id . "'") or die(mysqli_error($con));
        $con->query("update hp_facture set montantfacture='" . $prixtotal . "' where idsoinvaccin='" . $id . "'") or die(mysqli_error($con));
        ?>
        <?php
        unset($_SESSION["cart_prodvsoine" . $id]);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalfacture/lister_facture';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}
