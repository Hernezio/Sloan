-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-03-2021 a las 20:43:56
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectosloan`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarDetDevolucion` (IN `id` INT(10))  NO SQL
SELECT * FROM det_devolucion WHERE det_devolucion.id_det_devolucion = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarDevolucion` (IN `id_devolucion` INT(100))  NO SQL
SELECT * FROM devoluciones WHERE devoluciones.id_devolucion = id_devolucion$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscarIncidencia` (IN `id` INT(100))  NO SQL
SELECT * FROM incidencias WHERE incidencias.id_incidencia = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `carnet_id` (IN `carnet` INT(100))  NO SQL
SELECT * FROM usuarios WHERE usuarios.numero_carnet = carnet$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `codigo_barras` (IN `codigo` INT(100))  NO SQL
SELECT * FROM articulos WHERE articulos.codigo_barras = codigo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `confirmarInicioSesion` (IN `id` INT(10))  NO SQL
SELECT usuarios.sesion FROM usuarios WHERE usuarios.numero_carnet = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `confirmar_dev` (IN `idU` INT(100), IN `idArt` INT(100))  NO SQL
SELECT * FROM prestamos WHERE id_usuario = idU AND id_articulo = idArt ORDER BY id_prestamo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `detalle_prestamo` (IN `ide_prest` INT(100))  NO SQL
INSERT INTO `det_prestamo` (`id_det_prestamo`, `id_prestamo`, `fecha_prestamo`, `hora_prestamo`) VALUES (NULL, ide_prest, NOW(), NOW())$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `det_devolucion` (IN `ide_dev` INT(100))  NO SQL
INSERT INTO `det_devolucion` (`id_det_devolucion`, `id_devolucion`, `fecha_devolucion`, `hora_devolucion`) VALUES (NULL, ide_dev, NOW(), NOW())$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `devolucion` (IN `idUser` INT(100), IN `idArt` INT(100))  NO SQL
INSERT INTO `devoluciones` (`id_devolucion`, `id_usuario`, `id_articulo`) VALUES (NULL, idUser, idArt)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `D_nombre` (IN `id` INT(100), IN `idA` INT(100))  NO SQL
SELECT usuarios.nombre , usuarios.apellido, usuarios.numero_carnet, articulos.nombre_articulo, articulos.codigo_barras FROM usuarios, articulos  WHERE usuarios.id_usuario = id AND articulos.id_articulo = idA$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `estado_prestamo` (IN `est` INT(100), IN `id_art` INT(100))  NO SQL
UPDATE `articulos` SET `disponibilidad` = est WHERE `articulos`.`id_articulo` = id_art$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `estado_usuario` (IN `estado` INT(100), IN `idU` INT(100))  NO SQL
UPDATE `usuarios` SET `estado_usuario` = estado WHERE `usuarios`.`id_usuario` = idU$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inicioSesion` (IN `sesion` VARCHAR(10), IN `id` VARCHAR(10))  NO SQL
UPDATE usuarios SET usuarios.sesion = sesion WHERE usuarios.numero_carnet = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prestamos` (IN `idUser` INT(100), IN `idArt` INT(100))  NO SQL
INSERT INTO `prestamos` (`id_prestamo`, `id_usuario`, `id_articulo`) VALUES (NULL, idUser, idArt)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p_nombre` (IN `id` INT(100), IN `ida` INT)  NO SQL
SELECT usuarios.nombre , usuarios.apellido, usuarios.numero_carnet, articulos.nombre_articulo, articulos.codigo_barras FROM usuarios, articulos  WHERE usuarios.id_usuario = id AND articulos.id_articulo = idA$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectIncidencias` ()  NO SQL
SELECT * FROM incidencias ORDER BY incidencias.id_incidencia$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_detdev` (IN `id` INT(100))  NO SQL
SELECT * FROM det_devolucion  WHERE det_devolucion.id_devolucion = id ORDER BY id_devolucion ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_detprest` (IN `id` INT(100))  NO SQL
SELECT * FROM det_prestamo  WHERE det_prestamo.id_prestamo = id ORDER BY id_prestamo ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_perfiles` (IN `tip_user` INT(100))  NO SQL
SELECT * FROM perfiles WHERE perfiles.id_perfil = tip_user$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGenerarInforme` (IN `_id_incidencia` INT(11))  NO SQL
SELECT * FROM incidencias WHERE incidencias.id_incidencia = _id_incidencia$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id_articulo` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `nombre_articulo` varchar(20) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  `codigo_barras` varchar(10) NOT NULL,
  `disponibilidad` int(11) NOT NULL DEFAULT 1,
  `estado` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_articulo`, `categoria`, `nombre_articulo`, `descripcion`, `codigo_barras`, `disponibilidad`, `estado`) VALUES
