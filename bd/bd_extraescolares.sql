-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-04-2022 a las 16:51:21
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
DROP PROCEDURE IF EXISTS `sp_delete_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_actividad` (IN `a_id_actividad` INT)  BEGIN
START TRANSACTION;
	UPDATE actividad SET actividad.visible=0 WHERE actividad.id_actividad=a_id_actividad;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_complementos_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_complementos_actividad` (IN `a_id_actividad` INT)  BEGIN
START TRANSACTION;
DELETE FROM material_actividad WHERE id_actividad=a_id_actividad;
DELETE FROM material_alumno WHERE id_actividad=a_id_actividad;
DELETE FROM material_actividad WHERE id_actividad=a_id_actividad;
DELETE FROM tema WHERE id_actividad=a_id_actividad;
DELETE FROM criterio_evaluacion WHERE id_actividad=a_id_actividad;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_coordinador` (IN `c_id_coordinador` INT(7), IN `c_id_responsable` INT(5))  BEGIN
START TRANSACTION;

SET @departamento = (SELECT id_departamento FROM departamento_responsable WHERE departamento_responsable.id_responsable=c_id_responsable AND departamento_responsable.fecha_fin IS NULL);

	UPDATE departamento_coordinador SET departamento_coordinador.fecha_fin=NOW(), departamento_coordinador.visible=0 WHERE departamento_coordinador.id_coordinador=c_id_coordinador AND departamento_coordinador.id_departamento=@departamento;
    
    UPDATE coordinador_programa SET coordinador_programa.fecha_fin=NOW() WHERE coordinador_programa.id_coordinador=c_id_coordinador AND coordinador_programa.id_programa IN (SELECT id_programa FROM departamento_programa WHERE departamento_programa.id_departamento=@departamento);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_departamento` (IN `d_id_departamento` INT)  BEGIN
START TRANSACTION;
	UPDATE departamento SET departamento.visible=0 WHERE departamento.id_departamento=d_id_departamento;
    UPDATE departamento_responsable SET departamento_responsable.fecha_fin=NOW() WHERE departamento_responsable.id_departamento=d_id_departamento;
    UPDATE departamento_coordinador SET departamento_coordinador.fecha_fin=NOW() WHERE departamento_coordinador.id_departamento=d_id_departamento;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_programa` (IN `p_id_programa` INT)  BEGIN
START TRANSACTION;
	UPDATE programa SET programa.visible=0 WHERE programa.id_programa=p_id_programa;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_responsable` (IN `r_id_responsable` INT)  BEGIN
START TRANSACTION;
	UPDATE responsable SET responsable.visible=0 WHERE responsable.id_responsable=r_id_responsable;
    UPDATE departamento_responsable SET departamento_responsable.fecha_fin=NOW() WHERE departamento_responsable.id_responsable=r_id_responsable;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_actividad` (IN `a_nombre` VARCHAR(150), IN `a_descripcion` VARCHAR(200), IN `a_competencia` VARCHAR(200), IN `a_creditos_otorga` INT, IN `a_beneficios` VARCHAR(150), IN `a_capacidad_min` INT, IN `a_capacidad_max` INT, IN `a_fecha_incio` DATE, IN `a_fecha_fin` DATE, IN `a_id_programa` INT)  BEGIN
