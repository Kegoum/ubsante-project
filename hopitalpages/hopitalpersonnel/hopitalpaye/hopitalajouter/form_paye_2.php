<script type="text/javascript">

    /* On crée la fonction qui va construire la seconde liste déroulante */
    window.onload = function() {
        changeRemunerationBrute();
        changeHeureSup();
        changePrime();
        changeIndemnite()
        changeRetenueFiscale();
        changeRetenueSociale();
        changeAutreRetenue();
    };
    function changeRemunerationBrute()
    {
        var salairebase = parseInt(document.getElementById("salairebase").value);
        var heuresup = parseInt(document.getElementById("heuresup").value);
        var prime = parseInt(document.getElementById("prime").value);
        var indemnite = parseInt(document.getElementById("indemnite").value);
        if (isNaN(salairebase) == true) {
            salairebase = 0;
        }
        if (isNaN(heuresup) == true) {
            heuresup = 0;
        }
        if (isNaN(prime) == true) {
            prime = 0;
        }
        if (isNaN(indemnite) == true) {
            indemnite = 0;
        }
        if (salairebase != 0)
        {
            var totalretenue = parseInt(document.getElementById("totalretenue").value);
            if (isNaN(totalretenue) == true) {
                totalretenue = 0;
            }
            var remunerationbrute = salairebase + heuresup + prime + indemnite;
            var netapayer = remunerationbrute - totalretenue;
            document.getElementById("remunerationbrute").value = remunerationbrute;
            document.getElementById("netapayer").value = netapayer;
        }
    }

    function changeHeureSup()
    {
        var heure15 = parseInt(document.getElementById("heure15").value);
        var heure20 = parseInt(document.getElementById("heure20").value);
        var heure30 = parseInt(document.getElementById("heure30").value);
        var heure40 = parseInt(document.getElementById("heure40").value);
        var heure50 = parseInt(document.getElementById("heure50").value);
        if (isNaN(heure15) == true) {
            heure15 = 0;
        }
        if (isNaN(heure20) == true) {
            heure20 = 0;
        }
        if (isNaN(heure30) == true) {
            heure30 = 0;
        }
        if (isNaN(heure40) == true) {
            heure40 = 0;
        }
        if (isNaN(heure50) == true) {
            heure50 = 0;
        }
        var salairebase = parseInt(document.getElementById("salairebase").value);
        var heuresup = heure15 + heure20 + heure30 + heure40 + heure50;
        var prime = parseInt(document.getElementById("prime").value);
        var indemnite = parseInt(document.getElementById("indemnite").value);
        if (isNaN(salairebase) == true) {
            salairebase = 0;
        }
        if (isNaN(prime) == true) {
            prime = 0;
        }
        if (isNaN(indemnite) == true) {
            indemnite = 0;
        }
        var totalretenue = parseInt(document.getElementById("totalretenue").value);
        if (isNaN(totalretenue) == true) {
            totalretenue = 0;
        }
        var remunerationbrute = salairebase + heuresup + prime + indemnite;
        var netapayer = remunerationbrute - totalretenue;
        document.getElementById("heuresup").value = heuresup;
        document.getElementById("remunerationbrute").value = remunerationbrute;
        document.getElementById("netapayer").value = netapayer;
    }

    function changePrime()
    {
        var anciennep = parseInt(document.getElementById("anciennep").value);
        var rendementp = parseInt(document.getElementById("rendementp").value);
        var logementp = parseInt(document.getElementById("logementp").value);
        if (isNaN(anciennep) == true) {
            anciennep = 0;
        }
        if (isNaN(rendementp) == true) {
            rendementp = 0;
        }
        if (isNaN(logementp) == true) {
            logementp = 0;
        }
        var salairebase = parseInt(document.getElementById("salairebase").value);
        var heuresup = parseInt(document.getElementById("heuresup").value);
        var prime = anciennep + rendementp + logementp;
        var indemnite = parseInt(document.getElementById("indemnite").value);
        if (isNaN(salairebase) == true) {
            salairebase = 0;
        }
        if (isNaN(heuresup) == true) {
            heuresup = 0;
        }
        if (isNaN(indemnite) == true) {
            indemnite = 0;
        }
        var totalretenue = parseInt(document.getElementById("totalretenue").value);
        if (isNaN(totalretenue) == true) {
            totalretenue = 0;
        }
        var remunerationbrute = salairebase + heuresup + prime + indemnite;
        var netapayer = remunerationbrute - totalretenue;
        document.getElementById("prime").value = prime;
        document.getElementById("remunerationbrute").value = remunerationbrute;
        document.getElementById("netapayer").value = netapayer;
    }

    function changeIndemnite()
    {
        var caissei = parseInt(document.getElementById("caissei").value);
        var deplacementi = parseInt(document.getElementById("deplacementi").value);
        var representationi = parseInt(document.getElementById("representationi").value);
        var salairebase = parseInt(document.getElementById("salairebase").value);
        var heuresup = parseInt(document.getElementById("heuresup").value);
        var prime = parseInt(document.getElementById("prime").value);
        if (isNaN(caissei) == true) {
            caissei = 0;
        }
        if (isNaN(deplacementi) == true) {
            deplacementi = 0;
        }
        if (isNaN(representationi) == true) {
            representationi = 0;
        }
        if (isNaN(salairebase) == true) {
            salairebase = 0;
        }
        if (isNaN(heuresup) == true) {
            heuresup = 0;
        }
        if (isNaN(prime) == true) {
            prime = 0;
        }
        var indemnite = caissei + deplacementi + representationi;
        var totalretenue = parseInt(document.getElementById("totalretenue").value);
        if (isNaN(totalretenue) == true) {
            totalretenue = 0;
        }
        var remunerationbrute = salairebase + heuresup + prime + indemnite;
        var netapayer = remunerationbrute - totalretenue;
        document.getElementById("indemnite").value = indemnite;
        document.getElementById("remunerationbrute").value = remunerationbrute;
        document.getElementById("netapayer").value = netapayer;
    }

    function changeRetenueFiscale()
    {
        var irpp = parseInt(document.getElementById("irpp").value);
        var cac = parseInt(document.getElementById("cac").value);
        var taxec = parseInt(document.getElementById("taxec").value);
        var redevanceaudio = parseInt(document.getElementById("redevanceaudio").value);
        var creditf = parseInt(document.getElementById("creditf").value);
        var fne = parseInt(document.getElementById("fne").value);
        var retenuesociales = parseInt(document.getElementById("retenuesociales").value);
        var autresretenue = parseInt(document.getElementById("autresretenue").value);
        if (isNaN(irpp) == true) {
            irpp = 0;
        }
        if (isNaN(cac) == true) {
            cac = 0;
        }
        if (isNaN(taxec) == true) {
            taxec = 0;
        }
        if (isNaN(redevanceaudio) == true) {
            redevanceaudio = 0;
        }
        if (isNaN(creditf) == true) {
            creditf = 0;
        }
        if (isNaN(fne) == true) {
            fne = 0;
        }
        if (isNaN(retenuesociales) == true) {
            retenuesociales = 0;
        }
        if (isNaN(autresretenue) == true) {
            autresretenue = 0;
        }
        var retenuefiscales = irpp + cac + taxec + redevanceaudio + creditf + fne;
        var remunerationbrute = parseInt(document.getElementById("remunerationbrute").value);
        if (isNaN(remunerationbrute) == true) {
            remunerationbrute = 0;
        }
        var totalretenue = retenuefiscales + retenuesociales + autresretenue;
        var netapayer = remunerationbrute - totalretenue;
        document.getElementById("retenuefiscales").value = retenuefiscales;
        document.getElementById("totalretenue").value = totalretenue;
        document.getElementById("netapayer").value = netapayer;
    }

    function changeRetenueSociale()
    {
        var cnps = parseInt(document.getElementById("cnps").value);
        var retenuefiscales = parseInt(document.getElementById("retenuefiscales").value);
        var autresretenue = parseInt(document.getElementById("autresretenue").value);
        if (isNaN(cnps) == true) {
            cnps = 0;
        }
        if (isNaN(retenuefiscales) == true) {
            retenuefiscales = 0;
        }
        if (isNaN(autresretenue) == true) {
            autresretenue = 0;
        }
        var retenuesociales = cnps;
        var remunerationbrute = parseInt(document.getElementById("remunerationbrute").value);
        if (isNaN(remunerationbrute) == true) {
            remunerationbrute = 0;
        }
        var totalretenue = retenuefiscales + retenuesociales + autresretenue;
        var netapayer = remunerationbrute - totalretenue;
        document.getElementById("retenuesociales").value = retenuesociales;
        document.getElementById("totalretenue").value = totalretenue;
        document.getElementById("netapayer").value = netapayer;
    }

    function changeAutreRetenue()
    {
        var acomptes = parseInt(document.getElementById("acomptes").value);
        var avancee = parseInt(document.getElementById("avancee").value);
        var saisiearret = parseInt(document.getElementById("saisiearret").value);
        var cotisations = parseInt(document.getElementById("cotisations").value);
        var autre = parseInt(document.getElementById("autre").value);
        var retenuesociales = parseInt(document.getElementById("retenuesociales").value);
        var retenuefiscales = parseInt(document.getElementById("retenuefiscales").value);
        if (isNaN(acomptes) == true) {
            acomptes = 0;
        }
        if (isNaN(avancee) == true) {
            avancee = 0;
        }
        if (isNaN(saisiearret) == true) {
            saisiearret = 0;
        }
        if (isNaN(cotisations) == true) {
            cotisations = 0;
        }
        if (isNaN(autre) == true) {
            autre = 0;
        }
        if (isNaN(retenuesociales) == true) {
            retenuesociales = 0;
        }
        if (isNaN(retenuefiscales) == true) {
            retenuefiscales = 0;
        }
        var autresretenue = acomptes + avancee + saisiearret + cotisations + autre;
        var remunerationbrute = parseInt(document.getElementById("remunerationbrute").value);
        if (isNaN(remunerationbrute) == true) {
            remunerationbrute = 0;
        }
        var totalretenue = retenuefiscales + retenuesociales + autresretenue;
        var netapayer = remunerationbrute - totalretenue;
        document.getElementById("autresretenue").value = autresretenue;
        document.getElementById("totalretenue").value = totalretenue;
        document.getElementById("netapayer").value = netapayer;
    }
