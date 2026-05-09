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
include('../../../hotelconnexion/bdhotel.php');

$reqhote = $con->query("select * from hotel_proprietaire") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if (isset($_REQUEST["commande"])) {
    $id = $_REQUEST["commande"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $req = $con->query("select * from hotel_commande_pharmacie as f left join hotel_pharmacie as b on "
            . "f.id_pharmacie=b.id_pharmacie where f.id_commande_pharmacie='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $reql = $con->query("select * from hotel_ligne_commande_pharmacie as l left join hotel_magasin_pharmacie as mb on "
            . "l.id_magasin_pharmacie=mb.id_magasin_pharmacie left join hotel_article_point_hotel as aph on "
            . "mb.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
            . "aph.id_article=a.id_article where l.id_commande_pharmacie='" . $id . "'") or die(mysqli_error($con));
    
    $rsltph = $con->query('select * from hotel_point_hotel as pa left join hotel_departement as d '
            . 'on pa.id_departement=d.id_departement left join hotel_region as r on d.id_region=r.id_region '
            . 'where pa.id_point_hotel=' . $row["id_point_hotel"] . '') or die(mysqli_error($con));
    $rowph = mysqli_fetch_assoc($rsltph);
    ?>

    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div align="center" style="border-radius: 3mm; border: none; background: #DDDDAA;" >
            <h3>FACTURE DE COMMANDE BAR</h3>
            <?php echo strtoupper($rowhote["hotel"]); ?><br>
            <?php echo strtoupper($rowhote["slogan_h"]); ?><br>
            B. P. <?php echo $rowhote["code_postal_h"]; ?> 
            T&eacute;l: <?php echo $rowhote["tel_p"]; ?>
            E-mail<?php echo $rowhote["email_p"]; ?>
        </div>

        <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 2px #000000; border-radius: 10px; font-size: 9pt; ">
            <thead>
                <tr>
                    <th style="width: 100%; text-align: center; border: solid 1px #000000;" colspan="8">
            </th>
            </tr>
            <tr>
                <th style="width: 5%; border: solid 1px #000000;">N&deg;</th>
                <th style="width: 40%; border: solid 1px #000000;">D&eacute;signation</th>
                <th style="width: 15%; border: solid 1px #000000;">Qt&eacute;</th>
                <th style="width: 20%; border: solid 1px #000000;">P. U.</th>
                <th style="width: 20%; border: solid 1px #000000;">Prix Total</th>

            </tr>
            </thead>
            <tbody>
                <?php
                $nb = 0;
                $tqte=0;
                $tpu=0;
                $tpt=0;
                while ($rowl = mysqli_fetch_assoc($reql)) {
                    $nb = $nb + 1;
                    ?>
                    <tr>
                        <td style="width: 5%; border: solid 1px #000000;text-align: center; "><?php echo $nb ?></td>
                        <td style="width: 40%; border: solid 1px #000000;text-align: left; "><?php echo $rowl["libelle_article"] ?></td>
                        <td style="width: 15%; border: solid 1px #000000;text-align: left; "><?php echo $rowl["stock_ligne_cb"] ?></td>
                        <td style="width: 20%; border: solid 1px #000000;text-align: right; "><?php echo number_format($rowl["prix_ligne_cb"], 0, ',', ' ') ?></td>
                        <td style="width: 20%; border: solid 1px #000000;text-align: right; "><?php echo number_format(($rowl["stock_ligne_cb"] * $rowl["prix_ligne_cb"]), 0, ',', ' ') ?></td>
                    </tr>
                    <?php
                    $tqte=$tqte+$rowl["stock_ligne_cb"];
                    $tpu=$tpu+$rowl["prix_ligne_cb"];
                    $tpt=$tpt+($rowl["stock_ligne_cb"] * $rowl["prix_ligne_cb"]);
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="width: 45%; border: solid 1px #000000;text-align: center;" colspan="2">Facture du : <?php echo $row["date_commande_pharmacie"] ?></th>
                    <td style="width: 15%; border: solid 1px #000000;text-align: left; "><?php echo $tqte ?></td>
                    <td style="width: 40%; border: solid 1px #000000;text-align: right; background: #CCFFCC; font-size: 10pt;  " colspan="2"><?php echo number_format(($tpt), 0, ',', ' ') ?></td>
                </tr>
            </tfoot>
        </table>
        <br><br><br>
        <div align="right" >
            Fait &agrave; <?php echo $rowph["chef_lieu_reg"]; ?>, le <?php echo $date2; ?>
        </div>
    </page>
    <?php
}
?>

