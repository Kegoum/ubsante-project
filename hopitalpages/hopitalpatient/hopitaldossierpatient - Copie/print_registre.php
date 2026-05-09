<?php
include('../../../hotelconnexion/bdhotel.php');

$reqhote = $con->query("select * from hotel_proprietaire") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if (isset($_REQUEST["client"])) {
    $id = $_REQUEST["client"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $rslt = $con->query("select * from hotel_client where id_client='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rsltuser = $con->query("select * from hotel_registre_client as rc left join hotel_paye_logement as pl on "
            . "rc.id_paye_logement=pl.id_paye_logement left join hotel_client as cl on pl.id_client=cl.id_client "
            . "where pl.id_client='" . $id . "' order by rc.date_registre desc ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($rsltuser);
    if ($nb != 0) {
        $tpaye = 0;
//        $date = date('d-m-Y');
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
                    Registre de  <?php echo $row["nom_client"]; ?> 
                    <?php echo $row["prenom_client"]; ?> 
                    - <?php echo $row["cni_client"]; ?>
                </u>
                </td>
                </tr>
            </table><br><br>
            <table cellspacing="0" style="width: 100%; border: solid 1px; font-size: 9pt;">
                <thead>    
                    <tr style=" background: #cbcaca;">
                        <th style="width: 20%;text-align: center; border: solid 1px;">Date</th>
                        <th style="width: 40%;text-align: center; border: solid 1px;">Client</th>
                        <th style="width: 20%;text-align: center; border: solid 1px;">Op&eacute;ration</th>
                        <th style="width: 20%;text-align: center; border: solid 1px;">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nbeleve = 1;
                    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
                        ?>
                        <tr >
                            <td style="width: 20%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($recuser["date_registre"])) ?></td>
                            <td style="width: 40%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($recuser["nom_client"])) ?> 
                                <?php print nl2br(htmlspecialchars($recuser["prenom_client"])) ?>
                                <?php print nl2br(htmlspecialchars($recuser["cni_client"])) ?>
                            </td>
                            <td style="width: 20%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($recuser["operation_reg"])) ?></td>
                            <td style="width: 20%;text-align: center; border: solid 1px;">
                                <?php
                                if ($recuser["operation_reg"] == "Versement") {
                                    print "-" . number_format($recuser["montant_reg"], 0, ',', ' ');
                                    $tpaye = $tpaye - $recuser["montant_reg"];
                                } else {
                                    print number_format($recuser["montant_reg"], 0, ',', ' ');
                                    $tpaye = $tpaye + $recuser["montant_reg"];
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        $nbeleve = $nbeleve + 1;
                    }
                    ?>
                    <tr >
                        <td style="width: 20%;text-align: center; border: solid 1px;"><?php echo $date; ?></td>
                        <td style="width: 40%;text-align: center; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: center; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: center; border: solid 1px;">
                            <?php
                            echo number_format($tpaye, 0, ',', ' ');
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table><br><br>
            <table cellspacing="0" style="width: 100%; font-size: 10pt">
                <tr>
                    <td style="width: 100%; text-align: right">
                        <b>Fait à Yaound&eacute;, le</b> <?php echo $date2 ?><br> &nbsp;
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; text-align: right">
                        Signature de la Direction
                    </td>
                </tr>
            </table>
        </page>  
        <?php
    }
}
?>

