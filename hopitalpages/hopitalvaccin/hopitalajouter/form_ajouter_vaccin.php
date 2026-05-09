<script language="JavaScript">
    
</script>
<?php

$typea = "Simple";
?>
                                        
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Enregistrement d'un vaccin</h1>
                            </div>
                        </div>
                        <form id="ajout_vaccin" name="formvaccin" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalajouter/ajout_vaccin'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Sexe <g style="color: red">*</g></label>
                                        <select data-placeholder="Choisissez un sexe..." class=" form-control" name="sexe" id="sexe" required>
                                            <option value="" selected="selected">- Choisissez un sexe-</option>
                                            <option value="Masculin" <?php if ($_SESSION['formvaccin'][NUM_PAGE]["sexe"] == "Masculin") { ?> selected <?php } ?>>Masculin</option>
                                            <option value="Féminin" <?php if ($_SESSION['formvaccin'][NUM_PAGE]["sexe"] == "Féminin") { ?> selected <?php } ?>>F&eacute;minin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Nom &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccin'][NUM_PAGE]["nom"]; ?>" class="form-control" placeholder=" " type="text" name="nom" id="nom" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Date de naissance <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccin'][NUM_PAGE]["datenais"]; ?>" class="form-control" placeholder="" type="date" name="datenais" id="datenais" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Quartier &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccin'][NUM_PAGE]["quartier"]; ?>" class="form-control" placeholder="" type="text" name="quartier" id="quartier" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Nom parent </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccin'][NUM_PAGE]["nomparent"]; ?>" class="form-control" placeholder="" type="text" name="nomparent" id="nomparent" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Contact <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccin'][NUM_PAGE]["telc"]; ?>" class="form-control" placeholder="" type="text" name="telc" id="telc" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" panel-footer">
                                    <div class="row">
                                        <br>
                                        <div class="col-sm-12">
                                            <b style="color: red">Champs Obligatoires *</b>
                                        </div>
                                        <br>
                                        <div class="col-sm-12 text-center">    
                                            <center>
                                                <!--<a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>-->
                                                <button id="validateBtn" type="submit" name="insvaccin" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                                            </center><br>
                                        </div>
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
    $(document).ready(function () {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        $('#ajout_vaccin').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nom: {
                    message: 'Nom de l\'vaccin invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de l\'vaccin est obligatoire'
                        }
                    }
                },
                role: {
                    message: 'Rôle de l\'vaccin invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le Rôle de l\'vaccin est obligatoire'
                        }
                    }
                },
                login: {
                    message: 'Login de l\'vaccin invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le login de l\'vaccin est obligatoire'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            message: 'Le login doit contenir seulement les lettres de l\'alphabet, les chiffres, le point and la barre de 8(_)'
                        }
                    }
                },
                pass1: {
                    validators: {
                        notEmpty: {
                            message: 'Le mot de passe de l\'vaccin est obligatoire'
                        },
                        identical: {
                            field: 'pass2'
                        }
//                        ,
//                        remote: {
//                            type: 'POST',
//                            url: './hopitalpages/hopitalvaccin/remoteformvalidationvaccin.php',
//                            // Send { username: 'its value', email: 'its value' } to the back-end
//                            data: function(validator) {
//                                return {
//                                    email: validator.getFieldElements('email').val()
//                                };
//                            },
//                            message: 'Le mot de passe est incorrect'
//                        }
                    }
                },
                pass2: {
                    validators: {
                        identical: {
                            field: 'pass1'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'L\'Adresse mail est obligatoire'
                        },
                        emailAddress: {
                            message: 'Adresse mail invalide'
                        }
//                        ,
//                        remote: {
//                            type: 'POST',
//                            url: './hopitalpages/hopitalvaccin/remoteformvalidationvaccin.php',
//                            // Send { username: 'its value', email: 'its value' } to the back-end
//                            data: function(validator) {
//                                return {
//                                    pass1: validator.getFieldElements('pass1').val()
//                                };
//                            },
//                            message: 'L\'Adresse mail est incorrecte'
//                        }
                    }
                },
                tel: {
                    message: 'Téléphone de l\'vaccin invalide',
                    validators: {
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Le Téléphone doit contenir seulement les chiffres'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_vaccin').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_vaccin').data('bootstrapValidator').resetForm(true);
//    });
    });

    function totalExamen()
    {
        var montv = 0;
        if ((document.getElementById("montante").value) != "") {
            montv = parseFloat(document.getElementById("montante").value);
        }
        var prixres = 0;
        if ((document.getElementById("prixexamen").value) != "") {
            prixres = parseFloat(document.getElementById("prixexamen").value);
        }
        var prixresa = 0;
        if ((document.getElementById("prixexamena").value) != "") {
            prixresa = parseFloat(document.getElementById("prixexamena").value);
        }
//        alert(prixres);
//        document.getElementById("ajout_financen").reset();
        var t = montv - (prixresa) + (prixres);
        document.getElementById("montante").value = (Math.max((((t))), 0)).toFixed(0);
        document.getElementById("prixexamena").value = (Math.max((((prixres))), 0)).toFixed(0);

    }
    function totalExamenNew(i)
    {
        var montv = 0;
        if ((document.getElementById("montante").value) != "") {
            montv = parseFloat(document.getElementById("montante").value);
        }
        var prixres = 0;
        if ((document.getElementById("prixexamen" + i).value) != "") {
            prixres = parseFloat(document.getElementById("prixexamen" + i).value);
        }
        var prixresa = 0;
        if ((document.getElementById("prixexamena" + i).value) != "") {
            prixresa = parseFloat(document.getElementById("prixexamena" + i).value);
        }
//        alert(prixres);
//        document.getElementById("ajout_financen").reset();
        var t = montv - (prixresa) + (prixres);
        document.getElementById("montante").value = (Math.max((((t))), 0)).toFixed(0);
        document.getElementById("prixexamena" + i).value = (Math.max((((prixres))), 0)).toFixed(0);

    }

    function totalEchographie()
    {
        var montv = 0;
        if ((document.getElementById("montantec").value) != "") {
            montv = parseFloat(document.getElementById("montantec").value);
        }
        var prixres = 0;
        if ((document.getElementById("prixechographie").value) != "") {
            prixres = parseFloat(document.getElementById("prixechographie").value);
        }
        var prixresa = 0;
        if ((document.getElementById("prixechographiea").value) != "") {
            prixresa = parseFloat(document.getElementById("prixechographiea").value);
        }
//        alert(prixres);
//        document.getElementById("ajout_financen").reset();
        var t = montv - (prixresa) + (prixres);
        document.getElementById("montantec").value = (Math.max((((t))), 0)).toFixed(0);
        document.getElementById("prixechographiea").value = (Math.max((((prixres))), 0)).toFixed(0);

    }
    function totalEchographieNew(i)
    {
        var montv = 0;
        if ((document.getElementById("montantec").value) != "") {
            montv = parseFloat(document.getElementById("montantec").value);
        }
        var prixres = 0;
        if ((document.getElementById("prixechographie" + i).value) != "") {
            prixres = parseFloat(document.getElementById("prixechographie" + i).value);
        }
        var prixresa = 0;
        if ((document.getElementById("prixechographiea" + i).value) != "") {
            prixresa = parseFloat(document.getElementById("prixechographiea" + i).value);
        }
//        alert(prixres);
//        document.getElementById("ajout_financen").reset();
        var t = montv - (prixresa) + (prixres);
        document.getElementById("montantec").value = (Math.max((((t))), 0)).toFixed(0);
        document.getElementById("prixechographiea" + i).value = (Math.max((((prixres))), 0)).toFixed(0);

    }

    function totalActe()
    {
        var montv = 0;
        if ((document.getElementById("montanta").value) != "") {
            montv = parseFloat(document.getElementById("montanta").value);
        }
        var prixres = 0;
        if ((document.getElementById("prixacte").value) != "") {
            prixres = parseFloat(document.getElementById("prixacte").value);
        }
        var prixresa = 0;
        if ((document.getElementById("prixactea").value) != "") {
            prixresa = parseFloat(document.getElementById("prixactea").value);
        }
//        alert(prixres);
//        document.getElementById("ajout_financen").reset();
        var t = montv - (prixresa) + (prixres);
        document.getElementById("montanta").value = (Math.max((((t))), 0)).toFixed(0);
        document.getElementById("prixactea").value = (Math.max((((prixres))), 0)).toFixed(0);

    }
    function totalActeNew(i)
    {
        var montv = 0;
        if ((document.getElementById("montanta").value) != "") {
            montv = parseFloat(document.getElementById("montanta").value);
        }
        var prixres = 0;
        if ((document.getElementById("prixacte" + i).value) != "") {
            prixres = parseFloat(document.getElementById("prixacte" + i).value);
        }
        var prixresa = 0;
        if ((document.getElementById("prixactea" + i).value) != "") {
            prixresa = parseFloat(document.getElementById("prixactea" + i).value);
        }
//        alert(prixres);
//        document.getElementById("ajout_financen").reset();
        var t = montv - (prixresa) + (prixres);
        document.getElementById("montanta").value = (Math.max((((t))), 0)).toFixed(0);
        document.getElementById("prixactea" + i).value = (Math.max((((prixres))), 0)).toFixed(0);

    }

    function totalOrdonnance()
    {
        var pac = 0;
        var total = 0;
        var q = 0;
        var p = 0;
        if ((document.getElementById("prixtordonnance").value) != "") {
            pac = parseFloat(document.getElementById("prixtordonnance").value);
        }
        if ((document.getElementById("montanto").value) != "") {
            total = parseFloat(document.getElementById("montanto").value);
        }
        document.getElementById("prixtordonnance").value = "";
        if ((document.getElementById("qteordonnance").value) != "") {
            q = parseFloat(document.getElementById("qteordonnance").value);
        }
        if ((document.getElementById("prixuordonnance").value) != "") {
            p = parseFloat(document.getElementById("prixuordonnance").value);
        }
        if (p > 0)
        {
            var t = q * p;
            var nt = total - pac + t;
//            Math.max(a,b) donne le plus grand entre a et b
//              toFixed(2) limite à 2 chiffres après la virgule
            document.getElementById("prixtordonnance").value = (Math.max((((t))), 0)).toFixed(0);
            document.getElementById("montanto").value = (Math.max((((nt))), 0)).toFixed(0);
            document.getElementById("prixtordonnancea").value = (Math.max((((t))), 0)).toFixed(0);

        }
    }
    function totalOrdonnanceNew(i)
    {
        var pac = 0;
        var total = 0;
        var q = 0;
        var p = 0;
        if ((document.getElementById("prixtordonnance" + i).value) != "") {
            pac = parseFloat(document.getElementById("prixtordonnance" + i).value);
        }
        if ((document.getElementById("montanto").value) != "") {
            total = parseFloat(document.getElementById("montanto").value);
        }
        document.getElementById("prixtordonnance" + i).value = "";
        if ((document.getElementById("qteordonnance" + i).value) != "") {
            q = parseFloat(document.getElementById("qteordonnance" + i).value);
        }
        if ((document.getElementById("prixuordonnance" + i).value) != "") {
            p = parseFloat(document.getElementById("prixuordonnance" + i).value);
        }
        if (p > 0)
        {
            var t = q * p;
            var nt = total - pac + t;
//            Math.max(a,b) donne le plus grand entre a et b
//              toFixed(2) limite à 2 chiffres après la virgule
            document.getElementById("prixtordonnance" + i).value = (Math.max((((t))), 0)).toFixed(0);
            document.getElementById("montanto").value = (Math.max((((nt))), 0)).toFixed(0);
            document.getElementById("prixtordonnancea" + i).value = (Math.max((((t))), 0)).toFixed(0);

        }
    }

    function raz(liste)
    {
        d = document.formvaccin.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formvaccin.elements[liste].options[t] = null;
    }

    $(document).ready(function () {
        $("#consultation2").change(function () {
            var moid = $(this).val();
//            alert("dd");
            $.ajax({
                url: './hopitalpages/hopitalvaccin/getprixconsultation.php',
                type: 'post',
                data: {ma: moid},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        document.getElementById("montantc").value = "";
                        document.getElementById("montantc").value = lib;
                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $("#prenatale").change(function () {
            var moid = $(this).val();
//            alert("dd");
            $.ajax({
                url: './hopitalpages/hopitalvaccin/getprixconsultation.php',
                type: 'post',
                data: {ma: moid},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        document.getElementById("montantcp").value = "";
                        document.getElementById("montantcp").value = lib;
                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $("#vaccin2").change(function () {
            var moid = $(this).val();
//            alert("dd");
            $.ajax({
                url: './hopitalpages/hopitalvaccin/getprixconsultation.php',
                type: 'post',
                data: {ma: moid},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        document.getElementById("montantv").value = "";
                        document.getElementById("montantv").value = lib;
                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $("#libexamen").change(function () {
            var moid = $(this).val();
//            alert("dd");
            $.ajax({
                url: './hopitalpages/hopitalvaccin/getprixexamen.php',
                type: 'post',
                data: {ma: moid},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        document.getElementById("prixexamen").value = "";
                        document.getElementById("prixexamen").value = lib;
                        totalExamen();
                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $("#libechographie").change(function () {
            var moid = $(this).val();
//            alert("dd");
            $.ajax({
                url: './hopitalpages/hopitalvaccin/getprixechographie.php',
                type: 'post',
                data: {ma: moid},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        document.getElementById("prixechographie").value = "";
                        document.getElementById("prixechographie").value = lib;
                        totalEchographie();
                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $("#libacte").change(function () {
            var moid = $(this).val();
//            alert("dd");
            $.ajax({
                url: './hopitalpages/hopitalvaccin/getprixacte.php',
                type: 'post',
                data: {ma: moid},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        document.getElementById("prixacte").value = "";
                        document.getElementById("prixacte").value = lib;
                        totalActe();
                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $("#libordonnance").change(function () {
            var moid = $(this).val();
//            alert(moid);
            raz("uniteordonnance");
            $.ajax({
                url: 'hopitalpages/hopitalvaccin/getunite.php',
                type: 'post',
                data: {moid: moid},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        var servi = lib.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formvaccin.elements["uniteordonnance"].options[document.formvaccin.elements["uniteordonnance"].length] = new_options;

                    }
                }
            });
        });
    });

    $(document).ready(function () {
        $("#uniteordonnance").change(function () {
            var moid = $(this).val();
            var moidp = document.getElementById("libordonnance").value;
//            alert("dd");
            $.ajax({
                url: './hopitalpages/hopitalvaccin/getprixproduit.php',
                type: 'post',
                data: {ma: moid, map: moidp},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        document.getElementById("prixuordonnance").value = "";
                        document.getElementById("prixuordonnance").value = lib;
                        totalOrdonnance();
                    }
                }
            });
        });
    });

    var cexa, c2exa, d1exa, d2exa, d3exa, d4exa, chexa, chexa1,
            labelexa, labelexa1,
            dexa, selectexa, dselexa;

    function exavplus() {
        cexa = document.getElementById("cadreexa");
        dpexa = document.createElement("p");
        dexa = document.createElement("div");
        c2exa = cexa.getElementsByTagName("p");
        brexa = document.createElement("br");

        d1exa = document.createElement("div");
        d2exa = document.createElement("div");
        labelexa = document.createElement("label");
        selectexa = document.createElement("select");

        d3exa = document.createElement("div");
        labelexa1 = document.createElement("label");
        d4exa = document.createElement("div");
        chexa = document.createElement("input");

        chexa1 = document.createElement("input");

        labelexa = document.createTextNode("Examen : ");
        labelexa1 = document.createTextNode("Prix : ");

        dexa.setAttribute("class", "row");
        d1exa.setAttribute("class", "col-lg-8 col-md-8 col-sm-8 col-xs-12");
        d2exa.setAttribute("class", "chosen-select-single");
        d3exa.setAttribute("class", "col-lg-4 col-md-4 col-sm-4 col-xs-12");
        d4exa.setAttribute("class", "input-group mg-b-pro-edt");

        selectexa.setAttribute("class", "chosen-select form-control libexamenn");
        selectexa.setAttribute("name", "libexamen" + c2exa.length);
        selectexa.setAttribute("id", c2exa.length);

        theOption = document.createElement("OPTION");
        theText = document.createTextNode(" -Choisissez un Examen- ");
        theOption.setAttribute("value", "");
        theOption.appendChild(theText);

        selectexa.appendChild(theOption);


        chexa.setAttribute("type", "text");
        chexa.setAttribute("class", "form-control");
        chexa.setAttribute("name", "prixexamen" + c2exa.length);
        chexa.setAttribute("id", "prixexamen" + c2exa.length);
        chexa.setAttribute("value", "");
        chexa.setAttribute("readonly", "");

        chexa1.setAttribute("type", "hidden");
        chexa1.setAttribute("class", "");
        chexa1.setAttribute("name", "prixexamena" + c2exa.length);
        chexa1.setAttribute("id", "prixexamena" + c2exa.length);
        chexa1.setAttribute("value", "");

        cexa.appendChild(dpexa);
//        c.appendChild(br);

        dpexa.appendChild(dexa);

        dexa.appendChild(d1exa);
        dexa.appendChild(d3exa);

        d1exa.appendChild(d2exa);
        d2exa.appendChild(labelexa);
        d2exa.appendChild(selectexa);

        d3exa.appendChild(labelexa1);
        d3exa.appendChild(d4exa);
        d4exa.appendChild(chexa);
        d4exa.appendChild(chexa1);


        document.getElementById("supexa").style.display = "inline";
        document.getElementById('examennb').value = c2exa.length;
        lexa = c2exa.length;

//alert(cstr);
        $.ajax({
            url: 'hopitalpages/hopitalvaccin/getexamen.php',
            type: 'post',
//            data: {cstra: cstr},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['ide'];
                    var refexa = response[i]['libe'];
                    var type = response[i]['type'];
                    var prix = response[i]['prix'];
                    var name = refexa + " - " + type + " - " + prix;

//                            $("#libexamen" + c2.length).append("<option value='"+id+"'>"+refexa+" - "+name+"</option>");
                    var servi = name.replace(/&#039;/gi, "\'");

                    theOption = document.createElement("OPTION");
                    theText = document.createTextNode(servi);
                    theOption.setAttribute("value", id);
                    theOption.appendChild(theText);

                    selectexa.appendChild(theOption);

                }

                selectexa.onchange = function () {
                    var exaid = $(this).val();

                    var exaid2 = $(this).attr('id');
                    var num = exaid2.substring(6);

                    $.ajax({
                        url: './hopitalpages/hopitalvaccin/getprixexamen.php',
                        type: 'post',
                        data: {ma: exaid},
                        dataType: 'json',
                        success: function (response) {
                            var len = response.length;
                            for (var i = 0; i < len; i++) {
                                var id = response[i]['ide'];
                                var lib = response[i]['libe'];

                                document.getElementById("prixexamen" + exaid2).value = "";
                                document.getElementById("prixexamen" + exaid2).value = lib;
                            }

                            totalExamenNew(exaid2);
                        }
                    });
                };

            }
        });

    }

    function examoins(b) {
        var pac = 0;
        var total = 0;

        if ((document.getElementById("montante").value) != "") {
            total = parseFloat(document.getElementById("montante").value);
        }
        if (!c2exa[1]) {

            if ((document.getElementById("prixexamen" + 0).value) != "") {
                pac = parseFloat(document.getElementById("prixexamen" + 0).value);
            }
            var nt = total - pac;
            document.getElementById("montante").value = (Math.max((((nt))), 0)).toFixed(2);
            b.style.display = "none";
        }

        if (c2exa[0]) {
            if ((document.getElementById("prixexamen" + (c2exa.length - 1)).value) != "") {
                pac = parseFloat(document.getElementById("prixexamen" + (c2exa.length - 1)).value);
            }
            var nt = total - pac;
            document.getElementById("montante").value = (Math.max((((nt))), 0)).toFixed(2);
            cexa.removeChild(c2exa[c2exa.length - 1]);
        }
        document.getElementById('examennb').value = c2exa.length;
        lexa = c2exa.length;
    }

    var cecho, c2echo, d1echo, d2echo, d3echo, d4echo, checho, checho1,
            labelecho, labelecho1,
            decho, selectecho, dselecho;

    function echovplus() {
        cecho = document.getElementById("cadreecho");
        dpecho = document.createElement("p");
        decho = document.createElement("div");
        c2echo = cecho.getElementsByTagName("p");
        brecho = document.createElement("br");

        d1echo = document.createElement("div");
        d2echo = document.createElement("div");
        labelecho = document.createElement("label");
        selectecho = document.createElement("select");

        d3echo = document.createElement("div");
        labelecho1 = document.createElement("label");
        d4echo = document.createElement("div");
        checho = document.createElement("input");

        checho1 = document.createElement("input");

        labelecho = document.createTextNode("Echographie : ");
        labelecho1 = document.createTextNode("Prix : ");

        decho.setAttribute("class", "row");
        d1echo.setAttribute("class", "col-lg-8 col-md-8 col-sm-8 col-xs-12");
        d2echo.setAttribute("class", "chosen-select-single");
        d3echo.setAttribute("class", "col-lg-4 col-md-4 col-sm-4 col-xs-12");
        d4echo.setAttribute("class", "input-group mg-b-pro-edt");

        selectecho.setAttribute("class", "chosen-select form-control libechographien");
        selectecho.setAttribute("name", "libechographie" + c2echo.length);
        selectecho.setAttribute("id", c2echo.length);

        theOption = document.createElement("OPTION");
        theText = document.createTextNode(" -Choisissez un Echographie- ");
        theOption.setAttribute("value", "");
        theOption.appendChild(theText);

        selectecho.appendChild(theOption);


        checho.setAttribute("type", "text");
        checho.setAttribute("class", "form-control");
        checho.setAttribute("name", "prixechographie" + c2echo.length);
        checho.setAttribute("id", "prixechographie" + c2echo.length);
        checho.setAttribute("value", "");
        checho.setAttribute("readonly", "");

        checho1.setAttribute("type", "hidden");
        checho1.setAttribute("class", "");
        checho1.setAttribute("name", "prixechographiea" + c2echo.length);
        checho1.setAttribute("id", "prixechographiea" + c2echo.length);
        checho1.setAttribute("value", "");

        cecho.appendChild(dpecho);
//        c.appendChild(br);

        dpecho.appendChild(decho);

        decho.appendChild(d1echo);
        decho.appendChild(d3echo);

        d1echo.appendChild(d2echo);
        d2echo.appendChild(labelecho);
        d2echo.appendChild(selectecho);

        d3echo.appendChild(labelecho1);
        d3echo.appendChild(d4echo);
        d4echo.appendChild(checho);
        d4echo.appendChild(checho1);


        document.getElementById("supecho").style.display = "inline";
        document.getElementById('echographienb').value = c2echo.length;
        lecho = c2echo.length;

//alert(cstr);
        $.ajax({
            url: 'hopitalpages/hopitalvaccin/getechographie.php',
            type: 'post',
//            data: {cstra: cstr},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['ide'];
                    var refecho = response[i]['libe'];
                    var type = response[i]['type'];
                    var prix = response[i]['prix'];
                    var name = refecho + " - " + prix;

//                            $("#libechographie" + c2.length).append("<option value='"+id+"'>"+refecho+" - "+name+"</option>");
                    var servi = name.replace(/&#039;/gi, "\'");

                    theOption = document.createElement("OPTION");
                    theText = document.createTextNode(servi);
                    theOption.setAttribute("value", id);
                    theOption.appendChild(theText);

                    selectecho.appendChild(theOption);

                }

                selectecho.onchange = function () {
                    var echoid = $(this).val();

                    var echoid2 = $(this).attr('id');
                    var num = echoid2.substring(6);

                    $.ajax({
                        url: './hopitalpages/hopitalvaccin/getprixechographie.php',
                        type: 'post',
                        data: {ma: echoid},
                        dataType: 'json',
                        success: function (response) {
                            var len = response.length;
                            for (var i = 0; i < len; i++) {
                                var id = response[i]['ide'];
                                var lib = response[i]['libe'];

                                document.getElementById("prixechographie" + echoid2).value = "";
                                document.getElementById("prixechographie" + echoid2).value = lib;
                            }

                            totalEchographieNew(echoid2);
                        }
                    });
                };

            }
        });

    }

    function echomoins(b) {
        var pac = 0;
        var total = 0;

        if ((document.getElementById("montantec").value) != "") {
            total = parseFloat(document.getElementById("montantec").value);
        }
        if (!c2echo[1]) {

            if ((document.getElementById("prixechographie" + 0).value) != "") {
                pac = parseFloat(document.getElementById("prixechographie" + 0).value);
            }
            var nt = total - pac;
            document.getElementById("montantec").value = (Math.max((((nt))), 0)).toFixed(2);
            b.style.display = "none";
        }

        if (c2echo[0]) {
            if ((document.getElementById("prixechographie" + (c2echo.length - 1)).value) != "") {
                pac = parseFloat(document.getElementById("prixechographie" + (c2echo.length - 1)).value);
            }
            var nt = total - pac;
            document.getElementById("montantec").value = (Math.max((((nt))), 0)).toFixed(2);
            cecho.removeChild(c2echo[c2echo.length - 1]);
        }
        document.getElementById('echographienb').value = c2echo.length;
        lecho = c2echo.length;
    }

    var cact, c2act, d1act, d2act, d3act, d4act, chact, chact1,
            labelact, labelact1,
            dact, selectact, dselact;

    function actvplus() {
        cact = document.getElementById("cadreact");
        dpact = document.createElement("p");
        dact = document.createElement("div");
        c2act = cact.getElementsByTagName("p");
        bract = document.createElement("br");

        d1act = document.createElement("div");
        d2act = document.createElement("div");
        labelact = document.createElement("label");
        selectact = document.createElement("select");

        d3act = document.createElement("div");
        labelact1 = document.createElement("label");
        d4act = document.createElement("div");
        chact = document.createElement("input");

        chact1 = document.createElement("input");

        labelact = document.createTextNode("Acte : ");
        labelact1 = document.createTextNode("Prix : ");

        dact.setAttribute("class", "row");
        d1act.setAttribute("class", "col-lg-8 col-md-8 col-sm-8 col-xs-12");
        d2act.setAttribute("class", "chosen-select-single");
        d3act.setAttribute("class", "col-lg-4 col-md-4 col-sm-4 col-xs-12");
        d4act.setAttribute("class", "input-group mg-b-pro-edt");

        selectact.setAttribute("class", "chosen-select form-control libacten");
        selectact.setAttribute("name", "libacte" + c2act.length);
        selectact.setAttribute("id", c2act.length);

        theOption = document.createElement("OPTION");
        theText = document.createTextNode(" -Choisissez un Acte- ");
        theOption.setAttribute("value", "");
        theOption.appendChild(theText);

        selectact.appendChild(theOption);


        chact.setAttribute("type", "text");
        chact.setAttribute("class", "form-control");
        chact.setAttribute("name", "prixacte" + c2act.length);
        chact.setAttribute("id", "prixacte" + c2act.length);
        chact.setAttribute("value", "");
        chact.setAttribute("readonly", "");

        chact1.setAttribute("type", "hidden");
        chact1.setAttribute("class", "");
        chact1.setAttribute("name", "prixactea" + c2act.length);
        chact1.setAttribute("id", "prixactea" + c2act.length);
        chact1.setAttribute("value", "");

        cact.appendChild(dpact);
//        c.appendChild(br);

        dpact.appendChild(dact);

        dact.appendChild(d1act);
        dact.appendChild(d3act);

        d1act.appendChild(d2act);
        d2act.appendChild(labelact);
        d2act.appendChild(selectact);

        d3act.appendChild(labelact1);
        d3act.appendChild(d4act);
        d4act.appendChild(chact);
        d4act.appendChild(chact1);


        document.getElementById("supact").style.display = "inline";
        document.getElementById('actenb').value = c2act.length;
        lact = c2act.length;

//alert(cstr);
        $.ajax({
            url: 'hopitalpages/hopitalvaccin/getacte.php',
            type: 'post',
//            data: {cstra: cstr},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['ide'];
                    var refact = response[i]['libe'];
                    var type = response[i]['type'];
                    var prix = response[i]['prix'];
                    var name = refact + " - " + prix;

//                            $("#libacte" + c2.length).append("<option value='"+id+"'>"+refact+" - "+name+"</option>");
                    var servi = name.replace(/&#039;/gi, "\'");

                    theOption = document.createElement("OPTION");
                    theText = document.createTextNode(servi);
                    theOption.setAttribute("value", id);
                    theOption.appendChild(theText);

                    selectact.appendChild(theOption);

                }

                selectact.onchange = function () {
                    var actid = $(this).val();

                    var actid2 = $(this).attr('id');
                    var num = actid2.substring(6);

                    $.ajax({
                        url: './hopitalpages/hopitalvaccin/getprixacte.php',
                        type: 'post',
                        data: {ma: actid},
                        dataType: 'json',
                        success: function (response) {
                            var len = response.length;
                            for (var i = 0; i < len; i++) {
                                var id = response[i]['ide'];
                                var lib = response[i]['libe'];

                                document.getElementById("prixacte" + actid2).value = "";
                                document.getElementById("prixacte" + actid2).value = lib;
                            }

                            totalActeNew(actid2);
                        }
                    });
                };

            }
        });

    }

    function actmoins(b) {
        var pac = 0;
        var total = 0;

        if ((document.getElementById("montanta").value) != "") {
            total = parseFloat(document.getElementById("montanta").value);
        }
        if (!c2act[1]) {

            if ((document.getElementById("prixacte" + 0).value) != "") {
                pac = parseFloat(document.getElementById("prixacte" + 0).value);
            }
            var nt = total - pac;
            document.getElementById("montanta").value = (Math.max((((nt))), 0)).toFixed(2);
            b.style.display = "none";
        }

        if (c2act[0]) {
            if ((document.getElementById("prixacte" + (c2act.length - 1)).value) != "") {
                pac = parseFloat(document.getElementById("prixacte" + (c2act.length - 1)).value);
            }
            var nt = total - pac;
            document.getElementById("montanta").value = (Math.max((((nt))), 0)).toFixed(2);
            cact.removeChild(c2act[c2act.length - 1]);
        }
        document.getElementById('actenb').value = c2act.length;
        lact = c2act.length;
    }

    var cordo, c2ordo, d1ordo, d2ordo, d3ordo, d4ordo, d5ordo, d6ordo, d7ordo, d8ordo, d9ordo, d10ordo, chordo, chordo1,
            chordo2, chordo3, labelordo, labelordo1, labelordo2, labelordo3, labelordo4, dordo, selectordo, selectordou,
            dselordo;

    function ordovplus() {
        cordo = document.getElementById("cadreordo");
        dpordo = document.createElement("p");
        dordo = document.createElement("div");
        c2ordo = cordo.getElementsByTagName("p");
        brordo = document.createElement("br");

        d1ordo = document.createElement("div");
        d2ordo = document.createElement("div");
        labelordo = document.createElement("label");
        selectordo = document.createElement("select");

        d5ordo = document.createElement("div");
        d6ordo = document.createElement("div");
        labelordo2 = document.createElement("label");
        selectordou = document.createElement("select");

        d3ordo = document.createElement("div");
        labelordo1 = document.createElement("label");
        d4ordo = document.createElement("div");
        chordo = document.createElement("input");

        chordo1 = document.createElement("input");
        chordo2 = document.createElement("input");

        d7ordo = document.createElement("div");
        labelordo3 = document.createElement("label");
        d8ordo = document.createElement("div");

        d9ordo = document.createElement("div");
        dselordo = document.createElement("div");
        labelordo4 = document.createElement("label");
        d10ordo = document.createElement("div");
        chordo3 = document.createElement("input");

        labelordo = document.createTextNode("Produit : ");
        labelordo2 = document.createTextNode("Unité : ");
        labelordo1 = document.createTextNode("Quantité : ");
        labelordo3 = document.createTextNode("Prix Unitaire : ");
        labelordo4 = document.createTextNode("Prix Total : ");

        dordo.setAttribute("class", "row");
        d1ordo.setAttribute("class", "col-lg-4 col-md-4 col-sm-4 col-xs-8");
        d2ordo.setAttribute("class", "chosen-select-single");

        d5ordo.setAttribute("class", "col-lg-2 col-md-2 col-sm-2 col-xs-4");
        d6ordo.setAttribute("class", "chosen-select-single");

        d3ordo.setAttribute("class", "col-lg-2 col-md-2 col-sm-2 col-xs-4");
        d4ordo.setAttribute("class", "input-group mg-b-pro-edt");

        d7ordo.setAttribute("class", "col-lg-2 col-md-2 col-sm-2 col-xs-4");
        d8ordo.setAttribute("class", "input-group mg-b-pro-edt");
        d9ordo.setAttribute("class", "col-lg-2 col-md-2 col-sm-2 col-xs-4");
        d10ordo.setAttribute("class", "input-group mg-b-pro-edt");

        selectordo.setAttribute("class", "chosen-select form-control libordonnancen");
        selectordo.setAttribute("name", "libordonnance" + c2ordo.length);
        selectordo.setAttribute("id", c2ordo.length);

        theOption = document.createElement("OPTION");
        theText = document.createTextNode(" -Choisissez un Accessoire- ");
        theOption.setAttribute("value", "");
        theOption.appendChild(theText);

        selectordo.appendChild(theOption);

        selectordou.setAttribute("class", "chosen-select form-control");
        selectordou.setAttribute("name", "uniteordonnance" + c2ordo.length);
        selectordou.setAttribute("id", c2ordo.length);

        theOptionu = document.createElement("OPTION");
        theTextu = document.createTextNode(" -Choisissez une unité- ");
        theOptionu.setAttribute("value", "");
        theOptionu.appendChild(theTextu);

        selectordou.appendChild(theOptionu);

        chordo.setAttribute("type", "text");
        chordo.setAttribute("class", "");
        chordo.setAttribute("name", "qteordonnance" + c2ordo.length);
        chordo.setAttribute("id", "qteordonnance" + c2ordo.length);
        chordo.setAttribute("value", "");
        chordo.setAttribute("onkeyup", "totalOrdonnanceNew(" + c2ordo.length + ");");

        chordo1.setAttribute("type", "text");
        chordo1.setAttribute("class", "");
        chordo1.setAttribute("name", "prixuordonnance" + c2ordo.length);
        chordo1.setAttribute("id", "prixuordonnance" + c2ordo.length);
        chordo1.setAttribute("value", "");
        chordo1.setAttribute("readonly", "");

        chordo2.setAttribute("type", "hidden");
        chordo2.setAttribute("class", "");
        chordo2.setAttribute("name", "prixtordonnancea" + c2ordo.length);
        chordo2.setAttribute("id", "prixtordonnancea" + c2ordo.length);
        chordo2.setAttribute("value", "");

        chordo3.setAttribute("type", "text");
        chordo3.setAttribute("class", "");
        chordo3.setAttribute("name", "prixtordonnance" + c2ordo.length);
        chordo3.setAttribute("id", "prixtordonnance" + c2ordo.length);
        chordo3.setAttribute("value", "");
        chordo1.setAttribute("readonly", "");

        cordo.appendChild(dpordo);
//        c.appendChild(br);

        dpordo.appendChild(dordo);

        dordo.appendChild(d1ordo);
        dordo.appendChild(d5ordo);
        dordo.appendChild(d3ordo);
        dordo.appendChild(d7ordo);
        dordo.appendChild(d9ordo);

        d1ordo.appendChild(d2ordo);
        d2ordo.appendChild(labelordo);
        d2ordo.appendChild(selectordo);

        d5ordo.appendChild(d6ordo);
        d6ordo.appendChild(labelordo2);
        d6ordo.appendChild(selectordou);

        d3ordo.appendChild(labelordo1);
        d3ordo.appendChild(d4ordo);
        d4ordo.appendChild(chordo);

        d7ordo.appendChild(labelordo3);
        d7ordo.appendChild(d8ordo);
        d8ordo.appendChild(chordo1);
        d8ordo.appendChild(chordo2);

        d9ordo.appendChild(labelordo4);
        d9ordo.appendChild(d10ordo);
        d10ordo.appendChild(chordo3);

        document.getElementById("supordo").style.display = "inline";
        document.getElementById('ordonnancenb').value = c2ordo.length;
        lordo = c2ordo.length;

//alert(cstr);

        $.ajax({
            url: 'hopitalpages/hopitalvaccin/getproduit.php',
            type: 'post',
//            data: {cstra: cstr},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['ide'];
                    var refmoc = response[i]['code'];
                    var refmo = response[i]['libe'];
                    var nname = refmoc + " - " + refmo;

//                            $("#liblignesoin" + c2.length).append("<option value='"+id+"'>"+refmo+" - "+name+"</option>");
                    var servi = nname.replace(/&#039;/gi, "\'");

                    theOption = document.createElement("OPTION");
                    theText = document.createTextNode(servi);
                    theOption.setAttribute("value", id);
                    theOption.appendChild(theText);

                    selectordo.appendChild(theOption);

                }

                selectordo.onchange = function () {
                    var moid = $(this).val();

                    var moid2 = $(this).attr('id');
                    var num = moid2.substring(6);

                    raz("uniteordonnance" + moid2);
                    $.ajax({
                        url: 'hopitalpages/hopitalvaccin/getunite.php',
                        type: 'post',
                        data: {moid: moid},
                        dataType: 'json',
                        success: function (response) {
                            var len = response.length;
                            for (var i = 0; i < len; i++) {
                                var id = response[i]['ide'];
                                var lib = response[i]['libe'];
//                            alert(lib);
                                //                            $("#liblignesoin" + c2.length).append("<option value='"+id+"'>"+refmo+" - "+name+"</option>");
                                var serviu = lib.replace(/&#039;/gi, "\'");
                                theOptionu = document.createElement("OPTION");
                                theTextu = document.createTextNode(serviu);
                                theOptionu.setAttribute("value", id);
                                theOptionu.appendChild(theTextu);

                                selectordou.appendChild(theOptionu);
                            }
                            selectordou.onchange = function () {
                                var ordoidu = $(this).val();

                                var ordoid2u = $(this).attr('id');
                                var numu = ordoid2u.substring(6);

//                                alert('ddd');
                                $.ajax({
                                    url: './hopitalpages/hopitalvaccin/getprixproduit.php',
                                    type: 'post',
                                    data: {ma: ordoidu, map: moid},
                                    dataType: 'json',
                                    success: function (responseu) {
                                        var len = responseu.length;
                                        for (var i = 0; i < len; i++) {
                                            var idu = responseu[i]['ide'];
                                            var libu = responseu[i]['libe'];

                                            document.getElementById("prixuordonnance" + ordoid2u).value = "";
                                            document.getElementById("prixuordonnance" + ordoid2u).value = libu;
                                            totalOrdonnanceNew(ordoid2u);
                                        }
                                    }

                                });
                            };

                        }
                    });
                };

            }
        });

    }

    function ordomoins(b) {
        var pac = 0;
        var total = 0;

        if ((document.getElementById("montanto").value) != "") {
            total = parseFloat(document.getElementById("montanto").value);
        }
        if (!c2ordo[1]) {

            if ((document.getElementById("prixtordonnance" + 0).value) != "") {
                pac = parseFloat(document.getElementById("prixtordonnance" + 0).value);
            }
            var nt = total - pac;
            document.getElementById("montanto").value = (Math.max((((nt))), 0)).toFixed(2);
            b.style.display = "none";
        }

        if (c2ordo[0]) {
            if ((document.getElementById("prixtordonnance" + (c2ordo.length - 1)).value) != "") {
                pac = parseFloat(document.getElementById("prixtordonnance" + (c2ordo.length - 1)).value);
            }
            var nt = total - pac;
            document.getElementById("montanto").value = (Math.max((((nt))), 0)).toFixed(2);
            cordo.removeChild(c2ordo[c2ordo.length - 1]);
        }
        document.getElementById('ordonnancenb').value = c2ordo.length;
        lordo = c2ordo.length;
    }


    // JavaScript Document
// autocomplet : this function will be executed every time we change the text
    function findPatient() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyworda = $('#recherche').val();
        if (keyworda.length >= min_length) {
            $.ajax({
                url: 'hopitalpages/hopitalvaccin/ajax_refresh.php',
                type: 'POST',
                data: {keyworda: keyworda},
                success: function (data) {
                    $('#vaccin_list_id').show();
                    $('#vaccin_list_id').html(data);
                }
            });
        } else {
            $('#vaccin_list_id').hide();
        }
    }

    // JavaScript Document
// autocomplet : this function will be executed every time we change the text
    function findPatientNom() {
        var min_length = 1; // min caracters to display the autocomplete
        var keyworda = $('#nom').val();
        if (keyworda.length >= min_length) {
            $.ajax({
                url: 'hopitalpages/hopitalvaccin/ajax_refresh_nom.php',
                type: 'POST',
                data: {keyworda: keyworda},
                success: function (data) {
                    $('#vaccinnom_list_id').show();
                    $('#vaccinnom_list_id').html(data);
                }
            });
        } else {
            $('#vaccinnom_list_id').hide();
        }
    }

// set_item : this function will be executed when we select an item
    function set_item(id, item) {
        // change input value
        $('#recherche').val(item);
        // hide proposition list
        $('#vaccin_list_id').hide();
        var moid = id;
//        alert(moid);
        $.ajax({
            url: './hopitalpages/hopitalvaccin/getvaccin.php',
            type: 'post',
            data: {ma: moid},
            dataType: 'json',
            success: function (response) {
//                alert('ffff');
                var len = response.length;
//                alert(len);
                for (var i = 0; i < len; i++) {
                    if ((response[i]['ide'] != null)) {
                        var ide = (response[i]['ide']);
                        var nom = (response[i]['nom']);
                        var quartier = (response[i]['quartier']);
                        var lieun = (response[i]['lieun']);
                        var tel = (response[i]['tel']);
                        var telpac = (response[i]['telpac']);
                        var daten = (response[i]['daten']);
                        var regid = (response[i]['regid']);
                        var reg = (response[i]['reg']);
                        var depid = (response[i]['depid']);
                        var dep = (response[i]['dep']);
                        var prof = (response[i]['prof']);
                        var sitmat = (response[i]['sitmat']);
                        var sex = (response[i]['sex']);
                        document.getElementById("idvaccin").value = "";
                        document.getElementById("nom").value = "";
                        document.getElementById("quartier").value = "";
                        document.getElementById("datenais").value = "";
                        document.getElementById("tel").value = "";
                        document.getElementById("telc").value = "";
                        document.getElementById("lieunais").value = "";
//                        document.getElementById("regor").value = "";
//                        document.getElementById("regorlib").value = "";
                        document.getElementById("residence").value = "";
//                        document.getElementById("deporlib").value = "";
                        document.getElementById("profession").value = "";
                        document.getElementById("sitmat").value = "";
                        document.getElementById("sexe").value = "";
//                        alert('ffff');
                        document.getElementById("idvaccin").value = ide;
                        document.getElementById("nom").value = nom;
                        document.getElementById("quartier").value = quartier;
                        document.getElementById("datenais").value = daten;
                        document.getElementById("tel").value = tel;
                        document.getElementById("telc").value = telpac;
                        document.getElementById("lieunais").value = lieun;
//                        document.getElementById("regor").value = regid;
//                        document.getElementById("regorlib").value = reg;
                        document.getElementById("residence").value = depid;
//                        document.getElementById("deporlib").value = dep;
                        document.getElementById("profession").value = prof;
                        document.getElementById("sexe").value = sex;
                        document.getElementById("sitmat").value = sitmat;

                    } else {
//                        alert('poiii');
                    }
                }
            }
        });
    }


// set_item : this function will be executed when we select an item
    function set_item_nom(id, item) {
        // change input value
        $('#nom').val(item);
        // hide proposition list
        $('#vaccinnom_list_id').hide();
        var moid = id;
//        alert(moid);
        $.ajax({
            url: './hopitalpages/hopitalvaccin/getvaccin.php',
            type: 'post',
            data: {ma: moid},
            dataType: 'json',
            success: function (response) {
//                alert('ffff');
                var len = response.length;
//                alert(len);
                for (var i = 0; i < len; i++) {
                    if ((response[i]['ide'] != null)) {
                        var ide = (response[i]['ide']);
                        var nom = (response[i]['nom']);
                        var code = (response[i]['code']);
                        var quartier = (response[i]['quartier']);
                        var lieun = (response[i]['lieun']);
                        var tel = (response[i]['tel']);
                        var telpac = (response[i]['telpac']);
                        var daten = (response[i]['daten']);
                        var regid = (response[i]['regid']);
                        var reg = (response[i]['reg']);
                        var depid = (response[i]['depid']);
                        var dep = (response[i]['dep']);
                        var prof = (response[i]['prof']);
                        var sitmat = (response[i]['sitmat']);
                        var sex = (response[i]['sex']);
                        document.getElementById("idvaccin").value = "";
                        document.getElementById("recherche").value = "";
                        document.getElementById("nom").value = "";
                        document.getElementById("quartier").value = "";
                        document.getElementById("datenais").value = "";
                        document.getElementById("tel").value = "";
                        document.getElementById("telc").value = "";
                        document.getElementById("lieunais").value = "";
//                        document.getElementById("regor").value = "";
//                        document.getElementById("regorlib").value = "";
                        document.getElementById("residence").value = "";
//                        document.getElementById("deporlib").value = "";
                        document.getElementById("profession").value = "";
                        document.getElementById("sitmat").value = "";
                        document.getElementById("sexe").value = "";
//                        alert('ffff');
                        document.getElementById("idvaccin").value = ide;
                        document.getElementById("recherche").value = code;
                        document.getElementById("nom").value = nom;
                        document.getElementById("quartier").value = quartier;
                        document.getElementById("datenais").value = daten;
                        document.getElementById("tel").value = tel;
                        document.getElementById("telc").value = telpac;
                        document.getElementById("lieunais").value = lieun;
//                        document.getElementById("regor").value = regid;
//                        document.getElementById("regorlib").value = reg;
                        document.getElementById("residence").value = depid;
//                        document.getElementById("deporlib").value = dep;
                        document.getElementById("profession").value = prof;
                        document.getElementById("sexe").value = sex;
                        document.getElementById("sitmat").value = sitmat;

                    } else {
//                        alert('poiii');
                    }
                }
            }
        });
    }


</script>
