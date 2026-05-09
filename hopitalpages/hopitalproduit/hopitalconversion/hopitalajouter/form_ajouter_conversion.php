<script language="JavaScript">

</script>
<?php
$rsltu = $con->query("select * from hp_unite ") or die(mysqli_error($con));
?>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <h4 class="page-header text-center">Formulaire d'Ajout d'une unit&eacute; du produit <?php echo $row["libelleproduit"] ?> </h4>  
        <form id="ajout_prod" name="formprodunite" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalconversion/hopitalajouter/ajouter_conversion'); ?>&produit=<?php echo $_REQUEST["produit"] ?>&pagecom=<?php echo NUM_PAGE + 1; ?>">

            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" >Conversion <b style="color: red">*</b></label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formprodunite'][NUM_PAGE]["conver"]; ?>" class="text-input form-control" placeholder="" type="text" name="conver" id="conver" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" >Stock converti <b style="color: red">*</b></label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formprodunite'][NUM_PAGE]["stock"]; ?>" class="text-input form-control" placeholder="" type="text" name="stock" id="stock" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" >Unit&eacute; <b style="color: red">*</b></label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="unite" id="unite" class="validate[required] text-input form-control" >
                                    <option value=""> -Choisissez une unit&eacute;- </option>
                                    <?php
                                    while ($rowt = mysqli_fetch_assoc($rsltu)) {
                                        $rsltta = $con->query("select * from hp_conversion as c where c.idproduit='" . $idp . "' "
                                                . "and c.idunite='" . $rowt["idunite"] . "'") or die(mysqli_error($con));
                                        $nbta = mysqli_num_rows($rsltta);
                                        if ($nbta == 0) {
                                            ?>
                                            <option value="<?php echo $rowt["idunite"] ?>" <?php if ($_SESSION['formprodunite'][NUM_PAGE]["unite"] == $rowt["idunite"]) { ?> selected <?php } ?>><?php echo $rowt["libelleunite"] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
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
    <div class="col-sm-2"></div>
</div> 