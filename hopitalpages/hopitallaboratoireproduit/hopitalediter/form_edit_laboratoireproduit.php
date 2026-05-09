
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire de modification d'un Laboratoire </h1>
                            </div>
                        </div>
                        <form id="edit_laboratoireproduit" name="formlaboratoireproduite" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitallaboratoireproduit/hopitalediter/edit_laboratoireproduit'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&idlaboratoireproduit=<?php echo $_REQUEST["idlaboratoireproduit"]; ?>" style="padding: 2%;">

                            <input value="<?php echo $_SESSION['formlaboratoireproduite'][NUM_PAGE]["idlaboratoireproduit"]; ?>" type="hidden" name="idlaboratoireproduit" id="idlaboratoireproduit" />
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Nom&nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formlaboratoireproduite'][NUM_PAGE]["laboratoireproduite"]; ?>"  class="form-control" placeholder="" type="text" name="laboratoireproduite" id="laboratoireproduite" />
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

        var idlaboratoireproduit = document.getElementById('idlaboratoireproduit').value;
//        alert(idlaboratoireproduit);
        $('#edit_laboratoireproduit').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                laboratoireproduite: {
                    message: 'Conditionnement invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le laboratoireproduit est obligatoire'
                        },
                        remote: {
                            type: 'POST',
                            data: {idlaboratoireproduit: idlaboratoireproduit},
                            dataType: 'json',
                            url: './hopitalpages/hopitallaboratoireproduit/remoteformvalidationlaboratoireproduit.php',
                            message: 'Le laboratoireproduit doit etre unique'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//        $('#validateBtnpe').click(function () {
//            $('#edit_laboratoireproduit').bootstrapValidator('validate');
//        });
//
//        $('#resetBtnpe').click(function () {
//            $('#edit_laboratoireproduit').data('bootstrapValidator').resetForm(true);
//        });
    });
</script>