</script>

<div class="row">
    <div class="col-sm-12">
        <h2>Gestion des Paies</h2>
        <h2>Bulletin de Paie de l'enseignant <small> <?php echo $row["nom"]; ?> <?php echo $row["prenom"]; ?> - <?php echo $row["tel"]; ?></small></h2>

        <form id="ajout_prod" name="form" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('ubschoolpages/ubschoolenseignant/ubschoolpaye/ubschoolajouter/insert_paye'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&enseignant=<?php echo $_REQUEST["enseignant"] ?>">

            <fieldset class="space_data"><legend class="titre">Informations de l'Employeur</legend>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            Nom ou Raison Sociale : <?php echo $rowecol["nomecole"]; ?>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            Adresse : <?php echo $rowecol["adresse"]; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            N&deg; CNPS : 
                            <?php echo $rowecol["nocnps"]; ?>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            N&deg; Contribuable : <?php echo $rowecol["nocontribuable"]; ?>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="space_data"><legend class="titre">Informations de l'Employer</legend>
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <label>Paye du :</label>
                            <input name="datedebutp" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["datedebutp"]; ?>" placeholder="Date debut paiement" type="date" class="form-control" id="datedebutp" data-date-format="yyyy-mm-dd" required>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <label>au :</label>
                            <input name="datefinp" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["datefinp"]; ?>" placeholder="Date fin payement" type="date" class="form-control" id="datefinp" data-date-format="yyyy-mm-dd" required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Nom et Pr&eacute;nom du travailleur :</label>
                            <input name="nome" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["nome"]; ?>" type="text" class="form-control" id="nomp" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <label>Num&eacute;ro de pointage :</label>
                            <input name="nopointage" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["nopointage"]; ?>" id="nopointage" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <label>Emploi occup&eacute; :</label>
                            <input name="emploi" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["emploi"]; ?>" type="text" class="form-control" id="emploi" required>

                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <label>N&deg; Contribuable de l'employ&eacute; :</label>
                            <input name="nocontribuablee" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["nocontribuablee"]; ?>" id="nocontribuablee" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <label>N&deg; CNPS de l'employ&eacute; :</label>
                            <input name="nocnpse" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["nocnpse"]; ?>" id="nocnpse" type="text" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="space_data"><legend class="titre">Cours Effectu&eacute;s</legend>
                <div id="cadremo" style=" font-size: 10px;">
                    <?php
                    ?>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <?php
//                        $rsltp = $con->query("select * from smsmodepaiement as mp left join smsbanque as b on mp.idbanque=b.idbanque "
//                                . "left join smscampus as c on mp.idcampus=c.idcampus") or die(mysqli_error($con));
                            ?>
                            <div class="chosen-select-single">
                                <label class="control-label">Mode de paiement &nbsp;<g>*</g></label>
                                <select data-placeholder="Choisissez un Mode de paiement..." class="select2_demo_3 form-control" name="paiementcourseffectue" id="paiementcourseffectue" >
                                    <option value=""> - Choisissez le Mode de paiement - </option>
                                    <?php
//                                while ($rowp = mysqli_fetch_assoc($rsltp)) {
                                    ?>
                                        <!--<option value="<?php echo $rowp["idmodepaiement"]; ?>" <?php if ($rowp["idmodepaiement"] == $_SESSION['formpaye'][NUM_PAGE]["paiementcourseffectue"]) { ?> selected <?php } ?>><?php echo $rowp["libellemodepaiement"]; ?> - <?php echo $rowp["libellebanque"]; ?> - <?php echo $rowp["libellecampus"]; ?></option>-->
                                    <?php
//                                }
                                    ?>
                                </select>
                            </div>
                        </div> 
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Num&eacute;ro du re&ccedil;u</label>
                                <input name="numbanquecourseffectue" autocomplete="off" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["numbanquecourseffectue"]; ?>"  placeholder="Re&ccedil;u de la banque" type="text" class="form-control" id="numbanquecourseffectue">
                            </div>
                        </div>  
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Date du jour</label>
                                <input name="datejourcourseffectue" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["datejourcourseffectue"]; ?>"  placeholder="date de paiement" type="date" class="form-control" id="datejourcourseffectue">
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                            <div class="chosen-select-single">
                                <label class="control-label" >Heure Effectu&eacute; &nbsp;</label>
                                <?php
                                $rsltpmo1 = $con->query("select * from courseffectue as c left join enseignement as eg on c.idenseignement=eg.idenseignement "
                                        . "where c.etatce=true and c.payerce=false") or die(mysqli_error($con));
                                ?>
                                <select data-placeholder="Choisissez une Heure Effectu&eacute;..." name="libcourseffectue" id="libcourseffectue"  class=" chosen-select form-control">
                                    <option value="">Choisissez une Heure Effectu&eacute;</option>

                                    <?php
                                    while ($rowmo = mysqli_fetch_assoc($rsltpmo1)) {
                                        $rsltmc = $con->query("select * from matiereclasse as mc left join matiere as c on mc.idmatiere=c.idmatiere "
                                                . "where mc.idmatiereclasse='" . $rowmo["idmatiereclasse"] . "' ") or die(mysqli_error($con));
                                        $rowmc = mysqli_fetch_assoc($rsltmc);
                                        ?>
                                        <option value="<?php echo($rowmo["idcourseffectue"]); ?>" <?php if ($_SESSION['formpaye'][NUM_PAGE]['libcourseffectue'] == $rowmo["idcourseffectue"]) { ?> selected <?php } ?>><?php echo($rowmc["intitule"]); ?> - <?php echo($rowmo["heurecourse"]); ?></option>
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
                                <input value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["nbcourseffectue"]; ?>" class="" placeholder="" type="text" name="qtecourseffectue" id="qtecourseffectue" onkeyup="CalculTotalMO();" />
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                            <label class="control-label" >Prix Unitaire </label>
                            <div class="input-group mg-b-pro-edt">
                                <!--<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>-->
                                <input value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["prixucourseffectue"]; ?>" class="" placeholder="" type="text" name="prixucourseffectue" id="prixucourseffectue" readonly onkeyup="CalculTotalMO();" />
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">

                            <label class="control-label" >Prix Total </label>
                            <div class="input-group mg-b-pro-edt">
                                <!--<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>-->
                                <input value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["prixtcourseffectue"]; ?>" class="" placeholder="" type="text" name="prixtcourseffectue" id="prixtcourseffectue" readonly />
                            </div>

                        </div>
                    </div>
                    <?php
                    ?>
                    <input name="nbcourseffectue" type="hidden" id="nbcourseffectue" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]['nbcourseffectue']; ?>">

                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="button" class=" btn-danger" value="Ajouter un cours effectu&eacute;" onclick="movplus()" />
                        <input type="button" class=" btn-danger" style="display:none" id="supmo" value="Supprimer un cours effectu&eacute;" onclick="momoins(this)" />
                    </div>
                </div>
            </fieldset>
            <fieldset class="space_data"><legend class="titre"></legend>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Salaire de base :</label>
                            <input name="salairebase" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["salairebase"]; ?>" onblur="changeRemunerationBrute();" pattern="^([0-9]+)$" maxlength="254" placeholder="Salaire" type="number" class="form-control" id="salairebase">
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="space_data"><legend class="titre">Heures suplementaires</legend>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Heures suplementaires :</label>
                            <input name="heuresup" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["heuresup"]; ?>" id="heuresup" onblur="changeRemunerationBrute();" pattern="^([0-9]+)$" maxlength="254"  placeholder="" type="number" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Heure Sup &agrave; 15% &agrave; :</label>
                            <input name="heure15" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["heure15"]; ?>" id="heure15" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254"  placeholder="Heure Sup &agrave; 15% &agrave;" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Heure Sup &agrave; 20% &agrave; :</label>
                            <input name="heure20" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["heure20"]; ?>" id="heure20" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254" placeholder="Heure Sup &agrave; 20% &agrave;" type="number" class="form-control">
                        </div>
                    </div> 
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Heure Sup &agrave; 30% &agrave; :</label>
                            <input name="heure30" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["heure30"]; ?>" id="heure30" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254" placeholder="Heure Sup &agrave; 30% &agrave;" type="number" class="form-control">
                        </div>
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Heure Sup &agrave; 40% &agrave; :</label>
                            <input name="heure40" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["heure40"]; ?>" id="heure40" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254" placeholder="Heure Sup &agrave; 40% &agrave;" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Heure Sup &agrave; 50% &agrave; :</label>
                            <input name="heure50" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["heure50"]; ?>" id="heure50" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254" placeholder="Heure Sup &agrave; 50% &agrave;" type="number" class="form-control">
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="space_data"><legend class="titre">Primes</legend>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Primes :</label>
                            <input name="prime" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["prime"]; ?>" id="prime" onblur="changeRemunerationBrute();" pattern="^([0-9]+)$" maxlength="254"  placeholder="" type="number" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Ancienn&eacute;t&eacute; :</label>
                            <input name="anciennep" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["anciennep"]; ?>" id="anciennep" onblur="changePrime();" pattern="^([0-9]+)$" maxlength="254" placeholder="ancienne" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Rendement :</label>
                            <input name="rendementp" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["rendementp"]; ?>" id="rendementp" onblur="changePrime();" placeholder="rendement" pattern="^([0-9]+)$" maxlength="254" type="number" class="form-control" >
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Logement :</label>
                            <input name="logementp" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["logementp"]; ?>" id="logementp" onblur="changePrime();" placeholder="logement" pattern="^([0-9]+)$" maxlength="254" type="number" class="form-control" >
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="space_data"><legend class="titre">Indemnit&eacute;s</legend>
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Indemnit&eacute;s :</label>
                            <input name="indemnite" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["indemnite"]; ?>" id="indemnite" onblur="changeRemunerationBrute();" pattern="^([0-9]+)$" maxlength="254"  placeholder="" type="number" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Caisse :</label>
                            <input name="caissei" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["caissei"]; ?>" id="caissei" onblur="changeIndemnite();" pattern="^([0-9]+)$" maxlength="254" placeholder="Caisse" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Deplacement :</label>
                            <input name="deplacementi" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["deplacementi"]; ?>" id="deplacementi" onblur="changeIndemnite();" placeholder="deplacement" pattern="^([0-9]+)$" maxlength="254" type="number" class="form-control" >
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Repr&eacute;sentation :</label>
                            <input name="representationi" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["representationi"]; ?>" id="representationi" onblur="changeIndemnite();" placeholder="representation" pattern="^([0-9]+)$" maxlength="254" type="number" class="form-control" >
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="space_data"><legend class="titre"></legend>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>(1) R&eacute;mun&eacute;ration Brute :</label>
                            <input name="remunerationbrute" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["remunerationbrute"]; ?>" pattern="^([0-9]+)$" maxlength="254" placeholder="R&eacute;mun&eacute;ration Brute" type="number" class="form-control" id="remunerationbrute" readonly>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="space_data"><legend class="titre">Retenues</legend>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>(a) Retenues Fiscales :</label>
                            <input name="retenuefiscales" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["retenuefiscales"]; ?>" pattern="^([0-9]+)$" maxlength="254" placeholder="Retenues Fiscales" type="number" class="form-control" id="retenuefiscales" readonly >
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>I.R.P.P :</label>
                            <input name="irpp" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["irpp"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" value="" type="number" class="form-control" id="irpp">
                        </div>
                    </div> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>C.A.C :</label>
                            <input name="cac" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["cac"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9.]+)$" maxlength="254" value="" type="number" class="form-control" id="cac">
                        </div>
                    </div> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Taxe Communale :</label>
                            <input name="taxec" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["taxec"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" value="" type="number" class="form-control" id="taxec">
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Redevance Audio Visuelle :</label>
                            <input name="redevanceaudio" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["redevanceaudio"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control" id="redevanceaudio">
                        </div>
                    </div> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Cr&eacute;dit Foncier :</label>
                            <input name="creditf" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["creditf"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" placeholder="Cr&eacute;dit Foncier" type="number" class="form-control" id="creditf">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Fond National de l'Emploi :</label>
                            <input name="fne" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["fne"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control" id="fne">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>(b) Retenues Sociales :</label>
                            <input name="retenuesociales" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["retenuesociales"]; ?>" pattern="^([0-9]+)$" maxlength="254" placeholder="Retenues Fiscales" type="number" class="form-control" id="retenuesociales" readonly>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>PV&ID (CNPS) :</label>
                            <input name="cnps" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["cnps"]; ?>" onblur="changeRetenueSociale();" pattern="^([0-9]+)$" maxlength="254" value="" type="number" class="form-control" id="cnps">
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>(c) Autres Retenues :</label>
                            <input name="autresretenue" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["autresretenue"]; ?>" pattern="^([0-9]+)$" maxlength="254" placeholder="Retenues" type="number" class="form-control" id="autresretenue" readonly>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Acompte sur salaire :</label>
                            <input name="acomptes" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["acomptes"]; ?>" id="acomptes" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254"  placeholder="Acompte" type="number" class="form-control">
                        </div>
                    </div> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Avance et autres pr&ecirc;ts :</label>
                            <input name="avancee" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["avancee"]; ?>" id="avancee" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254"  placeholder="Avance" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Saisies arr&ecirc;ts :</label>
                            <input name="saisiearret" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["saisiearret"]; ?>" id="saisiearret" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254" value="" type="number" class="form-control">
                        </div>
                    </div> 
                </div>
                <div class="row"> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Cotisation Syndicale :</label>
                            <input name="cotisations" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["cotisations"]; ?>" id="cotisations" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254" placeholder="Cotisation Syndicale" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Autres :</label>
                            <input name="autre" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["autre"]; ?>" id="autre" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control">
                        </div>
                    </div> 
                </div>
            </fieldset>
            <fieldset class="space_data"><legend class="titre"></legend>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>(2) Total des retenues &agrave; &eacute;ffectuer (a)+(b)+(c) :</label>
                            <input name="totalretenue" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["totalretenue"]; ?>" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control" id="totalretenue" readonly>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="space_data"><legend class="titre"></legend>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>NET A PAYER (1)-(2) :</label>
                            <input name="netapayer" value="<?php echo $_SESSION['formpaye'][NUM_PAGE]["netapayer"]; ?>" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control" id="netapayer" readonly required>
                        </div>
                    </div>
                </div>
            </fieldset>
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

<script type="text/javascript">
    $(document).ready(function() {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
        $('#ajout_etudiant').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nom: {
                    message: 'Nom de l\'etudiant invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de l\'etudiant est obligatoire'
                        }
                    }
                },
                depor: {
                    message: 'Département de l\'etudiant invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le Département de l\'etudiant est obligatoire'
                        }
                    }
                },
                prenom: {
                    message: 'Prenom de l\'etudiant invalide',
                    validators: {
                    }
                },
                photo: {
                    validators: {
                        file: {
//                        extension: 'png',
//                        extension: {'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF'},
//                        extension: ('png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF'),
//                        extension: ('png', 'JPEG'),
//                        maxSize: 5*1024*1024,
                            message: 'Veuillez choisir une taille inferieur à 5M'
                        }
                    }
                },
                tel: {
                    message: 'Téléphone de l\'etudiant invalide',
                    validators: {
                        stringLength: {
                            min: 9,
                            max: 9,
                            message: 'Le Téléphone de l\'etudiant doit avoir au 9 characteres de long'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Le Téléphone de l\'etudiant doit être un nombre'
                        }
                    }
                },
            }
        });
        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_etudiant').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_etudiant').data('bootstrapValidator').resetForm(true);
