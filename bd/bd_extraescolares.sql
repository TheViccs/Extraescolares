-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-03-2022 a las 15:17:05
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
DROP PROCEDURE IF EXISTS `sp_delete_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_coordinador` (IN `c_id_coordinador` INT(7), IN `c_id_responsable` INT(5))  BEGIN
	UPDATE departamento_coordinador SET departamento_coordinador.fecha_fin=NOW(), departamento_coordinador.visible=0 WHERE departamento_coordinador.id_coordinador=c_id_coordinador AND departamento_coordinador.id_departamento=(SELECT id_departamento FROM departamento_responsable WHERE departamento_responsable.id_responsable=c_id_responsable AND departamento_responsable.fecha_fin IS NULL);
END$$

DROP PROCEDURE IF EXISTS `sp_delete_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_departamento` (IN `d_id_departamento` INT)  BEGIN
	UPDATE departamento SET departamento.visible=0 WHERE departamento.id_departamento=d_id_departamento;
    UPDATE departamento_responsable SET departamento_responsable.fecha_fin=NOW() WHERE departamento_responsable.id_departamento=d_id_departamento;
    UPDATE departamento_coordinador SET departamento_coordinador.fecha_fin=NOW() WHERE departamento_coordinador.id_departamento=d_id_departamento;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_programa` (IN `p_id_programa` INT)  BEGIN
	UPDATE programa SET programa.visible=0 WHERE programa.id_programa=p_id_programa;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_responsable` (IN `r_id_responsable` INT)  BEGIN
	UPDATE responsable SET responsable.visible=0 WHERE responsable.id_responsable=r_id_responsable;
    UPDATE departamento_responsable SET departamento_responsable.fecha_fin=NOW() WHERE departamento_responsable.id_responsable=r_id_responsable;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_coordinador` (IN `c_id_responsable` INT, IN `c_clave` VARCHAR(10), IN `c_nombre` VARCHAR(150), IN `c_apellido_p` VARCHAR(50), IN `c_apellido_m` VARCHAR(50), IN `c_sexo` VARCHAR(1), IN `c_correo` VARCHAR(150))  BEGIN
	INSERT INTO coordinador(clave, nombre, apellido_p, apellido_m,sexo , correo) VALUES (c_clave,c_nombre,c_apellido_p,c_apellido_m,c_sexo,c_correo) ON DUPLICATE KEY UPDATE nombre=c_nombre,apellido_p=c_apellido_p,apellido_m=c_apellido_m, sexo=c_sexo,correo=c_correo;
    
    SET @id_departamento = (SELECT id_departamento FROM departamento_responsable WHERE id_responsable=c_id_responsable AND fecha_fin IS NULL LIMIT 1);
    SET @id_coordinador = (SELECT id_coordinador FROM coordinador WHERE clave=c_clave);
    
    IF 0 = (SELECT COUNT(*) FROM departamento_coordinador WHERE id_departamento=@id_departamento AND id_coordinador=@id_coordinador AND fecha_fin IS NULL AND visible=1) THEN
    INSERT INTO departamento_coordinador(id_departamento, id_coordinador, fecha_inicio) VALUES (@id_departamento, @id_coordinador, NOW());
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_coordinador_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_coordinador_programa` (IN `c_id` INT, IN `p_id` INT, IN `c_p_correo` VARCHAR(150), IN `c_fecha_inicio` DATE)  BEGIN
    IF 0 <> (SELECT COUNT(*) FROM coordinador_programa WHERE id_programa=p_id AND fecha_fin IS NULL) THEN
    	IF 0 = (SELECT COUNT(*) FROM coordinador_programa WHERE id_coordinador=c_id AND id_programa=p_id AND fecha_fin IS NULL) THEN
        	UPDATE coordinador_programa SET fecha_fin=NOW() WHERE id_programa=p_id AND fecha_fin IS NULL;
    		INSERT INTO coordinador_programa (id_coordinador,id_programa,correo,fecha_inicio) VALUES (c_id,p_id,c_p_correo,c_fecha_inicio);
            ELSE
            UPDATE coordinador_programa SET correo=c_p_correo, fecha_inicio=c_fecha_inicio WHERE id_coordinador=c_id AND id_programa=p_id;
    	END IF;
    ELSE
    	INSERT INTO coordinador_programa (id_coordinador,id_programa,correo,fecha_inicio) VALUES (c_id,p_id,c_p_correo,c_fecha_inicio);
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento` (IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150))  BEGIN
	INSERT INTO departamento(clave, nombre, ubicacion, extension,correo) VALUES (d_clave,d_nombre,d_ubicacion,d_extension,d_correo) ON DUPLICATE KEY UPDATE nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension,correo=d_correo;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento_responsable` (IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150), IN `r_id` INT)  BEGIN
	INSERT INTO departamento (clave,nombre,ubicacion,extension,correo) VALUES (d_clave,d_nombre,d_ubicacion,d_extension,d_correo);
    INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio)VALUES((SELECT id_departamento FROM departamento WHERE clave=d_clave),r_id,NOW());
