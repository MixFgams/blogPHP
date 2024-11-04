-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 03 nov. 2024 à 22:54
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l''article.',
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Titre de l''article.',
  `description` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Contenu ou résumé de l''article.',
  `fk_pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Clé étrangère vers le pseudo de la table User.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `titre`, `description`, `fk_pseudo`) VALUES
(1, 'Les Tendances Technologiques de 2024', 'Un aperçu des avancées technologiques qui changeront notre quotidien en 2024.', 'AliceWonder'),
(2, 'Voyager à Petit Budget en Asie', 'Des astuces pour explorer l’Asie sans se ruiner.', 'BobBuilder'),
(3, 'Recettes Faciles pour les Débutants', 'Des recettes simples pour ceux qui débutent en cuisine.', 'CharlieBrown'),
(4, 'Les Classiques de la Littérature Française', 'Un voyage dans le monde des classiques français incontournables.', 'DanaScully'),
(5, 'Les Albums à Écouter en 2024', 'Une sélection des meilleurs albums de l’année.', 'EveRogue'),
(6, 'Les Nouveaux Films à Voir au Cinéma', 'Les sorties cinéma les plus attendues de l’année.', 'FrankOcean'),
(7, 'Les Découvertes Scientifiques Récentes', 'Les découvertes scientifiques qui nous ont impressionnés cette année.', 'GraceHopper'),
(8, 'Les Techniques d’Entraînement en Sport', 'Comment améliorer ses performances sportives.', 'HankHill'),
(9, 'Les Œuvres d’Art Contemporain', 'Une plongée dans l’art contemporain et ses artistes phares.', 'IslaFisher'),
(10, 'Les Merveilles de la Nature à Protéger', 'Les plus beaux sites naturels et pourquoi il faut les préserver.', 'JohnDoe'),
(14, 'reer', 'retert', 'sfgrgzef'),
(15, 'dadzaazd', 'adzazdazddaz', 'sfgrgzef'),
(19, 'ezfezfezf', 'ezzfe', 'admin'),
(22, 'zadzad', 'azdazazd', 'zefezfef'),
(23, 'ezfzfezfezf', 'zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )zeoijzogjiejz ezfj^àjfêzj ezj=àj e=àçj$p jqpsj djdpo qjopdsj ojaj dodjosjo joj ojs j ja )', 'zefezfef');

-- --------------------------------------------------------

--
-- Structure de la table `article_categorie`
--

DROP TABLE IF EXISTS `article_categorie`;
CREATE TABLE IF NOT EXISTS `article_categorie` (
  `article_id` int NOT NULL,
  `categorie_id` int NOT NULL,
  PRIMARY KEY (`article_id`,`categorie_id`),
  KEY `fk_categorie_id` (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article_categorie`
--

INSERT INTO `article_categorie` (`article_id`, `categorie_id`) VALUES
(1, 1),
(22, 1),
(2, 2),
(19, 2),
(23, 2),
(3, 3),
(15, 3),
(5, 5),
(6, 6),
(1, 7),
(7, 7),
(14, 7),
(8, 8),
(2, 9),
(9, 9),
(9, 10),
(10, 10);

-- --------------------------------------------------------

--
-- Structure de la table `article_commentaire`
--

