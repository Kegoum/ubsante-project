<?php

// Connexion à la base de données
    include('../../../hotelconnexion/bdhotel.php');

if ((isset($_REQUEST["datedcp"])) && (isset($_REQUEST["datefcp"])) && (isset($_REQUEST["produit"]))) {
    $dated = $_REQUEST["datedcp"];
    $datef = $_REQUEST["datefcp"];
    $produ = $_REQUEST["produit"];
    $rslt = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article as a on "
            . "aph.id_article=a.id_article where aph.id_article_point_hotel='" . $produ . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $tab = array();

    $pointhotel = $_REQUEST["pointhotel"];

    $rsltuserbl = $con->query("select *, cast(bl.date_bl as DATE) as dateliv from hotel_ligne_bon_livraison as lbl left join "
            . "hotel_article_point_hotel as aph on lbl.id_article_point_hotel=aph.id_article_point_hotel left join "
            . "hotel_article as a on aph.id_article=a.id_article left join hotel_bon_livraison as bl on "
            . "lbl.id_bon_livraison=bl.id_bon_livraison where lbl.id_article_point_hotel='" . $produ . "' and "
            . "bl.id_point_hotel='" . $pointhotel . "' and (cast(bl.date_bl as DATE) BETWEEN '" . $dated . "' and "
            . "'" . $datef . "')") or die(mysqli_error($con));

    $rsltuserbli = $con->query("select *, cast(bli.date_bli as DATE) as dateliv from hotel_ligne_bon_livraison_interne "
            . "as bl left join hotel_article_point_hotel as aph on bl.id_article_point_hotel=aph.id_article_point_hotel "
            . "left join hotel_article as a on aph.id_article=a.id_article left join hotel_bon_livraison_interne as bli on "
            . "bl.id_bon_livraison_interne=bli.id_bon_livraison_interne where bl.id_article_point_hotel='" . $produ . "' and "
            . "bli.id_point_hotel='" . $pointhotel . "' and cast(bli.date_bli as DATE) BETWEEN '" . $dated . "' and "
            . "'" . $datef . "'") or die(mysqli_error($con));
    $rsltusercb = $con->query("select *, cast(cb.date_commande_bar as DATE) as dateliv from hotel_ligne_commande_bar as lcb left join hotel_magasin_bar as mr on "
            . "lcb.id_magasin_bar=mr.id_magasin_bar left join hotel_article_point_hotel as aph on "
            . "mr.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
            . "aph.id_article=a.id_article left join hotel_commande_bar as cb on lcb.id_commande_bar=cb.id_commande_bar "
            . "left join hotel_bar as b on cb.id_bar=b.id_bar where mr.id_article_point_hotel='" . $produ . "' and "
            . "b.id_point_hotel='" . $pointhotel . "' and cast(cb.date_commande_bar as DATE) BETWEEN '" . $dated . "' and "
            . "'" . $datef . "'") or die(mysqli_error($con));
    $rsltusercr = $con->query("select *, cast(cr.date_commande_r as DATE) as dateliv from hotel_menu_restaurant as mer "
            . "left join hotel_magasin_restaurant as mar on mer.id_magasin_restaurant=mar.id_magasin_restaurant left join "
            . "hotel_article_point_hotel as aph on mar.id_article_point_hotel=aph.id_article_point_hotel left join "
            . "hotel_article as a on aph.id_article=a.id_article left join hotel_commande_menu as cm on "
            . "mer.id_commande_menu=cm.id_commande_menu left join hotel_commande_restaurant as cr on "
            . "cm.id_commande_restaurant=cr.id_commande_restaurant left join hotel_restaurant as r on "
            . "cr.id_restaurant=r.id_restaurant where mar.id_article_point_hotel='" . $produ . "' and "
            . "r.id_point_hotel='" . $pointhotel . "' and cast(cr.date_commande_r as DATE) BETWEEN '" . $dated . "' and "
            . "'" . $datef . "'") or die(mysqli_error($con));
    $rsltuserblh = $con->query("select *, cast(bh.date_hebergement as DATE) as dateliv from hotel_ligne_hebergement "
            . "as blh left join hotel_linge as l on blh.id_linge=l.id_linge left join hotel_article_point_hotel as aph "
            . "on l.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
            . "aph.id_article=a.id_article left join hotel_hebergement as bh on blh.id_hebergement=bh.id_hebergement "
            . "where l.id_article_point_hotel='" . $produ . "' and bh.id_point_hotel='" . $pointhotel . "' and "
            . "cast(bh.date_hebergement as DATE) BETWEEN '" . $dated . "' and '" . $datef . "'") or die(mysqli_error($con));
    $rsltusertls = $con->query("select *, cast(tls.date_tls as DATE) as dateliv from hotel_transfert_linge_sale "
            . "as tls left join hotel_magasin_linge as ml on tls.id_magasin_linge=ml.id_magasin_linge left join "
            . "hotel_linge as l on ml.id_linge=l.id_linge left join hotel_article_point_hotel as aph "
            . "on l.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
            . "aph.id_article=a.id_article where l.id_article_point_hotel='" . $produ . "' and "
            . "ml.id_point_hotel='" . $pointhotel . "' and cast(tls.date_tls as DATE) BETWEEN '" . $dated . "' and "
            . "'" . $datef . "'") or die(mysqli_error($con));
    $rsltuserbn = $con->query("select *, cast(bn.date_bn as DATE) as dateliv from hotel_ligne_bon_nettoyage as lbn left join hotel_magasin_linge_sale as "
            . "mls on lbn.id_linge_sale=mls.id_linge_sale left join hotel_magasin_linge as ml on "
            . "mls.id_magasin_linge=ml.id_magasin_linge left join hotel_linge as l on ml.id_linge=l.id_linge left join "
            . "hotel_article_point_hotel as aph on l.id_article_point_hotel=aph.id_article_point_hotel left join "
            . "hotel_article as a on aph.id_article=a.id_article left join hotel_bon_nettoyage as bn on "
            . "lbn.id_bon_nettoyage=bn.id_bon_nettoyage where l.id_article_point_hotel='" . $produ . "' and "
            . "bn.id_point_hotel='" . $pointhotel . "' and cast(bn.date_bn as DATE) BETWEEN '" . $dated . "' and "
            . "'" . $datef . "'") or die(mysqli_error($con));

    $rsltuserav = $con->query("select *, cast(aa.date_article_avarie as DATE) as dateliv from hotel_article_avarie as "
            . "aa left join hotel_article_point_hotel as aph on aa.id_article_point_hotel=aph.id_article_point_hotel "
            . "left join hotel_article as a on aph.id_article=a.id_article where aph.id_point_hotel='" . $pointhotel . "' "
            . "and aa.id_article_point_hotel='" . $produ . "' and cast(aa.date_article_avarie as DATE) BETWEEN "
            . "'" . $dated . "' and '" . $datef . "'") or die(mysqli_error($con));
    $i = 0;
    while ($rowlbl = mysqli_fetch_assoc($rsltuserbl)) {
        $livr = "Fournisseur";
        if ($rowlbl["id_fournisseur"] == NULL) {
            $livr = "Blanchisseur";
        }
        $stockarp = $rowlbl["stock_lbl"];
        if ($rowlbl["id_unite"] != $rowlbl["unite_achat_article"]) {
            $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
                    . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
            $nbarpa = mysqli_num_rows($rsltuarpa);

            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
            if ($nbarpa != 0) {
                $stockarap = 0;
                if ($rowarpa["stock_convertion"] != 0) {
                    $stockarap = (($rowlbl["stock_lbl"] * $rowlbl["stock_article"]) / ($rowarpa["stock_convertion"]));
                }
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }
            } else {
                $stockarap = $rowlbl["stock_lbl"];
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }
            }
        }
        $prodArray = array($rowlbl["dateliv"] => array(
                'datem' => $rowlbl["dateliv"],
                'mouvement' => array()
        ));
        $rsltcr = $con->query("select * from hotel_compte_personnel as cp inner join hotel_personnel as pe on "
                . "cp.id_personnel=pe.id_personnel where cp.id_compte_personnel='" . $rowlbl["id_compte_personnel_validel"] . "' ") or die(mysqli_error($con));
        $reccr = mysqli_fetch_assoc($rsltcr);

