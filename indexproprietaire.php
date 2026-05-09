
<?php
session_start();
ob_start();

include('hopitalconnexion/connexion.php');
include('./hopitalincludes/fonctionglobale.php');

include './hopitalincludes/get_url.php';
?>
<!doctype html>
<html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>HOPITAL</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- favicon
                    ============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="hopitalupload/logo/<?php echo $_SESSION["logoproprietaire"] ?>">


        <!-- Bootstrap CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/bootstrap.min.css">

        <!-- menu -->
        <link href="hopitalplugin/menu/css/component.css" rel="stylesheet" type="text/css" />

        <!-- Bootstrap CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/font-awesome.min.css">
        <!-- owl.carousel CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/owl.carousel.css">
        <link rel="stylesheet" href="hopitalcss/owl.theme.css">
        <link rel="stylesheet" href="hopitalcss/owl.transitions.css">
        <!-- animate CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/animate.css">
        <!-- normalize CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/normalize.css">
        <!-- meanmenu icon CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/meanmenu.min.css">
        <!-- main CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/main.css">
        <!-- educate icon CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/educate-custon-icon.css">
        <!-- morrisjs CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/morrisjs/morris.css">
        <!-- mCustomScrollbar CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/scrollbar/jquery.mCustomScrollbar.min.css">
        <!-- metisMenu CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/metisMenu/metisMenu.min.css">
        <link rel="stylesheet" href="hopitalcss/metisMenu/metisMenu-vertical.css">
        <!-- calendar CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/calendar/fullcalendar.min.css">
        <link rel="stylesheet" href="hopitalcss/calendar/fullcalendar.print.min.css">

        <!-- normalize CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/data-table/bootstrap-table.css">
        <link rel="stylesheet" href="hopitalcss/data-table/bootstrap-editable.css">
        <!-- style CSS ============================================ -->

        <link rel="stylesheet" href="hopitalcss/responsive.css">

        <!-- pour la selection multiple 
         
        <!-- select2 CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/select2/select2.min.css">
        <!-- chosen CSS
                    ============================================ -->
        <link rel="stylesheet" href="hopitalcss/chosen/bootstrap-chosen.css">
        <!-- fin la selection multiple-->

    <!-- summernote CSS
		============================================ -->
    <link rel="stylesheet" href="hopitalcss/summernote/summernote.css">
        <link rel="stylesheet" href="style.css">
        <!-- jquery
                    ============================================ -->
        <script src="hopitaljs/vendor/jquery-1.12.4.min.js"></script>
        <!-- modernizr JS
                    ============================================ -->
        <script src="hopitaljs/vendor/modernizr-2.8.3.min.js"></script>


        <!-- validation des formulaires -->
        <link href="hopitalplugin/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
        <link type="text/css" rel="stylesheet" href="hopitalcss/bootstrap-fileupload.min.css"/><!--pour la confirmation des fichier et images-->

        <!--Pour previsualiser les images du dossier-->
        <script src="hopitaljs/jquery.imagebox.js"></script>

        <!-- les dates -->
        <link rel="stylesheet" href="hopitalplugin/datetimepicker/css/bootstrap-datetimepicker.min.css">
        <!--<link rel="stylesheet" href="plugin/datetimepicker/css/bootstrap-combined.min.css">-->

        <script type="text/javascript">

            $(function() {
                $("#datecreatione").datetimepicker({
                    language: 'fr',
                    format: 'yyyy-mm-dd',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 0
                });
                $('#datearrive').datetimepicker({
                    language: 'fr',
                    format: 'yyyy-mm-dd',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 0
                });
                $("#datearrivee").datetimepicker({
                    language: 'fr',
                    format: 'yyyy-mm-dd',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 0
                });
                $('.periode').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });
                $('.moisis').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });
                $('.annee').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 4,
                    minView: 4,
                    forceParse: 0
                });
                $('.anneee').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 4,
                    minView: 4,
                    forceParse: 0
                });
                $('.moisd').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });
                $('.moisde').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });

                $('.datecni').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 0
                });

                $('.datepassport').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 0
                });

                $('.mois1').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });
                $('.mois1e').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });
                $('.mois2').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });
                $('.mois2e').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });
                $('.mois3').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });
                $('.mois3e').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 3,
                    minView: 3,
                    forceParse: 0
                });
                $('.datedhf').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 0
                });
                $('.datefhf').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    forceParse: 0
                });

                $("#datedhf").on("dp.change", function(e) {
                    $('#datefhf').data("DateTimePicker").minDate(e.date);
                });
                $("#datefhf").on("dp.change", function(e) {
                    $('#datedhf').data("DateTimePicker").maxDate(e.date);
                });
                

            });
            
            
            $(function() {
                $('#datecj').datepicker();
                $('#datecj').on('changeDate', function(ev) {
                    $(this).datepicker('hide');
                });
                $('#datedcp').datepicker();
                $('#datedcp').on('changeDate', function(ev) {
                    $(this).datepicker('hide');
                });
                $('#datefcp').datepicker();
                $('#datefcp').on('changeDate', function(ev) {
                    $(this).datepicker('hide');
                });
            });
        </script>

        <script src="hopitalckeditor/ckeditor.js"></script>
        <script src="hopitalckfinder/ckfinder.js"></script>

        <style>
            body{
                font-family: Book Antiqua !important;
            }
            thead th{
                white-space: nowrap;
            }
            .panel-heading{
                padding: 1px;
            }
        </style>

        <style>
            th{
                text-transform: uppercase;
                text-align: center;
            }
        </style>
    </head>

    <?php
    if (!($_SESSION["loginproprietaire"]) || !($_SESSION["motdepasseproprietaire"])) {
        header("location:index.php");
    }
    ?>

    <body>
        <!--<div class="container-fluid">-->
        <?php include('./hopitalincludes/navbar_pro.php'); ?>
        <div class="container-fluid" style="padding-top: 50px; margin-left: 0px;"  >
            <!--[if lt IE 8]>
                        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
                <![endif]-->

            <?php
            include './hopitalpages/hopitalparametre/hopitalregion/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitaldepartement/hopitalfonction.php';
            //include './hopitalpages/hopitalparametre/hopitalproprietaire/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalunite/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalservice/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalacte/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalgrilleprix/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalechographie/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalexamen/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalcaisse/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalparametre/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalchambre/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitalsoin/hopitalfonction.php';
            include './hopitalpages/hopitalparametre/hopitallaboratoire/hopitalfonction.php';
