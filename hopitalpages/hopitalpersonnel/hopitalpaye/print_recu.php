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
include('../../../hopitalconnexion/connexion.php');

$reqhote = $con->query("select * from hp_proprietaire as p left join hp_departement as d on "
        . "p.iddepartement=d.iddepartement left join hp_region as r on d.idregion=r.idregion ") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if (isset($_REQUEST["recu"])) {
    $id = $_REQUEST["recu"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $req = $con->query("select * from hp_recu_personnel as r left join hp_affectation as a on r.idaffectation=a.idaffectation "
            . "left join hp_personnel as e on a.idpersonnel=e.idpersonnel where r.idrecupersonnel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    
    ?>
    <page backimgx="center">
    <!--<div class="badgepdf" <?php if ($filigr != NULL) { ?> style=" background: url(../../ubschoolimg/logo/<?php print $filigr; ?>) center center no-repeat;" <?php } ?> >-->
         <table style="width: 100%; font-size: 11pt;">
            <tr>
                <td colspan="2" style="text-align: center; width: 100%;">
                    <b style="font-size : 20pt;"><?php echo strtoupper($rowhote["hopitalproprietaire"]); ?> </b>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; width: 100%"><?php echo ($rowhote["adressehopital"]); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 50%">B. P. <?php echo $rowhote["bpproprietaire"]; ?> <?php echo $rowhote["cheflieuregion"]; ?></td>
                <td style="text-align: right; width: 50%">T&eacute;l: <?php echo $rowhote["telephoneproprietaire"]; ?></td>
            </tr>
        </table>
        <hr>
        <table align="center" >
            <tr>
                <td style="text-align: center; font-size: 14pt; font-weight: bold;">
            <u>Bulletin de paie / Re&ccedil;u N&deg;  <?php echo $row["norecupersonnel"] ?></u>
            </td>
            </tr>
        </table><br>
        <table style="width: 100%; border: yes; border-radius: 10; font-size: 9pt;">
            <tr>
                <td style="width: 30%; text-align: left;">
                    Paiement du : <b><?php echo $row["datejour"] ?><br></b>
                    Motif du paiement <?php echo $row["butrecupersonnel"] ?>
                    <!--Mode de paiement : <b><?php // echo $row["modepaiement"] ?></b>-->
                </td>
                <td style="width: 70%; text-align: center; background-color: #999">
                    <h3><b>Mr/Mme <?php echo $row["nompersonnel"] ?> <?php echo $row["prenompersonnel"] ?></b></h3>
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
                    <b><?php echo $row["codepersonnel"] ?></b>
                </td>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">

                </td>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">

                </td>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                    <b> <?php echo $row["rolepersonnel"] ?> </b>
                </td>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">

                </td>
            </tr>
            <tr>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                    M&deg; CNPS :
                </td>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                    <b><?php // echo $row["nocnpse"] ?></b>
                </td>
                <td colspan="3" rowspan="3" style="width: 60%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">

                </td>
            </tr>
            <tr>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                    D&eacute;partement :
                </td>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                    <b><?php // echo $row["departement_pe"] ?></b>
                </td>
            </tr>
            <tr>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                    Situation Familiale :
                </td>
                <td style="width: 20%; text-align: left; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: none;">
                    <b><?php // echo $row["situation_familiale"] ?></b>
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
                    <?php echo $row["salairedebase"] ?>
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
                    <?php $heuresup = ($row["heuresup15"] + $row["heuresup20"] + $row["heuresup30"] + $row["heuresup40"] + $row["heuresup50"]); ?>
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
                    <?php echo $row["heuresup15"] ?>
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
                    <?php echo $row["heuresup20"] ?>
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
                    <?php echo $row["heuresup30"] ?>
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
                    <?php echo $row["heuresup40"] ?>
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
                    <?php echo $row["heuresup50"] ?>
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
                    <?php $prime = ($row["ancienneteprime"] + $row["rendementprime"] + $row["logementprime"]); ?>
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
                    <?php echo $row["ancienneteprime"] ?>
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
                    <?php echo $row["rendementprime"] ?>
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
                    <?php echo $row["logementprime"] ?>
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
                    <?php $indemnite = ($row["caisseindemnite"] + $row["deplacementindemnite"] + $row["representationindemnite"]); ?>
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
                    <?php echo $row["caisseindemnite"] ?>
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
                    <?php echo $row["deplacementindemnite"] ?>
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
                    <?php echo $row["representationindemnite"] ?>
                </td>
                <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">

                </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 90%; text-align: center;">
                    <b>(1) R&eacute;mun&eacute;ration Brute</b>
                </td>
                <td style="width: 10%; text-align: center; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: solid 1px #000000;">
                    <?php echo ($row["remunerationbrute"]); ?>
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
                    <?php
                    $retenuf = ($row["irpp"] + $row["cac"] + $row["taxecommunale"] +
                            $row["redevanceaudiovisuel"] + $row["creditfoncier"] + $row["fne"]);
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
    <?php echo $row["taxecommunale"] ?>
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
    <?php echo $row["redevanceaudiovisuel"] ?>
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
    <?php echo $row["creditfoncier"] ?>
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
                    <?php
                    $retenua = ($row["acomptesalaire"] + $row["avanceexceptionnelle"] + $row["saisiearret"] +
                            $row["cotisationsyndicale"] + $row["autre"]);
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
    <?php echo $row["acomptesalaire"] ?>
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
    <?php echo $row["avanceexceptionnelle"] ?>
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
    <?php echo $row["saisiearret"] ?>
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
    <?php echo $row["cotisationsyndicale"] ?>
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
    <?php echo ($row["totalretenue"]); ?>
                </td>
            </tr>
        </table>
        <table style="width: 100%; border: yes; border-radius: 10; font-size: 12pt;">
            <tr>
                <td style="width: 60%; text-align: left;">
                    NET &Agrave; PAYER (1)-(2)
                </td>
                <td style="width: 40%; text-align: right;">
                    <b><?php echo ($row["remunerationbrute"] - ($row["totalretenue"])) ?></b>
                </td>
            </tr>
        </table><br>
        <table cellspacing="0" style="width: 100%; font-size: 10pt">
            <tr>
                <td style="width: 50%; text-align: left;">
                    <!--Paiement le :--> 
                        <?php // echo $row["datejour"]; ?>
                </td>
                <td style="width: 50%; text-align: right">
                    <b>Fait &agrave; <?php echo $rowhote["cheflieuregion"]; ?>, le </b> <?php echo $date2 ?><br> &nbsp;
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