//        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["personnem"] = "Economat - ".$reccr["nom_pe"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["servicem"] = "Economat";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["operationm"] = "Reception Livraison " . $livr;
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["quantite"] = $stockarp;
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["unite"] = $rowlbl["unite_achat_article"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["dateliv"])) {
                    $f = TRUE;
                    foreach ($tab[$k]["mouvement"] as $km => $vm) {
                        if (($tab[$k]["mouvement"][$km]["operationm"] == ("Reception Livraison " . $livr)) && ($tab[$k]["mouvement"][$km]["servicem"] == "Economat")) {
                            $fm = TRUE;
                            $tab[$k]["mouvement"][$km]["quantite"] = $tab[$k]["mouvement"][$km]["quantite"] + $stockarp;
                        }
                    }
                    if (!$fm) {
                        $tab[$k]["mouvement"][$i]["servicem"] = "Economat";
                        $tab[$k]["mouvement"][$i]["operationm"] = "Reception Livraison " . $livr;
                        $tab[$k]["mouvement"][$i]["quantite"] = $stockarp;
                        $tab[$k]["mouvement"][$i]["unite"] = $rowlbl["unite_achat_article"];
                        $i = $i + 1;
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }

    while ($rowlbl = mysqli_fetch_assoc($rsltuserbli)) {
        $stockarp = $rowlbl["stock_lbli"];
        if ($rowlbl["id_unite"] != $rowlbl["unite_vente_article"]) {
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
        }
        $prodArray = array($rowlbl["dateliv"] => array(
                'datem' => $rowlbl["dateliv"],
                'mouvement' => array()
        ));
        $rsltcr = $con->query("select * from hotel_compte_personnel as cp inner join hotel_personnel as pe on "
                . "cp.id_personnel=pe.id_personnel where cp.id_compte_personnel='" . $rowlbl["id_compte_personnel_valide"] . "' ") or die(mysqli_error($con));
        $reccr = mysqli_fetch_assoc($rsltcr);
        $rsltspa = $con->query("select * from service_point_hotel as spa left join hotel_service as s on spa.id_service=s.id_service "
                . "where spa.id_service_point_hotel='" . $rowlbl["id_service_point_hotel"] . "' ") or die(mysqli_error($con));
        $rowspa = mysqli_fetch_assoc($rsltspa);

//        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["personnem"] = "Economat - ".$reccr["nom_pe"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["servicem"] = $rowspa["nom_service"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["operationm"] = "Reception Livraison";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["quantite"] = $stockarp;
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["dateliv"])) {
                    $f = TRUE;
                    foreach ($tab[$k]["mouvement"] as $km => $vm) {
                        if (($tab[$k]["mouvement"][$km]["operationm"] == "Reception Livraison") && ($tab[$k]["mouvement"][$km]["servicem"] == $rowspa["nom_service"])) {
                            $fm = TRUE;
                            $tab[$k]["mouvement"][$km]["quantite"] = $tab[$k]["mouvement"][$km]["quantite"] + $stockarp;
                        }
                    }
                    if (!$fm) {
                        $tab[$k]["mouvement"][$i]["servicem"] = $rowspa["nom_service"];
                        $tab[$k]["mouvement"][$i]["operationm"] = "Reception Livraison";
                        $tab[$k]["mouvement"][$i]["quantite"] = $stockarp;
                        $tab[$k]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];
                        $i = $i + 1;
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }

    while ($rowlbl = mysqli_fetch_assoc($rsltusercb)) {
        $stockarp = $rowlbl["stock_ligne_cb"];
        if ($rowlbl["id_unite"] != $rowlbl["unite_vente_article"]) {
            $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
                    . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
            $nbarpa = mysqli_num_rows($rsltuarpa);

            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
            if ($nbarpa != 0) {
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
        $prodArray = array($rowlbl["dateliv"] => array(
                'datem' => $rowlbl["dateliv"],
                'mouvement' => array()
        ));
        $rsltcr = $con->query("select * from hotel_compte_personnel as cp inner join hotel_personnel as pe on "
                . "cp.id_personnel=pe.id_personnel where cp.id_compte_personnel='" . $rowlbl["id_compte_personnel"] . "' ") or die(mysqli_error($con));
        $reccr = mysqli_fetch_assoc($rsltcr);

//        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["personnem"] = "Economat - ".$reccr["nom_pe"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["servicem"] = "Bar";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["operationm"] = "Vente";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["quantite"] = $stockarp;
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["dateliv"])) {
                    $f = TRUE;
                    foreach ($tab[$k]["mouvement"] as $km => $vm) {
                        if (($tab[$k]["mouvement"][$km]["operationm"] == "Vente") && ($tab[$k]["mouvement"][$km]["servicem"] == "Bar")) {
                            $fm = TRUE;
                            $tab[$k]["mouvement"][$km]["quantite"] = $tab[$k]["mouvement"][$km]["quantite"] + $stockarp;
                        }
                    }
                    if (!$fm) {
                        $tab[$k]["mouvement"][$i]["servicem"] = "Bar";
                        $tab[$k]["mouvement"][$i]["operationm"] = "Vente";
                        $tab[$k]["mouvement"][$i]["quantite"] = $stockarp;
                        $tab[$k]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];
                        $i = $i + 1;
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }

    while ($rowlbl = mysqli_fetch_assoc($rsltusercr)) {
        
        $stockarp = ($rowlbl["quantite_m"]*$rowlbl["stock_mr"]);
        if ($rowlbl["id_unite"] != $rowlbl["unite_vente_article"]) {
            $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
                    . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
            $nbarpa = mysqli_num_rows($rsltuarpa);

            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
            if ($nbarpa != 0) {
                $stockarap = 0;
                if ($rowarpa["stock_convertion"] != 0) {
                    $stockarap = ((($rowlbl["quantite_m"]*$rowlbl["stock_mr"]) * $rowlbl["stock_article"]) / ($rowarpa["stock_convertion"]));
                }
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }
            } else {
                $stockarap = ($rowlbl["quantite_m"]*$rowlbl["stock_mr"]);
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }
            }
        }
        $prodArray = array($rowlbl["dateliv"] => array(
                'datem' => $rowlbl["dateliv"],
                'mouvement' => array()
        ));
        $rsltcr = $con->query("select * from hotel_compte_personnel as cp inner join hotel_personnel as pe on "
                . "cp.id_personnel=pe.id_personnel where cp.id_compte_personnel='" . $rowlbl["id_compte_personnel"] . "' ") or die(mysqli_error($con));
        $reccr = mysqli_fetch_assoc($rsltcr);

