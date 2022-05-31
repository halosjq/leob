-- Estructura de la Databse de kirari en POO

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `bins`
--

CREATE TABLE `bins` (
  `bin` int(7) NOT NULL,
  `code` tinyint(1) NOT NULL DEFAULT 0,
  `brand` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `level` varchar(100) DEFAULT NULL,
  `bank_name` varchar(200) DEFAULT NULL,
  `bank_site` varchar(200) DEFAULT NULL,
  `bank_phone` varchar(200) DEFAULT NULL,
  `country_name` varchar(300) DEFAULT NULL,
  `ISO2` varchar(200) DEFAULT NULL,
  `ISO3` varchar(200) DEFAULT NULL,
  `currency` varchar(200) DEFAULT NULL,
  `flag` varchar(500) DEFAULT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT 0,
  `vbv_msc` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `cmds`
--

CREATE TABLE `cmds` (
  `cmd` varchar(10) NOT NULL COMMENT 'comando',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'true or false',
  `test` tinyint(1) DEFAULT 0 COMMENT 'true or false',
  `msg` varchar(150) NOT NULL DEFAULT '' COMMENT 'Command comment',
  `route` varchar(100) NOT NULL COMMENT 'ruta del archivo',
  `form` varchar(200) DEFAULT '' COMMENT 'formato largo',
  `format` varchar(200) NOT NULL DEFAULT '' COMMENT 'formato corto',
  `review` int(100) NOT NULL COMMENT 'Ultima fecha de revisión',
  `type` varchar(100) NOT NULL DEFAULT 'main' COMMENT 'main, tool, gate, other',
  `access` varchar(100) NOT NULL DEFAULT 'all' COMMENT 'free, premium all, staff, owner',
  `name` varchar(100) NOT NULL COMMENT 'Nombre del comando',
  `link` varchar(100) NOT NULL DEFAULT '' COMMENT 'si es gate'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `extras`
--

CREATE TABLE `extras` (
  `id` int(150) NOT NULL,
  `bin` int(7) NOT NULL,
  `cc` varchar(20) NOT NULL,
  `month` varchar(5) NOT NULL,
  `year` varchar(5) NOT NULL,
  `cvv` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `g_id` varchar(100) NOT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT 0,
  `warns` int(100) NOT NULL DEFAULT 0,
  `type` varchar(50) NOT NULL DEFAULT 'unauth',
  `members` int(255) NOT NULL DEFAULT 0,
  `custom_title` varchar(100) NOT NULL DEFAULT 'not_change',
  `antispam` int(100) NOT NULL DEFAULT 100,
  `finish_time` varchar(100) NOT NULL,
  `link` varchar(550) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Grupos de kirari';


--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `tg_id` varchar(30) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `username` varchar(33) DEFAULT NULL,
  `apodo` varchar(50) NOT NULL DEFAULT 'Free User',
  `lang` varchar(5) NOT NULL DEFAULT 'en',
  `status` varchar(20) NOT NULL DEFAULT 'free' COMMENT 'free o premium',
  `staff` varchar(20) NOT NULL DEFAULT 'user' COMMENT 'user, mod, admin, seller, owner',
  `creditos` varchar(300) NOT NULL DEFAULT '0',
  `save_live` tinyint(1) NOT NULL DEFAULT 0,
  `msg` varchar(1000) NOT NULL DEFAULT '' COMMENT 'Mensaje de servicio',
  `is_private` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'bool',
  `ref_of` int(50) NOT NULL DEFAULT 0 COMMENT 'referido de un usuario id',
  `n_ref` int(10) NOT NULL DEFAULT 0 COMMENT 'n° de referidos ',
  `muted` varchar(100) NOT NULL DEFAULT '0' COMMENT 'unix-time',
  `is_muted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'bool',
  `is_banned` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'bool',
  `warns` int(10) NOT NULL DEFAULT 0,
  `last_check` int(100) NOT NULL COMMENT 'unix.time',
  `antispam` int(100) NOT NULL DEFAULT 60 COMMENT 'tiempo de antispam',
  `member_expired` int(11) NOT NULL DEFAULT 0 COMMENT 'unix-time',
  `credit_expired` int(11) NOT NULL DEFAULT 0 COMMENT 'unix-time',
  `last_reset` int(100) NOT NULL DEFAULT 0 COMMENT 'unix-time en el que se reinicio el n° de checks',
  `n_check` int(100) NOT NULL DEFAULT 0 COMMENT 'n° de checks',
  `register_date` int(100) NOT NULL COMMENT 'unix-time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Table structure for table `keysp`
--

CREATE TABLE `keysp` (
  `key_id` varchar(200) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'premium',
  `credits` int(100) NOT NULL DEFAULT 0,
  `expire` int(12) NOT NULL DEFAULT 1,
  `msg` varchar(1000) NOT NULL DEFAULT 'User free',
  `r_reedem` int(100) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `mailtm`
--

CREATE TABLE `mailtm` (
  `id` varchar(100) NOT NULL,
  `token` varchar(400) DEFAULT NULL,
  `acc_id` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Account data of mail tm';
-- --------------------------------------------------------


--
-- Alter keys
--

-- BINS
ALTER TABLE `bins`
  ADD PRIMARY KEY (`bin`);
COMMIT;

-- CMDS
ALTER TABLE `cmds`
  ADD PRIMARY KEY (`cmd`);
COMMIT;

-- GROUPS
ALTER TABLE `groups`
  ADD PRIMARY KEY (`g_id`);
COMMIT;

-- USERS
ALTER TABLE `users`
  ADD PRIMARY KEY (`tg_id`),
  ADD UNIQUE KEY `username` (`username`);
COMMIT;

-- KEYSP
ALTER TABLE `keysp`
  ADD UNIQUE KEY `key_id` (`key_id`);
COMMIT;

-- EXTRAS
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cc` (`cc`);

-- AUTO_INCREMENT for table `extras`
ALTER TABLE `extras`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=820343;
COMMIT;

-- MAILTM
ALTER TABLE `mailtm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `acc_id` (`acc_id`);
COMMIT;