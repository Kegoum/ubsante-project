-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 25 Janvier 2021 à 08:56
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `hopitalbd`
--

-- --------------------------------------------------------

--
-- Structure de la table `hp_affectation`
--

CREATE TABLE `hp_affectation` (
  `idaffectation` int(11) NOT NULL,
  `idpersonnel` int(11) NOT NULL,
  `idservice` int(11) NOT NULL,
  `butaffectation` varchar(254) DEFAULT NULL,
  `roleaffectation` varchar(254) NOT NULL,
  `etataffectation` tinyint(1) DEFAULT '1',
  `dateaffectation` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_affectation`
--

INSERT INTO `hp_affectation` (`idaffectation`, `idpersonnel`, `idservice`, `butaffectation`, `roleaffectation`, `etataffectation`, `dateaffectation`) VALUES
(1, 1, 2, 'Recrutement', 'Accueil', 0, '2021-01-15 05:18:03'),
(2, 2, 3, 'Recrutement', 'MÃ©decin', 1, '2021-01-15 05:25:43'),
(3, 3, 3, 'Recrutement', 'Pharmacien', 1, '2021-01-15 05:26:15'),
(4, 1, 2, 'Affectation', 'Accueil', 0, '2021-01-18 11:52:53'),
(5, 1, 3, 'Affectation', 'Infirmer', 1, '2021-01-18 11:55:12'),
(6, 4, 1, 'Recrutement', 'Magasinier', 1, '2021-01-21 17:58:31'),
(7, 5, 5, 'Recrutement', 'Caisse', 1, '2021-01-22 13:18:32'),
(8, 6, 5, 'Recrutement', 'Caisse', 1, '2021-01-22 13:28:04');

-- --------------------------------------------------------

--
-- Structure de la table `hp_bon_commande`
--

CREATE TABLE `hp_bon_commande` (
  `idboncommande` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `idmagasin` int(11) NOT NULL,
  `codeboncommande` varchar(254) NOT NULL,
  `montantboncommande` float NOT NULL,
  `typeboncommande` varchar(254) DEFAULT NULL,
  `etatboncommande` varchar(254) DEFAULT 'En Cours',
  `dateboncommande` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_bon_commande`
--

INSERT INTO `hp_bon_commande` (`idboncommande`, `idcomptepersonnel`, `idmagasin`, `codeboncommande`, `montantboncommande`, `typeboncommande`, `etatboncommande`, `dateboncommande`) VALUES
(1, 2, 1, 'C202100000001', 45000, NULL, 'Valider', '2021-01-24 19:10:13'),
(2, 2, 1, 'C202100000002', 200000, NULL, 'Valider', '2021-01-25 05:44:41'),
(3, 2, 1, 'C202100000003', 960000, NULL, 'En Cours', '2021-01-25 08:06:10');

-- --------------------------------------------------------

--
-- Structure de la table `hp_bon_commande_interne`
--

CREATE TABLE `hp_bon_commande_interne` (
  `idboncommandeinterne` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `idpharmacie` int(11) NOT NULL,
  `codeboncommandeinterne` varchar(254) NOT NULL,
  `montantboncommandeinterne` float NOT NULL,
  `typeboncommandeinterne` varchar(254) DEFAULT NULL,
  `etatboncommandeinterne` varchar(254) DEFAULT 'En Cours',
  `dateboncommandeinterne` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_bon_livraison`
--

CREATE TABLE `hp_bon_livraison` (
  `idbonlivraison` int(11) NOT NULL,
  `idmagasin` int(11) NOT NULL,
  `idboncommande` int(11) DEFAULT NULL,
  `idfournisseur` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `codebonlivraison` varchar(254) NOT NULL,
  `montantbonlivraison` float NOT NULL,
  `etatbonlivraison` varchar(254) DEFAULT 'En Cours',
  `datebonlivraison` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_bon_livraison`
--

INSERT INTO `hp_bon_livraison` (`idbonlivraison`, `idmagasin`, `idboncommande`, `idfournisseur`, `idcomptepersonnel`, `codebonlivraison`, `montantbonlivraison`, `etatbonlivraison`, `datebonlivraison`) VALUES
(1, 1, 1, 1, 2, 'L202100000001', 45000, 'Valider', '2021-01-24 19:10:13'),
(2, 1, 2, 1, 2, 'L202100000002', 200000, 'Valider', '2021-01-25 05:44:41');

-- --------------------------------------------------------

--
-- Structure de la table `hp_bon_livraison_interne`
--

CREATE TABLE `hp_bon_livraison_interne` (
  `idbonlivraisoninterne` int(11) NOT NULL,
  `idpharmacie` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `idboncommandeinterne` int(11) DEFAULT NULL,
  `idcomptepersonnelrecep` int(11) DEFAULT NULL,
  `idmagasin` int(11) NOT NULL,
  `codebonlivraisoninterne` varchar(254) NOT NULL,
  `montantbonlivraisoninterne` float NOT NULL,
  `etatbonlivraisoninterne` varchar(254) DEFAULT 'En Cours',
  `datebonlivraisoninterne` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_boutique`
--

CREATE TABLE `hp_boutique` (
  `idboutique` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `idpharmacie` int(11) NOT NULL,
  `stockboutique` float NOT NULL,
  `stockminboutique` float DEFAULT NULL,
  `stockmaxboutique` float DEFAULT NULL,
  `prixventeboutique` float NOT NULL,
  `etatboutique` tinyint(1) DEFAULT '1',
  `dateboutique` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_caisse`
--

CREATE TABLE `hp_caisse` (
  `idcaisse` int(11) NOT NULL,
  `codecaisse` varchar(254) NOT NULL,
  `nomcaisse` varchar(254) NOT NULL,
  `etatcaisse` tinyint(1) DEFAULT '1',
  `datecaisse` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_caisse`
--

INSERT INTO `hp_caisse` (`idcaisse`, `codecaisse`, `nomcaisse`, `etatcaisse`, `datecaisse`) VALUES
(1, 'CAISA', 'Caisse A', 1, '2021-01-22 12:13:26'),
(2, 'CAISB', 'Caisse B', 1, '2021-01-22 13:20:51');

-- --------------------------------------------------------

--
-- Structure de la table `hp_categorie`
--

CREATE TABLE `hp_categorie` (
  `idcategorie` int(11) NOT NULL,
  `codecategorie` varchar(254) NOT NULL,
  `libellecategorie` varchar(254) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_categorie`
--

INSERT INTO `hp_categorie` (`idcategorie`, `codecategorie`, `libellecategorie`) VALUES
(1, 'SOIN', 'soin'),
(2, 'OPER', 'opÃ©ration');

-- --------------------------------------------------------

--
-- Structure de la table `hp_compte_personnel`
--

CREATE TABLE `hp_compte_personnel` (
  `idcomptepersonnel` int(11) NOT NULL,
  `idpersonnel` int(11) NOT NULL,
  `logincomptepersonnel` varchar(254) NOT NULL,
  `motdepassecomptepersonnel` varchar(254) NOT NULL,
  `rolecomptepersonnel` varchar(254) NOT NULL DEFAULT 'Accueil',
  `etatcomptepersonnel` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_compte_personnel`
--

INSERT INTO `hp_compte_personnel` (`idcomptepersonnel`, `idpersonnel`, `logincomptepersonnel`, `motdepassecomptepersonnel`, `rolecomptepersonnel`, `etatcomptepersonnel`) VALUES
(1, 1, 'accueil', '63acf559f5523599c7ef4acc843b0ba1d91f7653', 'Accueil', 1),
(2, 4, 'maga', '84b50cc35b66b652b9ba4d87a5ede509f13deef7', 'Accueil', 1),
(3, 3, 'phara', '901562a2db01b425c55f65f602e161e3090a3a5a', 'Accueil', 1),
(4, 5, 'caissea', 'ad0648a6828d70865e9f923f032a75e28085f334', 'Accueil', 1),
(5, 2, 'meda', 'd19e01fc0f9a5265ac84bec9541017c52a7208ef', 'Accueil', 1),
(6, 6, 'caisseb', 'ff8133a00e1e23d902493fc1dc18a4c4ad3669c5', 'Accueil', 1);

-- --------------------------------------------------------

--
-- Structure de la table `hp_consultation`
--

CREATE TABLE `hp_consultation` (
  `idconsultation` int(11) NOT NULL,
  `idsousdossier` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `idgrilleprix` int(11) NOT NULL,
  `codeconsultation` varchar(254) NOT NULL,
  `prixconsultation` float DEFAULT NULL,
  `butconsultation` varchar(254) DEFAULT NULL,
  `signeconsultation` text,
  `symptomeconsultation` text,
  `diagnostiqueconsultation` text,
  `resultatconsultation` text,
  `traitementconsultation` text,
  `etatconsultation` tinyint(1) DEFAULT '0',
  `dateconsultation` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_consultation`
--

INSERT INTO `hp_consultation` (`idconsultation`, `idsousdossier`, `idcomptepersonnel`, `idgrilleprix`, `codeconsultation`, `prixconsultation`, `butconsultation`, `signeconsultation`, `symptomeconsultation`, `diagnostiqueconsultation`, `resultatconsultation`, `traitementconsultation`, `etatconsultation`, `dateconsultation`) VALUES
(1, 1, 1, 1, 'CON21012100001', 3000, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2021-01-21 06:32:44'),
(2, 3, 1, 1, 'CON25012100001', 3000, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2021-01-25 09:22:32');

-- --------------------------------------------------------

--
-- Structure de la table `hp_conversion`
--

CREATE TABLE `hp_conversion` (
  `idconversion` int(11) NOT NULL,
  `idunite` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `conversion` float DEFAULT NULL,
  `stockconversion` float DEFAULT NULL,
  `prixconversion` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_conversion`
--

INSERT INTO `hp_conversion` (`idconversion`, `idunite`, `idproduit`, `conversion`, `stockconversion`, `prixconversion`) VALUES
(1, 6, 1, 50, 100, 1000),
(2, 5, 1, 1, 2, 50000),
(3, 7, 1, 500, 1000, 100),
(4, 5, 2, 1, 5, 250000),
(5, 6, 2, 100, 500, 2500);

-- --------------------------------------------------------

--
-- Structure de la table `hp_departement`
--

CREATE TABLE `hp_departement` (
  `iddepartement` int(11) NOT NULL,
  `idregion` int(11) NOT NULL,
  `libelledepartement` varchar(254) NOT NULL,
  `cheflieudepartement` varchar(254) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_departement`
--

INSERT INTO `hp_departement` (`iddepartement`, `idregion`, `libelledepartement`, `cheflieudepartement`) VALUES
(1, 1, 'YaoundÃ© 1', 'YaoundÃ© 1');

-- --------------------------------------------------------

--
-- Structure de la table `hp_dossier`
--

CREATE TABLE `hp_dossier` (
  `iddossier` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `codedossier` varchar(254) NOT NULL,
  `etatdossier` tinyint(1) DEFAULT '1',
  `lieudossier` varchar(254) NOT NULL DEFAULT 'Accueil',
  `datedossier` datetime DEFAULT NULL,
  `archivedossier` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_dossier`
--

INSERT INTO `hp_dossier` (`iddossier`, `idpatient`, `idcomptepersonnel`, `codedossier`, `etatdossier`, `lieudossier`, `datedossier`, `archivedossier`) VALUES
(1, 1, 1, 'DOC21012100001', 1, 'Accueil', '2021-01-21 06:32:44', 0),
(2, 2, 1, 'DOC21012100002', 1, 'Accueil', '2021-01-21 07:10:47', 0),
(3, 3, 1, 'DOC25012100001', 1, 'Accueil', '2021-01-25 09:22:31', 0);

-- --------------------------------------------------------

--
-- Structure de la table `hp_examen`
--

CREATE TABLE `hp_examen` (
  `idexamen` int(11) NOT NULL,
  `idunite` int(11) DEFAULT NULL,
  `codeexamen` varchar(254) NOT NULL,
  `nomexamen` varchar(254) NOT NULL,
  `typeexamen` varchar(254) DEFAULT NULL,
  `prixexamen` float DEFAULT NULL,
  `resultatexamen` varchar(254) DEFAULT NULL,
  `valeurminexamen` float DEFAULT NULL,
  `valeurmaxexamen` float DEFAULT NULL,
  `etatexamen` tinyint(1) DEFAULT '1',
  `dateexamen` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_examen`
--

INSERT INTO `hp_examen` (`idexamen`, `idunite`, `codeexamen`, `nomexamen`, `typeexamen`, `prixexamen`, `resultatexamen`, `valeurminexamen`, `valeurmaxexamen`, `etatexamen`, `dateexamen`) VALUES
(1, 1, 'FNS', 'Fns', 'exa', 4000, '', 3.5, 10, 1, '2021-01-20 12:22:21');

-- --------------------------------------------------------

--
-- Structure de la table `hp_examen_patient`
--

CREATE TABLE `hp_examen_patient` (
  `idexamenpatient` int(11) NOT NULL,
  `idsousdossier` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `idconsultation` int(11) DEFAULT NULL,
  `idexamen` int(11) NOT NULL,
  `butexamenpatient` varchar(254) DEFAULT NULL,
  `codeexamenpatient` varchar(254) NOT NULL,
  `montantexamenpatient` float DEFAULT NULL,
  `resultatexamenpatient` varchar(254) DEFAULT NULL,
  `valeurexamenpatient` float DEFAULT NULL,
  `etatexamenpatient` tinyint(1) DEFAULT '0',
  `dateexamenpatient` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_examen_patient`
--

INSERT INTO `hp_examen_patient` (`idexamenpatient`, `idsousdossier`, `idcomptepersonnel`, `idconsultation`, `idexamen`, `butexamenpatient`, `codeexamenpatient`, `montantexamenpatient`, `resultatexamenpatient`, `valeurexamenpatient`, `etatexamenpatient`, `dateexamenpatient`) VALUES
(1, 2, 1, NULL, 1, NULL, 'EXA21012100001', 4000, NULL, NULL, 0, '2021-01-21 07:10:47');

-- --------------------------------------------------------

--
-- Structure de la table `hp_facture`
--

CREATE TABLE `hp_facture` (
  `idfacture` int(11) NOT NULL,
  `idordonnance` int(11) DEFAULT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `idexamenpatient` int(11) DEFAULT NULL,
  `idconsultation` int(11) DEFAULT NULL,
  `codefacture` varchar(254) NOT NULL,
  `montantfacture` float NOT NULL,
  `avancefacture` float DEFAULT NULL,
  `etatfacture` tinyint(1) DEFAULT '0',
  `datefacture` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_facture`
--

INSERT INTO `hp_facture` (`idfacture`, `idordonnance`, `idcomptepersonnel`, `idexamenpatient`, `idconsultation`, `codefacture`, `montantfacture`, `avancefacture`, `etatfacture`, `datefacture`) VALUES
(1, NULL, 1, NULL, 1, 'F21012100001', 3000, 3000, 1, '2021-01-21 06:32:44'),
(2, NULL, 1, 1, NULL, 'F21012100002', 4000, NULL, 0, '2021-01-21 07:10:47'),
(3, NULL, 1, NULL, 2, 'F25012100001', 3000, 3000, 1, '2021-01-25 09:22:32');

-- --------------------------------------------------------

--
-- Structure de la table `hp_fournisseur`
--

CREATE TABLE `hp_fournisseur` (
  `idfournisseur` int(11) NOT NULL,
  `nomfournisseur` varchar(254) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_fournisseur`
--

INSERT INTO `hp_fournisseur` (`idfournisseur`, `nomfournisseur`) VALUES
(1, 'Inconnu');

-- --------------------------------------------------------

--
-- Structure de la table `hp_grille_prix`
--

CREATE TABLE `hp_grille_prix` (
  `idgrilleprix` int(11) NOT NULL,
  `categoriegrilleprix` int(11) NOT NULL,
  `typegrilleprix` varchar(254) DEFAULT NULL,
  `designationgrilleprix` varchar(254) NOT NULL,
  `montantgrilleprix` float NOT NULL,
  `etatgrilleprix` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_grille_prix`
--

INSERT INTO `hp_grille_prix` (`idgrilleprix`, `categoriegrilleprix`, `typegrilleprix`, `designationgrilleprix`, `montantgrilleprix`, `etatgrilleprix`) VALUES
(1, 3, 'Consultation', 'Consultation GÃ©nÃ©rale', 3000, 1),
(2, 4, 'Examen', 'Ecographie mammaire', 15000, 1),
(3, 3, 'Vaccination', 'Vaccination Enfant', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `hp_laboratoire`
--

CREATE TABLE `hp_laboratoire` (
  `idlaboratoire` int(11) NOT NULL,
  `idservice` int(11) NOT NULL,
  `codelaboratoire` varchar(254) NOT NULL,
  `nomlaboratoire` varchar(254) NOT NULL,
  `butlaboratoire` varchar(254) DEFAULT NULL,
  `etatlaboratoire` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_ligne_bon_commande`
--

CREATE TABLE `hp_ligne_bon_commande` (
  `idligneboncommande` int(11) NOT NULL,
  `idunite` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `idboncommande` int(11) NOT NULL,
  `stockligneboncommande` float DEFAULT NULL,
  `stocklivreligneboncommande` float DEFAULT NULL,
  `prixligneboncommande` float DEFAULT NULL,
  `etatligneboncommande` varchar(254) DEFAULT 'En Cours'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_ligne_bon_commande`
--

INSERT INTO `hp_ligne_bon_commande` (`idligneboncommande`, `idunite`, `idproduit`, `idboncommande`, `stockligneboncommande`, `stocklivreligneboncommande`, `prixligneboncommande`, `etatligneboncommande`) VALUES
(1, 5, 1, 1, 2, 2, 45000, 'Valider'),
(2, 5, 2, 2, 5, 5, 200000, 'Valider'),
(3, 5, 1, 3, 8, NULL, 45000, 'En Cours'),
(4, 5, 2, 3, 3, NULL, 200000, 'En Cours');

-- --------------------------------------------------------

--
-- Structure de la table `hp_ligne_bon_commande_interne`
--

CREATE TABLE `hp_ligne_bon_commande_interne` (
  `idligneboncommandeinterne` int(11) NOT NULL,
  `idunite` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `idboncommandeinterne` int(11) NOT NULL,
  `stockligneboncommandeinterne` float DEFAULT NULL,
  `stocklivreligneboncommandeinterne` float DEFAULT NULL,
  `prixligneboncommandeinterne` float DEFAULT NULL,
  `etatligneboncommandeinterne` varchar(254) DEFAULT 'En Cours'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_ligne_bon_livraison`
--

CREATE TABLE `hp_ligne_bon_livraison` (
  `idlignebonlivraison` int(11) NOT NULL,
  `idunite` int(11) NOT NULL,
  `idbonlivraison` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `stocklignebonlivraison` float DEFAULT NULL,
  `prixachatlignebonlivraison` float DEFAULT NULL,
  `prixventelignebonlivraison` float DEFAULT NULL,
  `etatlignebonlivraison` varchar(254) DEFAULT 'En Cours'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_ligne_bon_livraison`
--

INSERT INTO `hp_ligne_bon_livraison` (`idlignebonlivraison`, `idunite`, `idbonlivraison`, `idproduit`, `stocklignebonlivraison`, `prixachatlignebonlivraison`, `prixventelignebonlivraison`, `etatlignebonlivraison`) VALUES
(1, 5, 1, 1, 2, 45000, NULL, 'Valider'),
(2, 5, 2, 2, 5, 200000, NULL, 'Valider');

-- --------------------------------------------------------

--
-- Structure de la table `hp_ligne_bon_livraison_interne`
--

CREATE TABLE `hp_ligne_bon_livraison_interne` (
  `idlignebonlivraisoninterne` int(11) NOT NULL,
  `idunite` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `idbonlivraisoninterne` int(11) NOT NULL,
  `stocklignebonlivraisoninterne` float DEFAULT NULL,
  `prixachatlignebonlivraisoninterne` float DEFAULT NULL,
  `prixventelignebonlivraisoninterne` float DEFAULT NULL,
  `etatlignebonlivraisoninterne` varchar(254) DEFAULT 'En Cours'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_ligne_caisse`
--

CREATE TABLE `hp_ligne_caisse` (
  `idlignecaisse` int(11) NOT NULL,
  `idcaisse` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `idfacture` int(11) NOT NULL,
  `idmodepaiement` int(11) NOT NULL,
  `codelignecaisse` varchar(254) NOT NULL,
  `montantlignecaisse` float NOT NULL,
  `datejourlignecaisse` date DEFAULT NULL,
  `paiementlignecaisse` varchar(254) DEFAULT NULL,
  `datelignecaisse` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_ligne_caisse`
--

INSERT INTO `hp_ligne_caisse` (`idlignecaisse`, `idcaisse`, `idcomptepersonnel`, `idfacture`, `idmodepaiement`, `codelignecaisse`, `montantlignecaisse`, `datejourlignecaisse`, `paiementlignecaisse`, `datelignecaisse`) VALUES
(1, 1, 4, 1, 1, 'FA23012100001', 2000, '2021-01-23', NULL, '2021-01-23 13:19:45'),
(2, 1, 4, 1, 2, 'FA23012100002', 1000, '2021-01-23', NULL, '2021-01-23 13:56:44'),
(3, 1, 4, 3, 1, 'FA25012100001', 3000, '2021-01-25', NULL, '2021-01-25 09:28:03');

-- --------------------------------------------------------

--
-- Structure de la table `hp_ligne_livraison_ordonnance`
--

CREATE TABLE `hp_ligne_livraison_ordonnance` (
  `idlignelivraisonordonnance` int(11) NOT NULL,
  `idboutique` int(11) NOT NULL,
  `idlivraisonordonnance` int(11) NOT NULL,
  `stocklignelivraisonordonnance` float DEFAULT NULL,
  `prixlignelivraisonordonnance` float DEFAULT NULL,
  `etatlignelivraisonordonnance` varchar(254) DEFAULT 'En Cours'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_ligne_ordonnance`
--

CREATE TABLE `hp_ligne_ordonnance` (
  `idligneordonnance` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `idordonnance` int(11) NOT NULL,
  `stockligneordonnance` float DEFAULT NULL,
  `prixligneordonnance` float DEFAULT NULL,
  `etatligneordonnance` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_livraison_ordonnance`
--

CREATE TABLE `hp_livraison_ordonnance` (
  `idlivraisonordonnance` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `idordonnance` int(11) DEFAULT NULL,
  `codelivraisonordonnance` varchar(254) NOT NULL,
  `montantlivraisonordonnance` float DEFAULT NULL,
  `etatlivraisonordonnance` varchar(254) DEFAULT 'En Cours',
  `datelivraisonordonnance` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_magasin`
--

CREATE TABLE `hp_magasin` (
  `idmagasin` int(11) NOT NULL,
  `codemagasin` varchar(254) NOT NULL,
  `nommagasin` varchar(254) NOT NULL,
  `etatmagasin` tinyint(1) DEFAULT '1',
  `datemagasin` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_magasin`
--

INSERT INTO `hp_magasin` (`idmagasin`, `codemagasin`, `nommagasin`, `etatmagasin`, `datemagasin`) VALUES
(1, 'GM', 'Grand Magasin', 1, '2021-01-21 17:46:49');

-- --------------------------------------------------------

--
-- Structure de la table `hp_medecin`
--

CREATE TABLE `hp_medecin` (
  `idmedecin` int(11) NOT NULL,
  `idpersonnel` int(11) NOT NULL,
  `typemedecin` varchar(254) NOT NULL,
  `etatmedecin` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_mode_paiement`
--

CREATE TABLE `hp_mode_paiement` (
  `idmodepaiement` int(11) NOT NULL,
  `codemodepaiement` varchar(254) NOT NULL,
  `libellemodepaiement` varchar(254) NOT NULL,
  `etatmodepaiement` tinyint(1) DEFAULT '1',
  `datemodepaiement` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_mode_paiement`
--

INSERT INTO `hp_mode_paiement` (`idmodepaiement`, `codemodepaiement`, `libellemodepaiement`, `etatmodepaiement`, `datemodepaiement`) VALUES
(1, 'ES', 'EspÃ¨ce', 1, NULL),
(2, 'OM', 'Orange Money', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `hp_ordonnance`
--

CREATE TABLE `hp_ordonnance` (
  `idordonnance` int(11) NOT NULL,
  `idcomptepersonnel` int(11) NOT NULL,
  `codeordonnance` varchar(254) NOT NULL,
  `montantordonnance` float DEFAULT NULL,
  `etatordonnance` varchar(254) DEFAULT 'En Cours',
  `dateordonnance` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_parametre`
--

CREATE TABLE `hp_parametre` (
  `idparametre` int(11) NOT NULL,
  `idunite` int(11) NOT NULL,
  `libelleparametre` varchar(254) NOT NULL,
  `valeurminparametre` float DEFAULT NULL,
  `valeurmaxparametre` float DEFAULT NULL,
  `etatparametre` tinyint(1) DEFAULT '1',
  `dateparametre` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_parametre`
--

INSERT INTO `hp_parametre` (`idparametre`, `idunite`, `libelleparametre`, `valeurminparametre`, `valeurmaxparametre`, `etatparametre`, `dateparametre`) VALUES
(1, 2, 'TempÃ©rature', 36, 38, 1, '2021-01-22 12:43:20'),
(2, 4, 'Taille', 10, 300, 1, '2021-01-23 14:59:01'),
(3, 3, 'Masse', 2.5, 100, 1, '2021-01-23 14:59:47');

-- --------------------------------------------------------

--
-- Structure de la table `hp_parametre_patient`
--

CREATE TABLE `hp_parametre_patient` (
  `idparametrepatient` int(11) NOT NULL,
  `idconsultation` int(11) NOT NULL,
  `idparametre` int(11) NOT NULL,
  `datejourparametrepatient` date DEFAULT NULL,
  `heureparametrepatient` time DEFAULT NULL,
  `valeurparametrepatient` float NOT NULL,
  `dateparametrepatient` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_parametre_patient`
--

INSERT INTO `hp_parametre_patient` (`idparametrepatient`, `idconsultation`, `idparametre`, `datejourparametrepatient`, `heureparametrepatient`, `valeurparametrepatient`, `dateparametrepatient`) VALUES
(1, 1, 3, '2021-01-24', '07:20:00', 85, '2021-01-24 07:20:16'),
(2, 1, 2, '2021-01-24', '07:20:00', 163, '2021-01-24 07:20:16'),
(3, 1, 1, '2021-01-24', '07:20:00', 37.6, '2021-01-24 07:20:16'),
(4, 2, 3, '2021-01-25', '09:37:00', 80, '2021-01-25 09:37:32'),
(5, 2, 2, '2021-01-25', '09:37:00', 164, '2021-01-25 09:37:32'),
(6, 2, 1, '2021-01-25', '09:37:00', 37.8, '2021-01-25 09:37:32');

-- --------------------------------------------------------

--
-- Structure de la table `hp_patient`
--

CREATE TABLE `hp_patient` (
  `idpatient` int(11) NOT NULL,
  `residencepatient` int(11) NOT NULL,
  `codepatient` varchar(254) NOT NULL,
  `nompatient` varchar(254) NOT NULL,
  `prenompatient` varchar(254) DEFAULT NULL,
  `telephonepatient` varchar(254) DEFAULT NULL,
  `telephonepacpatient` varchar(254) NOT NULL,
  `sexepatient` varchar(254) DEFAULT NULL,
  `datenaissancepatient` date DEFAULT NULL,
  `lieunaissancepatient` varchar(254) DEFAULT NULL,
  `situationmatrimonialepatient` varchar(254) DEFAULT NULL,
  `professionpatient` varchar(254) DEFAULT NULL,
  `datepatient` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_patient`
--

INSERT INTO `hp_patient` (`idpatient`, `residencepatient`, `codepatient`, `nompatient`, `prenompatient`, `telephonepatient`, `telephonepacpatient`, `sexepatient`, `datenaissancepatient`, `lieunaissancepatient`, `situationmatrimonialepatient`, `professionpatient`, `datepatient`) VALUES
(1, 1, 'PA21012100001', 'FOTIE', 'odette', '653128980', '697866127', '', '1980-04-25', 'Bandjoun', 'Marier', 'Informaticienne', '2021-01-21 06:32:44'),
(2, 1, 'PA21012100002', 'kountchou', 'pharmaci', '653128956', '697866155', 'Masculin', '1985-10-20', 'Bandjoun', 'Marier', 'Informaticien', '2021-01-21 07:10:47'),
(3, 1, 'PA25012100001', 'GAPIAPSI NGUETO', 'Martial', '674783450', '653128980', 'Masculin', '1989-03-18', 'Bandjoun', 'Marier', 'Ing Informaticien', '2021-01-25 09:22:31');

-- --------------------------------------------------------

--
-- Structure de la table `hp_personnel`
--

CREATE TABLE `hp_personnel` (
  `idpersonnel` int(11) NOT NULL,
  `codepersonnel` varchar(254) NOT NULL,
  `nompersonnel` varchar(254) NOT NULL,
  `prenompersonnel` varchar(254) DEFAULT NULL,
  `telephonepersonnel` varchar(254) DEFAULT NULL,
  `rolepersonnel` varchar(254) NOT NULL,
  `etatpersonnel` tinyint(1) DEFAULT '1',
  `datepersonnel` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_personnel`
--

INSERT INTO `hp_personnel` (`idpersonnel`, `codepersonnel`, `nompersonnel`, `prenompersonnel`, `telephonepersonnel`, `rolepersonnel`, `etatpersonnel`, `datepersonnel`) VALUES
(1, '21AC001', 'ACCUEIL', 'accueil', '', 'Accueil', 1, '2021-01-15 05:18:03'),
(2, '21GE001', 'MEDECIN G', 'medecin g', '', 'MÃ©decin', 1, '2021-01-15 05:25:43'),
(3, '21PH001', 'PHARMACIEN', 'pharmacien', '', 'Pharmacien', 1, '2021-01-15 05:26:15'),
(4, '21PH002', 'MAGASIN', 'magasin', '', 'Magasinier', 1, '2021-01-21 17:58:31'),
(5, '21CA001', 'CAISSE A', 'caisse', '', 'Caisse', 1, '2021-01-22 13:18:32'),
(6, '21CA002', 'CAISSE B', 'caisse', '', 'Caisse', 1, '2021-01-22 13:28:04');

-- --------------------------------------------------------

--
-- Structure de la table `hp_personnel_caisse`
--

CREATE TABLE `hp_personnel_caisse` (
  `idpersonnelcaisse` int(11) NOT NULL,
  `idpersonnel` int(11) NOT NULL,
  `idcaisse` int(11) NOT NULL,
  `etatpersonnelcaisse` tinyint(1) DEFAULT '1',
  `datepersonnelcaisse` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_personnel_caisse`
--

INSERT INTO `hp_personnel_caisse` (`idpersonnelcaisse`, `idpersonnel`, `idcaisse`, `etatpersonnelcaisse`, `datepersonnelcaisse`) VALUES
(1, 5, 1, 1, NULL),
(2, 6, 2, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `hp_personnel_magasin`
--

CREATE TABLE `hp_personnel_magasin` (
  `idpersonnelmagasin` int(11) NOT NULL,
  `idmagasin` int(11) NOT NULL,
  `idpersonnel` int(11) NOT NULL,
  `etatpersonnelmagasin` tinyint(1) DEFAULT '1',
  `datepersonnelmagasin` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_personnel_magasin`
--

INSERT INTO `hp_personnel_magasin` (`idpersonnelmagasin`, `idmagasin`, `idpersonnel`, `etatpersonnelmagasin`, `datepersonnelmagasin`) VALUES
(1, 1, 4, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `hp_personnel_pharmacie`
--

CREATE TABLE `hp_personnel_pharmacie` (
  `idpersonnelpharmacie` int(11) NOT NULL,
  `idpersonnel` int(11) NOT NULL,
  `idpharmacie` int(11) NOT NULL,
  `etatpersonnelpharmacie` tinyint(1) DEFAULT '1',
  `datepersonnelpharmacie` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_personnel_pharmacie`
--

INSERT INTO `hp_personnel_pharmacie` (`idpersonnelpharmacie`, `idpersonnel`, `idpharmacie`, `etatpersonnelpharmacie`, `datepersonnelpharmacie`) VALUES
(1, 3, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `hp_pharmacie`
--

CREATE TABLE `hp_pharmacie` (
  `idpharmacie` int(11) NOT NULL,
  `codepharmacie` varchar(254) NOT NULL,
  `nompharmacie` varchar(254) NOT NULL,
  `etatpharmacie` tinyint(1) DEFAULT '1',
  `datepharmacie` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_pharmacie`
--

INSERT INTO `hp_pharmacie` (`idpharmacie`, `codepharmacie`, `nompharmacie`, `etatpharmacie`, `datepharmacie`) VALUES
(1, 'PHAA', 'Pharmacie A', 1, '2021-01-21 17:56:02');

-- --------------------------------------------------------

--
-- Structure de la table `hp_produit`
--

CREATE TABLE `hp_produit` (
  `idproduit` int(11) NOT NULL,
  `idmagasin` int(11) NOT NULL,
  `idcategorie` int(11) NOT NULL,
  `idvalorisationstock` int(11) NOT NULL,
  `codeproduit` varchar(254) NOT NULL,
  `libelleproduit` varchar(254) NOT NULL,
  `imageproduit` varchar(254) DEFAULT NULL,
  `typeproduit` varchar(254) DEFAULT NULL,
  `stockproduit` float NOT NULL,
  `stockminproduit` float DEFAULT NULL,
  `stockmaxproduit` float DEFAULT NULL,
  `prixachatproduit` float DEFAULT NULL,
  `prixventeproduit` float NOT NULL DEFAULT '0',
  `datefabricationproduit` date DEFAULT NULL,
  `dateperemptionproduit` date DEFAULT NULL,
  `etatproduit` tinyint(1) DEFAULT '1',
  `dateproduit` datetime DEFAULT NULL,
  `uniteachatproduit` int(11) NOT NULL,
  `uniteventeproduit` int(11) DEFAULT NULL,
  `unitesortieproduit` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_produit`
--

INSERT INTO `hp_produit` (`idproduit`, `idmagasin`, `idcategorie`, `idvalorisationstock`, `codeproduit`, `libelleproduit`, `imageproduit`, `typeproduit`, `stockproduit`, `stockminproduit`, `stockmaxproduit`, `prixachatproduit`, `prixventeproduit`, `datefabricationproduit`, `dateperemptionproduit`, `etatproduit`, `dateproduit`, `uniteachatproduit`, `uniteventeproduit`, `unitesortieproduit`) VALUES
(1, 1, 1, 1, 'PARA', 'ParacÃ©tamol', '', NULL, 2, 1, 20, 45000, 50000, NULL, NULL, 1, '2021-01-24 19:10:13', 5, 7, 6),
(2, 1, 1, 1, 'ALBS', 'Albendazol sirop', '', NULL, 5, 1, 50, 200000, 250000, NULL, NULL, 1, '2021-01-25 05:44:41', 5, 6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `hp_produit_avarie`
--

CREATE TABLE `hp_produit_avarie` (
  `idproduitavarie` int(11) NOT NULL,
  `idproduit` int(11) NOT NULL,
  `idcomptepersonnel` int(11) DEFAULT NULL,
  `idpharmacie` int(11) DEFAULT NULL,
  `idmagasin` int(11) DEFAULT NULL,
  `idunite` int(11) NOT NULL,
  `stockproduitavarie` float DEFAULT NULL,
  `prixproduitavarie` float DEFAULT NULL,
  `dateproduitavarie` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_proprietaire`
--

CREATE TABLE `hp_proprietaire` (
  `idproprietaire` int(11) NOT NULL,
  `iddepartement` int(11) NOT NULL,
  `nomproprietaire` varchar(254) NOT NULL,
  `telephoneproprietaire` varchar(254) NOT NULL,
  `emailproprietaire` varchar(254) DEFAULT NULL,
  `siteproprietaire` varchar(254) DEFAULT NULL,
  `bpproprietaire` varchar(254) DEFAULT NULL,
  `loginproprietaire` varchar(254) NOT NULL,
  `motdepasseproprietaire` varchar(254) NOT NULL,
  `hopitalproprietaire` varchar(254) NOT NULL,
  `logoproprietaire` varchar(254) DEFAULT NULL,
  `datecreationproprietaire` date DEFAULT NULL,
  `typeproprietaire` varchar(254) DEFAULT NULL,
  `sloganproprietaire` varchar(254) DEFAULT NULL,
  `nocontribuableproprietaire` varchar(254) DEFAULT NULL,
  `etatproprietaire` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_proprietaire`
--

INSERT INTO `hp_proprietaire` (`idproprietaire`, `iddepartement`, `nomproprietaire`, `telephoneproprietaire`, `emailproprietaire`, `siteproprietaire`, `bpproprietaire`, `loginproprietaire`, `motdepasseproprietaire`, `hopitalproprietaire`, `logoproprietaire`, `datecreationproprietaire`, `typeproprietaire`, `sloganproprietaire`, `nocontribuableproprietaire`, `etatproprietaire`) VALUES
(1, 1, 'Fongang Talla Eric', '674783450', 'info@universbinaire.com', 'www.universbinaire.com', '1234', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'PROSANTE', 'logo.png', '2018-06-25', 'privÃ©e', '', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `hp_region`
--

CREATE TABLE `hp_region` (
  `idregion` int(11) NOT NULL,
  `coderegion` varchar(254) NOT NULL,
  `libelleregion` varchar(254) NOT NULL,
  `cheflieuregion` varchar(254) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_region`
--

INSERT INTO `hp_region` (`idregion`, `coderegion`, `libelleregion`, `cheflieuregion`) VALUES
(1, 'CE', 'Centre', 'YaoundÃ©'),
(2, 'LT', 'Litoral', 'Douala');

-- --------------------------------------------------------

--
-- Structure de la table `hp_resultat_examen`
--

CREATE TABLE `hp_resultat_examen` (
  `idresultatexamen` int(11) NOT NULL,
  `idlaboratoire` int(11) NOT NULL,
  `idexamenpatient` int(11) NOT NULL,
  `conteneurresultatexamen` varchar(254) NOT NULL,
  `interpretationresultatexamen` text,
  `conclusionresultatexamen` text,
  `dateresultatexamen` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hp_service`
--

CREATE TABLE `hp_service` (
  `idservice` int(11) NOT NULL,
  `codeservice` varchar(254) NOT NULL,
  `nomservice` varchar(254) DEFAULT NULL,
  `telephoneservice` varchar(254) DEFAULT NULL,
  `domaineservice` varchar(254) DEFAULT NULL,
  `localservice` tinyint(1) NOT NULL DEFAULT '1',
  `etatservice` tinyint(1) DEFAULT '1',
  `dateservice` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_service`
--

INSERT INTO `hp_service` (`idservice`, `codeservice`, `nomservice`, `telephoneservice`, `domaineservice`, `localservice`, `etatservice`, `dateservice`) VALUES
(1, 'PHAR', 'Pharmacie', '653128980', 'Vente Des Medicaments', 1, 1, NULL),
(2, 'ACC', 'Accueil', '653128980', 'Accueil Des Patients', 0, 1, NULL),
(3, 'GEN', 'GÃ©nÃ©raliste', '', 'Consultation GÃ©nÃ©rale Des Patients', 1, 1, NULL),
(4, 'LAB', 'Laboratoire', '', 'Analyse Des Examens', 1, 1, NULL),
(5, 'CAIS', 'Caisse', '697866127', 'Encaisse Les Paiements Des Patients', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `hp_sous_dossier`
--

CREATE TABLE `hp_sous_dossier` (
  `idsousdossier` int(11) NOT NULL,
  `iddossier` int(11) NOT NULL,
  `codesousdossier` varchar(254) NOT NULL,
  `etatsousdossier` tinyint(1) DEFAULT '1',
  `datesousdossier` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_sous_dossier`
--

INSERT INTO `hp_sous_dossier` (`idsousdossier`, `iddossier`, `codesousdossier`, `etatsousdossier`, `datesousdossier`) VALUES
(1, 1, 'DOCS21012100001', 1, '2021-01-21 06:32:44'),
(2, 2, 'DOCS21012100002', 1, '2021-01-21 07:10:47'),
(3, 3, 'DOCS25012100001', 1, '2021-01-25 09:22:31');

-- --------------------------------------------------------

--
-- Structure de la table `hp_trace`
--

CREATE TABLE `hp_trace` (
  `idtrace` int(11) NOT NULL,
  `idexamen` int(11) DEFAULT NULL,
  `idcomptepersonnel` int(11) DEFAULT NULL,
  `idgrilleprix` int(11) DEFAULT NULL,
  `idpatient` int(11) DEFAULT NULL,
  `idproduit` int(11) DEFAULT NULL,
  `but` varchar(254) DEFAULT NULL,
  `operation` varchar(254) DEFAULT NULL,
  `objet` varchar(254) DEFAULT NULL,
  `etattrace` tinyint(1) DEFAULT '1',
  `datetrace` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_trace`
--

INSERT INTO `hp_trace` (`idtrace`, `idexamen`, `idcomptepersonnel`, `idgrilleprix`, `idpatient`, `idproduit`, `but`, `operation`, `objet`, `etattrace`, `datetrace`) VALUES
(1, NULL, 1, NULL, 1, NULL, NULL, 'Enregistrement', 'Consultation 3000', 1, '2021-01-21 06:32:44'),
(2, NULL, 1, NULL, 2, NULL, NULL, 'Enregistrement', 'Examen 4000', 1, '2021-01-21 07:10:47'),
(3, NULL, 4, NULL, 1, NULL, NULL, 'Ajout', 'Facture : FA23012100001 -> 2000', 1, '2021-01-23 13:19:45'),
(4, NULL, 4, NULL, 1, NULL, NULL, 'Ajout', 'Facture : FA23012100002 -> 1000', 1, '2021-01-23 13:56:44'),
(5, NULL, 2, NULL, NULL, 1, NULL, 'Ajout', 'PARA->2->45000', 1, '2021-01-24 19:10:13'),
(6, NULL, 2, NULL, NULL, 2, NULL, 'Ajout', 'ALBS->5->200000', 1, '2021-01-25 05:44:41'),
(7, NULL, 2, NULL, NULL, 1, NULL, 'Commande Externe', '8-ParacÃ©tamol', 1, '2021-01-25 08:06:10'),
(8, NULL, 2, NULL, NULL, 2, NULL, 'Commande Externe', '3-Albendazol sirop', 1, '2021-01-25 08:06:10'),
(9, NULL, 1, NULL, 3, NULL, NULL, 'Enregistrement', 'Consultation 3000', 1, '2021-01-25 09:22:32'),
(10, NULL, 4, NULL, 3, NULL, NULL, 'Ajout', 'Facture : FA25012100001 -> 3000', 1, '2021-01-25 09:28:03');

-- --------------------------------------------------------

--
-- Structure de la table `hp_unite`
--

CREATE TABLE `hp_unite` (
  `idunite` int(11) NOT NULL,
  `codeunite` varchar(254) NOT NULL,
  `libelleunite` varchar(254) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_unite`
--

INSERT INTO `hp_unite` (`idunite`, `codeunite`, `libelleunite`) VALUES
(1, 'ml', 'Mililitre'),
(2, 'Â°C', 'DÃ©grÃ© Celcus'),
(3, 'Kg', 'kilogramme'),
(4, 'Cm', 'centimetre'),
(5, 'C', 'carton'),
(6, 'Bte', 'boite'),
(7, 'pce', 'piÃ¨ce');

-- --------------------------------------------------------

--
-- Structure de la table `hp_valorisation_stock`
--

CREATE TABLE `hp_valorisation_stock` (
  `idvalorisationstock` int(11) NOT NULL,
  `codevalorisationstock` varchar(254) NOT NULL,
  `libellevalorisationstock` varchar(254) NOT NULL,
  `etatvalorisationstock` tinyint(1) DEFAULT '1',
  `datevalorisationstock` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `hp_valorisation_stock`
--

INSERT INTO `hp_valorisation_stock` (`idvalorisationstock`, `codevalorisationstock`, `libellevalorisationstock`, `etatvalorisationstock`, `datevalorisationstock`) VALUES
(1, 'CUMPFE', 'CoÃ»t Unitaire Moyen PondÃ©rÃ© Fin EntrÃ©e', 1, '2021-01-24 14:53:08');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `hp_affectation`
--
ALTER TABLE `hp_affectation`
  ADD PRIMARY KEY (`idaffectation`),
  ADD KEY `fk_perso_affecta` (`idpersonnel`),
  ADD KEY `fk_service_affecta` (`idservice`);

--
-- Index pour la table `hp_bon_commande`
--
ALTER TABLE `hp_bon_commande`
  ADD PRIMARY KEY (`idboncommande`),
  ADD UNIQUE KEY `codeboncommande` (`codeboncommande`),
  ADD KEY `fk_mag_com` (`idmagasin`),
  ADD KEY `fk_perso_com` (`idcomptepersonnel`);

--
-- Index pour la table `hp_bon_commande_interne`
--
ALTER TABLE `hp_bon_commande_interne`
  ADD PRIMARY KEY (`idboncommandeinterne`),
  ADD UNIQUE KEY `codeboncommandeinterne` (`codeboncommandeinterne`),
  ADD KEY `fk_peros_com_int` (`idcomptepersonnel`),
  ADD KEY `fk_phar_com_int` (`idpharmacie`);

--
-- Index pour la table `hp_bon_livraison`
--
ALTER TABLE `hp_bon_livraison`
  ADD PRIMARY KEY (`idbonlivraison`),
  ADD UNIQUE KEY `codebonlivraison` (`codebonlivraison`),
  ADD KEY `fk_com_liv` (`idboncommande`),
  ADD KEY `fk_four_liv` (`idfournisseur`),
  ADD KEY `fk_mag_liv` (`idmagasin`),
  ADD KEY `fk_perso_liv` (`idcomptepersonnel`);

--
-- Index pour la table `hp_bon_livraison_interne`
--
ALTER TABLE `hp_bon_livraison_interne`
  ADD PRIMARY KEY (`idbonlivraisoninterne`),
  ADD UNIQUE KEY `codebonlivraisoninterne` (`codebonlivraisoninterne`),
  ADD KEY `fk_liv_com_int` (`idboncommandeinterne`),
  ADD KEY `fk_mag_liv_int` (`idmagasin`),
  ADD KEY `fk_perso_liv_int` (`idcomptepersonnel`),
  ADD KEY `fk_perso_liv_int_recep` (`idcomptepersonnelrecep`),
  ADD KEY `fk_phar_liv_int` (`idpharmacie`);

--
-- Index pour la table `hp_boutique`
--
ALTER TABLE `hp_boutique`
  ADD PRIMARY KEY (`idboutique`),
  ADD KEY `fk_prod_pharpa` (`idpharmacie`),
  ADD KEY `fk_prod_pharpr` (`idproduit`);

--
-- Index pour la table `hp_caisse`
--
ALTER TABLE `hp_caisse`
  ADD PRIMARY KEY (`idcaisse`),
  ADD UNIQUE KEY `nomcaisse` (`nomcaisse`);

--
-- Index pour la table `hp_categorie`
--
ALTER TABLE `hp_categorie`
  ADD PRIMARY KEY (`idcategorie`),
  ADD UNIQUE KEY `codecategorie` (`codecategorie`);

--
-- Index pour la table `hp_compte_personnel`
--
ALTER TABLE `hp_compte_personnel`
  ADD PRIMARY KEY (`idcomptepersonnel`),
  ADD KEY `fk_compte_perso` (`idpersonnel`);

--
-- Index pour la table `hp_consultation`
--
ALTER TABLE `hp_consultation`
  ADD PRIMARY KEY (`idconsultation`),
  ADD UNIQUE KEY `codeconsultation` (`codeconsultation`),
  ADD KEY `fk_doc_consult` (`idsousdossier`),
  ADD KEY `fk_personnel_consult` (`idcomptepersonnel`),
  ADD KEY `fk_prix_consult` (`idgrilleprix`);

--
-- Index pour la table `hp_conversion`
--
ALTER TABLE `hp_conversion`
  ADD PRIMARY KEY (`idconversion`),
  ADD KEY `fk_prod_conv` (`idproduit`),
  ADD KEY `fk_unite_conv` (`idunite`);

--
-- Index pour la table `hp_departement`
--
ALTER TABLE `hp_departement`
  ADD PRIMARY KEY (`iddepartement`),
  ADD KEY `fk_reg_dep` (`idregion`);

--
-- Index pour la table `hp_dossier`
--
ALTER TABLE `hp_dossier`
  ADD PRIMARY KEY (`iddossier`),
  ADD UNIQUE KEY `codedossier` (`codedossier`),
  ADD KEY `fk_dossierpatient` (`idpatient`),
  ADD KEY `fk_perso_doc` (`idcomptepersonnel`);

--
-- Index pour la table `hp_examen`
--
ALTER TABLE `hp_examen`
  ADD PRIMARY KEY (`idexamen`),
  ADD UNIQUE KEY `codeexamen` (`codeexamen`),
  ADD KEY `fk_unite_examen` (`idunite`);

--
-- Index pour la table `hp_examen_patient`
--
ALTER TABLE `hp_examen_patient`
  ADD PRIMARY KEY (`idexamenpatient`),
  ADD UNIQUE KEY `codeexamenpatient` (`codeexamenpatient`),
  ADD KEY `fk_exam_consult` (`idconsultation`),
  ADD KEY `fk_examdoc` (`idsousdossier`),
  ADD KEY `fk_exampat` (`idexamen`),
  ADD KEY `fk_perso_exam` (`idcomptepersonnel`);

--
-- Index pour la table `hp_facture`
--
ALTER TABLE `hp_facture`
  ADD PRIMARY KEY (`idfacture`),
  ADD UNIQUE KEY `codefacture` (`codefacture`),
  ADD KEY `fk_examfacture` (`idexamenpatient`),
  ADD KEY `fk_fact_consult` (`idconsultation`),
  ADD KEY `fk_fact_ordon` (`idordonnance`),
  ADD KEY `fk_perso_facture` (`idcomptepersonnel`);

--
-- Index pour la table `hp_fournisseur`
--
ALTER TABLE `hp_fournisseur`
  ADD PRIMARY KEY (`idfournisseur`),
  ADD UNIQUE KEY `nomfournisseur` (`nomfournisseur`);

--
-- Index pour la table `hp_grille_prix`
--
ALTER TABLE `hp_grille_prix`
  ADD PRIMARY KEY (`idgrilleprix`),
  ADD UNIQUE KEY `designationgrilleprix` (`designationgrilleprix`),
  ADD KEY `fk_cat_prix` (`categoriegrilleprix`);

--
-- Index pour la table `hp_laboratoire`
--
ALTER TABLE `hp_laboratoire`
  ADD PRIMARY KEY (`idlaboratoire`),
  ADD UNIQUE KEY `codelaboratoire` (`codelaboratoire`),
  ADD KEY `fk_serv_labo` (`idservice`);

--
-- Index pour la table `hp_ligne_bon_commande`
--
ALTER TABLE `hp_ligne_bon_commande`
  ADD PRIMARY KEY (`idligneboncommande`),
  ADD KEY `fk_prod_comc` (`idboncommande`),
  ADD KEY `fk_prod_comp` (`idproduit`),
  ADD KEY `fk_unite_com` (`idunite`);

--
-- Index pour la table `hp_ligne_bon_commande_interne`
--
ALTER TABLE `hp_ligne_bon_commande_interne`
  ADD PRIMARY KEY (`idligneboncommandeinterne`),
  ADD KEY `fk_prod_com_intc` (`idboncommandeinterne`),
  ADD KEY `fk_prod_com_intp` (`idproduit`),
  ADD KEY `fk_unite_com_int` (`idunite`);

--
-- Index pour la table `hp_ligne_bon_livraison`
--
ALTER TABLE `hp_ligne_bon_livraison`
  ADD PRIMARY KEY (`idlignebonlivraison`),
  ADD KEY `fk_prod_livl` (`idbonlivraison`),
  ADD KEY `fk_prod_livp` (`idproduit`),
  ADD KEY `fk_unite_liv` (`idunite`);

--
-- Index pour la table `hp_ligne_bon_livraison_interne`
--
ALTER TABLE `hp_ligne_bon_livraison_interne`
  ADD PRIMARY KEY (`idlignebonlivraisoninterne`),
  ADD KEY `fk_prod_liv_intl` (`idbonlivraisoninterne`),
  ADD KEY `fk_prod_liv_intp` (`idproduit`),
  ADD KEY `fk_unite_liv_int` (`idunite`);

--
-- Index pour la table `hp_ligne_caisse`
--
ALTER TABLE `hp_ligne_caisse`
  ADD PRIMARY KEY (`idlignecaisse`),
  ADD UNIQUE KEY `codelignecaisse` (`codelignecaisse`),
  ADD KEY `fk_ligncaisfact` (`idfacture`),
  ADD KEY `fk_ligne_cais` (`idcaisse`),
  ADD KEY `fk_perso_caisse` (`idcomptepersonnel`),
  ADD KEY `fk_fact_mp` (`idmodepaiement`);

--
-- Index pour la table `hp_ligne_livraison_ordonnance`
--
ALTER TABLE `hp_ligne_livraison_ordonnance`
  ADD PRIMARY KEY (`idlignelivraisonordonnance`),
  ADD KEY `fk_bout_liv_ordonb` (`idboutique`),
  ADD KEY `fk_bout_liv_ordono` (`idlivraisonordonnance`);

--
-- Index pour la table `hp_ligne_ordonnance`
--
ALTER TABLE `hp_ligne_ordonnance`
  ADD PRIMARY KEY (`idligneordonnance`),
  ADD KEY `fk_prod_ordono` (`idordonnance`),
  ADD KEY `fk_prod_ordonp` (`idproduit`);

--
-- Index pour la table `hp_livraison_ordonnance`
--
ALTER TABLE `hp_livraison_ordonnance`
  ADD PRIMARY KEY (`idlivraisonordonnance`),
  ADD UNIQUE KEY `codelivraisonordonnance` (`codelivraisonordonnance`),
  ADD KEY `fk_ordon_liv` (`idordonnance`),
  ADD KEY `fk_perso_liv_ordon` (`idcomptepersonnel`);

--
-- Index pour la table `hp_magasin`
--
ALTER TABLE `hp_magasin`
  ADD PRIMARY KEY (`idmagasin`),
  ADD UNIQUE KEY `codemagasin` (`codemagasin`);

--
-- Index pour la table `hp_medecin`
--
ALTER TABLE `hp_medecin`
  ADD PRIMARY KEY (`idmedecin`),
  ADD KEY `fk_perso_medecin` (`idpersonnel`);

--
-- Index pour la table `hp_mode_paiement`
--
ALTER TABLE `hp_mode_paiement`
  ADD PRIMARY KEY (`idmodepaiement`),
  ADD UNIQUE KEY `codemodepaiement` (`codemodepaiement`);

--
-- Index pour la table `hp_ordonnance`
--
ALTER TABLE `hp_ordonnance`
  ADD PRIMARY KEY (`idordonnance`),
  ADD UNIQUE KEY `codeparmacie` (`codeordonnance`),
  ADD KEY `fk_perso_ordon` (`idcomptepersonnel`);

--
-- Index pour la table `hp_parametre`
--
ALTER TABLE `hp_parametre`
  ADD PRIMARY KEY (`idparametre`),
  ADD UNIQUE KEY `libelleparametre` (`libelleparametre`),
  ADD KEY `fk_unite_param` (`idunite`);

--
-- Index pour la table `hp_parametre_patient`
--
ALTER TABLE `hp_parametre_patient`
  ADD PRIMARY KEY (`idparametrepatient`),
  ADD KEY `fk_param_pat` (`idparametre`),
  ADD KEY `fk_patient_par` (`idconsultation`);

--
-- Index pour la table `hp_patient`
--
ALTER TABLE `hp_patient`
  ADD PRIMARY KEY (`idpatient`),
  ADD UNIQUE KEY `codepatient` (`codepatient`),
  ADD KEY `fk_residence_patient` (`residencepatient`);

--
-- Index pour la table `hp_personnel`
--
ALTER TABLE `hp_personnel`
  ADD PRIMARY KEY (`idpersonnel`),
  ADD UNIQUE KEY `codepersonnel` (`codepersonnel`);

--
-- Index pour la table `hp_personnel_caisse`
--
ALTER TABLE `hp_personnel_caisse`
  ADD PRIMARY KEY (`idpersonnelcaisse`),
  ADD KEY `fk_caisse_perso` (`idcaisse`),
  ADD KEY `fk_perso_caisse` (`idpersonnel`);

--
-- Index pour la table `hp_personnel_magasin`
--
ALTER TABLE `hp_personnel_magasin`
  ADD PRIMARY KEY (`idpersonnelmagasin`),
  ADD KEY `fk_mag_perso` (`idmagasin`),
  ADD KEY `fk_perso_mag` (`idpersonnel`);

--
-- Index pour la table `hp_personnel_pharmacie`
--
ALTER TABLE `hp_personnel_pharmacie`
  ADD PRIMARY KEY (`idpersonnelpharmacie`),
  ADD KEY `fk_perso_phar` (`idpersonnel`),
  ADD KEY `fk_phar_perso` (`idpharmacie`);

--
-- Index pour la table `hp_pharmacie`
--
ALTER TABLE `hp_pharmacie`
  ADD PRIMARY KEY (`idpharmacie`),
  ADD UNIQUE KEY `codepharmacie` (`codepharmacie`);

--
-- Index pour la table `hp_produit`
--
ALTER TABLE `hp_produit`
  ADD PRIMARY KEY (`idproduit`),
  ADD UNIQUE KEY `codeproduit` (`codeproduit`),
  ADD KEY `fk_cat_prod` (`idcategorie`),
  ADD KEY `fk_prod_mag` (`idmagasin`),
  ADD KEY `fk_uniteacahtproduit` (`uniteachatproduit`),
  ADD KEY `fk_uniteventeproduit` (`uniteventeproduit`),
  ADD KEY `fk_unite_prod_sortie` (`unitesortieproduit`),
  ADD KEY `fk_prod_val_stock` (`idvalorisationstock`);

--
-- Index pour la table `hp_produit_avarie`
--
ALTER TABLE `hp_produit_avarie`
  ADD PRIMARY KEY (`idproduitavarie`),
  ADD KEY `fk_mag_avarie` (`idmagasin`),
  ADD KEY `fk_perso_prod_avarie` (`idcomptepersonnel`),
  ADD KEY `fk_phar_avarie` (`idpharmacie`),
  ADD KEY `fk_prod_avarie` (`idproduit`),
  ADD KEY `fk_unite_avarie` (`idunite`);

--
-- Index pour la table `hp_proprietaire`
--
ALTER TABLE `hp_proprietaire`
  ADD PRIMARY KEY (`idproprietaire`),
  ADD UNIQUE KEY `nomproprietaire` (`nomproprietaire`),
  ADD KEY `fk_dep_prop` (`iddepartement`);

--
-- Index pour la table `hp_region`
--
ALTER TABLE `hp_region`
  ADD PRIMARY KEY (`idregion`),
  ADD UNIQUE KEY `coderegion` (`coderegion`);

--
-- Index pour la table `hp_resultat_examen`
--
ALTER TABLE `hp_resultat_examen`
  ADD PRIMARY KEY (`idresultatexamen`),
  ADD KEY `fk_labo_exam` (`idlaboratoire`),
  ADD KEY `fk_result_exam` (`idexamenpatient`);

--
-- Index pour la table `hp_service`
--
ALTER TABLE `hp_service`
  ADD PRIMARY KEY (`idservice`),
  ADD UNIQUE KEY `codeservice` (`codeservice`);

--
-- Index pour la table `hp_sous_dossier`
--
ALTER TABLE `hp_sous_dossier`
  ADD PRIMARY KEY (`idsousdossier`),
  ADD UNIQUE KEY `codesousdossier` (`codesousdossier`),
  ADD KEY `fk_sous_dossier` (`iddossier`);

--
-- Index pour la table `hp_trace`
--
ALTER TABLE `hp_trace`
  ADD PRIMARY KEY (`idtrace`),
  ADD KEY `fk_traceexamen` (`idexamen`),
  ADD KEY `fk_tracegrilleprix` (`idgrilleprix`),
  ADD KEY `fk_tracepatient` (`idpatient`),
  ADD KEY `fk_tracepersonnel` (`idcomptepersonnel`);

--
-- Index pour la table `hp_unite`
--
ALTER TABLE `hp_unite`
  ADD PRIMARY KEY (`idunite`),
  ADD UNIQUE KEY `codeunite` (`codeunite`);

--
-- Index pour la table `hp_valorisation_stock`
--
ALTER TABLE `hp_valorisation_stock`
  ADD PRIMARY KEY (`idvalorisationstock`),
  ADD UNIQUE KEY `codevalorisationstock` (`codevalorisationstock`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `hp_affectation`
--
ALTER TABLE `hp_affectation`
  MODIFY `idaffectation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `hp_bon_commande`
--
ALTER TABLE `hp_bon_commande`
  MODIFY `idboncommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `hp_bon_commande_interne`
--
ALTER TABLE `hp_bon_commande_interne`
  MODIFY `idboncommandeinterne` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_bon_livraison`
--
ALTER TABLE `hp_bon_livraison`
  MODIFY `idbonlivraison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `hp_bon_livraison_interne`
--
ALTER TABLE `hp_bon_livraison_interne`
  MODIFY `idbonlivraisoninterne` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_boutique`
--
ALTER TABLE `hp_boutique`
  MODIFY `idboutique` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_caisse`
--
ALTER TABLE `hp_caisse`
  MODIFY `idcaisse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `hp_categorie`
--
ALTER TABLE `hp_categorie`
  MODIFY `idcategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `hp_compte_personnel`
--
ALTER TABLE `hp_compte_personnel`
  MODIFY `idcomptepersonnel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `hp_consultation`
--
ALTER TABLE `hp_consultation`
  MODIFY `idconsultation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `hp_conversion`
--
ALTER TABLE `hp_conversion`
  MODIFY `idconversion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `hp_departement`
--
ALTER TABLE `hp_departement`
  MODIFY `iddepartement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `hp_dossier`
--
ALTER TABLE `hp_dossier`
  MODIFY `iddossier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `hp_examen`
--
ALTER TABLE `hp_examen`
  MODIFY `idexamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `hp_examen_patient`
--
ALTER TABLE `hp_examen_patient`
  MODIFY `idexamenpatient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `hp_facture`
--
ALTER TABLE `hp_facture`
  MODIFY `idfacture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `hp_fournisseur`
--
ALTER TABLE `hp_fournisseur`
  MODIFY `idfournisseur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `hp_grille_prix`
--
ALTER TABLE `hp_grille_prix`
  MODIFY `idgrilleprix` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `hp_laboratoire`
--
ALTER TABLE `hp_laboratoire`
  MODIFY `idlaboratoire` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_ligne_bon_commande`
--
ALTER TABLE `hp_ligne_bon_commande`
  MODIFY `idligneboncommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `hp_ligne_bon_commande_interne`
--
ALTER TABLE `hp_ligne_bon_commande_interne`
  MODIFY `idligneboncommandeinterne` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_ligne_bon_livraison`
--
ALTER TABLE `hp_ligne_bon_livraison`
  MODIFY `idlignebonlivraison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `hp_ligne_bon_livraison_interne`
--
ALTER TABLE `hp_ligne_bon_livraison_interne`
  MODIFY `idlignebonlivraisoninterne` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_ligne_caisse`
--
ALTER TABLE `hp_ligne_caisse`
  MODIFY `idlignecaisse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `hp_ligne_livraison_ordonnance`
--
ALTER TABLE `hp_ligne_livraison_ordonnance`
  MODIFY `idlignelivraisonordonnance` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_ligne_ordonnance`
--
ALTER TABLE `hp_ligne_ordonnance`
  MODIFY `idligneordonnance` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_livraison_ordonnance`
--
ALTER TABLE `hp_livraison_ordonnance`
  MODIFY `idlivraisonordonnance` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_magasin`
--
ALTER TABLE `hp_magasin`
  MODIFY `idmagasin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `hp_medecin`
--
ALTER TABLE `hp_medecin`
  MODIFY `idmedecin` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_mode_paiement`
--
ALTER TABLE `hp_mode_paiement`
  MODIFY `idmodepaiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `hp_ordonnance`
--
ALTER TABLE `hp_ordonnance`
  MODIFY `idordonnance` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_parametre`
--
ALTER TABLE `hp_parametre`
  MODIFY `idparametre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `hp_parametre_patient`
--
ALTER TABLE `hp_parametre_patient`
  MODIFY `idparametrepatient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `hp_patient`
--
ALTER TABLE `hp_patient`
  MODIFY `idpatient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `hp_personnel`
--
ALTER TABLE `hp_personnel`
  MODIFY `idpersonnel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `hp_personnel_caisse`
--
ALTER TABLE `hp_personnel_caisse`
  MODIFY `idpersonnelcaisse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `hp_personnel_magasin`
--
ALTER TABLE `hp_personnel_magasin`
  MODIFY `idpersonnelmagasin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `hp_personnel_pharmacie`
--
ALTER TABLE `hp_personnel_pharmacie`
  MODIFY `idpersonnelpharmacie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `hp_pharmacie`
--
ALTER TABLE `hp_pharmacie`
  MODIFY `idpharmacie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `hp_produit`
--
ALTER TABLE `hp_produit`
  MODIFY `idproduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `hp_produit_avarie`
--
ALTER TABLE `hp_produit_avarie`
  MODIFY `idproduitavarie` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_proprietaire`
--
ALTER TABLE `hp_proprietaire`
  MODIFY `idproprietaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `hp_region`
--
ALTER TABLE `hp_region`
  MODIFY `idregion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `hp_resultat_examen`
--
ALTER TABLE `hp_resultat_examen`
  MODIFY `idresultatexamen` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `hp_service`
--
ALTER TABLE `hp_service`
  MODIFY `idservice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `hp_sous_dossier`
--
ALTER TABLE `hp_sous_dossier`
  MODIFY `idsousdossier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `hp_trace`
--
ALTER TABLE `hp_trace`
  MODIFY `idtrace` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `hp_unite`
--
ALTER TABLE `hp_unite`
  MODIFY `idunite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `hp_valorisation_stock`
--
ALTER TABLE `hp_valorisation_stock`
  MODIFY `idvalorisationstock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
