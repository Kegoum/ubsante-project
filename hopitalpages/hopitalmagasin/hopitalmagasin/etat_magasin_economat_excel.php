<?php

// Connexion à la base de données
    include('../../../hotelconnexion/bdhotel.php');

if (isset($_REQUEST["datecj"])) {
    $date = $_REQUEST["datecj"];
    $pointhotel = $_REQUEST["pointhotel"];
     $tab = array();

    
    $rsltuserbl = $con->query("select * from hotel_bon_livraison as bl where "
            . "bl.id_point_hotel='" . $pointhotel . "' and cast(bl.date_bl as DATE)<='" . $date . "'") or die(mysqli_error($con));
    $rsltuserbli = $con->query("select * from hotel_bon_livraison_interne as bli where "
            . "bli.id_point_hotel='" . $pointhotel . "' and cast(bli.date_bli as DATE)<='" . $date . "'") or die(mysqli_error($con));
    $rsltuserblh = $con->query("select * from hotel_hebergement as blh where "
            . "blh.id_point_hotel='" . $pointhotel . "' and cast(blh.date_hebergement as DATE)<='" . $date . "'") or die(mysqli_error($con));
    $rsltuserav = $con->query("select * from hotel_article_avarie as aa left join hotel_article_point_hotel as aph on "
            . "aa.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
            . "aph.id_article=a.id_article where aph.id_point_hotel='" . $pointhotel . "' "
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
    
    
    if ($tab != NULL) {
        $num = 1;
        $etatmagasin = " \t  \t Stocks Economat du $date \t \t \n";
        $etatmagasin .= "No \t CODE \t DESIGNATION \t QUANTITE \t \n";
        foreach ($tab as $prod) {
                                    $rsltua = $con->query("select * from hotel_unite where id_unite='" . $prod["uniteart"] . "'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_assoc($rsltua);
                                    
            $etatmagasin .= "$num \t $prod[codeart] \t $prod[designationart] \t $prod[qteart]  $rowa[code_unite] \t \n";
            $num = $num + 1;
        }

        header("Content-type: application/vnd.ms-excel; charset=UTF-16LE");
        header("Content-disposition: attachment; filename=magasineconomatexcel.xls");
        print $etatmagasin;
        exit;
    } else {
        
    }
}
?>