START TRANSACTION;
	INSERT INTO actividad (nombre, descripcion, competencia, creditos_otorga, beneficios, capacidad_min, capacidad_max, fecha_inicio,fecha_fin,id_programa) VALUES (a_nombre, a_descripcion, a_competencia, a_creditos_otorga, a_beneficios, a_capacidad_min, a_capacidad_max,a_fecha_inicio,a_fecha_fin,a_id_programa);
    INSERT INTO periodo_actividad (id_periodo,id_actividad) VALUES (periodo_actual(),last_insert_id());
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_actividad_con_padre`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_actividad_con_padre` (IN `a_nombre` VARCHAR(150), IN `a_descripcion` VARCHAR(200), IN `a_competencia` VARCHAR(200), IN `a_creditos_otorga` INT, IN `a_beneficios` VARCHAR(150), IN `a_capacidad_min` INT, IN `a_capacidad_max` INT, IN `a_actividad_padre` INT, IN `a_id_programa` INT)  BEGIN
START TRANSACTION;
	INSERT INTO actividad (nombre, descripcion, competencia, creditos_otorga, beneficios, capacidad_min, capacidad_max, actividad_padre,id_programa) VALUES (a_nombre, a_descripcion, a_competencia, a_creditos_otorga, a_beneficios, a_capacidad_min, a_capacidad_max, a_actividad_padre, a_id_programa);
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_coordinador` (IN `c_id_responsable` INT, IN `c_clave` VARCHAR(10), IN `c_nombre` VARCHAR(150), IN `c_apellido_p` VARCHAR(50), IN `c_apellido_m` VARCHAR(50), IN `c_sexo` VARCHAR(1))  BEGIN
START TRANSACTION;
	INSERT INTO coordinador(clave, nombre, apellido_p, apellido_m,sexo) VALUES (c_clave,c_nombre,c_apellido_p,c_apellido_m,c_sexo) ON DUPLICATE KEY UPDATE nombre=c_nombre,apellido_p=c_apellido_p,apellido_m=c_apellido_m, sexo=c_sexo;
    
    SET @id_departamento = (SELECT id_departamento FROM departamento_responsable WHERE id_responsable=c_id_responsable AND fecha_fin IS NULL LIMIT 1);
    SET @id_coordinador = (SELECT id_coordinador FROM coordinador WHERE clave=c_clave);
    
    IF 0 = (SELECT COUNT(*) FROM departamento_coordinador WHERE id_departamento=@id_departamento AND id_coordinador=@id_coordinador AND fecha_fin IS NULL AND visible=1) THEN
    INSERT INTO departamento_coordinador(id_departamento, id_coordinador, fecha_inicio) VALUES (@id_departamento, @id_coordinador, NOW());
    END IF;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_coordinador_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_coordinador_programa` (IN `c_id` INT, IN `p_id` INT, IN `c_fecha_inicio` DATE)  BEGIN
