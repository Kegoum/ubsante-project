<script language="JavaScript">
    /* On crée la fonction qui va construire la seconde liste déroulante */
    window.onload = function () {
        choixPrix();
    };

    function raz(liste)
    {
        d = document.formproduite.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formproduite.elements[liste].options[t] = null;
    }
//
//    $(function () {
//        $('#datefab').datepicker();
//        $('#datefab').on('changeDate', function (ev) {
//            $(this).datepicker('hide');
//        });
//    });

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
    $(function () {
        $("#addnewfamillema").click(function (e) {
            e.preventDefault();
//alert('cool');
            var designation = $("#libfamillema").val();
            //in jQuery you can pass an object, directorname will now show up as $_POST['directorname'] in your PHP handler.
            var dataObj = {'designation': designation}

            $.ajax({
                type: "POST",
                url: "hopitalpages/hopitalfamille/actionfamille.php",
                data: dataObj,
                dataType: 'json',
                //success function should receive the id back as result
                success: function (result) {
                    var len = result.length;
                    for (var i = 0; i < len; i++) {
                        var id = result[i]['idmat'];
                        var name = result[i]['des'];
                        var servi = name.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formproduite.elements["classem"].options[document.formproduite.elements["classem"].length] = new_options;
                    }
                    document.getElementById("libfamillema").value = "";
                    $("#modalnewfamillee").modal('hide');
                }
            });
            return false;
        });
    });

    $(function () {
        $("#addnewformema").click(function (e) {
            e.preventDefault();
//alert('cool');
            var designation = $("#libformema").val();
            //in jQuery you can pass an object, directorname will now show up as $_POST['directorname'] in your PHP handler.
            var dataObj = {'designation': designation}

            $.ajax({
                type: "POST",
                url: "hopitalpages/hopitalforme/actionforme.php",
                data: dataObj,
                dataType: 'json',
                //success function should receive the id back as result
                success: function (result) {
                    var len = result.length;
                    for (var i = 0; i < len; i++) {
                        var id = result[i]['idmat'];
                        var name = result[i]['des'];
                        var servi = name.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formproduite.elements["formem"].options[document.formproduite.elements["formem"].length] = new_options;
                    }
                    document.getElementById("libformema").value = "";
                    $("#modalnewformee").modal('hide');
                }
            });
            return false;
        });
    });
    $(function () {
        $("#addnewlaboratoireproduitma").click(function (e) {
            e.preventDefault();
//alert('cool');
            var designation = $("#liblaboratoireproduitma").val();
            //in jQuery you can pass an object, directorname will now show up as $_POST['directorname'] in your PHP handler.
            var dataObj = {'designation': designation}

            $.ajax({
                type: "POST",
                url: "hopitalpages/hopitallaboratoireproduit/actionlaboratoireproduit.php",
                data: dataObj,
                dataType: 'json',
                //success function should receive the id back as result
                success: function (result) {
                    var len = result.length;
                    for (var i = 0; i < len; i++) {
                        var id = result[i]['idmat'];
                        var name = result[i]['des'];
                        var servi = name.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formproduite.elements["laboratoirem"].options[document.formproduite.elements["laboratoirem"].length] = new_options;
                    }
                    document.getElementById("liblaboratoireproduitma").value = "";
                    $("#modalnewlaboratoireproduite").modal('hide');
                }
            });
            return false;
        });
    });

    $(function () {
        $("#addnewdosagema").click(function (e) {
            e.preventDefault();
//alert('cool');
            var designation = $("#libdosagema").val();
            //in jQuery you can pass an object, directorname will now show up as $_POST['directorname'] in your PHP handler.
            var dataObj = {'designation': designation}

            $.ajax({
                type: "POST",
                url: "hopitalpages/hopitaldosage/actiondosage.php",
                data: dataObj,
                dataType: 'json',
                //success function should receive the id back as result
                success: function (result) {
                    var len = result.length;
                    for (var i = 0; i < len; i++) {
                        var id = result[i]['idmat'];
                        var name = result[i]['des'];
                        var servi = name.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formproduite.elements["dosagem"].options[document.formproduite.elements["dosagem"].length] = new_options;
                    }
                    document.getElementById("libdosagema").value = "";
                    $("#modalnewdosagee").modal('hide');
                }
            });
            return false;
        });
    });

    $(function () {
        $("#addnewconditionnementma").click(function (e) {
            e.preventDefault();
//alert('cool');
            var designation = $("#libconditionnementma").val();
            //in jQuery you can pass an object, directorname will now show up as $_POST['directorname'] in your PHP handler.
            var dataObj = {'designation': designation}

            $.ajax({
                type: "POST",
                url: "hopitalpages/hopitalconditionnement/actionconditionnement.php",
                data: dataObj,
                dataType: 'json',
                //success function should receive the id back as result
                success: function (result) {
                    var len = result.length;
                    for (var i = 0; i < len; i++) {
                        var id = result[i]['idmat'];
                        var name = result[i]['des'];
                        var servi = name.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formproduite.elements["conditionnementm"].options[document.formproduite.elements["conditionnementm"].length] = new_options;
                    }
                    document.getElementById("libconditionnementma").value = "";
                    $("#modalnewconditionnemente").modal('hide');
                }
            });
            return false;
        });
    });

    $(function () {
        $("#addnewdcima").click(function (e) {
            e.preventDefault();
//alert('cool');
            var code = $("#codedcima").val();
            var designation = $("#libdcima").val();
            //in jQuery you can pass an object, directorname will now show up as $_POST['directorname'] in your PHP handler.
            var dataObj = {'code': code, 'designation': designation}

            $.ajax({
                type: "POST",
                url: "hopitalpages/hopitaldci/actiondci.php",
                data: dataObj,
                dataType: 'json',
                //success function should receive the id back as result
                success: function (result) {
                    var len = result.length;
                    for (var i = 0; i < len; i++) {
                        var id = result[i]['idmat'];
                        var name = result[i]['des'];
                        var servi = name.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formproduite.elements["cat"].options[document.formproduite.elements["cat"].length] = new_options;
                    }
                    document.getElementById("codedcima").value = "";
                    document.getElementById("libdcima").value = "";
                    $("#modalnewdcie").modal('hide');
                }
            });
            return false;
        });
    });

    $(function () {
        $("#addnewuniteama").click(function (e) {
            e.preventDefault();
//alert('cool');
            var code = $("#codeuniteama").val();
            var designation = $("#libuniteama").val();
            //in jQuery you can pass an object, directorname will now show up as $_POST['directorname'] in your PHP handler.
            var dataObj = {'code': code, 'designation': designation}

            $.ajax({
                type: "POST",
                url: "hopitalpages/hopitalunite/actionunite.php",
                data: dataObj,
                dataType: 'json',
                //success function should receive the id back as result
                success: function (result) {
                    var len = result.length;
                    for (var i = 0; i < len; i++) {
                        var id = result[i]['idmat'];
                        var name = result[i]['des'];
                        var servi = name.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formproduite.elements["unitea"].options[document.formproduite.elements["unitea"].length] = new_options;
                    }
                    document.getElementById("codeuniteama").value = "";
                    document.getElementById("libuniteama").value = "";
                    $("#modalnewuniteae").modal('hide');
                }
            });
            return false;
        });
    });

    $(function () {
        $("#addnewunitevma").click(function (e) {
            e.preventDefault();
//alert('cool');
            var code = $("#codeunitevma").val();
            var designation = $("#libunitevma").val();
            //in jQuery you can pass an object, directorname will now show up as $_POST['directorname'] in your PHP handler.
            var dataObj = {'code': code, 'designation': designation}

            $.ajax({
                type: "POST",
                url: "hopitalpages/hopitalunite/actionunite.php",
                data: dataObj,
                dataType: 'json',
                //success function should receive the id back as result
                success: function (result) {
                    var len = result.length;
                    for (var i = 0; i < len; i++) {
                        var id = result[i]['idmat'];
                        var name = result[i]['des'];
                        var servi = name.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formproduite.elements["unitev"].options[document.formproduite.elements["unitev"].length] = new_options;
                    }
                    document.getElementById("codeunitevma").value = "";
                    document.getElementById("libunitevma").value = "";
                    $("#modalnewuniteve").modal('hide');
                }
            });
            return false;
        });
    });

    $(function () {
        $("#addnewunitesma").click(function (e) {
            e.preventDefault();
//alert('cool');
            var code = $("#codeunitesma").val();
            var designation = $("#libunitesma").val();
            //in jQuery you can pass an object, directorname will now show up as $_POST['directorname'] in your PHP handler.
            var dataObj = {'code': code, 'designation': designation}

            $.ajax({
                type: "POST",
                url: "hopitalpages/hopitalunite/actionunite.php",
                data: dataObj,
                dataType: 'json',
                //success function should receive the id back as result
                success: function (result) {
                    var len = result.length;
                    for (var i = 0; i < len; i++) {
                        var id = result[i]['idmat'];
                        var name = result[i]['des'];
                        var servi = name.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formproduite.elements["unites"].options[document.formproduite.elements["unites"].length] = new_options;
                    }
                    document.getElementById("codeunitesma").value = "";
                    document.getElementById("libunitesma").value = "";
                    $("#modalnewunitese").modal('hide');
                }
            });
            return false;
        });
    });

