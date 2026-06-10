-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2025 a las 06:53:51
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_brands`
--

CREATE TABLE `tb_brands` (
  `id_brand` int(11) NOT NULL,
  `name_brand` varchar(30) NOT NULL,
  `description_brand` varchar(150) NOT NULL,
  `status_brand` tinyint(4) DEFAULT 1,
  `picture_brand` varchar(300) DEFAULT '404Picture.png',
  `id_category1` int(11) NOT NULL,
  `id_category2` int(11) DEFAULT NULL,
  `id_category3` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
  ADD UNIQUE KEY `name_brand` (`name_brand`),
  ADD KEY `id_category1` (`id_category1`),
  ADD KEY `id_category2` (`id_category2`),
  ADD KEY `id_category3` (`id_category3`);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_administrator`
--
ALTER TABLE `tb_administrator`
  MODIFY `id_administrator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_brands`
--
ALTER TABLE `tb_brands`
  MODIFY `id_brand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tb_cars`
--
ALTER TABLE `tb_cars`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_categories`
--
ALTER TABLE `tb_categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_brands`
--
ALTER TABLE `tb_brands`
  ADD CONSTRAINT `tb_brands_ibfk_1` FOREIGN KEY (`id_category1`) REFERENCES `tb_categories` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_brands_ibfk_2` FOREIGN KEY (`id_category2`) REFERENCES `tb_categories` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_brands_ibfk_3` FOREIGN KEY (`id_category3`) REFERENCES `tb_categories` (`id_category`);

--
-- Filtros para la tabla `tb_cars`
--
ALTER TABLE `tb_cars`
  ADD CONSTRAINT `fk_cars_brands` FOREIGN KEY (`id_brand`) REFERENCES `tb_brands` (`id_brand`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
