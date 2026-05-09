
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire de modification d'une D.C.I. /PRINCIPE ACTIF</h1>
                            </div>
                        </div>
                        <form id="edit_categorie" name="formcategoriee" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalcategorie/hopitalediter/edit_categorie'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&idcategorie=<?php echo $_REQUEST["idcategorie"]; ?>" style="padding: 2%;">

                            <input value="<?php echo $_SESSION['formcategoriee'][NUM_PAGE]["idcategorie"]; ?>" type="hidden" name="idcategorie" id="idcategorie" />
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">Code&nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formcategoriee'][NUM_PAGE]["codepe"]; ?>" class="form-control" placeholder="" type="text" name="codepe" id="codepe" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Nom&nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formcategoriee'][NUM_PAGE]["categoriee"]; ?>" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" class="form-control" placeholder="" type="text" name="categoriee" id="categoriee" />
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
            </div>
        </div>
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

        var idcategorie = document.getElementById('idcategorie').value;
//        alert(idcategorie);
        $('#edit_categorie').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                codepe: {
                    message: 'Code du categorie invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le code du categorie est obligatoire'
                        },
                        stringLength: {
                            min: 1,
                            max: 5,
                            message: 'Le code du categorie doit etre entre 1 et 5 characteres de long'
                        },
                        remote: {
                            type: 'POST',
                            data: {idcategorie: idcategorie},
                            dataType: 'json',
                            url: './hopitalpages/hopitalproduit/hopitalcategorie/remoteformvalidationcategorie.php',
                            message: 'Le code doit etre unique'
                        }
                    }
                },
                categoriee: {
                    validators: {
                        notEmpty: {
                            message: 'Le nom du categorie est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//        $('#validateBtnpe').click(function () {
//            $('#edit_categorie').bootstrapValidator('validate');
//        });
//
//        $('#resetBtnpe').click(function () {
//            $('#edit_categorie').data('bootstrapValidator').resetForm(true);
//        });
    });
</script>