END$$

DROP PROCEDURE IF EXISTS `sp_insert_periodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_periodo` (IN `p_nombre` VARCHAR(12), IN `p_fecha_i_a` DATE, IN `p_fecha_f_a` DATE)  BEGIN
	IF 0 = (SELECT COUNT(*) FROM periodo) THEN
    	INSERT INTO periodo (nombre, fecha_inicio_actividades, fecha_fin_actividades) VALUES (p_nombre, p_fecha_i_a, p_fecha_f_a);
    ELSE
    	IF(CURDATE() > (SELECT fecha_fin_actividades FROM periodo ORDER BY id_periodo DESC LIMIT 1)) THEN
        	INSERT INTO periodo (nombre, fecha_inicio_actividades, fecha_fin_actividades) VALUES (p_nombre, p_fecha_i_a, p_fecha_f_a);
        ELSE
        	UPDATE periodo SET nombre=p_nombre, fecha_inicio_actividades=p_fecha_i_a, fecha_fin_actividades=p_fecha_f_a WHERE fecha_fin_actividades > CURDATE();
        END IF;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_programa` (IN `p_clave` VARCHAR(12), IN `p_nombre` VARCHAR(150), IN `p_descripcion` VARCHAR(150), IN `p_observaciones` VARCHAR(150))  BEGIN
	INSERT INTO programa(clave, nombre, descripcion, observaciones) VALUES (p_clave, p_nombre,p_descripcion,p_observaciones) ON DUPLICATE KEY UPDATE nombre=p_nombre, descripcion=p_descripcion, observaciones=p_observaciones;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_programa_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_programa_departamento` (IN `d_id` INT, IN `c_programa` INT)  BEGIN
	INSERT INTO departamento_programa(id_programa,id_departamento) VALUES ((SELECT id_programa FROM programa WHERE clave=c_programa),d_id);
END$$

DROP PROCEDURE IF EXISTS `sp_insert_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_responsable` (IN `r_clave` VARCHAR(10), IN `r_nombre` VARCHAR(150), IN `r_apellido_p` VARCHAR(50), IN `r_apellido_m` VARCHAR(50), IN `r_sexo` VARCHAR(1), IN `r_correo` VARCHAR(150))  BEGIN
	INSERT INTO responsable(clave, nombre, apellido_p, apellido_m,sexo , correo) VALUES (r_clave,r_nombre,r_apellido_p,r_apellido_m,r_sexo,r_correo) ON DUPLICATE KEY UPDATE nombre=r_nombre,apellido_p=r_apellido_p,apellido_m=r_apellido_m, sexo=r_sexo,correo=r_correo;
END$$

