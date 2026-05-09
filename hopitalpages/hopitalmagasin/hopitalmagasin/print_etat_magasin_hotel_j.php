<?php
include('../../../hotelconnexion/bdhotel.php');

$reqhote = $con->query("select * from hotel_proprietaire") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if (isset($_REQUEST["datecj"])) {
    $date = $_REQUEST["datecj"];
    $pointhotel = $_REQUEST["pointhotel"];
     $tab = array();

    $rsltph = $con->query('select * from hotel_point_hotel as pa left join hotel_departement as d '
            . 'on pa.id_departement=d.id_departement left join hotel_region as r on d.id_region=r.id_region '
            . 'where pa.id_point_hotel=' . $pointhotel . '') or die(mysqli_error($con));
    $rowph = mysqli_fetch_assoc($rsltph);
    
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
    $mtt = 0;
    $date2 = date('d-m-Y');
    ?>
    <page backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm">
        <table style="width: 100%;border: none;">
            <tr>
                <td style="width: 40%; text-align: center; font-size: 9pt; font-weight: bold;">
                    <!--REPUBLIC OF CAMEROON <br> Peace - Work - Fatherland<br>-->
                    <?php echo strtoupper($rowhote["hotel"]); ?><br>
                    <?php echo strtoupper($rowhote["slogan_h"]); ?><br>
                    B. P. <?php echo $rowhote["code_postal_h"]; ?> 
                    T&eacute;l: <?php echo $rowhote["tel_p"]; ?><br> 
                    E-mail<?php echo $rowhote["email_p"]; ?>
                </td>
                <td style="width: 20%; text-align: center; font-size: 7pt;">
                    <img src="../../../hotelimages/logo/<?php echo $rowhote["logo_h"]; ?>" alt="logo" style="height: 22mm; border-radius: 6mm;"><br>
                </td>
                <td style="width: 40%; text-align: center; font-size: 9pt; font-weight: bold;">
                    REPUBLIQUE DU CAMEROUN<br>Paix - Travail - Patrie<br>
                </td>
            </tr>
        </table><br>
        <table align="center" >
            <tr>
                <td style="text-align: center; font-size: 22pt; font-weight: bold;">
            <u>
                <h2>Stocks Economat du <?php echo $date ?></h2>
            </u>
            </td>
            </tr>
        </table><br><br>
        <table cellspacing="0" style="width: 100%; border: solid 1px; font-size: 10pt;">
            <thead>    
                <tr style=" background: #cbcaca;">
                    <th style="width: 5%;text-align: center; border: solid 1px;">N&deg;</th>
                    <th style="width: 20%;text-align: center; border: solid 1px;">Code</th>
                    <th style="width: 55%;text-align: center; border: solid 1px;">D&eacute;signation</th>
                    <th style="width: 20%;text-align: center; border: solid 1px;">Quantit&eacute;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nb = 0;
                        foreach ($tab as $prod) {
                            $nb = $nb + 1;
                    ?>
                    <tr >
                        <td style="width: 5%;text-align: left; border: solid 1px;">
                        <?php print $nb; ?>
                        </td>
                        <td style="width: 20%;text-align: left; border: solid 1px;">
                        <?php print nl2br(htmlspecialchars($prod["codeart"])) ?>
                        </td>
                        <td style="width: 55%;text-align: left; border: solid 1px;">
                            <?php print nl2br(htmlspecialchars($prod["designationart"])) ?>
                        </td>
                        <td style="width: 20%;text-align: left; border: solid 1px;">
                            <?php print nl2br(htmlspecialchars($prod["qteart"])) ?>
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
        </table><br><br>
        <table cellspacing="0" style="width: 100%; font-size: 16pt">
            <tr>
                <td style="width: 100%; text-align: right">
                    <b>Fait à <?php echo $rowph["chef_lieu_reg"]; ?>, le</b> <?php echo $date2 ?><br> &nbsp;
                </td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: right">
                    Signature de la Direction
                </td>
            </tr>
        </table>
    </page>  
    <?php
}
?>

