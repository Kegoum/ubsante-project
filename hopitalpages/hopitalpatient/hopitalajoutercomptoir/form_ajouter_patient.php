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
                                <h1>Enregistrement d'un patient Comptoir</h1>
                            </div>
                        </div>
                        <form id="ajout_patient" name="formpatientcomptoir" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalajoutercomptoir/ajout_patient'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                           <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Date du jour <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input value="<?php echo $_SESSION['formpatientcomptoir'][NUM_PAGE]["datejourp"]; ?>" class="form-control" placeholder="" type="date" name="datejourp" id="datejourp"  />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Heure du jour <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input value="<?php echo $_SESSION['formpatientcomptoir'][NUM_PAGE]["heurejourp"]; ?>" class="form-control" placeholder="" type="time" name="heurejourp" id="heurejourp"  />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group" id="monto">
                                        <label class="control-label" >Montant &agrave; payer <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formpatientcomptoir'][NUM_PAGE]["montanto"]; ?>" class="form-control" placeholder="" type="text" name="montanto" id="montanto" required readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <fieldset class="space_data"  id="ordo" ><legend class="titre">Ordonnance</legend>
                                <div id="cadreordo" style=" font-size: 10px;">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
                                            <div class="chosen-select-single">
                                                <label class="control-label">Ordonnance <g style="color: red">*</g></label>
                                                <?php
                                                $rsltbvo = $con->query("select * from hp_produit as a left join hp_categorie as c on a.idcategorie=c.idcategorie "
                                                        . "where a.etatproduit=true ") or die(mysqli_error($con));
                                                ?>
                                                <select data-placeholder="Choisissez un Produit..." class="chosen-select form-control" name="libordonnance" id="libordonnance" required>
                                                    <option value="" >- Choisissez un Produit-</option>
                                                    <?php
                                                    /* Construction de la première liste : on se sert du tableau PHP */
                                                    while ($rowr = mysqli_fetch_assoc($rsltbvo)) {
                                                        ?>
                                                        <option value="<?php echo($rowr['idproduit']); ?>" <?php if (($rowr["idproduit"] == $_SESSION['formpatientcomptoir'][NUM_PAGE]["libordonnance"])) { ?> selected <?php } ?>><?php echo($rowr["codeproduit"]); ?> - <?php echo($rowr["libelleproduit"]); ?> - <?php // echo($rowr["prixventeproduit"]);  ?> </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                            <div class="chosen-select-single">
                                                <label class="control-label" >Unit&eacute; &nbsp;</label><br>
                                                <select data-placeholder="Choisissez une Unit&eacute;..." name="uniteordonnance" id="uniteordonnance" class=" ">
                                                    <option value="">Choisissez une Unit&eacute;</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">

                                            <label class="control-label" >Quantit&eacute; &nbsp;</label>
                                            <div class="input-group mg-b-pro-edt">
                                                <!--<span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>-->
                                                <input value="<?php echo $_SESSION['formpatientcomptoir'][NUM_PAGE]["qteordonnance"]; ?>" class="" placeholder="" type="text" name="qteordonnance" id="qteordonnance" onkeyup="totalOrdonnance();" />
                                            </div>

                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">

                                            <label class="control-label" >Prix Unitaire </label>
                                            <div class="input-group mg-b-pro-edt">
                                                <!--<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>-->
                                                <input value="<?php echo $_SESSION['formpatientcomptoir'][NUM_PAGE]["prixuordonnance"]; ?>" class="" placeholder="" type="text" name="prixuordonnance" id="prixuordonnance" readonly onkeyup="CalculTotalMO();" />
                                            </div>

                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">

                                            <label class="control-label" >Prix Total </label>
                                            <div class="input-group mg-b-pro-edt">
                                                <!--<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>-->
                                                <input value="<?php echo $_SESSION['formpatientcomptoir'][NUM_PAGE]["prixtordonnance"]; ?>" class="" placeholder="" type="text" name="prixtordonnance" id="prixtordonnance" readonly />
                                            </div>

                                        </div>
                                    </div>
                                    <input value="0" class="" placeholder="" type="hidden" name="prixtordonnancea" id="prixtordonnancea" readonly />
                                    <input name="ordonnancenb" type="hidden" id="ordonnancenb" value="<?php echo $_SESSION['formpatientcomptoir'][NUM_PAGE]['ordonnancenb']; ?>">

                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="button" class=" btn-danger" value="Ajouter Un Produit" onclick="ordovplus()" />
                                        <input type="button" class=" btn-danger" style="display:none" id="supordo" value="Supprimer Un Produit" onclick="ordomoins(this)" />
                                    </div>
                                </div>
                            </fieldset> 
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
                                                <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>
                                                <button id="validateBtn" type="submit" name="inspatient" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Suivant</button>
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

        $('#ajout_patient').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nom: {
                    message: 'Nom de l\'patient invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de l\'patient est obligatoire'
                        }
                    }
                },
                role: {
                    message: 'Rôle de l\'patient invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le Rôle de l\'patient est obligatoire'
                        }
                    }
                },
                login: {
                    message: 'Login de l\'patient invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le login de l\'patient est obligatoire'
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
                            message: 'Le mot de passe de l\'patient est obligatoire'
                        },
                        identical: {
                            field: 'pass2'
                        }
//                        ,
//                        remote: {
//                            type: 'POST',
//                            url: './hopitalpages/hopitalpatient/remoteformvalidationpatient.php',
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
//                            url: './hopitalpages/hopitalpatient/remoteformvalidationpatient.php',
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
                    message: 'Téléphone de l\'patient invalide',
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
//        $('#ajout_patient').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_patient').data('bootstrapValidator').resetForm(true);
//    });
    });

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
        d = document.formpatientcomptoir.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formpatientcomptoir.elements[liste].options[t] = null;
    }

    $(document).ready(function () {
        $("#libordonnance").change(function () {
            var moid = $(this).val();
//            alert(moid);
            raz("uniteordonnance");
            $.ajax({
                url: 'hopitalpages/hopitalpatient/getunite.php',
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
                        document.formpatientcomptoir.elements["uniteordonnance"].options[document.formpatientcomptoir.elements["uniteordonnance"].length] = new_options;

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
                url: './hopitalpages/hopitalpatient/getprixproduit.php',
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
            url: 'hopitalpages/hopitalpatient/getproduit.php',
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
                        url: 'hopitalpages/hopitalpatient/getunite.php',
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
                                    url: './hopitalpages/hopitalpatient/getprixproduit.php',
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

</script>
