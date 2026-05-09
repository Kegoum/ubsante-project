<script language="JavaScript">
    jQuery(document).ready(function () {
        // binds form submission and fields to the validation engine
        jQuery("#pointhotel_form").validationEngine('attach');
    });
    $(function () {
        $('#datefpl2').datepicker();
        $('#datefpl2').on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
    });
    function choixPrix(chaine)
    {
        var a = document.getElementById("prixlog");
        var b = document.getElementById("prixaut");

        if (chaine == 'logement') {

            a.style.display = "block";
            b.style.display = "none";
        }
        if (chaine == 'autre') {

            a.style.display = "none";
            b.style.display = "block";
        }

    }
</script>
<?php
if (isset($_REQUEST["client"])) {
    $ch = $_REQUEST["client"];

    if (isset($_POST["inspointh"])) {
        $datefpl2 = trim(htmlspecialchars($_POST["datefpl2"]));

        $prixl = NULL;
        if ($_POST["prixlog"] == "autre") {
            $prixl = trim(htmlspecialchars($_POST["prixl"]));
        }
        if ($_POST["datefpl2"] < $_POST["datefpl"]) {
            echo "<script language='javascript'>alert('Nouvelle date de fin invalide')</script>";
        } else {
            ajouter_jour_client($ch, $prixl, $datefpl2, $con);
        }
    }
    $rslt = $con->query("select * from hotel_client where id_client='" . $ch . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rsltpl = $con->query("select * from hotel_paye_logement as pl where "
            . "pl.id_client='" . $row["id_client"] . "' order by pl.date_pl desc "
            . "LIMIT 0,1") or die(mysqli_error($con));
    $rowpl = mysqli_fetch_assoc($rsltpl);
    ?>
    <div class="row">
        <div class="col-lg-12">
            <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->

            <h2 class="page-header">Ajout les jours de <small> <?php echo $row["nom_client"]; ?> <?php echo $row["prenom_client"]; ?> - <?php echo $row["cni_client"]; ?></small> </h2>  

            <form id="pointhotel_form" method="post" action="#">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label" >Ancienne Date d&eacute;but</label>  
                            <input value="<?php echo $rowpl["date_debut_pl"]; ?>" class="form-control" type="text" name="datedpl" id="datedpl" readonly />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label" >Ancienne Date fin</label>  
                            <input value="<?php echo $rowpl["date_fin_pl"]; ?>" class="form-control" type="text" name="datefpl" id="datefpl" readonly />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label" >Nouvelle Date de Fin</label>  
                            <div class="inputGroupContainer">
                                <input class="validate[custom[date],validate[future[datefpl]]] text-input form-control" placeholder="aaaa-mm-jj" data-date-format="yyyy-mm-dd" type="text" name="datefpl2" id="datefpl2" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label>Prix</label> <br>
                            <input class="validate[required] radio-inline" name="prixlog" type="radio" value="logement" checked required onchange="choixPrix('logement')" />Prix du logement
                            <input class="validate[required] radio-inline" name="prixlog" type="radio" value="autre" required onchange="choixPrix('autre')" />Autre prix
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="prixlog" style="display:none">

                        </div>
                        <div id="prixaut" style="display:none">
                            <div class="form-group" style="margin-left:15px;">
                                <label class="control-label">Nouveau prix</label>  
                                <div class="inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <input class="validate[custom[onlyNumber]] text-input form-control" placeholder="Le Prix" type="text" name="prixl" id="prixl" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-6">
                        <button type="submit" name="inspointh" class="btn btn-success"><i class="icon-check"></i> Enregistrer</button>
                        <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                        <a href="javascript:history.go(-1)" class="btn btn-success"><i class="icon-backward"></i> Quitter</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
    <?php
}
?> 