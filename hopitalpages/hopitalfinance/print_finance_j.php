<?php
include('../../hotelconnexion/bdhotel.php');

$reqhote = $conn->query("select * from hotel_proprietaire") or die(mysqli_error($conn));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if (isset($_REQUEST["datecj"])) {
    $date = $_REQUEST["datecj"];
     $rsltuser = $conn->query("select * from hotel_historique as c where cast(c.date_histo as DATE)='" . $date . "'") or die(mysqli_error($conn));
    $mtt = 0;
    $date2 = date('d-m-Y');
    ?>
    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="10mm">
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
                    <img src="../../hotelimages/logo/<?php echo $rowhote["logo_h"]; ?>" alt="logo" style="height: 22mm; border-radius: 6mm;"><br>
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
                <h2>Historique du <?php echo $date ?></h2>
            </u>
            </td>
            </tr>
        </table><br><br>
        <table cellspacing="0" style="width: 100%; border: solid 1px; font-size: 10pt;">
            <thead>    
                <tr style=" background: #cbcaca;">
                    <th style="width: 12%;text-align: center; border: solid 1px;">Utilisateur</th>
                    <th style="width: 30%;text-align: center; border: solid 1px;">Client</th>
                    <th style="width: 15%;text-align: center; border: solid 1px;">op&eacute;ration</th>
                    <th style="width: 30%;text-align: center; border: solid 1px;">Objet</th>
                    <th style="width: 13%;text-align: center; border: solid 1px;">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($recuser = mysqli_fetch_assoc($rsltuser)) {
                    ?>
                    <tr >
                        <td style="width: 12%;text-align: left; border: solid 1px;">
                        <?php
                        if ($recuser["id_proprietaire"] != NULL) {
                            $reqch = $conn->query("select * from hotel_proprietaire as c where "
                                    . "c.id_proprietaire= '" . $recuser["id_proprietaire"] . "' ") or die(mysqli_error($conn));
                            $rowch = mysqli_fetch_assoc($reqch);
                            ?>
                            <?php print nl2br(htmlspecialchars($rowch["code_p"])) ?> 
                            <?php
                        }
                        if ($recuser["id_compte_personnel"] != NULL) {
                            $reqch = $conn->query("select * from hotel_compte_personnel as c left join hotel_personnel as p on "
                                    . "c.id_personnel=p.id_personnel where c.id_compte_personnel= '" . $recuser["id_compte_personnel"] . "' ") or die(mysqli_error($conn));
                            $rowch = mysqli_fetch_assoc($reqch);
                            ?>
                            <?php print nl2br(htmlspecialchars($rowch["code_pe"])) ?>
                            <?php
                        }
                        ?>
                        </td>
                        <td style="width: 30%;text-align: left; border: solid 1px;">
                        <?php
                        if ($recuser["id_client"] != NULL) {
                            $reqch = $conn->query("select * from hotel_client as c where c.id_client= '" . $recuser["id_client"] . "' "
                                    . "") or die(mysqli_error($conn));
                            $rowch = mysqli_fetch_assoc($reqch);
                            ?>
                            <?php print nl2br(htmlspecialchars($rowch["nom_client"])) ?> 
                            <?php print nl2br(htmlspecialchars($rowch["prenom_client"])) ?> - 
                            <?php print nl2br(htmlspecialchars($rowch["cni_client"])) ?>
                            <?php
                        }
                        ?>
                        </td>
                        <td style="width: 15%;text-align: left; border: solid 1px;">
                            <?php print nl2br(htmlspecialchars($recuser["operation_h"])) ?>
                        </td>
                        <td style="width: 30%;text-align: left; border: solid 1px;">
                            <?php print nl2br(htmlspecialchars($recuser["objet_h"])) ?>
                        </td>
                        <td style="width: 13%;text-align: right; border: solid 1px;">
                            <?php
                            print nl2br(htmlspecialchars($recuser["date_histo"])); 
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table><br><br>
        <table cellspacing="0" style="width: 100%; font-size: 16pt">
            <tr>
                <td style="width: 100%; text-align: right">
                    <b>Fait à Yaound&eacute;, le</b> <?php echo $date2 ?><br> &nbsp;
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

