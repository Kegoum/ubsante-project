
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Gestion des Paies</h1>
                                <h5>Bulletin de Paie du personnel <small> <?php echo $row["nompersonnel"]; ?> <?php echo $row["prenompersonnel"]; ?> - <?php echo $row["codepersonnel"]; ?></small></h5>
                                <h2 style="color: red">Confirmation du paiement cette action est irréversible !!!</h2>
                            </div>
                        </div>
                        <form id="ajout_prod" name="form" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpaye/hopitalajouter/insert_paye'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&idpersonnel=<?php echo $_REQUEST["idpersonnel"] ?>">
                            <input name="idpersonnel" value="<?php echo $_REQUEST["idpersonnel"]; ?>" type="hidden" class="form-control" id="idpersonnel" >
                            <input name="idaffectation" value="<?php echo $row["idaffectation"]; ?>" type="hidden" class="form-control" id="idaffectation" >
                            <input name="salaireaffectation" value="<?php echo $row["salaireaffectation"]; ?>" type="hidden" class="form-control" id="salaireaffectation" >

                            <table style="width: 100%; border: yes; border-radius: 10; font-size: 9pt;">
                                <tr>
                                    <td style="width: 30%; text-align: left;">
                                        Paiement du : <b><?php echo $_SESSION['formpaye'][1]["datejoureffectue"] ?><br></b> 
                                        <!--Mode de paiement : <b><?php // echo $_SESSION['formpaye'][1]["modepaiement"]  ?></b>-->
                                    </td>
                                    <td style="width: 70%; text-align: center; background-color: #999">
                                        <h3><b>Mr/Mme <?php echo $_SESSION['formpaye'][1]["nome"]; ?></b></h3>
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
                                        <?php echo $_SESSION['formpaye'][1]["salairebase"]; ?>
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
                                        <?php // $heuresup = ($_SESSION['formpaye'][1]["heuresup"] + $_SESSION['formpaye'][1]["heuresup"] + $row["heuresup30"] + $row["heuresup40"] + $row["heuresup50"]); ?>
                                        <?php echo $_SESSION['formpaye'][1]["heuresup"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["heure15"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["heure20"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["heure30"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["heure40"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["heure50"] ?>
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
                                        <?php // $prime = ($row["ancienneteprime"] + $row["rendementprime"] + $row["logementprime"]); ?>
                                        <?php echo $_SESSION['formpaye'][1]["prime"]; ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["anciennep"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["rendementp"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["logementp"] ?>
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
                                        <?php // $indemnite = ($row["caisseindemnite"] + $row["deplacementindemnite"] + $row["representationindemnite"]); ?>
                                        <?php echo $_SESSION['formpaye'][1]["indemnite"]; ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["caissei"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["deplacementi"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["representationi"] ?>
                                    </td>
                                    <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="width: 90%; text-align: center;">
                                        <b>(1) R&eacute;mun&eacute;ration Brute</b>
                                    </td>
                                    <td style="width: 10%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: solid 1px #000000;">
                                        <?php echo ($_SESSION['formpaye'][1]["remunerationbrute"]); ?>
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
//                    $retenuf = ($row["irpp"] + $row["cac"] + $row["taxecommunale"] + $row["redevanceaudiovisuel"] + $row["creditfoncier"] + $row["fne"]);
                                        ?>
                                        <?php echo $_SESSION['formpaye'][1]["retenuefiscales"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["irpp"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["cac"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["taxec"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["redevanceaudio"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["creditf"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["fne"] ?>
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
                                        <?php // $retenus = ($row["cnps"]); ?>
                                        <?php echo $_SESSION['formpaye'][1]["retenuesociales"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["cnps"] ?>
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
//                    $retenua = ($row["acomptesalaire"] + $row["avanceexceptionnelle"] + $row["saisiearret"] + $row["cotisationsyndicale"] + $row["autre"]);
                                        ?>
                                        <?php echo $_SESSION['formpaye'][1]["autresretenue"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["acomptes"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["avancee"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["saisiearret"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["cotisations"] ?>
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
                                        <?php echo $_SESSION['formpaye'][1]["autre"] ?>
                                    </td>
                                    <td style="width: 20%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: none; border-left: solid 1px #000000;">

                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="width: 90%; text-align: center;">
                                        <b>(2) Total des retenues &agrave; &eacute;ffectuer (a)+(b)+(c)</b>
                                    </td>
                                    <td style="width: 10%; text-align: right; border-bottom: solid 1px #000000; border-top: none; border-right: solid 1px #000000; border-left: solid 1px #000000;">
                                        <?php echo ($_SESSION['formpaye'][1]["totalretenue"]); ?>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%; border: yes; border-radius: 10; font-size: 12pt;">
                                <tr>
                                    <td style="width: 60%; text-align: left;">
                                        NET &Agrave; PAYER (1)-(2)
                                    </td>
                                    <td style="width: 40%; text-align: right;">
                                        <b><?php echo ($_SESSION['formpaye'][1]["netapayer"]) ?></b>
                                    </td>
                                </tr>
                            </table><br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <b style="color: red">Champs Obligatoires *</b>
                                </div>
                                <div class="col-sm-6">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpaye/hopitalajouter/insert_paye'); ?>&pagecom=<?php echo NUM_PAGE - 1; ?>&idpersonnel=<?php echo $_REQUEST["idpersonnel"] ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>
                                        <button type="submit" name="insproduit" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        $("#libeffectue").change(function () {
            var moid = $(this).val();
//            alert(moid);
            $.ajax({
                url: 'hopitalpages/hopitalpersonnel/hopitalpaye/getsalaire.php',
                type: 'post',
                data: {moid: moid},
                dataType: 'json',
                success: function (response) {
                    var factjmo = response['prixu'];
                    var nbh = response['nbh'];
//                    alert(factjmo);
                    document.getElementById("qteeffectue").value = "";
                    document.getElementById("prixueffectue").value = "";
                    document.getElementById("qteeffectue").value = parseFloat(nbh);
                    document.getElementById("prixueffectue").value = parseFloat(factjmo);
                    CalculTotalMO();
                }
            });
        });

    });

    function CalculTotalMON(i)
    {
        var p = 0;
        var q = 0;
        var ta = 0;
        var salb = 0;
        if (document.getElementById("qteeffectue" + i).value != "") {
            q = parseFloat(document.getElementById("qteeffectue" + i).value);
        }
        if (document.getElementById("prixueffectue" + i).value != "") {
            p = parseFloat(document.getElementById("prixueffectue" + i).value);
        }
        if (document.getElementById("prixteffectue" + i).value != "") {
            ta = parseFloat(document.getElementById("prixteffectue" + i).value);
        }
        if (document.getElementById("salairebase").value != "") {
            salb = parseFloat(document.getElementById("salairebase").value);
        }
        document.getElementById("prixteffectue" + i).value = "";

        if (p > 0)
        {
            var t = q * p;
            var told = (salb - ta) + t;
//            Math.max(a,b) donne le plus grand entre a et b
//              toFixed(2) limite à 2 chiffres après la virgule
            document.getElementById("prixteffectue" + i).value = (Math.max((((t))), 0)).toFixed(2);
            document.getElementById("salairebase").value = (Math.max((((told))), 0)).toFixed(2);
            changeRemunerationBrute();
        }
    }
    function CalculTotalMO()
    {
        var p = 0;
        var q = 0;
        var ta = 0;
        var salb = 0;
        if (document.getElementById("qteeffectue").value != "") {
            q = parseFloat(document.getElementById("qteeffectue").value);
        }
        if (document.getElementById("prixueffectue").value != "") {
            p = parseFloat(document.getElementById("prixueffectue").value);
        }
        if (document.getElementById("prixteffectue").value != "") {
            ta = parseFloat(document.getElementById("prixteffectue").value);
        }
        if (document.getElementById("salairebase").value != "") {
            salb = parseFloat(document.getElementById("salairebase").value);
        }
        document.getElementById("prixteffectue").value = "";

        if (p > 0)
        {
            var t = q * p;
            var told = (salb - ta) + t;
//            Math.max(a,b) donne le plus grand entre a et b
//              toFixed(2) limite à 2 chiffres après la virgule
            document.getElementById("prixteffectue").value = (Math.max((((t))), 0)).toFixed(2);
            document.getElementById("salairebase").value = (Math.max((((told))), 0)).toFixed(2);
            changeRemunerationBrute();

        }
    }

    var cmo, c2mo, d1mo, d2mo, d3mo, d4mo, d7mo, d8mo, d9mo, d10mo, chmo, chmo1, chmo3,
            labelmo, labelmo1,
            labelmo3, labelmo4, dmo, selectmo, dselmo;

    function movplus() {
        cmo = document.getElementById("cadremo");
        dpmo = document.createElement("p");
        dmo = document.createElement("div");
        c2mo = cmo.getElementsByTagName("p");
        brmo = document.createElement("br");

        d1mo = document.createElement("div");
        d2mo = document.createElement("div");
        labelmo = document.createElement("label");
        selectmo = document.createElement("select");

        d3mo = document.createElement("div");
        labelmo1 = document.createElement("label");
        d4mo = document.createElement("div");
        chmo = document.createElement("input");

        chmo1 = document.createElement("input");

        d7mo = document.createElement("div");
        labelmo3 = document.createElement("label");
        d8mo = document.createElement("div");

        d9mo = document.createElement("div");
        dselmo = document.createElement("div");
        labelmo4 = document.createElement("label");
        d10mo = document.createElement("div");
        chmo3 = document.createElement("input");

        labelmo = document.createTextNode("Pointage : ");
        labelmo1 = document.createTextNode("Quantité : ");
        labelmo2 = document.createTextNode("Durée (H) : ");
        labelmo3 = document.createTextNode("Montant Unitaire : ");
        labelmo4 = document.createTextNode("Montant Total : ");

        dmo.setAttribute("class", "row");
        d1mo.setAttribute("class", "col-lg-4 col-md-4 col-sm-6 col-xs-12");
        d2mo.setAttribute("class", "chosen-select-single");
        d3mo.setAttribute("class", "col-lg-2 col-md-2 col-sm-3 col-xs-6");
        d4mo.setAttribute("class", "input-group mg-b-pro-edt");

        d7mo.setAttribute("class", "col-lg-3 col-md-3 col-sm-3 col-xs-6");
        d8mo.setAttribute("class", "input-group mg-b-pro-edt");
        d9mo.setAttribute("class", "col-lg-3 col-md-3 col-sm-3 col-xs-6");
        d10mo.setAttribute("class", "input-group mg-b-pro-edt");

        selectmo.setAttribute("class", "chosen-select form-control libeffectuen");
        selectmo.setAttribute("name", "libeffectue" + c2mo.length);
        selectmo.setAttribute("id", c2mo.length);

        theOption = document.createElement("OPTION");
        theText = document.createTextNode(" -Choisissez un pointage - ");
        theOption.setAttribute("value", "");
        theOption.appendChild(theText);

        selectmo.appendChild(theOption);


        chmo.setAttribute("type", "text");
        chmo.setAttribute("class", "");
        chmo.setAttribute("name", "qteeffectue" + c2mo.length);
        chmo.setAttribute("id", "qteeffectue" + c2mo.length);
        chmo.setAttribute("value", "");
        chmo.setAttribute("onkeyup", "CalculTotalMON(" + c2mo.length + ");");

        chmo1.setAttribute("type", "text");
        chmo1.setAttribute("class", "");
        chmo1.setAttribute("name", "prixueffectue" + c2mo.length);
        chmo1.setAttribute("id", "prixueffectue" + c2mo.length);
        chmo1.setAttribute("value", "");
        chmo1.setAttribute("onkeyup", "CalculTotalMON(" + c2mo.length + ");");

        chmo3.setAttribute("type", "text");
        chmo3.setAttribute("class", "");
        chmo3.setAttribute("name", "prixteffectue" + c2mo.length);
        chmo3.setAttribute("id", "prixteffectue" + c2mo.length);
        chmo3.setAttribute("value", "");

        cmo.appendChild(dpmo);
//        c.appendChild(br);

        dpmo.appendChild(dmo);

        dmo.appendChild(d1mo);
        dmo.appendChild(d3mo);
        dmo.appendChild(d7mo);
        dmo.appendChild(d9mo);

        d1mo.appendChild(d2mo);
        d2mo.appendChild(labelmo);
        d2mo.appendChild(selectmo);

        d3mo.appendChild(labelmo1);
        d3mo.appendChild(d4mo);
        d4mo.appendChild(chmo);

        d7mo.appendChild(labelmo3);
        d7mo.appendChild(d8mo);
        d8mo.appendChild(chmo1);

        d9mo.appendChild(labelmo4);
        d9mo.appendChild(d10mo);
        d10mo.appendChild(chmo3);

        document.getElementById("supmo").style.display = "inline";
        document.getElementById('nbeffectue').value = c2mo.length;
        lmo = c2mo.length;
        var idaf = document.getElementById('idaffectation').value;
//alert(idaf);
        $.ajax({
            url: 'hopitalpages/hopitalpersonnel/hopitalpaye/getpointage.php',
            type: 'post',
            data: {idaf: idaf},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['idmo'];
                    var refmo = response[i]['lib'];
                    var hdeb = response[i]['hdeb'];
                    var hfin = response[i]['hfin'];
                    var nname = refmo + " -> " + hdeb + " - " + hfin;

//                            $("#libeffectue" + c2.length).append("<option value='"+id+"'>"+refmo+" - "+name+"</option>");
                    var servi = nname.replace(/&#039;/gi, "\'");

                    theOption = document.createElement("OPTION");
                    theText = document.createTextNode(servi);
                    theOption.setAttribute("value", id);
                    theOption.appendChild(theText);

                    selectmo.appendChild(theOption);

                }

                selectmo.onchange = function () {
                    var moid = $(this).val();

                    var moid2 = $(this).attr('id');
                    var num = moid2.substring(6);

                    $.ajax({
                        url: 'hopitalpages/hopitalpersonnel/hopitalpaye/getsalaire.php',
                        type: 'post',
                        data: {moid: moid},
                        dataType: 'json',
                        success: function (response) {

                            var factjmo = response['prixu'];
                            var nbh = response['nbh'];
//                    alert(factjmo);
                            document.getElementById("qteeffectue" + moid2).value = "";
                            document.getElementById("prixueffectue" + moid2).value = "";
                            document.getElementById("qteeffectue" + moid2).value = parseFloat(nbh);
                            document.getElementById("prixueffectue" + moid2).value = parseFloat(factjmo);
                            CalculTotalMON(moid2);
                        }
                    });
                };

            }
        });

//        $(".libeffectue").change(function () {
//            var moid = $(this).val();
//
//            $.ajax({
//                url: 'issampages/issametudiant/getmainoeuvre.php',
//                type: 'post',
//                data: {moid: moid},
//                dataType: 'json',
//                success: function (response) {
//
//                    var factjmo = response['factjmo'];
//                    document.getElementById("prixueffectue"+c2.length).value = "";
//                    document.getElementById("prixueffectue"+c2.length).value = factjmo;
//                    CalculTotalMO(c2.length);
//                }
//            });
//        });

    }

    function momoins(b) {
        if (!c2mo[1]) {

            b.style.display = "none";
        }

        if (c2mo[0]) {
            var i = c2mo.length - 1;
            var ta = 0;
            var salb = 0;

            if (document.getElementById("prixteffectue" + i).value != "") {
                ta = parseFloat(document.getElementById("prixteffectue" + i).value);
            }
            if (document.getElementById("salairebase").value != "") {
                salb = parseFloat(document.getElementById("salairebase").value);
            }

            var told = (salb - ta);
            document.getElementById("salairebase").value = (Math.max((((told))), 0)).toFixed(2);


            cmo.removeChild(c2mo[c2mo.length - 1]);
        }
        document.getElementById('nbeffectue').value = c2mo.length;
        lmo = c2mo.length;
    }
    function CalculTotalMOM()
    {
        var p = 0;
        var q = 0;
        var ta = 0;
        var salb = 0;
        if (document.getElementById("nbmeffectue").value != "") {
            q = parseFloat(document.getElementById("nbmeffectue").value);
        }
        if (document.getElementById("prixumeffectue").value != "") {
            p = parseFloat(document.getElementById("prixumeffectue").value);
        }
        if (document.getElementById("prixtmeffectue").value != "") {
            ta = parseFloat(document.getElementById("prixtmeffectue").value);
        }
        if (document.getElementById("salairebase").value != "") {
            salb = parseFloat(document.getElementById("salairebase").value);
        }
        document.getElementById("prixtmeffectue").value = "";

        if (q > 0)
        {
            var t = q * p;
            var told = (salb - ta) + t;
//            Math.max(a,b) donne le plus grand entre a et b
//              toFixed(2) limite à 2 chiffres après la virgule
            document.getElementById("prixtmeffectue").value = (Math.max((((t))), 0)).toFixed(2);
            document.getElementById("salairebase").value = (Math.max((((told))), 0)).toFixed(2);
            changeRemunerationBrute();

        }
    }

</script>
