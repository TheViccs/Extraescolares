-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-05-2022 a las 03:42:13
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.29

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_actividad` (IN `a_id_actividad` INT)   BEGIN
START TRANSACTION;
	UPDATE actividad SET actividad.visible=0 WHERE actividad.id_actividad=a_id_actividad;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_complementos_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_complementos_actividad` (IN `a_id_actividad` INT)   BEGIN
START TRANSACTION;
DELETE FROM material_actividad WHERE id_actividad=a_id_actividad;
DELETE FROM material_alumno WHERE id_actividad=a_id_actividad;
DELETE FROM material_actividad WHERE id_actividad=a_id_actividad;
DELETE FROM tema WHERE id_actividad=a_id_actividad;
DELETE FROM criterio_evaluacion WHERE id_actividad=a_id_actividad;
CREATE TEMPORARY TABLE evidencias_actuales(
    id_evidencia INT
);
INSERT INTO evidencias_actuales (id_evidencia) SELECT id_evidencia FROM actividad_evidencia WHERE id_actividad=a_id_actividad;
DELETE FROM actividad_evidencia WHERE id_actividad=a_id_actividad;
DELETE FROM evidencia WHERE id_actividad=a_id_actividad AND id_evidencia IN (SELECT id_evidencia FROM evidencias_actuales);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_coordinador` (IN `c_id_coordinador` INT(7), IN `c_id_departamento` INT(5))   BEGIN
START TRANSACTION;

	UPDATE departamento_coordinador SET departamento_coordinador.fecha_fin=NOW(), departamento_coordinador.visible=0 WHERE departamento_coordinador.id_coordinador=c_id_coordinador AND departamento_coordinador.id_departamento=c_id_departamento;
    
    UPDATE coordinador_programa SET coordinador_programa.fecha_fin=NOW() WHERE coordinador_programa.id_coordinador=c_id_coordinador AND coordinador_programa.id_programa IN (SELECT id_programa FROM departamento_programa WHERE departamento_programa.id_departamento=c_id_departamento);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_departamento` (IN `d_id_departamento` INT)   BEGIN
START TRANSACTION;
	UPDATE departamento SET departamento.visible=0 WHERE departamento.id_departamento=d_id_departamento;
    UPDATE departamento_responsable SET departamento_responsable.fecha_fin=NOW() WHERE departamento_responsable.id_departamento=d_id_departamento;
    UPDATE departamento_coordinador SET departamento_coordinador.fecha_fin=NOW() WHERE departamento_coordinador.id_departamento=d_id_departamento;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_grupo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_grupo` (IN `g_id_grupo` INT)   BEGIN
START TRANSACTION;
UPDATE grupo SET visible=0 WHERE grupo.id_grupo=g_id_grupo;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_programa` (IN `p_id_programa` INT)   BEGIN
START TRANSACTION;
	UPDATE programa SET programa.visible=0 WHERE programa.id_programa=p_id_programa;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_responsable` (IN `r_id_responsable` INT)   BEGIN
START TRANSACTION;
	UPDATE responsable SET responsable.visible=0 WHERE responsable.id_responsable=r_id_responsable;
    UPDATE departamento_responsable SET departamento_responsable.fecha_fin=NOW() WHERE departamento_responsable.id_responsable=r_id_responsable;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_actividad` (IN `a_nombre` VARCHAR(150), IN `a_descripcion` VARCHAR(200), IN `a_competencia` VARCHAR(200), IN `a_creditos_otorga` INT, IN `a_beneficios` VARCHAR(150), IN `a_capacidad_min` INT, IN `a_capacidad_max` INT, IN `a_fecha_incio` DATE, IN `a_fecha_fin` DATE, IN `a_id_programa` INT)   BEGIN