//    });
    });

    $(document).ready(function() {

        $("#libcourseffectue").change(function() {
            var moid = $(this).val();
//            alert(moid);
            $.ajax({
                url: 'ubschoolpages/ubschoolenseignant/ubschoolpaye/getprixcourseffectue.php',
                type: 'post',
                data: {moid: moid},
                dataType: 'json',
                success: function(response) {
                    var factjmo = response['prixu'];
                    document.getElementById("prixucourseffectue").value = "";
                    document.getElementById("prixucourseffectue").value = factjmo;
                    CalculTotalMO();
                }
            });
        });

    });

    function CalculTotalMON(i)
    {
        document.getElementById("prixtcourseffectue" + i).value = "";
        var q = parseFloat(document.getElementById("qtecourseffectue" + i).value);
        var p = parseFloat(document.getElementById("prixucourseffectue" + i).value);
        if (p > 0)
        {
            var t = q * p;
//            Math.max(a,b) donne le plus grand entre a et b
//              toFixed(2) limite à 2 chiffres après la virgule
            document.getElementById("prixtcourseffectue" + i).value = (Math.max((((t))), 0)).toFixed(2);

        }
    }
    function CalculTotalMO()
    {
        document.getElementById("prixtcourseffectue").value = "";
        var q = parseFloat(document.getElementById("qtecourseffectue").value);
        var p = parseFloat(document.getElementById("prixucourseffectue").value);
        if (p > 0)
        {
            var t = q * p;
//            Math.max(a,b) donne le plus grand entre a et b
//              toFixed(2) limite à 2 chiffres après la virgule
            document.getElementById("prixtcourseffectue").value = (Math.max((((t))), 0)).toFixed(2);

        }
    }

    var cmo, c2mo, d1mo, d2mo, d3mo, d4mo, d7mo, d8mo, d9mo, d10mo, chmo, chmo1, chmo3,
            labelmo, labelmo1,
            labelmo3, labelmo4, dmo, selectmo, dselmo;

    function movplus() {
        alert("dfdf");
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

        labelmo = document.createTextNode("Accessoire : ");
        labelmo1 = document.createTextNode("Quantité : ");
        labelmo2 = document.createTextNode("Durée (H) : ");
        labelmo3 = document.createTextNode("Prix Unitaire : ");
        labelmo4 = document.createTextNode("Prix Total : ");

        dmo.setAttribute("class", "row");
        d1mo.setAttribute("class", "col-lg-4 col-md-4 col-sm-6 col-xs-12");
        d2mo.setAttribute("class", "chosen-select-single");
        d3mo.setAttribute("class", "col-lg-2 col-md-2 col-sm-3 col-xs-6");
        d4mo.setAttribute("class", "input-group mg-b-pro-edt");

        d7mo.setAttribute("class", "col-lg-3 col-md-3 col-sm-3 col-xs-6");
        d8mo.setAttribute("class", "input-group mg-b-pro-edt");
        d9mo.setAttribute("class", "col-lg-3 col-md-3 col-sm-3 col-xs-6");
        d10mo.setAttribute("class", "input-group mg-b-pro-edt");

        selectmo.setAttribute("class", "chosen-select form-control libcourseffectuen");
        selectmo.setAttribute("name", "libcourseffectue" + c2mo.length);
        selectmo.setAttribute("id", c2mo.length);

        theOption = document.createElement("OPTION");
        theText = document.createTextNode(" -Choisissez un Accessoire- ");
        theOption.setAttribute("value", "");
        theOption.appendChild(theText);

        selectmo.appendChild(theOption);


        chmo.setAttribute("type", "text");
        chmo.setAttribute("class", "");
        chmo.setAttribute("name", "qtecourseffectue" + c2mo.length);
        chmo.setAttribute("id", "qtecourseffectue" + c2mo.length);
        chmo.setAttribute("value", "");
        chmo.setAttribute("onkeyup", "CalculTotalMON(" + c2mo.length + ");");

        chmo1.setAttribute("type", "text");
        chmo1.setAttribute("class", "");
        chmo1.setAttribute("name", "prixucourseffectue" + c2mo.length);
        chmo1.setAttribute("id", "prixucourseffectue" + c2mo.length);
        chmo1.setAttribute("value", "");
        chmo1.setAttribute("onkeyup", "CalculTotalMON(" + c2mo.length + ");");

        chmo3.setAttribute("type", "text");
        chmo3.setAttribute("class", "");
        chmo3.setAttribute("name", "prixtcourseffectue" + c2mo.length);
        chmo3.setAttribute("id", "prixtcourseffectue" + c2mo.length);
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
        document.getElementById('nbcourseffectue').value = c2mo.length;
        lmo = c2mo.length;

//alert(cstr);
        $.ajax({
            url: 'ubschoolpages/ubschoolenseignant/ubschoolpaye/getcourseffectue.php', ,
                    type: 'post',
//            data: {cstra: cstr},
            dataType: 'json',
            success: function(response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['idmo'];
                    var refmo = response[i]['lib'];
                    var name = response[i]['prix'];
                    var nname = refmo + " - " + name;

//                            $("#libcourseffectue" + c2.length).append("<option value='"+id+"'>"+refmo+" - "+name+"</option>");
                    var servi = nname.replace(/&#039;/gi, "\'");

                    theOption = document.createElement("OPTION");
                    theText = document.createTextNode(servi);
                    theOption.setAttribute("value", id);
                    theOption.appendChild(theText);

                    selectmo.appendChild(theOption);

                }

                selectmo.onchange = function() {
                    var moid = $(this).val();

                    var moid2 = $(this).attr('id');
                    var num = moid2.substring(6);

                    $.ajax({
                url: 'ubschoolpages/ubschoolenseignant/ubschoolpaye/getprixcourseffectue.php',
                        type: 'post',
                        data: {moid: moid},
                        dataType: 'json',
                        success: function(response) {

                            var factjmo = response['prixu'];
                            document.getElementById("prixucourseffectue" + moid2).value = "";
                            document.getElementById("prixucourseffectue" + moid2).value = factjmo;
                            CalculTotalMON(moid2);
                        }
                    });
                };

            }
        });

//        $(".libcourseffectue").change(function () {
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
//                    document.getElementById("prixucourseffectue"+c2.length).value = "";
//                    document.getElementById("prixucourseffectue"+c2.length).value = factjmo;
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
            cmo.removeChild(c2mo[c2mo.length - 1]);
        }
        document.getElementById('nbcourseffectue').value = c2mo.length;
        lmo = c2mo.length;
    }


</script>
