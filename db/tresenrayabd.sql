-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2018 a las 13:18:10
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tresenrayabd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `id` int(11) NOT NULL,
  `player1` int(11) NOT NULL,
  `player2` int(11) DEFAULT NULL,
  `c0` int(11) NOT NULL,
  `c1` int(11) NOT NULL,
  `c2` int(11) NOT NULL,
  `c3` int(11) NOT NULL,
  `c4` int(11) NOT NULL,
  `c5` int(11) NOT NULL,
  `c6` int(11) NOT NULL,
  `c7` int(11) NOT NULL,
  `c8` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `turno` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `partidas`
--

INSERT INTO `partidas` (`id`, `player1`, `player2`, `c0`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`, `c7`, `c8`, `estado`, `turno`) VALUES
(39, 6, 4, 4, 6, 6, 4, 4, 6, 4, 6, 4, 4, 1),
(40, 6, 7, 6, 6, 7, 6, 7, 0, 7, 0, 0, 7, 2),
(42, 4, 1, 4, 1, 1, 4, 1, 1, 4, 1, 1, 1, 1),
(44, 7, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(45, 4, 8, 8, 0, 4, 8, 4, 4, 8, 0, 0, 8, 1),
(46, 4, 1, 4, 4, 1, 4, 1, 0, 0, 0, 0, 0, 1),
(47, 1, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2),
(48, 4, 8, 4, 8, 8, 8, 8, 4, 4, 4, 8, 0, 1),
(49, 4, 1, 4, 4, 4, 1, 4, 1, 4, 4, 1, 4, 2),
(50, 4, 1, 4, 4, 4, 0, 1, 0, 0, 1, 0, 4, 2),
(51, 4, 1, 4, 4, 4, 1, 1, 1, 4, 0, 0, 1, 2),
(52, 4, 1, 4, 1, 1, 1, 4, 4, 4, 1, 1, 0, 1),
(53, 4, 1, 1, 4, 4, 1, 1, 4, 1, 1, 4, 4, 1),
(54, 1, 4, 4, 0, 1, 4, 1, 4, 1, 4, 1, 1, 2),
(55, 1, 4, 4, 1, 4, 4, 1, 0, 4, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `pass` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `pass`) VALUES
(1, 'Paco Johnson', 'pjohnson', 'abc123.'),
(4, 'Pedro Pablos', 'ppablos', 'abc123.'),
(6, 'Jaime Alonso', 'jalonso', 'abc123.'),
(7, 'Lidia Ramirez', 'lramirez', 'abc123.'),
(8, 'Tomas', 'Tomas', '1234');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `partidas`
--
ALTER TABLE `partidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
