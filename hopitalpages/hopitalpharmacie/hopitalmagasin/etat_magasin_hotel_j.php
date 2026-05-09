<?php
if (isset($_POST["datecj"])) {
    $date = $_POST["datecj"];
    $nompharmaciee = $_POST["nompharmacie"];
    $pointhotel = $_SESSION["id_point_hotel"];
    $tab = array();
    $codeb = "BAR";
    
    $rsltb = $con->query("select * from hotel_pharmacie as r left join hotel_point_hotel as ph on "
                    . "r.id_point_hotel=ph.id_point_hotel where r.id_pharmacie='" . $nompharmaciee . "'") or die(mysqli_error($con));
    $rowb = mysqli_fetch_assoc($rsltb);
    
    $rsltserv = $con->query("select * from service_point_hotel as spa left join hotel_service as s on "
            . "spa.id_service=s.id_service where spa.id_point_hotel='" . $pointhotel . "' "
            . "and s.code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuserbl = $con->query("select * from hotel_commande_pharmacie as bl left join hotel_pharmacie as b on bl.id_pharmacie=b.id_pharmacie "
            . "where bl.id_pharmacie='" . $nompharmaciee . "' and b.id_point_hotel='" . $pointhotel . "' and "
            . "cast(bl.date_commande_pharmacie as DATE)<='" . $date . "'") or die(mysqli_error($con));

    $rsltuserbli = $con->query("select * from hotel_bon_livraison_interne as bli where "
            . "bli.id_point_hotel='" . $pointhotel . "' and bli.id_pharmacie='" . $nompharmaciee . "' and cast(bli.date_bli as "
            . "DATE)<='" . $date . "' and bli.id_service_point_hotel='" . $rowserv["id_service_point_hotel"] . "'") 
            or die(mysqli_error($con));
    
    $rsltuserav = $con->query("select * from hotel_article_avarie as aa left join hotel_article_point_hotel as aph on "
            . "aa.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
            . "aph.id_article=a.id_article where aa.id_pharmacie='" . $nompharmaciee . "' and "
            . "aa.id_service_point_hotel='" . $rowserv["id_service_point_hotel"] . "' "
            . "and aph.id_point_hotel='" . $pointhotel . "' and cast(aa.date_article_avarie as DATE)<='" . $date . "'") 
            or die(mysqli_error($con));
    while ($rowbli = mysqli_fetch_assoc($rsltuserbli)) {
        $rsltuserlbl = $con->query("select * from hotel_ligne_bon_livraison_interne as bl left join "
                . "hotel_article_point_hotel as aph on bl.id_article_point_hotel=aph.id_article_point_hotel left "
                . "join hotel_article as a on aph.id_article=a.id_article where bl.id_bon_livraison_interne='" . $rowbli["id_bon_livraison_interne"] . "'") or die(mysqli_error($con));
        while ($rowlbl = mysqli_fetch_assoc($rsltuserlbl)) {
            $stockarp = $rowlbl["stock_lbli"];
            if ($rowlbl["id_unite"] != $rowlbl["unite_vente_article"]) {
                $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
                        . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                $npharmaciepa = mysqli_num_rows($rsltuarpa);

                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                if ($npharmaciepa != 0) {
                    $stockarap = 0;
                    if ($rowarpa["stock_convertion"] != 0) {
                        $stockarap = (($rowlbl["stock_lbli"] * $rowlbl["stock_article"]) / ($rowarpa["stock_convertion"]));
                    }
                    if ($stockarap >= 0) {
                        $stockarp = $stockarap;
                    } else {
                        $stockarp = 0;
                    }
                } else {
                    $stockarap = $rowlbl["stock_lbli"];
                    if ($stockarap >= 0) {
                        $stockarp = $stockarap;
                    } else {
                        $stockarp = 0;
                    }
                }
            }
            $prodArray = array($rowlbl["id_article_point_hotel"] => array(
                    'idart' => $rowlbl["id_article_point_hotel"],
                    'codeart' => $rowlbl["code_article"],
                    'designationart' => $rowlbl["libelle_article"],
                    'qteart' => $stockarp,
                    'uniteart' => $rowlbl["unite_vente_article"]
            ));

            if (!empty($tab)) {
                $f = FALSE;
                foreach ($tab as $k => $v) {
                    if (($tab[$k]["idart"] == $rowlbl["id_article_point_hotel"])) {
                        $f = TRUE;
                        $tab[$k]["qteart"] = $tab[$k]["qteart"] + $stockarp;
                    }
                }
                if (!$f) {
                    $tab = array_merge($tab, $prodArray);
                }
            } else {
                $tab = $prodArray;
            }
        }
    }

    while ($rowbl = mysqli_fetch_assoc($rsltuserbl)) {
        $rsltuserlbl = $con->query("select * from hotel_ligne_commande_pharmacie as l left join hotel_magasin_pharmacie as mr on "
                . "l.id_magasin_pharmacie=mr.id_magasin_pharmacie left join hotel_article_point_hotel as aph on mr.id_article_point_hotel=aph.id_article_point_hotel left "
                . "join hotel_article as a on aph.id_article=a.id_article where "
                . "l.id_commande_pharmacie='" . $rowbl["id_commande_pharmacie"] . "'") or die(mysqli_error($con));
        while ($rowlbl = mysqli_fetch_assoc($rsltuserlbl)) {
            $stockarp = $rowlbl["stock_ligne_cb"];
            if ($rowlbl["id_unite"] != $rowlbl["unite_vente_article"]) {
                $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
                        . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                $npharmaciepa = mysqli_num_rows($rsltuarpa);

                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                if ($npharmaciepa != 0) {
                    $stockarap = 0;
                    if ($rowarpa["stock_convertion"] != 0) {
                        $stockarap = (($rowlbl["stock_ligne_cb"] * $rowlbl["stock_article"]) / ($rowarpa["stock_convertion"]));
                    }
                    if ($stockarap >= 0) {
                        $stockarp = $stockarap;
                    } else {
                        $stockarp = 0;
                    }
                } else {
                    $stockarap = $rowlbl["stock_ligne_cb"];
                    if ($stockarap >= 0) {
                        $stockarp = $stockarap;
                    } else {
                        $stockarp = 0;
                    }
                }
            }
            $prodArray = array($rowlbl["id_article_point_hotel"] => array(
                    'idart' => $rowlbl["id_article_point_hotel"],
                    'codeart' => $rowlbl["code_article"],
                    'designationart' => $rowlbl["libelle_article"],
                    'qteart' => $stockarp,
                    'uniteart' => $rowlbl["unite_vente_article"]
            ));

            if (!empty($tab)) {
                $f = FALSE;
                foreach ($tab as $k => $v) {
                    if (($tab[$k]["idart"] == $rowlbl["id_article_point_hotel"])) {
                        $f = TRUE;
                        $tab[$k]["qteart"] = $tab[$k]["qteart"] - $stockarp;
                    }
                }
            }
        }
    }
    
    while ($rowlbl = mysqli_fetch_assoc($rsltuserav)) {
        $prodArray = array($rowlbl["id_article_point_hotel"] => array(
                'idart' => $rowlbl["id_article_point_hotel"],
                'codeart' => $rowlbl["code_article"],
                'designationart' => $rowlbl["libelle_article"],
                'qteart' => $rowlbl["stock_article_avarie"],
                'uniteart' => $rowlbl["unite_vente_article"]
        ));

        if (!empty($tab)) {
            $f = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["idart"] == $rowlbl["id_article_point_hotel"])) {
                    $f = TRUE;
                    $stockarp = 0;
                    $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["unite_sortie_article"] . "' "
                            . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                    $npharmaciepa = mysqli_num_rows($rsltuarpa);

                    $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                    if ($npharmaciepa != 0) {
                        $stockarap = 0;
                        if ($rowarpa["stock_convertion"] != 0) {
                            $stockarap = (($rowlbl["stock_article_avarie"] * $rowlbl["stock_article"]) / ($rowarpa["stock_convertion"]));
                        }
                        if ($stockarap >= 0) {
                            $stockarp = $stockarap;
                        } else {
                            $stockarp = 0;
                        }
                    } else {
                        $stockarap = $rowlbl["stock_article_avarie"];
                        if ($stockarap >= 0) {
                            $stockarp = $stockarap;
                        } else {
                            $stockarp = 0;
                        }
                    }
                    $tab[$k]["qteart"] = $tab[$k]["qteart"] - $stockarp;
                }
            }
        }
    }
    ?>
    <div class="row">
        <div class="col-sm-12">
            <h2>Stocks <?php echo $rowb["nom_pharmacie"] ?> du <?php echo $date ?></h2>
            <a href="hotelpages/pharmaciehotel/magasinhotel/print_etat_magasin_hotel_j_pdf.php?datecj=<?php echo $date ?>&nompharmacie=<?php echo $nompharmaciee ?>&pointhotel=<?php echo $pointhotel ?>" class="btn btn-lg btn-success" target="_blank">
                <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
            </a>
            &nbsp;&nbsp;
            <a href="hotelpages/pharmaciehotel/magasinhotel/etat_magasin_excel.php?datecj=<?php echo $date ?>&nompharmacie=<?php echo $nompharmaciee ?>&pointhotel=<?php echo $pointhotel ?>" class="btn btn-lg btn-success" target="_blank">
                <span title="Exporter la liste" alt="expoter"><i class="fa fa-file-pdf-o"></i> Exporter</span>
            </a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-client">
                    <thead>
                        <tr class="btn-success">
                            <th>N&deg;</th>
                            <th>Code</th>
                            <th>D&eacute;signation</th>
                            <th>Quantit&eacute;</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $nb = 0;
                        foreach ($tab as $prod) {
                            $nb = $nb + 1;
                            ?>
                            <tr >
                                <td><?php print $nb; ?> </td>
                                <td><?php print nl2br(htmlspecialchars($prod["codeart"])) ?></td>
                                <td><?php print nl2br(htmlspecialchars($prod["designationart"])) ?></td>
                                <td>
                                    <?php print nl2br(htmlspecialchars($prod["qteart"])) ?>&nbsp;
                                    <?php
                                    $rsltua = $con->query("select * from hotel_unite where id_unite='" . $prod["uniteart"] . "'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_assoc($rsltua);
                                    print nl2br(htmlspecialchars($rowa["code_unite"]));
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <a href="hotelpages/pharmaciehotel/magasinhotel/print_etat_magasin_hotel_j_pdf.php?datecj=<?php echo $date ?>&nompharmacie=<?php echo $nompharmaciee ?>&pointhotel=<?php echo $pointhotel ?>" class="btn btn-lg btn-success" target="_blank">
                <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
            </a>
        </div>
    </div>
    <?php
}
?>
