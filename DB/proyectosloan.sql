-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2021 at 09:31 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyectosloan`
--

DELIMITER $$
--
-- Procedures
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
SELECT * FROM incidencias ORDER BY incidencias.id_incidencia DESC$$

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
-- Table structure for table `articulos`
--

CREATE TABLE `articulos` (
  `id_articulo` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `nombre_articulo` varchar(20) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  `codigo_barras` varchar(10) NOT NULL,
  `disponibilidad` int(11) NOT NULL DEFAULT '1',
  `estado` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `devoluciones`
--

CREATE TABLE `devoluciones` (
  `id_devolucion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(4, 'Instructor'),
(5, 'Portero');

-- --------------------------------------------------------

--
-- Table structure for table `prestamos`
--

CREATE TABLE `prestamos` (
  `id_prestamo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
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
  MODIFY `id_articulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `det_devolucion`
--
ALTER TABLE `det_devolucion`
  MODIFY `id_det_devolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `det_prestamo`
--
ALTER TABLE `det_prestamo`
  MODIFY `id_det_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `devoluciones`
--
ALTER TABLE `devoluciones`
  MODIFY `id_devolucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