//        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["personnem"] = "Economat - ".$reccr["nom_pe"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["servicem"] = "Restaurant";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["operationm"] = "Vente";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["quantite"] = $stockarp;
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["dateliv"])) {
                    $f = TRUE;
                    foreach ($tab[$k]["mouvement"] as $km => $vm) {
                        if (($tab[$k]["mouvement"][$km]["operationm"] == "Vente") && ($tab[$k]["mouvement"][$km]["servicem"] == "Restaurant")) {
                            $fm = TRUE;
                            $tab[$k]["mouvement"][$km]["quantite"] = $tab[$k]["mouvement"][$km]["quantite"] + $stockarp;
                        }
                    }
                    if (!$fm) {
                        $tab[$k]["mouvement"][$i]["servicem"] = "Restaurant";
                        $tab[$k]["mouvement"][$i]["operationm"] = "Vente";
                        $tab[$k]["mouvement"][$i]["quantite"] = $stockarp;
                        $tab[$k]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];
                        $i = $i + 1;
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }

    while ($rowlbl = mysqli_fetch_assoc($rsltuserblh)) {

        $stockarp = $rowlbl["stock_lh"];
        if ($rowlbl["id_unite"] != $rowlbl["unite_vente_article"]) {
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
        }
        $prodArray = array($rowlbl["dateliv"] => array(
                'datem' => $rowlbl["dateliv"],
                'mouvement' => array()
        ));
        $rsltcr = $con->query("select * from hotel_compte_personnel as cp inner join hotel_personnel as pe on "
                . "cp.id_personnel=pe.id_personnel where cp.id_compte_personnel='" . $rowlbl["id_compte_personnel_valide"] . "' ") or die(mysqli_error($con));
        $reccr = mysqli_fetch_assoc($rsltcr);


//        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["personnem"] = "Economat - ".$reccr["nom_pe"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["servicem"] = "Hébergement";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["operationm"] = "Reception Livraison";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["quantite"] = $stockarp;
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["dateliv"])) {
                    $f = TRUE;
                    foreach ($tab[$k]["mouvement"] as $km => $vm) {
                        if (($tab[$k]["mouvement"][$km]["operationm"] == "Reception Livraison") && ($tab[$k]["mouvement"][$km]["servicem"] == "Hébergement")) {
                            $fm = TRUE;
                            $tab[$k]["mouvement"][$km]["quantite"] = $tab[$k]["mouvement"][$km]["quantite"] + $stockarp;
                        }
                    }
                    if (!$fm) {
                        $tab[$k]["mouvement"][$i]["servicem"] = "Hébergement";
                        $tab[$k]["mouvement"][$i]["operationm"] = "Reception Livraison";
                        $tab[$k]["mouvement"][$i]["quantite"] = $stockarp;
                        $tab[$k]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];
                        $i = $i + 1;
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }

    while ($rowlbl = mysqli_fetch_assoc($rsltusertls)) {

        $stockarp = $rowlbl["stock_tls"];
        if ($rowlbl["id_unite"] != $rowlbl["unite_vente_article"]) {
            $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
                    . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
            $nbarpa = mysqli_num_rows($rsltuarpa);

            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
            if ($nbarpa != 0) {
                $stockarap = 0;
                if ($rowarpa["stock_convertion"] != 0) {
                    $stockarap = (($rowlbl["stock_tls"] * $rowlbl["stock_article"]) / ($rowarpa["stock_convertion"]));
                }
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }
            } else {
                $stockarap = $rowlbl["stock_tls"];
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }
            }
        }
        $prodArray = array($rowlbl["dateliv"] => array(
                'datem' => $rowlbl["dateliv"],
                'mouvement' => array()
        ));
        $rsltcr = $con->query("select * from hotel_compte_personnel as cp inner join hotel_personnel as pe on "
                . "cp.id_personnel=pe.id_personnel where cp.id_compte_personnel='" . $rowlbl["id_compte_personnel"] . "' ") or die(mysqli_error($con));
        $reccr = mysqli_fetch_assoc($rsltcr);


