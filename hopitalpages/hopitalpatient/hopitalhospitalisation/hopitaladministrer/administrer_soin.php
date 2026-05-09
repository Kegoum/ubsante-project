<?php
    ?>

<div id="modaladminsoin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaladminsoinLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 id="modaladminsoinLabel">Administrer les soins
                    <?php // echo $row["libelle_produit"]; ?> 
                </h2>
            </div>
            <div class="modal-body">
                <form name="" id="personnel_eform" method="POST" action="#">
                    <div class="form-group">
                        <label>Patient</label>
                        <input name="patientadm" type="text" class="text-input form-control" id="patientadm" readonly>
                    </div>
                    <div class="form-group">
                        <label>Soin</label>
                        <input name="soinadm" type="text" class="text-input form-control" id="soinadm" readonly>
                    </div>
                        <div class="form-group" >
                            <label>Date</label> <br>
                            <input class="form-control" placeholder="" type="date" name="datef" id="datef" required autofocus />
                        </div>
                        <div class="form-group" >
                            <label>Heure </label> <br>
                            <input class="form-control" placeholder="" type="time" name="heuref" id="heuref" required />
                        </div>
                </div>
                    <input name="idsoinpatientadm" type="hidden" class="" id="idsoinpatientadm">
                    <br/><br/>
                    <input type="submit" class="btn btn-success"  id="Submite" name="adminsoin_btn"/>
                    <!--<input type="reset" class="btn btn-success " name="effacere" value="Effacer">-->
                    <input type="button" class="close btn-success" data-dismiss="modal" aria-hidden="true"  value="Annuler">
                </form>
                <?php
                if (isset($_POST["adminsoin_btn"])) {
                    
        
                    $soinpa = trim($_POST["idsoinpatientadm"]);
                    $datef = trim($_POST["datef"]);
                    $heuref = trim($_POST["heuref"]);
                    administrer_soin_patient($soinpa, $datef, $heuref, $con);
                }
                ?>
            </div>

        </div>
    </div>
</div>
    <?php
