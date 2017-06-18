-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Dim 26 Mars 2017 à 01:03
-- Version du serveur :  5.6.35
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `circhain`
--

-- --------------------------------------------------------

--
-- Structure de la table `Acteurs`
--

CREATE TABLE `Acteurs` (
  `id` int(11) NOT NULL,
  `id_acteur` varchar(255) NOT NULL,
  `nom_acteur` varchar(255) DEFAULT NULL,
  `prenom_acteur` varchar(255) DEFAULT NULL,
  `email_acteur` varchar(255) DEFAULT NULL,
  `adresse_acteur` varchar(255) DEFAULT NULL,
  `tel_acteur` varchar(255) DEFAULT NULL,
  `profil` varchar(50) DEFAULT NULL,
  `homologation` varchar(255) DEFAULT NULL,
  `timestamp` varchar(70) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Acteurs`
--

INSERT INTO `Acteurs` (`id`, `id_acteur`, `nom_acteur`, `prenom_acteur`, `email_acteur`, `adresse_acteur`, `tel_acteur`, `profil`, `homologation`, `timestamp`, `mdp`) VALUES
(1, 'CIRLY', 'Frachon', 'Maxime', 'frachon@cirly.com', 'Brignais', '0472715955', 'administrateur', 'A,B,C,D', '1490484667', '6d1b74393fb219ad5380838006a9a1d46d256e75'),
(2, 'ALSTOM', 'Adam', 'Mark', 'mark.adam@alstom.com', 'Paris', '0406890045', 'client', '', '1490484667', '629495600e3c30ab9dd16dd13e4c31bba1e7da0c'),
(3, 'AREVA', 'Frank', 'Taylor', 'frank.taylor@areva.com', 'Valence', '476888045', 'client', '', '1490484667', '9e3a3d3fe136affa24bfe3137c044e067262f09e'),
(4, 'CTS', 'Pamerlo', 'Jean', 'jean.pamerlo@cts.com', 'CTS industries', '0376888045', 'cableur', 'A,B,C,D', '1490484667', '70460c6ba8049d797b3b0f2922dcca0387f2d258'),
(5, 'BSE', 'Loic', 'Ribalt', 'loic.ribalt@bse.com', 'Lille', '0376888045', 'cableur', 'A,B,C', '1490484667', 'cd7705dd26a434f0822911169275f3a001728a32'),
(6, 'EOLANE', 'Moreau', 'Hugues', 'hugues.moreau@eolane.com', 'Ecully', '0376888045', 'cableur', 'A,B', '1490484667', '62e4e012916d77de2c2c47276437e51389c8e82c'),
(7, 'ASTEEL', 'Hachim', 'khalid', 'khalid.hachim@asteel.com', 'Asteel Flash', '0376888045', 'cableur', 'A', '1490484667', '7a538e91ab9a610357164efb65eee698bde6e7c9'),
(8, 'CABLEUR', 'NS', 'Paola', 'paola.ns@cableur.com', 'Paris', '0376888045', 'cableur', '', '1490484720', 'ccdb090a250b8462fb22b2a6714ad1f892607c10');

-- --------------------------------------------------------

--
-- Structure de la table `Acteurs_Cartes`
--

CREATE TABLE `Acteurs_Cartes` (
  `id` int(11) NOT NULL,
  `id_proprietaire_actu` varchar(70) DEFAULT NULL,
  `id_proprietaire_prec` varchar(70) DEFAULT NULL,
  `id_carte` varchar(70) DEFAULT NULL,
  `date_emis` datetime DEFAULT NULL,
  `date_recu` datetime DEFAULT NULL,
  `timestamp` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Acteurs_Cartes`
--

INSERT INTO `Acteurs_Cartes` (`id`, `id_proprietaire_actu`, `id_proprietaire_prec`, `id_carte`, `date_emis`, `date_recu`, `timestamp`) VALUES
(1, 'CIRLY', 'CIRLY', 'carte1', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499'),
(2, 'CIRLY', 'CIRLY', 'carte2', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499'),
(3, 'CIRLY', 'CIRLY', 'carte3', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499'),
(4, 'CIRLY', 'CIRLY', 'carte4', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499'),
(5, 'CIRLY', 'CIRLY', 'carte5', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499'),
(6, 'CIRLY', 'CIRLY', 'carte6', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499'),
(7, 'CIRLY', 'CIRLY', 'carte7', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499'),
(8, 'CIRLY', 'CIRLY', 'carte8', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499'),
(9, 'CIRLY', 'CIRLY', 'carte9', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499'),
(10, 'CIRLY', 'CIRLY', 'carte10', '2017-03-26 00:44:59', '2017-03-26 00:44:59', '1490485499');

-- --------------------------------------------------------

--
-- Structure de la table `Cartes`
--

CREATE TABLE `Cartes` (
  `id` int(11) NOT NULL,
  `id_carte` varchar(255) DEFAULT NULL,
  `proprietaire_actu` varchar(255) DEFAULT NULL,
  `proprietaire_final` varchar(50) NOT NULL,
  `etat_carte` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `certification` varchar(255) DEFAULT NULL,
  `timestamp` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Cartes`
--

INSERT INTO `Cartes` (`id`, `id_carte`, `proprietaire_actu`, `proprietaire_final`, `etat_carte`, `date_creation`, `certification`, `timestamp`) VALUES
(1, 'carte1', 'CIRLY', 'AREVA', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499'),
(2, 'carte2', 'CIRLY', 'AREVA', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499'),
(3, 'carte3', 'CIRLY', 'ALSTOM', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499'),
(4, 'carte4', 'CIRLY', 'AREVA', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499'),
(5, 'carte5', 'CIRLY', 'ALSTOM', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499'),
(6, 'carte6', 'CIRLY', 'AREVA', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499'),
(7, 'carte7', 'CIRLY', 'ALSTOM', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499'),
(8, 'carte8', 'CIRLY', 'ALSTOM', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499'),
(9, 'carte9', 'CIRLY', 'AREVA', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499'),
(10, 'carte10', 'CIRLY', 'ALSTOM', 'reçue', '2017-03-26 00:44:59', 'A,B,C,D', '1490485499');

-- --------------------------------------------------------

--
-- Structure de la table `Notifications`
--

CREATE TABLE `Notifications` (
  `id` int(11) NOT NULL,
  `id_acteur` varchar(50) DEFAULT NULL,
  `id_destinataire` varchar(70) DEFAULT NULL,
  `id_carte_concernee` varchar(50) DEFAULT NULL,
  `type_notification` varchar(25) DEFAULT NULL,
  `etat_notification` int(10) DEFAULT NULL,
  `date_envoi` datetime DEFAULT NULL,
  `timestamp` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Acteurs`
--
ALTER TABLE `Acteurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_acteur` (`id_acteur`);

--
-- Index pour la table `Acteurs_Cartes`
--
ALTER TABLE `Acteurs_Cartes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Cartes`
--
ALTER TABLE `Cartes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_carte` (`id_carte`);

--
-- Index pour la table `Notifications`
--
ALTER TABLE `Notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Acteurs`
--
ALTER TABLE `Acteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `Acteurs_Cartes`
--
ALTER TABLE `Acteurs_Cartes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `Cartes`
--
ALTER TABLE `Cartes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