DROP TABLE IF EXISTS `article_commentaire`;
CREATE TABLE IF NOT EXISTS `article_commentaire` (
  `article_id` int NOT NULL,
  `commentaire_id` int NOT NULL,
  PRIMARY KEY (`article_id`,`commentaire_id`),
  KEY `fk_commentaire_id` (`commentaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article_commentaire`
--

INSERT INTO `article_commentaire` (`article_id`, `commentaire_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(2, 6),
(3, 7),
(3, 8),
(3, 9),
(4, 10),
(4, 11),
(4, 12),
(5, 13),
(5, 14),
(5, 15),
(6, 16),
(6, 17),
(6, 18),
(7, 19),
(7, 20),
(7, 21),
(8, 22),
(8, 23),
(8, 24),
(9, 25),
(9, 26),
(9, 27),
(10, 28),
(10, 29),
(10, 30),
(14, 37),
(15, 39),
(4, 44),
(23, 48);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la catégorie.',
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nom de la catégorie.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'Technologie'),
(2, 'Voyage'),
(3, 'Cuisine'),
(5, 'Musique'),
(6, 'Cinéma'),
(7, 'Science'),
(8, 'Sport'),
(9, 'Art'),
(10, 'Nature');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du commentaire.',
  `description` varchar(2000) NOT NULL COMMENT 'Contenu du commentaire.',
  `fk_pseudo` varchar(50) NOT NULL COMMENT 'Clé étrangère vers le pseudo de la table User.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `description`, `fk_pseudo`) VALUES
(1, 'Très intéressant ! Hâte de voir ces innovations en action.', 'JohnDoe'),
(2, 'Je pense que l’IA va vraiment prendre de l’ampleur.', 'IslaFisher'),
(3, 'Super article !', 'HankHill'),
(4, 'J’adore l’Asie, merci pour les conseils !', 'DanaScully'),
(5, 'Je vais tester ces astuces lors de mon prochain voyage.', 'FrankOcean'),
(6, 'Partir à petit budget, c’est tout un art !', 'GraceHopper'),
(7, 'Parfait pour moi qui débute en cuisine, merci !', 'CharlieBrown'),
(8, 'Je vais essayer la recette de gâteau, ça a l’air facile.', 'AliceWonder'),
(9, 'Recettes vraiment simples, c’est top !', 'EveRogue'),
(10, 'Les classiques sont intemporels.', 'BobBuilder'),
(11, 'Merci pour cette liste, je vais m’y plonger !', 'HankHill'),
(12, 'Je recommande aussi d’ajouter Zola dans les classiques.', 'CharlieBrown'),
(13, 'Je ne connaissais pas certains albums, belle découverte.', 'GraceHopper'),
(14, 'Top liste, j’ajoute ces albums à ma playlist.', 'FrankOcean'),
(15, 'Je suis d’accord pour le premier album, un chef-d’œuvre.', 'DanaScully'),
(16, 'Les films de cette année sont incroyables !', 'IslaFisher'),
(17, 'J’espère que le film de Nolan sera à la hauteur.', 'AliceWonder'),
(18, 'Le cinéma, une passion sans fin.', 'JohnDoe'),
(19, 'Passionnant ! Les avancées en science ne cessent de me surprendre.', 'EveRogue'),
(20, 'Je suis toujours impressionné par la technologie moderne.', 'BobBuilder'),
(21, 'Article très instructif, merci.', 'FrankOcean'),
(22, 'Je suis d’accord, l’entraînement fait toute la différence.', 'JohnDoe'),
(23, 'Un très bon guide pour débutants et confirmés.', 'IslaFisher'),
(24, 'Merci pour ces conseils sportifs !', 'HankHill'),
(25, 'L’art contemporain, c’est vraiment fascinant.', 'DanaScully'),
(26, 'Il y a tellement de nouveaux artistes à découvrir.', 'CharlieBrown'),
(27, 'Merci pour cet aperçu !', 'GraceHopper'),
(28, 'Il faut vraiment protéger ces endroits !', 'AliceWonder'),
(29, 'La nature est précieuse, article inspirant.', 'BobBuilder'),
(30, 'Merci pour cette sensibilisation à l’écologie.', 'EveRogue'),
(37, 'ertert', 'sfgrgzef'),
(39, 'adzazda', 'sfgrgzef'),
(44, 'ezfezfe', 'admin'),
(45, 'dzazdaad', 'zefezfef'),
(48, 'zefezfzef', 'zefezfef');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `motDePasse` varchar(100) NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `email`, `motDePasse`, `dateCreation`) VALUES
(1, 'AliceWonder', 'alice@example.com', 'password123', '2024-11-02 14:11:16'),
(2, 'BobBuilder', 'bob@example.com', 'securepass456', '2024-11-02 14:11:16'),
(3, 'CharlieBrown', 'charlie@example.com', 'brownpass789', '2024-11-02 14:11:16'),
(4, 'DanaScully', 'dana@example.com', 'xfiles098', '2024-11-02 14:11:16'),
(5, 'EveRogue', 'eve@example.com', 'roguekey202', '2024-11-02 14:11:16'),
(6, 'FrankOcean', 'frank@example.com', 'oceanview303', '2024-11-02 14:11:16'),
(7, 'GraceHopper', 'grace@example.com', 'debuglife404', '2024-11-02 14:11:16'),
(8, 'HankHill', 'hank@example.com', 'propane505', '2024-11-02 14:11:16'),
(9, 'IslaFisher', 'isla@example.com', 'island606', '2024-11-02 14:11:16'),
(10, 'JohnDoe', 'john@example.com', 'defaultpass707', '2024-11-02 14:11:16'),
(11, 'Farouk', 'bendeddouche@gmail.com', '$2y$10$JDGPvlx4HSWr5Db3tMxZnuuriIFwVsKm83mJVpGekdoZUu2U7MEgm', '2024-11-02 14:44:16'),
(12, 'FaroukFarouk', 'bendeddouche@gmail.com', '$2y$10$lC0DY/QRnbawsTSMybuU4ORdy.HcHmdhLjQu3wvodCMamLn9Q8iVy', '2024-11-02 15:19:53'),
(13, 'afazza', 'zazf@gmail.Com', '$2y$10$Cod9B1wJH/suNNtU5qdtluGn2SGRJiTmXMV7P7O.kaIOHqw7KoFpC', '2024-11-02 15:41:38'),
(14, 'efozfe', 'ezofzk@gmaiL.com', '$2y$10$Z5rOBUu1sWE4Pe6VURgK7eQtPNOlyBuwAZYeqSpf/LdjKmXzGyqwW', '2024-11-02 15:43:14'),
(15, 'sfgrgz', 'ezfe@gmail.com', '$2y$10$poR7M9NihvJ74yUQT1vGVuoKh8nhcSf89KYNU4pkvSD7LY9SFl8XG', '2024-11-02 15:54:38'),
(16, 'sfgrgzef', 'ezfe@gmail.com', '$2y$10$Zy/qmKF9vTQ76yQ8Ytqjku06bQ3UD5qLZUmL8lQl2F8Mj9lS4qz2a', '2024-11-02 15:57:25'),
(17, 'azdzad', 'azd@gmail.com', '$2y$10$tziDlzIkMD5pv21SZCvQ2uSwgdWimZ9Ziy7p4GyebCGCx/6gn1XRq', '2024-11-03 18:47:05'),
(18, 'zeffzeffze', 'zefezfzef@gmail.com', '$2y$10$ZvJtNYYiq7c1enCAgs2hZe5uXQmYjBwp.0BCmeSbzRiWa29RusldG', '2024-11-03 18:47:48'),
(19, 'ezfzezefef', 'zefezf@gmail.COM', '$2y$10$wnKicvSITAaHVP7df5uxEOwpBZQqk4kxDqggcFUZrJ5rZ7bPRLJoq', '2024-11-03 18:48:40'),
(20, 'benbenben', 'benbenben@gmail.com', '$2y$10$tvYB200wjrzjfhPkqOh4NeDLiTmw2gkbITfDrlNqmU1nJmX5CUXK6', '2024-11-03 18:48:56'),
(21, 'admin', 'admin@localhost.fr', '$2y$10$LvIIHL7.OdbXyphMO4ApB.H5BBfyiBaxsaxye96tB4hbFSQwaGNJm', '2024-11-03 18:59:37'),
(22, 'zefezfef', 'ezfezff@gmailC.om', '$2y$10$7s.Ph7UoEQDBlFntoZXuJOEMsdSlsyjiqa7.6fWNI7cAXGynCk.zK', '2024-11-03 23:12:14');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article_categorie`
--
ALTER TABLE `article_categorie`
  ADD CONSTRAINT `fk_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_categorie_id` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `article_commentaire`
--
ALTER TABLE `article_commentaire`
  ADD CONSTRAINT `fk_article_id_commentaire` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_commentaire_id` FOREIGN KEY (`commentaire_id`) REFERENCES `commentaire` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
