-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2022 a las 18:38:46
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_extraescolares`
--
CREATE DATABASE IF NOT EXISTS `bd_extraescolares` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_extraescolares`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `sp_delete_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_departamento` (IN `d_id_departamento` INT)  BEGIN
	DELETE FROM departamento WHERE id_departamento=d_id_departamento;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_responsable` (IN `r_id_responsable` INT)  BEGIN
	DELETE FROM responsable WHERE id_responsable=r_id_responsable;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento` (IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12))  BEGIN
	INSERT INTO departamento(clave, nombre, ubicacion, extension) VALUES (d_clave,d_nombre,d_ubicacion,d_extension) ON DUPLICATE KEY UPDATE nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento_responsable` (IN `d_id` INT, IN `r_id` INT)  BEGIN
	IF 0 = (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id AND id_responsable=r_id AND fecha_fin IS NULL) THEN
		IF 0 < (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id AND id_responsable<>r_id AND fecha_fin IS NULL) THEN
        		UPDATE departamento_responsable SET fecha_fin=NOW() WHERE id_departamento=d_id AND fecha_fin IS NULL;
            		INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio) VALUES (d_id,r_id,NOW());
        	ELSE
			INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio) VALUES (d_id,r_id,NOW());
		END IF;         		
    	END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_periodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_periodo` (IN `p_nombre` VARCHAR(12), IN `p_fecha_i_a` DATE, IN `p_fecha_f_a` DATE, IN `p_fecha_i_i` DATE, IN `p_fecha_f_i` DATE)  BEGIN
	IF 0 = (SELECT COUNT(*) FROM periodo) THEN
    	INSERT INTO periodo (nombre, fecha_inicio_actividades, fecha_fin_actividades, fecha_inicio_inscripciones, fecha_fin_inscripciones) VALUES (p_nombre, p_fecha_i_a, p_fecha_f_a, p_fecha_i_i, p_fecha_f_i);
    ELSE
    	IF(CURDATE() > (SELECT fecha_fin_actividades FROM periodo ORDER BY id_periodo DESC LIMIT 1)) THEN
        	INSERT INTO periodo (nombre, fecha_inicio_actividades, fecha_fin_actividades, fecha_inicio_inscripciones, fecha_fin_inscripciones) VALUES (p_nombre, p_fecha_i_a, p_fecha_f_a, p_fecha_i_i, p_fecha_f_i);
        ELSE
        	UPDATE periodo SET nombre=p_nombre, fecha_inicio_actividades=p_fecha_i_a, fecha_fin_actividades=p_fecha_f_a, fecha_inicio_inscripciones=p_fecha_i_i, fecha_fin_inscripciones=p_fecha_f_i WHERE fecha_fin_actividades > CURDATE();
        END IF;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_responsable` (IN `r_clave` VARCHAR(10), IN `r_nombre` VARCHAR(150), IN `r_correo` VARCHAR(150))  BEGIN
	INSERT INTO responsable(clave, nombre, correo) VALUES (r_clave,r_nombre,r_correo) ON DUPLICATE KEY UPDATE nombre=r_nombre, correo=r_correo;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamentos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamentos` ()  BEGIN
	SELECT * FROM departamento;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamento_clave`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamento_clave` (IN `d_clave` VARCHAR(10))  BEGIN
	SELECT * FROM departamento WHERE clave=d_clave;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamento_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamento_id` (IN `d_id_departamento` INT)  BEGIN
	SELECT departamento.id_departamento, departamento.clave, departamento.nombre, departamento.ubicacion, departamento.extension, departamento_responsable.id_responsable, responsable.nombre AS nombre_responsable FROM departamento LEFT JOIN departamento_responsable ON departamento.id_departamento = departamento_responsable.id_departamento JOIN responsable ON responsable.id_responsable=departamento_responsable.id_responsable WHERE departamento.id_departamento=d_id_departamento AND departamento_responsable.fecha_fin IS NULL;
END$$

DROP PROCEDURE IF EXISTS `sp_select_periodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_periodo` ()  BEGIN
	SELECT * FROM periodo ORDER BY id_periodo DESC LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_programas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_programas` ()  BEGIN
	SELECT * FROM programa;
END$$

DROP PROCEDURE IF EXISTS `sp_select_responsables`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_responsables` ()  BEGIN
	SELECT * FROM responsable;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

DROP TABLE IF EXISTS `departamento`;
CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `clave` varchar(10) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `ubicacion` varchar(150) NOT NULL,
  `extension` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `clave`, `nombre`, `ubicacion`, `extension`) VALUES
(1, 'DEPSIS1', 'SISTEMAS', 'EDIFICIO SISTEMAS', '3121481633'),
(2, 'DEPAMB1', 'AMBIENTAL', 'EDIFICIO AMBIENTAL', '3121481633'),
(61, 'DEPGEST1', 'GESTION', 'EDIFICIO GESTION', '3121481633'),
(67, 'DEPADM', 'ADMINISTRACION', 'EDIFICIO ADMINISTRACION', '3121481633'),
(70, 'DEPELE', 'ELECTRONICA', 'EDIFICIO ELECTRONICA', '3121481633');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_programa`
--