(1, 3, '  HDMI', '  Latigazo 2000', '  650600', 2, 1),
(2, 2, 'PC Portatil', 'Accer 255i', '20001', 1, 1),
(3, 2, 'Pc Portatil Prueba', 'Accer S34i', '100032', 1, 1),
(4, 2, 'Pc Portatil Prueba 2', 'Epson H890', '1002366', 1, 1),
(5, 1, 'Video Beans', 'Hp X500', '44444', 1, 1),
(9, 3, ' Modem', ' hawei blanco', ' 12345', 1, 1),
(10, 3, 'Servidor Linux', '45599', '4555', 1, 1),
(12, 1, 'Computadora', 'Acer', '1101', 1, 1),
(13, 1, '  Pc gammer', '  Acer', '  1122', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Computadoras'),
(2, 'Video Beans'),
(3, 'Accesorios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_devolucion`
--

CREATE TABLE `det_devolucion` (
  `id_det_devolucion` int(11) NOT NULL,
  `id_devolucion` int(11) NOT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  `hora_devolucion` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `det_devolucion`
--

INSERT INTO `det_devolucion` (`id_det_devolucion`, `id_devolucion`, `fecha_devolucion`, `hora_devolucion`) VALUES
(99, 109, '2021-02-05', '20:53:49'),
(100, 110, '2021-02-05', '20:58:02'),
(101, 111, '2021-02-05', '20:58:11'),
(102, 112, '2021-02-05', '20:58:20'),
(103, 113, '2021-02-05', '20:59:09'),
(104, 114, '2021-02-05', '21:00:45'),
(105, 115, '2021-02-05', '21:02:13'),
(106, 116, '2021-02-05', '21:02:39'),
(107, 117, '2021-02-06', '10:12:22'),
(108, 118, '2021-02-06', '10:52:45'),
(109, 119, '2021-02-06', '10:52:45'),
(110, 120, '2021-02-06', '10:52:48'),
(111, 121, '2021-02-06', '10:56:23'),
(112, 122, '2021-02-08', '12:58:11'),
(113, 123, '2021-02-08', '13:05:34'),
(114, 124, '2021-02-08', '13:07:15'),
(115, 125, '2021-02-08', '13:07:40'),
(116, 126, '2021-02-09', '12:18:01'),
(117, 127, '2021-02-09', '12:18:19'),
(118, 128, '2021-02-09', '12:19:09'),
(119, 129, '2021-02-09', '12:20:01'),
(120, 130, '2021-02-09', '12:21:16'),
(121, 131, '2021-02-09', '12:54:11'),
(122, 132, '2021-02-09', '12:54:33'),
(123, 133, '2021-02-09', '12:54:52'),
(124, 134, '2021-02-09', '12:58:15'),
(125, 135, '2021-02-09', '12:58:29'),
(126, 136, '2021-02-09', '15:33:50'),
(127, 137, '2021-02-09', '16:14:57'),
(128, 138, '2021-02-09', '16:20:15'),
(129, 139, '2021-02-10', '16:31:08'),
(130, 140, '2021-02-10', '16:34:33'),
(131, 141, '2021-02-15', '16:39:48'),
(132, 142, '2021-02-15', '21:50:02'),
(133, 143, '2021-02-15', '21:53:21'),
(134, 144, '2021-02-15', '21:53:40'),
(135, 145, '2021-02-19', '15:27:49'),
(136, 146, '2021-02-21', '13:27:36'),
(137, 147, '2021-02-26', '17:24:11'),
(138, 148, '2021-02-26', '23:19:20'),
(139, 149, '2021-02-27', '11:08:01'),
(140, 150, '2021-03-02', '09:06:15'),
(141, 151, '2021-03-17', '20:10:17'),
(142, 152, '2021-03-17', '20:10:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_prestamo`
--

CREATE TABLE `det_prestamo` (
  `id_det_prestamo` int(11) NOT NULL,
  `id_prestamo` int(11) NOT NULL,
  `fecha_Prestamo` date NOT NULL,
  `hora_prestamo` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `det_prestamo`
--

INSERT INTO `det_prestamo` (`id_det_prestamo`, `id_prestamo`, `fecha_Prestamo`, `hora_prestamo`) VALUES
(4, 75, '2021-02-09', '13:14:51'),
(5, 76, '2021-02-09', '14:54:13'),
(6, 77, '2021-02-09', '16:19:18'),
(7, 78, '2021-02-09', '16:26:47'),
(8, 79, '2021-02-10', '16:32:35'),
(9, 80, '2021-02-15', '16:13:08'),
(10, 81, '2021-02-15', '16:54:01'),
(11, 82, '2021-02-15', '16:54:57'),
(12, 83, '2021-02-15', '16:56:52'),
(13, 84, '2021-02-16', '08:06:05'),
(14, 85, '2021-02-16', '11:27:26'),
(15, 86, '2021-02-19', '15:26:29'),
(16, 87, '2021-02-20', '19:24:46'),
(17, 88, '2021-02-21', '12:48:08'),
(18, 89, '2021-02-27', '11:33:47'),
(19, 90, '2021-02-27', '11:44:43'),
(20, 91, '2021-03-02', '09:04:11'),
(21, 92, '2021-03-17', '21:43:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

CREATE TABLE `devoluciones` (
  `id_devolucion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `devoluciones`
--

INSERT INTO `devoluciones` (`id_devolucion`, `id_usuario`, `id_articulo`) VALUES
(109, 1, 1),
(110, 1, 1),
(111, 2, 2),
(112, 1, 4),
(113, 1, 1),
(114, 3, 1),
(115, 1, 2),
(116, 3, 2),
(117, 1, 4),
(118, 1, 1),
(119, 1, 1),
(120, 1, 1),
(121, 1, 1),
(122, 2, 5),
(123, 1, 2),
(124, 7, 3),
(125, 8, 4),
(126, 1, 1),
(127, 7, 4),
(128, 7, 2),
(129, 2, 3),
(130, 1, 5),
(131, 8, 5),
(132, 7, 2),
(133, 1, 1),
(134, 7, 4),
(135, 1, 1),
(136, 1, 2),
(137, 3, 4),
(138, 8, 1),
(139, 8, 5),
(140, 8, 1),
(141, 1, 1),
(142, 3, 3),
(143, 7, 5),
(144, 7, 9),
(145, 1, 9),
(146, 7, 4),
(147, 8, 1),
(148, 7, 2),
(149, 1, 3),
(150, 12, 3),
(151, 8, 2),
(152, 7, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibles`
--

CREATE TABLE `disponibles` (
  `id_disponible` int(11) NOT NULL,
  `nombre_disponible` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `disponibles`
--

INSERT INTO `disponibles` (`id_disponible`, `nombre_disponible`) VALUES
(1, 'Disponible'),
(2, 'Ocupado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `nombre_estado`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencias`
--

CREATE TABLE `incidencias` (
  `id_incidencia` int(11) NOT NULL,
  `id_det_devolucion` int(11) NOT NULL,
  `tipo_incidencia` int(11) NOT NULL,
  `observaciones` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `incidencias`
--

INSERT INTO `incidencias` (`id_incidencia`, `id_det_devolucion`, `tipo_incidencia`, `observaciones`) VALUES
(1, 107, 1, 'Dejo caer el articulo y se le daño la pantall'),
(2, 113, 2, 'Lo boto\r\n'),
(4, 115, 0, 'Salio del establecimiento y jamas devolvio el articulo'),
(5, 106, 1, 'Le dio rabia y lo arrojo contra la pared'),
(6, 134, 2, 'Se lo llevo en su automovil'),
(7, 99, 1, 'Le dio un golpe a su compaÃ±ero con el artÃ­culo'),
(8, 109, 1, 'Se resbalo'),
(9, 99, 2, 'Salio con el'),
(10, 106, 1, 'Salio del centro con el en el carro'),
(11, 117, 0, 'Le derramo un refresco en el teclado'),
(12, 111, 2, 'Lo empaco en un bolsillo escondido de su bolso y saco el articulo de la institucion'),
(13, 104, 1, 'It is a long established fact that a reader will be distracted by the readable content of a page whe'),
(14, 113, 2, 'Se fue\r\n'),
(15, 105, 2, 'Lo dejo en la Basura y se fue'),
(16, 101, 2, 'Se fue con el'),
(17, 118, 2, 'se le cayo por aguevado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` int(11) NOT NULL,
  `nombre_perfil` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id_perfil`, `nombre_perfil`) VALUES
(1, 'Administrador'),
(2, 'Monitor'),
(3, 'Aprendiz'),
(4, 'Instructor'),
(5, 'Portero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id_prestamo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id_prestamo`, `id_usuario`, `id_articulo`) VALUES
(44, 7, 4),
(45, 3, 1),
(46, 1, 1),
(47, 1, 1),
(48, 1, 1),
(49, 1, 1),
(50, 7, 2),
(51, 1, 1),
(52, 3, 1),
(53, 3, 1),
(54, 1, 2),
(55, 3, 2),
(56, 1, 2),
(57, 1, 4),
(58, 1, 4),
(59, 1, 3),
(60, 1, 5),
(61, 1, 1),
(62, 1, 2),
(63, 2, 3),
(64, 8, 4),
(65, 8, 4),
(66, 8, 4),
(67, 8, 4),
(68, 7, 1),
(69, 7, 5),
(70, 1, 1),
(71, 7, 2),
(72, 8, 5),
(73, 1, 1),
(74, 7, 4),
(75, 1, 2),
(76, 3, 4),
(77, 8, 1),
(78, 8, 5),
(79, 8, 1),
(80, 1, 1),
(81, 7, 9),
(82, 7, 5),
(83, 3, 3),
(84, 9, 2),
(85, 1, 1),
(86, 1, 9),
(87, 9, 3),
(88, 7, 4),
(89, 7, 5),
(90, 8, 2),
(91, 12, 3),
(92, 14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `numero_carnet` int(10) NOT NULL,
  `estado_usuario` int(1) NOT NULL,
  `contrasenia` varchar(10) DEFAULT NULL,
  `sesion` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `tipo_usuario`, `nombre`, `apellido`, `numero_carnet`, `estado_usuario`, `contrasenia`, `sesion`) VALUES
(1, 1, ' Alberto Faridss', ' Einstein Anchico', 1001, 1, '  1234', 'activo'),
(2, 2, 'Nicola', 'Tesla', 999000999, 1, 'Afura', '0'),
(3, 1, 'Ferney', 'Sanchez', 104073762, 1, 'Afura2', '0'),
(7, 3, 'Gay Bunny', 'Saldarriaga', 604060400, 1, 'Luian', '0'),
(8, 3, 'Mary', 'Hellen', 39382321, 1, 'RAP', '0'),
(9, 3, ' Sergio', ' Perez', 7546698, 1, ' Auteco', '0'),
(10, 3, 'Julieth Jimena', 'Sandoval Hernandez', 1255, 1, 'Jime', '0'),
(11, 4, 'Jose Luis', 'Guzman', 45899, 1, 'jj', '0'),
(12, 4, 'Mauricio', 'Paez', 455888, 1, NULL, '0'),
(13, 2, 'Fulanito', 'Uribe', 11000, 1, '555', '0'),
(14, 3, 'Jairo', 'Sabas', 145, 2, NULL, '0'),
(15, 5, 'Alveiro', 'Buitrago', 456, 1, NULL, '0');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_articulo`),
  ADD UNIQUE KEY `codigo_barras` (`codigo_barras`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `estado` (`estado`),
  ADD KEY `disponibilidad` (`disponibilidad`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `det_devolucion`
--
ALTER TABLE `det_devolucion`
  ADD PRIMARY KEY (`id_det_devolucion`),
  ADD KEY `id_devolucion` (`id_devolucion`);

--
-- Indices de la tabla `det_prestamo`
--
ALTER TABLE `det_prestamo`
  ADD PRIMARY KEY (`id_det_prestamo`),
  ADD KEY `id_prestamo` (`id_prestamo`) USING BTREE;

--
-- Indices de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD PRIMARY KEY (`id_devolucion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_articulo` (`id_articulo`);

--
-- Indices de la tabla `disponibles`
--
ALTER TABLE `disponibles`
  ADD PRIMARY KEY (`id_disponible`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD KEY `id_det_devolucion` (`id_det_devolucion`),
  ADD KEY `tipo_incidencia` (`tipo_incidencia`) USING BTREE,
  ADD KEY `tipo_incidencia_2` (`tipo_incidencia`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_articulo` (`id_articulo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `numero_carnet` (`numero_carnet`),
  ADD KEY `tipo_usuario` (`tipo_usuario`),
  ADD KEY `estado_usuario` (`estado_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id_articulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `det_devolucion`
--
ALTER TABLE `det_devolucion`
  MODIFY `id_det_devolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `det_prestamo`
--
ALTER TABLE `det_prestamo`
  MODIFY `id_det_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  MODIFY `id_devolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `articulos_ibfk_2` FOREIGN KEY (`estado`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `articulos_ibfk_3` FOREIGN KEY (`disponibilidad`) REFERENCES `disponibles` (`id_disponible`);

--
-- Filtros para la tabla `det_devolucion`
--
ALTER TABLE `det_devolucion`
  ADD CONSTRAINT `det_devolucion_ibfk_1` FOREIGN KEY (`id_devolucion`) REFERENCES `devoluciones` (`id_devolucion`);

--
-- Filtros para la tabla `det_prestamo`
--
ALTER TABLE `det_prestamo`
  ADD CONSTRAINT `det_prestamo_ibfk_1` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamos` (`id_prestamo`);

--
-- Filtros para la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD CONSTRAINT `devoluciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `devoluciones_ibfk_2` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`id_articulo`);

--
-- Filtros para la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD CONSTRAINT `incidencias_ibfk_1` FOREIGN KEY (`id_det_devolucion`) REFERENCES `det_devolucion` (`id_det_devolucion`);

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`id_articulo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_usuario`) REFERENCES `perfiles` (`id_perfil`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`estado_usuario`) REFERENCES `estados` (`id_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
