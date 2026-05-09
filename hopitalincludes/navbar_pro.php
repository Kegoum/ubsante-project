<div class="container-fluid">
    <div class="row">
        <div class="col-md-1 col-lg-1 col-sm-2 col-xs-2">
            <?php
//            if (($_SESSION["roleproprietaire"] == "Super Administrateur") || ($_SESSION["roleproprietaire"] == "Administrateur")) {
            ?><br>
            <div id="dl-menu" class="dl-menuwrapper">
                <button class="dl-trigger">Menu</button>
                <ul class="dl-menu">
                    <li>
                        <a href="#">Param&egrave;tre</a>
                        <ul class="dl-submenu">
                            <li>
                                <a href="#">
                                    R&eacute;gion
                                </a>
                                <ul class="dl-submenu">
                                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalregion/lister_region'); ?>">R&eacute;gion</a></li>
                                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldepartement/lister_departement'); ?>">D&eacute;partement</a></li>
                                </ul>
                            </li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproprietaire/info_user'); ?>">Proprietaire</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalunite/lister_unite'); ?>">Unit&eacute;</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalcaisse/lister_caisse'); ?>">Caisse</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalparametre/lister_parametre'); ?>">Param&egrave;tre</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalmodepaiement/lister_modepaiement'); ?>">Mode de paiement</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalservice/lister_service'); ?>">Services</a></li>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalacte/lister_acte'); ?>">Acte</a></li>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalexamen/lister_examen'); ?>">Examen</a></li>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalechographie/lister_echographie'); ?>">Echographie</a></li>
                    <li>
                        <a href="#">
                            Laboratoire
                        </a>
                        <ul class="dl-submenu">
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/lister_laboratoire'); ?>">Laboratoire</a></li>
                            <li>
                                <a href="#">
                                    Type
                                </a>
                                <ul class="dl-submenu">
<!--                                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalserologiewidalfelix/lister_serologiewidalfelix'); ?>">Sérologie de Widal et Felix</a></li>
                                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalvih/lister_vih'); ?>">Sérologie V.I.H</a></li>
                                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalcorprologieparasitaire/lister_corprologieparasitaire'); ?>">Coprologie Parasitaire: Selles</a></li>
                                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalpcv/lister_pcv'); ?>">Prélèvement Cervico-Vaginal: PCV</a></li>-->
                                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/lister_nfs'); ?>">Ligne Numération Formule Sanguine (NFS)</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            Pharmacie
                        </a>
                        <ul class="dl-submenu">
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/lister_magasin'); ?>">Magasin</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/lister_pharmacie'); ?>">Pharmacie</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            Salle
                        </a>
                        <ul class="dl-submenu">
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/lister_categoriechambre'); ?>">Cat&eacute;gorie</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/lister_materiel'); ?>">Mat&eacute;riel</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/lister_chambre'); ?>">Salle</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalsoin/lister_soin'); ?>">Soin</a></li>
                     <!--<li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalacte/lister_acte'); ?>">Acte</a></li>-->
                </ul>
            </div><!-- /dl-menuwrapper -->
            <?php
//            } else {
            ?>
            <!--&nbsp;<br>-->
            <?php
//            }
            ?>
        </div>

    </div>
</div>
<div class="header-top-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <div class="header-top-menu tabl-d-n">
                    <ul class="nav navbar-nav mai-top-nav ">
                        <li class="nav-item"><a href="<?php echo $url; ?>"  class="nav-link area" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;" >Accueil</a></li>
                        <?php
//                        if (($_SESSION["roleproprietaire"] == "Super Administrateur")) {
                        ?>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Personnel <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/lister_personnel'); ?>" class="dropdown-item">Liste des Personnels</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpointage/lister_personnel'); ?>" class="dropdown-item">Pointage</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpaye/lister_personnel'); ?>" class="dropdown-item">Paye</a>
                            </div>
                        </li>
                        <?php
//                        }
                        ?>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Patient <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/lister_patient'); ?>" class="dropdown-item">Liste des Patients</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/lister_patient_hospitalisation'); ?>" class="dropdown-item">Liste des Patients hospitalis&eacute;s</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Vaccin <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/lister_vaccin'); ?>" class="dropdown-item">Liste des Vaccins</a>
                                <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/historique_vaccin_form'); ?>" class="dropdown-item">Historique des vaccin</a>-->
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Facture <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/lister_facture'); ?>" class="dropdown-item">Factures Impay&eacute;es</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/facture_form'); ?>" class="dropdown-item">Toutes les Factures</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldecaissement/lister_decaissement'); ?>" class="nav-link area" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >D&eacute;caissement</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Examen <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/lister_examen'); ?>" class="dropdown-item">Liste des Examens</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Echographie <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/lister_echographie'); ?>" class="dropdown-item">Liste des Echographies</a>
                            </div>
                        </li>
