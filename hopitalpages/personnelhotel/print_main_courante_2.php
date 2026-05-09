<style>
    div.recu
    {
        width:       12mm;
        height:      3mm;
        overflow: hidden;
        border:2px solid #999;
        margin:0px;
        background-color:#999;
    }
</style>
<?php
include('../../hotelconnexion/bdhotel.php');

$reqhote = $con->query("select * from hotel_proprietaire") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

function dates_range($debut, $fin) {

    if ($debut < $fin) {
        $tDeb = explode("-", $debut);
        $tFin = explode("-", $fin);

        $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) -
                mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);

        return(($diff / 86400) + 1);
    } else {
        return 0;
    }
}

$date = date('Y-m-d');
$date2 = date('d-m-Y');

$reqcl = $con->query("select * from hotel_paye_logement as pl left join hotel_client as c on pl.id_client=c.id_client "
        . "where pl.regle_pl=false and pl.reserve_pl=false") or die(mysqli_error($con));
?>

<page backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm">
    <table style="width: 100%;border: none;">
        <tr>
            <td style="width: 10%; text-align: center; font-size: 10pt;">
                <img src="../../hotelimages/logo/<?php echo $rowhote["logo_h"]; ?>" alt="logo" style="height: 22mm; border-radius: 6mm;"><br>
                <br>
                <?php echo $rowhote["slogan_h"]; ?>
            </td>
            <td style="width: 30%; text-align: left; font-size: 16pt; font-weight: bold;">
        <big style="font-size:31pt; color: blue"><b> <?php echo $rowhote["code_h"]; ?></b></big><br>
        E-mail : <?php echo $rowhote["email_p"]; ?><br>
        B.P. <?php echo $rowhote["code_postal_h"]; ?> Yaound&eacute; - 
        T&eacute;l.: <?php echo $rowhote["tel_p"]; ?>
        </td>
        <td style="width: 60%; text-align: left; font-size: 16pt; font-weight: bold;">
        <big style="font-size:35pt; color: blue"><b> MAIN COURANTE RECEPTION</b></big><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        N&deg; ...............................................
        </td>
        </tr>
    </table><br>
    <table cellspacing="0" style="padding: 1px; width: 100%; border: 1px #000000; font-size: 9pt; ">
        <thead>
            <tr>
                <th colspan="5" style="border: solid 1px #000000; text-align: center;">HEBERGEMENT</th>
                <th colspan="5" style="border: solid 1px #000000; text-align: center;">RESTAURATION</th>
                <th colspan="3" style="border: solid 1px #000000; text-align: center;">VENTES DIVERSES</th>
                <th colspan="1" rowspan="2" style="width: 3%; border: solid 1px #000000; text-align: center;">TOTAL DU JOUR</th>
                <th colspan="8" style="border: none; text-align: right;">JOURNEE DU <?php echo $date2 ?></th>
            </tr>
            <tr>
                <th style="width: 2%; border: solid 1px #000000;">N&deg; Fact</th>
                <th style="width: 4%; border: solid 1px #000000;">N&deg; Ch</th>
                <th style="width: 2%; border: solid 1px #000000;">Nbr</th>
                <th style="width: 10%; border: solid 1px #000000;">Noms et Pr&eacute;noms</th>
                <th style="width: 4%; border: solid 1px #000000;">Chambre</th>
                <th style="width: 3%; border: solid 1px #000000;">P D&eacute;jeu</th>
                <th style="width: 4%; border: solid 1px #000000;">D&eacute;jeuner</th>
                <th style="width: 4%; border: solid 1px #000000;">Diner</th>
                <th style="width: 4%; border: solid 1px #000000;">Bar</th>
                <th style="width: 4%; border: solid 1px #000000;">Cave</th>
                <th style="width: 4%; border: solid 1px #000000;">T&eacute;l</th>
                <th style="width: 4%; border: solid 1px #000000;">Blanch.</th>
                <th style="width: 4%; border: solid 1px #000000;">Divers</th>
                <!--<th style="width: 3%; border: solid 1px #000000;"></th>-->
                <th style="width: 5%; border: solid 1px #000000;">Repport veille</th>
                <th style="width: 5%; border: solid 1px #000000;">Total G&eacute;n&eacute;r.</th>
                <th style="width: 5%; border: solid 1px #000000;">D&eacute;duct.</th>
                <th style="width: 5%; border: solid 1px #000000;">Esp&egrave;ces</th>
                <th style="width: 5%; border: solid 1px #000000;">D&eacute;biteurs</th>
                <th style="width: 4%; border: solid 1px #000000;">Arrhes</th>
                <th style="width: 6%; border: solid 1px #000000;">A Reporter</th>
                <th style="width: 8%; border: solid 1px #000000;">Observations</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tnbr = 0;
            $tcha = 0;
            $tpde = 0;
            $tde = 0;
            $tdi = 0;
            $tba = 0;
            $tca = 0;
            $ttel = 0;
            $tbla = 0;
            $tdiv = 0;
            $ttj = 0;
            $trv = 0;
            $ttgen = 0;
            $tded = 0;
            $tesp = 0;
            $tdeb = 0;
            $tarr = 0;
            $tarep = 0;
            $numfact = 1;
            while ($rowcl = mysqli_fetch_assoc($reqcl)) {
                $reserv = FALSE;
                if ($rowcl["id_chambre"] != NULL) {
                    $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowcl["id_chambre"] . "' ") or die(mysqli_error($con));
                    $rowch = mysqli_fetch_assoc($reqch);
                    if ($rowch["reserve_c"]) {
                        $reserv = TRUE;
                    }
                } else if ($rowcl["id_studio"] != NULL) {
                    $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowcl["id_studio"] . "' ") or die(mysqli_error($con));
                    $rowst = mysqli_fetch_assoc($reqst);
                    if ($rowst["reserve_s"]) {
                        $reserv = TRUE;
                    }
                } else if ($rowcl["id_appartement"] != NULL) {
                    $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowcl["id_appartement"] . "' ") or die(mysqli_error($con));
                    $rowap = mysqli_fetch_assoc($reqap);
                    if ($rowap["reserve_a"]) {
                        $reserv = TRUE;
                    }
                } else if ($rowcl["id_salle"] != NULL) {
                    $reqsa = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowcl["id_salle"] . "' ") or die(mysqli_error($con));
                    $rowsa = mysqli_fetch_assoc($reqsa);
                    if ($rowsa["reserve_salle"]) {
                        $reserv = TRUE;
                    }
                }
                if (!$reserv){
                $totalj = 0;
                $repveil = 0;
                $rsltreco = $con->query("select SUM(r.montant) as mont from hotel_recu as r where r.id_paye_logement='" . $rowcl["id_paye_logement"] . "' "
                        . " and DATE(date_recu)='" . $date . "'") or die(mysqli_error($con));
                $rowreco = mysqli_fetch_assoc($rsltreco);

//                $rsltreca = $con->query("select SUM(r.montant) as mont from hotel_recu as r where r.id_paye_logement='" . $rowcl["id_paye_logement"] . "' "
//                        . " and DATE(date_recu)<'" . $date . "'") or die(mysqli_error($con));
//                $rowreca = mysqli_fetch_assoc($rsltreca);

                $rsltfm = $con->query("select * from hotel_facture_m where id_paye_logement='" . $rowcl["id_paye_logement"] . "' "
                        . "and DATE(date_facture_m)='" . $date . "' ") or die(mysqli_error($con));
                $rsltfmb = $con->query("select * from hotel_commande_bar where id_paye_logement='" . $rowcl["id_paye_logement"] . "' "
                        . "and DATE(date_commande_bar)='" . $date . "' ") or die(mysqli_error($con));
                $pde = 0;
                $de = 0;
                $di = 0;
                $ba = 0;
                $bac = 0;
                $ca = 0;
                while ($rowfm = mysqli_fetch_assoc($rsltfm)) {
                    $rsltl = $con->query("select * from hotel_ligne_m as l left join hotel_menu as m on l.id_menu=m.id_menu "
                            . "where l.id_facture_m='" . $rowfm["id_facture_m"] . "' ") or die(mysqli_error($con));

                    while ($rowl = mysqli_fetch_assoc($rsltl)) {

                        if ($rowl["type_mr"] == "Petit déjeuner") {
                            $pde = $pde + ($rowl["qte_fmr"] * $rowl["prix_fmr"]);
                        } else if ($rowl["type_mr"] == "Déjeuner") {
                            $de = $de + ($rowl["qte_fmr"] * $rowl["prix_fmr"]);
                        } else if ($rowl["type_mr"] == "Dîner") {
                            $di = $di + ($rowl["qte_fmr"] * $rowl["prix_fmr"]);
                        } else if ($rowl["type_mr"] == "Bar") {
                            $ba = $ba + ($rowl["qte_fmr"] * $rowl["prix_fmr"]);
                        } else if ($rowl["type_mr"] == "Cave") {
                            $ca = $ca + ($rowl["qte_fmr"] * $rowl["prix_fmr"]);
                        }
                    }
                }

                while ($rowfmb = mysqli_fetch_assoc($rsltfmb)) {
                    $rsltl = $con->query("select * from hotel_ligne_commande_bar as l left join hotel_magasin_bar as m "
                            . "on l.id_magasin_bar=m.id_magasin_bar "
                            . "where l.id_commande_bar='" . $rowfmb["id_commande_bar"] . "' ") or die(mysqli_error($con));

                    while ($rowl = mysqli_fetch_assoc($rsltl)) {
                            $bac = $bac + ($rowl["stock_ligne_cb"] * $rowl["prix_ligne_cb"]);
                    }
                }
                $rsltfd = $con->query("select * from hotel_facture_d where id_paye_logement='" . $rowcl["id_paye_logement"] . "' "
                        . "and DATE(date_facture_d)='" . $date . "' ") or die(mysqli_error($con));
                $tel = 0;
                $blan = 0;
                $dive = 0;
                while ($rowfd = mysqli_fetch_assoc($rsltfd)) {
                    $rsltld = $con->query("select * from hotel_ligne_d as l left join hotel_divers as m on l.id_divers=m.id_divers "
                            . "where l.id_facture_d='" . $rowfd["id_facture_d"] . "' ") or die(mysqli_error($con));
                    while ($rowld = mysqli_fetch_assoc($rsltld)) {
                        if ($rowld["type_d"] == "Téléphone") {
//                            print_r($tel." ff");
                            $tel = $tel + ($rowld["qte_fd"] * $rowld["prix_fd"]);
                        } else if ($rowld["type_d"] == "Blanchissement") {
//                            echo "<script language='javascript'>alert('blan')</script>";
                            $blan = $blan + ($rowld["qte_fd"] * $rowld["prix_fd"]);
                        } else if ($rowld["type_d"] == "Divers") {
//                            echo "<script language='javascript'>alert('div')</script>";
                            $dive = $dive + ($rowld["qte_fd"] * $rowld["prix_fd"]);
                        }
                    }
                }
//                print_r($tel." ff");
                $rsltv = $con->query("select * from hotel_registre_client where id_paye_logement='" . $rowcl["id_paye_logement"] . "' "
                        . "and DATE(date_registre)='" . $date . "' ") or die(mysqli_error($con));
                $ver = 0;
                $dep = 0;
                while ($rowv = mysqli_fetch_assoc($rsltv)) {

                    if ($rowv["operation_reg"] == "Versement") {
                        $ver = $ver + ($rowv["montant_reg"]);
                    } else if (($rowv["operation_reg"] != "Logement") && ($rowv["operation_reg"] != "Réserver")) {
                        $dep = $dep + ($rowv["montant_reg"]);
                    }
                }

                $rsltva = $con->query("select * from hotel_registre_client where id_paye_logement='" . $rowcl["id_paye_logement"] . "' "
                        . "and DATE(date_registre)<'" . $date . "' ") or die(mysqli_error($con));
                $vera = 0;
                $depa = 0;
                while ($rowva = mysqli_fetch_assoc($rsltva)) {

                    if ($rowva["operation_reg"] == "Versement") {
                        $vera = $vera + ($rowva["montant_reg"]);
                    } else if (($rowva["operation_reg"] != "Logement") && ($rowva["operation_reg"] != "Réserver")) {
                        $depa = $depa + $rowva["montant_reg"];
                    }
                }

//                $logo = $rowreco["mont"];
                $logo = $rowcl["prix_u"];
                $dif1 = dates_range(date('Y-m-d', strtotime($rowcl["date_debut_pl"])), date('Y-m-d', strtotime($rowcl["date_fin_pl"])));
                $dif = $dif1 - 1;

                $dif2 = dates_range(date('Y-m-d'), date('Y-m-d', strtotime($rowcl["date_fin_pl"])));
                $dif3 = $dif2 - 1;
                $nbj = $dif - $dif3;


                $dif21 = dates_range(date('Y-m-d', strtotime($rowcl["date_debut_pl"])), date('Y-m-d'));
                $dif31 = $dif21 - 1;
                ?>

                <tr>
                    <td style="width: 2%; border: solid 1px #000000;"><?php echo $numfact; ?></td>
                    <?php
                    if ($rowcl["id_chambre"] != NULL) {
                        $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                                . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowcl["id_chambre"] . "' ") or die(mysqli_error($con));
                        $rowch = mysqli_fetch_assoc($reqch);
                        ?>
                        <td style="width: 4%; border: solid 1px #000000;">
                            <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                        </td>
                        <?php
                    } else if ($rowcl["id_studio"] != NULL) {
                        $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                                . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowcl["id_studio"] . "' ") or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        <td style="width: 4%; border: solid 1px #000000;">
                            <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                        </td>
                        <?php
                    } else if ($rowcl["id_appartement"] != NULL) {
                        $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                                . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowcl["id_appartement"] . "' ") or die(mysqli_error($con));
                        $rowap = mysqli_fetch_assoc($reqap);
                        ?>
                        <td style="width: 4%; border: solid 1px #000000;">
                            <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                            <?php print $rowap["nbchambre_a"] ?>Ch  
                            <?php echo $rowap["nbsalon_a"] ?>S  
                            <?php echo $rowap["nbdouche_a"] ?>D  
                            <?php echo $rowap["nbcuisine_a"] ?>Cu 
                        </td>
                        <?php
                    } else if ($rowcl["id_salle"] != NULL) {
                        $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowcl["id_salle"] . "' ") or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        <td style="width: 4%; border: solid 1px #000000;">
                            <?php print nl2br(htmlspecialchars($rowst["code_salle"])) ?>
                        </td>
                        <?php
                    }
                    ?>
                    <td style="width: 2%; border: solid 1px #000000;">
                        <?php echo $rowcl["nbpers"] ?>
                    </td>
                    <td style="width: 10%; border: solid 1px #000000;">
                        <?php echo $rowcl["nom_client"] ?> 
                        <?php echo $rowcl["prenom_client"] ?>
                    </td>
                    <td style="width: 4%; border: solid 1px #000000;">
                        <?php echo number_format($logo, 0, ',', ' ') ?>
                    </td>
                    <?php
                    $totalj = $dep + $rowcl["prix_u"];
                    $depa = $depa + ($dif31 * $rowcl["prix_u"]);
                    if ($depa > $vera) {
                        $repveil = ($depa - $vera);
                    }
                    $esp = $ver;
                    $arr = $vera - $depa;
                    ?>
                    <td style="width: 3%; border: solid 1px #000000;"><?php echo number_format($pde, 0, ',', ' ') ?></td>
                    <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($de, 0, ',', ' ') ?></td>
                    <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($di, 0, ',', ' ') ?></td>
                    <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($bac, 0, ',', ' ') ?></td>
                    <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($ca, 0, ',', ' ') ?></td>
                    <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($tel, 0, ',', ' ') ?></td>
                    <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($blan, 0, ',', ' ') ?></td>
                    <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($dive, 0, ',', ' ') ?></td>
                    <td style="width: 3%; border: solid 1px #000000;"><?php echo number_format($totalj, 0, ',', ' ') ?></td>
                    <td style="width: 5%; border: solid 1px #000000;"><?php echo number_format($repveil, 0, ',', ' ') ?></td>
                    <td style="width: 5%; border: solid 1px #000000;"><?php echo number_format(($totalj + $repveil), 0, ',', ' ') ?></td>
                    <td style="width: 5%; border: solid 1px #000000;"></td>
                    <td style="width: 5%; border: solid 1px #000000;"><?php echo number_format(($esp), 0, ',', ' ') ?></td>
                    <td style="width: 5%; border: solid 1px #000000;"></td>
                    <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format(($arr), 0, ',', ' ') ?></td>
                    <td style="width: 6%; border: solid 1px #000000;"></td>
                    <td style="width: 8%; border: solid 1px #000000;"></td>
                </tr>
                <?php
                $tnbr = $tnbr + $rowcl["nbpers"];
                $tcha = $tcha + $logo;
                $tpde = $tpde + $pde;
                $tde = $tde + $de;
                $tdi = $tdi + $di;
