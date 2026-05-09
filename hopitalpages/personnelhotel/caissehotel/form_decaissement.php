<script language="JavaScript">
    /* On crée la fonction qui va construire la seconde liste déroulante */
    window.onload = function () {
        changePersonnel(tabpe, document.getElementById("serviced").value);
    };

    function changePersonnel(tabpe, idpa)
    {
        //        idpaili=idpa;
        if (idpa != "vide")
        {
            raz("personneld");
            var nbs = tabpe.length;
            var indicepa = 0;
            for (var j = 0; j < nbs; j++)
            {
                if (tabpe[j][0] == idpa) {
                    indicepa = j;
                }
            }

            /* On compte les services */
            var nbds = tabpe[indicepa][4].length;
            for (i = 0; i < nbds; i++)
            {
                var servi = tabpe[indicepa][4][i][2].replace(/&#039;/gi, "\'");
                new_options = new Option(servi, tabpe[indicepa][4][i][0]);
                document.formdecaissement.elements["personneld"].options[document.formdecaissement.elements["personneld"].length] = new_options;
            }
        }
    }
    function raz(liste)
    {
        d = document.formdecaissement.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formdecaissement.elements[liste].options[t] = null;
    }

    jQuery(document).ready(function () {
        // binds form submission and fields to the validation engine
        jQuery("#decaissement_form").validationEngine('attach');
    });
    /**
     *
     * @param {jqObject} the field where the validation applies
     * @param {Array[String]} validation rules for this field
     * @param {int} rule index
     * @param {Map} form options
     * @return an error string if validation failed
     */
    function checkHELLO(field, rules, i, options) {
        if (field.val() != "HELLO") {
            // this allows to use i18 for the error msgs
            return options.allrules.validate2fields.alertText;
        }
    }

</script>
<?php
$rslts = $con->query("select * from service_point_hotel as spa left join hotel_service as s on 
    spa.id_service=s.id_service where spa.id_point_hotel='" . $_SESSION["id_point_hotel"] . "'") or die(mysqli_error($con));


/* Création du tableau PHP des valeurs récupérées */
$pers = array();
/* Index du département par tableau régional */
$id = 0;
while ($ligne = mysqli_fetch_assoc($rslts)) {

    /* J'ajoute les points d'hotels */
    $pers[$id][0] = $ligne['id_service_point_hotel'];
    $pers[$id][1] = $ligne['id_service'];
    $pers[$id][2] = $ligne['code_service'];
    $pers[$id][3] = $ligne['nom_service'];
    $pers[$id][4] = array();
    $rsltp = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on "
            . "pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
            . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
            . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service "
            . "where af.id_service_point_hotel='" . $ligne["id_service_point_hotel"] . "' and "
            . "af.etat_affectation=true ") or die(mysqli_error($con));
    /* J'ajoute les services */
    $ids = 0;
    while ($ligne1 = mysqli_fetch_assoc($rsltp)) {
        $pers[$id][4][$ids][0] = $ligne1['id_personnel'];
        $pers[$id][4][$ids][1] = $ligne1['code_pe'];
        $pers[$id][4][$ids][2] = $ligne1['nom_pe'];
        $pers[$id][4][$ids][3] = $ligne1['prenom_pe'];
        $ids = $ids + 1;
    }
    $id++;
}

/* On sérialise le tableau obtenu pour traitement par JavaScript */
$chaine = htmlspecialchars(serialize($pers), ENT_QUOTES);
?>
<script type="text/javascript">
    /*
     * Ici, on transmets la chaîne sérialisée à JavaScript 
     * pour la transformer en tableau indexé JavaScript 
     */
    var tableau = new PhpArray2Js('<?php echo $chaine; ?>');
    var tabpe = tableau.retour();

</script> 
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h3 class=" text-center">Formulaire de D&eacute;caissement</h3>  
        <form id="decaissement_form" name="formdecaissement" enctype="multipart/form-data" method="post" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/decaissement'); ?>&pagevoy=<?php echo NUM_PAGE + 1; ?>">
            <div class="row ">
                <div class="col-sm-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">Montant</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <input value="<?php echo $_SESSION['formdecaisse'][NUM_PAGE]["montant"]; ?>" class="validate[required,custom[onlyNumber]] text-input form-control" placeholder="50000" type="text" name="montant" id="montant" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">But</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <textarea value="" class="validate[required] text-input form-control" placeholder="Le but de ce d&eacute;caissement" type="text" name="but" id="but"><?php echo $_SESSION['formdecaisse'][NUM_PAGE]["but"]; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">Service</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="serviced" id="serviced"  class="form-control" onchange="changePersonnel(tabpe, this.value);">
                                    <option value="" selected="selected">- Choisissez un Service -</option>
                                    <?php
                                    /* Construction de la première liste : on se sert du tableau PHP */
                                    $nbf = count($pers);
                                    for ($j = 0; $j < $nbf; $j++) {
                                        ?>
                                        <option value="<?php echo($pers[$j][0]); ?>"><?php echo($pers[$j][3]); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label for="personneld">Personnel</label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="personneld" class="form-control">
                                    <option value="" selected="selected">- Choisissez un Personnel -</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pull-right">
                <div class="col-sm-12">
                    <a href="javascript:history.go(-1)" class="btn btn-success"><i class="icon-backward"></i> Quitter</a>
                    <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                    <button type="submit" name="editpers" class="btn btn-success">D&eacute;caisser <i class="icon-forward"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-3"></div>
</div>