<!--                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Produit <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalcategorie/lister_categorie'); ?>" class="dropdown-item">D.C.I. /PRINCIPE ACTIF</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalconditionnement/lister_conditionnement'); ?>" class="dropdown-item">Conditionnement</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldosage/lister_dosage'); ?>" class="dropdown-item">Dosage</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfamille/lister_famille'); ?>" class="dropdown-item">Famille</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalforme/lister_forme'); ?>" class="dropdown-item">Forme</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitallaboratoireproduit/lister_laboratoireproduit'); ?>" class="dropdown-item">Laboratoire</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalvalorisation/lister_valorisation'); ?>" class="dropdown-item">Valosisation des stocks</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/lister_produit'); ?>" class="dropdown-item">Liste des Produits</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalproduitavarie/lister_produit_avarie'); ?>" class="dropdown-item">Liste des Produits avaries</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/lister_commande'); ?>" class="dropdown-item">Bon de commande</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraison/lister_livraison'); ?>" class="dropdown-item">Bon de livraison</a>
                            </div>
                        </li>-->
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Pharmacie <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/lister_pharmacie'); ?>">Pharmacie </a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalcategorie/lister_categorie'); ?>" class="dropdown-item">D.C.I. /PRINCIPE ACTIF</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalconditionnement/lister_conditionnement'); ?>" class="dropdown-item">Conditionnement</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldosage/lister_dosage'); ?>" class="dropdown-item">Dosage</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfamille/lister_famille'); ?>" class="dropdown-item">Famille</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalforme/lister_forme'); ?>" class="dropdown-item">Forme</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitallaboratoireproduit/lister_laboratoireproduit'); ?>" class="dropdown-item">Laboratoire</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalvalorisation/lister_valorisation'); ?>" class="dropdown-item">Valosisation des stocks</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/lister_produit'); ?>" class="dropdown-item">Liste des Produits</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalproduitavarie/lister_produit_avarie'); ?>" class="dropdown-item">Liste des Produits avaries</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/lister_commande'); ?>" class="dropdown-item">Bon de commande</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraison/lister_livraison'); ?>" class="dropdown-item">Bon de livraison</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Ordonance <span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/lister_ordonnance'); ?>">Patient </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"  class="nav-link dropdown-toggle" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;">Finance<span class="angle-down-topmenu"><i class="fa fa-angle-down"></i></span></a>
                            <div role="menu" class="dropdown-menu animated zoomIn">
                                <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfinance/lister_service'); ?>">Finance par service</a>-->
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfinance/finance_form'); ?>">Toutes les Finance</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfinance/hopitaljournalcaisse/journalcaisse_form'); ?>">Journal de caisse</a>
                            </div>
                        </li>
                        <?php
//                        if (($_SESSION["roleproprietaire"] == "Super Administrateur")) {
                        ?>
                        <li class="nav-item"><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalinformationsanitaire/informationsanitaire_form'); ?>" class="nav-link area" style="padding-left: 5px; padding-right: 5px; font-size: 9pt;"  >Identification Sanitaire</a>
                        </li>
                        <?php
//                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="header-right-info">
                    <ul class="nav navbar-nav mai-top-nav header-right-menu">
                        <li class="nav-item">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle" style="padding-left: 0px; padding-right: 0px; font-size: 8pt;">
                                <span class="admin-name"><?php echo $_SESSION["nomproprietaire"]; ?></span>
                                <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                            </a>
                            <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproprietaire/info_user'); ?>"><span class="edu-icon edu-user-rounded author-log-ic"></span>Hopital</a>
                                </li>
                                <li><a href="javascript:deconnexion();"><span class="edu-icon edu-locked author-log-ic"></span>D&eacute;connexion</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Menu start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="mobile-menu-nav">

                            <li><a href="<?php echo $url; ?>" >Accueil</a></li>
                            <?php
//                        if (($_SESSION["roleproprietaire"] == "Super Administrateur")) {
                            ?>
                            <li>
                                <a href="#" data-toggle="collapse" data-target="#patient">Personnel <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="patient" class="collapse dropdown-header-top">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/lister_personnel'); ?>" class="dropdown-item">Liste des Personnels</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpointage/lister_personnel'); ?>" class="dropdown-item">Pointage</a>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpaye/lister_personnel'); ?>" class="dropdown-item">Paye</a>
                            </ul>
                            </li>
                            <?php