DROP PROCEDURE IF EXISTS `sp_login`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `in_correo` VARCHAR(150), IN `in_contraseña` VARCHAR(12))  BEGIN
	IF (SELECT COUNT(*) FROM administrador WHERE administrador.usuario=in_correo AND administrador.contraseña=in_contraseña) <> 0 THEN
    	SELECT *,"administrador" as Tipo FROM administrador WHERE administrador.usuario=in_correo AND administrador.contraseña=in_contraseña;
	ELSEIF (SELECT COUNT(*) FROM responsable WHERE responsable.correo=in_correo AND contraseña=in_contraseña) <> 0 THEN
		SELECT *,"responsable" as Tipo FROM responsable WHERE responsable.correo=in_correo AND contraseña=in_contraseña;
    ELSEIF (SELECT COUNT(*) FROM coordinador WHERE coordinador.correo=in_correo) <> 0 THEN
    	SELECT *,"coordinador" as Tipo FROM coordinador WHERE coordinador.correo=in_correo;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_select_coordinadores`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_coordinadores` (IN `c_id_responsable` INT)  SELECT coordinador.id_coordinador,coordinador.clave,coordinador.nombre,coordinador.apellido_p,coordinador.apellido_m,coordinador.sexo,coordinador.correo,departamento_coordinador.id_departamento, coordinador_programa.id_programa FROM coordinador JOIN departamento_coordinador ON coordinador.id_coordinador=departamento_coordinador.id_coordinador LEFT JOIN coordinador_programa ON coordinador_programa.id_coordinador=coordinador.id_coordinador WHERE departamento_coordinador.id_departamento=(SELECT id_departamento FROM departamento_responsable WHERE departamento_responsable.id_responsable=c_id_responsable AND departamento_responsable.fecha_fin IS NULL) and departamento_coordinador.visible = 1$$

DROP PROCEDURE IF EXISTS `sp_select_coordinador_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_coordinador_id` (IN `c_id_coordinador` INT)  BEGIN
	SELECT coordinador.id_coordinador, coordinador.clave, coordinador.nombre, coordinador.apellido_p, coordinador.apellido_m, coordinador.sexo, coordinador.correo, programa.nombre AS nombre_programa, departamento.nombre AS nombre_departamento FROM coordinador LEFT JOIN coordinador_programa ON coordinador.id_coordinador=coordinador_programa.id_coordinador LEFT JOIN programa ON coordinador_programa.id_programa=programa.id_programa LEFT JOIN departamento_programa ON programa.id_programa=departamento_programa.id_programa LEFT JOIN departamento ON departamento.id_departamento=departamento_programa.id_departamento WHERE coordinador.id_coordinador=c_id_coordinador;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamentos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamentos` ()  BEGIN
	SELECT * FROM departamento WHERE departamento.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamento_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamento_id` (IN `d_id_departamento` INT)  BEGIN
	SELECT departamento.id_departamento, departamento.clave, departamento.nombre, departamento.ubicacion, departamento.extension, departamento.correo, departamento_responsable.id_responsable, responsable.nombre AS nombre_responsable, responsable.apellido_p, responsable.apellido_m FROM departamento LEFT JOIN departamento_responsable ON departamento.id_departamento = departamento_responsable.id_departamento LEFT JOIN responsable ON responsable.id_responsable=departamento_responsable.id_responsable WHERE departamento.id_departamento=d_id_departamento AND departamento_responsable.fecha_fin IS NULL;
END$$

