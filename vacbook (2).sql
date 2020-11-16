-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 16 nov. 2020 à 09:56
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vacbook`
--

-- --------------------------------------------------------

--
-- Structure de la table `nf_users`
--

CREATE TABLE `nf_users` (
  `id` int(11) NOT NULL,
  `nom` varchar(120) NOT NULL,
  `prenom` varchar(120) NOT NULL,
  `civilitee` varchar(30) NOT NULL,
  `date_naissance` datetime NOT NULL,
  `adresse1` varchar(250) DEFAULT NULL,
  `adresse2` varchar(2500) DEFAULT NULL,
  `ville` varchar(120) DEFAULT NULL,
  `codepostal` int(5) DEFAULT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'user_novalid',
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  `token_at` datetime DEFAULT NULL,
  `token2` varchar(250) DEFAULT NULL,
  `token3` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `nf_users`
--

INSERT INTO `nf_users` (`id`, `nom`, `prenom`, `civilitee`, `date_naissance`, `adresse1`, `adresse2`, `ville`, `codepostal`, `role`, `email`, `password`, `created_at`, `updated_at`, `token`, `token_at`, `token2`, `token3`) VALUES
(73, 'admin', 'admin', 'Homme', '1999-07-14 00:00:00', NULL, NULL, NULL, NULL, 'admin', 'admin@gmail.com', '$2y$10$56vQ0g8NlctqFDr/Demx5u9D.OMw9W1MJbGghvAcX/0IsSodtWBrm', '2020-11-13 10:22:09', NULL, NULL, '2020-11-14 14:44:46', 'bl7f2doh4zgPy0puluAXWOhQHOv2Dg0Fnu7O6lg39tZmKhXHsl9v63QcnximBU1IdyF46eymTiFMX9pYlvNwUE1k7ZZKwRh2UrRfCmJpJ80rJpmApcZbaFcH', '');

-- --------------------------------------------------------

--
-- Structure de la table `vaccins`
--

CREATE TABLE `vaccins` (
  `id` int(11) NOT NULL,
  `nomvaccin` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `nombrerappel` int(100) NOT NULL DEFAULT 3,
  `intervallerappel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `vaccins`
--

INSERT INTO `vaccins` (`id`, `nomvaccin`, `description`, `nombrerappel`, `intervallerappel`) VALUES
(1, 'michel', 'michel vaccin de michel', 5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `vaccins_user`
--

CREATE TABLE `vaccins_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vaccin_id` int(11) NOT NULL,
  `date_vaccin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `nf_users`
--
ALTER TABLE `nf_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vaccins`
--
ALTER TABLE `vaccins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vaccins_user`
--
ALTER TABLE `vaccins_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `nf_users`
--
ALTER TABLE `nf_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT pour la table `vaccins`
--
ALTER TABLE `vaccins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `vaccins_user`
--
ALTER TABLE `vaccins_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
