<script>
    $(function () {
//        $('#datedce').datepicker();
//        $('#datefce').datepicker();
    });
</script>
<script type="text/javascript">
    /* On crée la fonction qui va construire la seconde liste déroulante */
    window.onload = function () {
        CalculeHeure()
    };

    function timeToDecimal(t) {
        var arr = t.split(':');
        var dec = parseInt((arr[1] / 6) * 10, 10);

        return parseFloat(parseInt(arr[0], 10) + '.' + (dec < 10 ? '0' : '') + dec);
    }
    function CalculeHeure()
    {
        var deb = document.getElementById("heuredce").value;
        var fin = document.getElementById("heurefce").value;
        var StartTime = moment(deb, "hh:mm");
        var EndTime = moment(fin, "hh:mm");
        var TotalTime = ((EndTime.subtract(StartTime))).format("hh:mm");
        document.getElementById("nbheurecours1").value = TotalTime;
        document.getElementById("nbheurecours2").value = timeToDecimal(TotalTime);
    }

</script>

<?php
if ($_REQUEST["idpersonnel"]) {

    $rsltens = $con->query("select * from hp_personnel where idpersonnel='" . $_REQUEST["idpersonnel"] . "'") or die(mysqli_error($con));
    $rece = mysqli_fetch_assoc($rsltens);
    $idens=$_REQUEST["idpersonnel"];
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
                                    <h2>Gestion des Pointages</h2>
                                    <h5>Personnel : 
                                        <?php
                                        print nl2br(htmlspecialchars($rece["codepersonnel"]));
                                        ?> <?php print nl2br(htmlspecialchars($rece["nompersonnel"])); ?> <?php print nl2br(htmlspecialchars($rece["prenompersonnel"])); ?> &nbsp;&nbsp;
                                        - <?php print nl2br(htmlspecialchars($rece["rolepersonnel"])); ?>
                                    </h5>
                                </div>
                            </div>
                            <form method="Post" action="#">
                                <div class="alert alert-block alert-danger alertdate" style="display:none">
                                    date post&eacute;rieur  !
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label" >Date du jour</label> 
                                            <div class="inputGroupContainer">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    <input type="date" placeholder="aaaa-mm-jj" name="datece" id="datece" class="form-control" data-date-format="yyyy-mm-dd" required>
                                                    <div class="alert alert-block alert-danger alertdatedce" style="display:none">
                                                        date d&eacute;but vide  !
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label" >Nombre d'heures</label> 
                                            <div class="inputGroupContainer">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    <input type="text" placeholder="Nombre d'heures" name="nbheurecours1" id="nbheurecours1" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label" >Nombre d'heures D&eacute;cimal</label> 
                                            <div class="inputGroupContainer">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    <input type="text" placeholder="Nombre d'heures" name="nbheurecours2" id="nbheurecours2" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label" >heure d&eacute;but</label> 
                                            <div class="inputGroupContainer">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    <input type="time" placeholder="hh:mm" name="heuredce" id="heuredce" class="form-control" onblur="CalculeHeure();" required>
                                                    <div class="alert alert-block alert-danger alertdatefce" style="display:none">
                                                        date fin vide  !
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label" >heure fin</label> 
                                            <div class="inputGroupContainer">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                    <input type="time" placeholder="hh:mm" name="heurefce" id="heurefce" class="form-control"  onblur="CalculeHeure();" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Type de pointage &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <select class="form-control" name="typepaiement" id="typepaiement">
                                                    <option value=""> - Choisissez un Type - </option>
                                                    <option value="normal" selected >Normal</option>
                                                    <option value="heuresup15" >Heure Suplémentaire 15&percnt;</option>
                                                    <option value="heuresup20" >Heure Suplémentaire 20&percnt;</option>
                                                    <option value="heuresup30" >Heure Suplémentaire 30&percnt;</option>
                                                    <option value="heuresup40" >Heure Suplémentaire 40&percnt;</option>
                                                    <option value="heuresup50" >Heure Suplémentaire 50&percnt;</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <input type="submit" name="envoicours" value="Envoyer" class="btn btn-info">
                                <a href="javascript:history.go(-1)" class="btn btn-info">Quitter</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST["envoicours"])) {
        $date = date('Y-m-d');
        if (($date < $_POST["datece"])) {
            echo"<script language='javascript'>$('div.alertdate').show('slow').delay(8000).hide('slow');</script>";
        } else {
            if ($idens != 0) {
                $datece = trim(htmlspecialchars($_POST["datece"]));
                $heuredce = $_POST["heuredce"];
                $heurefce = $_POST["heurefce"];
                $nbheurecours1 = $_POST["nbheurecours1"];
                $nbheurecours2 = $_POST["nbheurecours2"];
                $typepaiement = $_POST["typepaiement"];
                insert_pointage_personnel($idens, $_REQUEST["idpersonnel"], $datece, $heuredce, $heurefce, $nbheurecours1, $nbheurecours2, $typepaiement, $con);
            }
        }
    }
} else {
    
}
?>