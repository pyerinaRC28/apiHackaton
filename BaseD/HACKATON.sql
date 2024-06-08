-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2024 a las 23:28:12
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
-- Base de datos: `hackaton`
--
CREATE DATABASE IF NOT EXISTS `hackaton` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hackaton`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `alumno` char(9) NOT NULL,
  `merch` int(11) NOT NULL,
  `f_ingreso` date NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `alumno`, `merch`, `f_ingreso`, `estado`) VALUES
(1, 'u20210943', 4, '2024-06-08', 'Por recoger'),
(2, 'u20213914', 2, '2024-06-07', 'Entregado'),
(3, 'u20201451', 1, '2024-06-08', 'Por recoger');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `store`
--

CREATE TABLE `store` (
  `cod_prod` int(3) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `Precio` int(4) NOT NULL,
  `stock` int(11) NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `store`
--

INSERT INTO `store` (`cod_prod`, `nombre`, `Precio`, `stock`, `img`) VALUES
(1, 'Lapicero UTP', 1400, 1, '/tienda/1.png'),
(2, 'Libreta Innova', 3400, 0, '/tienda/4.png'),
(3, 'Polo Aprende UTP', 6400, 12, '/tienda/2.png'),
(4, 'Gorra UTP', 5000, 15, '/tienda/3.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `cod_alumno` char(9) NOT NULL,
  `contrasena` varchar(30) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `sede` varchar(25) NOT NULL,
  `modalidad` varchar(10) NOT NULL,
  `puntaje` int(2) NOT NULL,
  `monedas` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`cod_alumno`, `contrasena`, `nombre`, `sede`, `modalidad`, `puntaje`, `monedas`) VALUES
('u20201451', '123qwe+', 'Ana', 'Chiclayo', '80-20', 0, 0),
('u20202831', '123qwe+', 'Sebastian', 'Huancayo', 'Presencial', 0, 0),
('u20210943', '123qwe+', 'Yeicot', 'Ica', '50-50', 0, 0),
('u20213914', '123qwe+', 'Pyerina', 'Piura', '80-20', 0, 0),
('u20229373', '123qwe+J', 'Jeremy', 'Lima Centro', 'Presencial', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `alumno` (`alumno`),
  ADD KEY `merch` (`merch`);

--
-- Indices de la tabla `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`cod_prod`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`cod_alumno`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `store`
--
ALTER TABLE `store`
  MODIFY `cod_prod` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `alumno` FOREIGN KEY (`alumno`) REFERENCES `user` (`cod_alumno`),
  ADD CONSTRAINT `merch` FOREIGN KEY (`merch`) REFERENCES `store` (`cod_prod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
