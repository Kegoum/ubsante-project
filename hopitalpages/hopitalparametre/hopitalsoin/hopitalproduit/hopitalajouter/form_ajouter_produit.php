
<div class="col-md-12 col-sm-12 col-xs-12" >
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 style=" color: white;">Ajout d'un soin</h2></h4>  
        </div>
        <form id="ajout_financen" name="formsoin" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalsoin/hopitalajouter/ajout_soin'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label" >Libelle <g style="color: red">*</g></label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formsoin'][NUM_PAGE]["libelle"]; ?>" class="form-control" placeholder="" type="text" name="libelle" id="libelle" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label" >Montant <g style="color: red">*</g></label>
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formsoin'][NUM_PAGE]["montant"]; ?>" class="form-control" placeholder="" type="number" name="montant" id="montant" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <fieldset class="space_data"><legend class="titre">Produits de soins</legend>
                <div id="cadremo" style=" font-size: 10px;">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="chosen-select-single">
                                <label class="control-label" >Nom &nbsp;</label>
                                <?php
                                $rsltpmo1 = $con->query("select * from hp_produit where etatproduit=true") or die(mysqli_error($con));
                                ?>
                                <select data-placeholder="Choisissez un Produit..." name="liblignesoin" id="liblignesoin"  class=" chosen-select form-control">
                                    <option value="">Choisissez un Produit</option>

                                    <?php
                                    while ($rowmo = mysqli_fetch_assoc($rsltpmo1)) {
                                        ?>
                                        <option value="<?php echo($rowmo["idproduit"]); ?>" <?php if ($_SESSION['formsoin'][NUM_PAGE]['liblignesoin'] == $rowmo["idproduit"]) { ?> selected <?php } ?>><?php echo($rowmo["libelleproduit"]); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">

                            <label class="control-label" >Quantit&eacute; &nbsp;</label>
                            <div class="input-group mg-b-pro-edt">
                                <!--<span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>-->
                                <input value="<?php echo $_SESSION['formsoin'][NUM_PAGE]["qtelignesoin"]; ?>" class="" placeholder="" type="text" name="qtelignesoin" id="qtelignesoin" />
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="chosen-select-single">
                                <label class="control-label" >Unit&eacute; &nbsp;</label>
                                <select data-placeholder="Choisissez une Unit&eacute;..." name="unitelignesoin" id="unitelignesoin"  class=" form-control">
                                    <option value="">Choisissez une Unit&eacute;</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input name="nblignesoin" type="hidden" id="nblignesoin" value="<?php echo $_SESSION['formsoin'][NUM_PAGE]['nblignesoin']; ?>">

                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="button" class=" btn-danger" value="Ajouter Un Produit" onclick="movplus()" />
                        <input type="button" class=" btn-danger" style="display:none" id="supmo" value="Supprimer Un Produit" onclick="momoins(this)" />
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
                            <center><button id="validateBtn" type="submit" name="insfinance" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                                <button type="reset" id="resetBtn" class="btn btn-primary"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                                <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                            </center><br>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
        $('#ajout_financen').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nom: {
                    message: 'Nom de l\'finance invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de l\'finance est obligatoire'
                        }
                    }
                },
                prenom: {
                    message: 'Prenom de l\'finance invalide',
                    validators: {
                    }
                },
                photo: {
                    validators: {
                        file: {
//                        extension: 'png',
//                        extension: {'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF'},
//                        extension: ('png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF'),
//                        extension: ('png', 'JPEG'),
//                        maxSize: 5*1024*1024,
                            message: 'Veuillez choisir une taille inferieur à 5M'
                        }
                    }
                }
            }
        });
        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_finance').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_finance').data('bootstrapValidator').resetForm(true);