START TRANSACTION;
    IF 0 <> (SELECT COUNT(*) FROM coordinador_programa WHERE id_programa=p_id AND fecha_fin IS NULL) THEN
    	IF 0 = (SELECT COUNT(*) FROM coordinador_programa WHERE id_coordinador=c_id AND id_programa=p_id AND fecha_fin IS NULL) THEN
        	UPDATE coordinador_programa SET fecha_fin=NOW() WHERE id_programa=p_id AND fecha_fin IS NULL;
    		INSERT INTO coordinador_programa (id_coordinador,id_programa,fecha_inicio) VALUES (c_id,p_id,c_fecha_inicio);
            ELSE
            UPDATE coordinador_programa SET fecha_inicio=c_fecha_inicio WHERE id_coordinador=c_id AND id_programa=p_id;
            UPDATE departamento_programa SET departamento_programa.contraseña='coordinador1' WHERE departamento_programa.id_programa=p_id;
    	END IF;
    ELSE
    	INSERT INTO coordinador_programa (id_coordinador,id_programa,fecha_inicio) VALUES (c_id,p_id,c_fecha_inicio);
        UPDATE departamento_programa SET departamento_programa.contraseña='coordinador1' WHERE departamento_programa.id_programa=p_id;
    END IF;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_criterio_evaluacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_criterio_evaluacion` (IN `c_nombre` VARCHAR(150), IN `c_descripcion` VARCHAR(200), IN `c_id_actividad` INT)  BEGIN
START TRANSACTION;
INSERT INTO criterio_evaluacion (nombre,descripcion,id_actividad) VALUES (c_nombre,c_descripcion,c_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento` (IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150))  BEGIN
START TRANSACTION;
	INSERT INTO departamento(clave, nombre, ubicacion, extension,correo) VALUES (d_clave,d_nombre,d_ubicacion,d_extension,d_correo) ON DUPLICATE KEY UPDATE nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension,correo=d_correo;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento_responsable` (IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150), IN `r_id` INT)  BEGIN
START TRANSACTION;
	INSERT INTO departamento (clave,nombre,ubicacion,extension,correo) VALUES (d_clave,d_nombre,d_ubicacion,d_extension,d_correo);
    INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio)VALUES((SELECT id_departamento FROM departamento WHERE clave=d_clave),r_id,NOW());
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_material_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_material_actividad` (IN `m_nombre` VARCHAR(150), IN `m_cantidad` INT, IN `m_id_actividad` INT)  BEGIN
START TRANSACTION;
INSERT INTO material_actividad (nombre, cantidad, id_actividad) VALUES (m_nombre,m_cantidad,m_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_material_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_material_alumno` (IN `m_nombre` VARCHAR(150), IN `m_cantidad` INT, IN `m_id_actividad` INT)  BEGIN
START TRANSACTION;
INSERT INTO material_alumno (nombre, cantidad, id_actividad) VALUES (m_nombre,m_cantidad,m_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_periodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_periodo` (IN `p_nombre` VARCHAR(12), IN `p_fecha_i_a` DATE, IN `p_fecha_f_a` DATE)  BEGIN
START TRANSACTION;
	IF 0 = (SELECT COUNT(*) FROM periodo) THEN
    	INSERT INTO periodo (nombre, fecha_inicio_actividades, fecha_fin_actividades) VALUES (p_nombre, p_fecha_i_a, p_fecha_f_a);
    ELSE
    	IF(CURDATE() > (SELECT fecha_fin_actividades FROM periodo ORDER BY id_periodo DESC LIMIT 1)) THEN
        	INSERT INTO periodo (nombre, fecha_inicio_actividades, fecha_fin_actividades) VALUES (p_nombre, p_fecha_i_a, p_fecha_f_a);
        ELSE
        	UPDATE periodo SET nombre=p_nombre, fecha_inicio_actividades=p_fecha_i_a, fecha_fin_actividades=p_fecha_f_a WHERE fecha_fin_actividades > CURDATE();
        END IF;
    END IF;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_programa` (IN `p_clave` VARCHAR(12), IN `p_nombre` VARCHAR(150), IN `p_descripcion` VARCHAR(150), IN `p_observaciones` VARCHAR(150))  BEGIN
START TRANSACTION;
	INSERT INTO programa(clave, nombre, descripcion, observaciones) VALUES (p_clave, p_nombre,p_descripcion,p_observaciones) ON DUPLICATE KEY UPDATE nombre=p_nombre, descripcion=p_descripcion, observaciones=p_observaciones;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_programa_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_programa_departamento` (IN `d_id` INT, IN `c_programa` VARCHAR(12), IN `p_d_correo` VARCHAR(150))  BEGIN
START TRANSACTION;
	INSERT INTO departamento_programa(id_programa,id_departamento,correo) VALUES ((SELECT id_programa FROM programa WHERE clave=c_programa),d_id,p_d_correo);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_responsable` (IN `r_clave` VARCHAR(10), IN `r_nombre` VARCHAR(150), IN `r_apellido_p` VARCHAR(50), IN `r_apellido_m` VARCHAR(50), IN `r_sexo` VARCHAR(1), IN `r_correo` VARCHAR(150))  BEGIN
START TRANSACTION;
	INSERT INTO responsable(clave, nombre, apellido_p, apellido_m,sexo , correo) VALUES (r_clave,r_nombre,r_apellido_p,r_apellido_m,r_sexo,r_correo) ON DUPLICATE KEY UPDATE nombre=r_nombre,apellido_p=r_apellido_p,apellido_m=r_apellido_m, sexo=r_sexo,correo=r_correo;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_tema`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_tema` (IN `t_nombre` VARCHAR(150), IN `t_descripcion` VARCHAR(200), IN `t_semanas` INT, IN `t_id_actividad` INT)  BEGIN
START TRANSACTION;
INSERT INTO tema (nombre, descripcion, semanas, id_actividad) VALUES (t_nombre,t_descripcion,t_semanas,t_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_login`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `in_correo` VARCHAR(150), IN `in_contraseña` VARCHAR(12))  BEGIN
	IF (SELECT COUNT(*) FROM administrador WHERE administrador.usuario=in_correo AND administrador.contraseña=in_contraseña) <> 0 THEN
    	SELECT *,"administrador" as Tipo FROM administrador WHERE administrador.usuario=in_correo AND administrador.contraseña=in_contraseña;
	ELSEIF (SELECT COUNT(*) FROM responsable WHERE responsable.correo=in_correo AND contraseña=in_contraseña) <> 0 THEN
		SELECT *,"responsable" as Tipo FROM responsable WHERE responsable.correo=in_correo AND contraseña=in_contraseña;
    ELSEIF (SELECT COUNT(*) FROM departamento_programa WHERE departamento_programa.correo=in_correo AND departamento_programa.contraseña=in_contraseña) <> 0 THEN
    	SELECT *,"coordinador" as Tipo FROM departamento_programa JOIN coordinador_programa ON departamento_programa.id_programa=coordinador_programa.id_programa JOIN coordinador ON coordinador.id_coordinador=coordinador_programa.id_coordinador WHERE coordinador_programa.fecha_fin IS NULL AND departamento_programa.correo=in_correo AND departamento_programa.contraseña=in_contraseña;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_select_actividades`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_actividades` (IN `a_id_programa` INT)  BEGIN
	SELECT * FROM actividad WHERE actividad.visible=1 AND actividad.id_programa=a_id_programa;
