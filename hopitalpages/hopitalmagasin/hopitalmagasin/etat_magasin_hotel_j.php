<?php
if (isset($_POST["datecj"])) {
    $date = $_POST["datecj"];
    $tab = array();
    $pointhotel = $_SESSION["id_point_hotel"];
$codeb = "ECONO";
    $rsltserv = $con->query("select * from service_point_hotel as spa left join hotel_service as s on "
            . "spa.id_service=s.id_service where spa.id_point_hotel='" . $pointhotel . "' "
            . "and s.code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuserbl = $con->query("select * from hotel_bon_livraison as bl where "
            . "bl.id_point_hotel='" . $pointhotel . "' and cast(bl.date_bl as DATE)<='" . $date . "'") or die(mysqli_error($con));
    $rsltuserbli = $con->query("select * from hotel_bon_livraison_interne as bli where "
            . "bli.id_point_hotel='" . $pointhotel . "' and cast(bli.date_bli as DATE)<='" . $date . "'") or die(mysqli_error($con));
    $rsltuserblh = $con->query("select * from hotel_hebergement as blh where "
            . "blh.id_point_hotel='" . $pointhotel . "' and cast(blh.date_hebergement as DATE)<='" . $date . "'") or die(mysqli_error($con));
    $rsltuserav = $con->query("select * from hotel_article_avarie as aa left join hotel_article_point_hotel as aph on "
            . "aa.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
            . "aph.id_article=a.id_article where aa.id_service_point_hotel='" . $rowserv["id_service_point_hotel"] . "' "
            . "and aph.id_point_hotel='" . $pointhotel . "' "
            . "and cast(aa.date_article_avarie as DATE)<='" . $date . "'") or die(mysqli_error($con));

    while ($rowbl = mysqli_fetch_assoc($rsltuserbl)) {
        $rsltuserlbl = $con->query("select * from hotel_ligne_bon_livraison as bl left join hotel_article_point_hotel as aph on "
                . "bl.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
                . "aph.id_article=a.id_article where bl.id_bon_livraison='" . $rowbl["id_bon_livraison"] . "'") or die(mysqli_error($con));
        while ($rowlbl = mysqli_fetch_assoc($rsltuserlbl)) {
            $prodArray = array($rowlbl["id_article_point_hotel"] => array(
                    'idart' => $rowlbl["id_article_point_hotel"],
                    'codeart' => $rowlbl["code_article"],
                    'designationart' => $rowlbl["libelle_article"],
                    'qteart' => $rowlbl["stock_lbl"],
                    'uniteart' => $rowlbl["unite_achat_article"],
            ));

            if (!empty($tab)) {
                $f = FALSE;
                foreach ($tab as $k => $v) {
                    if (($tab[$k]["idart"] == $rowlbl["id_article_point_hotel"])) {
                        $f = TRUE;
                        $tab[$k]["qteart"] = $tab[$k]["qteart"] + $rowlbl["stock_lbl"];
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

    while ($rowbli = mysqli_fetch_assoc($rsltuserbli)) {
        $rsltuserlbl = $con->query("select * from hotel_ligne_bon_livraison_interne as bl left join hotel_article_point_hotel as aph on "
                . "bl.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
                . "aph.id_article=a.id_article where bl.id_bon_livraison_interne='" . $rowbli["id_bon_livraison_interne"] . "'") or die(mysqli_error($con));
        while ($rowlbl = mysqli_fetch_assoc($rsltuserlbl)) {
            $prodArray = array($rowlbl["id_article_point_hotel"] => array(
                    'idart' => $rowlbl["id_article_point_hotel"],
                    'codeart' => $rowlbl["code_article"],
                    'designationart' => $rowlbl["libelle_article"],
                    'qteart' => $rowlbl["stock_lbli"],
                    'uniteart' => $rowlbl["unite_achat_article"]
            ));

            if (!empty($tab)) {
                $f = FALSE;
                foreach ($tab as $k => $v) {
                    if (($tab[$k]["idart"] == $rowlbl["id_article_point_hotel"])) {
                        $f = TRUE;

                        $stockarp = 0;
                        $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
                                . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                        $nbarpa = mysqli_num_rows($rsltuarpa);

                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($nbarpa != 0) {
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
                        $tab[$k]["qteart"] = $tab[$k]["qteart"] - $stockarp;
                    }
                }
            }
        }
    }

    while ($rowbli = mysqli_fetch_assoc($rsltuserblh)) {
        $rsltuserlbl = $con->query("select * from hotel_ligne_hebergement as blh left join hotel_linge as l on "
                . "blh.id_linge=l.id_linge left join hotel_article_point_hotel as aph on "
                . "l.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
                . "aph.id_article=a.id_article where blh.id_hebergement='" . $rowbli["id_hebergement"] . "'") or die(mysqli_error($con));
        while ($rowlbl = mysqli_fetch_assoc($rsltuserlbl)) {
            $prodArray = array($rowlbl["id_article_point_hotel"] => array(
                    'idart' => $rowlbl["id_article_point_hotel"],
                    'codeart' => $rowlbl["code_article"],
                    'designationart' => $rowlbl["libelle_article"],
                    'qteart' => $rowlbl["stock_lh"],
                    'uniteart' => $rowlbl["unite_achat_article"]
            ));
            
            if (!empty($tab)) {
                $f = FALSE;
                foreach ($tab as $k => $v) {
                    if (($tab[$k]["idart"] == $rowlbl["id_article_point_hotel"])) {
                        $f = TRUE;
                        $stockarp = 0;
                        $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
                                . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                        $nbarpa = mysqli_num_rows($rsltuarpa);

                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($nbarpa != 0) {
                            $stockarap = 0;
                            if ($rowarpa["stock_convertion"] != 0) {
                                $stockarap = (($rowlbl["stock_lh"] * $rowlbl["stock_article"]) / ($rowarpa["stock_convertion"]));
                            }
                            if ($stockarap >= 0) {
                                $stockarp = $stockarap;
                            } else {
                                $stockarp = 0;
                            }
                        } else {
                            $stockarap = $rowlbl["stock_lh"];
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
    }

    while ($rowlbl = mysqli_fetch_assoc($rsltuserav)) {
        $prodArray = array($rowlbl["id_article_point_hotel"] => array(
                'idart' => $rowlbl["id_article_point_hotel"],
                'codeart' => $rowlbl["code_article"],
                'designationart' => $rowlbl["libelle_article"],
                'qteart' => $rowlbl["stock_article_avarie"],
                'uniteart' => $rowlbl["unite_achat_article"]
        ));

        if (!empty($tab)) {
            $f = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["idart"] == $rowlbl["id_article_point_hotel"])) {
                    $f = TRUE;
                    $stockarp = 0;
                    $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["unite_sortie_article"] . "' "
                            . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                    $nbarpa = mysqli_num_rows($rsltuarpa);

                    $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                    if ($nbarpa != 0) {
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
            <h2>Stocks Economat du <?php echo $date ?></h2>
            <a href="hotelpages/economathotel/magasinhotel/print_etat_magasin_hotel_j_pdf.php?datecj=<?php echo $date ?>&pointhotel=<?php echo $pointhotel ?>" class="btn btn-lg btn-success" target="_blank">
                <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
            </a>
            &nbsp;&nbsp;
            <a href="hotelpages/economathotel/magasinhotel/etat_magasin_economat_excel.php?datecj=<?php echo $date ?>&pointhotel=<?php echo $pointhotel ?>" class="btn btn-lg btn-success" target="_blank">
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
            <a href="hotelpages/economathotel/magasinhotel/print_etat_magasin_hotel_j_pdf.php?datecj=<?php echo $date ?>&pointhotel=<?php echo $pointhotel ?>" class="btn btn-lg btn-success" target="_blank">
                <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
            </a>
        </div>
    </div>
    <?php
}
?>
