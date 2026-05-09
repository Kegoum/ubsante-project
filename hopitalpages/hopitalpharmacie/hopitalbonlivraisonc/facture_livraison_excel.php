<?php

// Connexion à la base de données
include('../../../hotelconnexion/bdhotel.php');

if (isset($_REQUEST["bonlivraison"])) {
    $id = $_REQUEST["bonlivraison"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $req = $con->query("select * from hotel_bon_livraison_interne as bl left join service_point_hotel as "
            . "sph on bl.id_service_point_hotel=sph.id_service_point_hotel left join hotel_service as s on "
            . "sph.id_service=s.id_service where bl.id_bon_livraison_interne='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $reql = $con->query("select * from hotel_ligne_bon_livraison_interne as lbl left join hotel_article_point_hotel "
            . "as aph on lbl.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
            . "aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_livraison_interne='" . $id . "'") or die(mysqli_error($con));

    $mtt = 0;
    $date2 = date('d-m-Y');

    $num = 1;
    $etatmagasin = " \t  \t Bon de Livraison $row[nom_service] du $row[date_bli] \t \t \n";
    $etatmagasin .= "No \t DESIGNATION \t QUANTITE \t PRIX UNITAIRE \t PRIX TOTAL \t \n";
    $tqte = 0;
    $tpu = 0;
    $tpt = 0;
    while ($rowl = mysqli_fetch_assoc($reql)) {
        $prt = $rowl["prix_vente_lbli"] * $rowl["stock_lbli"];

        $rsltua = $con->query("select * from hotel_unite where id_unite='" . $rowl["id_unite"] . "'") or die(mysqli_error($con));
        $rowa = mysqli_fetch_assoc($rsltua);

        $etatmagasin .= "$num \t $rowl[libelle_article] \t $rowl[stock_lbli]  $rowa[code_unite] \t "
                . "$rowl[prix_vente_lbli] \t $prt \t \n";
        $tqte = $tqte + $rowl["stock_lbli"];
        $tpu = $tpu + $rowl["prix_vente_lbli"];
        $tpt = $tpt + ($rowl["stock_lbli"] * $rowl["prix_vente_lbli"]);
        $num = $num + 1;
    }
    $etatmagasin .= " TOTAL \t \t $tqte \t \t $tpt \t \n";

    header("Content-type: application/vnd.ms-excel; charset=UTF-16LE");
    header("Content-disposition: attachment; filename=facturelivraisonpharmacieexcel.xls");
    print $etatmagasin;
    exit;
}
?>