END$$

DROP PROCEDURE IF EXISTS `sp_select_actividad_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_actividad_id` (IN `a_id_actividad` INT)  BEGIN
    SELECT actividad.id_actividad, actividad.nombre, actividad.descripcion, actividad.competencia, actividad.creditos_otorga, actividad.beneficios, actividad.capacidad_min, actividad.capacidad_max, actividad.id_programa WHERE actividad.id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_coordinadores`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_coordinadores` (IN `c_id_responsable` INT)  BEGIN

CREATE TEMPORARY TABLE coordinadores_actuales(
	id_coordinador INT,
    id_programa INT
);

INSERT INTO coordinadores_actuales (id_coordinador,id_programa) SELECT id_coordinador, id_programa FROM coordinador_programa WHERE fecha_fin IS NULL;

SELECT coordinador.id_coordinador,coordinador.clave,coordinador.nombre,coordinador.apellido_p,coordinador.apellido_m,coordinador.sexo,departamento_coordinador.id_departamento, coordinadores_actuales.id_programa FROM coordinador JOIN departamento_coordinador ON coordinador.id_coordinador=departamento_coordinador.id_coordinador LEFT JOIN coordinadores_actuales ON coordinadores_actuales.id_coordinador=coordinador.id_coordinador WHERE departamento_coordinador.id_departamento=(SELECT id_departamento FROM departamento_responsable WHERE departamento_responsable.id_responsable=c_id_responsable AND departamento_responsable.fecha_fin IS NULL) and departamento_coordinador.visible = 1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_coordinador_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_coordinador_id` (IN `c_id_coordinador` INT)  BEGIN
	SELECT coordinador.id_coordinador, coordinador.clave, coordinador.nombre, coordinador.apellido_p, coordinador.apellido_m, coordinador.sexo, programa.nombre AS nombre_programa, departamento.nombre AS nombre_departamento FROM coordinador LEFT JOIN coordinador_programa ON coordinador.id_coordinador=coordinador_programa.id_coordinador LEFT JOIN programa ON coordinador_programa.id_programa=programa.id_programa LEFT JOIN departamento_programa ON programa.id_programa=departamento_programa.id_programa LEFT JOIN departamento ON departamento.id_departamento=departamento_programa.id_departamento WHERE coordinador.id_coordinador=c_id_coordinador;
END$$

DROP PROCEDURE IF EXISTS `sp_select_criterios_evaluacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_criterios_evaluacion` (IN `a_id_actividad` INT)  BEGIN
SELECT * FROM criterio_evaluacion WHERE id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamentos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamentos` ()  BEGIN
	SELECT * FROM departamento WHERE departamento.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamento_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamento_id` (IN `d_id_departamento` INT)  BEGIN
	SELECT departamento.id_departamento, departamento.clave, departamento.nombre, departamento.ubicacion, departamento.extension, departamento.correo, departamento_responsable.id_responsable, responsable.nombre AS nombre_responsable, responsable.apellido_p, responsable.apellido_m FROM departamento LEFT JOIN departamento_responsable ON departamento.id_departamento = departamento_responsable.id_departamento LEFT JOIN responsable ON responsable.id_responsable=departamento_responsable.id_responsable WHERE departamento.id_departamento=d_id_departamento AND departamento_responsable.fecha_fin IS NULL;
END$$

DROP PROCEDURE IF EXISTS `sp_select_materiales_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_materiales_actividad` (IN `a_id_actividad` INT)  BEGIN
SELECT * FROM material_actividad WHERE id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_materiales_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_materiales_alumno` (IN `a_id_actividad` INT)  BEGIN 
SELECT * FROM material_alumno WHERE id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_periodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_periodo` ()  BEGIN
	SELECT * FROM periodo ORDER BY id_periodo DESC LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_periodo_actual`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_periodo_actual` (INOUT `@periodo` INT)  BEGIN
SELECT id_periodo FROM periodo WHERE NOW()>fecha_inicio_actividades AND NOW()<fecha_fin_actividades;
END$$

DROP PROCEDURE IF EXISTS `sp_select_programas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_programas` ()  BEGIN
	SELECT * FROM programa WHERE programa.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_programas_responsable_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_programas_responsable_id` (IN `r_id_responsable` INT)  BEGIN