START TRANSACTION;
	INSERT INTO actividad (nombre, descripcion, competencia, creditos_otorga, beneficios, capacidad_min, capacidad_max, fecha_inicio,fecha_fin,id_programa) VALUES (a_nombre, a_descripcion, a_competencia, a_creditos_otorga, a_beneficios, a_capacidad_min, a_capacidad_max,a_fecha_inicio,a_fecha_fin,a_id_programa);
    INSERT INTO periodo_actividad (id_periodo,id_actividad) VALUES (periodo_actual(),last_insert_id());
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_actividad_con_padre`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_actividad_con_padre` (IN `a_nombre` VARCHAR(150), IN `a_descripcion` VARCHAR(200), IN `a_competencia` VARCHAR(200), IN `a_creditos_otorga` INT, IN `a_beneficios` VARCHAR(150), IN `a_capacidad_min` INT, IN `a_capacidad_max` INT, IN `a_actividad_padre` INT, IN `a_id_programa` INT)   BEGIN
START TRANSACTION;
	INSERT INTO actividad (nombre, descripcion, competencia, creditos_otorga, beneficios, capacidad_min, capacidad_max, actividad_padre,id_programa) VALUES (a_nombre, a_descripcion, a_competencia, a_creditos_otorga, a_beneficios, a_capacidad_min, a_capacidad_max, a_actividad_padre, a_id_programa);
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_caracteristica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_caracteristica` (IN `c_nombre` VARCHAR(150))   BEGIN
START TRANSACTION;
INSERT INTO caracteristica (nombre) VALUES (c_nombre);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_coordinador` (IN `c_id_departamento` INT, IN `c_clave` VARCHAR(10), IN `c_nombre` VARCHAR(150), IN `c_apellido_p` VARCHAR(50), IN `c_apellido_m` VARCHAR(50), IN `c_sexo` VARCHAR(1))   BEGIN
START TRANSACTION;
	INSERT INTO coordinador(clave, nombre, apellido_p, apellido_m,sexo) VALUES (c_clave,c_nombre,c_apellido_p,c_apellido_m,c_sexo) ON DUPLICATE KEY UPDATE nombre=c_nombre,apellido_p=c_apellido_p,apellido_m=c_apellido_m, sexo=c_sexo;
    
    SET @id_departamento = c_id_departamento;
    SET @id_coordinador = (SELECT id_coordinador FROM coordinador WHERE clave=c_clave);
    
    IF 0 = (SELECT COUNT(*) FROM departamento_coordinador WHERE id_departamento=@id_departamento AND id_coordinador=@id_coordinador AND fecha_fin IS NULL AND visible=1) THEN
    INSERT INTO departamento_coordinador(id_departamento, id_coordinador, fecha_inicio) VALUES (@id_departamento, @id_coordinador, NOW());
    END IF;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_coordinador_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_coordinador_programa` (IN `c_id` INT, IN `p_id` INT, IN `c_fecha_inicio` DATE)   BEGIN
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_criterio_evaluacion` (IN `c_nombre` VARCHAR(150), IN `c_descripcion` VARCHAR(200), IN `c_id_actividad` INT)   BEGIN
START TRANSACTION;
INSERT INTO criterio_evaluacion (nombre,descripcion,id_actividad) VALUES (c_nombre,c_descripcion,c_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento` (IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	INSERT INTO departamento(clave, nombre, ubicacion, extension,correo) VALUES (d_clave,d_nombre,d_ubicacion,d_extension,d_correo) ON DUPLICATE KEY UPDATE nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension,correo=d_correo;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento_responsable` (IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150), IN `r_id` INT)   BEGIN
START TRANSACTION;
	INSERT INTO departamento (clave,nombre,ubicacion,extension,correo) VALUES (d_clave,d_nombre,d_ubicacion,d_extension,d_correo);
    INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio)VALUES((SELECT id_departamento FROM departamento WHERE clave=d_clave),r_id,NOW());
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_evidencia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_evidencia` (IN `e_nombre` VARCHAR(150), IN `e_id_actividad` INT)   BEGIN
START TRANSACTION;
INSERT INTO evidencia (nombre) VALUES (e_nombre);
INSERT INTO actividad_evidencia (id_actividad,id_evidencia) VALUES (e_id_actividad,last_insert_id());
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_grupo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_grupo` (IN `g_nombre` VARCHAR(50), IN `g_capacidad_max` INT, IN `g_capacidad_min` INT, IN `g_id_actividad` INT, IN `g_id_lugar` INT, IN `g_id_caracteristica` INT, IN `g_id_instructor` INT)   BEGIN
START TRANSACTION;
INSERT INTO grupo (nombre, capacidad_max, capacidad_min, id_actividad, id_lugar, id_caracteristica, id_instructor) VALUES (g_nombre, g_capacidad_max, g_capacidad_min, g_id_actividad, g_id_lugar, g_id_caracteristica, g_id_instructor);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_horario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_horario` (IN `h_dia` VARCHAR(20), IN `h_hora_inicio` TIME, IN `h_hora_fin` TIME, IN `h_id_grupo` INT)   BEGIN
START TRANSACTION;
INSERT INTO horario (dia, hora_inicio, hora_fin) VALUES (h_dia, h_hora_inicio, h_hora_fin);
INSERT INTO grupo_horario (id_grupo, id_horario) VALUES (h_id_grupo, last_insert_id());
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_instructor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_instructor` (IN `i_nombre` VARCHAR(150), IN `i_apellido_p` VARCHAR(50), IN `i_apellido_m` VARCHAR(50), IN `i_telefono` VARCHAR(10), IN `i_sexo` VARCHAR(1), IN `i_correo` VARCHAR(150), IN `i_id_departamento` INT)   BEGIN
START TRANSACTION;
	IF 0 = (SELECT COUNT(*) FROM instructor WHERE nombre=i_nombre AND apellido_p=i_apellido_p AND apellido_m=i_apellido_m AND telefono=i_telefono AND sexo=i_sexo AND correo=i_correo) THEN
		INSERT INTO instructor(nombre, apellido_p, apellido_m, telefono, sexo, correo) VALUES (i_nombre, i_apellido_p, i_apellido_m, i_telefono, i_sexo, i_correo) ON DUPLICATE KEY UPDATE nombre=i_nombre, apellido_p=i_apellido_p, apellido_m=i_apellido_m, telefono=i_telefono, sexo=i_sexo, correo=i_correo;
    	INSERT INTO departamento_instructor(id_departamento,id_instructor,fecha_inicio) VALUES (i_id_departamento, last_insert_id(),NOW());
	ELSE
		SET @instructor = (SELECT id_instructor FROM instructor WHERE nombre=i_nombre AND apellido_p=i_apellido_p AND apellido_m=i_apellido_m AND telefono=i_telefono AND sexo=i_sexo AND correo=i_correo);
    	IF 0 = (SELECT COUNT(*) FROM departamento_instructor WHERE id_departamento=i_id_departamento AND id_instructor=@instructor AND fecha_fin IS NULL) THEN
    		INSERT INTO departamento_instructor (id_departamento,id_instructor,fecha_inicio) VALUES (i_id_departamento,@instructor,NOW());
    	END IF;
