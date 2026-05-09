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

if (isset($_REQUEST["caisse"])) {
    $id = $_REQUEST["caisse"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $req = $con->query("select * from hotel_caisse as c where c.id_caisse='" . $id . "'") or die(mysqli_error($con));
    
    $row = mysqli_fetch_assoc($req);
   
    $rsltph = $con->query('select * from hotel_point_hotel as pa left join hotel_departement as d '
            . 'on pa.id_departement=d.id_departement left join hotel_region as r on d.id_region=r.id_region '
            . 'where pa.id_point_hotel=' . $row["id_point_hotel"] . '') or die(mysqli_error($con));
    $rowph = mysqli_fetch_assoc($rsltph);
     ?>

    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div align="center" style="border-radius: 3mm; border: none; background: #DDDDAA; font-size: 7pt; " >
            <h3>Facture d&eacute;caissement</h3>
            <?php echo strtoupper($rowhote["hotel"]); ?><br>
            <?php echo strtoupper($rowhote["slogan_h"]); ?><br>
            B. P. <?php echo $rowhote["code_postal_h"]; ?> 
            T&eacute;l: <?php echo $rowhote["tel_p"]; ?>
            E-mail<?php echo $rowhote["email_p"]; ?>
        </div>

        <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 2px #000000; border-radius: 10px; font-size: 6pt; ">
            <thead>
                <tr>
                    <th style="width: 100%; text-align: center; border: solid 1px #000000;" colspan="6">
            <h4></h4>
            </th>
            </tr>
            <tr>
                <th style="width: 15%; border: solid 1px #000000;">Caissier</th>
                <th style="width: 15%; border: solid 1px #000000;">Personnel</th>
                <th style="width: 20%; border: solid 1px #000000;">Service</th>
                <th style="width: 15%; border: solid 1px #000000;">Op&eacute;ration</th>
                <th style="width: 25%; border: solid 1px #000000;">But</th>
                <th style="width: 10%; border: solid 1px #000000;">Montant</th>
            </tr>
            </thead>
            <tbody>
                    <tr>
                        <td style="width: 15%; border: solid 1px #000000;text-align: left; ">
                            <?php
                            if ($row["caissier"] != NULL) {
                                $reqc = $con->query("select * from hotel_compte_personnel as cp inner join hotel_personnel as p on "
                                        . "cp.id_personnel=p.id_personnel where cp.id_compte_personnel='" . $row["caissier"] . "'") or die(mysqli_error($con));
                                $rowc = mysqli_fetch_assoc($reqc);
                                ?>
                                <?php echo $rowc["nom_pe"] ?> - <?php echo $rowc["tel_pe"] ?>
                                <?php
                            }
                            ?>
                        </td>
                        <td style="width: 15%; border: solid 1px #000000;text-align: left; ">
                            <?php
                            if ($row["id_personnel"] != NULL) {
                                $reqp = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on "
                                        . "pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
                                        . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
                                        . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service "
                                        . "where pe.id_personnel='" . $row["id_personnel"] . "'") or die(mysqli_error($con));
                                $rowp = mysqli_fetch_assoc($reqp);
                                ?>
                                <?php echo $rowp["nom_pe"] ?> - <?php echo $rowp["tel_pe"] ?>
                                <?php
                            }
                            ?>
                        </td>
                        <td style="width: 20%; border: solid 1px #000000;text-align: left; ">
                            <?php
                            if ($row["id_service_point_hotel"] != NULL) {
                                $reqp = $con->query("select * from service_point_hotel as spa left join hotel_service "
                                        . "as s on spa.id_service=s.id_service where "
                                        . "spa.id_service_point_hotel='" . $row["id_service_point_hotel"] . "'") or die(mysqli_error($con));
                                $rowp = mysqli_fetch_assoc($reqp);
                                ?>
                                <?php echo $rowp["nom_service"] ?>
                                <?php
                            }
                            ?>
                        </td>
                        <td style="width: 15%; border: solid 1px #000000;text-align: left; ">
                            <?php echo nl2br(htmlspecialchars($row["operation"])); ?>
                        </td>
                        <td style="width: 25%; border: solid 1px #000000;text-align: left; ">
                            <?php echo nl2br(htmlspecialchars($row["but"])); ?>
                        </td>
                        <td style="width: 10%; border: solid 1px #000000;text-align: right; ">
                            <?php echo number_format(($row["montant_caisse"]), 0, ',', ' ') ?>
                        </td>
                    </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th style="width: 50%; border: solid 1px #000000;text-align: center;" colspan="3">Facture du : <?php echo $row["date_caisse"] ?></th>
                    <td style="width: 50%; border: solid 1px #000000;text-align: right; background: #CCFFCC; font-size: 10pt;  " colspan="3"><?php echo number_format(($row["montant_caisse"]), 0, ',', ' ') ?></td>
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