CREATE TEMPORARY TABLE coordinadores_actuales(
	id_coordinador INT,
    id_programa INT
);

INSERT INTO coordinadores_actuales (id_coordinador,id_programa) SELECT id_coordinador, id_programa FROM coordinador_programa WHERE fecha_fin IS NULL;

	SELECT programa.id_programa,programa.clave,programa.nombre,programa.descripcion,programa.observaciones, departamento_responsable.id_departamento, coordinadores_actuales.id_coordinador FROM responsable JOIN departamento_responsable ON responsable.id_responsable=departamento_responsable.id_responsable JOIN departamento_programa ON departamento_responsable.id_departamento=departamento_programa.id_departamento JOIN programa ON departamento_programa.id_programa=programa.id_programa LEFT JOIN coordinadores_actuales ON programa.id_programa=coordinadores_actuales.id_programa WHERE departamento_responsable.fecha_fin IS NULL AND responsable.id_responsable=r_id_responsable AND programa.visible=1;
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

DROP PROCEDURE IF EXISTS `sp_select_temas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_temas` (IN `a_id_actividad` INT)  BEGIN
SELECT * FROM tema WHERE id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_update_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_actividad` (IN `a_id_actividad` INT, IN `a_nombre` VARCHAR(150), IN `a_descripcion` VARCHAR(200), IN `a_competencia` VARCHAR(200), IN `a_creditos_otorga` INT, IN `a_beneficios` VARCHAR(150), IN `a_capacidad_min` INT, IN `a_capacidad_max` INT)  BEGIN
START TRANSACTION;
	UPDATE actividad SET nombre=a_nombre, descripcion=a_descripcion, competencia=a_competencia, creditos_otorga=a_creditos_otorga, beneficios=a_beneficios, capacidad_min=a_capacidad_min, capacidad_max=a_capacidad_max WHERE id_actividad=a_id_actividad;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_coordinador` (IN `c_id_coordinador` INT, IN `c_clave` VARCHAR(10), IN `c_nombre` VARCHAR(150), IN `c_apellido_p` VARCHAR(50), IN `c_apellido_m` VARCHAR(50), IN `c_sexo` VARCHAR(1))  BEGIN
START TRANSACTION;
	UPDATE coordinador SET clave=c_clave, nombre=c_nombre, apellido_p=c_apellido_p, apellido_m=c_apellido_m, sexo=c_sexo WHERE id_coordinador=c_id_coordinador;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_departamento` (IN `d_id_departamento` INT, IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150))  BEGIN
START TRANSACTION;
	UPDATE departamento SET clave=d_clave, nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension, correo=d_correo WHERE id_departamento=d_id_departamento;
    IF 0 <> (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL) THEN
    	UPDATE departamento_responsable SET fecha_fin=NOW() WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL; 
    END IF;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_departamento_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_departamento_responsable` (IN `d_id_departamento` INT, IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150), IN `r_id` INT)  BEGIN