//
            include './hopitalpages/hopitalproprietaire/hopitalfonction.php';
            include './hopitalpages/hopitalpersonnel/hopitalfonction.php';
            include './hopitalpages/hopitalpersonnel/hopitalpointage/hopitalfonction.php';
            include './hopitalpages/hopitalvaccin/hopitalfonction.php';
//            include './hopitalpages/hopitalvaccin/hopitalparametre/hopitalfonction.php';
            include './hopitalpages/hopitalvaccin/hopitaldossiervaccin/hopitalfonction.php';
            include './hopitalpages/hopitalpatient/hopitalfonction.php';
            include './hopitalpages/hopitalpatient/hopitalparametre/hopitalfonction.php';
            include './hopitalpages/hopitalpatient/hopitalconsultation/hopitalfonction.php';
            include './hopitalpages/hopitalpatient/hopitalexamen/hopitalfonction.php';
            include './hopitalpages/hopitalpatient/hopitalechographie/hopitalfonction.php';
            include './hopitalpages/hopitalpatient/hopitaldossierpatient/hopitalfonction.php';
            include './hopitalpages/hopitalmagasin/hopitalfonction.php';
            include './hopitalpages/hopitalpharmacie/hopitalfonction.php';
            include './hopitalpages/hopitalfacture/hopitalfonction.php';
            include './hopitalpages/hopitalproduit/hopitalfonction.php';
            include './hopitalpages/hopitaldecaissement/hopitalfonction.php';
            include './hopitalpages/hopitalconditionnement/hopitalfonction.php';
            include './hopitalpages/hopitaldosage/hopitalfonction.php';
            include './hopitalpages/hopitalfamille/hopitalfonction.php';
            include './hopitalpages/hopitalforme/hopitalfonction.php';
            include './hopitalpages/hopitallaboratoireproduit/hopitalfonction.php';
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="javascript:history.go(-1)" class="btn btn-sm pull-left btn-primary" ><i class="glyphicon glyphicon-backward"></i> Pr&eacute;cedant</a>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12" id="products">
                            <?php include './hopitalincludes/alertjs.php'; ?>
                            <?php
                            if (isset($_REQUEST["page"])) {
                                $page = base64_decode($_REQUEST["page"]) . ".php";
                                if (file_exists($page)) {
                                    include ($page);
                                } else {
                                    echo 'Page nom disponible sur le serveur';
                                }
                            } else {
                                include './hopitalincludes/hopitalaccueil.php';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->

        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-copy-right">
                            <p>Copyright © 2022. tous droits réservés. <?php echo $_SESSION["hopitalproprietaire"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--</div>-->

        <!-- bootstrap JS
                    ============================================ -->
        <script src="hopitaljs/bootstrap.min.js"></script>


        <!-- validation des formulaires -->
        <script src="hopitalplugin/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
        <script src="hopitalplugin/bootstrapvalidator/js/language/fr_FR.js"></script>
        <script src="hopitaljs/bootstrap-fileupload.js"></script>

        <!-- menu -->
        <script src="hopitalplugin/menu/js/jquery.dlmenu.js"></script>
        <script>
            $(function() {
                $('#dl-menu').dlmenu();
            });
        </script>


        <!-- wow JS
                    ============================================ -->
        <script src="hopitaljs/wow.min.js"></script>
        <!-- price-slider JS
                    ============================================ -->
        <script src="hopitaljs/jquery-price-slider.js"></script>
        <!-- meanmenu JS
                    ============================================ -->
        <script src="hopitaljs/jquery.meanmenu.js"></script>
        <!-- owl.carousel JS
                    ============================================ -->
        <script src="hopitaljs/owl.carousel.min.js"></script>
        <!-- sticky JS
                    ============================================ -->
        <script src="hopitaljs/jquery.sticky.js"></script>
        <!-- scrollUp JS
                    ============================================ -->
        <script src="hopitaljs/jquery.scrollUp.min.js"></script>
        <!-- counterup JS
                    ============================================ -->
        <script src="hopitaljs/counterup/jquery.counterup.min.js"></script>
        <script src="hopitaljs/counterup/waypoints.min.js"></script>
        <script src="hopitaljs/counterup/counterup-active.js"></script>
        <!-- mCustomScrollbar JS
                    ============================================ -->
        <script src="hopitaljs/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="hopitaljs/scrollbar/mCustomScrollbar-active.js"></script>
        <!-- metisMenu JS
                    ============================================ -->
        <script src="hopitaljs/metisMenu/metisMenu.min.js"></script>
        <script src="hopitaljs/metisMenu/metisMenu-active.js"></script>

    <!-- summernote JS
		============================================ -->
    <script src="hopitaljs/summernote/summernote.min.js"></script>
    <script src="hopitaljs/summernote/summernote-active.js"></script>
        <!-- data table JS
                    ============================================ -->
        <script src="hopitaljs/data-table/bootstrap-table.js"></script>
        <script src="hopitaljs/data-table/tableExport.js"></script>
        <script src="hopitaljs/data-table/data-table-active.js"></script>
        <script src="hopitaljs/data-table/bootstrap-table-editable.js"></script>
        <script src="hopitaljs/data-table/bootstrap-editable.js"></script>
        <script src="hopitaljs/data-table/bootstrap-table-resizable.js"></script>
        <script src="hopitaljs/data-table/colResizable-1.5.source.js"></script>
        <script src="hopitaljs/data-table/bootstrap-table-export.js"></script>
        <script>
        $('#table').bootstrapTable({
            pagination: true,
            pageSize: 100, //your page size here
            pageList: [100, 200, 300, 500] //list of page sizes
        });
        </script>
        <!-- morrisjs JS
                    ============================================ -->
        <script src="hopitaljs/morrisjs/raphael-min.js"></script>
        <script src="hopitaljs/morrisjs/morris.js"></script>
        <script src="hopitaljs/morrisjs/morris-active.js"></script>
        <!-- morrisjs JS
                    ============================================ -->
        <script src="hopitaljs/sparkline/jquery.sparkline.min.js"></script>
        <script src="hopitaljs/sparkline/jquery.charts-sparkline.js"></script>
        <script src="hopitaljs/sparkline/sparkline-active.js"></script>
        <!-- calendar JS
                    ============================================ -->
        <script src="hopitaljs/calendar/moment.min.js"></script>
        <script src="hopitaljs/calendar/fullcalendar.min.js"></script>
        <script src="hopitaljs/calendar/fullcalendar-active.js"></script>
        <!-- plugins JS
                    ============================================ -->
        <script src="hopitaljs/plugins.js"></script>
        <!-- main JS
                    ============================================ -->
        <script src="hopitaljs/main.js"></script>
        <!-- tawk chat JS
                    ============================================ -->
<!--        <script src="hopitaljs/tawk-chat.js"></script>-->

        <!-- chosen JS
                    ============================================ -->
        <script src="hopitaljs/chosen/chosen.jquery.js"></script>
        <script src="hopitaljs/chosen/chosen-active.js"></script>
        <!-- select2 JS
                    ============================================ -->
        <script src="hopitaljs/select2/select2.full.min.js"></script>
        <script src="hopitaljs/select2/select2-active.js"></script>

        <!-- les dates -->
        <script src="hopitalplugin/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="hopitalplugin/datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
        <script src="hopitalplugin/moment/moment.min.js"></script>

        <script src="hopitaljs/scriptajax.js"></script>


    </body>

</html>

<?php
ob_end_flush();
?>