DROP TABLE IF EXISTS `departamento_programa`;
CREATE TABLE `departamento_programa` (
  `id_departamento` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_responsable`
--

DROP TABLE IF EXISTS `departamento_responsable`;
CREATE TABLE `departamento_responsable` (
  `id_departamento` int(11) NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento_responsable`
--

INSERT INTO `departamento_responsable` (`id_departamento`, `id_responsable`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 1, '2022-02-24', '2022-02-24'),
(1, 2, '2022-02-24', '2022-02-24'),
(1, 3, '2022-02-24', '2022-02-24'),
(1, 4, '2022-02-24', '2022-02-24'),
(1, 1, '2022-02-24', '2022-02-24'),
(1, 2, '2022-02-24', '2022-02-24'),
(1, 1, '2022-02-24', '2022-02-24'),
(1, 2, '2022-02-24', '2022-02-24'),
(1, 1, '2022-02-24', '2022-02-25'),
(1, 2, '2022-02-25', '2022-02-25'),
(1, 1, '2022-02-25', '2022-02-25'),
(1, 2, '2022-02-25', '2022-02-25'),
(1, 1, '2022-02-25', NULL),
(2, 3, '2022-02-25', NULL),
(61, 4, '2022-02-25', '2022-02-25'),
(67, 6, '2022-02-25', '2022-02-25'),
(61, 5, '2022-02-25', NULL),
(67, 5, '2022-02-25', '2022-03-02'),
(70, 7, '2022-02-25', '2022-02-25'),
(70, 1, '2022-02-25', NULL),
(67, 1, '2022-03-02', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo`
--

DROP TABLE IF EXISTS `periodo`;
CREATE TABLE `periodo` (
  `id_periodo` int(11) NOT NULL,
  `nombre` varchar(12) NOT NULL,
  `fecha_inicio_actividades` date NOT NULL,
  `fecha_fin_actividades` date NOT NULL,
  `fecha_inicio_inscripciones` date NOT NULL,
  `fecha_fin_inscripciones` date NOT NULL
) ;

--
-- Volcado de datos para la tabla `periodo`
--

INSERT INTO `periodo` (`id_periodo`, `nombre`, `fecha_inicio_actividades`, `fecha_fin_actividades`, `fecha_inicio_inscripciones`, `fecha_fin_inscripciones`) VALUES
(3, 'Mar-Mar 2022', '2022-03-01', '2022-03-02', '2022-03-01', '2022-03-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

DROP TABLE IF EXISTS `programa`;
CREATE TABLE `programa` (
  `id_programa` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `observaciones` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id_programa`, `nombre`, `descripcion`, `observaciones`) VALUES
(1, 'Deportivo', NULL, NULL),
(2, 'Cultural', NULL, NULL),
(3, 'Cívico', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE `responsable` (
  `id_responsable` int(11) NOT NULL,
  `clave` varchar(10) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `responsable`
--

INSERT INTO `responsable` (`id_responsable`, `clave`, `nombre`, `correo`) VALUES
(1, '17460069', 'José Ricardo Baeza Candor', '17460069@colima.tecnm.mx'),
(2, '17460341', 'Victor del Rio Ramos', '17460341@colima.tecnm.mx'),
(3, '17460346', 'Marco Eleno Tovar', '17460346@colima.tecnm.mx'),
(4, '17454323', 'Juan Perez Robles', '17454323@colima.tecnm.mx'),
(5, '17456365', 'Renata Perez Robles', '17456365@colima.tecnm.mx'),
(6, '1634874', 'Roberto Ramos Barrios', '1634874@colima.tecnm.mx'),
(7, '2342525', 'Fernanda Baeza Candor', '2342525@colima.tecnm.mx');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`),
  ADD UNIQUE KEY `id` (`clave`);

--
-- Indices de la tabla `departamento_programa`
--
ALTER TABLE `departamento_programa`
  ADD KEY `id_departamento` (`id_departamento`),
  ADD KEY `id_programa` (`id_programa`);

--
-- Indices de la tabla `departamento_responsable`
--
ALTER TABLE `departamento_responsable`
  ADD KEY `id_responsable` (`id_responsable`),
  ADD KEY `departamento_responsable_ibfk_1` (`id_departamento`);

--
-- Indices de la tabla `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id_periodo`);

--
-- Indices de la tabla `programa`
--
ALTER TABLE `programa`
  ADD PRIMARY KEY (`id_programa`);

--
-- Indices de la tabla `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`id_responsable`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id_periodo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programa`
--
ALTER TABLE `programa`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `responsable`
--
ALTER TABLE `responsable`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `departamento_programa`
--
ALTER TABLE `departamento_programa`
  ADD CONSTRAINT `departamento_programa_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`),
  ADD CONSTRAINT `departamento_programa_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`);

--
-- Filtros para la tabla `departamento_responsable`
--
ALTER TABLE `departamento_responsable`
  ADD CONSTRAINT `departamento_responsable_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE CASCADE,
  ADD CONSTRAINT `departamento_responsable_ibfk_2` FOREIGN KEY (`id_responsable`) REFERENCES `responsable` (`id_responsable`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
