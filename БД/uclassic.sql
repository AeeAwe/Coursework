-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 31 2026 г., 01:38
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `uclassic`
--

-- --------------------------------------------------------

--
-- Структура таблицы `abonements`
--

CREATE TABLE `abonements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `visits` int(11) NOT NULL DEFAULT 20,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `abonements`
--

INSERT INTO `abonements` (`id`, `name`, `description`, `visits`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Абонемент 10 занятий', 'Абонемент на 10 занятий, действующий неограничено по времени', 10, 1700.00, '2026-03-30 23:15:04', '2026-03-30 23:15:04'),
(2, 'Абонемент 20 занятий', 'Абонемент на 20 занятий, действующий неограничено по времени', 20, 3500.00, '2026-03-30 23:15:04', '2026-03-30 23:15:04'),
(3, 'Безлимитный месяц', 'Безлимитные занятия неограничено по времени', 9999, 9999.00, '2026-03-30 23:15:04', '2026-03-30 23:15:04');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_abonements_table', 1),
(3, '0001_01_01_000002_create_schedules_table', 1),
(4, '0001_01_01_000003_create_user_abonements_table', 1),
(5, '0001_01_01_000004_create_user_activities_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trainer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 15,
  `status` enum('active','completed','canceled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `schedules`
--

INSERT INTO `schedules` (`id`, `trainer_id`, `name`, `date`, `capacity`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Групповая тренировка', '2026-04-15 10:00:00', 10, 'active', '2026-03-30 23:15:04', '2026-03-30 23:15:04'),
(2, 2, 'Групповая тренировка', '2026-04-11 10:00:00', 20, 'active', '2026-03-30 23:15:04', '2026-03-30 23:15:04'),
(3, 2, 'Тяжелый вес', '2026-04-13 17:00:00', 10, 'active', '2026-03-30 23:15:04', '2026-03-30 23:15:04'),
(4, 2, 'Тяжелый вес', '2026-04-08 11:00:00', 10, 'active', '2026-03-30 23:15:04', '2026-03-30 23:15:04'),
(5, 2, 'Йога', '2026-04-15 13:00:00', 15, 'active', '2026-03-30 23:15:04', '2026-03-30 23:15:04');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fio` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','trainer','admin') NOT NULL DEFAULT 'client',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fio`, `phone`, `email`, `login`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin221', '+7(999)-121-12-12', 'admin@example.com', 'admin221', '$2y$12$ZCgA4AMNDv.3c2.8TywZ2OOd2iTAMvuRI6kulFGy5Qpuqo2CODtEm', 'admin', '2026-03-30 23:15:04', '2026-03-30 23:15:04'),
(2, 'trainer221', '+7(999)-122-12-12', 'trainer@example.com', 'trainer221', '$2y$12$Ih4tuRVl9ZOGDNlr.E7RxO2XS.OckuuCeal0OyMksmNvJPjEPSZEC', 'trainer', '2026-03-30 23:15:04', '2026-03-30 23:15:04'),
(3, 'client221', '+7(999)-123-12-12', 'client@example.com', 'client221', '$2y$12$cPoC02XcxoM0JQeC5tD5wOdl/7G04w1XcymcLKCPFgbY5RbZk61ZW', 'client', '2026-03-30 23:15:04', '2026-03-30 23:15:04');

-- --------------------------------------------------------

--
-- Структура таблицы `user_abonements`
--

CREATE TABLE `user_abonements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `abonement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `visits_left` int(11) NOT NULL DEFAULT 0,
  `status` enum('pending','active','ended','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_activities`
--

CREATE TABLE `user_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('recorded','attended') NOT NULL DEFAULT 'recorded',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `abonements`
--
ALTER TABLE `abonements`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_trainer_id_foreign` (`trainer_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_login_unique` (`login`);

--
-- Индексы таблицы `user_abonements`
--
ALTER TABLE `user_abonements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_abonements_user_id_foreign` (`user_id`),
  ADD KEY `user_abonements_abonement_id_foreign` (`abonement_id`);

--
-- Индексы таблицы `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activities_user_id_foreign` (`user_id`),
  ADD KEY `user_activities_schedule_id_foreign` (`schedule_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `abonements`
--
ALTER TABLE `abonements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user_abonements`
--
ALTER TABLE `user_abonements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_trainer_id_foreign` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `user_abonements`
--
ALTER TABLE `user_abonements`
  ADD CONSTRAINT `user_abonements_abonement_id_foreign` FOREIGN KEY (`abonement_id`) REFERENCES `abonements` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_abonements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_activities`
--
ALTER TABLE `user_activities`
  ADD CONSTRAINT `user_activities_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
