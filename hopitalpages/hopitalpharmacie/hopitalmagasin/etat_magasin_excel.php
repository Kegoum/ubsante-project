<?php

// Connexion à la base de données
    include('../../../hotelconnexion/bdhotel.php');

if (isset($_REQUEST["datecj"])) {
    $date = $_REQUEST["datecj"];
    $nompharmaciee = $_REQUEST["nompharmacie"];
    $pointhotel = $_REQUEST["pointhotel"];
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
    $mtt = 0;
    $date2 = date('d-m-Y');
    
    
    if ($tab != NULL) {
        $num = 1;
        $etatmagasin = " \t  \t Stocks $rowb[nom_pharmacie] du $date \t \t \n";
        $etatmagasin .= "No \t CODE \t DESIGNATION \t QUANTITE \t \n";
        foreach ($tab as $prod) {
                                    $rsltua = $con->query("select * from hotel_unite where id_unite='" . $prod["uniteart"] . "'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_assoc($rsltua);
                                    
            $etatmagasin .= "$num \t $prod[codeart] \t $prod[designationart] \t $prod[qteart]  $rowa[code_unite] \t \n";
            $num = $num + 1;
        }

        header("Content-type: application/vnd.ms-excel; charset=UTF-16LE");
        header("Content-disposition: attachment; filename=magasinpharmacieexcel.xls");
        print $etatmagasin;
        exit;
    } else {
        
    }
}
?>