//        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["personnem"] = "Economat - ".$reccr["nom_pe"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["servicem"] = "Hébergement";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["operationm"] = "Transfert linge sale";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["quantite"] = $stockarp;
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["dateliv"])) {
                    $f = TRUE;
                    foreach ($tab[$k]["mouvement"] as $km => $vm) {
                        if (($tab[$k]["mouvement"][$km]["operationm"] == "Transfert linge sale") && ($tab[$k]["mouvement"][$km]["servicem"] == "Hébergement")) {
                            $fm = TRUE;
                            $tab[$k]["mouvement"][$km]["quantite"] = $tab[$k]["mouvement"][$km]["quantite"] + $stockarp;
                        }
                    }
                    if (!$fm) {
                        $tab[$k]["mouvement"][$i]["servicem"] = "Hébergement";
                        $tab[$k]["mouvement"][$i]["operationm"] = "Transfert linge sale";
                        $tab[$k]["mouvement"][$i]["quantite"] = $stockarp;
                        $tab[$k]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];
                        $i = $i + 1;
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }

    while ($rowlbl = mysqli_fetch_assoc($rsltuserbn)) {

        $stockarp = $rowlbl["stock_lbn"];
        if ($rowlbl["id_unite"] != $rowlbl["unite_vente_article"]) {
            $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
                    . "and id_article_point_hotel='" . $rowlbl["id_article_point_hotel"] . "'") or die(mysqli_error($con));
            $nbarpa = mysqli_num_rows($rsltuarpa);

            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
            if ($nbarpa != 0) {
                $stockarap = 0;
                if ($rowarpa["stock_convertion"] != 0) {
                    $stockarap = (($rowlbl["stock_lbn"] * $rowlbl["stock_article"]) / ($rowarpa["stock_convertion"]));
                }
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }
            } else {
                $stockarap = $rowlbl["stock_lbn"];
                if ($stockarap >= 0) {
                    $stockarp = $stockarap;
                } else {
                    $stockarp = 0;
                }
            }
        }
        $prodArray = array($rowlbl["dateliv"] => array(
                'datem' => $rowlbl["dateliv"],
                'mouvement' => array()
        ));
        $rsltcr = $con->query("select * from hotel_compte_personnel as cp inner join hotel_personnel as pe on "
                . "cp.id_personnel=pe.id_personnel where cp.id_compte_personnel='" . $rowlbl["id_compte_personnel"] . "' ") or die(mysqli_error($con));
        $reccr = mysqli_fetch_assoc($rsltcr);