//    });
    });

    function raz(liste)
    {
        d = document.formsoin.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formsoin.elements[liste].options[t] = null;
    }

    $(document).ready(function() {
        $("#liblignesoin").change(function() {
            var moid = $(this).val();
//            alert(moid);
            raz("unitelignesoin");
            $.ajax({
                url: 'hopitalpages/hopitalparametre/hopitalsoin/getunite.php',
                type: 'post',
                data: {moid: moid},
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        var servi = lib.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formsoin.elements["unitelignesoin"].options[document.formsoin.elements["unitelignesoin"].length] = new_options;

                    }
                }
            });
        });
    });


    var cmo, c2mo, d1mo, d2mo, d3mo, d4mo, d7mo, d8mo, d9mo, d10mo, chmo, chmo1, chmo3,
            labelmo, labelmo1,
            labelmo3, dmo, selectmo, selectmou, dselmo;

    function movplus() {
        cmo = document.getElementById("cadremo");
        dpmo = document.createElement("p");
        dmo = document.createElement("div");
        c2mo = cmo.getElementsByTagName("p");
        brmo = document.createElement("br");

        d1mo = document.createElement("div");
        d2mo = document.createElement("div");
        labelmo = document.createElement("label");
        selectmo = document.createElement("select");
        
        selectmou = document.createElement("select");
        d3mo = document.createElement("div");
        labelmo1 = document.createElement("label");
        d4mo = document.createElement("div");
        chmo = document.createElement("input");

        chmo1 = document.createElement("input");

        d7mo = document.createElement("div");
        labelmo3 = document.createElement("label");
        d8mo = document.createElement("div");
        selectmou = document.createElement("select");

        labelmo = document.createTextNode("Accessoire : ");
        labelmo1 = document.createTextNode("Quantité : ");
        labelmo3 = document.createTextNode("Unité : ");

        dmo.setAttribute("class", "row");
        d1mo.setAttribute("class", "col-lg-4 col-md-4 col-sm-6 col-xs-12");
        d2mo.setAttribute("class", "chosen-select-single");
        d3mo.setAttribute("class", "col-lg-2 col-md-2 col-sm-3 col-xs-6");
        d4mo.setAttribute("class", "input-group mg-b-pro-edt");

        d7mo.setAttribute("class", "col-lg-4 col-md-4 col-sm-6 col-xs-12");
        d8mo.setAttribute("class", "input-group mg-b-pro-edt");

        selectmo.setAttribute("class", "chosen-select form-control liblignesoinn");
        selectmo.setAttribute("name", "liblignesoin" + c2mo.length);
        selectmo.setAttribute("id", c2mo.length);

        theOption = document.createElement("OPTION");
        theText = document.createTextNode(" -Choisissez un Produit- ");
        theOption.setAttribute("value", "");
        theOption.appendChild(theText);

        selectmo.appendChild(theOption);


        selectmou.setAttribute("class", "chosen-select form-control");
        selectmou.setAttribute("name", "unitelignesoin" + c2mo.length);
        selectmou.setAttribute("id", c2mo.length);

        theOptionu = document.createElement("OPTION");
        theTextu = document.createTextNode(" -Choisissez une unité- ");
        theOptionu.setAttribute("value", "");
        theOptionu.appendChild(theTextu);

        selectmou.appendChild(theOptionu);


        chmo.setAttribute("type", "text");
        chmo.setAttribute("class", "");
        chmo.setAttribute("name", "qtelignesoin" + c2mo.length);
        chmo.setAttribute("id", "qtelignesoin" + c2mo.length);
        chmo.setAttribute("value", "");
        chmo.setAttribute("onkeyup", "CalculTotalMON(" + c2mo.length + ");");

        cmo.appendChild(dpmo);
//        c.appendChild(br);

        dpmo.appendChild(dmo);

        dmo.appendChild(d1mo);
        dmo.appendChild(d3mo);
        dmo.appendChild(d7mo);

        d1mo.appendChild(d2mo);
        d2mo.appendChild(labelmo);
        d2mo.appendChild(selectmo);

        d3mo.appendChild(labelmo1);
        d3mo.appendChild(d4mo);
        d4mo.appendChild(chmo);

        d7mo.appendChild(labelmo3);
        d7mo.appendChild(d8mo);
        d8mo.appendChild(selectmou);

        document.getElementById("supmo").style.display = "inline";
        document.getElementById('nblignesoin').value = c2mo.length;
        lmo = c2mo.length;

//alert(cstr);
        $.ajax({
            url: 'hopitalpages/hopitalparametre/hopitalsoin/getproduit.php',
            type: 'post',
//            data: {cstra: cstr},
            dataType: 'json',
            success: function(response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var id = response[i]['ide'];
                    var refmo = response[i]['libe'];
                    var nname = refmo;

//                            $("#liblignesoin" + c2.length).append("<option value='"+id+"'>"+refmo+" - "+name+"</option>");
                    var servi = nname.replace(/&#039;/gi, "\'");

                    theOption = document.createElement("OPTION");
                    theText = document.createTextNode(servi);
                    theOption.setAttribute("value", id);
                    theOption.appendChild(theText);

                    selectmo.appendChild(theOption);

                }

                selectmo.onchange = function() {
                    var moid = $(this).val();

                    var moid2 = $(this).attr('id');
                    var num = moid2.substring(6);

                    raz("unitelignesoin" + moid2);
                    $.ajax({
                        url: 'hopitalpages/hopitalparametre/hopitalsoin/getunite.php',
                        type: 'post',
                        data: {moid: moid},
                        dataType: 'json',
                        success: function(response) {
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

                    selectmou.appendChild(theOptionu);
                            }
                        }
                    });
                };

            }
        });

//        $(".liblignesoin").change(function () {
//            var moid = $(this).val();
//
//            $.ajax({
//                url: 'issampages/issametudiant/getmainoeuvre.php',
//                type: 'post',
//                data: {moid: moid},
//                dataType: 'json',
//                success: function (response) {
//
//                    var factjmo = response['factjmo'];
//                    document.getElementById("prixulignesoin"+c2.length).value = "";
//                    document.getElementById("prixulignesoin"+c2.length).value = factjmo;
//                    CalculTotalMO(c2.length);
//                }
//            });
//        });

    }

    function momoins(b) {
        
        if (!c2mo[1]) {
            b.style.display = "none";
        }

        if (c2mo[0]) {
            cmo.removeChild(c2mo[c2mo.length - 1]);
        }
        document.getElementById('nblignesoin').value = c2mo.length;
        lmo = c2mo.length;
    }

</script>
