<div class="row">
    <div class="col-md-3 col-sm-2 col-xs-1" ></div>
    <div class="col-md-6 col-sm-8 col-xs-10" >


        <!--***** BASIC FORM *****-->
        <div class="card form" id="form1">
            <div class="card-header">
                <h3>Formulaire de modification d'une Cat&eacute;gorie de Salle</h3>  

            </div>
            <br>
        <form id="edit_categoriechambre" name="formcategoriechambree" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/hopitalediter/edit_categoriechambre'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&idcategoriechambre=<?php echo $_REQUEST["idcategoriechambre"]; ?>" style="padding: 2%;">
        
            <input value="<?php echo $_SESSION['formcategoriechambree'][NUM_PAGE]["idcategoriechambre"]; ?>" type="hidden" name="idcategoriechambre" id="idcategoriechambre" />

           <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label" >Titre &nbsp;<g>*</g></label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formcategoriechambree'][NUM_PAGE]["libellee"]; ?>" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" class="form-control" placeholder="" type="text" name="libellee" id="libellee" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label" >Prix &nbsp;<g>*</g></label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formcategoriechambree'][NUM_PAGE]["prixe"]; ?>" class="form-control" placeholder="" type="text" name="prixe" id="prixe" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
        <div class="row">
            <br>
            <div class="col-sm-12">
                <b style="color: red">Champs Obligatoires *</b>
            </div>
            <br>
            <div class="col-sm-12 text-center">
                    <button type="submit" id="validateBtnpe" name="" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Modifier</button>
                        <button type="reset" id="resetBtnpe" class="btn btn-primary"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                        <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                <br>
            </div>
        </div>
                </div>
    </form>
        </div>
    </div>

    <div class="col-md-3 col-sm-2 col-xs-1" ></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        var idcategoriechambre = document.getElementById('idcategoriechambre').value;
//        alert(idcategoriechambre);
        $('#edit_categoriechambre').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                libellee: {
                    message: 'Nom du categoriechambre invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de la categoriechambre est obligatoire'
                        },
                        stringLength: {
                            min: 2,
                            message: 'Le nom de la categoriechambre doit avoir au moins 2 characteres de long'
                        },
                        remote: {
                            type: 'POST',
                            data: {idcategoriechambre: idcategoriechambre},
                            dataType: 'json',
                            url: './hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/remoteformvalidationcategoriechambre.php',
                            message: 'Le nom doit etre unique'
                        }
                    }
                },
                prixe: {
                    validators: {
                        notEmpty: {
                            message: 'Le prix de la categorie est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//        $('#validateBtnpe').click(function () {
//            $('#edit_categoriechambre').bootstrapValidator('validate');
//        });

//        $('#resetBtnpe').click(function () {
//            $('#edit_categoriechambre').data('bootstrapValidator').resetForm(true);
//        });
    });
</script>
