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
include('../../hopitalconnexion/connexion.php');

$reqhote = $con->query("select * from hp_proprietaire as p left join hp_departement as d on "
        . "p.iddepartement=d.iddepartement left join hp_region as r on d.idregion=r.idregion ") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if ((isset($_REQUEST["moisis"]))) {

    $mois1 = addslashes($_REQUEST["moisis"]);
    $mois1f = explode(' ', $mois1);
    $mois1em = $mois1f[0];
    $mois1ea = $mois1f[1];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');
    ?>

    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">

        <page_footer>
            <!--&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>-->
            <table style="width: 100%; font-size: 10pt;">
                <tr>
                    <td style="text-align: right; width: 100%">
                        
                        <hr style=" height: 8px; background-color: black;">
                        Page [[page_cu]]
                    </td>
                </tr>
            </table>
        </page_footer>
        <table style="width: 100%;border: none;" align="center">
            <tr>
                <td style="width: 40%; text-align: center; font-size: 14pt;">
                    REPUBLIQUE DU CAMEROUN<br>
                    ************************<br>
                    Paix - Travail - Patrie<br>
                    ************************<br>
                    MINISTERE DE LA SANTE PUBLIQUE<br>
                    *******************************<br>
                    SECRETARIAT GENERAL<br>
                    *******************************<br>
                    CELLULE DES INFORMATIONS SANITAIRES
                </td>
                <td style="width: 25%; text-align: center; font-size: 10pt;">
                    <?php
                    if (is_file("../../hopitalimages/minsante.png")) {
                    ?>
                    <img src="../../hopitalimages/minsante.png" alt="minsante" style="width: 60%; border-radius: 5mm;"><br>
                    <?php
                    }
                    ?>
                    <br>MINSANTE
                </td>
                <td style="width: 35%; text-align: center; font-size: 14pt;">
                    REPUBLIC OF CAMEROON<br>
                    *******************************<br>
                    Peace - Work - Fatherland<br>
                    *******************************<br>
                    MINISTRY OF PUBLIC HEALTH<br>
                    *******************************<br>
                    SECRETARIAT GENERAL<br>
                    *******************************<br>
                    HEALTH INFORMATION UNIT
                </td>
            </tr>
        </table>
        <br><br>
        <div align="center" style="" >
            <b style=" font-size: 16pt;">
                SYSTEME NATIONAL D'INFORMATION SANITAIRE
            </b>
            <hr style=" height: 8px; background-color: black">
            <b style=" font-size: 12.7pt;"> 
                RAPPORT MENSUEL D'ACTIVITES DES CENTRES DE SANTE INTEGRES ET ASSIMILES
            </b>
        </div>
        <!--<br>-->
        <h1 style=" text-align: center">- RAM III -</h1>
        <br>

        <table cellspacing="0" style="padding: 1px; width: 100%; border: none; font-size: 9pt; ">

            <tbody>
                <tr>
                    <td style="width: 20%; border: none; ">
                        &nbsp;
                    </td>
                    <td style="width: 35%; border: solid 1px #000000;text-align: left; ">
                        Mois : <?php echo $mois1em; ?>
                    </td>
                    <td style="width: 25%; border: solid 1px #000000;text-align: left; ">
                        Ann&eacute;e : <?php echo $mois1ea; ?>
                    </td>
                    <td style="width: 20%; border: none; ">
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <h3> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            I. &nbsp;&nbsp; IDENTIFICATION DE LA FORMATION SANITAIRE
        </h3>
        <!--<br>-->
        <table cellspacing="0" style="padding: 5px; width: 100%; font-size: 12pt; ">

            <tbody>
                <tr>
                    <td colspan="2" style="width: 100%; border: solid 1px #000000;text-align: left; ">
                        Région : <?php echo $rowhote["cheflieuregion"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Département : <?php echo $rowhote["cheflieudepartement"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Arrondissement : <?php ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; border: solid 1px #000000;text-align: left; ">
                        District de santé de : <?php ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Aire de santé de : <?php ?>  
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; border: solid 1px #000000;text-align: left; font-size: 9pt; ">
                        Nombre de villages/quartiers desservis : <?php ?>&nbsp;&nbsp;
                        Nombre de villages/quartiers nécessitant une stratégie avancée/mobile(>5km) : <?php ?>  
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; border: solid 1px #000000;text-align: left; ">
                        <b>Nom de la formation sanitaire :</b> <?php echo strtoupper($rowhote["hopitalproprietaire"]); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; border: solid 1px #000000;text-align: left; ">
                        Statut : Public <?php ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Public Apparenté : <?php ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Parapublic : <?php ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        privé confessionnel : <?php ?><br>
                        Privé laic à but non lucratif : <?php ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Privé à but lucratif : <?php ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; border: solid 1px #000000;text-align: left; ">
                        Téléphone de la structure : <?php echo $rowhote["telephoneproprietaire"]; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; border: solid 1px #000000;text-align: left; ">
                        E-mail : <?php echo $rowhote["emailproprietaire"]; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 100%; border: solid 1px #000000;text-align: left; ">
                        Lieu d’implantation(ville/village/quartier) : <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; border: solid 1px #000000;text-align: left; ">
                        Date saisie dans DHIS2 :
                    </td>
                    <td style="width: 50%; border: solid 1px #000000;text-align: left; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; border: solid 1px #000000;text-align: left; ">
                        Nom du gestionnaire de données :
                    </td>
                    <td style="width: 50%; border: solid 1px #000000;text-align: left; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; border: solid 1px #000000;text-align: left; ">
                        Téléphone du gestionnaire de données :
                    </td>
                    <td style="width: 50%; border: solid 1px #000000;text-align: left; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; border: solid 1px #000000;text-align: left; ">
                        Nom de responsable de  la formation sanitaire
                    </td>
                    <td style="width: 50%; border: solid 1px #000000;text-align: left; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; border: solid 1px #000000;text-align: center; font-size: 10pt; ">
                        Cachet de la formation sanitaire
                        <br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;
                    </td>
                    <td style="width: 50%; border: solid 1px #000000;text-align: center; font-size: 10pt; ">
                        Signature du responsable de la formation sanitaire
                        <br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;<br>
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <h3> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            II. &nbsp;&nbsp; SANTE REPRODUCTIVE, MATERNELLE, NEONATALE ET INFANTILE (SRMNI)
        </h3>
        <h4> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            II.1 &nbsp;&nbsp; SANTE DE LA MERE
        </h4>
        <table cellspacing="0" style="padding: 1px; width: 100%; font-size: 9.8pt; ">

            <thead>
                <tr>
                    <th style="width: 85%; border: solid 1px #000000;text-align: left; ">
            <h5> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                II.1.1 &nbsp; CONSULTATIONS PRE NATALES
            </h5>
            </th>
            <th style="width: 5%; border: solid 1px #000000;text-align: center; font-size: 9pt; ">
                &nbsp;10-14 ans
            </th>
            <th style="width: 5%; border: solid 1px #000000;text-align: center; font-size: 9pt; ">
                &nbsp;15-19 ans
            </th>
            <th style="width: 5%; border: solid 1px #000000;text-align: center; font-size: 9pt; ">
                &nbsp;> 19 ans
            </th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width:  85%; border: solid 1px #000000;text-align: left; ">
                        1. &nbsp; Nombres de femmes enceintes de moins de 15 ans reçues au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; background-color: #999; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; background-color: #999; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        2. &nbsp; Nombre total de femmes enceintes reçues en CPN au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        3. &nbsp; Nombre de femmes enceintes enregistrées en CPN I (Ier contact) au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        4. &nbsp; Nombre de femmes enceintes qui ont leur première CPN avant 16 semaines
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        5. &nbsp; Nombre de femmes enceintes reçues en CPN 4 et + au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        6. &nbsp; Nombres de femmes enceintes ayant reçue la 1ere dose de TPI
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        7. &nbsp; Nombre de femmes ayant reçu la 3ème dose de TPI (TPI complet)
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        8. &nbsp; Nombre de femmes ayant reçu la 1ère dose de Tétanos Diphtérie au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        9. &nbsp; Nombre de femmes ayant reçu la 2ème dose de Tétanos Diphtérie au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        10. &nbsp; Nombre de femmes ayant reçu la 3ème dose de Tétanos Diphtérie au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        11. &nbsp; Nombre de femmes ayant reçu la 4ème dose de Tétanos Diphtérie au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        12. &nbsp; Nombre de femmes ayant reçu la 5ème dose de Tétanos Diphtérie au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        13. &nbsp; Nombre total de femmes reçues en CPN au cours du mois dont la pression sanguine a été mesurée

                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        14. &nbsp; Nombre total de femmes en CPN ayant effectuée un test de syphilis
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        15. &nbsp; Nombre total de femmes en CPN ayant fait la mesure du taux d’hémoglobine
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        16. &nbsp; Nombre de cas de syphilis diagnostiqués chez les femmes enceintes en CPN au cours du mois

                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        17. &nbsp; Nombre de FEC déjà connues séropositives à l’hépatite B au moment de leur premier contact en CPN

                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        18. &nbsp; Nombre de cas de syphilis traités chez les femmes enceintes en CPN au cours du mois

                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        19. &nbsp; Nombre de femmes enceintes dépistées à l’hépatite B au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        20. &nbsp; Nombre de femmes enceintes séropositives à l’hépatite B au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        21. &nbsp; Nombre de femmes enceintes ayant reçu la 3ème dose de fer/Acide Folique et + au Cours du mois

                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table cellspacing="0" style="padding: 1px; width: 100%; font-size: 9.8pt; ">

            <thead>
                <tr>
                    <th style="width: 80%; border: solid 1px #000000;text-align: left; ">
            <h5> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                II.1.2 &nbsp; ACCOUCHEMENTS, SOINS OBSTETRICAUX NEONATAUX D’URGENCE
            </h5>
            </th>
            <th style="width: 5%; border: solid 1px #000000;text-align: center; font-size: 9pt; ">
                &nbsp;10-14 ans
            </th>
            <th style="width: 5%; border: solid 1px #000000;text-align: center; font-size: 9pt; ">
                &nbsp;15-19 ans
            </th>
            <th style="width: 5%; border: solid 1px #000000;text-align: center; font-size: 9pt; ">
                &nbsp;> 19 ans
            </th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width:  85%; border: solid 1px #000000;text-align: left; ">
                        22. &nbsp; Nombre total d’accouchements effectués dans la formation sanitaire au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        23. &nbsp; Nombre total d’accouchements enregistrés dans la communauté au cours du moi
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        24. &nbsp; Nombre de femmes ayant bénéficié des soins de la GATPA au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        25. &nbsp; Nombre d’accouchements suivis de complications obstétricales :
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; background-color: #999; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; background-color: #999; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; background-color: #999; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nombre de cas d’Hémorragies
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nombre de cas de travail prolongé dystocie
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nombre de cas de pré éclampsie/ éclampsie
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nombre de cas de Ruptures utérines
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nombre de cas d’infections puerpérales
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        26. &nbsp; Nombre de césariennes réalisées
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        27. &nbsp; Nombre de cas de complications obstétricales pris en charge ou référés au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        28. &nbsp; Nombre de cas de complications d’avortements enregistrés dans la formation sanitaire au cours du mois

                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        29. &nbsp; Nombre de décès maternels enregistrés dans la formation sanitaire au cours du mois

                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        30. &nbsp; Nombre de décès maternels enregistrés dans la communauté au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        31. &nbsp; Nombre de décès maternels audités au cours du mois 
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        32. &nbsp; Nombre de cas de décès des suites d’avortement enregistrés au cours du mois

                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        33. &nbsp; Nombre de décès maternels dus :
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; background-color: #999; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; background-color: #999; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; background-color: #999; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A l’Hémorragie
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Au travail prolongés/dystocie
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A la pré éclampsie/éclampsie
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A la rupture utérines 
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A l’infections puerpérales 
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; font-size: 8pt; ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Autres à préciser : <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        34. &nbsp; Nombre de femmes ayant accouché dans la FOSA, qui ont initié un allaitement maternel dans les 30 minutes en postpartum immédiat au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        35. &nbsp; Nombre de femmes qui ont accouché dans la communauté, qui ont initié un allaitement maternel dans les 30 minutes en postpartum immédiat au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        36. &nbsp; Nombre de femmes qui ont débuté une méthode de planning familial en postpartum immédiat au cours du mois
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 85%; border: solid 1px #000000;text-align: left; ">
                        21. &nbsp; Nombre de femmes enceintes ayant reçu la 3ème dose de fer/Acide Folique et + au Cours du mois

                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                    <td style="width: 5%; border: solid 1px #000000;text-align: center; ">
                        <?php ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </page>
    <?php
}
?>

