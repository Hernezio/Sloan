-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2021 at 04:18 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id16522369_proyectosloan`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `buscarDetDevolucion` (IN `id` INT(10))  NO SQL
SELECT * FROM det_devolucion WHERE det_devolucion.id_det_devolucion = id$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `buscarDevolucion` (IN `id_devolucion` INT(100))  NO SQL
SELECT * FROM devoluciones WHERE devoluciones.id_devolucion = id_devolucion$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `buscarIncidencia` (IN `id` INT(100))  NO SQL
SELECT * FROM incidencias WHERE incidencias.id_incidencia = id$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `carnet_id` (IN `carnet` INT(100))  NO SQL
SELECT usuarios.numero_carnet FROM usuarios WHERE usuarios.numero_carnet = carnet$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `codigo_barras` (IN `codigo` INT(100))  NO SQL
SELECT articulos.id_articulo FROM articulos WHERE articulos.codigo_barras = codigo$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `confirmar_dev` (IN `idU` INT(100), IN `idArt` INT(100))  NO SQL
SELECT * FROM prestamos WHERE id_usuario = idU AND id_articulo = idArt ORDER BY id_prestamo$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `det_devolucion` (IN `ide_dev` INT(100))  NO SQL
INSERT INTO `det_devolucion` (`id_det_devolucion`, `id_devolucion`, `fecha_devolucion`, `hora_devolucion`) VALUES (NULL, ide_dev, NOW(), NOW())$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `D_nombre` (IN `id` INT(100), IN `idA` INT(100))  NO SQL
SELECT 
	usuarios.nombre , 
	usuarios.apellido, 
    usuarios.numero_carnet, 
    articulos.nombre_articulo, 
    articulos.codigo_barras 
FROM usuarios, articulos 
WHERE usuarios.id_usuario = id AND articulos.id_articulo = idA$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `estado_prestamo` (IN `est` INT(100), IN `id_art` INT(100))  NO SQL
UPDATE `articulos` SET `disponibilidad` = est WHERE `articulos`.`id_articulo` = id_art$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `estado_usuario` (IN `estado` INT(100), IN `idU` INT(100))  NO SQL
UPDATE `usuarios` SET `estado_usuario` = estado WHERE `usuarios`.`id_usuario` = idU$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `p_nombre` (IN `id` INT(100), IN `ida` INT)  NO SQL
SELECT usuarios.nombre , usuarios.apellido, usuarios.numero_carnet, articulos.nombre_articulo, articulos.codigo_barras FROM usuarios, articulos  WHERE usuarios.id_usuario = id AND articulos.id_articulo = idA$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `selectIncidencias` ()  NO SQL
SELECT * FROM incidencias ORDER BY incidencias.id_incidencia DESC$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `selectUsuario` (IN `_numero_carnet` VARCHAR(30))  NO SQL
SELECT usuarios.id_usuario FROM usuarios WHERE usuarios.numero_carnet = _numero_carnet OR usuarios.nombre = _numero_carnet$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `select_detdev` (IN `id` INT(100))  NO SQL
SELECT * FROM det_devolucion  WHERE det_devolucion.id_devolucion = id ORDER BY id_devolucion ASC$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `select_detprest` (IN `id` INT(100))  NO SQL
SELECT * FROM det_prestamo  WHERE det_prestamo.id_prestamo = id ORDER BY id_prestamo DESC$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `select_perfiles` (IN `tip_user` INT(100))  NO SQL
SELECT * FROM perfiles WHERE perfiles.id_perfil = tip_user$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `spBuscarArticulo` (IN `_codigo_barras` VARCHAR(30))  NO SQL
SELECT articulos.id_articulo FROM articulos WHERE articulos.codigo_barras = _codigo_barras OR articulos.nombre_articulo = _codigo_barras$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `spBuscarPrestamo` (IN `_id_usuario` INT(11))  NO SQL
SELECT * FROM prestamos WHERE prestamos.id_usuario = _id_usuario OR prestamos.id_articulo = _id_usuario$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `spBuscarUsuarioCarnet` (IN `_carnet` VARCHAR(100))  NO SQL
SELECT usuarios.estado_usuario FROM usuarios WHERE usuarios.numero_carnet =_carnet$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `spCrearDetallePrestamo` (IN `ide_prest` INT(100))  NO SQL
INSERT INTO `det_prestamo` (`id_det_prestamo`, `id_prestamo`, `fecha_prestamo`, `hora_prestamo`) VALUES (NULL, ide_prest, NOW(), NOW())$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `spCrearDevolucion` (IN `idUser` INT(100), IN `idArt` INT(100))  NO SQL
INSERT INTO `devoluciones` (`id_devolucion`, `id_usuario`, `id_articulo`) VALUES (NULL, idUser, idArt)$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `spCrearPrestamos` (IN `idUser` INT(100), IN `idArt` INT(100))  NO SQL
INSERT INTO `prestamos` (`id_prestamo`, `id_usuario`, `id_articulo`) VALUES (NULL, idUser, idArt)$$

CREATE DEFINER=`id16522369_root`@`%` PROCEDURE `spGenerarInforme` (IN `_id_incidencia` INT(11))  NO SQL
SELECT * FROM incidencias WHERE incidencias.id_incidencia = _id_incidencia$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `articulos`
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
-- Dumping data for table `articulos`
--

INSERT INTO `articulos` (`id_articulo`, `categoria`, `nombre_articulo`, `descripcion`, `codigo_barras`, `disponibilidad`, `estado`) VALUES
(27, 1, ' Portatil Prueba', ' Accer', ' 7880', 2, 1),
(28, 1, 'Pc gammer', 'Genius', '7881', 2, 1),
(32, 2, 'Video proyector', 'z-500', '7882', 2, 1),
(33, 3, 'Mouse', 'Inalambrico', '7883', 1, 1),
(34, 2, 'Video Veams', 'Home\'s', '7884', 1, 1),
(35, 3, 'Impresora', 'Enpolvis 5000', '45005', 2, 1),
(36, 1, 'Pc Uno', '555', '585', 1, 1),
(37, 2, 'pc dos', '2322', '555', 1, 1),
(38, 2, 'Pc tres', '5685', '458', 1, 1),
(39, 3, 'Pc cuatro', '458', 'jejej', 2, 1),
(40, 2, 'Pc cinco', '5895', 'jsjsj', 1, 1),
(41, 2, 'Noslasco', '458', '4555', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Computadoras'),
(2, 'Video Beans'),
(3, 'Accesorios');

-- --------------------------------------------------------

--
-- Table structure for table `det_devolucion`
--

CREATE TABLE `det_devolucion` (
  `id_det_devolucion` int(11) NOT NULL,
  `id_devolucion` int(11) NOT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  `hora_devolucion` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `det_devolucion`
--

INSERT INTO `det_devolucion` (`id_det_devolucion`, `id_devolucion`, `fecha_devolucion`, `hora_devolucion`) VALUES
(40, 46, '2021-04-04', '18:57:11'),
(41, 47, '2021-04-04', '18:57:39'),
(42, 48, '2021-04-04', '18:57:58'),
(43, 49, '2021-04-07', '00:27:35'),
(44, 50, '2021-04-07', '15:11:28'),
(45, 51, '2021-04-10', '16:38:23'),
(46, 52, '2021-04-10', '16:41:50'),
(47, 53, '2021-04-10', '16:59:22'),
(48, 54, '2021-04-11', '14:54:08');

-- --------------------------------------------------------

--
-- Table structure for table `det_prestamo`
--

CREATE TABLE `det_prestamo` (
  `id_det_prestamo` int(11) NOT NULL,
  `id_prestamo` int(11) NOT NULL,
  `fecha_Prestamo` date NOT NULL,
  `hora_prestamo` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `det_prestamo`
--

INSERT INTO `det_prestamo` (`id_det_prestamo`, `id_prestamo`, `fecha_Prestamo`, `hora_prestamo`) VALUES
(66, 66, '2021-04-04', '18:54:30'),
(67, 67, '2021-04-04', '18:55:02'),
(68, 68, '2021-04-04', '18:55:30'),
(69, 69, '2021-04-07', '00:27:03'),
(70, 70, '2021-04-07', '15:11:04'),
(71, 71, '2021-04-07', '15:18:32'),
(72, 72, '2021-04-10', '16:34:00'),
(73, 73, '2021-04-10', '16:39:04'),
(74, 74, '2021-04-10', '16:58:21'),
(75, 75, '2021-04-10', '17:00:17'),
(76, 76, '2021-04-10', '17:00:49'),
(77, 77, '2021-04-10', '17:03:15'),
(78, 78, '2021-04-11', '14:53:28'),
(79, 79, '2021-04-11', '15:07:20'),
(80, 80, '2021-04-11', '15:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `devoluciones`
--

CREATE TABLE `devoluciones` (
  `id_devolucion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `devoluciones`
