<?php
include('../../../../hotelconnexion/bdhotel.php');

$reqhote = $con->query("select * from hotel_proprietaire") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if ((isset($_REQUEST["dated"])) && (isset($_REQUEST["datef"]))) {
    $dated = $_REQUEST["dated"];
    $datef = $_REQUEST["datef"];
    $idph=$_REQUEST["pointhotel"];
    
    $rsltph = $con->query('select * from hotel_point_hotel as pa left join hotel_departement as d '
            . 'on pa.id_departement=d.id_departement left join hotel_region as r on d.id_region=r.id_region '
            . 'where pa.id_point_hotel=' . $idph . ' ') or die(mysqli_error($con));
    $rowph = mysqli_fetch_assoc($rsltph);
    
    $rsltuser = $con->query("select * from hotel_caisse as c left join hotel_compte_personnel as cp on "
            . "c.caissier=cp.id_compte_personnel "
            . "where c.id_point_hotel='".$idph."' and cast(c.date_caisse as DATE) BETWEEN '" . $dated . "' and '" . $datef . "' order by c.date_caisse desc ") or die(mysqli_error($con));
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
                    <img src="../../../../hotelimages/logo/<?php echo $rowhote["logo_h"]; ?>" alt="logo" style="height: 22mm; border-radius: 6mm;"><br>
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
                <h2>Controle du <?php echo $dated ?> au <?php echo $datef ?></h2>
            </u>
            </td>
            </tr>
        </table><br><br>
        <table cellspacing="0" style="width: 100%; border: solid 1px; font-size: 10pt;">
            <thead>    
                <tr style=" background: #cbcaca;">
                    <th style="width: 25%;text-align: center; border: solid 1px;">Caissier</th>
                    <th style="width: 15%;text-align: center; border: solid 1px;">Date</th>
                    <th style="width: 13%;text-align: center; border: solid 1px;">op&eacute;ration</th>
                    <th style="width: 35%;text-align: center; border: solid 1px;">But</th>
                    <th style="width: 12%;text-align: center; border: solid 1px;">Montant</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($recuser = mysqli_fetch_assoc($rsltuser)) {
                    ?>
                    <tr >
                        <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($recuser["login_pe"])) ?></td>
                        <td style="width: 15%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($recuser["date_caisse"])) ?></td>
                        <td style="width: 13%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($recuser["operation"])) ?></td>
                        <td style="width: 35%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($recuser["but"])) ?></td>
                        <td style="width: 12%;text-align: right; border: solid 1px;">
                            <?php
                            if ($recuser["operation"] == "Versement") {
                                print number_format(nl2br(htmlspecialchars($recuser["montant_caisse"])), 0, ',', ' ');
                                $mtt = $mtt + $recuser["montant_caisse"];
                            } else {
                                print "-" . number_format(nl2br(htmlspecialchars($recuser["montant_caisse"])), 0, ',', ' ');
                                $mtt = $mtt - $recuser["montant_caisse"];
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr >
                    <td style="width: 25%;text-align: center; border: solid 1px;">TOTAL</td>
                    <td style="width: 15%;text-align: left; border: solid 1px;"></td>
                    <td style="width: 13%;text-align: left; border: solid 1px;"></td>
                    <td style="width: 35%;text-align: left; border: solid 1px;"></td>
                    <td style="width: 12%;text-align: right; border: solid 1px;"><?php echo number_format($mtt, 0, ',', ' ') ?></td>
                </tr>
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

