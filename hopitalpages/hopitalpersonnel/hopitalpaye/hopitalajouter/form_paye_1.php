<script language="JavaScript">
    /* On crée la fonction qui va construire la seconde liste déroulante */
    window.onload = function() {
        changeCategorie(tabag, document.getElementById("lang").value);
        choixPrix();
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
                document.formprod.elements["cat"].options[document.formprod.elements["cat"].length] = new_options;
            }
        }
    }

    function raz(liste)
    {
        d = document.formprod.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formprod.elements[liste].options[t] = null;
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

    function CalculPrixVente() {
        qte = parseInt(document.getElementById('qtes').value);
        prita = parseInt(document.getElementById('prixta').value);
        benp = parseInt(document.getElementById('benp').value);
        if ((qte != 0) && (prita != 0)) {
            pria = prita / qte;
            priv = ((prita / qte) + benp);
            document.getElementById('prixa').value = pria;
            document.getElementById('prixv').value = priv;
        }
    }
    function choixPrix()
    {
        if (document.getElementById("linge").checked) {
            document.getElementById("prixlinge").style.display = "block";
        } else {
            document.getElementById("prixlinge").style.display = "none";
        }

    }

</script>
<?php
$rsltcat = $con->query("select * from hotel_categorie") or die(mysqli_error($con));
$rsltfou = $con->query("select * from hotel_fourniture") or die(mysqli_error($con));
$rsltua = $con->query("select * from hotel_unite") or die(mysqli_error($con));
$rsltuv = $con->query("select * from hotel_unite") or die(mysqli_error($con));
$rsltus = $con->query("select * from hotel_unite") or die(mysqli_error($con));
?>

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-header text-center">Formulaire d'Ajout d'un article </h4>  
        <?php
        if (isset($_SESSION["login_proprietaire"]) && (isset($_SESSION["mot_de_passe_proprietaire"]))) {
            ?>
            <form id="ajout_prod" name="formprod" enctype="multipart/form-data" method="post" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/enseignanthotel/payeenseignanthotel/hotelajouter/insert_paye'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>">
                <?php
            } else if (isset($_SESSION["login_enseignant"]) && (isset($_SESSION["mot_de_passe_enseignant"])) && ($_SESSION["etat_compte_enseignant"])) {
                if (($_SESSION["code_service"] == "DG")) {
                    ?>
                    <form id="ajout_prod" name="formprod" enctype="multipart/form-data" method="post" action="indexdg.php?page=<?php echo base64_encode('hotelpages/enseignanthotel/payeenseignanthotel/hotelajouter/insert_paye'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>">
                        <?php
                    }
                }
                ?>
                <div class="row">
                    <div class="col-sm-3">
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
                                            <option value="<?php echo($rowfou["id_fourniture"]); ?>" <?php if ($_SESSION['formprod'][NUM_PAGE]["four"] == $rowfou["id_fourniture"]) { ?> selected <?php } ?>><?php echo($rowfou["libelle_fourniture"]); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Code Produit <b style="color: red">*</b></label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $_SESSION['formprod'][NUM_PAGE]["codep"]; ?>" class="validate[required,custom[onlyLetterNumber]] text-input form-control" placeholder="Ex: RIZ,TORA,... " type="text" name="codep" id="codep" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">D&eacute;signation <b style="color: red">*</b></label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $_SESSION['formprod'][NUM_PAGE]["desp"]; ?>" class="validate[required] text-input form-control" placeholder="Le nom ou la d&eacute;signation du produit" type="text" name="desp" id="desp" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
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
                                            <option value="<?php echo($rowcat["id_categorie"]); ?>" <?php if ($_SESSION['formprod'][NUM_PAGE]["cat"] == $rowcat["id_categorie"]) { ?> selected <?php } ?>><?php echo($rowcat["libelle_categorie"]); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" >Prix unitaire d'achat <b style="color: red">*</b></label> 
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $_SESSION['formprod'][NUM_PAGE]["prixa"]; ?>" class="validate[required,custom[number]] text-input form-control" placeholder="" type="text" name="prixa" id="prixa" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" >Stock</label> 
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $_SESSION['formprod'][NUM_PAGE]["qtes"]; ?>" class="validate[custom[onlyNumber]] text-input form-control" placeholder="" type="text" name="qtes" id="qtes" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" >Stock Minimal</label> 
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $_SESSION['formprod'][NUM_PAGE]["qtemin"]; ?>" class="validate[custom[onlyNumber]] text-input form-control" placeholder="" type="text" name="qtemin" id="qtemin" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Stock Maximal</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $_SESSION['formprod'][NUM_PAGE]["qtemax"]; ?>" class="validate[custom[onlyNumber]] text-input form-control" placeholder="La quantit&eacute; maximale du produit" type="text" name="qtemax" id="qtemax" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Unit&eacute; d'achat</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <select name="unitea" class="validate[required] text-input form-control">
                                        <option value="" selected="selected">- Choisissez une Unit&eacute;-</option>
                                        <?php
                                        /* Construction de la première liste : on se sert du tableau PHP */
                                        while ($rowua = mysqli_fetch_assoc($rsltua)) {
                                            ?>
                                            <option value="<?php echo($rowua["id_unite"]); ?>" <?php if ($_SESSION['formprod'][NUM_PAGE]["unitea"] == $rowua["id_unite"]) { ?> selected <?php } ?>><?php echo($rowua["libelle_unite"]); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Unit&eacute; de vente</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <select name="unitev" class="text-input form-control">
                                        <option value="" selected="selected">- Choisissez une Unit&eacute;-</option>
                                        <?php
                                        /* Construction de la première liste : on se sert du tableau PHP */
                                        while ($rowuv = mysqli_fetch_assoc($rsltuv)) {
                                            ?>
                                            <option value="<?php echo($rowuv["id_unite"]); ?>" <?php if ($_SESSION['formprod'][NUM_PAGE]["unitev"] == $rowuv["id_unite"]) { ?> selected <?php } ?>><?php echo($rowuv["libelle_unite"]); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Unit&eacute; de sortie</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <select name="unites" class="text-input form-control">
                                        <option value="" selected="selected">- Choisissez une Unit&eacute;-</option>
                                        <?php
                                        /* Construction de la première liste : on se sert du tableau PHP */
                                        while ($rowus = mysqli_fetch_assoc($rsltus)) {
                                            ?>
                                            <option value="<?php echo($rowus["id_unite"]); ?>" <?php if ($_SESSION['formprod'][NUM_PAGE]["unites"] == $rowus["id_unite"]) { ?> selected <?php } ?>><?php echo($rowus["libelle_unite"]); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Image :</label>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-preview thumbnail" style="width: 75px; height: 75px;"></div>
                                <!--<div>-->
                                <span class="btn btn-file btn-success"><span class="fileupload-new">Sélectionner une image</span>
                                    <span class="fileupload-exists">Changer</span><input type="file" name="imagep" id="imagep" /></span>
                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                                <!--</div>-->
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-3">
                                <div class="form-group" style="margin-left:15px;">
                                    <label>Linge</label>
                                    <input <?php if ($_SESSION['formprod'][1]["linge"]) { ?> checked <?php } ?> class=" " name="linge" id="linge" type="checkbox" onchange="choixPrix()" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <b style="color: red">Champs Obligatoires *</b>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" name="insproduit" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                        <button type="reset" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                        <a href="javascript:history.go(-1)" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                    </div>
                </div>
            </form>
    </div>
</div> 