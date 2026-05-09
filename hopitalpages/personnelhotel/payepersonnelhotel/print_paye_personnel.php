<style>
div.badgepdf
{
	
    
    width:       190mm;
    height:      260mm;
	overflow: hidden;
	margin:auto; 
	margin-bottom:0px; 
}
	
	</style>
<?php
include('../../../hotelconnexion/bdhotel.php');

if (isset($_REQUEST["paye_personnel"])) {
    $id = $_REQUEST["paye_personnel"];
    $idph = $_REQUEST["pointhotel"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $reqhote = $con->query("select * from hotel_proprietaire") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

    $req = $con->query("select * from hotel_paye_personnel as r left join hotel_personnel as e "
            . "on r.id_personnel=e.id_personnel where r.id_paye_personnel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $rsltph = $con->query('select * from hotel_point_hotel as pa left join hotel_departement as d '
            . 'on pa.id_departement=d.id_departement left join hotel_region as r on d.id_region=r.id_region '
            . 'where pa.id_point_hotel=' . $idph . '') or die(mysqli_error($con));
    $rowph = mysqli_fetch_assoc($rsltph);
        ?>
        <page backimgx="center">
        <!--<div class="badgepdf" <?php if ($filigr != NULL) { ?> style=" background: url(../../ubschoolimg/logo/<?php print $filigr; ?>) center center no-repeat;" <?php } ?> >-->
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
                        <td style="text-align: center; font-size: 14pt; font-weight: bold;">
                            <u>Bulletin de paie / Re&ccedil;u N&deg;  <?php echo $row["no_paye_personnel"] ?></u>
                        </td>
                    </tr>
                </table><br>
                <table style="width: 100%; border: yes; border-radius: 10; font-size: 9pt;">
                    <tr>
                        <td style="width: 30%; text-align: left;">
                            Periode du : <b><?php echo $row["date_debut_p"] ?><br></b> Au : <b><?php echo $row["date_fin_p"] ?></b>
                        </td>
                        <td style="width: 70%; text-align: center; background-color: #999">
                            <h3><b>Mr/Mme <?php echo $row["nom_pe"] ?> <?php echo $row["prenom_pe"] ?></b></h3>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; border: solid 1px #000000; font-size: 8pt;">
                    <tr>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            Matricule
                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            Cat&eacute;gorie
                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            Echellon
                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            Emploi Occup&eacute;
                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            Anciennet&eacute;
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            <b><?php echo $row["code_pe"] ?></b>
                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">

                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">

                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            <b> <?php echo $row["emploi_occupe"] ?> </b>
                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            M&deg; CNPS :
                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            <b><?php echo $row["no_cnps_pe"] ?></b>
                        </td>
                        <td colspan="3" rowspan="3" style="width: 60%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            D&eacute;partement :
                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            <b><?php echo $row["departement_pe"] ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            Situation Familiale :
                        </td>
                        <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                            <b><?php echo $row["situation_familiale"] ?></b>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; border: solid 1px #000000; font-size: 8pt;">
                    <tr>
                        <td colspan="4" style="width: 90%; text-align: center; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: none;">
                            Taux de r&eacute;mun&eacute;ration brute
                        </td>
                        <td rowspan="20" style="width: 10%; text-align: center; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="width: 90%; text-align: center;"></td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">
                            Salaire de base
                        </td>
                        <td style="width: 30%; text-align: left;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: solid 1px #000000; border-right: solid 1px #000000; border-left: solid 1px #000000;">
                            <?php echo $row["salaire_de_base"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: solid 1px #000000; border-right: none; border-left: none;">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: center;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">
                            Heures suplementaires
                        </td>
                        <td style="width: 30%; text-align: left;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">
                            <?php $heuresup = ($row["heure_sup_15"] + $row["heure_sup_20"] + $row["heure_sup_30"] + $row["heure_sup_40"] + $row["heure_sup_50"]); ?>
                            <?php echo $heuresup ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Heures sup &agrave; 15%......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["heure_sup_15"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Heures sup &agrave; 20%......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["heure_sup_20"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Heures sup &agrave; 30%......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["heure_sup_30"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Heures sup &agrave; 40%......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["heure_sup_40"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Heures sup &agrave; 50%......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["heure_sup_50"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: center;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">
                            Primes
                        </td>
                        <td style="width: 30%; text-align: left;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">
                            <?php $prime = ($row["anciennete_prime"] + $row["rendement_prime"] + $row["logement_prime"]); ?>
                            <?php echo $prime; ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Ancienn&eacute;t&eacute;......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["anciennete_prime"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Rendement......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["rendement_prime"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Logement......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["logement_prime"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; text-align: center;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">
                            Indemnit&e&eacute;s
                        </td>
                        <td style="width: 30%; text-align: left;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">
                            <?php $indemnite = ($row["caisse_indemnite"] + $row["deplacement_indemnite"] + $row["representation_indemnite"]); ?>
                            <?php echo $indemnite; ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Caisse......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["caisse_indemnite"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Deplacement......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["deplacement_indemnite"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Repr&e&eacute;sentation......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">
                            <?php echo $row["representation_indemnite"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="width: 90%; text-align: center;">
                            <b>(1) R&eacute;mun&eacute;ration Brute</b>
                        </td>
                        <td style="width: 10%; text-align: center; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: solid 1px #000000;">
                            <?php echo ($row["remuneration_brute"]); ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="width: 50%; text-align: center;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                        <td rowspan="18" style="width: 10%; text-align: center; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">
                            Retenues Fiscales
                        </td>
                        <td style="width: 30%; text-align: left;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">
                            <?php $retenuf = ($row["irpp"] + $row["cac"] + $row["taxe_communale"] +
                                    $row["redevance_audio_visuel"] + $row["credit_foncier"] + $row["fne"]);
                            ?>
        <?php echo $retenuf ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            I.R.P.P.......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["irpp"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            C.A.C.......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["cac"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Taxe Communale......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["taxe_communale"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Redevance Audio Visuelle......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["redevance_audio_visuel"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Cr&eacute;dit Foncier......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["credit_foncier"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Fonds National de l'Emploi......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["fne"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="width: 50%; text-align: center;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">
                            Retenues Sociales
                        </td>
                        <td style="width: 30%; text-align: left;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">
                            <?php $retenus = ($row["cnps"]); ?>
        <?php echo $retenus ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            PV&ID (CNPS)......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["cnps"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="width: 50%; text-align: center;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">
                            Autres Retenues
                        </td>
                        <td style="width: 30%; text-align: left;">

                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">
                            <?php $retenua = ($row["acompte_salaire"] + $row["avance_exceptionnelle"] + $row["saisie_arret"] +
                                    $row["cotisation_syndicale"] + $row["autre"]);
                            ?>
        <?php echo $retenua ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: solid 1px #000000; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Acomptes sur Salaires......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["acompte_salaire"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Avances et autres pr&ecirc;ts......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["avance_exceptionnelle"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Saisies arr&ecirc;ts......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["saisie_arret"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Cotisations Syndicales......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["cotisation_syndicale"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: none; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; text-align: left;">

                        </td>
                        <td style="width: 30%; text-align: left;">
                            Autres......
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">
        <?php echo $row["autre"] ?>
                        </td>
                        <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">

                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" style="width: 90%; text-align: center;">
                            <b>(2) Total des retenues &agrave; &eacute;ffectuer (a)+(b)+(c)</b>
                        </td>
                        <td style="width: 10%; text-align: center; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: solid 1px #000000;">
        <?php echo ($row["total_retenue"]); ?>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; border: yes; border-radius: 10; font-size: 12pt;">
                    <tr>
                        <td style="width: 60%; text-align: left;">
                            NET &Agrave; PAYER (1)-(2)
                        </td>
                        <td style="width: 40%; text-align: right;">
                            <b><?php echo ($row["remuneration_brute"] - ($row["total_retenue"])) ?></b>
                        </td>
                    </tr>
                </table><br>
                <table cellspacing="0" style="width: 100%; font-size: 10pt">
                    <tr>
                        <td style="width: 50%; text-align: left;">
                            Paiement le : <?php echo $row["date_paye_personnel"]; ?>
                        </td>
                        <td style="width: 50%; text-align: right">
                            <b>Fait &agrave; <?php echo $rowph["chef_lieu_reg"]; ?>, le </b> <?php echo $date2 ?><br> &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%; text-align: left">
                            Signature de l'employ&eacute;
                        </td>
                    </tr>
                </table>
            <!--</div>-->
        </page>  
        <?php
}
?>

