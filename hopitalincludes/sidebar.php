<nav id="sidebar" class="">
    <div class="sidebar-header">
<!--                    <a href="index.html"><img class="main-logo" src="img/logo/logo.jpeg" alt="" /></a>
        <strong><a href="index.html"><img src="img/logo/logosn.png" alt="" /></a></strong>-->
    </div>
    <div class="left-custom-menu-adp-wrap comment-scrollbar">
        <nav class="sidebar-nav left-sidebar-menu-pro">
            <ul class="metismenu" id="menu1">
                <!--<li class="active">-->
                <li>
                    <a class="has-arrow" href="<?php echo $url; ?>" aria-expanded="true">
                        <i class="fa big-icon fa-home icon-wrap"></i>
                        <span class="mini-click-non">Param&egrave;tre</span>
                    </a>
                    <ul class="submenu-angle" aria-expanded="false">
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallangue/lister_langue'); ?>"><i class="fa fa-language sub-icon-mg" aria-hidden="true"  title="Langue"></i> <span class="mini-sub-pro">Langue</span></a></li>
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldevise/lister_devise'); ?>"><i class="fa fa-money sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Devise</span></a></li>
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalpays/lister_pays'); ?>"><i class="fa fa-home sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Pays</span></a></li>
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalville/lister_ville'); ?>"><i class="fa fa-home sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Ville</span></a></li>
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalentreprise/lister_entreprise'); ?>"><i class="fa fa-home sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Entreprise</span></a></li>
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalentete/lister_entete'); ?>"><i class="fa fa-home sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Ent&ecirc;te</span></a></li>
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldepartement/lister_departement'); ?>"><i class="fa fa-home sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">D&eacute;partement</span></a></li>
                        <li><a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaltypefournisseur/lister_typefournisseur'); ?>"><i class="fa fa-car sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Type Fourniseur</span></a></li>
                    </ul>
                </li>
                <?php
                if (($_SESSION["roleutilisateur"] == "Administrateur") || ($_SESSION["roleutilisateur"] == "Chef d'Achat") || ($_SESSION["roleutilisateur"] == "Directeur Administratif et Finance") || ($_SESSION["roleutilisateur"] == "Directeur Général Adjoint") || ($_SESSION["roleutilisateur"] == "Directeur Général")) {
                    ?>
                    <li>
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="fa big-icon fa-buysellads icon-wrap"></i> 
                            <span class="mini-click-non">Achat</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a title="" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalunite/lister_unite'); ?>"><i class="fa fa-mercury sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Unit&eacute;</span></a></li>
                            <li><a title="" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalmodepaiement/lister_modepaiement'); ?>"><i class="fa fa-paypal sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Mode de Paiement</span></a></li>
                        </ul>
                    </li>
                    <?php
                }
                if (($_SESSION["roleutilisateur"] == "Administrateur") || ($_SESSION["roleutilisateur"] == "Chef d'Opération") || ($_SESSION["roleutilisateur"] == "Directeur Administratif et Finance") || ($_SESSION["roleutilisateur"] == "Directeur Général Adjoint") || ($_SESSION["roleutilisateur"] == "Directeur Général")) {
                    ?>
                    <li>
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="fa big-icon fa-opera icon-wrap"></i> 
                            <span class="mini-click-non">Op&eacute;ration</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a title="" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalequipe/lister_equipe'); ?>"><i class="fa fa-users sub-icon-mg" aria-hidden="true"></i> <span class="mini-sub-pro">Equipe</span></a></li>
                        </ul>
                    </li>
                    <?php
                }
                if (($_SESSION["roleutilisateur"] == "Administrateur") || ($_SESSION["roleutilisateur"] == "Directeur Général Adjoint") || ($_SESSION["roleutilisateur"] == "Directeur Général") || ($_SESSION["roleutilisateur"] == "Directeur Administratif et Finance") || ($_SESSION["roleutilisateur"] == "Chef d'Opération") || ($_SESSION["roleutilisateur"] == "Chef d'Achat")) {
                    ?>
                    <li>
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="fa big-icon fa-user icon-wrap"></i> 
                            <span class="mini-click-non">Utilisateur</span>
                        </a>
                        <ul class="submenu-angle" aria-expanded="false">
                            <li><a title="Login" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalutilisateur/lister_utilisateur'); ?>"><i class="fa fa-user-circle sub-icon-mg" aria-hidden="true"></i><span class="mini-sub-pro">Utilisateur</span></a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </nav>
    </div>
</nav>