-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 19 2026 г., 18:46
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `car_news`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Новинки', 'novinki', '2026-02-19 13:41:28', '2026-02-19 13:41:28'),
(2, 'Электромобили', 'elektromobili', '2026-02-19 13:41:28', '2026-02-19 13:41:28'),
(3, 'Тест-драйвы', 'test-drajvy', '2026-02-19 13:41:28', '2026-02-19 13:41:28'),
(4, 'Автоспорт', 'avtosport', '2026-02-19 13:41:28', '2026-02-19 13:41:28'),
(5, 'Тюнинг', 'tyuning', '2026-02-19 13:41:28', '2026-02-19 13:41:28'),
(6, 'Ремонт', 'remont', '2026-02-19 13:41:28', '2026-02-19 13:41:28');

-- --------------------------------------------------------

--
-- Структура таблицы `homepage_settings`
--

CREATE TABLE `homepage_settings` (
  `id` int NOT NULL,
  `section` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` text,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `homepage_settings`
--

INSERT INTO `homepage_settings` (`id`, `section`, `title`, `subtitle`, `content`, `image`, `button_text`, `button_link`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'slider', 'Диагностика в помощь1111', 'Как мы покупали Geely Monjaro с пробегом 80 тыс. км', 'Полное описание', '/assets/image/347690815514729.png', 'Читать далее', '/news/1', 1, 1, '2026-02-19 14:03:38', '2026-02-19 11:25:27'),
(2, 'slider', 'Прогнозы', 'Что будет с ценами на автозапчасти и ремонт в 2026 году', 'Аналитика и прогнозы', '/assets/image/347690056559303.webp', 'Читать далее', '/news/2', 2, 1, '2026-02-19 14:03:38', '2026-02-19 14:03:38'),
(3, 'slider', 'Топ 9', 'Девять важных изменений на авторынке России', 'Пояснения дилеров', '/assets/image/347690077805638.webp', 'Читать далее', '/news/3', 3, 1, '2026-02-19 14:03:38', '2026-02-19 14:03:38'),
(4, 'news_header', 'Последние новости', 'Самые свежие события из мира автомобилей', NULL, NULL, NULL, NULL, 1, 1, '2026-02-19 14:03:38', '2026-02-19 14:03:38'),
(5, 'all_news_button', NULL, NULL, NULL, NULL, 'Все новости', '/news', 1, 1, '2026-02-19 14:03:38', '2026-02-19 14:03:38');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `views` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `excerpt`, `content`, `image`, `category_id`, `user_id`, `views`, `created_at`, `updated_at`) VALUES
(1, 'Новый электромобиль Tesla', 'tesla-new', 'Компания Tesla представила новую модель электромобиля с запасом хода 1000 км...', 'Полный текст новости о новой Tesla. Здесь будет подробное описание новой модели, технические характеристики, цены и даты начала продаж.', 'https://avatars.mds.yandex.net/i?id=3cc00e0e675a4382310b22b836203916_l-5101081-images-thumbs&n=13', 2, 2, 7, '2026-02-19 13:41:29', '2026-02-19 15:35:35'),
(2, 'Тест-драйв BMW M5', 'bmw-m(0(', 'Мы протестировали новый BMW M5 и делимся впечатлениями...', 'Полный обзор BMW M5 с описанием характеристик, поведения на дороге, расхода топлива и сравнения с конкурентами.', 'https://avatars.mds.yandex.net/get-autoru-reviews/8112346/66142008c769b6a09fba2ff6f16fed5e/1200x900', 3, 2, 0, '2026-02-19 13:41:29', '2026-02-19 12:05:40'),
(3, 'Toyota с водородным двигателем', 'toyota-hydrogen', 'Toyota представила водородный двигатель нового поколения...', 'Подробности о новой технологии Toyota. Как работает водородный двигатель, его преимущества перед электромобилями.', 'https://avatars.mds.yandex.net/i?id=69c40cc0fc13398c0a5e07c2e3daa6ee_l-12513672-images-thumbs&n=13', 1, 1, 9, '2026-02-19 13:41:29', '2026-02-19 15:39:54'),
(4, 'ЦЕНЫ 2026', 'ceny-zapchasti-2026', 'Что будет с ценами на запчасти и ремонт в новом году...', 'Аналитики рассказали о ситуации на рынке автозапчастей. Прогнозы по изменению цен.', 'https://avatars.mds.yandex.net/get-autoru-vos/4829839/6793e6f3b486ba2c6f489654fd5353d1/1200x900', 6, 3, 0, '2026-02-19 13:41:29', '2026-02-19 12:04:34'),
(5, 'Geely Monjaro с пробегом', 'geely-monjaro', 'Как мы покупали Geely Monjaro с пробегом 80 тыс. км...', 'Опыт покупки трехлетнего Geely Monjaro. На что обратить внимание при осмотре.', 'https://avatars.mds.yandex.net/get-autoru-vos/2161791/d24f8ddd54dc7b69a607dcb009ecb170/1200x900', 1, 2, 5, '2026-02-19 13:41:29', '2026-02-19 15:37:31');

-- --------------------------------------------------------

--
-- Структура таблицы `news_comments`
--

CREATE TABLE `news_comments` (
  `id` int NOT NULL,
  `news_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `rating` int DEFAULT '5',
  `is_approved` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `news_comments`
--

INSERT INTO `news_comments` (`id`, `news_id`, `user_id`, `user_name`, `comment`, `rating`, `is_approved`, `created_at`) VALUES
(1, 1, 5, 'admin admin', 'НИЧЕСЕ', 4, 1, '2026-02-19 12:15:25'),
(2, 3, 6, 'фыв вфы', 'по-моему хуета это а не новость!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!(*/ω＼*)(●\'◡\'●)(●\'◡\'●)(●\'◡\'●)(●\'◡\'●)(●\'◡\'●):-Dಥ_ಥ༼ つ ◕_◕ ༽つ(☞ﾟヮﾟ)☞☜(ﾟヮﾟ☜)', 1, 1, '2026-02-19 12:20:41'),
(3, 3, 5, 'admin admin', 'НОРМ', 5, 1, '2026-02-19 12:30:44');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `car_model` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` int DEFAULT NULL,
  `status` enum('moderation','published','rejected') DEFAULT 'moderation',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `car_model`, `title`, `content`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Geely Monjaro', 'Отличный автомобиль', 'Очень доволен покупкой. Комплектация богатая, салон комфортный, двигатель тянет отлично.', 5, 'published', '2026-02-19 13:41:29', '2026-02-19 13:41:29'),
(2, 3, 'BMW M5', 'Зверь, но дорогой', 'Динамика невероятная, управляемость на высоте. Но обслуживание очень дорогое.', 4, 'published', '2026-02-19 13:41:29', '2026-02-19 13:41:29'),
(3, 1, 'Tesla Model Y', 'Электромобиль рулит', 'Экономия на топливе огромная. Минусы - долгая зарядка в дальней дороге.', 4, 'published', '2026-02-19 13:41:29', '2026-02-19 13:41:29'),
(4, 2, 'Toyota Camry', 'Надежность', 'Машина очень комфортная, надежная, расход 9 литров. Рекомендую для семьи.', 5, 'published', '2026-02-19 13:41:29', '2026-02-19 13:41:29'),
(5, 3, 'BYD Song Plus', 'Неплохой вариант', 'Комплектация богаче чем у Tesla, цена ниже. Сервис пока непонятный.', 3, 'moderation', '2026-02-19 13:41:29', '2026-02-19 13:41:29');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `patronymic` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int DEFAULT '1' COMMENT '1-user, 2-admin',
  `phone` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `patronymic`, `login`, `email`, `password`, `role`, `phone`, `city`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Иван', 'Иванов', NULL, 'ivan', 'ivan@mail.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, NULL, '2026-02-19 13:41:29', '2026-02-19 13:41:29'),
(2, 'Петр', 'Петров', NULL, 'petr', 'petr@mail.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, NULL, NULL, NULL, '2026-02-19 13:41:29', '2026-02-19 13:41:29'),
(3, 'Алексей', 'Смирнов', NULL, 'alex', 'alex@mail.ru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, NULL, '2026-02-19 13:41:29', '2026-02-19 13:41:29'),
(4, 'ывф', 'вфы', NULL, 'ывф', 'admin@xn--example-qkg6d.com', '$2y$10$3foo.TyY0nDIlNO94/GCSequxdLIUzIiJHXLmK5SHKHwmKi.VjAUi', 1, NULL, NULL, NULL, '2026-02-19 11:12:18', '2026-02-19 11:12:18'),
(5, 'admin', 'admin', NULL, 'admin', '1@1.r', '$2y$10$jiqRz9u3enFW93q2/Ldi9uUqwc6.3yGSW2FoqpKEE8p54A2ecXDCq', 2, NULL, NULL, NULL, '2026-02-19 11:18:31', '2026-02-19 14:18:59'),
(6, 'фыв', 'вфы', NULL, 'вфы', '1@11.r', '$2y$10$7XUJwd52B2/m.DaLanYFZec1mz8GFFqjDB64UTVQ.ycx8A7puKuz.', 1, NULL, NULL, NULL, '2026-02-19 12:17:17', '2026-02-19 12:17:17');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `homepage_settings`
--
ALTER TABLE `homepage_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `news_comments`
--
ALTER TABLE `news_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `homepage_settings`
--
ALTER TABLE `homepage_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `news_comments`
--
ALTER TABLE `news_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `news_comments`
--
ALTER TABLE `news_comments`
  ADD CONSTRAINT `news_comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
