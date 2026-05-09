<script type="text/javascript">

    /* On crée la fonction qui va construire la seconde liste déroulante */
    window.onload = function () {
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
<?php
if ($rowval["statut"]) {
    ?>
    <?php
    if (isset($_REQUEST["recu"])) {
        $id = $_REQUEST["recu"];
        $reqens = $con->query("select * from recu as r left join hotel_personnel as e on r.id_personnel=e.id_personnel where r.idrecu='" . $id . "'") or die(mysqli_error($con));
        $rowens = mysqli_fetch_assoc($reqens);
        $reqecole = $con->query("select * from ecole") or die(mysqli_error($con));
        $rowecole = NULL;
        while ($rowecole1 = mysqli_fetch_assoc($reqecole)) {
            $rowecole = $rowecole1;
        }

        $date = date('Y-m-d');
        $reqa = $con->query("select * from annee where libellean<'" . $date . "' and libellean2>'" . $date . "'") or die(mysqli_error($con));

        $rowa = mysqli_fetch_assoc($reqa);
        $cace = ($rowens["irpp"] * 10) / 100;
        $totalimpote = $rowens["irpp"] + $rowens["taxecommunale"];
        $caissere = 1854;
        ?>

        <div class="col-xs-12 col-sm-12 col-md-12 well">
            <form role="form" name="form" action="#" method="post"  enctype="multipart/form-data">

                <h2>Bulletin de Paie du personnel <small> <?php echo $rowens["nom"]; ?> <?php echo $rowens["prenom"]; ?> - <?php echo $rowens["tel"]; ?></small></h2>
                <h2>Modification</h2>
                <fieldset class="space_data"><legend class="titre">Informations de l'Employeur</legend>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                Nom ou Raison Sociale : <?php echo $rowecole["nomecole"]; ?>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                Adresse : <?php echo $rowecole["adresse"]; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                N&deg; CNPS : <?php echo $rowecole["nocnps"]; ?>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                N&deg; Contribuable : <?php echo $rowecole["nocontribuable"]; ?>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="space_data"><legend class="titre">Informations de l'Employer</legend>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Paye du :</label>
                                <input name="datedebutp" value="<?php echo $rowens["date_debut_p"]; ?>" placeholder="Date debut paiement" type="text" class="form-control" id="datedebutp" data-date-format="yyyy-mm-dd" required>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>au :</label>
                                <input name="datefinp" value="<?php echo $rowens["date_fin_p"]; ?>" placeholder="Date fin payement" type="text" class="form-control" id="datefinp" data-date-format="yyyy-mm-dd" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Nom et Pr&eacute;nom du travailleur :</label>
                                <input name="nome" value="<?php echo $rowens["nom"]; ?> <?php echo $rowens["prenom"]; ?>" type="text" class="form-control" id="nomp" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Num&eacute;ro de pointage :</label>
                                <input name="nopointage" id="nopointage" value="<?php echo $rowens["no_pointage"]; ?>" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Emploi occup&eacute; :</label>
                                <input name="emploi" value="Enseignant" type="text" class="form-control" id="emploi" required>

                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>N&deg; Contribuable de l'employ&eacute; :</label>
                                <input name="nocontribuablee" id="nocontribuablee" value="<?php echo $rowens["no_contribuable_pe"]; ?>" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>N&deg; CNPS de l'employ&eacute; :</label>
                                <input name="nocnpse" id="nocnpse" value="<?php echo $rowens["no_cnps_pe"]; ?>" type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="space_data"><legend class="titre"></legend>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Salaire de base :</label>
                                <input name="salairebase" value="<?php echo $rowens["salaire_de_base"]; ?>" onblur="changeRemunerationBrute();" pattern="^([0-9]+)$" maxlength="254" placeholder="Salaire" type="number" class="form-control" id="salairebase">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="space_data"><legend class="titre">Heures suplementaires</legend>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Heures suplementaires :</label>
                                <input name="heuresup" id="heuresup" onblur="changeRemunerationBrute();" pattern="^([0-9]+)$" maxlength="254"  placeholder="" type="number" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Heure Sup &agrave; 15% &agrave; :</label>
                                <input name="heure15" id="heure15" value="<?php echo $rowens["heure_sup_15"]; ?>" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254"  placeholder="Heure Sup &agrave; 15% &agrave;" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Heure Sup &agrave; 20% &agrave; :</label>
                                <input name="heure20" id="heure20" value="<?php echo $rowens["heure_sup_20"]; ?>" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254" placeholder="Heure Sup &agrave; 20% &agrave;" type="number" class="form-control">
                            </div>
                        </div> 
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Heure Sup &agrave; 30% &agrave; :</label>
                                <input name="heure30" id="heure30" value="<?php echo $rowens["heure_sup_30"]; ?>" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254" placeholder="Heure Sup &agrave; 30% &agrave;" type="number" class="form-control">
                            </div>
                        </div> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Heure Sup &agrave; 40% &agrave; :</label>
                                <input name="heure40" id="heure40" value="<?php echo $rowens["heure_sup_40"]; ?>" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254" placeholder="Heure Sup &agrave; 40% &agrave;" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Heure Sup &agrave; 50% &agrave; :</label>
                                <input name="heure50" id="heure50" value="<?php echo $rowens["heure_sup_50"]; ?>" onblur="changeHeureSup();" pattern="^([0-9]+)$" maxlength="254" placeholder="Heure Sup &agrave; 50% &agrave;" type="number" class="form-control">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="space_data"><legend class="titre">Primes</legend>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Primes :</label>
                                <input name="prime" id="prime" onblur="changeRemunerationBrute();" pattern="^([0-9]+)$" maxlength="254"  placeholder="" type="number" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Ancienn&eacute;t&eacute; :</label>
                                <input name="anciennep" id="anciennep" value="<?php echo $rowens["anciennete_prime"]; ?>" onblur="changePrime();" pattern="^([0-9]+)$" maxlength="254" placeholder="ancienne" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Rendement :</label>
                                <input name="rendementp" id="rendementp" value="<?php echo $rowens["rendement_prime"]; ?>" onblur="changePrime();" placeholder="rendement" pattern="^([0-9]+)$" maxlength="254" type="number" class="form-control" >
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Logement :</label>
                                <input name="logementp" id="logementp" value="<?php echo $rowens["logement_prime"]; ?>" onblur="changePrime();" placeholder="logement" pattern="^([0-9]+)$" maxlength="254" type="number" class="form-control" >
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="space_data"><legend class="titre">Indemnit&eacute;s</legend>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Indemnit&eacute;s :</label>
                                <input name="indemnite" id="indemnite" onblur="changeRemunerationBrute();" pattern="^([0-9]+)$" maxlength="254"  placeholder="" type="number" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Caisse :</label>
                                <input name="caissei" id="caissei" value="<?php echo $rowens["caisse_indemnite"]; ?>" onblur="changeIndemnite();" pattern="^([0-9]+)$" maxlength="254" placeholder="Caisse" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Deplacement :</label>
                                <input name="deplacementi" id="deplacementi" value="<?php echo $rowens["deplacement_indemnite"]; ?>" onblur="changeIndemnite();" placeholder="deplacement" pattern="^([0-9]+)$" maxlength="254" type="number" class="form-control" >
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Repr&eacute;sentation :</label>
                                <input name="representationi" id="representationi" value="<?php echo $rowens["representation_indemnite"]; ?>" onblur="changeIndemnite();" placeholder="representation" pattern="^([0-9]+)$" maxlength="254" type="number" class="form-control" >
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="space_data"><legend class="titre"></legend>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>(1) R&eacute;mun&eacute;ration Brute :</label>
                                <input name="remunerationbrute" pattern="^([0-9]+)$" maxlength="254" placeholder="R&eacute;mun&eacute;ration Brute" type="number" class="form-control" id="remunerationbrute" readonly>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="space_data"><legend class="titre">Retenues</legend>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>(a) Retenues Fiscales :</label>
                                <input name="retenuefiscales" pattern="^([0-9]+)$" maxlength="254" placeholder="Retenues Fiscales" type="number" class="form-control" id="retenuefiscales" readonly >
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>I.R.P.P :</label>
                                <input name="irpp" value="<?php echo $rowens["irpp"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" value="" type="number" class="form-control" id="irpp">
                            </div>
                        </div> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>C.A.C :</label>
                                <input name="cac" value="<?php echo $rowens["cac"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9.]+)$" maxlength="254" value="" type="number" class="form-control" id="cac">
                            </div>
                        </div> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Taxe Communale :</label>
                                <input name="taxec" value="<?php echo $rowens["taxe_communale"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" value="" type="number" class="form-control" id="taxec">
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Redevance Audio Visuelle :</label>
                                <input name="redevanceaudio" value="<?php echo $rowens["redevance_audio_visuel"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control" id="redevanceaudio">
                            </div>
                        </div> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Cr&eacute;dit Foncier :</label>
                                <input name="creditf" value="<?php echo $rowens["credit_foncier"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" placeholder="Cr&eacute;dit Foncier" type="number" class="form-control" id="creditf">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Fond National de l'Emploi :</label>
                                <input name="fne" value="<?php echo $rowens["fne"]; ?>" onblur="changeRetenueFiscale();" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control" id="fne">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>(b) Retenues Sociales :</label>
                                <input name="retenuesociales" pattern="^([0-9]+)$" maxlength="254" placeholder="Retenues Fiscales" type="number" class="form-control" id="retenuesociales" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>PV&ID (CNPS) :</label>
                                <input name="cnps" value="<?php echo $rowens["cnps"]; ?>" onblur="changeRetenueSociale();" pattern="^([0-9]+)$" maxlength="254" value="" type="number" class="form-control" id="cnps">
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>(c) Autres Retenues :</label>
                                <input name="autresretenue" pattern="^([0-9]+)$" maxlength="254" placeholder="Retenues" type="number" class="form-control" id="autresretenue" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Acompte sur salaire :</label>
                                <input name="acomptes" id="acomptes" value="<?php echo $rowens["acompte_salaire"]; ?>" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254"  placeholder="Acompte" type="number" class="form-control">
                            </div>
                        </div> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Avance et autres pr&ecirc;ts :</label>
                                <input name="avancee" id="avancee" value="<?php echo $rowens["avance_exceptionnelle"]; ?>" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254"  placeholder="Avance" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Saisies arr&ecirc;ts :</label>
                                <input name="saisiearret" id="saisiearret" value="<?php echo $rowens["saisie_arret"]; ?>" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254" value="" type="number" class="form-control">
                            </div>
                        </div> 
                    </div>
                    <div class="row"> 
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Cotisation Syndicale :</label>
                                <input name="cotisations" id="cotisations" value="<?php echo $rowens["cotisation_syndicale"]; ?>" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254" placeholder="Cotisation Syndicale" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>Autres :</label>
                                <input name="autre" id="autre" value="<?php echo $rowens["autre"]; ?>" onblur="changeAutreRetenue();" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control">
                            </div>
                        </div> 
                    </div>
                </fieldset>
                <fieldset class="space_data"><legend class="titre"></legend>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>(2) Total des retenues &agrave; &eacute;ffectuer (a)+(b)+(c) :</label>
                                <input name="totalretenue" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control" id="totalretenue" readonly>
                            </div>
                        </div>
                    </div>
                </fieldset>
                
                <fieldset class="space_data"><legend class="titre"></legend>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>NET A PAYER (1)-(2) :</label>
                                <input name="netapayer" pattern="^([0-9]+)$" maxlength="254" placeholder="" type="number" class="form-control" id="netapayer" readonly required>
                            </div>
                        </div>
                    </div>
                </fieldset><br />
                <fieldset class="space_data"><legend class="titre">Options</legend>
                    <input type="submit" id="Submit" class="btn btn-success" name="editrecu_btn" value="Modifier">
                    <input type="reset" class="btn btn-success " name="annuler" value="Effacer">
                    <a href="javascript:history.go(-1)" class="btn btn-success btn-sm">Quitter</a>
                </fieldset> <br />
            </form>
        </div>
        <?php
        if (isset($_POST["editrecu_btn"])) {
            $datedebutp = trim(htmlspecialchars($_POST["datedebutp"]));
            $datefinp = trim(htmlspecialchars($_POST["datefinp"]));
            $emploi = trim(htmlspecialchars($_POST["emploi"]));

            $salairebase = trim(htmlspecialchars($_POST["salairebase"]));
            $heure15 = trim(htmlspecialchars($_POST["heure15"]));
            $heure20 = trim(htmlspecialchars($_POST["heure20"]));
            $heure30 = trim(htmlspecialchars($_POST["heure30"]));
            $heure40 = trim(htmlspecialchars($_POST["heure40"]));
            $heure50 = trim(htmlspecialchars($_POST["heure50"]));

            $anciennep = trim(htmlspecialchars($_POST["anciennep"]));
            $rendementp = trim(htmlspecialchars($_POST["rendementp"]));
            $logementp = trim(htmlspecialchars($_POST["logementp"]));

            $caissei = trim(htmlspecialchars($_POST["caissei"]));
            $deplacementi = trim(htmlspecialchars($_POST["deplacementi"]));
            $representationi = trim(htmlspecialchars($_POST["representationi"]));

            $remunerationbrute = trim(htmlspecialchars($_POST["remunerationbrute"]));

            $retenuefiscales = trim(htmlspecialchars($_POST["retenuefiscales"]));
            $irpp = trim(htmlspecialchars($_POST["irpp"]));
            $cac = trim(htmlspecialchars($_POST["cac"]));
            $taxec = trim(htmlspecialchars($_POST["taxec"]));
            $redevanceaudio = trim(htmlspecialchars($_POST["redevanceaudio"]));
            $creditf = trim(htmlspecialchars($_POST["creditf"]));
            $fne = trim(htmlspecialchars($_POST["fne"]));
            $retenuesociales = trim(htmlspecialchars($_POST["retenuesociales"]));
            $cnps = trim(htmlspecialchars($_POST["cnps"]));
            $autresretenue = trim(htmlspecialchars($_POST["autresretenue"]));
            $acomptes = trim(htmlspecialchars($_POST["acomptes"]));
            $avancee = trim(htmlspecialchars($_POST["avancee"]));
            $saisiearret = trim(htmlspecialchars($_POST["saisiearret"]));
            $cotisations = trim(htmlspecialchars($_POST["cotisations"]));
            $autre = trim(htmlspecialchars($_POST["autre"]));

            $totalretenue = trim(htmlspecialchars($_POST["totalretenue"]));

            $netapayer = trim(htmlspecialchars($_POST["netapayer"]));
//            update_paye_ens($id, $datedebutp, $datefinp, $remunerationb, $irpp, $taxec, $caisser, $journee, $heure, $heure15, $heure20, $heure30, $heure40, $heure50, $ancienne, $nouvelle, $salairet, $cac, $retenuecrtv, $creditf, $acomptes, $avancee, $retenuces, $saisie, $cotisations,$con);
        update_paye_ens($id, $datedebutp, $datefinp, $emploi, $salairebase, $heure15, $heure20, $heure30, $heure40, $heure50, $anciennep, $rendementp, $logementp, $caissei, $deplacementi, $representationi, $remunerationbrute, $retenuefiscales, $irpp, $cac, $taxec, $redevanceaudio, $creditf, $fne, $retenuesociales, $cnps, $autresretenue, $acomptes, $avancee, $saisiearret, $cotisations, $autre, $netapayer, $totalretenue, $con);
        }
    }
} else {
    echo "veuillez contacter Univers Binaire au 697 86 61 27";
}
?>