START TRANSACTION;
	UPDATE departamento SET clave=d_clave, nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension, correo=d_correo WHERE id_departamento=d_id_departamento;
    IF 0 <> (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL) THEN
    	IF 0 = (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id_departamento AND id_responsable=r_id AND fecha_fin IS NULL) THEN
        UPDATE departamento_responsable SET fecha_fin=NOW() WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL;
        INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio) VALUES (d_id_departamento,r_id,NOW());
        END IF;
        ELSE
        INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio) VALUES (d_id_departamento,r_id,NOW());
    END IF; 
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_programa` (IN `p_id_programa` INT, IN `p_clave` VARCHAR(12), IN `p_nombre` VARCHAR(150), IN `p_descripcion` VARCHAR(150), IN `p_observaciones` VARCHAR(150))  BEGIN
START TRANSACTION;
	UPDATE programa SET clave=p_clave, nombre=p_nombre, descripcion=p_descripcion, observaciones=p_observaciones WHERE id_programa=p_id_programa;
    DELETE FROM departamento_programa WHERE id_programa=p_id_programa;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_programa_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_programa_departamento` (IN `p_id_programa` INT, IN `d_id_departamento` INT, IN `d_p_correo` VARCHAR(150))  BEGIN
START TRANSACTION;
	INSERT INTO departamento_programa (id_programa,id_departamento,correo) VALUES (p_id_programa,d_id_departamento,d_p_correo);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_responsable` (IN `r_id_responsable` INT, IN `r_clave` VARCHAR(10), IN `r_nombre` VARCHAR(150), IN `r_apellido_p` VARCHAR(50), IN `r_apellido_m` VARCHAR(50), IN `r_sexo` VARCHAR(1), IN `r_correo` VARCHAR(150))  BEGIN
START TRANSACTION;
	UPDATE responsable SET clave=r_clave, nombre=r_nombre, apellido_p=r_apellido_p, apellido_m=r_apellido_m, sexo=r_sexo, correo=r_correo WHERE id_responsable=r_id_responsable;
COMMIT;
END$$

--
-- Funciones
--
DROP FUNCTION IF EXISTS `periodo_actual`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `periodo_actual` () RETURNS INT(11) BEGIN
DECLARE periodo INT;
SET periodo = (SELECT id_periodo FROM periodo WHERE NOW()>fecha_inicio_actividades AND NOW()<fecha_fin_actividades);
RETURN periodo;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

DROP TABLE IF EXISTS `actividad`;
CREATE TABLE `actividad` (
  `id_actividad` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `competencia` varchar(200) NOT NULL,
  `creditos_otorga` int(11) NOT NULL,
  `beneficios` varchar(150) NOT NULL,
  `video` varchar(150) DEFAULT NULL,
  `capacidad_min` int(11) NOT NULL,
  `capacidad_max` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `actividad_padre` int(11) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `id_programa` int(11) NOT NULL
) ;

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
(1, 'admin@colima.tecnm.mx', '1234');

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
  `foto` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`id_coordinador`, `clave`, `nombre`, `apellido_p`, `apellido_m`, `sexo`, `foto`) VALUES
(7, '212', 'rve', 'ververv', 'erve', 'M', NULL),
(13, '123', 'AAA', 'AAA', 'AAA', 'M', NULL),
(15, '324', 'qwd', 'qwd', 'qwd', 'M', NULL),
(26, '432', 'fege', 'ergr', 'erge', 'M', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador_programa`
--

