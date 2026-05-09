<?php
include('../../../hotelconnexion/bdhotel.php');

$reqhote = $con->query("select * from hotel_proprietaire") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if (isset($_REQUEST["datecj"])) {
    $date = $_REQUEST["datecj"];
    $nompharmaciee = $_REQUEST["nompharmacie"];
    $pointhotel = $_REQUEST["pointhotel"];
     $tab = array();
    $codeb = "BAR";
    $rsltb = $con->query("select * from hotel_pharmacie as r left join hotel_point_hotel as ph on "
                    . "r.id_point_hotel=ph.id_point_hotel where r.id_pharmacie='" . $nompharmaciee . "'") or die(mysqli_error($con));
    $rowb = mysqli_fetch_assoc($rsltb);
    
    $rsltph = $con->query('select * from hotel_point_hotel as pa left join hotel_departement as d '
            . 'on pa.id_departement=d.id_departement left join hotel_region as r on d.id_region=r.id_region '
            . 'where pa.id_point_hotel=' . $rowb["id_point_hotel"] . '') or die(mysqli_error($con));
    $rowph = mysqli_fetch_assoc($rsltph);
    
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
                <h2>Stocks <?php echo $rowb["nom_pharmacie"] ?> du <?php echo $date ?></h2>
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

