<?php
$rsltuser = $con->query("select * from hp_compte_personnel as cp left join hp_personnel as p on "
        . "cp.idpersonnel=p.idpersonnel where cp.idcomptepersonnel='" . $_SESSION["idcomptepersonnel"] . "'") or die(mysqli_error($con));
$recuser = mysqli_fetch_assoc($rsltuser);
?>
<!--<div class="row">-->
<div class="col-sm-6 col-xs-12 col-lg-6 col-sm-offset-3">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4>Informations de <?php echo $recuser['nompersonnel']; ?>&nbsp;<?php echo $recuser['prenompersonnel']; ?></h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <!--<img class="img-rounded" style="width: 100%;" src="hopitalupload/profil/<?php print nl2br(htmlspecialchars($recuser["photopersonnel"])); ?>">--> 
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <b><u>Nom:</u></b> &nbsp;<?php echo $recuser['nompersonnel']; ?>
                    <br><br>
                    <b><u>Prenom:</u></b> &nbsp;<?php echo $recuser['prenompersonnel']; ?>
                    <br><br>
                    <b><u>Num&eacute;ro de t&eacute;l&eacute;phone:</u></b> &nbsp;<?php echo $recuser['telephonepersonnel']; ?>
                    <br><br>
                    <b><u>Login:</u></b> &nbsp;<?php echo $recuser['logincomptepersonnel']; ?>
                    <br><br>
                    <b><u>R&ocirc;le:</u></b> &nbsp;<?php echo $recuser['rolepersonnel']; ?>
                </div>
            </div>
        </div>
        <div class="panel-footer"><br>
            &nbsp;&nbsp;
            <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
            &nbsp;&nbsp;
            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalediterprofil/edit_personnel'); ?>&idcomptepersonnel=<?php echo $recuser["idcomptepersonnel"]; ?>" class="btn btn-info">
                <span title="Modifier mon compte personnel" alt="editer"></span>
                <i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;<b>Modifier mon compte</b>
            </a>

            <br><br>
        </div>
    </div>
</div>
<!--</div>-->