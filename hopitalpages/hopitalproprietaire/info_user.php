<?php
$rsltuser = $con->query("select * from hp_proprietaire as p left join hp_departement as d on p.iddepartement=d.iddepartement "
        . "left join hp_region as r on d.idregion=r.idregion where p.idproprietaire='" . $_SESSION["idproprietaire"] . "'") or die(mysqli_error($con));
$recuser = mysqli_fetch_assoc($rsltuser);
?>
<!--<div class="row">-->
<div class="col-sm-8 col-xs-12 col-lg-8 col-sm-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4>Informations de <?php echo $recuser['hopitalproprietaire']; ?></h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-12">
                    Logo : 
                    <img class="img-rounded" style="width: 60%;" src="hopitalupload/logo/<?php print nl2br(htmlspecialchars($recuser["logoproprietaire"])); ?>"> 
                    <br>Filigrane A5 Portrait : 
                    <img class="img-rounded" style="width: 60%;" src="hopitalupload/logo/<?php print nl2br(htmlspecialchars($recuser["filigranea5p"])); ?>"> 
                    <br>Filigrane A5 Payisage :
                    <img class="img-rounded" style="width: 60%;" src="hopitalupload/logo/<?php print nl2br(htmlspecialchars($recuser["filigranea5l"])); ?>"> 
                    <br>Filigrane A4 Portrait :
                    <img class="img-rounded" style="width: 60%;" src="hopitalupload/logo/<?php print nl2br(htmlspecialchars($recuser["filigranea4p"])); ?>"> 
                    <br>Filigrane A4 Payisage :
                    <img class="img-rounded" style="width: 60%;" src="hopitalupload/logo/<?php print nl2br(htmlspecialchars($recuser["filigranea4l"])); ?>"> 
                </div>
                <div class="col-md-5 col-sm-5 col-xs-12">
                    <b><u>Centre de sant&eacute;:</u></b> &nbsp;<?php echo $recuser['hopitalproprietaire']; ?>
                    <br><br>
                    <b><u>Nom propriétaire:</u></b> &nbsp;<?php echo $recuser['nomproprietaire']; ?>
                    <br><br>
                    <b><u>Air sant&eacute;:</u></b> &nbsp;<?php echo $recuser['airesanteproprietaire']; ?>
                    <br><br>
                    <b><u>Num&eacute;ro de t&eacute;l&eacute;phone:</u></b> &nbsp;<?php echo $recuser['telephoneproprietaire']; ?>
                    <br><br>
                    <b><u>E mail:</u></b> &nbsp;<?php echo $recuser['emailproprietaire']; ?>
                    <br><br>
                    <b><u>Site:</u></b> &nbsp;<?php echo $recuser['siteproprietaire']; ?>
                    <br><br>
                    <b><u>Adresse:</u></b> &nbsp;<?php echo $recuser['adressehopital']; ?>
                    <br><br>
                    <b><u>Boite postale:</u></b> &nbsp;<?php echo $recuser['bpproprietaire']; ?>
                    <br><br>
                    <b><u>Login:</u></b> &nbsp;<?php echo $recuser['loginproprietaire']; ?>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-12">
                    <b><u>R&eacute;gion:</u></b> &nbsp;<?php echo $recuser['cheflieuregion']; ?>
                    <br><br>
                    <b><u>D&eacute;partement:</u></b> &nbsp;<?php echo $recuser['cheflieudepartement']; ?>
                    <br><br>
                    <b><u>Arrondissement:</u></b> &nbsp;<?php echo $recuser['arrondissementproprietaire']; ?>
                    <br><br>
                    <b><u>District:</u></b> &nbsp;<?php echo $recuser['districtproprietaire']; ?>
                    <br><br>
                    <b><u>Date de la cr&eacute;ation:</u></b> &nbsp;<?php echo $recuser['datecreationproprietaire']; ?>
                    <br><br>
                    <b><u>Type:</u></b> &nbsp;<?php echo $recuser['typeproprietaire']; ?>
                    <br><br>
                    <b><u>N&deg; contribuable:</u></b> &nbsp;<?php echo $recuser['nocontribuableproprietaire']; ?>
                    <br><br>
                    <b><u>Slogan:</u></b> &nbsp;<?php echo $recuser['sloganproprietaire']; ?>
                    <br><br>
                    <b><u>Domaine:</u></b> &nbsp;<?php echo $recuser['textehopital']; ?>
                </div>
            </div>
        </div>
        <div class="panel-footer"><br>
            &nbsp;&nbsp;
            <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
            &nbsp;&nbsp;
            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire'); ?>&idproprietaire=<?php echo $recuser["idproprietaire"]; ?>" class="btn btn-info">
                <span title="Modifier mon compte proprietaire" alt="editer"></span>
                <i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;<b>Modifier mon compte</b>
            </a>

            <br><br>
        </div>
    </div>
</div>
<!--</div>-->