//                $tba = $tba + $ba;
                $tba = $tba + $bac;
                $tca = $tca + $ca;
                $ttel = 0;
                $tbla = 0;
                $tdiv = 0;
                $ttj = $ttj + $totalj;
                $trv = $trv + $repveil;
                $ttgen = $ttgen + ($totalj + $repveil);
                $tded = 0;
                $tesp = $tesp + ($esp);
                $tdeb = 0;
                $tarr = $tarr + ($arr);
                $tarep = 0;
                $numfact = $numfact + 1;
                }
            }
            ?>


            <?php
            ?>
        </tbody>
        <tfoot>
            <tr>
            <tr>
                <td style="width: 2%; border: solid 1px #000000;"></td>

                <td style="width: 4%; border: solid 1px #000000;">
                </td>
                <td style="width: 2%; border: solid 1px #000000;">
                    <?php echo number_format($tnbr, 0, ',', ' ') ?>
                </td>
                <td style="width: 10%; border: solid 1px #000000;">
                    TOTAL JOURNALIER
                </td>
                <td style="width: 4%; border: solid 1px #000000;">
                    <?php echo number_format($tcha, 0, ',', ' ') ?>
                </td>
                <td style="width: 3%; border: solid 1px #000000;"><?php echo number_format($tpde, 0, ',', ' ') ?></td>
                <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($tde, 0, ',', ' ') ?></td>
                <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($tdi, 0, ',', ' ') ?></td>
                <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($tba, 0, ',', ' ') ?></td>
                <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format($tca, 0, ',', ' ') ?></td>
                <td style="width: 4%; border: solid 1px #000000;"></td>
                <td style="width: 4%; border: solid 1px #000000;"></td>
                <td style="width: 4%; border: solid 1px #000000;"></td>
                <td style="width: 3%; border: solid 1px #000000;"><?php echo number_format($ttj, 0, ',', ' ') ?></td>
                <td style="width: 5%; border: solid 1px #000000;"><?php echo number_format($trv, 0, ',', ' ') ?></td>
                <td style="width: 5%; border: solid 1px #000000;"><?php echo number_format(($ttgen), 0, ',', ' ') ?></td>
                <td style="width: 5%; border: solid 1px #000000;"></td>
                <td style="width: 5%; border: solid 1px #000000;"><?php echo number_format(($tesp), 0, ',', ' ') ?></td>
                <td style="width: 5%; border: solid 1px #000000;"></td>
                <td style="width: 4%; border: solid 1px #000000;"><?php echo number_format(($tarr), 0, ',', ' ') ?></td>
                <td style="width: 6%; border: solid 1px #000000;"></td>
                <td style="width: 8%; border: solid 1px #000000;"> </td>
            </tr>
            </tr>
        </tfoot>
    </table>
</page>
<?php
?>

