-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-02-2020 a las 00:12:19
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tdg`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambios`
--

CREATE TABLE `cambios` (
  `modulo` double NOT NULL,
  `cambios` double NOT NULL,
  `noResueltos` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cambios`
--

INSERT INTO `cambios` (`modulo`, `cambios`, `noResueltos`) VALUES
(3, 18, 6),
(2, 14, 2),
(1, 26, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costo`
--

CREATE TABLE `costo` (
  `proceso` double NOT NULL,
  `esfuerzo` double NOT NULL,
  `costo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `costo`
--

INSERT INTO `costo` (`proceso`, `esfuerzo`, `costo`) VALUES
(1, 8, 1000),
(2, 4, 2000),
(3, 6, 1000),
(4, 7, 1000),
(5, 3, 3000),
(6, 2, 5000),
(7, 11, 1000),
(8, 10, 1000),
(8, 5, 2000),
(9, 5, 2000),
(10, 2, 2000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `errores`
--

CREATE TABLE `errores` (
  `modulo` double NOT NULL,
  `defectos` double NOT NULL,
  `tamano` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `errores`
--

INSERT INTO `errores` (`modulo`, `defectos`, `tamano`) VALUES
(1, 19, 430),
(2, 8, 380),
(3, 3, 134),
(4, 6, 369),
(5, 9, 436),
(6, 4, 165),
(7, 2, 112),
(8, 4, 329),
(9, 12, 500),
(10, 8, 324),
(11, 6, 391),
(12, 6, 346),
(13, 2, 125),
(14, 8, 503),
(15, 8, 250),
(16, 3, 312),
(17, 12, 419),
(18, 6, 403),
(19, 3, 150),
(20, 6, 344),
(21, 11, 396),
(22, 2, 204),
(23, 8, 478),
(24, 2, 132),
(25, 5, 249),
(26, 10, 435);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esfuerzo_dias`
--

CREATE TABLE `esfuerzo_dias` (
  `dia` double NOT NULL,
  `horas` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `esfuerzo_dias`
--

INSERT INTO `esfuerzo_dias` (`dia`, `horas`) VALUES
(1, 1),
(2, 3),
(3, 1),
(4, 2),
(5, 2.9),
(6, 3),
(7, 2.8),
(8, 3),
(9, 2.7),
(10, 3),
(11, 2.8),
(12, 3),
(13, 1),
(14, 3),
(15, 1),
(16, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esfuerzo_semanas`
--

CREATE TABLE `esfuerzo_semanas` (
  `semana` double NOT NULL,
  `lunes` double NOT NULL,
  `martes` double NOT NULL,
  `miercoles` double NOT NULL,
  `jueves` double NOT NULL,
  `viernes` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `esfuerzo_semanas`
--

INSERT INTO `esfuerzo_semanas` (`semana`, `lunes`, `martes`, `miercoles`, `jueves`, `viernes`) VALUES
(4, 46.3, 45.2, 48.1, 45.7, 44.1),
(16, 47.3, 49.7, 48, 42, 41),
(15, 50, 46.2, 47.4, 42.2, 47),
(14, 52.3, 45.2, 42.2, 44.8, 42.8),
(1, 50.5, 43.5, 45.5, 39.8, 42.9),
(2, 44.3, 44.9, 42.9, 39.8, 39.3),
(3, 48.8, 51, 44.3, 43, 51.3),
(5, 40.6, 45.7, 51.9, 47.3, 46.4),
(6, 44.4, 49, 47.9, 45.5, 44.8),
(7, 46, 41.1, 44.1, 41.8, 47.9),
(8, 44.9, 43.4, 49, 49.5, 47.4),
(9, 50, 49, 42.6, 41.7, 38.5),
(10, 44.5, 46.5, 41.7, 42.6, 41.7),
(11, 43.8, 41.8, 45.5, 44.5, 38.6),
(12, 37.2, 43.8, 44.8, 43.5, 40.9),
(13, 50, 43.4, 48.3, 46.4, 43.4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pruebas`
--

CREATE TABLE `pruebas` (
  `modulo` double NOT NULL,
  `pruebas` double NOT NULL,
  `noAprobadas` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pruebas`
--

INSERT INTO `pruebas` (`modulo`, `pruebas`, `noAprobadas`) VALUES
(1, 10, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requerimientos`
--

CREATE TABLE `requerimientos` (
  `modulo` double NOT NULL,
  `requerimientos` double NOT NULL,
  `noResueltos` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `requerimientos`
--

INSERT INTO `requerimientos` (`modulo`, `requerimientos`, `noResueltos`) VALUES
(1, 10, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempo`
--

CREATE TABLE `tiempo` (
  `proceso` double NOT NULL,
  `nombre` text NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_trabajo_db`
--

CREATE TABLE `unidades_trabajo_db` (
  `modulo` double NOT NULL,
  `sloc` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidades_trabajo_db`
--

INSERT INTO `unidades_trabajo_db` (`modulo`, `sloc`) VALUES
(1, 1000),
(2, 3000),
(3, 6000),
(4, 5000),
(5, 6000),
(6, 2000),
(7, 1000),
(8, 1000),
(9, 1000),
(10, 1000);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
