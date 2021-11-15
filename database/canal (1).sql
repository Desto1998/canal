-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 15 nov. 2021 à 11:02
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `canal`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnements`
--

CREATE TABLE `abonnements` (
  `id_abonnement` bigint(20) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_decodeur` int(11) NOT NULL,
  `id_formule` int(11) NOT NULL,
  `type_abonnement` int(11) NOT NULL,
  `date_reabonnement` date NOT NULL,
  `date_echeance` date DEFAULT NULL,
  `statut_abo` int(11) NOT NULL,
  `duree` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `caisses`
--

CREATE TABLE `caisses` (
  `id_caisse` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_ajout` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `raison` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_abonnement` int(11) DEFAULT NULL,
  `id_reabonnement` int(11) DEFAULT NULL,
  `id_upgrade` int(11) DEFAULT NULL,
  `id_achat` int(11) DEFAULT NULL,
  `id_materiel` int(11) DEFAULT NULL,
  `id_decodeur` int(11) DEFAULT NULL,
  `id_versement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` bigint(20) UNSIGNED NOT NULL,
  `nom_client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_client` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_client` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_abonnement` date NOT NULL,
  `duree` int(11) NOT NULL,
  `date_reabonnement` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_materiel` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client_decodeurs`
--

CREATE TABLE `client_decodeurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_abonnement` date NOT NULL,
  `date_reabonnement` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_client` bigint(20) UNSIGNED NOT NULL,
  `id_decodeur` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_formule` int(11) NOT NULL,
  `num_abonne` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client_messages`
--

CREATE TABLE `client_messages` (
  `id_clientmessage` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `decodeurs`
--

CREATE TABLE `decodeurs` (
  `id_decodeur` bigint(20) UNSIGNED NOT NULL,
  `num_decodeur` bigint(20) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_decodeur` int(11) NOT NULL,
  `date_livaison` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `decodeurs`
--

INSERT INTO `decodeurs` (`id_decodeur`, `num_decodeur`, `quantite`, `prix_decodeur`, `date_livaison`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 11111111111111, 1, 10000, '2021-11-12', 4, '2021-11-12 15:09:01', '2021-11-12 15:09:01');

-- --------------------------------------------------------

--
-- Structure de la table `decodeur__accessoires`
--

CREATE TABLE `decodeur__accessoires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_decodeur` bigint(20) UNSIGNED NOT NULL,
  `id_materiel` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formules`
--

CREATE TABLE `formules` (
  `id_formule` bigint(20) UNSIGNED NOT NULL,
  `nom_formule` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_formule` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formules`
--

INSERT INTO `formules` (`id_formule`, `nom_formule`, `prix_formule`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'EVASION', 10000, 1, NULL, NULL),
(2, 'ACCESS', 5000, 1, NULL, NULL),
(3, 'EVASION +', 22500, 1, NULL, NULL),
(4, 'ACCESS +', 17000, 1, NULL, NULL),
(5, 'PRESTIGE', 34000, 1, NULL, NULL),
(6, 'ESSENTIEL +', 13500, 1, NULL, NULL),
(7, 'TOUT CANAL', 45000, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id_fournisseur` int(11) NOT NULL,
  `nom_fr` varchar(100) NOT NULL,
  `email_fr` varchar(100) NOT NULL,
  `phone_fr` varchar(20) NOT NULL,
  `adresse_fr` varchar(255) DEFAULT NULL,
  `description_fr` varchar(255) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `materiels`
--

CREATE TABLE `materiels` (
  `id_materiel` bigint(20) UNSIGNED NOT NULL,
  `nom_materiel` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_materiel` int(11) NOT NULL,
  `date_livaison` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `materiels`
--

INSERT INTO `materiels` (`id_materiel`, `nom_materiel`, `quantite`, `prix_materiel`, `date_livaison`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'Télécommande', 1, 2000, '2021-08-18', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `titre_sms` varchar(50) DEFAULT NULL,
  `type_sms` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `description_sms` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id_message`, `titre_sms`, `type_sms`, `message`, `description_sms`, `created_at`, `updated_at`) VALUES
(2, 'Relance', 'STANDART', 'Votre abonnement expire bientôt!', NULL, '2021-09-15 14:46:15', '2021-09-15 15:46:15'),
(18, 'REABONNEMENT', 'STANDART', 'viens te reabonner', NULL, '2021-09-15 15:17:17', '2021-09-15 16:17:17'),
(26, 'Message après réabonnement', 'REABONNEMENT', 'M/Mme <NOM>, votre reabonnement à été effectué avec succès ! Reference: <DATEREABO> .Expire le <DATEECHEANCE>.\r\nContact: 651902626/ 694662294.', '', '2021-09-21 13:40:23', '2021-09-21 14:40:23'),
(27, 'Message après récrutement', 'ABONNEMENT', 'M/Mme <NOM>, votre recrutement à été effectué avec succès ! Reference: <DATEREABO> .Expire le <DATEECHEANCE>.\r\nContact: 651902626/ 694662294.', '', '2021-09-21 13:40:23', '2021-09-21 14:40:23'),
(28, 'Message après versement', 'VERSEMENT', 'M/Mme <NOM>, votre versement de <MONTANT> à été enregistré avec succès ! Reference: <DATEREABO> .Expire le <DATEECHEANCE>', '', '2021-09-21 13:40:23', '2021-09-21 14:40:23');

-- --------------------------------------------------------

--
-- Structure de la table `message_envoyes`
--

CREATE TABLE `message_envoyes` (
  `id_message_envoye` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(100) DEFAULT NULL,
  `telephone_client` varchar(255) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `descition_sms` varchar(255) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT 1,
  `id_user` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_07_19_125358_create_sessions_table', 1),
(7, '2021_07_19_131255_create_clients_table', 1),
(8, '2021_07_19_131458_create_materiels_table', 1),
(9, '2021_07_19_131547_create_messages_table', 1),
(10, '2021_07_19_131635_create_client_messages_table', 1),
(11, '2021_07_19_131726_create_formules_table', 1),
(12, '2021_07_28_130535_create_decodeurs_table', 1),
(13, '2021_07_30_162326_create_decodeur__accessoires_table', 1),
(14, '2021_08_04_132944_create_client_decodeurs_table', 1),
(15, '2021_08_04_134502_create_reabonnements_table', 1),
(16, '2021_08_05_122946_create_caisses_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reabonnements`
--

CREATE TABLE `reabonnements` (
  `id_reabonnement` bigint(20) UNSIGNED NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_decodeur` int(11) NOT NULL,
  `id_formule` int(11) NOT NULL,
  `type_reabonement` int(11) NOT NULL,
  `date_reabonnement` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `duree` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `statut_reabo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('IVmnxo9iLNIyqgnd8rM8t8Fm3hZr9ZykvTbYjqaJ', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiNjFad1VLdlU5N3pPSHV5azlBMzlUUk90Y1BldVJKZjMzMlBkMkNZQyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCRIQm9LdUJ3ZHh4UnJqU0J3YlJMemQua1dzaWJNWUtSZTY0VUo2OVR4ZTNpRGQvaFJxQTdSVyI7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkSEJvS3VCd2R4eFJyalNCd2JSTHpkLmtXc2liTVlLUmU2NFVKNjlUeGUzaURkL2hScUE3UlciO30=', 1636734595);

-- --------------------------------------------------------

--
-- Structure de la table `type_operations`
--

CREATE TABLE `type_operations` (
  `id_type` bigint(20) NOT NULL,
  `operation` varchar(50) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `id_reabonnement` int(11) DEFAULT NULL,
  `id_abonnement` int(11) DEFAULT NULL,
  `id_upgrade` int(11) DEFAULT NULL,
  `date_ajout` date DEFAULT NULL,
  `montant` float NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `upgrades`
--

CREATE TABLE `upgrades` (
  `id_upgrade` bigint(20) NOT NULL,
  `id_oldformule` int(11) NOT NULL,
  `id_newformule` int(11) NOT NULL,
  `montant_upgrade` float NOT NULL,
  `type_upgrade` int(11) NOT NULL,
  `date_upgrade` date DEFAULT NULL,
  `statut_upgrade` int(11) NOT NULL,
  `id_reabonnement` int(11) DEFAULT NULL,
  `id_abonnement` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `telephone` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `adresse`, `telephone`, `is_active`, `is_admin`, `role`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$z3QhQQL2wJn6qCv2cvP40edwQf7ofG7YmJ02mwD3DhtsABZYvmyrG', NULL, NULL, NULL, '', 0, 1, 1, 'admin', NULL, NULL, NULL, NULL),
(2, 'user1', 'user1@gmail.com', NULL, '$2y$10$T8/bOI7GKu7ON.3QgqCER.WhvGQlp.QmGw7CNiPhwp.AT26vlQ5a2', NULL, NULL, NULL, '', 0, 1, 0, 'user', NULL, NULL, NULL, NULL),
(3, 'user2', 'user2@gmaiil.com', NULL, '$2y$10$uwFvvhNNRZYsCiO.eJwzNeR9YLp3JvbC2N5.AaqEtl.Dg8T.uLaka', NULL, NULL, NULL, '', 0, 0, 0, 'user', NULL, NULL, NULL, NULL),
(4, 'teneyemdesto@gmail.com', 'admin@example.com', NULL, '$2y$10$HBoKuBwdxxRrjSBwbRLzd.kWsibMYKRe64UJ69Txe3iDd/hRqA7RW', NULL, NULL, NULL, 'admin@example.com', 679099099, 1, 1, 'admin', NULL, NULL, '2021-08-19 13:56:03', '2021-08-19 13:56:03');

-- --------------------------------------------------------

--
-- Structure de la table `versements`
--

CREATE TABLE `versements` (
  `id_versement` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `montant_versement` float NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `versement_achats`
--

CREATE TABLE `versement_achats` (
  `id_achat` int(11) NOT NULL,
  `montant_achat` float NOT NULL,
  `description_achat` varchar(255) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnements`
--
ALTER TABLE `abonnements`
  ADD PRIMARY KEY (`id_abonnement`);

--
-- Index pour la table `caisses`
--
ALTER TABLE `caisses`
  ADD PRIMARY KEY (`id_caisse`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `client_decodeurs`
--
ALTER TABLE `client_decodeurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_decodeurs_id_client_foreign` (`id_client`),
  ADD KEY `client_decodeurs_id_decodeur_foreign` (`id_decodeur`);

--
-- Index pour la table `client_messages`
--
ALTER TABLE `client_messages`
  ADD PRIMARY KEY (`id_clientmessage`);

--
-- Index pour la table `decodeurs`
--
ALTER TABLE `decodeurs`
  ADD PRIMARY KEY (`id_decodeur`);

--
-- Index pour la table `decodeur__accessoires`
--
ALTER TABLE `decodeur__accessoires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `decodeur__accessoires_id_decodeur_foreign` (`id_decodeur`),
  ADD KEY `decodeur__accessoires_id_materiel_foreign` (`id_materiel`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `formules`
--
ALTER TABLE `formules`
  ADD PRIMARY KEY (`id_formule`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id_fournisseur`);

--
-- Index pour la table `materiels`
--
ALTER TABLE `materiels`
  ADD PRIMARY KEY (`id_materiel`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `message_envoyes`
--
ALTER TABLE `message_envoyes`
  ADD PRIMARY KEY (`id_message_envoye`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `reabonnements`
--
ALTER TABLE `reabonnements`
  ADD PRIMARY KEY (`id_reabonnement`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `type_operations`
--
ALTER TABLE `type_operations`
  ADD PRIMARY KEY (`id_type`);

--
-- Index pour la table `upgrades`
--
ALTER TABLE `upgrades`
  ADD PRIMARY KEY (`id_upgrade`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `versements`
--
ALTER TABLE `versements`
  ADD PRIMARY KEY (`id_versement`);

--
-- Index pour la table `versement_achats`
--
ALTER TABLE `versement_achats`
  ADD PRIMARY KEY (`id_achat`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnements`
--
ALTER TABLE `abonnements`
  MODIFY `id_abonnement` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `caisses`
--
ALTER TABLE `caisses`
  MODIFY `id_caisse` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `client_decodeurs`
--
ALTER TABLE `client_decodeurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `client_messages`
--
ALTER TABLE `client_messages`
  MODIFY `id_clientmessage` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `decodeurs`
--
ALTER TABLE `decodeurs`
  MODIFY `id_decodeur` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `decodeur__accessoires`
--
ALTER TABLE `decodeur__accessoires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formules`
--
ALTER TABLE `formules`
  MODIFY `id_formule` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id_fournisseur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `materiels`
--
ALTER TABLE `materiels`
  MODIFY `id_materiel` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `message_envoyes`
--
ALTER TABLE `message_envoyes`
  MODIFY `id_message_envoye` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reabonnements`
--
ALTER TABLE `reabonnements`
  MODIFY `id_reabonnement` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_operations`
--
ALTER TABLE `type_operations`
  MODIFY `id_type` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `upgrades`
--
ALTER TABLE `upgrades`
  MODIFY `id_upgrade` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `versements`
--
ALTER TABLE `versements`
  MODIFY `id_versement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `versement_achats`
--
ALTER TABLE `versement_achats`
  MODIFY `id_achat` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client_decodeurs`
--
ALTER TABLE `client_decodeurs`
  ADD CONSTRAINT `client_decodeurs_id_client_foreign` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_decodeurs_id_decodeur_foreign` FOREIGN KEY (`id_decodeur`) REFERENCES `decodeurs` (`id_decodeur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `decodeur__accessoires`
--
ALTER TABLE `decodeur__accessoires`
  ADD CONSTRAINT `decodeur__accessoires_id_decodeur_foreign` FOREIGN KEY (`id_decodeur`) REFERENCES `decodeurs` (`id_decodeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `decodeur__accessoires_id_materiel_foreign` FOREIGN KEY (`id_materiel`) REFERENCES `materiels` (`id_materiel`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
