<?php $page_active = "Personnel"; ?>
<script language="JavaScript">

    /* On crée la fonction qui va construire la seconde liste déroulante */
    window.onload = function() {
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
                document.formeditpers.elements["servpa"].options[document.formeditpers.elements["servpa"].length] = new_options;
            }
        }
    }
    function raz(liste)
    {
        d = document.formeditpers.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formeditpers.elements[liste].options[t] = null;
    }

    jQuery(document).ready(function() {
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
        $pointag[$id][2][$ids][0] = $ligne1['id_service_point_hotel'];
        $pointag[$id][2][$ids][1] = $ligne1['id_service'];
        $pointag[$id][2][$ids][2] = $ligne1['nom_service'];
        $ids = $ids + 1;
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
if (isset($_REQUEST["personnel"])) {
    $id = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on "
            . "pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
            . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
            . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service "
            . "where pe.id_personnel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    if (isset($_POST["editpers"])) {
        $pointapa = trim(htmlspecialchars($_POST["idpointhotela"]));
        $servpaa = trim(htmlspecialchars($_POST["idservpaa"]));
        $pointap = trim(htmlspecialchars($_POST["pointhotel"]));
        $servpa = trim(htmlspecialchars($_POST["servpa"]));
//        $servpa = $row["idservice"];
//        if($_POST["servpa"]!=NULL){
//        $servpa = trim(htmlspecialchars($_POST["servpa"]));
//        }
        affecter_personnel($id, $pointapa, $servpaa, $pointap, $servpa, $con);
    }
    ?>
    <div class="row">
        <div class="col-lg-12">
            <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
            <h2>Affectation <small> de <?php echo $row["prenom_pe"]; ?> <?php echo $row["nom_pe"]; ?> - <?php echo $row["code_pe"]; ?></small></h2>
            <form id="personnel_edit_form" name="formeditpers" method="post" action="#">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label">Ancien Point Hotel</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $row["id_point_hotel"]; ?>" class="validate[required] text-input form-control" placeholder="" type="hidden" name="idpointhotela" id="idpointhotela" readonly />
                                <input value="<?php echo $row["nom_ph"]; ?>" class="validate[required] text-input form-control" placeholder="" type="text" name="pointhotela" id="pointhotela" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label" >Ancien Service</label> 
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $row["id_service_point_hotel"]; ?>" class="validate[required] text-input form-control" placeholder="" type="hidden" name="idservpaa" id="idservpaa" readonly />
                                <input value="<?php echo $row["nom_service"]; ?>" class="validate[required] text-input form-control" placeholder="" type="text" name="servpaa" id="servpaa" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label">Nouveau Point d'Hotel</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <select name="pointhotel" id="pointhotel"  class="validate[required] form-control" onchange="changeService(tabpa, this.value);" required>
                                        <?php
                                        /* Construction de la première liste : on se sert du tableau PHP */
                                        $nbf = count($pointag);
                                        for ($j = 0; $j < $nbf; $j++) {
                                            ?>
                                            <option value="<?php echo($pointag[$j][0]); ?>"<?php
                                            if ($row["id_point_hotel"] == $pointag[$j][0]) {
                                                echo ' selected="selected"';
                                            }
                                            ?>><?php echo($pointag[$j][1]); ?></option>
                                                    <?php
                                                }
                                                ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label for="servpa">Nouveau Service</label>
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
                        <button type="submit" name="editpers" class="btn btn-success"><i class="icon-check"></i> Enregistrer</button>
                        <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                        <a href="javascript:history.go(-1)" class="btn btn-success"><i class="icon-backward"></i> Quitter</a>
                    </div>
                </div>
            </form>
        </div>
    </div>  
    <?php
}
?> 