--

INSERT INTO `devoluciones` (`id_devolucion`, `id_usuario`, `id_articulo`) VALUES
(46, 40, 27),
(47, 42, 28),
(48, 43, 32),
(49, 40, 35),
(50, 40, 35),
(51, 53, 39),
(52, 53, 39),
(53, 40, 33),
(54, 53, 41);

-- --------------------------------------------------------

--
-- Table structure for table `disponibles`
--

CREATE TABLE `disponibles` (
  `id_disponible` int(11) NOT NULL,
  `nombre_disponible` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disponibles`
--

INSERT INTO `disponibles` (`id_disponible`, `nombre_disponible`) VALUES
(1, 'Disponible'),
(2, 'Ocupado');

-- --------------------------------------------------------

--
-- Table structure for table `estados`
--

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estados`
--

INSERT INTO `estados` (`id_estado`, `nombre_estado`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Table structure for table `incidencias`
--

CREATE TABLE `incidencias` (
  `id_incidencia` int(11) NOT NULL,
  `id_det_devolucion` int(11) NOT NULL,
  `tipo_incidencia` int(11) NOT NULL,
  `observaciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `incidencias`
--

INSERT INTO `incidencias` (`id_incidencia`, `id_det_devolucion`, `tipo_incidencia`, `observaciones`) VALUES
(10, 40, 1, 'Lo dejo caer y se rompio'),
(11, 41, 2, 'Se lo llevo en el carro nocturno'),
(12, 42, 1, 'Rayo la pantalla con lapiz'),
(13, 46, 1, 'Se cierra excel');

-- --------------------------------------------------------

--
-- Table structure for table `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` int(11) NOT NULL,
  `nombre_perfil` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `perfiles`
--

INSERT INTO `perfiles` (`id_perfil`, `nombre_perfil`) VALUES
(1, 'Administrador'),
(2, 'Monitor'),
(3, 'Aprendiz'),
(4, 'Instructor');

-- --------------------------------------------------------

--
-- Table structure for table `prestamos`
--

CREATE TABLE `prestamos` (
  `id_prestamo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prestamos`
--

INSERT INTO `prestamos` (`id_prestamo`, `id_usuario`, `id_articulo`) VALUES
(66, 40, 27),
(67, 42, 28),
(68, 43, 32),
(69, 40, 35),
(70, 40, 35),
(71, 43, 35),
(72, 53, 39),
(73, 53, 39),
(74, 40, 33),
(75, 40, 27),
(76, 40, 28),
(77, 40, 32),
(78, 53, 41),
(79, 53, 41),
(80, 42, 39);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `numero_carnet` varchar(10) NOT NULL,
  `estado_usuario` int(1) NOT NULL,
  `contrasenia` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `tipo_usuario`, `nombre`, `apellido`, `numero_carnet`, `estado_usuario`, `contrasenia`) VALUES
(37, 2, ' Ferney', ' Montoya', '1010', 1, '1234'),
(38, 2, 'Sergio', 'Sanchez', '1020', 1, '5678'),
(40, 2, '      Laura', '      Gonzales', '1002', 1, '    '),
(42, 3, 'Sergio', 'Montoya', '1003', 2, NULL),
(43, 3, 'Jair', 'Martinez', '1004', 2, NULL),
(44, 3, 'Jhonatan', 'Ruiz', '1005', 1, NULL),
(45, 3, 'Juan', 'Ruiz', '1007', 1, NULL),
(46, 2, ' Tutorial', 'Ramirez', '1008', 1, ' 456'),
(49, 1, 'Elvis', 'Presley', '1220', 1, 'open'),
(50, 1, 'Sebastián', 'Uribe', '7898', 1, '4887'),
(51, 4, 'Juan David', 'Jimenez Jaramillo', '789000', 1, NULL),
(52, 2, 'Ana', 'Petite', '70563', 1, '1812'),
(53, 3, 'Yimi', 'Yomo', '471', 2, NULL),
(54, 3, 'ERIC ROBINSON ', 'ESPINOSA MENDOZA', '98714265', 1, '98714265'),
(55, 4, 'YURY MARITZA ', 'GALLEGO MONTOYA', '1020427643', 1, NULL),
(56, 1, ' JULIAN ANDRES', ' MENDOZA CARVAJAL', '1017168667', 1, ' ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_articulo`),
  ADD UNIQUE KEY `codigo_barras` (`codigo_barras`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `estado` (`estado`),
  ADD KEY `disponibilidad` (`disponibilidad`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `det_devolucion`
--
ALTER TABLE `det_devolucion`
  ADD PRIMARY KEY (`id_det_devolucion`),
  ADD KEY `id_devolucion` (`id_devolucion`);

--
-- Indexes for table `det_prestamo`
--
ALTER TABLE `det_prestamo`
  ADD PRIMARY KEY (`id_det_prestamo`),
  ADD KEY `id_prestamo` (`id_prestamo`) USING BTREE;

--
-- Indexes for table `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD PRIMARY KEY (`id_devolucion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_articulo` (`id_articulo`);

--
-- Indexes for table `disponibles`
--
ALTER TABLE `disponibles`
  ADD PRIMARY KEY (`id_disponible`);

--
-- Indexes for table `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indexes for table `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD UNIQUE KEY `id_det_devolucion_2` (`id_det_devolucion`),
  ADD KEY `id_det_devolucion` (`id_det_devolucion`),
  ADD KEY `tipo_incidencia` (`tipo_incidencia`) USING BTREE,
  ADD KEY `tipo_incidencia_2` (`tipo_incidencia`);

--
-- Indexes for table `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indexes for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_articulo` (`id_articulo`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `numero_carnet` (`numero_carnet`),
  ADD KEY `tipo_usuario` (`tipo_usuario`),
  ADD KEY `estado_usuario` (`estado_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id_articulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `det_devolucion`
--
ALTER TABLE `det_devolucion`
  MODIFY `id_det_devolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `det_prestamo`
--
ALTER TABLE `det_prestamo`
  MODIFY `id_det_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `devoluciones`
--
ALTER TABLE `devoluciones`
  MODIFY `id_devolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `articulos_ibfk_2` FOREIGN KEY (`estado`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `articulos_ibfk_3` FOREIGN KEY (`disponibilidad`) REFERENCES `disponibles` (`id_disponible`);

--
-- Constraints for table `det_devolucion`
--
ALTER TABLE `det_devolucion`
  ADD CONSTRAINT `det_devolucion_ibfk_1` FOREIGN KEY (`id_devolucion`) REFERENCES `devoluciones` (`id_devolucion`);

--
-- Constraints for table `det_prestamo`
--
ALTER TABLE `det_prestamo`
  ADD CONSTRAINT `det_prestamo_ibfk_1` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamos` (`id_prestamo`);

--
-- Constraints for table `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD CONSTRAINT `devoluciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `devoluciones_ibfk_2` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`id_articulo`);

--
-- Constraints for table `incidencias`
--
ALTER TABLE `incidencias`
  ADD CONSTRAINT `incidencias_ibfk_1` FOREIGN KEY (`id_det_devolucion`) REFERENCES `det_devolucion` (`id_det_devolucion`);

--
-- Constraints for table `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`id_articulo`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_usuario`) REFERENCES `perfiles` (`id_perfil`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`estado_usuario`) REFERENCES `estados` (`id_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
