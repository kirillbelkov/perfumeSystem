-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 14 2025 г., 14:39
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
-- База данных: `perfume_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `perfumes`
--

CREATE TABLE `perfumes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `volume_ml` int(11) DEFAULT NULL,
  `bottle_condition` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `perfumes`
--

INSERT INTO `perfumes` (`id`, `name`, `brand`, `release_year`, `volume_ml`, `bottle_condition`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Le Male Elixir ', 'Jean Paul Gaultier', 2025, 75, 'Отличное', 7500.00, '2025-05-14 12:26:10', '2025-05-14 12:26:10'),
(2, 'Bois Impérial', 'Essential Parfums', 2020, 87, 'Отличное', 4500.00, '2025-05-14 12:27:56', '2025-05-14 12:27:56'),
(3, 'Acqua di Giò Parfum', 'Giorgio Armani', 2023, 45, 'Хорошее', 5700.00, '2025-05-14 12:28:30', '2025-05-14 12:28:30'),
(4, 'Quattro Pizzi', 'Xerjoff', 2024, 15, 'Удовлетворительное', 9000.00, '2025-05-14 12:31:16', '2025-05-14 12:31:16');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `perfumes`
--
ALTER TABLE `perfumes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `perfumes`
--
ALTER TABLE `perfumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
