-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Mar 28 Février 2017 à 17:47
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
(1, 'CCIIRRLLYY', 'Françon', 'Maxime', 'maxime.francon@cirly.com', 'Brignais', '0476890045', 'administrateur', '1487431823', '6d1b74393fb219ad5380838006a9a1d46d256e75'),
(2, 'AALLSSTTOOMM', 'Adam', 'Mark', 'mark.adam@alstom.com', 'Paris', '0406890045', 'client', '1487431823', '629495600e3c30ab9dd16dd13e4c31bba1e7da0c'),
(3, 'AARREEVVAA', 'Frank', 'Taylor', 'frank.taylor@areva.com', 'Valence', '476888045', 'client', '1487431823', '9e3a3d3fe136affa24bfe3137c044e067262f09e'),
(4, 'FFRRIILLNN', 'Pamerlo', 'Jean', 'jean.pamerlo@cable1.com', 'Turin', '0376888045', 'cableur', '1487431823', '8a1eff894f01eda33a3152c3393874176de5fe91');

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
(1, 'FFRRIILLNN', 'CCIIRRLLYY', 'carte1', '2017-02-18 16:39:15', '2017-02-18 17:25:56', '1487432355'),
(2, 'AALLSSTTOOMM', 'CCIIRRLLYY', 'carte2', '2017-02-18 17:54:12', '2017-02-18 17:55:28', '1487436852'),
(3, 'FFRRIILLNN', 'AALLSSTTOOMM', 'carte2', '2017-02-18 18:17:42', '2017-02-18 18:18:50', '1487438262');

-- --------------------------------------------------------

--
-- Structure de la table `Acteurs_Notifications`
--

CREATE TABLE `Acteurs_Notifications` (
  `id` int(11) NOT NULL,
  `id_acteur` int(11) DEFAULT NULL,
  `id_destinataire` varchar(70) DEFAULT NULL,
  `id_notification` int(11) DEFAULT NULL,
  `etat_notification` varchar(10) DEFAULT NULL,
  `timestamp` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'carte1', 'FFRRIILLNN', 'reçue', '2017-02-18 16:36:48', '1487432355'),
(2, 'carte2', 'FFRRIILLNN', 'reçue', '2017-02-18 16:36:48', '1487438262'),
(3, 'carte3', 'CCIIRRLLYY', 'en fabrication', '2017-02-18 16:36:48', '1487432208'),
(4, 'carte4', 'CCIIRRLLYY', 'en fabrication', '2017-02-18 16:36:48', '1487432208'),
(5, 'carte5', 'CCIIRRLLYY', 'en fabrication', '2017-02-19 15:57:30', '1487516250'),
(6, 'carte6', 'CCIIRRLLYY', 'en fabrication', '2017-02-19 16:04:34', '1487516674');

-- --------------------------------------------------------

--
-- Structure de la table `Notifications`
--

CREATE TABLE `Notifications` (
  `id_notification` int(11) NOT NULL,
  `auteur` varchar(255) DEFAULT NULL,
  `date_envoie` datetime DEFAULT NULL,
  `id_carte_concernee` int(11) DEFAULT NULL,
  `timestamp` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Index pour la table `Acteurs_Notifications`
--
ALTER TABLE `Acteurs_Notifications`
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
  ADD PRIMARY KEY (`id_notification`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Acteurs`
--
ALTER TABLE `Acteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `Acteurs_Cartes`
--
ALTER TABLE `Acteurs_Cartes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `Acteurs_Notifications`
--
ALTER TABLE `Acteurs_Notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Cartes`
--
ALTER TABLE `Cartes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT;