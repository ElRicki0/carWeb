-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2026 a las 03:34:58
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
(2, 'ricardo', 'example@gmail.com', '404Administrator.png', '(555) 223-4567', 'example', '$2y$10$H0tWWdy/GNJoomph.PLwO.lN7ePlrbRSJacMC6yGba0zstQR/WWAG', 0, '2026-06-10 19:31:04', '2026-06-10 19:31:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_brands`
--

CREATE TABLE `tb_brands` (
  `id_brand` int(11) NOT NULL,
  `name_brand` varchar(30) NOT NULL,
  `description_brand` varchar(150) NOT NULL,
  `status_brand` tinyint(4) DEFAULT 1,
  `picture_brand` varchar(300) DEFAULT '404Picture.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tb_brands`
--

INSERT INTO `tb_brands` (`id_brand`, `name_brand`, `description_brand`, `status_brand`, `picture_brand`) VALUES
(32, 'mazda brand name updated one', 'mazda description brand', 0, '6a2c1a507021c.png'),
(33, 'toyota brand name updated', 'toyota brand description', 0, '6a2c8afde2fad.png'),
(34, 'ponmi brand name', 'ponmi brand description', 1, '6a2c8b2d21963.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cars`
--

CREATE TABLE `tb_cars` (
  `id_car` int(11) NOT NULL,
  `model_car` varchar(50) NOT NULL,
  `year_car` int(11) NOT NULL,
  `color_car` varchar(50) DEFAULT NULL,
  `status_car` tinyint(1) NOT NULL DEFAULT 1,
  `id_brand` int(11) DEFAULT NULL,
  `created_at_car` datetime DEFAULT current_timestamp(),
  `modified_at_car` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_categories`
--

CREATE TABLE `tb_categories` (
  `id_category` int(11) NOT NULL,
  `name_category` varchar(50) NOT NULL,
  `description_category` varchar(100) DEFAULT NULL,
  `usage_type_category` varchar(50) NOT NULL,
  `status_category` tinyint(1) NOT NULL DEFAULT 1,
  `picture_category` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tb_categories`
--

INSERT INTO `tb_categories` (`id_category`, `name_category`, `description_category`, `usage_type_category`, `status_category`, `picture_category`) VALUES
(9, 'pickup brands', 'description brandm state', 'family and daily', 0, '6a2ca5f8943ea.jpg'),
(10, 'exotic cars status', 'description exotic car', 'racing cars statuand exibitions', 1, '6a2ca69b2027d.jpg'),
(11, 'sedan', 'family car aun  daily use car', 'family and daily', 1, '6a2ca6e10cb62.jpg'),
(12, 'suv', 'a daily car and family car', 'daily car', 1, '6a2ca77d341be.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_models`
--

CREATE TABLE `tb_models` (
  `id_model` int(11) NOT NULL,
  `name_model` varchar(15) NOT NULL,
  `description_model` int(11) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indices de la tabla `tb_brands`
--
ALTER TABLE `tb_brands`
  ADD PRIMARY KEY (`id_brand`),
  ADD UNIQUE KEY `name_brand` (`name_brand`);

--
-- Indices de la tabla `tb_cars`
--
ALTER TABLE `tb_cars`
  ADD PRIMARY KEY (`id_car`),
  ADD KEY `idx_id_brand` (`id_brand`);

--
-- Indices de la tabla `tb_categories`
--
ALTER TABLE `tb_categories`
  ADD PRIMARY KEY (`id_category`),
  ADD UNIQUE KEY `name_category` (`name_category`);

--
-- Indices de la tabla `tb_models`
--
ALTER TABLE `tb_models`
  ADD PRIMARY KEY (`id_model`),
  ADD UNIQUE KEY `name_model` (`name_model`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_administrator`
--
ALTER TABLE `tb_administrator`
  MODIFY `id_administrator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tb_brands`
--
ALTER TABLE `tb_brands`
  MODIFY `id_brand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `tb_cars`
--
ALTER TABLE `tb_cars`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_categories`
--
ALTER TABLE `tb_categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_cars`
--
ALTER TABLE `tb_cars`
  ADD CONSTRAINT `fk_cars_brands` FOREIGN KEY (`id_brand`) REFERENCES `tb_brands` (`id_brand`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