DROP TABLE IF EXISTS `coordinador_programa`;
CREATE TABLE `coordinador_programa` (
  `id_coordinador` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `coordinador_programa`
--

INSERT INTO `coordinador_programa` (`id_coordinador`, `id_programa`, `fecha_inicio`, `fecha_fin`) VALUES
(13, 5, '2022-03-17', '2022-03-29'),
(13, 5, '2022-03-17', '2022-03-29'),
(26, 5, '2022-03-16', '2022-03-29'),
(13, 5, '2022-03-09', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterio_evaluacion`
--

DROP TABLE IF EXISTS `criterio_evaluacion`;
CREATE TABLE `criterio_evaluacion` (
  `id_criterio` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(6, 13, '2022-03-17', NULL, 1),
(6, 26, '2022-03-29', '2022-03-29', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_programa`
--

DROP TABLE IF EXISTS `departamento_programa`;
CREATE TABLE `departamento_programa` (
  `id_departamento` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contraseña` varchar(20) NOT NULL DEFAULT 'coordinador1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento_programa`
--

INSERT INTO `departamento_programa` (`id_departamento`, `id_programa`, `correo`, `contraseña`) VALUES
(6, 2, 'coordinacion.deportiva.extraescolares@colima.tecnm.mx', 'coordinador1'),
(6, 5, 'coordinacion.cultural.extraescolares@colima.tecnm.mx', 'coordinador1'),
(6, 6, 'coordinacion.civica.extraescolares@colima.tecnm.mx', 'coordinador1');

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
-- Estructura de tabla para la tabla `material_actividad`
--

DROP TABLE IF EXISTS `material_actividad`;
CREATE TABLE `material_actividad` (
  `id_material_actividad` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_alumno`
--

DROP TABLE IF EXISTS `material_alumno`;
CREATE TABLE `material_alumno` (
  `id_material_alumno` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'Mar-Mar 2022', '2022-03-08', '2022-03-31'),
(3, 'Abr-May 2022', '2022-04-25', '2022-05-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_actividad`
--

DROP TABLE IF EXISTS `periodo_actividad`;
CREATE TABLE `periodo_actividad` (
  `id_periodo` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

DROP TABLE IF EXISTS `tema`;
CREATE TABLE `tema` (
  `id_tema` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `semanas` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_programa` (`id_programa`);

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
-- Indices de la tabla `criterio_evaluacion`
--
ALTER TABLE `criterio_evaluacion`
  ADD PRIMARY KEY (`id_criterio`),
  ADD KEY `id_actividad` (`id_actividad`);

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
-- Indices de la tabla `material_actividad`
--
ALTER TABLE `material_actividad`
  ADD PRIMARY KEY (`id_material_actividad`),
  ADD KEY `id_actividad` (`id_actividad`);

--
-- Indices de la tabla `material_alumno`
--
ALTER TABLE `material_alumno`
  ADD PRIMARY KEY (`id_material_alumno`),
  ADD KEY `id_actividad` (`id_actividad`);

--
-- Indices de la tabla `periodo`
--
ALTER TABLE `periodo`
  ADD PRIMARY KEY (`id_periodo`);

--
-- Indices de la tabla `periodo_actividad`
--
ALTER TABLE `periodo_actividad`
  ADD UNIQUE KEY `id_periodo_actividad` (`id_periodo`,`id_actividad`) USING BTREE;

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
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id_tema`),
  ADD KEY `id_actividad` (`id_actividad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  MODIFY `id_coordinador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `criterio_evaluacion`
--
ALTER TABLE `criterio_evaluacion`
  MODIFY `id_criterio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `material_actividad`
--
ALTER TABLE `material_actividad`
  MODIFY `id_material_actividad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `material_alumno`
--
ALTER TABLE `material_alumno`
  MODIFY `id_material_alumno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id_periodo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programa`
--
ALTER TABLE `programa`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `responsable`
--
ALTER TABLE `responsable`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`);

--
-- Filtros para la tabla `coordinador_programa`
--
ALTER TABLE `coordinador_programa`
  ADD CONSTRAINT `coordinador_programa_ibfk_1` FOREIGN KEY (`id_coordinador`) REFERENCES `coordinador` (`id_coordinador`),
  ADD CONSTRAINT `coordinador_programa_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`);

--
-- Filtros para la tabla `criterio_evaluacion`
--
ALTER TABLE `criterio_evaluacion`
  ADD CONSTRAINT `criterio_evaluacion_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`);

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

--
-- Filtros para la tabla `material_actividad`
--
ALTER TABLE `material_actividad`
  ADD CONSTRAINT `material_actividad_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`);

--
-- Filtros para la tabla `material_alumno`
--
ALTER TABLE `material_alumno`
  ADD CONSTRAINT `material_alumno_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`);

--
-- Filtros para la tabla `periodo_actividad`
--
ALTER TABLE `periodo_actividad`
  ADD CONSTRAINT `periodo_actividad_ibfk_1` FOREIGN KEY (`id_periodo`) REFERENCES `periodo` (`id_periodo`),
  ADD CONSTRAINT `periodo_actividad_ibfk_2` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`);

--
-- Filtros para la tabla `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `tema_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
