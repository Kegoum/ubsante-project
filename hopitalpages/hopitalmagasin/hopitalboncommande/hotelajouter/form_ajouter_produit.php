
<?php
$rsltcat = $con->query("select * from hp_categorie") or die(mysqli_error($con));
$rsltua = $con->query("select * from hp_unite") or die(mysqli_error($con));
$rsltuv = $con->query("select * from hp_unite") or die(mysqli_error($con));
$rsltus = $con->query("select * from hp_unite") or die(mysqli_error($con));
?>

<div class="row">
    <div class="col-sm-12">
        <form id="ajout_prod" name="formprod" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/hopitalajouter/ajouter_produit'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>">
            <div class="row">
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
                        <label class="control-label" >Prix d'achat <b style="color: red">*</b></label> 
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