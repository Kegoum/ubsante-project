
<nav class="navbar navbar-custom navbar-fixed-top " >

    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand" href="#">CORE</a>-->
            <?php
            if (($_SESSION["roleutilisateur"] == "Administrateur") || ($_SESSION["roleutilisateur"] == "Directeur Général Adjoint") || ($_SESSION["roleutilisateur"] == "Directeur Général") || ($_SESSION["roleutilisateur"] == "Directeur Administratif et Finance") || ($_SESSION["roleutilisateur"] == "Chef Finance")) {
                ?>
                <div id="dl-menu" class="dl-menuwrapper">
                    <button class="dl-trigger">Menu</button>
                    <ul class="dl-menu">
                        <li>
                            <a href="#">Paramètre</a>
                            <ul class="dl-submenu">
                                <li>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallangue/lister_langue'); ?>">Langue</a>
                                </li>
                                <li>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldevise/lister_devise'); ?>">D&eacute;vise</a>
                                </li>
                                <li>
                                    <a href="#">
                                        Pays
                                    </a>
                                    <ul class="dl-submenu">
                                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalpays/lister_pays'); ?>">Pays</a></li>
                                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalville/lister_ville'); ?>">Ville</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        Entreprise
                                    </a>
                                    <ul class="dl-submenu">
                                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalentreprise/lister_entreprise'); ?>">Entreprise</a></li>
                                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalentete/lister_entete'); ?>">Entête</a></li>
                                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldepartement/lister_departement'); ?>">D&eacute;partement</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#">
                                        Banque
                                    </a>
                                    <ul class="dl-submenu">
                                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalbanque/lister_banque'); ?>">Banque</a></li>
                                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalcomptebancaire/lister_comptebancaire'); ?>">Compte Bancaire</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaltypefournisseur/lister_typefournisseur'); ?>">Type Fourniseur</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /dl-menuwrapper -->
                <?php
            }
            ?>
            <?php
            ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo $url; ?>"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> Accueil</a></li>
                <?php
                if (($_SESSION["roleutilisateur"] == "Administrateur") || ($_SESSION["roleutilisateur"] == "Directeur Général Adjoint") || ($_SESSION["roleutilisateur"] == "Directeur Général") || ($_SESSION["roleutilisateur"] == "Directeur Administratif et Finance") || ($_SESSION["roleutilisateur"] == "Chef Finance")) {
                    ?>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalutilisateur/lister_utilisateur'); ?>"> Utilisateur</a></li>
                    <?php
                }
                if (($_SESSION["roleutilisateur"] != "Chef Matériel") && ($_SESSION["roleutilisateur"] != "Chef d'Achat") && ($_SESSION["roleutilisateur"] != "Chef d'Opération")) {
                    ?>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfournisseur/lister_fournisseur'); ?>"> Fournisseur</a></li>
                    <?php
                }
                if (($_SESSION["roleutilisateur"] != "Chef Matériel") && ($_SESSION["roleutilisateur"] != "Chef d'Achat") && ($_SESSION["roleutilisateur"] != "Chef d'Opération")) {
                    ?>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalprojet/lister_projet'); ?>"> Projet</a></li>
                    <?php
                }
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Courrier <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalcourrier/lister_courrier'); ?>"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Gestion des courriers</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalcourrier/courrier_archive_form'); ?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Courriers archiv&eacute;s</a></li>
                    </ul>
                </li>
                <?php
                if (($_SESSION["roleutilisateur"] != "Chef Matériel") && ($_SESSION["roleutilisateur"] != "Chef d'Achat") && ($_SESSION["roleutilisateur"] != "Chef d'Opération") && ($_SESSION["roleutilisateur"] != "Bureau d'Ordre") && ($_SESSION["roleutilisateur"] != "Contrôleur de Dépenses")) {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Etat de paiement <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaletatpaiement/lister_etatpaiement'); ?>">Gestion des &eacute;tats de paiement</a></li>
                            <li role="separator" class="divider"></li>
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaletatpaiement/etatpaiement_paye_form'); ?>"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Engagement Tiers</a></li>
                    </ul>
                    </li>
                    <?php
                }
                ?>
                    
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmemo/lister_memo'); ?>"> Memo</a></li>
                    
                    <?php
                if (($_SESSION["roleutilisateur"] == "Administrateur") || ($_SESSION["roleutilisateur"] == "Directeur Général Adjoint") || ($_SESSION["roleutilisateur"] == "Directeur Général") || ($_SESSION["roleutilisateur"] == "Directeur Administratif et Finance") || ($_SESSION["roleutilisateur"] == "Chef Finance")) {
                    ?>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalcharge/lister_charge'); ?>"> Charge</a></li>
                    <?php
                }
                ?>
                    <?php
                if (($_SESSION["roleutilisateur"] == "Administrateur") || ($_SESSION["roleutilisateur"] == "Directeur Général Adjoint") || ($_SESSION["roleutilisateur"] == "Directeur Général") || ($_SESSION["roleutilisateur"] == "Directeur Administratif et Finance")) {
                    ?>
                    <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldecompte/lister_decompte'); ?>"> D&eacute;compte</a></li>
                    <?php
                }
                ?>
                <?php
                if (($_SESSION["roleutilisateur"] != "Chef Matériel") && ($_SESSION["roleutilisateur"] != "Chef d'Achat") && ($_SESSION["roleutilisateur"] != "Chef d'Opération") && ($_SESSION["roleutilisateur"] != "Bureau d'Ordre") && ($_SESSION["roleutilisateur"] != "Contrôleur de Dépenses") && ($_SESSION["roleutilisateur"] != "Comptable") && ($_SESSION["roleutilisateur"] != "Chef Comptable")) {
                    $annee=date('Y');
					?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Budget <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitaltrimestre/lister_trimestre'); ?>">Trimestre</a></li>
                            <!--<li><a href="#">Decaissement</a></li>-->
                            <li role="separator" class="divider"></li>
                                                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalencaissement/lister_encaissement'); ?>">Encaissement</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/lister_budget'); ?>">Tr&eacute;sorerie</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/afficher_budget_annee'); ?>&annee=<?php echo $annee; ?>">Budget Annuel</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <?php
                if (($_SESSION["roleutilisateur"] == "Administrateur") || ($_SESSION["roleutilisateur"] == "Directeur Général Adjoint") || ($_SESSION["roleutilisateur"] == "Directeur Général") || ($_SESSION["roleutilisateur"] == "Directeur Administratif et Finance") || ($_SESSION["roleutilisateur"] == "Chef Finance")) {
                    $mois1="Janvier";
                    $mois2="Février";
                    $mois3="Mars";
                    $mois4="Avril";
                    $mois5="Mai";
                    $mois6="Juin";
                    $mois7="Juillet";
                    $mois8="Août";
                    $mois9="Septembre";
                    $mois10="Octobre";
                    $mois11="Novembre";
                    $mois12="Décembre";
                    $year=date('Y');
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Liquidation <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois1; ?>&annee=<?php echo $year; ?>">Janvier</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois2; ?>&annee=<?php echo $year; ?>">F&eacute;vrier</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois3; ?>&annee=<?php echo $year; ?>">Mars</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois4; ?>&annee=<?php echo $year; ?>">Avril</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois5; ?>&annee=<?php echo $year; ?>">Mai</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois6; ?>&annee=<?php echo $year; ?>">Juin</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois7; ?>&annee=<?php echo $year; ?>">Juillet</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois8; ?>&annee=<?php echo $year; ?>">Ao&ucirc;t</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois9; ?>&annee=<?php echo $year; ?>">Septembre</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois10; ?>&annee=<?php echo $year; ?>">Octobre</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois11; ?>&annee=<?php echo $year; ?>">Novembre</a></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalbudget/hopitalpositionnement/afficher_positionnement'); ?>&mois=<?php echo $mois12; ?>&annee=<?php echo $year; ?>">D&eacute;cembre</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                    <?php
                if (($_SESSION["roleutilisateur"] == "Administrateur") || ($_SESSION["roleutilisateur"] == "Directeur Général Adjoint") || ($_SESSION["roleutilisateur"] == "Directeur Général") || ($_SESSION["roleutilisateur"] == "Directeur Administratif et Finance") || ($_SESSION["roleutilisateur"] == "Chef Finance")) {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Statistique <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfournisseur/historiquefournisseur/lister_fournisseur'); ?>">Historique de fournisseurs</a></li>
                    <li role="separator" class="divider"></li>
                            <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalstatistique/statistique_form'); ?>">Statistique annuel</a></li>
                    </ul>
                    </li>
                        <?php
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $_SESSION["prenomuser"]; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalutilisateur/info_user'); ?>" ><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Mon profil</a>
                        </li>
                        <li>
                            <a href="javascript:deconnexion();">
                                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 
                                D&eacute;connexion
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