DROP PROCEDURE IF EXISTS `sp_select_periodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_periodo` ()  BEGIN
	SELECT * FROM periodo ORDER BY id_periodo DESC LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_programas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_programas` ()  BEGIN
	SELECT * FROM programa WHERE programa.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_programas_responsable_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_programas_responsable_id` (IN `r_id_responsable` INT)  BEGIN
	SELECT programa.id_programa,programa.clave,programa.nombre,programa.descripcion,programa.observaciones, departamento_responsable.id_departamento, coordinador_programa.id_coordinador FROM responsable JOIN departamento_responsable ON responsable.id_responsable=departamento_responsable.id_responsable JOIN departamento_programa ON departamento_responsable.id_departamento=departamento_programa.id_departamento JOIN programa ON departamento_programa.id_programa=programa.id_programa LEFT JOIN coordinador_programa ON programa.id_programa=coordinador_programa.id_programa WHERE departamento_responsable.fecha_fin IS NULL AND responsable.id_responsable=r_id_responsable AND programa.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_programa_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_programa_id` (IN `p_id_programa` INT)  BEGIN
	SELECT programa.clave, programa.nombre, programa.descripcion, programa.observaciones, departamento_programa.id_departamento, departamento.nombre AS nombre_departamento FROM programa LEFT JOIN departamento_programa ON programa.id_programa=departamento_programa.id_programa LEFT JOIN departamento ON departamento.id_departamento=departamento_programa.id_departamento WHERE programa.id_programa=p_id_programa;
END$$

DROP PROCEDURE IF EXISTS `sp_select_responsables`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_responsables` ()  BEGIN
	SELECT * FROM responsable WHERE responsable.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_responsable_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_responsable_id` (IN `r_id_responsable` INT)  BEGIN
	SELECT responsable.id_responsable, responsable.clave as clave_responsable, responsable.nombre, responsable.apellido_p, responsable.apellido_m, responsable.sexo,responsable.correo AS correo_responsable, departamento.id_departamento, departamento.nombre as nombre_departamento FROM responsable LEFT JOIN departamento_responsable ON responsable.id_responsable=departamento_responsable.id_responsable LEFT JOIN departamento ON departamento_responsable.id_departamento=departamento.id_departamento WHERE responsable.id_responsable=r_id_responsable;
END$$

DROP PROCEDURE IF EXISTS `sp_update_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_coordinador` (IN `c_id_coordinador` INT, IN `c_clave` VARCHAR(10), IN `c_nombre` VARCHAR(150), IN `c_apellido_p` VARCHAR(50), IN `c_apellido_m` VARCHAR(50), IN `c_sexo` VARCHAR(1), IN `c_correo` VARCHAR(150))  BEGIN
	UPDATE coordinador SET clave=c_clave, nombre=c_nombre, apellido_p=c_apellido_p, apellido_m=c_apellido_m, sexo=c_sexo, correo=c_correo WHERE id_coordinador=c_id_coordinador;
END$$

DROP PROCEDURE IF EXISTS `sp_update_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_departamento` (IN `d_id_departamento` INT, IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150))  BEGIN
	UPDATE departamento SET clave=d_clave, nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension, correo=d_correo WHERE id_departamento=d_id_departamento;
    IF 0 <> (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL) THEN
    	UPDATE departamento_responsable SET fecha_fin=NOW() WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL;    
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_update_departamento_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_departamento_responsable` (IN `d_id_departamento` INT, IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150), IN `r_id` INT)  BEGIN
	UPDATE departamento SET clave=d_clave, nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension, correo=d_correo WHERE id_departamento=d_id_departamento;
    IF 0 <> (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL) THEN
    	IF 0 = (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id_departamento AND id_responsable=r_id AND fecha_fin IS NULL) THEN
        UPDATE departamento_responsable SET fecha_fin=NOW() WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL;
        INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio) VALUES (d_id_departamento,r_id,NOW());
        END IF;
        ELSE
        INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio) VALUES (d_id_departamento,r_id,NOW());
    END IF; 
END$$

DROP PROCEDURE IF EXISTS `sp_update_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_programa` (IN `p_id_programa` INT, IN `p_clave` VARCHAR(12), IN `p_nombre` VARCHAR(150), IN `p_descripcion` VARCHAR(150), IN `p_observaciones` VARCHAR(150))  BEGIN
	UPDATE programa SET clave=p_clave, nombre=p_nombre, descripcion=p_descripcion, observaciones=p_observaciones WHERE id_programa=p_id_programa;
    DELETE FROM departamento_programa WHERE id_programa=p_id_programa;
END$$

DROP PROCEDURE IF EXISTS `sp_update_programa_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_programa_departamento` (IN `p_id_programa` INT, IN `d_id_departamento` INT)  BEGIN
	INSERT INTO departamento_programa (id_programa,id_departamento) VALUES (p_id_programa,d_id_departamento);
END$$

