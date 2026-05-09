<script language="JavaScript">

</script>
<div class="col-xs-12 col-sm-12 col-md-12 well">

    <fieldset><legend>Finance P&eacute;riodique</legend>
        <form id="entreesortiep_form" role="form" name="form_annee" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfinance/finance_p'); ?>'); ?>" method="post">
            <div id="alertcp" class="alert alert-danger" style="display:none"> <strong>La date de fin doit être postérieure à la date de debut !</strong> </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <input name="datedcp" placeholder="Votre D&eacute;but de p&eacute;riode" type="text" class="form-control" autocomplete="off" id="datedcp" data-date-format="yyyy-mm-dd">
                        <div class="alert alert-block alert-danger alertdatedcp" style="display:none">
                            <h4>Erreur !</h4>
                            D&eacute;but de p&eacute;riode invalide !
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <input name="datefcp" placeholder="Votre Fin de p&eacute;riode" type="text" class="form-control" id="datefcp" autocomplete="off" data-date-format="yyyy-mm-dd" >
                        <div class="alert alert-block alert-danger alertdatefcp" style="display:none">
                            <h4>Erreur !</h4>
                            Fin de p&eacute;riode invalide !
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <input type="submit" id="Submitcp" class="btn btn-success" name="storecp" value="Afficher">
                </div>
            </div>
        </form>
    </fieldset>
</div>