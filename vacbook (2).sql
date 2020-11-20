-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 20 nov. 2020 à 12:49
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
(124, 'admin', 'admin', 'Femme', '1999-07-14 00:00:00', '', 'fgfg', 'ffffffffffffffff', 27240, 'admin', 'admin@gmail.com', '$2y$10$9PaaK4wwi4x.h0.u7xKPsOGk0Dzo2EOQoPqYQp/HSXG.4tcZql6kW', '2020-11-19 23:39:47', NULL, '8clDC11WWBUMkpdoOBHqY1RWhcXm1OD9w7ENVuVD7XhAxydvROMIFOz4rg4kKSz5DGA7us6H9i19h4YKxGQH8lpUBAG7XFyNH3e5ufk5NfX7wzgHgM0lmTuz', '2020-11-19 23:39:47', NULL, NULL),
(125, 'Dupont', 'Paul', 'Homme', '1998-07-14 00:00:00', NULL, NULL, NULL, NULL, 'user', 'paul@gmail.com', '$2y$10$7H5RldAkvUXJxY8.psrjC.Bw2fIXbYHx8FdMPwvIKnFJPyMvd5xvm', '2020-11-19 23:40:24', NULL, NULL, '2020-11-19 23:40:24', NULL, NULL),
(126, 'fred', 'fred', 'Homme', '1999-07-14 00:00:00', NULL, NULL, NULL, NULL, 'user', 'fred@gmail.com', '$2y$10$C9GZ/Ys7MhtnfmTfOb2.i.CIPr28LrItRdkE03BuwEkifnjdvG5eW', '2020-11-19 23:51:26', NULL, NULL, '2020-11-19 23:51:26', NULL, NULL),
(127, 'Armand', 'Armand', 'Homme', '1999-07-14 00:00:00', NULL, NULL, NULL, NULL, 'user', 'armand@gmail.com', '$2y$10$uTr2k2o5TKc4pUAiNxN31e4mMn4meBk.hLD.H9u58/ixVtKR30kfm', '2020-11-19 23:53:33', NULL, NULL, '2020-11-19 23:53:33', '09IHm6CZJooVWlNAuJ0bpny1t6QikroPbigXEyMx8y60PVvWHu2LKQ20EI6SMlbdM0bgjxsfMw144rBeRPLB2JMflIMjaORQbcw2RVZAQ0vsNSlpPIDzEpT5', NULL),
(128, 'kevin', 'kevin', 'Homme', '2020-02-02 00:00:00', NULL, NULL, NULL, NULL, 'user', 'kevin@gmail.com', '$2y$10$lbvxlFaHRQ//GjsxzOcy.OP4Iw0SYtG7PAK/5n73mBih7xXpAjqb2', '2020-11-19 23:56:46', NULL, NULL, '2020-11-19 23:56:46', 'Gj7flVmP72Yb1RkD2cN9eYDCGUAAmjq5NYHxuIlPbLsXy7XnW219vSVS26UHKnADIW7VmA0eMJqMqKWppQwJBmbL3fkRKremFdXUcLX4qnz88ta3D1bh8INv', NULL),
(129, 'bob', 'bob', 'Homme', '1999-01-02 00:00:00', NULL, NULL, NULL, NULL, 'user', 'bob@gmail.com', '$2y$10$aviWjK06aokhfACt8CnRyu0CSKwi8ra9bR5DqZKYkJfd2zZ2wkD7G', '2020-11-19 23:58:09', NULL, NULL, '2020-11-19 23:58:09', NULL, NULL),
(130, 'Martin', 'Basile', 'Homme', '1999-07-14 00:00:00', '', 'fffffffffffffff', 'ffffffffffffffff', 27240, 'user', 'bazz.martin42@gmail.com', '$2y$10$P8PQqhKY7f4jTJRaZ/ZqB.iaUpReJxQHfRQK.upCFC1M1JGehqgIi', '2020-11-20 11:08:29', NULL, NULL, '2020-11-20 11:09:53', NULL, NULL),
(131, 'Yaffa', 'Elie', 'Homme', '1997-09-14 00:00:00', NULL, NULL, NULL, NULL, 'user', 'eli@gmail.com', '$2y$10$Y9KNX8ITysaWlD8Cz4p/reLqUUGDzpi4tebiHuB4Al07K8kEbFXsi', '2020-11-20 11:15:36', NULL, NULL, '2020-11-20 11:15:36', NULL, NULL),
(132, 'Michel', 'Michel', 'Homme', '1999-10-12 00:00:00', '', 'fffffffffffffff', 'ffffffffffffffff', 27240, 'user', 'michel@gmail.com', '$2y$10$GZjoEjFJaTNMrx/mXCeRQOU6s3mJwl4Uj/8SpjLkrh9Ykbx.TWMLW', '2020-11-20 11:38:20', NULL, NULL, '2020-11-20 11:40:47', NULL, NULL),
(133, 'Martin', 'Basile', 'Homme', '1998-10-14 00:00:00', NULL, NULL, NULL, NULL, 'user_novalid', 'baz.martin42@gmail.com', '$2y$10$CFhH2jA6h88NOPDctOQsh.7d4nGgdo5ktcCTUQ3tJ465x.71vrRNi', '2020-11-20 11:59:40', NULL, 'YKC2yr4b2QAoJamyCxCSpBaNY2Vtcw01G0OB9mlaA34HQULOZlPIHuPBzEMDGub2npmnEW8ry1I23n9cEmeaT0ixAmaroJUsMo2OYoVvccx1NLzVNEynouoy', '2020-11-20 11:59:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vaccins`
--

CREATE TABLE `vaccins` (
  `id` int(11) NOT NULL,
  `nomvaccin` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `nombrerappel` int(100) NOT NULL DEFAULT 3,
  `intervallerappel` int(11) NOT NULL,
  `peremption` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `vaccins`
--

INSERT INTO `vaccins` (`id`, `nomvaccin`, `description`, `nombrerappel`, `intervallerappel`, `peremption`) VALUES
(7, 'Corona', 'Corona virus', 8, 5, 10),
(8, 'Grippe', 'Vaccin contre la grippe.', 5, 5, 10),
(9, 'Hépatite B', 'Vaccin contre l\'hépatite B.', 5, 5, 10),
(10, 'Coqueluche', 'Vaccin contre la coqueluche.', 5, 5, 10),
(11, 'Peste', 'Vaccin contre la peste', 10, 10, 10),
(12, 'Rougeole', 'Vaccin contre la rougeole.', 10, 10, 10),
(13, 'Pneumocoque', 'Vaccin contre la pneumocoque.', 10, 10, 10),
(14, 'Gastro', 'gastro', 10, 10, 10),
(15, 'vaccin', 'vaccin', 10, 10, 10);

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
-- Déchargement des données de la table `vaccins_user`
--

INSERT INTO `vaccins_user` (`id`, `user_id`, `vaccin_id`, `date_vaccin`) VALUES
(157, 124, 8, '2020-03-05 00:00:00'),
(158, 124, 10, '2020-05-04 00:00:00'),
(159, 124, 12, '2020-08-05 00:00:00'),
(160, 125, 8, '2020-01-04 00:00:00'),
(161, 125, 7, '2020-01-04 00:00:00'),
(162, 125, 11, '2020-01-04 00:00:00'),
(163, 125, 10, '2020-01-04 00:00:00'),
(164, 125, 13, '2019-01-09 00:00:00'),
(166, 123, 9, '2020-05-03 00:00:00'),
(167, 123, 12, '2020-09-03 00:00:00'),
(168, 123, 8, '2020-02-08 00:00:00'),
(170, 126, 8, '2020-06-01 00:00:00'),
(171, 126, 9, '2020-01-01 00:00:00'),
(172, 126, 11, '2020-02-01 00:00:00'),
(173, 126, 7, '2020-02-08 00:00:00'),
(174, 126, 12, '2020-04-04 00:00:00'),
(175, 126, 13, '2019-09-04 00:00:00'),
(176, 127, 9, '2019-09-04 00:00:00'),
(177, 127, 8, '2019-09-08 00:00:00'),
(178, 127, 13, '2019-04-04 00:00:00'),
(179, 127, 12, '2019-04-04 00:00:00'),
(180, 127, 11, '2019-03-04 00:00:00'),
(181, 127, 7, '2019-05-01 00:00:00'),
(182, 129, 9, '2019-02-01 00:00:00'),
(183, 129, 13, '2019-10-01 00:00:00'),
(184, 129, 12, '2019-09-04 00:00:00'),
(185, 129, 11, '2020-08-08 00:00:00'),
(186, 129, 10, '2020-01-01 00:00:00'),
(187, 129, 7, '2020-08-01 00:00:00'),
(188, 124, 9, '2010-12-14 00:00:00'),
(189, 124, 7, '2015-10-14 00:00:00'),
(191, 130, 10, '2016-12-12 00:00:00'),
(192, 130, 9, '2018-05-01 00:00:00'),
(193, 132, 8, '2019-10-05 00:00:00'),
(194, 132, 13, '2015-01-15 00:00:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT pour la table `vaccins`
--
ALTER TABLE `vaccins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `vaccins_user`
--
ALTER TABLE `vaccins_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