DROP PROCEDURE IF EXISTS `sp_update_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_responsable` (IN `r_id_responsable` INT, IN `r_clave` VARCHAR(10), IN `r_nombre` VARCHAR(150), IN `r_apellido_p` VARCHAR(50), IN `r_apellido_m` VARCHAR(50), IN `r_sexo` VARCHAR(1), IN `r_correo` VARCHAR(150))  BEGIN
	UPDATE responsable SET clave=r_clave, nombre=r_nombre, apellido_p=r_apellido_p, apellido_m=r_apellido_m, sexo=r_sexo, correo=r_correo WHERE id_responsable=r_id_responsable;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE `administrador` (
  `id_admin` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_admin`, `usuario`, `contraseña`) VALUES
(1, 'admin', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador`
--

DROP TABLE IF EXISTS `coordinador`;
CREATE TABLE `coordinador` (
  `id_coordinador` int(11) NOT NULL,
  `clave` varchar(12) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido_p` varchar(150) NOT NULL,
  `apellido_m` varchar(150) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contraseña` varchar(12) NOT NULL DEFAULT 'coordinador1',
  `foto` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`id_coordinador`, `clave`, `nombre`, `apellido_p`, `apellido_m`, `sexo`, `correo`, `contraseña`, `foto`) VALUES
(7, '212', 'rve', 'ververv', 'erve', 'M', 'erve@colima.tecnm.mx', 'coordinador1', NULL),
(13, '123', 'AAA', 'AAA', 'AAA', 'M', 'AAA@colima.tecnm.mx', 'coordinador1', NULL),
(15, '324', 'qwd', 'qwd', 'qwd', 'M', 'qwd@colima.tecnm.mx', 'coordinador1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador_programa`
--

DROP TABLE IF EXISTS `coordinador_programa`;
CREATE TABLE `coordinador_programa` (
  `id_coordinador` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `coordinador_programa`
--

INSERT INTO `coordinador_programa` (`id_coordinador`, `id_programa`, `correo`, `fecha_inicio`, `fecha_fin`) VALUES
(13, 5, 'asada', '2022-03-09', NULL);

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
  `extension` varchar(12) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `clave`, `nombre`, `ubicacion`, `extension`, `correo`, `visible`) VALUES
(1, 'D', 'Dirección', ' ', '201', 'direccion@colima.tecnm.mx', 1),
(2, 'SPB', 'Subdirector de Planeación y Vinculación', ' ', '102', 'subdireccion@colima.tecnm.mx', 1),
(6, 'DAE', 'Departamento de Actividades Extraescolares', ' ', '108', 'departamento.extraescolares@colima.tecnm.mx', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_coordinador`
--

DROP TABLE IF EXISTS `departamento_coordinador`;
CREATE TABLE `departamento_coordinador` (
  `id_departamento` int(11) NOT NULL,
  `id_coordinador` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento_coordinador`
--

INSERT INTO `departamento_coordinador` (`id_departamento`, `id_coordinador`, `fecha_inicio`, `fecha_fin`, `visible`) VALUES
(6, 13, '2022-03-17', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_programa`
--

DROP TABLE IF EXISTS `departamento_programa`;
CREATE TABLE `departamento_programa` (
  `id_departamento` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento_programa`
--

INSERT INTO `departamento_programa` (`id_departamento`, `id_programa`) VALUES
(6, 2),
(6, 5),
(6, 6);

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
(1, 1, '2022-03-09', NULL),
(2, 4, '2022-03-09', NULL),
(6, 5, '2022-03-09', '2022-03-16'),
(6, 1, '2022-03-16', '2022-03-16'),
(6, 5, '2022-03-16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo`
--

DROP TABLE IF EXISTS `periodo`;
CREATE TABLE `periodo` (
  `id_periodo` int(11) NOT NULL,
  `nombre` varchar(12) NOT NULL,
  `fecha_inicio_actividades` date NOT NULL,
  `fecha_fin_actividades` date NOT NULL
) ;

--
-- Volcado de datos para la tabla `periodo`
--

INSERT INTO `periodo` (`id_periodo`, `nombre`, `fecha_inicio_actividades`, `fecha_fin_actividades`) VALUES
(2, 'Mar-Mar 2022', '2022-03-08', '2022-03-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

DROP TABLE IF EXISTS `programa`;
CREATE TABLE `programa` (
  `id_programa` int(11) NOT NULL,
  `clave` varchar(12) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `observaciones` varchar(150) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id_programa`, `clave`, `nombre`, `descripcion`, `observaciones`, `visible`) VALUES
(1, 'PFP', 'Formación profesional', NULL, NULL, 1),
(2, 'PAD', 'Programa de Actividades Deportivas', NULL, NULL, 1),
(5, 'PAC', 'Programa de Actividades Culturales', NULL, NULL, 1),
(6, 'PACIV', 'Programa de Actividades Cívicas', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE `responsable` (
  `id_responsable` int(11) NOT NULL,
  `clave` varchar(10) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido_p` varchar(50) DEFAULT NULL,
  `apellido_m` varchar(50) DEFAULT NULL,
  `sexo` varchar(1) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contraseña` varchar(12) NOT NULL DEFAULT 'responsable1',
  `foto` varchar(150) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `responsable`
--

INSERT INTO `responsable` (`id_responsable`, `clave`, `nombre`, `apellido_p`, `apellido_m`, `sexo`, `correo`, `contraseña`, `foto`, `visible`) VALUES
(1, '1', 'Ana Rosa', 'Braña', 'Castillo', 'F', 'ana.braña@colima.tecnm.mx', 'responsable1', NULL, 1),
(4, '2', 'Pedro Itzvan', 'Silva', 'Medina', 'M', 'pedro.silva@colima.tecnm.mx', 'responsable1', NULL, 1),
(5, '190', 'Ariel', 'Lira', 'Obando', 'M', 'alira@colima.tecnm.mx', 'responsable1', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  ADD PRIMARY KEY (`id_coordinador`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indices de la tabla `coordinador_programa`
--
ALTER TABLE `coordinador_programa`
  ADD KEY `id_coordinador` (`id_coordinador`),
  ADD KEY `id_programa` (`id_programa`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`),
  ADD UNIQUE KEY `id` (`clave`);

--
-- Indices de la tabla `departamento_coordinador`
--
ALTER TABLE `departamento_coordinador`
  ADD KEY `id_departamento` (`id_departamento`),
  ADD KEY `id_coordinador` (`id_coordinador`);

--
-- Indices de la tabla `departamento_programa`
--
ALTER TABLE `departamento_programa`
  ADD UNIQUE KEY `departamento_programa` (`id_departamento`,`id_programa`) USING BTREE,
  ADD KEY `departamento_programa_ibfk_2` (`id_programa`);

--
-- Indices de la tabla `departamento_responsable`
--
ALTER TABLE `departamento_responsable`
  ADD KEY `id_responsable` (`id_responsable`),
  ADD KEY `id_departamento` (`id_departamento`) USING BTREE;

--
-- Indices de la tabla `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id_periodo`);

--
-- Indices de la tabla `programa`
--
ALTER TABLE `programa`
  ADD PRIMARY KEY (`id_programa`),
  ADD UNIQUE KEY `clave` (`clave`);

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
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  MODIFY `id_coordinador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id_periodo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programa`
--
ALTER TABLE `programa`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `responsable`
--
ALTER TABLE `responsable`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `coordinador_programa`
--
ALTER TABLE `coordinador_programa`
  ADD CONSTRAINT `coordinador_programa_ibfk_1` FOREIGN KEY (`id_coordinador`) REFERENCES `coordinador` (`id_coordinador`),
  ADD CONSTRAINT `coordinador_programa_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`);

--
-- Filtros para la tabla `departamento_coordinador`
--
ALTER TABLE `departamento_coordinador`
  ADD CONSTRAINT `departamento_coordinador_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`),
  ADD CONSTRAINT `departamento_coordinador_ibfk_2` FOREIGN KEY (`id_coordinador`) REFERENCES `coordinador` (`id_coordinador`);

--
-- Filtros para la tabla `departamento_programa`
--
ALTER TABLE `departamento_programa`
  ADD CONSTRAINT `departamento_programa_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`),
  ADD CONSTRAINT `departamento_programa_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE;

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
