-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Янв 14 2022 г., 20:10
-- Версия сервера: 10.4.20-MariaDB
-- Версия PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bridge_sport`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_auth_assignment`
--

CREATE TABLE `bsip_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_auth_item`
--

CREATE TABLE `bsip_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_auth_item_child`
--

CREATE TABLE `bsip_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_auth_rule`
--

CREATE TABLE `bsip_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_category`
--

CREATE TABLE `bsip_category` (
  `id` int(4) NOT NULL,
  `parent_id` smallint(6) NOT NULL DEFAULT 0,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(3) NOT NULL DEFAULT 1,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bsip_category`
--

INSERT INTO `bsip_category` (`id`, `parent_id`, `name`, `slug`, `img`, `keywords`, `description`, `active`, `deleted_at`) VALUES
(1, 0, 'Розыгрыш', 'rozygrysh', NULL, '', '', 1, NULL),
(2, 1, 'Задачки', 'zadachki', NULL, '', '', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_migration`
--

CREATE TABLE `bsip_migration` (
  `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bsip_migration`
--

INSERT INTO `bsip_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1641035697),
('m130524_201442_init', 1641035745),
('m140506_102106_rbac_init', 1641045785),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1641045786),
('m180523_151638_rbac_updates_indexes_without_prefix', 1641045786),
('m190124_110200_add_verification_token_column_to_user_table', 1641035745),
('m200409_110543_rbac_update_mssql_trigger', 1641045786),
('m220102_143820_create_category_table', 1641931369),
('m220102_183314_create_post_table', 1641931370),
('m220111_193418_create_taxonomy_table', 1641931370),
('m220111_193518_create_post_taxonomy_table', 1641931370);

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_post`
--

CREATE TABLE `bsip_post` (
  `id` int(11) NOT NULL,
  `category_id` int(4) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preview` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indexing` tinyint(3) NOT NULL DEFAULT 0,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(3) NOT NULL DEFAULT 1,
  `author_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bsip_post`
--

INSERT INTO `bsip_post` (`id`, `category_id`, `name`, `url`, `slug`, `preview`, `description`, `img`, `dial`, `indexing`, `keywords`, `active`, `author_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'сквиз', 'rozygrysh/zadachki/skviz', 'skviz', 'фывфывыфва', '<p>фывафывафываа</p>\r\n', '', '', 0, '', 1, 1, 1641935649, 1642141015, NULL),
(2, 1, 'сквизюкафыв', 'rozygrysh/skvizyukafyv', 'skvizyukafyv', 'ываы', '<p>ываываыв</p>\r\n', '', '', 0, '', 1, 1, 1641983233, 1641983233, NULL),
(3, 1, 'сквизяка', 'rozygrysh/skvizyaka', 'skvizyaka', 'фыфсфы', '<p>фыфысфсвф</p>\r\n', '', '', 0, '', 1, 1, 1641987943, 1641987943, NULL),
(4, 1, 'слегка задачка1', 'rozygrysh/slegka-zadachka1', 'slegka-zadachka1', 'вввяяяыяы', '<p>яссяч</p>\r\n', '', '', 0, '', 1, 1, 1642139848, 1642139887, NULL),
(5, 2, 'йцуйуайайцуйц', 'rozygrysh/zadachki/ycuyuayaycuyc', 'ycuyuayaycuyc', 'фывафывафыа', '<p>фывафывафыва</p>\r\n', '5ac8d-Снимок экрана от 2021-06-30 08-51-38.png', '', 1, '', 1, 1, 1642160250, 1642160758, NULL),
(6, 1, 'ыва', 'rozygrysh/yva', 'yva', 'ыва', '<p>ываыва</p>\r\n', 'e336f-Снимок экрана от 2021-07-29 16-50-31.png', '', 0, '', 1, 1, 1642166650, 1642166650, NULL),
(7, 2, 'фыарентпорпа', 'rozygrysh/zadachki/fyarentporpa', 'fyarentporpa', 'фывфывфы', '<p>афыафывафы</p>\r\n', '2022/01/507f5-Снимок экрана от 2021-07-16 10-44-54.png', '', 0, '', 1, 1, 1642166834, 1642166834, NULL),
(8, 1, 'фыафываыафыва', 'rozygrysh/fyafyvayafyva', 'fyafyvayafyva', 'фыафыва', '<p>фыафыафы</p>\r\n', '2022/01/bdb98-9b950ec4b9c5c8b49f3df7ddff8d9279d8af396f (копия).jpg', '', 0, '', 1, 1, 1642168865, 1642184525, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_post_taxonomy`
--

CREATE TABLE `bsip_post_taxonomy` (
  `post_id` int(11) NOT NULL,
  `taxonomy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bsip_post_taxonomy`
--

INSERT INTO `bsip_post_taxonomy` (`post_id`, `taxonomy_id`) VALUES
(1, 1),
(1, 2),
(4, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_taxonomy`
--

CREATE TABLE `bsip_taxonomy` (
  `id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attr_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` smallint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bsip_taxonomy`
--

INSERT INTO `bsip_taxonomy` (`id`, `label`, `attr_key`, `value`) VALUES
(1, 'beginner', 'Для новичков', NULL),
(2, 'advanced', 'Продвинутый', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `bsip_user`
--

CREATE TABLE `bsip_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `bsip_user`
--

INSERT INTO `bsip_user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'Eridiant', 'UWtwhcOL-CJoqYl4wC9YrYjRziBYvzl8', '$2y$13$hyqHHJYzFpzbepf.H1G/XeQ.Zi.T6CA2RWDPaSb8HpzcWo8Ia2Jti', NULL, 'zdvxfb@mail.ru', 10, 1641051505, 1641054625, 'GZzNzhoUc4QCOF3yKO_4yo8gRiD8TLUS_1641051505');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bsip_auth_assignment`
--
ALTER TABLE `bsip_auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `bsip_idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `bsip_auth_item`
--
ALTER TABLE `bsip_auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `bsip_idx-auth_item-type` (`type`);

--
-- Индексы таблицы `bsip_auth_item_child`
--
ALTER TABLE `bsip_auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `bsip_auth_rule`
--
ALTER TABLE `bsip_auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `bsip_category`
--
ALTER TABLE `bsip_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bsip_migration`
--
ALTER TABLE `bsip_migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `bsip_post`
--
ALTER TABLE `bsip_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-post-url` (`url`(768)),
  ADD KEY `idx-post-slug` (`slug`),
  ADD KEY `fk-category-post` (`category_id`);

--
-- Индексы таблицы `bsip_post_taxonomy`
--
ALTER TABLE `bsip_post_taxonomy`
  ADD PRIMARY KEY (`post_id`,`taxonomy_id`),
  ADD KEY `bsip_idx-post_taxonomy-post_id` (`post_id`),
  ADD KEY `bsip_idx-post_taxonomy-taxonomy_id` (`taxonomy_id`);

--
-- Индексы таблицы `bsip_taxonomy`
--
ALTER TABLE `bsip_taxonomy`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bsip_user`
--
ALTER TABLE `bsip_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bsip_category`
--
ALTER TABLE `bsip_category`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `bsip_post`
--
ALTER TABLE `bsip_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `bsip_taxonomy`
--
ALTER TABLE `bsip_taxonomy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `bsip_user`
--
ALTER TABLE `bsip_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bsip_auth_assignment`
--
ALTER TABLE `bsip_auth_assignment`
  ADD CONSTRAINT `bsip_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `bsip_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `bsip_auth_item`
--
ALTER TABLE `bsip_auth_item`
  ADD CONSTRAINT `bsip_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `bsip_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `bsip_auth_item_child`
--
ALTER TABLE `bsip_auth_item_child`
  ADD CONSTRAINT `bsip_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `bsip_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bsip_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `bsip_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `bsip_post`
--
ALTER TABLE `bsip_post`
  ADD CONSTRAINT `fk-category-post` FOREIGN KEY (`category_id`) REFERENCES `bsip_category` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `bsip_post_taxonomy`
--
ALTER TABLE `bsip_post_taxonomy`
  ADD CONSTRAINT `bsip_fk-post_taxonomy-post_id` FOREIGN KEY (`post_id`) REFERENCES `bsip_post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bsip_fk-post_taxonomy-taxonomy_id` FOREIGN KEY (`taxonomy_id`) REFERENCES `bsip_taxonomy` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