</script>
<?php
$rsltcat = $con->query("select * from hp_categorie order by libellecategorie asc") or die(mysqli_error($con));
$rsltua = $con->query("select * from hp_unite order by libelleunite asc") or die(mysqli_error($con));
$rsltuv = $con->query("select * from hp_unite order by libelleunite asc") or die(mysqli_error($con));
$rsltus = $con->query("select * from hp_unite order by libelleunite asc") or die(mysqli_error($con));
?>
<?php
include ("hopitalpages/hopitalfamille/hopitalajouter/ajout_famille.php");
include ("hopitalpages/hopitalforme/hopitalajouter/ajout_forme.php");
include ("hopitalpages/hopitallaboratoireproduit/hopitalajouter/ajout_laboratoireproduit.php");
include ("hopitalpages/hopitaldosage/hopitalajouter/ajout_dosage.php");
include ("hopitalpages/hopitalconditionnement/hopitalajouter/ajout_conditionnement.php");
include ("hopitalpages/hopitaldci/hopitalajouter/ajout_dci.php");
include ("hopitalpages/hopitalunite/hopitalajouter/ajout_unitea.php");
include ("hopitalpages/hopitalunite/hopitalajouter/ajout_unitev.php");
include ("hopitalpages/hopitalunite/hopitalajouter/ajout_unites.php");
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4 class="page-header text-center">Formulaire de Modification d'un Produit </h4> 
        <form id="ajout_prod" name="formproduite" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalediter/editer_produit'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&produit=<?php echo $_REQUEST["produit"]; ?>">

            <input value="<?php echo $_SESSION['formproduite'][NUM_PAGE]["idproduit"]; ?>" type="hidden" name="idproduit" id="idproduit" />

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label class="control-label">Code Produit <b style="color: red">*</b></label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formproduite'][NUM_PAGE]["codepe"]; ?>" class="text-input form-control" placeholder="Ex: PARA,... " type="text" name="codepe" id="codep" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label">D&eacute;signation <b style="color: red">*</b></label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formproduite'][NUM_PAGE]["desp"]; ?>" class="text-input form-control" placeholder="Le nom ou la d&eacute;signation du produit" type="text" name="desp" id="desp" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="review-content-section">
                        <div class="chosen-select-single mg-b-20">
                            <label class="control-label" >D.C.I. /Principe actif <b style="color: red">*</b></label> 
                            <select name="cat" id="cat" class="select2_demo_2 form-control">
                                <option value="" selected="selected">- Choisissez un D.C.I.-</option>
                                <?php
                                /* Construction de la première liste : on se sert du tableau PHP */
                                while ($rowcat = mysqli_fetch_assoc($rsltcat)) {
                                    ?>
                                    <option value="<?php echo($rowcat["idcategorie"]); ?>" <?php if ($_SESSION['formproduite'][NUM_PAGE]["cat"] == $rowcat["idcategorie"]) { ?> selected <?php } ?>><?php echo($rowcat["libellecategorie"]); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <a href="#modalnewdcie" role="button" data-toggle="modal" class="btn-sm btn-danger"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="review-content-section">
                        <div class="chosen-select-single mg-b-20">
                            <label class="control-label" >Famille &nbsp;</label>
                            <?php
                            $rsltpa = $con->query("select * from hp_classe_medicamenteuse order by libelleclassemedicamenteuse asc") or die(mysqli_error($con));
                            ?>
                            <select name="classe" id="classem"  class="select2_demo_2 form-control">
                                <option value="">Choisissez une Famille</option>

                                <?php
                                while ($ligne = mysqli_fetch_assoc($rsltpa)) {
                                    ?>
                                    <option value="<?php echo($ligne["idclassemedicamenteuse"]); ?>" <?php if ($_SESSION['formproduite'][NUM_PAGE]["classe"] == $ligne["idclassemedicamenteuse"]) { ?> selected <?php } ?>><?php echo($ligne["libelleclassemedicamenteuse"]); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <a href="#modalnewfamillee" role="button" data-toggle="modal" class="btn-sm btn-danger"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="review-content-section">
                        <div class="chosen-select-single mg-b-20">
                            <label class="control-label" >Forme &nbsp;</label>
                            <?php
                            $rsltpaf = $con->query("select * from hp_forme order by libelleforme asc") or die(mysqli_error($con));
                            ?>
                            <select name="forme" id="formem"  class="select2_demo_2 form-control">
                                <option value="">Choisissez une forme</option>

                                <?php
                                while ($ligne = mysqli_fetch_assoc($rsltpaf)) {
                                    ?>
                                    <option value="<?php echo($ligne["idforme"]); ?>" <?php if ($_SESSION['formproduite'][NUM_PAGE]["forme"] == $ligne["idforme"]) { ?> selected <?php } ?>><?php echo($ligne["libelleforme"]); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <a href="#modalnewformee" role="button" data-toggle="modal" class="btn-sm btn-danger"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="review-content-section">
                        <div class="chosen-select-single mg-b-20">
                            <label class="control-label" >Dosage &nbsp;</label>
                            <?php
                            $rsltpad = $con->query("select * from hp_dosage order by libelledosage asc") or die(mysqli_error($con));
                            ?>
                            <select name="dosage" id="dosagem"  class="select2_demo_2 form-control">
                                <option value="">Choisissez un dosage</option>

                                <?php
                                while ($ligne = mysqli_fetch_assoc($rsltpad)) {
                                    ?>
                                    <option value="<?php echo($ligne["iddosage"]); ?>" <?php if ($_SESSION['formproduite'][NUM_PAGE]["dosage"] == $ligne["iddosage"]) { ?> selected <?php } ?>><?php echo($ligne["libelledosage"]); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <a href="#modalnewdosagee" role="button" data-toggle="modal" class="btn-sm btn-danger"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="review-content-section">
                        <div class="chosen-select-single mg-b-20">
                            <label class="control-label" >Conditionnement &nbsp;</label>
                            <?php
                            $rsltpaco = $con->query("select * from hp_conditionnement order by libelleconditionnement asc") or die(mysqli_error($con));
                            ?>
                            <select name="conditionnement" id="conditionnementm"  class="select2_demo_2 form-control">
                                <option value="">Choisissez un conditionnement</option>

                                <?php
                                while ($ligne = mysqli_fetch_assoc($rsltpaco)) {
                                    ?>
                                    <option value="<?php echo($ligne["idconditionnement"]); ?>" <?php if ($_SESSION['formproduite'][NUM_PAGE]["conditionnement"] == $ligne["idconditionnement"]) { ?> selected <?php } ?>><?php echo($ligne["libelleconditionnement"]); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <a href="#modalnewconditionnemente" role="button" data-toggle="modal" class="btn-sm btn-danger"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="review-content-section">
                        <div class="chosen-select-single mg-b-20">
                            <label class="control-label" >Laboratoire &nbsp;</label>
                            <?php
                            $rsltpal = $con->query("select * from hp_laboratoire_produit order by libellelaboratoireproduit asc") or die(mysqli_error($con));
                            ?>
                            <select name="laboratoire" id="laboratoirem"  class="select2_demo_2 form-control">
                                <option value="">Choisissez un Laboratoire</option>

                                <?php
                                while ($ligne = mysqli_fetch_assoc($rsltpal)) {
                                    ?>
                                    <option value="<?php echo($ligne["idlaboratoireproduit"]); ?>" <?php if ($_SESSION['formproduite'][NUM_PAGE]["laboratoire"] == $ligne["idlaboratoireproduit"]) { ?> selected <?php } ?>><?php echo($ligne["libellelaboratoireproduit"]); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <a href="#modalnewlaboratoireproduite" role="button" data-toggle="modal" class="btn-sm btn-danger"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label class="control-label" >Date de fabrication</label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input value="<?php echo $_SESSION['formproduite'][NUM_PAGE]["datefab"]; ?>" class="text-input form-control" placeholder="" type="date" name="datefab" id="datefab" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label class="control-label" >Date de p&eacute;remption</label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input value="<?php echo $_SESSION['formproduite'][NUM_PAGE]["dateper"]; ?>" class="text-input form-control" placeholder="" type="date" name="dateper" id="dateper" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                   <div class="form-group">
                        <label class="control-label" >Prix unitaire d'achat <b style="color: red">*</b></label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formproduite'][NUM_PAGE]["prixa"]; ?>" class="text-input form-control" placeholder="" type="text" name="prixa" id="prixa" />
                            </div>
                        </div>
                    </div>
                    <div class="review-content-section">
                        <label class="control-label" >Valorisation &nbsp;<g style="color: red">*</g></label>
                        <div class="input-group mg-b-pro-edt">
                            <?php
                            $rsltp = $con->query('select * from hp_valorisation_stock where etatvalorisationstock=true') or die(mysqli_error($con));
                            ?>
                            <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                            <select name="valorisation" class="form-control pro-edt-select form-control-primary">
                                <option value="" selected="selected">- Choisissez une Valorisation-</option>
                                <?php
                                while ($rowp = mysqli_fetch_assoc($rsltp)) {
                                    ?>
                                    <option value="<?php echo $rowp["idvalorisationstock"]; ?>" <?php if ($rowp["idvalorisationstock"] == $_SESSION['formproduite'][NUM_PAGE]["valorisation"]) { ?> selected <?php } ?>><?php echo $rowp["libellevalorisationstock"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label class="control-label" >Stock</label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formproduite'][NUM_PAGE]["qtes"]; ?>" class="text-input form-control" placeholder="" type="text" name="qtes" id="qtes" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" >Stock Minimal</label> 
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formproduite'][NUM_PAGE]["qtemin"]; ?>" class="text-input form-control" placeholder="" type="text" name="qtemin" id="qtemin" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Stock Maximal</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input value="<?php echo $_SESSION['formproduite'][NUM_PAGE]["qtemax"]; ?>" class="text-input form-control" placeholder="La quantit&eacute; maximale du produit" type="text" name="qtemax" id="qtemax" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label class="control-label">Unit&eacute; d'achat</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="unitea" id="unitea" class="validate[required] text-input form-control">
                                    <option value="" selected="selected">- Choisissez une Unit&eacute;-</option>
                                    <?php
                                    /* Construction de la première liste : on se sert du tableau PHP */
                                    while ($rowua = mysqli_fetch_assoc($rsltua)) {
                                        ?>
                                        <option value="<?php echo($rowua["idunite"]); ?>" <?php if ($_SESSION['formproduite'][NUM_PAGE]["unitea"] == $rowua["idunite"]) { ?> selected <?php } ?>><?php echo($rowua["libelleunite"]); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <a href="#modalnewuniteae" role="button" data-toggle="modal" class="btn-sm btn-danger"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Unit&eacute; de vente</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="unitev" id="unitev" class="text-input form-control">
                                    <option value="" selected="selected">- Choisissez une Unit&eacute;-</option>
                                    <?php
                                    /* Construction de la première liste : on se sert du tableau PHP */
                                    while ($rowuv = mysqli_fetch_assoc($rsltuv)) {
                                        ?>
                                        <option value="<?php echo($rowuv["idunite"]); ?>" <?php if ($_SESSION['formproduite'][NUM_PAGE]["unitev"] == $rowuv["idunite"]) { ?> selected <?php } ?>><?php echo($rowuv["libelleunite"]); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <a href="#modalnewuniteve" role="button" data-toggle="modal" class="btn-sm btn-danger"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Unit&eacute; de sortie</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <select name="unites" id="unites" class="text-input form-control">
                                    <option value="" selected="selected">- Choisissez une Unit&eacute;-</option>
                                    <?php
                                    /* Construction de la première liste : on se sert du tableau PHP */
                                    while ($rowus = mysqli_fetch_assoc($rsltus)) {
                                        ?>
                                        <option value="<?php echo($rowus["idunite"]); ?>" <?php if ($_SESSION['formproduite'][NUM_PAGE]["unites"] == $rowus["idunite"]) { ?> selected <?php } ?>><?php echo($rowus["libelleunite"]); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <a href="#modalnewunitese" role="button" data-toggle="modal" class="btn-sm btn-danger"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label>Image :</label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <input type="hidden" name="imagepstring" value="<?php echo $_SESSION['formproduite'][NUM_PAGE]['imagepstring']; ?>">
                            <img src="hopitalupload/images/<?php echo $_SESSION['formproduite'][NUM_PAGE]['imagepstring']; ?>" style="width: 20mm; height: 20mm;">
                            <div class="fileupload-preview thumbnail" style="width: 75px; height: 75px;"></div>
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
                    <input type="reset" value="Effacer" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i>>
                    <a href="javascript:history.go(-1)" class="btn btn-success"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                </div>
            </div>
        </form>
    </div>
</div> 