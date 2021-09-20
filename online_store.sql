-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 10 2021 г., 23:13
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `online_store`
--

-- --------------------------------------------------------

--
-- Структура таблицы `basket_goods`
--

CREATE TABLE `basket_goods` (
  `id` int(11) NOT NULL,
  `goods` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `basket_goods`
--

INSERT INTO `basket_goods` (`id`, `goods`, `count`, `ip`) VALUES
(40, 1, 1, '3973938405fca0624ed6d8'),
(49, 3, 3, '13398855575fc9245b4fde0'),
(59, 5, 1, '13398855575fc9245b4fde0'),
(60, 4, 1, '13398855575fc9245b4fde0'),
(63, 3, 1, '2064874093600c51fa0e86f'),
(64, 5, 1, '2064874093600c51fa0e86f'),
(65, 7, 1, '2064874093600c51fa0e86f'),
(83, 10, 1, '1435837561600d8eb645372'),
(92, 3, 1, '8801613056038c420620ed'),
(217, 3, 3, '13342259036011ada883b1b');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Оптика'),
(2, 'Двигатель'),
(3, 'Диски'),
(4, 'Кузов'),
(5, 'Подвеска');

-- --------------------------------------------------------

--
-- Структура таблицы `composition`
--

CREATE TABLE `composition` (
  `id` int(11) DEFAULT NULL,
  `goods` int(11) DEFAULT NULL,
  `matrials` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `composition`
--

INSERT INTO `composition` (`id`, `goods`, `matrials`) VALUES
(1, 1, 1),
(2, 3, 1),
(3, 4, 1),
(4, 5, 2),
(5, 6, 2),
(6, 7, 1),
(7, 8, 2),
(8, 9, 1),
(9, 10, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `discount`
--

CREATE TABLE `discount` (
  `skidka` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `discount`
--

INSERT INTO `discount` (`skidka`, `id`, `start`, `end`) VALUES
(10, 1, '2020-11-04 23:17:09', '2021-12-01 22:59:47'),
(25, 2, '2020-11-04 03:21:47', '2021-12-07 03:18:50');

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `sales` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `price`, `discount`, `name`, `stock`, `description`, `quantity`, `category`, `sales`, `date`) VALUES
(1, 5000, 1, 'Фара', 'сток', 'оптика', 3, 1, 5, '2020-11-04 23:40:53'),
(3, 10000, 2, 'Дверь', 'сток', 'кузов', 34, 4, 20, '2020-11-04 23:40:53'),
(4, 15000, 1, 'Поршня', 'сток', 'двигатель', 5, 2, 12, '2020-11-04 23:40:53'),
(5, 2000, NULL, 'Диск колесный', 'сток', 'диски', 10, 3, 34, '2020-11-04 23:40:53'),
(6, 30000, 1, 'Коленвал', 'сток', 'двигатель', 34, 2, 11, '2020-11-04 23:40:53'),
(7, 15000, 2, 'Рычаг', 'сток', 'подвеска', 35, 5, 8, '2020-11-04 23:40:53'),
(8, 70000, NULL, 'Коробка', 'сток', 'МКПП', 38, 2, 9, '2020-11-04 23:40:53'),
(9, 9000, NULL, 'Прокладки двигателя', 'сток', 'двигатель', 35, 2, 10, '2020-11-04 23:40:53'),
(10, 20000, NULL, 'Руль', 'сток', 'кузов', 34, 4, 14, '2020-11-04 23:40:53'),
(11, 1000, 1, 'Запчасть', 'сток', 'оптика', 3, 1, 10, '2021-02-09 20:28:05'),
(12, 1000, 1, 'Запчасть', 'сток', 'оптика', 3, 1, 10, '2021-02-09 20:28:05');

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `img` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `goods` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `image`
--

INSERT INTO `image` (`id`, `img`, `goods`) VALUES
(1, '21.jpg', 1),
(5, '22.jpg', 3),
(11, '23.jpg', 4),
(12, '24.jpg', 5),
(13, '25.jpg', 6),
(14, '26.jpg', 7),
(15, '27.jpg', 8),
(16, '28.jpg', 9),
(17, '29.jpg', 10),
(20, '29.jpg', 11),
(21, '29.jpg', 12);

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `name`) VALUES
(1, 'Оригинал'),
(2, 'Аналог');

-- --------------------------------------------------------

--
-- Структура таблицы `reg_user`
--

CREATE TABLE `reg_user` (
  `id` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pass` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `patronymic` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datatime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reg_user`
--

INSERT INTO `reg_user` (`id`, `login`, `email`, `pass`, `surname`, `name`, `patronymic`, `address`, `phone`, `ip`, `datatime`) VALUES
(4, 'admin', 'admin@mail.ru', '9nm2rv8q27e230c63db3c4f0bed809c84effdf6f2yo6z', 'Админ', 'Админ', 'Админ', 'г.Уфа, ул.Комсомольская, д.10, кв.35', '89999945265', '2064874093600c51fa0e86f', '2021-01-23 23:23:00'),
(5, 'vladislav', 'vlad@mail.ru', '9nm2rv8q3652208d1e3ddf839bf558e6b6e46dcc2yo6z', 'Марсаков', 'Влад', 'Алексеевич', 'г.Уфа, ул.Комсомольская, д.10, кв.35', '89175642354', '2064874093600c51fa0e86f', '2021-01-24 02:35:29'),
(6, 'admins', 'admins@mail.ru', '9nm2rv8qaa531b4045759ac34be25728feddd3aa2yo6z', 'Авапавор', 'вапвапв', 'вапвап', 'г.Уфа, ул.Комсомольская, д.10, кв.35', '85464235761', '2064874093600c51fa0e86f', '2021-01-24 02:39:04'),
(7, 'abcd1', 'asga@mail.ru', '9nm2rv8qadbd7c1ba60c6233b33ed59549befc972yo6z', 'Пользователь', 'Пользователь', 'Пользователь', 'г.Уфа, ул.Комсомольская, д.10, кв.35', '89456325478', '1127738876600c9c2b8cf2f', '2021-01-24 20:06:53'),
(8, 'admin1', 'admin1@mail.ru', '9nm2rv8q7f2045ce65aecd5081069a06bfe460582yo6z', 'Админ', 'Админ', 'Админ', 'г.Уфа, ул.Ленина, д.45, кв.3', '89456325478', '13342259036011ada883b1b', '2021-01-27 23:18:28'),
(9, 'admin254', 'asga65@mail.ru', '9nm2rv8qbc3c35a542c6418c185aba12ec8d7c992yo6z', 'выпапв', 'пвапва', 'ипапт', 'г.Уфа, ул.Ленина, д.45, кв.3', '89456325478', '21034810856039041f916a3', '2021-02-26 19:23:20'),
(10, 'user1', 'user@mail.ru', '9nm2rv8qf3e40d652acfd3245163e6899ab41da62yo6z', 'Пользователь', 'Пользователь', 'Пользователь', 'г.Уфа, ул.Ленина, д.45, кв.3', '89142134567', '89763061460390b4589131', '2021-02-26 20:14:58');

-- --------------------------------------------------------

--
-- Структура таблицы `zakazi`
--

CREATE TABLE `zakazi` (
  `id` int(11) NOT NULL,
  `goods` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `zakazi`
--

INSERT INTO `zakazi` (`id`, `goods`, `count`, `phone`, `email`, `address`, `total_price`, `date`, `status`) VALUES
(32, 'Фара,Дверь', '1,1', '89456325478', 'admin1@mail.ru', 'г.Уфа, ул.Ленина, д.45, кв.3', 12000, '2021-03-01 14:20:43', 1),
(33, 'Поршня,Диск колесный', '1,1', '89456325478', 'admin1@mail.ru', 'г.Уфа, ул.Ленина, д.45, кв.3', 15500, '2021-03-01 14:28:32', 2),
(34, 'Фара,Дверь,Поршня,Диск колесный,Коленвал,Рычаг', '1,3,2,6,1,4', '89456325478', 'admin1@mail.ru', 'г.Уфа, ул.Ленина, д.45, кв.3', 138000, '2021-03-01 15:10:57', 3),
(35, 'Дверь,Поршня', '1,1', '89142134567', 'user@mail.ru', 'г.Уфа, ул.Ленина, д.45, кв.3', 21000, '2021-03-01 15:27:58', 1),
(36, 'Дверь,Поршня,Диск колесный', '1,1,1', '89142134567', 'user@mail.ru', 'г.Уфа, ул.Ленина, д.45, кв.3', 23000, '2021-03-01 15:32:36', 2),
(37, 'Дверь,Поршня,Диск колесный', '1,1,1', '89142134567', 'user@mail.ru', 'г.Уфа, ул.Ленина, д.45, кв.3', 23000, '2021-03-01 15:33:18', 3),
(38, 'Коробка', '1', '89142134567', 'user@mail.ru', 'г.Уфа, ул.Ленина, д.45, кв.3', 70000, '2021-03-01 15:34:48', 4),
(39, 'Фара,Рычаг', '1,2', '89142134567', 'user@mail.ru', 'г.Уфа, ул.Ленина, д.45, кв.3', 27000, '2021-03-01 15:36:03', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket_goods`
--
ALTER TABLE `basket_goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reg_user`
--
ALTER TABLE `reg_user`
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `zakazi`
--
ALTER TABLE `zakazi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `basket_goods`
--
ALTER TABLE `basket_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `reg_user`
--
ALTER TABLE `reg_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `zakazi`
--
ALTER TABLE `zakazi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
