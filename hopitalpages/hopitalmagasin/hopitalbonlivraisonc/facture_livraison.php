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
include('../../../hopitalconnexion/bdhopital.php');

$reqhote = $con->query("select * from hp_proprietaire") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if (isset($_REQUEST["bonlivraison"])) {
    $id = $_REQUEST["bonlivraison"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $req = $con->query("select * from hp_bon_livraison_interne as bl left join hp_service as s on "
            . "bl.id_service=s.id_service where bl.id_bon_livraison_interne='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $reql = $con->query("select * from hp_ligne_bon_livraison_interne as lbl left join hp_produit as a on "
            . "lbl.id_produit=a.id_produit left join hp_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_livraison_interne='" . $id . "'") or die(mysqli_error($con));
    
    $rsltph = $con->query('select * from hp_point_hopital as pa left join hp_departement as d '
            . 'on pa.id_departement=d.id_departement left join hp_region as r on d.id_region=r.id_region '
            . 'where pa.id_point_hopital=' . $row["id_point_hopital"] . '') or die(mysqli_error($con));
    $rowph = mysqli_fetch_assoc($rsltph);
    ?>

    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div align="center" style="border-radius: 3mm; border: none; background: #DDDDAA;" >
            <h3>Bon de Livraison <?php echo $row["nom_service"] ?></h3>
            <?php echo strtoupper($rowhote["hopital"]); ?><br>
            <?php echo strtoupper($rowhote["slogan_h"]); ?><br>
            B. P. <?php echo $rowhote["code_postal_h"]; ?> 
            T&eacute;l: <?php echo $rowhote["tel_p"]; ?>
            E-mail<?php echo $rowhote["email_p"]; ?>
        </div>

        <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 2px #000000; border-radius: 10px; font-size: 9pt; ">
            <thead>
                <tr>
                    <th style="width: 100%; text-align: center; border: solid 1px #000000;" colspan="6">
            <h4></h4>
            </th>
            </tr>
            <tr>
                <th style="width: 5%; border: solid 1px #000000;">N&deg;</th>
                <th style="width: 50%; border: solid 1px #000000;">D&eacute;signation</th>
                <th style="width: 10%; border: solid 1px #000000;">Qt&eacute;</th>
                <th style="width: 10%; border: solid 1px #000000;">U. V.</th>
                <th style="width: 10%; border: solid 1px #000000;">U. S.</th>
                <th style="width: 15%; border: solid 1px #000000;">Prix Total</th>
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
                        <td style="width: 50%; border: solid 1px #000000;text-align: left; "><?php echo $rowl["libelle_produit"] ?></td>
                        <td style="width: 10%; border: solid 1px #000000;text-align: left; "><?php echo $rowl["stock_lbli"] ?></td>
                        <td style="width: 10%; border: solid 1px #000000;text-align: right; "><?php echo number_format($rowl["unite_vente_lbli"], 0, ',', ' ') ?></td>
                        <td style="width: 10%; border: solid 1px #000000;text-align: right; "><?php echo number_format($rowl["unite_sortie_lbli"], 0, ',', ' ') ?></td>
                        <td style="width: 15%; border: solid 1px #000000;text-align: right; "><?php echo number_format(($rowl["unite_vente_lbli"] * $rowl["stock_lbli"]), 0, ',', ' ') ?></td>
                    </tr>
                    <?php
                    $tqte=$tqte+$rowl["stock_lbli"];
                    $tpu=$tpu+$rowl["unite_vente_lbli"];
                    $tpt=$tpt+($rowl["stock_lbli"] * $rowl["unite_vente_lbli"]);
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="width: 55%; border: solid 1px #000000;text-align: center;" colspan="2">Livraison du : <?php echo $row["date_bli"] ?></th>
                    <td style="width: 10%; border: solid 1px #000000;text-align: left; "><?php echo $tqte ?></td>
                    <td style="width: 35%; border: solid 1px #000000;text-align: right; background: #CCFFCC; font-size: 10pt;  " colspan="3"><?php echo number_format(($tpt), 0, ',', ' ') ?></td>
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

