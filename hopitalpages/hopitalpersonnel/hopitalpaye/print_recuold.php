<?php
include('../../../ubschoolconnexion/connexion.php');

if (isset($_REQUEST["recu"])) {
    $id = $_REQUEST["recu"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $reqecol = $con->query("select * from ecole") or die(mysqli_error($con));
    $rowecol = NULL;
    while ($rowecol1 = mysqli_fetch_assoc($reqecol)) {
        $rowecol = $rowecol1;
    }

    $reqa = $con->query("select * from annee where libellean<'" . $date . "' and libellean2>'" . $date . "'") or die(mysqli_error($con));
    $rowa = mysqli_fetch_assoc($reqa);

    $req = $con->query("select * from recu as r left join enseignant as e on r.idenseignant=e.idenseignant where r.idrecu='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $and = NULL;
    $anf = NULL;
    if ($rowa != NULL) {
        $dated = date_parse($rowa['libellean']);
        $and = $dated['year'];

        $datef = date_parse($rowa['libellean2']);
        $anf = $datef['year'];
    }
    if ($rowa != NULL) {
        ?>
        <page backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm">
            <table style="width: 100%;border: none;">
                <tr>
                    <td style="width: 40%; text-align: center; font-size: 9pt; font-weight: bold;">
                        <?php echo $rowecol["ministere"]; ?><br><br>
                        <?php echo $rowecol["textea"]; ?><br><?php echo strtoupper($rowecol["nomecole"]); ?><br>
                        <?php echo $rowecol["bp"]; ?> <?php echo $rowecol["quartier"]; ?> <?php echo $rowecol["region"]; ?>
                        <br>T&eacute;l&eacute;phone: <?php echo $rowecol["tel"]; ?>
                    </td>
                    <td style="width: 20%; text-align: center; font-size: 7pt;">
                        <?php
                        if ($rowecol["logo"] != NULL) {
                            ?>
                            <img src="../../../issamupload/logo/<?php echo $rowecol["logo"]; ?>" alt="logo" style="height: 22mm; border-radius: 6mm;"><br>
                            <?php
                        }
                        ?>
                        <?php echo $rowecol["devise"]; ?>
                    </td>
                    <td style="width: 45%; text-align: center; font-size: 10pt; font-weight: bold;">
                        REPUBLIQUE DU CAMEROUN<br>Paix - Travail - Patrie<br><br>ANNEE SCOLAIRE <?php echo $and ?>-<?php echo $anf ?>
                    </td>
                </tr>
            </table><br>
            <table align="center" >
                <tr>
                    <td style="text-align: center; font-size: 14pt; font-weight: bold;">
                <u>Bulletin de paie / Re&ccedil;u N&deg;  <?php echo $row["norecu"] ?></u>
                </td>
                </tr>
            </table><br>
            <table style="width: 100%; border: yes; border-radius: 10;  font-size: 9pt;">
                <tr>
                    <td style="width: 100%; text-align: left;">
                        Nom ou raison sociale : <b><?php echo $rowecol["nomecole"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; text-align: left;">
                        Adresse : <b><?php echo $rowecol["adresse"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; text-align: left;">
                        N&deg; CNPS : <b><?php echo $rowecol["nocnps"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%; text-align: left;">
                        N&deg; de contribuable de l'employeur : <b><?php echo $rowecol["nocontribuable"] ?></b>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border: yes; border-radius: 10; font-size: 9pt;">
                <tr>
                    <td style="width: 50%; text-align: left;">
                        Paye du : <b><?php echo $row["datedebutp"] ?></b>
                    </td>
                    <td style="width: 50%; text-align: left;">
                        Au : <b><?php echo $row["datefinp"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; text-align: left;">
                        Nom et Pr&eacute;nom du travailleur : <b><?php echo $row["nom"] ?> <?php echo $row["prenom"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; text-align: left;">
                        N&deg; de pointage : <b><?php echo $row["nopointage"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; text-align: left;">
                        Emploi et cat&eacute;gorie professionnelle : <b> Enseignant </b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; text-align: left;">
                        N&deg; contribuable de l'employ&eacute; : <b><?php echo $row["nocontribuablee"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; text-align: left;">
                        N&deg; CNPS de l'employ&eacute; : <b><?php echo $row["nocnpse"] ?></b>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border: yes; border-radius: 10; font-size: 9pt;">
                <tr>
                    <td colspan="2" style="width: 100%; text-align: center;">
                        Taux de r&eacute;mun&eacute;ration (Mensuel, Journalier, Horaire)
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Jour&eacute;es &agrave; 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["journee"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Heure &agrave; 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["heure"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Heure sup &agrave; 15% &agrave; 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["heuresup15"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Heure sup &agrave; 20% &agrave; 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["heuresup20"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Heure sup &agrave; 30% &agrave; 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["heuresup30"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Heure sup &agrave; 40% &agrave;
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["heuresup40"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Heure sup &agrave; 50% &agrave;
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["heuresup50"] ?></b>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border: yes; border-radius: 10; font-size: 9pt;">
                <tr>
                    <td colspan="2" style="width: 100%; text-align: center;">
                        Primes
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Anciennes 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["ancienne"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Nouvelles 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["nouvelle"] ?></b>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border: yes; border-radius: 10; font-size: 9pt;">
                <tr>
                    <td colspan="2" style="width: 100%; text-align: center;">
                        Indemnit&eacute;
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Salaire Taxable 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["salairetaxable"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Montant dela r&eacute;mun&eacute;ration brute 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["remunerationbrute"] ?></b>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border: yes; border-radius: 10; font-size: 9pt;">
                <tr>
                    <td colspan="2" style="width: 100%; text-align: center;">
                        Imp&ocirc;t
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        IRPP 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["irpp"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        CAC 10% IRPP 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["cac"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Taxe Communale 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["taxecommunale"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Retenue CRTV 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["retenuecrtv"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Cr&eacute;dit foncier 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["creditfoncier"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Total Imp&ocirc;t 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo ($row["irpp"] + $row["taxecommunale"]) ?></b>
                        <!--<b><?php // echo ($row["irpp"]+$row["taxecommunale"]+$row["retenuecrtv"]+$row["creditfoncier"])  ?></b>-->
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border: yes; border-radius: 10; font-size: 9pt;">
                <tr>
                    <td colspan="2" style="width: 100%; text-align: center;">
                        Retenue
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Caisse de retraite (CNPS) 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["caisseretraite"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Acompte sur salaire 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["acomptesalaire"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Avance exceptionnelle
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["avanceexceptionnelle"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Retenue sur Cession 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["retenuecession"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Saisie
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo $row["saisie"] ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Cotisation Syndicale 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo ($row["cotisationsyndicale"]) ?></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Total Retenue 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo ($row["caisseretraite"]) ?></b>
                        <!--<b><?php //echo ($row["caisseretraite"]+$row["acomptesalaire"]+$row["avanceexceptionnelle"]+$row["retenuecession"]+$row["saisie"]+$row["cotisationsyndicale"])  ?></b>-->
                    </td>
                </tr>
            </table><br>
            <table style="width: 100%; border: yes; border-radius: 10; font-size: 10pt;">
                <tr>
                    <td style="width: 60%; text-align: left;">
                        Net &agrave;Payer 
                    </td>
                    <td style="width: 40%; text-align: left;">
                        <b><?php echo ($row["remunerationbrute"] - ($row["caisseretraite"] + $row["irpp"] + $row["taxecommunale"])) ?></b>
                    </td>
                </tr>
            </table><br>
            <table cellspacing="0" style="width: 100%; font-size: 12pt">
                <tr>
                    <td style="width: 100%; text-align: right">
                        <b>Fait à <?php echo $rowecol["quartier"]; ?>, le</b> <?php echo $date2 ?><br> &nbsp;
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; text-align: left">
                        Signature de l'employ&eacute;
                    </td>
                </tr>
            </table>
        </page>  
        <?php
    }
}
?>

