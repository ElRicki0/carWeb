-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-09-2025 a las 21:25:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `carwebdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_administrator`
--

CREATE TABLE `tb_administrator` (
  `id_administrator` int(11) NOT NULL,
  `name_administrator` varchar(30) NOT NULL,
  `email_administrator` varchar(50) NOT NULL,
  `picture_administrator` varchar(150) DEFAULT '404Administrator.png',
  `phone_administrator` varchar(20) NOT NULL,
  `username_administrator` varchar(50) NOT NULL,
  `password_administrator` varchar(200) NOT NULL,
  `status_administrator` tinyint(1) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tb_administrator`
--

INSERT INTO `tb_administrator` (`id_administrator`, `name_administrator`, `email_administrator`, `picture_administrator`, `phone_administrator`, `username_administrator`, `password_administrator`, `status_administrator`, `create_at`, `updated_at`) VALUES
(7, 'ricardomelara', 'example@gmail.com', '404Administrator.png', '7899854521', 'example', '$2y$10$j1NYPrlbi4JfRLJ7toJ8neOolJ5dbc.mdjpSCNZeIqvucBAec1sHC', 0, '2025-09-22 15:25:41', '2025-09-22 15:25:41');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_administrator`
--
ALTER TABLE `tb_administrator`
  ADD PRIMARY KEY (`id_administrator`),
  ADD UNIQUE KEY `email_administrator` (`email_administrator`),
  ADD UNIQUE KEY `phone_administrator` (`phone_administrator`),
  ADD UNIQUE KEY `username_administrator` (`username_administrator`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_administrator`
--
ALTER TABLE `tb_administrator`
  MODIFY `id_administrator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
