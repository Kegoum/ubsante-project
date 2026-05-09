<?php $page_active = "Personnel"; ?>
<script language="JavaScript">
    /* On crée la fonction qui va construire la seconde liste déroulante */
    window.onload = function () {
        changeService(tabpa, document.getElementById("pointhotel").value);
    };

    function changeService(tabpa, idpa)
    {
        //        idpaili=idpa;
        if (idpa != "vide")
        {
            raz("servpa");
            var nbs = tabpa.length;
            var indicepa = 0;
            for (var j = 0; j < nbs; j++)
            {
                if (tabpa[j][0] == idpa) {
                    indicepa = j;
                }
            }

            /* On compte les services */
            var nbds = tabpa[indicepa][2].length;
            for (i = 0; i < nbds; i++)
            {
                var servi = tabpa[indicepa][2][i][2].replace(/&#039;/gi, "\'");
                new_options = new Option(servi, tabpa[indicepa][2][i][0]);
                document.formpers.elements["servpa"].options[document.formpers.elements["servpa"].length] = new_options;
            }
        }
    }
    function raz(liste)
    {
        d = document.formpers.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formpers.elements[liste].options[t] = null;
    }

    jQuery(document).ready(function () {
        // binds form submission and fields to the validation engine
        jQuery("#personnel_form").validationEngine('attach');
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
$rsltpa = $con->query("select * from hotel_point_hotel order by nom_ph asc") or die(mysqli_error($con));
?>
<?php
/* Création du tableau PHP des valeurs récupérées */
$pointag = array();
/* Index du département par tableau régional */
$id = 0;
while ($ligne = mysqli_fetch_assoc($rsltpa)) {

    /* J'ajoute les points d'hotels */
    $pointag[$id][0] = $ligne['id_point_hotel'];
    $pointag[$id][1] = $ligne['nom_ph'];
    $pointag[$id][2] = array();
    $rsltserv = $con->query("select DISTINCT(spa.id_service),spa.*,s.* from service_point_hotel as spa left join hotel_service as s "
            . "on spa.id_service=s.id_service where spa.id_point_hotel='" . $ligne['id_point_hotel'] . "'") or die(mysqli_error($con));

    /* J'ajoute les services */
    $ids = 0;
    while ($ligne1 = mysqli_fetch_assoc($rsltserv)) {
        if ((isset($_SESSION["code_service"])) && ($_SESSION["code_service"] == "DG")) {
            if ($ligne1['code_service'] != "DG") {
                $pointag[$id][2][$ids][0] = $ligne1['id_service_point_hotel'];
                $pointag[$id][2][$ids][1] = $ligne1['id_service'];
                $pointag[$id][2][$ids][2] = $ligne1['nom_service'];
                $ids = $ids + 1;
            }
        } else {
            $pointag[$id][2][$ids][0] = $ligne1['id_service_point_hotel'];
            $pointag[$id][2][$ids][1] = $ligne1['id_service'];
            $pointag[$id][2][$ids][2] = $ligne1['nom_service'];
            $ids = $ids + 1;
        }
    }
    $id++;
}

/* On sérialise le tableau obtenu pour traitement par JavaScript */
$chaine = htmlspecialchars(serialize($pointag), ENT_QUOTES);
?>
<script type="text/javascript">
    /*
     * Ici, on transmets la chaîne sérialisée à JavaScript 
     * pour la transformer en tableau indexé JavaScript 
     */
    var tableau = new PhpArray2Js('<?php echo $chaine; ?>');
    var tabpa = tableau.retour();

</script>   
<?php
if (isset($_POST["inspers"])) {
    $nomp = trim(htmlspecialchars($_POST["nomp"]));
    $prenomp = trim(htmlspecialchars($_POST["prenomp"]));
    $emailp = trim(htmlspecialchars($_POST["emailp"]));
    $telp = trim(htmlspecialchars($_POST["telp"]));
    $pointap = trim(htmlspecialchars($_POST["pointhotel"]));
    $servpa = trim(htmlspecialchars($_POST["servpa"]));
    ajouter_personnel($nomp, $prenomp, $emailp, $telp, $pointap, $servpa, $con);
}
?>
<div class="row">
    <div class="col-lg-12">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h3 class="page-header">Formulaire d'Ajout d'un Personnel </h3> 
        <form id="personnel_form" name="formpers" enctype="multipart/form-data" method="post" action="#">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">Nom du personnel</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input class="validate[required,custom[textSansApostroph]] text-input form-control" placeholder="Le nom du personnel" type="text" name="nomp" id="nomp" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label" >Pr&eacute;om du personnel</label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input class="validate[custom[textSansApostroph]] text-input form-control" placeholder="Le pr&eacute;nom du personnel" type="text" name="prenomp" id="prenomp" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-6">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">E-Mail</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input class="validate[required,custom[email]] text-input form-control" placeholder="email@domaine.com" type="text" name="emailp" id="emailp" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">T&eacute;l&eacute;phone</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <input class="validate[custom[phone]] text-input form-control" placeholder="655555555" type="text" name="telp" id="telp" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-6">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">Point d'Hotel</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="pointhotel" id="pointhotel"  class="validate[required] form-control" onchange="changeService(tabpa, this.value);" required>
                                    <option value="" selected="selected">- Choisissez un Point d'Hotel -</option>
                                    <?php
                                    if (isset($_SESSION["id_point_hotel"])) {
                                        $rsltpas = $con->query("select * from hotel_point_hotel where "
                                                . "id_point_hotel='" . $_SESSION["id_point_hotel"] . "'") or die(mysqli_error($con));
                                        $rows = mysqli_fetch_assoc($rsltpas);
                                        ?>
                                    <option value="<?php echo($rows["id_point_hotel"]); ?>" selected><?php echo($rows["nom_ph"]); ?></option>
                                        <?php
                                    } else {
                                        /* Construction de la première liste : on se sert du tableau PHP */
                                        $nbf = count($pointag);
                                        for ($j = 0; $j < $nbf; $j++) {
                                            ?>
                                            <option value="<?php echo($pointag[$j][0]); ?>"><?php echo($pointag[$j][1]); ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" style="margin-left:15px;">
                        <label for="servpa">Service</label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="servpa" class="validate[required] form-control">
                                    <option value="" selected="selected">- Choisissez un Service -</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-6">
                    <button type="submit" name="inspers" class="btn btn-success"><i class="icon-check"></i> Enregistrer</button>
                    <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                    <a href="javascript:history.go(-1)" class="btn btn-success"><i class="icon-backward"></i> Quitter</a>
                </div>
            </div>
        </form>
    </div>
</div>