//        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["personnem"] = "Economat - ".$reccr["nom_pe"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["servicem"] = "Economat";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["operationm"] = "Envoi pour nettoyage";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["quantite"] = $stockarp;
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["dateliv"])) {
                    $f = TRUE;
                    foreach ($tab[$k]["mouvement"] as $km => $vm) {
                        if (($tab[$k]["mouvement"][$km]["operationm"] == "Envoi pour nettoyage") && ($tab[$k]["mouvement"][$km]["servicem"] == "Economat")) {
                            $fm = TRUE;
                            $tab[$k]["mouvement"][$km]["quantite"] = $tab[$k]["mouvement"][$km]["quantite"] + $stockarp;
                        }
                    }
                    if (!$fm) {
                        $tab[$k]["mouvement"][$i]["servicem"] = "Economat";
                        $tab[$k]["mouvement"][$i]["operationm"] = "Envoi pour nettoyage";
                        $tab[$k]["mouvement"][$i]["quantite"] = $stockarp;
                        $tab[$k]["mouvement"][$i]["unite"] = $rowlbl["unite_vente_article"];
                        $i = $i + 1;
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }

    while ($rowlbl = mysqli_fetch_assoc($rsltuserav)) {
        $stockarp = $rowlbl["stock_article_avarie"];
        if ($rowlbl["id_unite"] != $rowlbl["unite_sortie_article"]) {
            $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowlbl["id_unite"] . "' "
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
        }
        $prodArray = array($rowlbl["dateliv"] => array(
                'datem' => $rowlbl["dateliv"],
                'mouvement' => array()
        ));
        $rsltcr = $con->query("select * from hotel_compte_personnel as cp inner join hotel_personnel as pe on "
                . "cp.id_personnel=pe.id_personnel where cp.id_compte_personnel='" . $rowlbl["id_compte_personnel"] . "' ") or die(mysqli_error($con));
        $reccr = mysqli_fetch_assoc($rsltcr);
        $rsltspa = $con->query("select * from service_point_hotel as spa left join hotel_service as s on spa.id_service=s.id_service "
                . "where spa.id_service_point_hotel='" . $rowlbl["id_service_point_hotel"] . "' ") or die(mysqli_error($con));
        $rowspa = mysqli_fetch_assoc($rsltspa);

//        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["personnem"] = "Economat - ".$reccr["nom_pe"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["servicem"] = $rowspa["nom_service"];
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["operationm"] = "Avarie";
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["quantite"] = $stockarp;
        $prodArray[$rowlbl["dateliv"]]["mouvement"][$i]["unite"] = $rowlbl["unite_sortie_article"];

        if (!empty($tab)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tab as $k => $v) {
                if (($tab[$k]["datem"] == $rowlbl["dateliv"])) {
                    $f = TRUE;
                    foreach ($tab[$k]["mouvement"] as $km => $vm) {
                        if (($tab[$k]["mouvement"][$km]["operationm"] == "Avarie") && ($tab[$k]["mouvement"][$km]["servicem"] == $rowspa["nom_service"])) {
                            $fm = TRUE;
                            $tab[$k]["mouvement"][$km]["quantite"] = $tab[$k]["mouvement"][$km]["quantite"] + $stockarp;
                        }
                    }
                    if (!$fm) {
                        $tab[$k]["mouvement"][$i]["servicem"] = $rowspa["nom_service"];
                        $tab[$k]["mouvement"][$i]["operationm"] = "Avarie";
                        $tab[$k]["mouvement"][$i]["quantite"] = $stockarp;
                        $tab[$k]["mouvement"][$i]["unite"] = $rowlbl["unite_sortie_article"];
                        $i = $i + 1;
                    }
                }
            }
            if (!$f) {
                $tab = array_merge($tab, $prodArray);
                $i = $i + 1;
            }
        } else {
            $tab = $prodArray;
            $i = $i + 1;
        }
    }
    $mtt = 0;
    $date2 = date('d-m-Y');
    
    
    if ($tab != NULL) {
        $num = 1;
        $etatmagasin = " \t  \t Mouvement p&eacute;riodique de $row[libelle_article] du $dated au $datef \t \t \n";
        $etatmagasin .= "DATE \t SERVICE \t OPERATION \t QUANTITE \t \n";
        foreach ($tab as $prod) {
            foreach ($prod["mouvement"] as $prodm) {
                                    $rsltua = $con->query("select * from hotel_unite where id_unite='" . $prodm["unite"] . "'") or die(mysqli_error($con));
                                        $rowa = mysqli_fetch_assoc($rsltua);
                                    
            $etatmagasin .= "$prod[datem] \t $prodm[servicem] \t $prodm[operationm]  \t $prodm[quantite]  $rowa[code_unite] \t \n";
            }
        }

        header("Content-type: application/vnd.ms-excel; charset=UTF-16LE");
        header("Content-disposition: attachment; filename=magasineconomatexcel.xls");
        print $etatmagasin;
        exit;
    } else {
        
    }
}
?>