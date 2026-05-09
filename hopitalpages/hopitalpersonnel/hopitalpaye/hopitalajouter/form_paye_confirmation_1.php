
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
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <fieldset class="space_data"><legend class="titre">Informations de l'Employeur</legend>
                                        Nom ou Raison Sociale : <?php echo $rowecol["hopitalproprietaire"]; ?>
                                        <br>
                                        Adresse : <?php echo $rowecol["adressehopital"]; ?>
                                        <br>
                                        N&deg; Contribuable : <?php echo $rowecol["nocontribuableproprietaire"]; ?>

                                    </fieldset>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6">
                            <fieldset class="space_data"><legend class="titre">Informations de l'Employer</legend>
                                Nom et Pr&eacute;nom du travailleur : <?php echo $_SESSION['formpaye'][1]["nome"]; ?>
                                <br>
                                Num&eacute;ro de pointage : <?php echo $_SESSION['formpaye'][1]["nopointage"]; ?>
                                <br>Emploi occup&eacute; : <?php echo $_SESSION['formpaye'][1]["emploi"]; ?>
                                <br>Date du jour : <?php echo $_SESSION['formpaye'][1]["datejoureffectue"]; ?>
                                <br>Type de payement : <?php echo $_SESSION['formpaye'][1]["typepaiement"]; ?>
                            </fieldset>
                    </div> 
                </div>
                <fieldset class="space_data"><legend class="titre">Pointages</legend>

                    <div id="listeh" style="display:none">
                        <div id="cadremo" style=" font-size: 10px;">
                            <?php
                            ?>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                                    <div class="chosen-select-single">
                                        <label class="control-label" >Pointage &nbsp;</label>
                                        <?php
                                        $typ = "Normal";
                                        $rsltpmo1 = $con->query("select * from hp_pointage as c left join hp_affectation as eg on c.idaffectation=eg.idaffectation "
                                                . "where c.idaffectation='" . $row["idaffectation"] . "' and c.typepointage='" . $typ . "' and c.etatpointage=true and c.payepointage=false") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez un pointage..." name="libeffectue" id="libeffectue"  class=" chosen-select form-control">
                                            <option value="">Choisissez un pointagee</option>

                                            <?php
                                            while ($rowmo = mysqli_fetch_assoc($rsltpmo1)) {
                                                ?>
                                                <option value="<?php echo($rowmo["idpointage"]); ?>" <?php if ($_SESSION['formpaye'][1]['libeffectue'] == $rowmo["idpointage"]) { ?> selected <?php } ?>><?php echo($rowmo["datejourpointage"]); ?> -> <?php echo($rowmo["heuredebutpointage"]); ?> - <?php echo($rowmo["heurefinpointage"]); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">

                                    <label class="control-label" >Quantit&eacute; &nbsp;</label>
                                    <div class="input-group mg-b-pro-edt">
                                        <!--<span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>-->
                                        <input value="<?php echo $_SESSION['formpaye'][1]["nbeffectue"]; ?>" class="" placeholder="" type="text" name="qteeffectue" id="qteeffectue" onkeyup="CalculTotalMO();" />
                                    </div>

                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                                    <label class="control-label" >Montant Unitaire </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <!--<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>-->
                                        <input value="<?php echo $_SESSION['formpaye'][1]["prixueffectue"]; ?>" class="" placeholder="" type="text" name="prixueffectue" id="prixueffectue" readonly onkeyup="CalculTotalMO();" />
                                    </div>

                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                                    <label class="control-label" >Montant Total </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <!--<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>-->
                                        <input value="<?php echo $_SESSION['formpaye'][1]["prixteffectue"]; ?>" class="" placeholder="" type="text" name="prixteffectue" id="prixteffectue" readonly />
                                    </div>

                                </div>
                            </div>
                            <?php
                            ?>
                            <input name="nbeffectue" type="hidden" id="nbeffectue" value="<?php echo $_SESSION['formpaye'][1]['nbeffectue']; ?>">

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type="button" class=" btn-danger" value="Ajouter un pointage" onclick="movplus()" />
                                <input type="button" class=" btn-danger" style="display:none" id="supmo" value="Supprimer un pointage" onclick="momoins(this)" />
                            </div>
                        </div>
                    </div>

                    <div id="listej" style="display:none">
                        <div id="cadremoj" style=" font-size: 10px;">
                            <?php
                            ?>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label" >Jour &nbsp;</label>
                                        <?php
                                        $rsltpmo1j = $con->query("select DISTINCT(c.datejourpointage) as datejour from hp_pointage as c left join hp_affectation as eg on c.idaffectation=eg.idaffectation "
                                                . "where c.idaffectation='" . $row["idaffectation"] . "' and c.typepointage='" . $typ . "' and c.etatpointage=true and c.payepointage=false") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez une date..." name="libjeffectue" id="libjeffectue"  class=" chosen-select form-control">
                                            <option value="">Choisissez une date</option>

                                            <?php
                                            while ($rowmo = mysqli_fetch_assoc($rsltpmo1j)) {
                                                ?>
                                                <option value="<?php echo($rowmo["datejour"]); ?>" <?php if ($_SESSION['formpaye'][1]['libjeffectue'] == $rowmo["datejour"]) { ?> selected <?php } ?>><?php echo($rowmo["datejour"]); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                                    <label class="control-label" >Montant </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <!--<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>-->
                                        <!--<input value="<?php echo $_SESSION['formpaye'][1]["prixjeffectue2"]; ?>" class="" placeholder="" type="text" name="prixjeffectue2" id="prixjeffectue2"/>-->
                                        <input value="<?php echo $_SESSION['formpaye'][1]["prixjeffectue"]; ?>" class="" placeholder="" type="text" name="prixjeffectue" id="prixjeffectue" readonly onkeyup="CalculTotalMOj();" />
                                    </div>

                                </div>
                            </div>
                            <?php
                            ?>
                            <input name="nbjeffectue" type="hidden" id="nbjeffectue" value="<?php echo $_SESSION['formpaye'][1]['nbjeffectue']; ?>">

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type="button" class=" btn-danger" value="Ajouter une date" onclick="mojvplus()" />
                                <input type="button" class=" btn-danger" style="display:none" id="supmoj" value="Supprimer une date" onclick="mojmoins(this)" />
                            </div>
                        </div>
                    </div>

                    <div id="listem" style="display:none">
                        <div id="cadremom" >
                            <?php
                            ?>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label for="periode" class="control-label">Mois d&eacute;but <g>*</g></label>
                                        <div class="input-group date periode" data-date="" data-date-format="MM yyyy" data-link-field="periode" data-link-format="MM yyyy">
                                            <input class="form-control" size="16" type="text" value="" readonly>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                        <input class="form-control" type="hidden" id="periode" name="libmeffectue" value="<?php echo $_SESSION['formpaye'][1]["libmeffectue"]; ?>"  /><br/> 
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                                    <label class="control-label" >Nombre de mois </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home" aria-hidden="true"></i></span>
                                        <input value="<?php echo $_SESSION['formpaye'][1]["nbmeffectue"]; ?>" class="form-control" placeholder="" type="text" name="nbmeffectue" id="nbmeffectue" onkeyup="CalculTotalMOM();" />
                                    </div>

                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                                    <label class="control-label" >Montant /Mois </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card" aria-hidden="true"></i></span>
                                        <input value="<?php echo $_SESSION['formpaye'][1]["prixumeffectue"]; ?>" class="form-control" placeholder="" type="text" name="prixumeffectue" id="prixumeffectue" readonly/>
                                    </div>

                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                                    <label class="control-label" >Montant total </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card" aria-hidden="true"></i></span>
                                        <input value="<?php echo $_SESSION['formpaye'][1]["prixtmeffectue"]; ?>" class="form-control" placeholder="" type="text" name="prixtmeffectue" id="prixtmeffectue" readonly />
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </fieldset>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                <fieldset class="space_data"><legend class="titre"></legend>
                    Salaire de base : <?php echo $_SESSION['formpaye'][1]["salairebase"]; ?>
                </fieldset>
                            </div>
                        </div>
                            <br>
                <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            Heures suplementaires : <?php echo $_SESSION['formpaye'][1]["heuresup"]; ?>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-2">
                            Heure Sup &agrave; 15% &agrave; : <?php echo $_SESSION['formpaye'][1]["heure15"]; ?>
                        </div>
                        <div class="col-sm-2">
                            Heure Sup &agrave; 20% &agrave; : <?php echo $_SESSION['formpaye'][1]["heure20"]; ?>
                        </div> 
                        <div class="col-sm-2">
                           Heure Sup &agrave; 30% &agrave; : <?php echo $_SESSION['formpaye'][1]["heure30"]; ?>
                        </div> 
                        <div class="col-sm-3">
                            Heure Sup &agrave; 40% &agrave; : <?php echo $_SESSION['formpaye'][1]["heure40"]; ?>
                        </div>
                        <div class="col-sm-3">
                            Heure Sup &agrave; 50% &agrave; : <?php echo $_SESSION['formpaye'][1]["heure50"]; ?>
                        </div>
                    </div>
                            <br>
               <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            Primes : <?php echo $_SESSION['formpaye'][1]["prime"]; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            Ancienn&eacute;t&eacute; : <?php echo $_SESSION['formpaye'][1]["anciennep"]; ?>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            Rendement : <?php echo $_SESSION['formpaye'][1]["rendementp"]; ?>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            Logement : <?php echo $_SESSION['formpaye'][1]["logementp"]; ?>
                        </div>
                    </div>
                            <br>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            Indemnit&eacute;s : <?php echo $_SESSION['formpaye'][1]["indemnite"]; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            Caisse : <?php echo $_SESSION['formpaye'][1]["caissei"]; ?>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            Deplacement : <?php echo $_SESSION['formpaye'][1]["deplacementi"]; ?>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Repr&eacute;sentation : <?php echo $_SESSION['formpaye'][1]["representationi"]; ?> 
                        </div>
                    </div>
                            <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                             (1) R&eacute;mun&eacute;ration Brute : <?php echo $_SESSION['formpaye'][1]["remunerationbrute"]; ?> 
                        </div>
                    </div>
                            <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                             (a) Retenues Fiscales : <?php echo $_SESSION['formpaye'][1]["retenuefiscales"]; ?>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             I.R.P.P : <?php echo $_SESSION['formpaye'][1]["irpp"]; ?> 
                        </div> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             C.A.C : <?php echo $_SESSION['formpaye'][1]["cac"]; ?> 
                        </div> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Taxe Communale : <?php echo $_SESSION['formpaye'][1]["taxec"]; ?> 
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Redevance Audio Visuelle : <?php echo $_SESSION['formpaye'][1]["redevanceaudio"]; ?> 
                        </div> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Cr&eacute;dit Foncier : <?php echo $_SESSION['formpaye'][1]["creditf"]; ?> 
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Fond National de l'Emploi : <?php echo $_SESSION['formpaye'][1]["fne"]; ?> 
                        </div>
                    </div>
                            <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                             (b) Retenues Sociales : <?php echo $_SESSION['formpaye'][1]["retenuesociales"]; ?> 
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             PV&ID (CNPS) : <?php echo $_SESSION['formpaye'][1]["cnps"]; ?> 
                        </div> 
                    </div>
                            <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                             (c) Autres Retenues : <?php echo $_SESSION['formpaye'][1]["autresretenue"]; ?> 
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Acompte sur salaire : <?php echo $_SESSION['formpaye'][1]["acomptes"]; ?> 
                        </div> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Avance et autres pr&ecirc;ts : <?php echo $_SESSION['formpaye'][1]["avancee"]; ?> 
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Saisies arr&ecirc;ts : <?php echo $_SESSION['formpaye'][1]["saisiearret"]; ?> 
                        </div> 
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Cotisation Syndicale : <?php echo $_SESSION['formpaye'][1]["cotisations"]; ?> 
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                             Autres : <?php echo $_SESSION['formpaye'][1]["autre"]; ?> 
                        </div> 
                    </div>
                            <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                             (2) Total des retenues &agrave; &eacute;ffectuer (a)+(b)+(c) : <?php echo $_SESSION['formpaye'][1]["totalretenue"]; ?>
                        </div>
                    </div>
                            <br>
                            <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            NET A PAYER (1)-(2) : <?php echo $_SESSION['formpaye'][1]["netapayer"]; ?>
                        </div>
                    </div>
                            <br>
                <div class="row">
                    <div class="col-sm-6">
                        <b style="color: red">Champs Obligatoires *</b>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" name="insproduit" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                        <button type="reset" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
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