END IF;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_lugar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_lugar` (IN `l_nombre` VARCHAR(150), IN `l_capacidad_max` INT, IN `l_observaciones` VARCHAR(200))   BEGIN
START TRANSACTION;
INSERT INTO lugar (nombre, capacidad_max, observaciones) VALUES (l_nombre, l_capacidad_max, l_observaciones);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_material_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_material_actividad` (IN `m_nombre` VARCHAR(150), IN `m_cantidad` INT, IN `m_id_actividad` INT)   BEGIN
START TRANSACTION;
INSERT INTO material_actividad (nombre, cantidad, id_actividad) VALUES (m_nombre,m_cantidad,m_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_material_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_material_alumno` (IN `m_nombre` VARCHAR(150), IN `m_cantidad` INT, IN `m_id_actividad` INT)   BEGIN
START TRANSACTION;
INSERT INTO material_alumno (nombre, cantidad, id_actividad) VALUES (m_nombre,m_cantidad,m_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_periodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_periodo` (IN `p_nombre` VARCHAR(12), IN `p_fecha_i_a` DATE, IN `p_fecha_f_a` DATE)   BEGIN
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_programa` (IN `p_clave` VARCHAR(12), IN `p_nombre` VARCHAR(150), IN `p_descripcion` VARCHAR(150), IN `p_observaciones` VARCHAR(150))   BEGIN
START TRANSACTION;
	INSERT INTO programa(clave, nombre, descripcion, observaciones) VALUES (p_clave, p_nombre,p_descripcion,p_observaciones) ON DUPLICATE KEY UPDATE nombre=p_nombre, descripcion=p_descripcion, observaciones=p_observaciones;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_programa_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_programa_departamento` (IN `d_id` INT, IN `c_programa` VARCHAR(12), IN `p_d_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	INSERT INTO departamento_programa(id_programa,id_departamento,correo) VALUES ((SELECT id_programa FROM programa WHERE clave=c_programa),d_id,p_d_correo);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_responsable` (IN `r_clave` VARCHAR(10), IN `r_nombre` VARCHAR(150), IN `r_apellido_p` VARCHAR(50), IN `r_apellido_m` VARCHAR(50), IN `r_sexo` VARCHAR(1), IN `r_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	INSERT INTO responsable(clave, nombre, apellido_p, apellido_m,sexo , correo) VALUES (r_clave,r_nombre,r_apellido_p,r_apellido_m,r_sexo,r_correo) ON DUPLICATE KEY UPDATE nombre=r_nombre,apellido_p=r_apellido_p,apellido_m=r_apellido_m, sexo=r_sexo,correo=r_correo;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_tema`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_tema` (IN `t_nombre` VARCHAR(150), IN `t_descripcion` VARCHAR(200), IN `t_semanas` INT, IN `t_id_actividad` INT)   BEGIN
START TRANSACTION;
INSERT INTO tema (nombre, descripcion, semanas, id_actividad) VALUES (t_nombre,t_descripcion,t_semanas,t_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_login`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login` (IN `in_correo` VARCHAR(150), IN `in_contraseña` VARCHAR(12))   BEGIN
	IF (SELECT COUNT(*) FROM administrador WHERE administrador.usuario=in_correo AND administrador.contraseña=in_contraseña) <> 0 THEN
    	SELECT *,"administrador" as Tipo FROM administrador WHERE administrador.usuario=in_correo AND administrador.contraseña=in_contraseña;
	ELSEIF (SELECT COUNT(*) FROM departamento WHERE departamento.correo=in_correo AND contraseña=in_contraseña) <> 0 THEN
		SELECT *,"responsable" as Tipo FROM departamento WHERE departamento.correo=in_correo AND contraseña=in_contraseña;
    ELSEIF (SELECT COUNT(*) FROM departamento_programa WHERE departamento_programa.correo=in_correo AND departamento_programa.contraseña=in_contraseña) <> 0 THEN
    	SELECT *,"coordinador" as Tipo FROM departamento_programa JOIN coordinador_programa ON departamento_programa.id_programa=coordinador_programa.id_programa JOIN coordinador ON coordinador.id_coordinador=coordinador_programa.id_coordinador WHERE coordinador_programa.fecha_fin IS NULL AND departamento_programa.correo=in_correo AND departamento_programa.contraseña=in_contraseña;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_select_actividades`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_actividades` (IN `a_id_programa` INT)   BEGIN
	SELECT * FROM actividad WHERE actividad.visible=1 AND actividad.id_programa=a_id_programa;
END$$

DROP PROCEDURE IF EXISTS `sp_select_actividad_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_actividad_id` (IN `a_id_actividad` INT)   BEGIN
    SELECT actividad.id_actividad, actividad.nombre, actividad.descripcion, actividad.competencia, actividad.creditos_otorga, actividad.beneficios, actividad.capacidad_min, actividad.capacidad_max, actividad.id_programa WHERE actividad.id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_coordinadores_departamento_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_coordinadores_departamento_id` (IN `c_id_departamento` INT)   BEGIN

CREATE TEMPORARY TABLE coordinadores_actuales(
	id_coordinador INT,
    id_programa INT
);

INSERT INTO coordinadores_actuales (id_coordinador,id_programa) SELECT id_coordinador, id_programa FROM coordinador_programa WHERE fecha_fin IS NULL;

SELECT coordinador.id_coordinador,coordinador.clave,coordinador.nombre,coordinador.apellido_p,coordinador.apellido_m,coordinador.sexo,departamento_coordinador.id_departamento, coordinadores_actuales.id_programa FROM coordinador JOIN departamento_coordinador ON coordinador.id_coordinador=departamento_coordinador.id_coordinador LEFT JOIN coordinadores_actuales ON coordinadores_actuales.id_coordinador=coordinador.id_coordinador WHERE departamento_coordinador.id_departamento=c_id_departamento and departamento_coordinador.visible = 1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_coordinador_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_coordinador_id` (IN `c_id_coordinador` INT)   BEGIN
	SELECT coordinador.id_coordinador, coordinador.clave, coordinador.nombre, coordinador.apellido_p, coordinador.apellido_m, coordinador.sexo, programa.nombre AS nombre_programa, departamento.nombre AS nombre_departamento FROM coordinador LEFT JOIN coordinador_programa ON coordinador.id_coordinador=coordinador_programa.id_coordinador LEFT JOIN programa ON coordinador_programa.id_programa=programa.id_programa LEFT JOIN departamento_programa ON programa.id_programa=departamento_programa.id_programa LEFT JOIN departamento ON departamento.id_departamento=departamento_programa.id_departamento WHERE coordinador.id_coordinador=c_id_coordinador;
END$$

DROP PROCEDURE IF EXISTS `sp_select_criterios_evaluacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_criterios_evaluacion` (IN `a_id_actividad` INT)   BEGIN
SELECT * FROM criterio_evaluacion WHERE id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamentos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamentos` ()   BEGIN
	SELECT * FROM departamento WHERE departamento.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamento_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamento_id` (IN `d_id_departamento` INT)   BEGIN
	SELECT departamento.id_departamento, departamento.clave, departamento.nombre, departamento.ubicacion, departamento.extension, departamento.correo, departamento_responsable.id_responsable, responsable.nombre AS nombre_responsable, responsable.apellido_p, responsable.apellido_m FROM departamento LEFT JOIN departamento_responsable ON departamento.id_departamento = departamento_responsable.id_departamento LEFT JOIN responsable ON responsable.id_responsable=departamento_responsable.id_responsable WHERE departamento.id_departamento=d_id_departamento AND departamento_responsable.fecha_fin IS NULL;
END$$

DROP PROCEDURE IF EXISTS `sp_select_grupo_actividad_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_grupo_actividad_id` (IN `g_id_actividad` INT)   BEGIN
SELECT * FROM grupo WHERE grupo.id_actividad=g_id_actividad AND grupo.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_grupo_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_grupo_id` (IN `g_id_grupo` INT)   BEGIN
SELECT * FROM grupo WHERE grupo.id_grupo=g_id_grupo;
END$$

DROP PROCEDURE IF EXISTS `sp_select_horarios_grupo_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_horarios_grupo_id` (IN `g_id_grupo` INT)   BEGIN
SELECT horario.*, grupo_horario.id_grupo FROM grupo_horario JOIN grupo ON grupo_horario.id_grupo=grupo.id_grupo WHERE grupo_horario.id_grupo=g_id_grupo;
END$$

DROP PROCEDURE IF EXISTS `sp_select_instructores_departamento_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_instructores_departamento_id` (IN `i_id_departamento` INT)   BEGIN
SELECT instructor.* FROM instructor JOIN departamento_instructor ON instructor.id_instructor=departamento_instructor.id_instructor WHERE departamento_instructor.id_departamento=i_id_departamento AND departamento_instructor.fecha_fin IS NULL AND departamento_instructor.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_instructor_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_instructor_id` (IN `i_id_instructor` INT)   BEGIN
SELECT * FROM instructor WHERE id_instructor = i_id_instructor;
END$$

DROP PROCEDURE IF EXISTS `sp_select_materiales_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_materiales_actividad` (IN `a_id_actividad` INT)   BEGIN
SELECT * FROM material_actividad WHERE id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_materiales_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_materiales_alumno` (IN `a_id_actividad` INT)   BEGIN 
SELECT * FROM material_alumno WHERE id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_periodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_periodo` ()   BEGIN
	SELECT * FROM periodo ORDER BY id_periodo DESC LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_periodo_actual`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_periodo_actual` (INOUT `@periodo` INT)   BEGIN
SELECT id_periodo FROM periodo WHERE NOW()>fecha_inicio_actividades AND NOW()<fecha_fin_actividades;
END$$

DROP PROCEDURE IF EXISTS `sp_select_programas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_programas` ()   BEGIN
	SELECT * FROM programa WHERE programa.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_programas_departamento_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_programas_departamento_id` (IN `d_id_departamento` INT)   BEGIN

CREATE TEMPORARY TABLE coordinadores_actuales(
	id_coordinador INT,
    id_programa INT
);

INSERT INTO coordinadores_actuales (id_coordinador,id_programa) SELECT id_coordinador, id_programa FROM coordinador_programa WHERE fecha_fin IS NULL;
	
SELECT programa.id_programa,programa.clave,programa.nombre,programa.descripcion,programa.observaciones, departamento.id_departamento, coordinadores_actuales.id_coordinador FROM departamento JOIN departamento_programa ON departamento.id_departamento=departamento_programa.id_departamento JOIN programa ON departamento_programa.id_programa=programa.id_programa LEFT JOIN coordinadores_actuales ON programa.id_programa=coordinadores_actuales.id_programa WHERE departamento.id_departamento=d_id_departamento AND programa.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_programa_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_programa_id` (IN `p_id_programa` INT)   BEGIN
	SELECT programa.clave, programa.nombre, programa.descripcion, programa.observaciones, departamento_programa.id_departamento, departamento.nombre AS nombre_departamento FROM programa LEFT JOIN departamento_programa ON programa.id_programa=departamento_programa.id_programa LEFT JOIN departamento ON departamento.id_departamento=departamento_programa.id_departamento WHERE programa.id_programa=p_id_programa;
END$$

DROP PROCEDURE IF EXISTS `sp_select_responsables`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_responsables` ()   BEGIN
	SELECT * FROM responsable WHERE responsable.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_responsable_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_responsable_id` (IN `r_id_responsable` INT)   BEGIN
	SELECT responsable.id_responsable, responsable.clave as clave_responsable, responsable.nombre, responsable.apellido_p, responsable.apellido_m, responsable.sexo,responsable.correo AS correo_responsable, departamento.id_departamento, departamento.nombre as nombre_departamento FROM responsable LEFT JOIN departamento_responsable ON responsable.id_responsable=departamento_responsable.id_responsable LEFT JOIN departamento ON departamento_responsable.id_departamento=departamento.id_departamento WHERE responsable.id_responsable=r_id_responsable;
END$$

DROP PROCEDURE IF EXISTS `sp_select_temas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_temas` (IN `a_id_actividad` INT)   BEGIN
SELECT * FROM tema WHERE id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_update_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_actividad` (IN `a_nombre` VARCHAR(150), IN `a_descripcion` VARCHAR(200), IN `a_competencia` VARCHAR(200), IN `a_creditos_otorga` INT, IN `a_beneficios` VARCHAR(150), IN `a_capacidad_min` INT, IN `a_capacidad_max` INT, IN `a_fecha_incio` DATE, IN `a_fecha_fin` DATE, IN `a_id_actividad` INT)   BEGIN
START TRANSACTION;
	UPDATE actividad SET nombre=a_nombre, descripcion=a_descripcion, competencia=a_competencia, creditos_otorga=a_creditos_otorga, beneficios=a_beneficios, capacidad_min=a_capacidad_min, capacidad_max=a_capacidad_max, fecha_inicio=a_fecha_inicio, fecha_fin=a_fecha_fin WHERE id_actividad=a_id_actividad;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_coordinador` (IN `c_id_coordinador` INT, IN `c_clave` VARCHAR(10), IN `c_nombre` VARCHAR(150), IN `c_apellido_p` VARCHAR(50), IN `c_apellido_m` VARCHAR(50), IN `c_sexo` VARCHAR(1))   BEGIN
START TRANSACTION;
	UPDATE coordinador SET clave=c_clave, nombre=c_nombre, apellido_p=c_apellido_p, apellido_m=c_apellido_m, sexo=c_sexo WHERE id_coordinador=c_id_coordinador;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_departamento` (IN `d_id_departamento` INT, IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	UPDATE departamento SET clave=d_clave, nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension, correo=d_correo WHERE id_departamento=d_id_departamento;
    IF 0 <> (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL) THEN
    	UPDATE departamento_responsable SET fecha_fin=NOW() WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL; 
    END IF;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_departamento_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_departamento_responsable` (IN `d_id_departamento` INT, IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(150), IN `d_ubicacion` VARCHAR(150), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150), IN `r_id` INT)   BEGIN
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

DROP PROCEDURE IF EXISTS `sp_update_instructor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_instructor` (IN `i_id_instructor` INT, IN `i_nombre` VARCHAR(150), IN `i_apellido_p` VARCHAR(50), IN `i_apellido_m` VARCHAR(50), IN `i_telefono` VARCHAR(10), IN `i_sexo` VARCHAR(1), IN `i_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	UPDATE instructor SET nombre=i_nombre, apellido_p=i_apellido_p, apellido_m=i_apellido_m, telefono=i_telefono, sexo=i_sexo, correo=i_correo WHERE id_instructor=i_id_instructor;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_programa` (IN `p_id_programa` INT, IN `p_clave` VARCHAR(12), IN `p_nombre` VARCHAR(150), IN `p_descripcion` VARCHAR(150), IN `p_observaciones` VARCHAR(150))   BEGIN
START TRANSACTION;
	UPDATE programa SET clave=p_clave, nombre=p_nombre, descripcion=p_descripcion, observaciones=p_observaciones WHERE id_programa=p_id_programa;
    DELETE FROM departamento_programa WHERE id_programa=p_id_programa;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_programa_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_programa_departamento` (IN `p_id_programa` INT, IN `d_id_departamento` INT, IN `d_p_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	INSERT INTO departamento_programa (id_programa,id_departamento,correo) VALUES (p_id_programa,d_id_departamento,d_p_correo);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_responsable` (IN `r_id_responsable` INT, IN `r_clave` VARCHAR(10), IN `r_nombre` VARCHAR(150), IN `r_apellido_p` VARCHAR(50), IN `r_apellido_m` VARCHAR(50), IN `r_sexo` VARCHAR(1), IN `r_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	UPDATE responsable SET clave=r_clave, nombre=r_nombre, apellido_p=r_apellido_p, apellido_m=r_apellido_m, sexo=r_sexo, correo=r_correo WHERE id_responsable=r_id_responsable;
COMMIT;
END$$

--
-- Funciones
--
DROP FUNCTION IF EXISTS `periodo_actual`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `periodo_actual` () RETURNS INT(11)  BEGIN
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_evidencia`
--

DROP TABLE IF EXISTS `actividad_evidencia`;
CREATE TABLE `actividad_evidencia` (
  `id_actividad` int(11) DEFAULT NULL,
  `id_evidencia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Estructura de tabla para la tabla `caracteristica`
--

DROP TABLE IF EXISTS `caracteristica`;
CREATE TABLE `caracteristica` (
  `id_caracteristica` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(26, '432', 'fege', 'ergr', 'erge', 'M', NULL),
(31, '200', 'Juan', 'Perez', 'Robles', 'M', NULL);

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
(13, 5, '2022-04-27', '2022-03-29'),
(13, 5, '2022-04-27', '2022-03-29'),
(26, 5, '2022-03-16', '2022-03-29'),
(13, 5, '2022-04-27', '2022-04-27'),
(31, 5, '2022-04-27', '2022-04-27'),
(13, 5, '2022-04-27', '2022-04-27'),
(31, 5, '2022-04-27', '2022-04-27'),
(13, 5, '2022-04-27', '2022-04-27'),
(31, 5, '2022-04-27', '2022-04-27'),
(13, 5, '2022-04-27', '2022-04-27'),
(31, 5, '2022-04-27', '2022-04-27'),
(13, 5, '2022-04-27', '2022-04-27'),
(31, 5, '2022-04-27', '2022-04-27'),
(13, 5, '2022-04-27', NULL);

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
  `contraseña` varchar(20) NOT NULL DEFAULT 'responsable1',
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `clave`, `nombre`, `ubicacion`, `extension`, `correo`, `contraseña`, `visible`) VALUES
(1, 'D', 'Dirección', ' ', '201', 'direccion@colima.tecnm.mx', 'responsable1', 1),
(2, 'SPB', 'Subdirector de Planeación y Vinculación', ' ', '102', 'subdireccion@colima.tecnm.mx', 'responsable1', 1),
(6, 'DAE', 'Departamento de Actividades Extraescolares', ' ', '108', 'departamento.extraescolares@colima.tecnm.mx', 'responsable1', 1);

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
(6, 26, '2022-03-29', '2022-03-29', 0),
(6, 31, '2022-04-27', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_instructor`
--

DROP TABLE IF EXISTS `departamento_instructor`;
CREATE TABLE `departamento_instructor` (
  `id_departamento` int(11) DEFAULT NULL,
  `id_instructor` int(11) DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento_instructor`
--

INSERT INTO `departamento_instructor` (`id_departamento`, `id_instructor`, `fecha_inicio`, `fecha_fin`, `visible`) VALUES
(1, 6, '2022-04-28', NULL, 1);

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
(6, 6, 'coordinacion.civica.extraescolares@colima.tecnm.mx', 'coordinador1'),
(6, 33, 'tutoria.extraescolares@colima.tecnm.mx', 'coordinador1');

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
-- Estructura de tabla para la tabla `evidencia`
--

DROP TABLE IF EXISTS `evidencia`;
CREATE TABLE `evidencia` (
  `id_evidencia` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo` (
  `id_grupo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `capacidad_max` int(11) NOT NULL,
  `capacidad_min` int(11) NOT NULL,
  `total_inscripciones` int(11) NOT NULL DEFAULT 0,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `id_actividad` int(11) DEFAULT NULL,
  `id_lugar` int(11) DEFAULT NULL,
  `id_caracteristica` int(11) DEFAULT NULL,
  `id_instructor` int(11) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_horario`
--

DROP TABLE IF EXISTS `grupo_horario`;
CREATE TABLE `grupo_horario` (
  `id_grupo` int(11) DEFAULT NULL,
  `id_horario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

DROP TABLE IF EXISTS `horario`;
CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `dia` varchar(20) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructor`
--

DROP TABLE IF EXISTS `instructor`;
CREATE TABLE `instructor` (
  `id_instructor` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido_m` varchar(50) NOT NULL,
  `apellido_p` varchar(50) NOT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `sexo` varchar(1) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contraseña` varchar(20) NOT NULL DEFAULT 'instructor1',
  `foto` varchar(150) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `instructor`
--

INSERT INTO `instructor` (`id_instructor`, `nombre`, `apellido_m`, `apellido_p`, `telefono`, `sexo`, `correo`, `contraseña`, `foto`, `visible`) VALUES
(6, 'Juan', 'Robles', 'Perez', '', 'H', 'juan.perez@gmail.com', 'instructor1', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

DROP TABLE IF EXISTS `lugar`;
CREATE TABLE `lugar` (
  `id_lugar` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `capacidad_max` int(11) NOT NULL,
  `observaciones` varchar(200) DEFAULT NULL,
  `foto_1` varchar(200) DEFAULT NULL,
  `foto_2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(6, 'PACIV', 'Programa de Actividades Cívicas', NULL, NULL, 1),
(33, '500', 'Tutoría', NULL, NULL, 1);

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
  `foto` varchar(150) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `responsable`
--

INSERT INTO `responsable` (`id_responsable`, `clave`, `nombre`, `apellido_p`, `apellido_m`, `sexo`, `correo`, `foto`, `visible`) VALUES
(1, '1', 'Ana Rosa', 'Braña', 'Castillo', 'F', 'ana.braña@colima.tecnm.mx', NULL, 1),
(4, '2', 'Pedro Itzvan', 'Silva', 'Medina', 'M', 'pedro.silva@colima.tecnm.mx', NULL, 1),
(5, '190', 'Ariel', 'Lira', 'Obando', 'M', 'alira@colima.tecnm.mx', NULL, 1);

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
-- Indices de la tabla `actividad_evidencia`
--
ALTER TABLE `actividad_evidencia`
  ADD KEY `id_actividad` (`id_actividad`),
  ADD KEY `id_evidencia` (`id_evidencia`);

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  ADD PRIMARY KEY (`id_caracteristica`);

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
-- Indices de la tabla `departamento_instructor`
--
ALTER TABLE `departamento_instructor`
  ADD KEY `id_departamento` (`id_departamento`),
  ADD KEY `id_instructor` (`id_instructor`);

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
-- Indices de la tabla `evidencia`
--
ALTER TABLE `evidencia`
  ADD PRIMARY KEY (`id_evidencia`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_grupo`),
  ADD KEY `id_actividad` (`id_actividad`),
  ADD KEY `id_lugar` (`id_lugar`),
  ADD KEY `id_caracteristica` (`id_caracteristica`),
  ADD KEY `id_instructor` (`id_instructor`);

--
-- Indices de la tabla `grupo_horario`
--
ALTER TABLE `grupo_horario`
  ADD KEY `id_grupo` (`id_grupo`),
  ADD KEY `id_horario` (`id_horario`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`);

--
-- Indices de la tabla `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id_instructor`);

--
-- Indices de la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD PRIMARY KEY (`id_lugar`);

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
  ADD UNIQUE KEY `id_periodo_actividad` (`id_periodo`,`id_actividad`) USING BTREE,
  ADD KEY `periodo_actividad_ibfk_2` (`id_actividad`);

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
-- AUTO_INCREMENT de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  MODIFY `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  MODIFY `id_coordinador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
-- AUTO_INCREMENT de la tabla `evidencia`
--
ALTER TABLE `evidencia`
  MODIFY `id_evidencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id_instructor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `lugar`
--
ALTER TABLE `lugar`
  MODIFY `id_lugar` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_periodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `programa`
--
ALTER TABLE `programa`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
-- Filtros para la tabla `actividad_evidencia`
--
ALTER TABLE `actividad_evidencia`
  ADD CONSTRAINT `actividad_evidencia_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`),
  ADD CONSTRAINT `actividad_evidencia_ibfk_2` FOREIGN KEY (`id_evidencia`) REFERENCES `evidencia` (`id_evidencia`);

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
-- Filtros para la tabla `departamento_instructor`
--
ALTER TABLE `departamento_instructor`
  ADD CONSTRAINT `departamento_instructor_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`),
  ADD CONSTRAINT `departamento_instructor_ibfk_2` FOREIGN KEY (`id_instructor`) REFERENCES `instructor` (`id_instructor`);

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
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`),
  ADD CONSTRAINT `grupo_ibfk_2` FOREIGN KEY (`id_lugar`) REFERENCES `lugar` (`id_lugar`),
  ADD CONSTRAINT `grupo_ibfk_3` FOREIGN KEY (`id_caracteristica`) REFERENCES `caracteristica` (`id_caracteristica`),
  ADD CONSTRAINT `grupo_ibfk_4` FOREIGN KEY (`id_instructor`) REFERENCES `instructor` (`id_instructor`);

--
-- Filtros para la tabla `grupo_horario`
--
ALTER TABLE `grupo_horario`
  ADD CONSTRAINT `grupo_horario_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`),
  ADD CONSTRAINT `grupo_horario_ibfk_2` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id_horario`);

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
