-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Lun 13 Mars 2017 à 20:13
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
  `timestamp` varchar(70) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Acteurs`
--

INSERT INTO `Acteurs` (`id`, `id_acteur`, `nom_acteur`, `prenom_acteur`, `email_acteur`, `adresse_acteur`, `tel_acteur`, `profil`, `timestamp`, `mdp`) VALUES
(1, 'CCIIRRLLYY', 'Françon', 'Maxime', 'maxime.francon@cirly.com', 'Brignais', '0476890045', 'administrateur', '1489432091', '6d1b74393fb219ad5380838006a9a1d46d256e75'),
(2, 'AALLSSTTOOMM', 'Adam', 'Mark', 'mark.adam@alstom.com', 'Paris', '0406890045', 'client', '1489432091', '629495600e3c30ab9dd16dd13e4c31bba1e7da0c'),
(3, 'AARREEVVAA', 'Frank', 'Taylor', 'frank.taylor@areva.com', 'Valence', '476888045', 'client', '1489432091', '9e3a3d3fe136affa24bfe3137c044e067262f09e'),
(4, 'FFRRIILLNN', 'Pamerlo', 'Jean', 'jean.pamerlo@cable1.com', 'Turin', '0376888045', 'cableur', '1489432091', '8a1eff894f01eda33a3152c3393874176de5fe91'),
(5, 'TEST', 'Test', 'Test', 'test.test@test.com', 'Paris', '0006890045', 'client', '1489432091', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');

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
(1, 'AARREEVVAA', 'CCIIRRLLYY', 'carte1', '2017-03-13 20:12:00', NULL, '1489432320'),
(2, 'AARREEVVAA', 'CCIIRRLLYY', 'carte2', '2017-03-13 20:12:00', NULL, '1489432320'),
(3, 'AALLSSTTOOMM', 'CCIIRRLLYY', 'carte3', '2017-03-13 20:12:00', NULL, '1489432320'),
(4, 'AALLSSTTOOMM', 'CCIIRRLLYY', 'carte4', '2017-03-13 20:12:00', NULL, '1489432320'),
(5, 'TEST', 'CCIIRRLLYY', 'carte5', '2017-03-13 20:12:00', NULL, '1489432320'),
(6, 'TEST', 'CCIIRRLLYY', 'carte6', '2017-03-13 20:12:00', NULL, '1489432320'),
(7, 'AARREEVVAA', 'CCIIRRLLYY', 'carte7', '2017-03-13 20:12:00', NULL, '1489432320'),
(8, 'FFRRIILLNN', 'CCIIRRLLYY', 'carte8', '2017-03-13 20:12:00', NULL, '1489432320'),
(9, 'FFRRIILLNN', 'CCIIRRLLYY', 'carte9', '2017-03-13 20:12:00', NULL, '1489432320');

-- --------------------------------------------------------

--
-- Structure de la table `Cartes`
--

CREATE TABLE `Cartes` (
  `id` int(11) NOT NULL,
  `id_carte` varchar(255) DEFAULT NULL,
  `proprietaire_actu` varchar(255) DEFAULT NULL,
  `etat_carte` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `timestamp` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Cartes`
--

INSERT INTO `Cartes` (`id`, `id_carte`, `proprietaire_actu`, `etat_carte`, `date_creation`, `timestamp`) VALUES
(1, 'carte1', 'AARREEVVAA', 'en transit', '2017-03-13 20:11:03', '1489432320'),
(2, 'carte2', 'AARREEVVAA', 'en transit', '2017-03-13 20:11:03', '1489432320'),
(3, 'carte3', 'AALLSSTTOOMM', 'en transit', '2017-03-13 20:11:03', '1489432320'),
(4, 'carte4', 'AALLSSTTOOMM', 'en transit', '2017-03-13 20:11:03', '1489432320'),
(5, 'carte5', 'TEST', 'en transit', '2017-03-13 20:11:03', '1489432320'),
(6, 'carte6', 'TEST', 'en transit', '2017-03-13 20:11:03', '1489432320'),
(7, 'carte7', 'AARREEVVAA', 'en transit', '2017-03-13 20:11:03', '1489432320'),
(8, 'carte8', 'FFRRIILLNN', 'en transit', '2017-03-13 20:11:03', '1489432320'),
(9, 'carte9', 'FFRRIILLNN', 'en transit', '2017-03-13 20:11:03', '1489432320'),
(10, 'carte10', 'CCIIRRLLYY', 'reçue', '2017-03-13 20:11:03', '1489432263');

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
-- Contenu de la table `Notifications`
--

INSERT INTO `Notifications` (`id`, `id_acteur`, `id_destinataire`, `id_carte_concernee`, `type_notification`, `etat_notification`, `date_envoi`, `timestamp`) VALUES
(1, 'CCIIRRLLYY', 'AARREEVVAA', 'carte1', 'émise', 0, '2017-03-13 20:12:00', '1489432320'),
(2, 'CCIIRRLLYY', 'AARREEVVAA', 'carte2', 'émise', 0, '2017-03-13 20:12:00', '1489432320'),
(3, 'CCIIRRLLYY', 'AALLSSTTOOMM', 'carte3', 'émise', 0, '2017-03-13 20:12:00', '1489432320'),
(4, 'CCIIRRLLYY', 'AALLSSTTOOMM', 'carte4', 'émise', 0, '2017-03-13 20:12:00', '1489432320'),
(5, 'CCIIRRLLYY', 'TEST', 'carte5', 'émise', 0, '2017-03-13 20:12:00', '1489432320'),
(6, 'CCIIRRLLYY', 'TEST', 'carte6', 'émise', 0, '2017-03-13 20:12:00', '1489432320'),
(7, 'CCIIRRLLYY', 'AARREEVVAA', 'carte7', 'émise', 0, '2017-03-13 20:12:00', '1489432320'),
(8, 'CCIIRRLLYY', 'FFRRIILLNN', 'carte8', 'émise', 0, '2017-03-13 20:12:00', '1489432320'),
(9, 'CCIIRRLLYY', 'FFRRIILLNN', 'carte9', 'émise', 0, '2017-03-13 20:12:00', '1489432320');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `Acteurs_Cartes`
--
ALTER TABLE `Acteurs_Cartes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `Cartes`
--
ALTER TABLE `Cartes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;