<script language="JavaScript">
    /* On crée la fonction qui va construire la seconde liste déroulante */
    window.onload = function() {
        changeCategorie(tabag, document.getElementById("lang").value);
    };
    function changeCategorie(tabag, idpa)
    {
        //        idpaili=idpa;
        if (idpa != "vide")
        {
            raz("cat");
            var nbs = tabag.length;
            var indicepa = 0;
            for (var j = 0; j < nbs; j++)
            {
                if (tabag[j][0] == idpa) {
                    indicepa = j;
                }
            }

            /* On compte les services */
            var nbds = tabag[indicepa][3].length;
            for (i = 0; i < nbds; i++)
            {
                var servi = tabag[indicepa][3][i][2].replace(/&#039;/gi, "\'");
                new_options = new Option(servi, tabag[indicepa][3][i][0]);
                document.formprode.elements["cat"].options[document.formprode.elements["cat"].length] = new_options;
            }
        }
    }

    function raz(liste)
    {
        d = document.formprode.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formprode.elements[liste].options[t] = null;
    }

    jQuery(document).ready(function() {
        // binds form submission and fields to the validation engine
//        jQuery("#voyage_form").validationEngine('attach');
        jQuery("#ajout_prod").validationEngine('attach');

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

    $(function() {
        $('#datefab').datepicker();
        $('#datefab').on('changeDate', function(ev) {
            $(this).datepicker('hide');
        });
    });

</script>
<?php
$rsltcat = $con->query("select * from hotel_categorie") or die(mysqli_error($con));
$rsltfou = $con->query("select * from hotel_fourniture") or die(mysqli_error($con));
?>

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <h4 class="page-header text-center">Formulaire de Modification d'un Produit </h4> 
        <form id="ajout_prod" name="formprode" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelediter/editer_produit'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&produit=<?php echo $_REQUEST["produit"]; ?>">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" >Fourniture <b style="color: red">*</b></label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="four" id="four" class="validate[required] text-input form-control">
                                    <option value="" selected="selected">- Choisissez une Fourniture-</option>
                                    <?php
                                    /* Construction de la première liste : on se sert du tableau PHP */
                                    while ($rowfou = mysqli_fetch_assoc($rsltfou)) {
                                        ?>
                                        <option value="<?php echo($rowfou["id_fourniture"]); ?>" <?php if ($_SESSION['formprode'][NUM_PAGE]["four"] == $rowfou["id_fourniture"]) { ?> selected <?php } ?>><?php echo($rowfou["libelle_fourniture"]); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Code Produit <b style="color: red">*</b></label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formprode'][NUM_PAGE]["codep"]; ?>" class="validate[required,custom[onlyLetterNumber]] text-input form-control" placeholder="Ex: RIZ,TORA,... " type="text" name="codep" id="codep" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label">D&eacute;signation <b style="color: red">*</b></label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formprode'][NUM_PAGE]["desp"]; ?>" class="validate[required] text-input form-control" placeholder="Le nom ou la d&eacute;signation du produit" type="text" name="desp" id="desp" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" >Cat&eacute;gorie <b style="color: red">*</b></label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="cat" id="cat" class="validate[required] text-input form-control">
                                    <option value="" selected="selected">- Choisissez une Cat&eacute;gorie-</option>
                                    <?php
                                    /* Construction de la première liste : on se sert du tableau PHP */
                                    while ($rowcat = mysqli_fetch_assoc($rsltcat)) {
                                        ?>
                                        <option value="<?php echo($rowcat["id_categorie"]); ?>" <?php if ($_SESSION['formprode'][NUM_PAGE]["cat"] == $rowcat["id_categorie"]) { ?> selected <?php } ?>><?php echo($rowcat["libelle_categorie"]); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Image :</label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <input type="hidden" name="imagepstring" value="<?php echo $_SESSION['formprode'][NUM_PAGE]['imagepstring']; ?>">
                            <img src="hotelupload/images/<?php echo $_SESSION['formprode'][NUM_PAGE]['imagepstring']; ?>" style="width: 20mm; height: 20mm;">
                            <div class="fileupload-preview thumbnail" style="width: 20mm; height: 20mm;"></div>
                            <!--<div>-->
                            <span class="btn btn-file btn-success"><span class="fileupload-new">Sélectionner une image</span>
                                <span class="fileupload-exists">Changer</span><input type="file" name="imagep" id="imagep" /></span>
                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                            <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <b style="color: red">Champs Obligatoires *</b>
                </div>
                <div class="col-sm-6">
                    <button type="submit" name="insproduit" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Modifier</button>
                    <button type="reset" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                    <a href="javascript:history.go(-1)" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-3"></div>
</div> 