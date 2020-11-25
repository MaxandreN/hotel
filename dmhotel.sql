-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 25 nov. 2020 à 09:47
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dmhotel`
--

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

CREATE TABLE `chambre` (
  `id` int(11) NOT NULL,
  `statut_id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `etage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`id`, `statut_id`, `numero`, `etage`) VALUES
(1, 3, 101, 1),
(2, 1, 102, 1),
(3, 3, 103, 1),
(4, 3, 201, 2),
(5, 1, 202, 2),
(6, 1, 203, 2),
(7, 1, 301, 3);

-- --------------------------------------------------------

--
-- Structure de la table `create`
--

CREATE TABLE `create` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201114225308', '2020-11-14 23:53:44', 164),
('DoctrineMigrations\\Version20201114225915', '2020-11-14 23:59:20', 137),
('DoctrineMigrations\\Version20201114230603', '2020-11-15 00:06:09', 171),
('DoctrineMigrations\\Version20201117095239', '2020-11-17 10:58:17', 106),
('DoctrineMigrations\\Version20201118132150', '2020-11-18 14:29:50', 116);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `label`, `name`) VALUES
(1, 'Employé de chambre', 'ROLE_EMPLOYE_CHAMBRE'),
(2, 'Réceptionniste ', 'ROLE_RECEPTIONNISTE'),
(3, 'manager ', 'ROLE_MANAGER');

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
  `id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id`, `label`) VALUES
(1, 'libre'),
(2, 'occupé'),
(3, 'en nettoyage');

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `id` int(11) NOT NULL,
  `chambre_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tache`
--

INSERT INTO `tache` (`id`, `chambre_id`, `user_id`, `date_debut`, `date_fin`) VALUES
(1, 1, 1, '2020-11-16 00:00:00', '2020-11-19 00:37:50'),
(3, 2, 4, '2020-11-18 22:39:03', '2020-11-23 11:17:53'),
(4, 2, 1, '2020-11-19 00:41:39', '2020-11-19 08:06:47'),
(8, 7, 1, '2020-11-19 19:37:58', '2020-11-20 17:15:45'),
(9, 6, 4, '2020-11-19 19:38:29', '2020-11-23 11:17:57'),
(11, 1, 1, '2020-11-20 11:15:40', '2020-11-20 18:01:41'),
(14, 5, 1, '2020-11-20 11:33:20', '2020-11-20 18:01:38'),
(15, 5, 4, '2020-11-20 12:00:41', '2020-11-23 11:18:15'),
(16, 3, 4, '2020-11-20 17:53:48', NULL),
(18, 7, 1, '2020-11-20 19:54:48', '2020-11-21 19:22:09'),
(19, 1, 1, '2020-11-20 19:56:57', '2020-11-20 19:59:18'),
(21, 1, 1, '2020-11-21 19:21:40', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fonction_id` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `role`, `fonction_id`, `password`, `email`) VALUES
(1, 'Sal', 'Jean', '1', 1, '$argon2id$v=19$m=65536,t=4,p=1$a09pUEc3ZUJxS1hVclpVUw$ih8JP76wdMuDna7A802R12jMCyWlFrTUDIzaq2L7Ucc', 'Jean.sal@hotel.fr'),
(2, 'res', 'Hugue', '2', 2, '$argon2id$v=19$m=65536,t=4,p=1$a09pUEc3ZUJxS1hVclpVUw$ih8JP76wdMuDna7A802R12jMCyWlFrTUDIzaq2L7Ucc', 'Hugue.res@hotel.fr'),
(3, 'Man', 'Janette', '1', 3, '$argon2id$v=19$m=65536,t=4,p=1$a09pUEc3ZUJxS1hVclpVUw$ih8JP76wdMuDna7A802R12jMCyWlFrTUDIzaq2L7Ucc', 'Jannette.man@hotel.fr'),
(4, 'Sal', 'Henriette', '1', 1, '$argon2id$v=19$m=65536,t=4,p=1$a09pUEc3ZUJxS1hVclpVUw$ih8JP76wdMuDna7A802R12jMCyWlFrTUDIzaq2L7Ucc', 'Henriette.Sal@hotel.fr');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C509E4FFF6203804` (`statut_id`);

--
-- Index pour la table `create`
--
ALTER TABLE `create`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_938720759B177F54` (`chambre_id`),
  ADD KEY `IDX_93872075A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD KEY `IDX_8D93D64957889920` (`fonction_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chambre`
--
ALTER TABLE `chambre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `create`
--
ALTER TABLE `create`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `statut`
--
ALTER TABLE `statut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tache`
--
ALTER TABLE `tache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD CONSTRAINT `FK_C509E4FFF6203804` FOREIGN KEY (`statut_id`) REFERENCES `statut` (`id`);

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `FK_938720759B177F54` FOREIGN KEY (`chambre_id`) REFERENCES `chambre` (`id`),
  ADD CONSTRAINT `FK_93872075A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64957889920` FOREIGN KEY (`fonction_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