//                        }
                            ?>
                            <li>
                                <a href="#" data-toggle="collapse" data-target="#patient">Patient <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="patient" class="collapse dropdown-header-top">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/lister_patient'); ?>" >Liste des Patients</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/lister_patient_hospitalisation'); ?>" >Liste des Patients hospitalis&eacute;s</a>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="collapse" data-target="#vaccin">Vaccin <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="vaccin" class="collapse dropdown-header-top">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/lister_vaccin'); ?>" class="dropdown-item">Liste des Vaccins</a>
                                    <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/historique_vaccin_form'); ?>" class="dropdown-item">Historique des vaccin</a>-->
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="collapse" data-target="#facture">Facture <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="facture" class="collapse dropdown-header-top">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/lister_facture'); ?>" >Factures Impay&eacute;es</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/facture_form'); ?>" >Toutes les Factures</a>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldecaissement/lister_decaissement'); ?>">D&eacute;caissement</a>
                            </li>
                            <li>
                                <a href="#" data-toggle="collapse" data-target="#examen">Examen <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="examen" class="collapse dropdown-header-top">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/lister_examen'); ?>" >Liste des Examens</a>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="collapse" data-target="#echographie">Echographie <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="echographie" class="collapse dropdown-header-top">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/lister_echographie'); ?>" >Liste des Echographies</a>
                                </ul>
                            </li>
<!--                            <li>
                                <a href="#" data-toggle="collapse" data-target="#produit">Produit <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="produit" class="collapse dropdown-header-top">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalcategorie/lister_categorie'); ?>" >D.C.I. /PRINCIPE ACTIF</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalconditionnement/lister_conditionnement'); ?>" >Conditionnement</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldosage/lister_dosage'); ?>" >Dosage</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfamille/lister_famille'); ?>" >Famille</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalforme/lister_forme'); ?>" >Forme</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitallaboratoireproduit/lister_laboratoireproduit'); ?>" >Laboratoire</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalvalorisation/lister_valorisation'); ?>" >Valosisation des stocks</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/lister_produit'); ?>" >Liste des Produits</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalproduitavarie/lister_produit_avarie'); ?>" >Liste des Produits avaries</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/lister_commande'); ?>" >Bon de commande</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraison/lister_livraison'); ?>" >Bon de livraison</a>
                                </ul>
                            </li>-->
                            <li>
                                <a href="#" data-toggle="collapse" data-target="#pharmacie">Pharmacie <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="pharmacie" class="collapse dropdown-header-top">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/lister_pharmacie'); ?>">Pharmacie </a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalcategorie/lister_categorie'); ?>" >D.C.I. /PRINCIPE ACTIF</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalconditionnement/lister_conditionnement'); ?>" >Conditionnement</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldosage/lister_dosage'); ?>" >Dosage</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfamille/lister_famille'); ?>" >Famille</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalforme/lister_forme'); ?>" >Forme</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitallaboratoireproduit/lister_laboratoireproduit'); ?>" >Laboratoire</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalvalorisation/lister_valorisation'); ?>" >Valosisation des stocks</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/lister_produit'); ?>" >Liste des Produits</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalproduitavarie/lister_produit_avarie'); ?>" >Liste des Produits avaries</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/lister_commande'); ?>" >Bon de commande</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraison/lister_livraison'); ?>" >Bon de livraison</a>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="collapse" data-target="#ordonance">Ordonance <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="ordonance" class="collapse dropdown-header-top">
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/lister_ordonnance'); ?>">Patient </a>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="collapse" data-target="#finance">Finance <span class="admin-project-icon edu-icon edu-down-arrow"></span></a>
                                <ul id="finance" class="collapse dropdown-header-top">
                                    <!--<a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfinance/lister_service'); ?>">Finance par service</a>-->
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfinance/finance_form'); ?>">Toutes les Finance</a>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfinance/hopitaljournalcaisse/journalcaisse_form'); ?>">Journal de caisse</a>
                                </ul>
                            </li>
                            <?php
//                        if (($_SESSION["roleproprietaire"] == "Super Administrateur")) {
                            ?>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalinformationsanitaire/informationsanitaire_form'); ?>" >Identification Sanitaire</a>
                            </li>
                            <?php
//                        }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Menu end -->
<!--<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list  single-page-breadcome">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="breadcome-heading">
                                
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->