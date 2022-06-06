-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-06-2022 a las 15:24:26
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
DROP PROCEDURE IF EXISTS `sp_calificar_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_calificar_alumno` (IN `d_id_alumno` INT, IN `d_id_grupo` INT, IN `d_calificacion_numerica` INT, IN `d_acreditacion` TINYINT(1), IN `d_desempeño` INT)   BEGIN
START TRANSACTION;
UPDATE detalles_inscripcion SET calificacion_numerica=d_calificacion_numerica, acreditacion=d_acreditacion, desempeño=d_desempeño WHERE id_alumno=d_id_alumno AND id_grupo=d_id_grupo AND id_periodo=periodo_actual();
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_actividad` (IN `a_id_actividad` INT)   BEGIN
START TRANSACTION;
	UPDATE actividad SET actividad.visible=0 WHERE actividad.id_actividad=a_id_actividad;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_actividad_instructor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_actividad_instructor` (IN `a_id_actividad` INT, IN `a_id_instructor` INT, IN `a_id_evidencia` INT)   BEGIN
START TRANSACTION;
DELETE FROM actividad_instructor WHERE id_instructor=a_id_instructor AND id_evidencia=a_id_evidencia AND id_actividad=a_id_actividad;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_alumno` (IN `a_id_alumno` INT)   BEGIN
START TRANSACTION;
UPDATE alumno SET visible = 0 WHERE id_alumno=a_id_alumno;
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
DELETE FROM actividad_evidencia WHERE id_actividad=a_id_actividad AND id_evidencia IN (SELECT id_evidencia FROM evidencias_actuales);
DELETE FROM evidencia WHERE id_evidencia IN (SELECT id_evidencia FROM evidencias_actuales);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_complementos_grupo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_complementos_grupo` (IN `g_id_grupo` INT)   BEGIN
START TRANSACTION;
CREATE TEMPORARY TABLE horarios_actuales(
    id_horario INT
);
INSERT INTO horarios_actuales (id_horario) SELECT id_horario FROM grupo_horario WHERE id_grupo=g_id_grupo;
DELETE FROM grupo_horario WHERE id_grupo=g_id_grupo AND id_horario IN (SELECT id_horario FROM horarios_actuales);
DELETE FROM horarios WHERE id_horario IN (SELECT id_horario FROM horarios_actuales);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_coordinador` (IN `c_id_coordinador` INT(7), IN `c_id_departamento` INT(5))   BEGIN
START TRANSACTION;

	UPDATE departamento_coordinador SET departamento_coordinador.fecha_fin=NOW(), departamento_coordinador.visible=0 WHERE departamento_coordinador.id_coordinador=c_id_coordinador AND departamento_coordinador.id_departamento=c_id_departamento;
    
    UPDATE coordinador_programa SET coordinador_programa.fecha_fin=NOW() WHERE coordinador_programa.id_coordinador=c_id_coordinador AND coordinador_programa.id_programa IN (SELECT id_programa FROM departamento_programa WHERE departamento_programa.id_departamento=c_id_departamento);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_criterios_evaluacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_criterios_evaluacion` (IN `a_id_actividad` INT)   BEGIN
START TRANSACTION;
DELETE FROM criterio_evaluacion WHERE criterio_evaluacion.id_actividad=a_id_actividad;
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

DROP PROCEDURE IF EXISTS `sp_delete_detalle_inscripcion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_detalle_inscripcion` (IN `d_id_alumno` INT, IN `d_id_grupo` INT, IN `d_id_actividad` INT)   BEGIN

END$$

DROP PROCEDURE IF EXISTS `sp_delete_detelles_inscripcion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_detelles_inscripcion` (IN `d_id_alumno` INT, IN `d_id_grupo` INT, IN `d_id_actividad` INT)   BEGIN
START TRANSACTION;
DELETE FROM detalles_inscripcion WHERE id_alumno=d_id_alumno AND id_grupo=d_id_grupo AND id_actividad=d_id_actividad AND id_periodo=periodo_actual();
SET @carga = (SELECT id_carga FROM carga_complementaria WHERE id_alumno=d_id_alumno AND id_periodo=periodo_actual());
DELETE FROM carga_actividad WHERE id_carga=@carga AND id_actividad=d_id_actividad;
DELETE FROM carga_grupo WHERE id_carga=@carga AND id_grupo=d_id_grupo;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_grupo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_grupo` (IN `g_id_grupo` INT)   BEGIN
START TRANSACTION;
UPDATE grupo SET visible=0 WHERE grupo.id_grupo=g_id_grupo;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_horario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_horario` (IN `h_id_horario` INT)   BEGIN
START TRANSACTION;
DELETE FROM grupo_horario WHERE id_horario = h_id_horario;
DELETE FROM horario WHERE id_horario = h_id_horario;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_instructor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_instructor` (IN `i_id_instructor` INT)   BEGIN
START TRANSACTION;
UPDATE instructor SET visible=0 WHERE instructor.id_instructor=i_id_instructor;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_materiales_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_materiales_actividad` (IN `a_id_actividad` INT)   BEGIN
START TRANSACTION;
DELETE FROM material_actividad WHERE material_actividad.id_actividad=a_id_actividad;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_materiales_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_materiales_alumno` (IN `a_id_actividad` INT)   BEGIN
START TRANSACTION;
DELETE FROM material_alumno WHERE material_alumno.id_actividad=a_id_actividad;
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

DROP PROCEDURE IF EXISTS `sp_delete_temas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_temas` (IN `a_id_actividad` INT)   BEGIN
START TRANSACTION;
DELETE FROM tema WHERE tema.id_actividad=a_id_actividad;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_actividad` (IN `a_nombre` VARCHAR(150), IN `a_descripcion` VARCHAR(1000), IN `a_competencia` VARCHAR(1000), IN `a_creditos_otorga` INT, IN `a_beneficios` VARCHAR(1000), IN `a_capacidad_min` INT, IN `a_capacidad_max` INT, IN `a_fecha_inicio` DATE, IN `a_fecha_fin` DATE, IN `a_id_programa` INT, IN `a_actividad_padre` INT, IN `a_video` VARCHAR(200))   BEGIN
START TRANSACTION;
	INSERT INTO actividad (nombre, descripcion, competencia, creditos_otorga, beneficios, capacidad_min, capacidad_max, fecha_inicio,fecha_fin,id_programa, actividad_padre,video) VALUES (a_nombre, a_descripcion, a_competencia, a_creditos_otorga, a_beneficios, a_capacidad_min, a_capacidad_max,a_fecha_inicio,a_fecha_fin,a_id_programa,a_actividad_padre,a_video);
    SET @actividad = last_insert_id();
    INSERT INTO periodo_actividad (id_periodo,id_actividad) VALUES (periodo_actual(),last_insert_id());
    SELECT @actividad as id_actividad_insertada;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_actividad_instructor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_actividad_instructor` (IN `a_id_actividad` INT, IN `a_id_instructor` INT)   BEGIN
START TRANSACTION;
INSERT INTO actividad_instructor (id_actividad, id_instructor) VALUES (a_id_actividad, a_id_instructor);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_actividad_instructor_evidencia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_actividad_instructor_evidencia` (IN `a_id_actividad` INT, IN `a_id_instructor` INT, IN `a_id_evidencia` INT, IN `a_porcentaje` INT)   BEGIN
START TRANSACTION;
INSERT INTO actividad_instructor (id_actividad, id_instructor, id_evidencia, porcentaje) VALUES (a_id_actividad, a_id_instructor, a_id_evidencia, a_porcentaje);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_alumno` (IN `a_nombre` VARCHAR(150), IN `a_apellido_p` VARCHAR(50), IN `a_apellido_m` VARCHAR(50), IN `a_correo` VARCHAR(200), IN `a_carrera` VARCHAR(200), IN `a_semestre` INT)   BEGIN
START TRANSACTION;
INSERT INTO alumno (nombre, apellido_p, apellido_m, correo, carrera, semestre) VALUES (a_nombre, a_apellido_p, a_apellido_m, a_correo, a_carrera, a_semestre);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_caracteristica`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_caracteristica` (IN `c_nombre` VARCHAR(200))   BEGIN
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

DROP PROCEDURE IF EXISTS `sp_insert_criterio_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_criterio_alumno` (IN `c_id_alumno` INT, IN `c_id_grupo` INT, IN `c_id_criterio` INT, IN `c_desempeño` INT)   BEGIN
START TRANSACTION;
IF 1 > (SELECT COUNT(*) FROM criterio_alumno WHERE criterio_alumno.id_alumno=c_id_alumno AND criterio_alumno.id_grupo=c_id_grupo AND criterio_alumno.id_criterio=c_id_criterio) THEN
	INSERT INTO criterio_alumno (id_alumno,id_grupo,id_criterio,desempeño) VALUES (c_id_alumno,c_id_grupo, c_id_criterio,c_desempeño);
ELSE
	UPDATE criterio_alumno SET desempeño=c_desempeño WHERE id_alumno=c_id_alumno AND id_grupo=c_id_grupo AND id_criterio=c_id_criterio;
END IF;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_criterio_evaluacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_criterio_evaluacion` (IN `c_nombre` VARCHAR(200), IN `c_descripcion` VARCHAR(1000), IN `c_id_actividad` INT)   BEGIN
START TRANSACTION;
INSERT INTO criterio_evaluacion (nombre,descripcion,id_actividad) VALUES (c_nombre,c_descripcion,c_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento` (IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(200), IN `d_ubicacion` VARCHAR(200), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	INSERT INTO departamento(clave, nombre, ubicacion, extension,correo) VALUES (d_clave,d_nombre,d_ubicacion,d_extension,d_correo) ON DUPLICATE KEY UPDATE nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension,correo=d_correo;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_departamento_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_departamento_responsable` (IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(200), IN `d_ubicacion` VARCHAR(200), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150), IN `r_id` INT)   BEGIN
START TRANSACTION;
	INSERT INTO departamento (clave,nombre,ubicacion,extension,correo) VALUES (d_clave,d_nombre,d_ubicacion,d_extension,d_correo);
    INSERT INTO departamento_responsable(id_departamento,id_responsable,fecha_inicio)VALUES((SELECT id_departamento FROM departamento WHERE clave=d_clave),r_id,NOW());
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_detalle_inscripcion_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_detalle_inscripcion_alumno` (IN `d_id_alumno` INT, IN `d_id_grupo` INT, IN `d_id_actividad` INT)   BEGIN
START TRANSACTION;
/*Ver capacidad actual grupo*/
SET @inscripciones_actuales_grupo = (SELECT total_inscripciones FROM grupo WHERE id_grupo=d_id_grupo);
SET @capacidad_max_grupo = (SELECT capacidad_max FROM grupo WHERE id_grupo=d_id_grupo);
/*Ver que el alumno no este inscrito en mas 2 dos actividades por semestre*/
SET @inscripciones_alumno_semestre_actual = (SELECT COUNT(*) FROM detalles_inscripcion WHERE id_alumno=d_id_alumno AND id_periodo=periodo_actual());
/*Ver si el alumo ya tienen 5 creditos o 2 creditos en un programa*/
SET @numero_creditos_alumno = (SELECT creditos_totales FROM alumno WHERE id_alumno=d_id_alumno);
SET @programa = (SELECT id_programa FROM actividad WHERE id_actividad=d_id_actividad);
SET @acreditaciones_en_programa_alumno = (SELECT COUNT(*) FROM detalles_inscripcion JOIN actividad ON detalles_inscripcion.id_actividad=actividad.id_actividad WHERE id_alumno=d_id_alumno AND id_programa=@programa AND acreditacion=1);
SET @inscripciones_en_actividad = (SELECT COUNT(*) FROM detalles_inscripcion WHERE id_actividad=d_id_actividad AND id_alumno=d_id_alumno);
SET @constancia = 0;
IF((@numero_creditos_alumno < 5) AND (@acreditaciones_en_programa_alumno < 2)) THEN
	SET @constancia = 1;
END IF;
/*INSERCION*/
IF ((@inscripciones_actuales_grupo < @capacidad_max_grupo) AND (@inscripciones_alumno_semestre_actual < 2) AND (@inscripciones_en_actividad < 1)) THEN
	INSERT INTO detalles_inscripcion (constancia, id_alumno, id_grupo, id_actividad, id_periodo) VALUES (@constancia, d_id_alumno, d_id_grupo, d_id_actividad, periodo_actual());
    UPDATE grupo SET grupo.total_inscripciones = grupo.total_inscripciones + 1 WHERE grupo.id_grupo = d_id_grupo;
    IF 1 > (SELECT COUNT(*) FROM carga_complementaria WHERE id_alumno=d_id_alumno AND id_periodo=periodo_actual()) THEN
    	INSERT INTO carga_complementaria (id_alumno, id_periodo) VALUES (d_id_alumno, periodo_actual());
    END IF;
    SET @carga = (SELECT id_carga FROM carga_complementaria WHERE id_alumno=d_id_alumno AND id_periodo=periodo_actual());
    INSERT INTO carga_grupo(id_carga, id_grupo) VALUES (@carga,d_id_grupo);
    INSERT INTO carga_actividad (id_carga, id_actividad) VALUES (@carga, d_id_actividad);
    SET @mensaje = "INSERTADO";
    SELECT @mensaje as mensaje;
ELSE 
 	SET @mensaje = "HUBO UN ERROR";
	SELECT @mensaje as mensaje;
END IF;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_evidencia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_evidencia` (IN `e_nombre` VARCHAR(200), IN `e_id_actividad` INT)   BEGIN
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

DROP PROCEDURE IF EXISTS `sp_insert_grupo_horario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_grupo_horario` (IN `h_id_grupo` INT, IN `h_id_horario` INT)   BEGIN
START TRANSACTION;
INSERT INTO grupo_horario (id_grupo, id_horario) VALUES (h_id_grupo, h_id_horario);
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_instructor` (IN `i_nombre` VARCHAR(150), IN `i_apellido_p` VARCHAR(50), IN `i_apellido_m` VARCHAR(50), IN `i_sexo` VARCHAR(1), IN `i_correo` VARCHAR(150), IN `i_fecha_inicio` DATE, IN `i_fecha_fin` DATE, IN `i_id_departamento` INT)   BEGIN
START TRANSACTION;
	IF 0 = (SELECT COUNT(*) FROM instructor WHERE nombre=i_nombre AND apellido_p=i_apellido_p AND apellido_m=i_apellido_m AND sexo=i_sexo AND correo=i_correo) THEN
		INSERT INTO instructor(nombre, apellido_p, apellido_m, sexo, correo) VALUES (i_nombre, i_apellido_p, i_apellido_m, i_sexo, i_correo) ON DUPLICATE KEY UPDATE nombre=i_nombre, apellido_p=i_apellido_p, apellido_m=i_apellido_m, sexo=i_sexo, correo=i_correo;
    	INSERT INTO departamento_instructor(id_departamento,id_instructor,fecha_inicio,fecha_fin) VALUES (i_id_departamento, last_insert_id(),i_fecha_inicio,i_fecha_fin);
	ELSE
		SET @instructor = (SELECT id_instructor FROM instructor WHERE nombre=i_nombre AND apellido_p=i_apellido_p AND apellido_m=i_apellido_m AND sexo=i_sexo AND correo=i_correo);
    	IF 0 = (SELECT COUNT(*) FROM departamento_instructor WHERE id_departamento=i_id_departamento AND id_instructor=@instructor AND fecha_fin > NOW()) THEN
    		INSERT INTO departamento_instructor (id_departamento,id_instructor,fecha_inicio,fecha_fin) VALUES (i_id_departamento,@instructor,i_fecha_inicio,i_fecha_fin);
    	END IF;
END IF;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_lugar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_lugar` (IN `l_nombre` VARCHAR(200), IN `l_capacidad_max` INT, IN `l_observaciones` VARCHAR(1000))   BEGIN
START TRANSACTION;
INSERT INTO lugar (nombre, capacidad_max, observaciones) VALUES (l_nombre, l_capacidad_max, l_observaciones);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_material_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_material_actividad` (IN `m_nombre` VARCHAR(200), IN `m_cantidad` INT, IN `m_id_actividad` INT)   BEGIN
START TRANSACTION;
INSERT INTO material_actividad (nombre, cantidad, id_actividad) VALUES (m_nombre,m_cantidad,m_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_material_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_material_alumno` (IN `m_nombre` VARCHAR(200), IN `m_cantidad` INT, IN `m_id_actividad` INT)   BEGIN
START TRANSACTION;
INSERT INTO material_alumno (nombre, cantidad, id_actividad) VALUES (m_nombre,m_cantidad,m_id_actividad);
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_periodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_periodo` (IN `p_nombre` VARCHAR(20), IN `p_fecha_i_a` DATE, IN `p_fecha_f_a` DATE)   BEGIN
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_programa` (IN `p_clave` VARCHAR(12), IN `p_nombre` VARCHAR(200), IN `p_descripcion` VARCHAR(1000), IN `p_observaciones` VARCHAR(150))   BEGIN
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_tema` (IN `t_nombre` VARCHAR(200), IN `t_descripcion` VARCHAR(1000), IN `t_semanas` INT, IN `t_id_actividad` INT)   BEGIN
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
    ELSEIF (SELECT COUNT(*) FROM alumno WHERE alumno.correo=in_correo AND alumno.contraseña=in_contraseña) <> 0 THEN
    	SELECT alumno.*,"alumno" as Tipo FROM alumno WHERE alumno.correo=in_correo AND alumno.contraseña=in_contraseña AND visible=1;
   	ELSEIF (SELECT COUNT(*) FROM instructor WHERE instructor.correo=in_correo AND instructor.contraseña=in_contraseña) <> 0 THEN
    	SELECT instructor.*,"instructor" as Tipo FROM instructor WHERE instructor.correo=in_correo AND instructor.contraseña=in_contraseña AND visible=1;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_select_actividades`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_actividades` ()   BEGIN
SELECT actividad.* FROM actividad JOIN periodo_actividad ON actividad.id_actividad=periodo_actividad.id_actividad WHERE periodo_actividad.id_periodo=periodo_actual() AND actividad.visible=1 AND actividad.fecha_inicio > NOW();
END$$

DROP PROCEDURE IF EXISTS `sp_select_actividades_acreditadas_alumno_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_actividades_acreditadas_alumno_id` (IN `d_id_alumno` INT)   BEGIN
SELECT COUNT(*) as actividades_acreditadas FROM detalles_inscripcion WHERE id_alumno=1 AND acreditacion=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_actividades_programa_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_actividades_programa_id` (IN `a_id_programa` INT)   BEGIN
	SELECT * FROM actividad WHERE actividad.visible=1 AND actividad.id_programa=a_id_programa;
END$$

DROP PROCEDURE IF EXISTS `sp_select_actividad_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_actividad_id` (IN `a_id_actividad` INT)   BEGIN
    SELECT actividad.id_actividad, actividad.nombre, actividad.descripcion, actividad.competencia, actividad.creditos_otorga, actividad.beneficios, actividad.capacidad_min, actividad.capacidad_max, actividad.id_programa, actividad.actividad_padre, actividad.fecha_inicio, actividad.fecha_fin FROM actividad WHERE actividad.id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_actividad_instructores`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_actividad_instructores` (IN `a_id_actividad` INT)   BEGIN
SELECT instructor.* FROM actividad_instructor JOIN instructor ON actividad_instructor.id_instructor=instructor.id_instructor WHERE id_actividad=a_id_actividad AND id_evidencia IS NULL AND porcentaje IS NULL;
END$$

DROP PROCEDURE IF EXISTS `sp_select_alumnos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_alumnos` ()   BEGIN
SELECT * FROM alumno WHERE visible = 1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_alumnos_actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_alumnos_actividad` (IN `d_id_actividad` INT)   BEGIN
	SELECT alumno.*, detalles_inscripcion.id_grupo FROM detalles_inscripcion JOIN alumno ON detalles_inscripcion.id_alumno=alumno.id_alumno WHERE detalles_inscripcion.id_actividad=d_id_actividad AND alumno.visible=1 AND id_periodo=periodo_actual();
END$$

DROP PROCEDURE IF EXISTS `sp_select_alumnos_grupo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_alumnos_grupo` (IN `a_id_grupo` INT)   BEGIN 
	SELECT alumno.*, detalles_inscripcion.id_grupo,detalles_inscripcion.id_actividad FROM detalles_inscripcion JOIN alumno ON detalles_inscripcion.id_alumno=alumno.id_alumno WHERE alumno.visible=1 AND detalles_inscripcion.id_grupo=a_id_grupo AND id_periodo=perido_actual();
END$$

DROP PROCEDURE IF EXISTS `sp_select_alumnos_grupo_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_alumnos_grupo_id` (IN `g_id_grupo` INT)   BEGIN
SELECT alumno.id_alumno,alumno.nombre,alumno.apellido_p,alumno.apellido_m,alumno.semestre,alumno.carrera FROM detalles_inscripcion JOIN alumno ON detalles_inscripcion.id_alumno=alumno.id_alumno WHERE detalles_inscripcion.id_grupo=g_id_grupo AND detalles_inscripcion.id_periodo=periodo_actual();
END$$

DROP PROCEDURE IF EXISTS `sp_select_calificacion_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_calificacion_alumno` (IN `d_id_alumno` INT, IN `d_id_grupo` INT)   BEGIN
SELECT * FROM detalles_inscripcion WHERE detalles_inscripcion.id_alumno=d_id_alumno AND detalles_inscripcion.id_grupo=d_id_grupo AND detalles_inscripcion.id_periodo=periodo_actual();
END$$

DROP PROCEDURE IF EXISTS `sp_select_caracteristicas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_caracteristicas` ()   BEGIN
SELECT * FROM caracteristica;
END$$

DROP PROCEDURE IF EXISTS `sp_select_carga_complementaria_alumno_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_carga_complementaria_alumno_id` (IN `c_id_alumno` INT)   BEGIN
SELECT actividad.nombre as nombre_actividad, instructor.nombre as nombre_instructor, instructor.apellido_p, instructor.apellido_m, lugar.nombre as nombre_lugar, grupo.* FROM carga_complementaria JOIN carga_grupo ON carga_complementaria.id_carga=carga_grupo.id_carga JOIN grupo ON grupo.id_grupo=carga_grupo.id_grupo JOIN actividad ON grupo.id_actividad = actividad.id_actividad JOIN instructor ON grupo.id_instructor=instructor.id_instructor JOIN lugar ON grupo.id_lugar=lugar.id_lugar WHERE carga_complementaria.id_alumno=c_id_alumno AND carga_complementaria.id_periodo=periodo_actual();
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

DROP PROCEDURE IF EXISTS `sp_select_criterios`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_criterios` ()   BEGIN
SELECT * FROM criterio;
END$$

DROP PROCEDURE IF EXISTS `sp_select_criterios_evaluacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_criterios_evaluacion` (IN `a_id_actividad` INT)   BEGIN
SELECT * FROM criterio_evaluacion WHERE id_actividad=a_id_actividad;
END$$

DROP PROCEDURE IF EXISTS `sp_select_critrerio_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_critrerio_alumno` (IN `c_id_alumno` INT, IN `c_id_grupo` INT)   BEGIN
SELECT * FROM criterio_alumno WHERE id_alumno=c_id_alumno AND id_grupo=c_id_grupo;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamentos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamentos` ()   BEGIN
	SELECT * FROM departamento WHERE departamento.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_departamento_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_departamento_id` (IN `d_id_departamento` INT)   BEGIN
	SELECT departamento.id_departamento, departamento.clave, departamento.nombre, departamento.ubicacion, departamento.extension, departamento.correo, departamento_responsable.id_responsable, responsable.nombre AS nombre_responsable, responsable.apellido_p, responsable.apellido_m FROM departamento LEFT JOIN departamento_responsable ON departamento.id_departamento = departamento_responsable.id_departamento LEFT JOIN responsable ON responsable.id_responsable=departamento_responsable.id_responsable WHERE departamento.id_departamento=d_id_departamento AND departamento_responsable.fecha_fin IS NULL;
END$$

DROP PROCEDURE IF EXISTS `sp_select_detalles_inscripcion_alumno_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_detalles_inscripcion_alumno_id` (IN `d_id_alumno` INT)   BEGIN
	 SELECT detalles_inscripcion.*, periodo.fecha_fin_actividades, periodo.nombre as nombre_periodo, actividad.nombre,actividad.creditos_otorga,actividad.fecha_fin FROM detalles_inscripcion JOIN actividad ON detalles_inscripcion.id_actividad=actividad.id_actividad JOIN periodo ON detalles_inscripcion.id_periodo=periodo.id_periodo WHERE id_alumno = d_id_alumno;
END$$

DROP PROCEDURE IF EXISTS `sp_select_directivos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_directivos` ()   BEGIN
SELECT * FROM directivo;
END$$

DROP PROCEDURE IF EXISTS `sp_select_grupos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_grupos` ()   BEGIN
SELECT grupo.*, instructor.nombre as nombre_instructor, instructor.apellido_p, instructor.apellido_m, lugar.nombre as nombre_lugar, caracteristica.nombre as nombre_caracteristica FROM grupo LEFT JOIN lugar ON grupo.id_lugar=lugar.id_lugar LEFT JOIN caracteristica ON grupo.id_caracteristica=caracteristica.id_caracteristica LEFT JOIN instructor ON grupo.id_instructor=instructor.id_instructor JOIN actividad ON grupo.id_actividad=actividad.id_actividad JOIN periodo_actividad ON actividad.id_actividad = periodo_actividad.id_actividad WHERE grupo.visible=1 AND periodo_actividad.id_periodo=periodo_actual() AND actividad.visible=1 AND actividad.fecha_inicio > NOW();
END$$

DROP PROCEDURE IF EXISTS `sp_select_grupos_instructor_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_grupos_instructor_id` (IN `d_id_instructor` INT)   BEGIN
SELECT actividad.nombre as nombre_actividad, grupo.* FROM grupo JOIN actividad ON grupo.id_actividad=actividad.id_actividad JOIN periodo_actividad ON actividad.id_actividad=periodo_actividad.id_actividad WHERE periodo_actividad.id_periodo=periodo_actual() AND grupo.id_instructor=d_id_instructor AND actividad.visible=1 AND grupo.visible=1; 
END$$

DROP PROCEDURE IF EXISTS `sp_select_grupo_actividad_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_grupo_actividad_id` (IN `g_id_actividad` INT)   BEGIN
SELECT grupo.*, instructor.nombre as nombre_instructor, instructor.apellido_p, instructor.apellido_m, lugar.nombre as nombre_lugar, caracteristica.nombre as nombre_caracteristica FROM grupo LEFT JOIN lugar ON grupo.id_lugar=lugar.id_lugar LEFT JOIN caracteristica ON grupo.id_caracteristica=caracteristica.id_caracteristica LEFT JOIN instructor ON grupo.id_instructor=instructor.id_instructor WHERE grupo.id_actividad=g_id_actividad AND grupo.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_grupo_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_grupo_id` (IN `g_id_grupo` INT)   BEGIN
SELECT grupo.*, instructor.nombre as nombre_instructor, instructor.apellido_p, instructor.apellido_m, lugar.nombre as nombre_lugar, caracteristica.nombre as nombre_caracteristica FROM grupo LEFT JOIN lugar ON grupo.id_lugar=lugar.id_lugar LEFT JOIN caracteristica ON grupo.id_caracteristica=caracteristica.id_caracteristica LEFT JOIN instructor ON grupo.id_instructor=instructor.id_instructor WHERE grupo.id_grupo=g_id_grupo;
END$$

DROP PROCEDURE IF EXISTS `sp_select_horarios`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_horarios` ()   BEGIN
SELECT horario.*, grupo_horario.id_grupo FROM horario JOIN grupo_horario ON horario.id_horario=grupo_horario.id_horario JOIN grupo ON grupo_horario.id_grupo=grupo.id_grupo JOIN actividad ON grupo.id_actividad=actividad.id_actividad JOIN periodo_actividad ON actividad.id_actividad=periodo_actividad.id_actividad WHERE grupo.visible=1 AND periodo_actividad.id_periodo=periodo_actual() AND actividad.visible=1 AND actividad.fecha_inicio > NOW();
END$$

DROP PROCEDURE IF EXISTS `sp_select_horarios_carga_complementaria_alumno_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_horarios_carga_complementaria_alumno_id` (IN `c_id_alumno` INT)   BEGIN
SELECT horario.* ,grupo.id_grupo FROM carga_complementaria JOIN carga_grupo ON carga_complementaria.id_carga=carga_grupo.id_carga JOIN grupo ON grupo.id_grupo=carga_grupo.id_grupo JOIN actividad ON grupo.id_actividad = actividad.id_actividad JOIN instructor ON grupo.id_instructor=instructor.id_instructor JOIN lugar ON grupo.id_lugar=lugar.id_lugar JOIN grupo_horario ON grupo.id_grupo=grupo_horario.id_grupo JOIN horario ON grupo_horario.id_horario=horario.id_horario WHERE carga_complementaria.id_alumno=c_id_alumno AND carga_complementaria.id_periodo=periodo_actual();
END$$

DROP PROCEDURE IF EXISTS `sp_select_horarios_grupo_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_horarios_grupo_id` (IN `g_id_grupo` INT)   BEGIN
SELECT horario.*, grupo_horario.id_grupo FROM grupo_horario JOIN grupo ON grupo_horario.id_grupo=grupo.id_grupo JOIN horario ON grupo_horario.id_horario=horario.id_horario WHERE grupo_horario.id_grupo=g_id_grupo;
END$$

DROP PROCEDURE IF EXISTS `sp_select_horario_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_horario_id` (IN `h_id_horario` INT)   BEGIN
SELECT * FROM horario WHERE id_horario = h_id_horario;
END$$

DROP PROCEDURE IF EXISTS `sp_select_instructores_departamento_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_instructores_departamento_id` (IN `i_id_departamento` INT)   BEGIN
SELECT instructor.* FROM instructor JOIN departamento_instructor ON instructor.id_instructor=departamento_instructor.id_instructor WHERE departamento_instructor.id_departamento=i_id_departamento AND departamento_instructor.fecha_fin > NOW() AND departamento_instructor.visible=1 AND instructor.visible=1;
END$$

DROP PROCEDURE IF EXISTS `sp_select_instructor_evidencias`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_instructor_evidencias` (IN `a_id_actividad` INT, IN `a_id_instructor` INT)   BEGIN
SELECT evidencia.* FROM actividad_instructor JOIN evidencia ON actividad_instructor.id_evidencia=evidencia.id_evidencia WHERE id_actividad=a_id_actividad AND id_instructor=a_id_instructor; 
END$$

DROP PROCEDURE IF EXISTS `sp_select_instructor_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_instructor_id` (IN `i_id_instructor` INT)   BEGIN
SELECT * FROM instructor WHERE id_instructor = i_id_instructor;
END$$

DROP PROCEDURE IF EXISTS `sp_select_lugares`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_lugares` ()   BEGIN
SELECT * FROM lugar;
END$$

DROP PROCEDURE IF EXISTS `sp_select_materiales`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_select_materiales` ()   BEGIN
SELECT * FROM material_alumno;
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_actividad` (IN `a_nombre` VARCHAR(200), IN `a_descripcion` VARCHAR(1000), IN `a_competencia` VARCHAR(1000), IN `a_creditos_otorga` INT, IN `a_beneficios` VARCHAR(1000), IN `a_capacidad_min` INT, IN `a_capacidad_max` INT, IN `a_fecha_inicio` DATE, IN `a_fecha_fin` DATE, IN `a_id_actividad` INT, IN `a_actividad_padre` INT, IN `a_video` VARCHAR(200))   BEGIN
START TRANSACTION;
	UPDATE actividad SET nombre=a_nombre, descripcion=a_descripcion, competencia=a_competencia, creditos_otorga=a_creditos_otorga, beneficios=a_beneficios, capacidad_min=a_capacidad_min, capacidad_max=a_capacidad_max, fecha_inicio=a_fecha_inicio, fecha_fin=a_fecha_fin, actividad_padre=a_actividad_padre, video=a_video WHERE id_actividad=a_id_actividad;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_actividad_instructor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_actividad_instructor` (IN `a_id_actividad` INT, IN `a_id_instructor` INT, IN `a_id_evidencia` INT, IN `a_porcentaje` INT)   BEGIN
START TRANSACTION;
UPDATE actividad_instructor SET porcentaje=a_porcentaje WHERE id_actividad=a_id_actividad AND id_instructor=a_id_instructor AND id_evidencia=a_id_evidencia;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_alumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_alumno` (IN `a_estatura` FLOAT, IN `a_peso` FLOAT, IN `a_tipo_sangre` VARCHAR(2), IN `a_talla` VARCHAR(3), IN `a_telefono` VARCHAR(10), IN `a_alergias` VARCHAR(300), IN `a_enfermedades` VARCHAR(300), IN `a_id_alumno` INT)   BEGIN
START TRANSACTION;
UPDATE alumno SET estatura=a_estatura, peso=a_peso, tipo_sangre=a_tipo_sangre, talla=a_talla, telefono=a_telefono, alergias=a_alergias, enfermedades=a_enfermedades WHERE id_alumno=a_id_alumno;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_coordinador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_coordinador` (IN `c_id_coordinador` INT, IN `c_clave` VARCHAR(10), IN `c_nombre` VARCHAR(150), IN `c_apellido_p` VARCHAR(50), IN `c_apellido_m` VARCHAR(50), IN `c_sexo` VARCHAR(1))   BEGIN
START TRANSACTION;
	UPDATE coordinador SET clave=c_clave, nombre=c_nombre, apellido_p=c_apellido_p, apellido_m=c_apellido_m, sexo=c_sexo WHERE id_coordinador=c_id_coordinador;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_departamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_departamento` (IN `d_id_departamento` INT, IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(200), IN `d_ubicacion` VARCHAR(200), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	UPDATE departamento SET clave=d_clave, nombre=d_nombre, ubicacion=d_ubicacion, extension=d_extension, correo=d_correo WHERE id_departamento=d_id_departamento;
    IF 0 <> (SELECT COUNT(*) FROM departamento_responsable WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL) THEN
    	UPDATE departamento_responsable SET fecha_fin=NOW() WHERE id_departamento=d_id_departamento AND fecha_fin IS NULL; 
    END IF;
    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_departamento_responsable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_departamento_responsable` (IN `d_id_departamento` INT, IN `d_clave` VARCHAR(10), IN `d_nombre` VARCHAR(200), IN `d_ubicacion` VARCHAR(200), IN `d_extension` VARCHAR(12), IN `d_correo` VARCHAR(150), IN `r_id` INT)   BEGIN
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

DROP PROCEDURE IF EXISTS `sp_update_grupo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_grupo` (IN `g_id_grupo` INT, IN `g_nombre` VARCHAR(50), IN `g_capacidad_max` INT, IN `g_capacidad_min` INT, IN `g_id_lugar` INT, IN `g_id_caracteristica` INT, IN `g_id_instructor` INT)   BEGIN
START TRANSACTION;
UPDATE grupo SET nombre=g_nombre, capacidad_max=g_capacidad_max, capacidad_min=g_capacidad_min, id_lugar=g_id_lugar, id_caracteristica=g_id_caracteristica, id_instructor=g_id_instructor WHERE id_grupo=g_id_grupo;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_horario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_horario` (IN `h_dia` VARCHAR(20), IN `h_hora_inicio` TIME, IN `h_hora_fin` TIME, IN `h_id_horario` INT)   BEGIN
UPDATE horario SET dia = h_dia, hora_inicio = h_hora_inicio, hora_fin = h_hora_fin WHERE id_horario = h_id_horario;
END$$

DROP PROCEDURE IF EXISTS `sp_update_instructor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_instructor` (IN `i_id_instructor` INT, IN `i_nombre` VARCHAR(150), IN `i_apellido_p` VARCHAR(50), IN `i_apellido_m` VARCHAR(50), IN `i_sexo` VARCHAR(1), IN `i_correo` VARCHAR(150))   BEGIN
START TRANSACTION;
	UPDATE instructor SET nombre=i_nombre, apellido_p=i_apellido_p, apellido_m=i_apellido_m, sexo=i_sexo, correo=i_correo WHERE id_instructor=i_id_instructor;
COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_update_programa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_programa` (IN `p_id_programa` INT, IN `p_clave` VARCHAR(12), IN `p_nombre` VARCHAR(200), IN `p_descripcion` VARCHAR(1000), IN `p_observaciones` VARCHAR(1000))   BEGIN
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
SET periodo = (SELECT id_periodo FROM periodo WHERE NOW()<fecha_fin_actividades);
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
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `competencia` varchar(1000) DEFAULT NULL,
  `creditos_otorga` int(11) NOT NULL,
  `beneficios` varchar(1000) DEFAULT NULL,
  `video` varchar(200) DEFAULT NULL,
  `capacidad_min` int(11) NOT NULL,
  `capacidad_max` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `actividad_padre` int(11) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `id_programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id_actividad`, `nombre`, `descripcion`, `competencia`, `creditos_otorga`, `beneficios`, `video`, `capacidad_min`, `capacidad_max`, `fecha_inicio`, `fecha_fin`, `actividad_padre`, `visible`, `id_programa`) VALUES
(1, 'Futbol Soccer', 'Actividad fisica deportiva que implica la practica y desarrollo de destrezas motrices, asi como las habilidades socio-afectivas, como la coperacion, comunicaci ón y trabajo en equipo, favoreciendo la ', 'Desarrollar habilidades físicas, técnicas y psicológicas a través de la practica de futbol soccer ', 1, 'Pendiente', '../../../assets/videos/1654110192.5251-intro 5 segundos.mp4', 20, 40, '2022-09-05', '2022-12-12', NULL, 1, 1),
(2, 'Dibujo y pintura (Básico)', 'Pendiente', 'Pendiente', 1, 'Pendiente', NULL, 15, 30, '2022-09-05', '2022-12-12', NULL, 1, 2),
(3, 'Dibujo y pintura (Intermedio)', 'Pendiente', 'Pendiente', 1, 'Pendiente', NULL, 15, 30, '2022-09-05', '2022-12-12', NULL, 1, 2),
(5, 'Escolta', NULL, NULL, 1, NULL, NULL, 6, 20, '2022-06-15', '2022-06-30', NULL, 1, 3),
(6, 'Escolta2', NULL, NULL, 1, NULL, NULL, 6, 20, '2022-06-15', '2022-06-29', NULL, 1, 3);

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
-- Estructura de tabla para la tabla `actividad_instructor`
--

DROP TABLE IF EXISTS `actividad_instructor`;
CREATE TABLE `actividad_instructor` (
  `id_actividad` int(11) NOT NULL,
  `id_instructor` int(11) NOT NULL,
  `id_evidencia` int(11) DEFAULT NULL,
  `porcentaje` int(11) DEFAULT NULL
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
-- Estructura de tabla para la tabla `alumno`
--

DROP TABLE IF EXISTS `alumno`;
CREATE TABLE `alumno` (
  `id_alumno` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido_p` varchar(50) NOT NULL,
  `apellido_m` varchar(50) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `contraseña` varchar(20) NOT NULL DEFAULT 'alumno1',
  `semestre` int(11) NOT NULL,
  `carrera` varchar(200) NOT NULL,
  `creditos_totales` int(11) NOT NULL DEFAULT 0,
  `estatura` float DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `tipo_sangre` varchar(2) DEFAULT NULL,
  `talla` varchar(3) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `alergias` varchar(300) DEFAULT NULL,
  `enfermedades` varchar(300) DEFAULT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id_alumno`, `nombre`, `apellido_p`, `apellido_m`, `correo`, `contraseña`, `semestre`, `carrera`, `creditos_totales`, `estatura`, `peso`, `tipo_sangre`, `talla`, `telefono`, `alergias`, `enfermedades`, `foto`, `visible`) VALUES
(1, 'José Ricardo', 'Baeza', 'Candor', '17460069@colima.tecnm.mx', 'alumno1', 10, 'Ing. en Sistemas Computacionales', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Victor Hugo', 'Del Rio', 'Ramos', '17460066@colima.tecnm.mx', 'alumno1', 10, 'Ing. en Sistemas Computacionales', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristica`
--

DROP TABLE IF EXISTS `caracteristica`;
CREATE TABLE `caracteristica` (
  `id_caracteristica` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `caracteristica`
--

INSERT INTO `caracteristica` (`id_caracteristica`, `nombre`) VALUES
(2, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carga_actividad`
--

DROP TABLE IF EXISTS `carga_actividad`;
CREATE TABLE `carga_actividad` (
  `id_carga` int(11) DEFAULT NULL,
  `id_actividad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carga_actividad`
--

INSERT INTO `carga_actividad` (`id_carga`, `id_actividad`) VALUES
(1, 1),
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carga_complementaria`
--

DROP TABLE IF EXISTS `carga_complementaria`;
CREATE TABLE `carga_complementaria` (
  `id_carga` int(11) NOT NULL,
  `id_alumno` int(11) DEFAULT NULL,
  `id_periodo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carga_complementaria`
--

INSERT INTO `carga_complementaria` (`id_carga`, `id_alumno`, `id_periodo`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carga_grupo`
--

DROP TABLE IF EXISTS `carga_grupo`;
CREATE TABLE `carga_grupo` (
  `id_carga` int(11) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carga_grupo`
--

INSERT INTO `carga_grupo` (`id_carga`, `id_grupo`) VALUES
(1, 1),
(1, 6),
(2, 8);

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
(1, '190', 'Ariel', 'Lira', 'Obando', 'M', NULL),
(2, '210', 'Benjamín', 'Medina', 'Ventura', 'M', NULL),
(3, '232', 'Hugo Gerardo', 'Castrejón', 'Cerro', 'M', NULL);

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
(1, 3, '2022-08-15', NULL),
(2, 2, '2022-08-15', NULL),
(3, 1, '2022-08-15', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterio`
--

DROP TABLE IF EXISTS `criterio`;
CREATE TABLE `criterio` (
  `id_criterio` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `criterio`
--

INSERT INTO `criterio` (`id_criterio`, `nombre`, `descripcion`) VALUES
(1, 'Criterio 1', 'Ejemplo Criterio 1'),
(2, 'Criterio 2', 'Ejemplo Criterio 2'),
(3, 'Criterio 3', 'Ejemplo Criterio 3'),
(4, 'Criterio 4', 'Ejemplo Criterio 4'),
(5, 'Criterio 5', 'Ejemplo Criterio 5'),
(6, 'Criterio 6', 'Ejemplo Criterio 6'),
(7, 'Criterio 7', 'Ejemplo Criterio 7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterio_alumno`
--

DROP TABLE IF EXISTS `criterio_alumno`;
CREATE TABLE `criterio_alumno` (
  `desempeño` int(11) DEFAULT NULL,
  `id_alumno` int(11) DEFAULT NULL,
  `id_criterio` int(11) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `criterio_alumno`
--

INSERT INTO `criterio_alumno` (`desempeño`, `id_alumno`, `id_criterio`, `id_grupo`) VALUES
(4, 1, 1, 1),
(4, 1, 2, 1),
(4, 1, 3, 1),
(4, 1, 4, 1),
(4, 1, 5, 1),
(4, 1, 6, 1),
(4, 1, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterio_evaluacion`
--

DROP TABLE IF EXISTS `criterio_evaluacion`;
CREATE TABLE `criterio_evaluacion` (
  `id_criterio` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `criterio_evaluacion`
--

INSERT INTO `criterio_evaluacion` (`id_criterio`, `nombre`, `descripcion`, `id_actividad`) VALUES
(1, 'asistencia', 'prediente', 1),
(2, 'participacion en torneo', 'prediente', 1),
(3, 'Asistencia', 'Pendiente', 2),
(4, 'Participación en clase', 'Pendiente', 2),
(5, 'Presentación de obras', 'Pendiente', 2),
(6, 'Asistencia', 'Pendiente', 3),
(7, 'Participación en clase', 'Pendiente', 3),
(8, 'Presentación de obras', 'Pendiente', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

DROP TABLE IF EXISTS `departamento`;
CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `clave` varchar(10) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `ubicacion` varchar(200) NOT NULL,
  `extension` varchar(12) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contraseña` varchar(20) NOT NULL DEFAULT 'responsable1',
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `clave`, `nombre`, `ubicacion`, `extension`, `correo`, `contraseña`, `visible`) VALUES
(1, 'DEXT', 'Departamento de Actividades Extraescolares', 'Edificio R', '098', 'formacion.integral@colima.tecnm.mx', 'responsable1', 1);

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
(1, 1, '2022-05-26', NULL, 1),
(1, 2, '2022-05-26', NULL, 1),
(1, 3, '2022-05-26', NULL, 1);

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
(1, 1, '2022-09-05', '2022-12-12', 1),
(1, 2, '2022-09-05', '2022-12-12', 1);

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
(1, 1, 'coordinacion.deportiva@colima.tecnm.mx', 'coordinador1'),
(1, 2, 'coordinacion.cultural@colima.tecnm.mx', 'coordinador1'),
(1, 3, 'coordinacion.civica@colima.tecnm.mx', 'coordinador1');

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
(1, 1, '2022-05-26', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_inscripcion`
--

DROP TABLE IF EXISTS `detalles_inscripcion`;
CREATE TABLE `detalles_inscripcion` (
  `calificacion_numerica` int(11) NOT NULL DEFAULT 0,
  `desempeño` int(11) NOT NULL DEFAULT 1,
  `acreditacion` tinyint(1) NOT NULL DEFAULT 0,
  `constancia` tinyint(1) NOT NULL DEFAULT 1,
  `id_alumno` int(11) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `id_actividad` int(11) DEFAULT NULL,
  `id_periodo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalles_inscripcion`
--

INSERT INTO `detalles_inscripcion` (`calificacion_numerica`, `desempeño`, `acreditacion`, `constancia`, `id_alumno`, `id_grupo`, `id_actividad`, `id_periodo`) VALUES
(10, 4, 1, 1, 1, 1, 1, 1),
(0, 1, 0, 1, 1, 6, 2, 1),
(0, 1, 0, 1, 2, 8, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directivo`
--

DROP TABLE IF EXISTS `directivo`;
CREATE TABLE `directivo` (
  `id_directivo` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido_p` varchar(50) NOT NULL,
  `apellido_m` varchar(50) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contraseña` varchar(20) NOT NULL DEFAULT 'directivo1',
  `foto` int(150) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencia`
--

DROP TABLE IF EXISTS `evidencia`;
CREATE TABLE `evidencia` (
  `id_evidencia` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `nombre`, `capacidad_max`, `capacidad_min`, `total_inscripciones`, `visible`, `id_actividad`, `id_lugar`, `id_caracteristica`, `id_instructor`) VALUES
(1, 'A', 40, 20, 1, 1, 1, 1, 2, 1),
(2, 'B', 40, 20, 0, 1, 1, 1, 2, 1),
(3, 'C', 40, 20, 0, 1, 1, 1, 2, 1),
(4, 'D', 40, 20, 0, 1, 1, 1, 2, 1),
(5, 'A', 30, 15, 0, 1, 2, 2, 2, 2),
(6, 'B', 30, 15, 1, 1, 2, 2, 2, 2),
(7, 'C', 30, 15, 0, 1, 2, 2, 2, 2),
(8, 'A', 30, 15, 1, 1, 3, 2, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_horario`
--

DROP TABLE IF EXISTS `grupo_horario`;
CREATE TABLE `grupo_horario` (
  `id_grupo` int(11) DEFAULT NULL,
  `id_horario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `grupo_horario`
--

INSERT INTO `grupo_horario` (`id_grupo`, `id_horario`) VALUES
(1, 1),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 7),
(7, 8),
(8, 9);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `dia`, `hora_inicio`, `hora_fin`) VALUES
(1, 'Martes', '17:00:00', '19:00:00'),
(3, 'Jueves', '17:00:00', '19:00:00'),
(4, 'Sábado', '08:00:00', '10:00:00'),
(5, 'Sábado', '10:00:00', '12:00:00'),
(6, 'Lunes', '16:00:00', '18:00:00'),
(7, 'Martes', '16:00:00', '18:00:00'),
(8, 'Jueves', '16:00:00', '18:00:00'),
(9, 'Viernes', '16:00:00', '18:00:00');

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
  `sexo` varchar(1) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contraseña` varchar(20) NOT NULL DEFAULT 'instructor1',
  `foto` varchar(150) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `instructor`
--

INSERT INTO `instructor` (`id_instructor`, `nombre`, `apellido_m`, `apellido_p`, `sexo`, `correo`, `contraseña`, `foto`, `visible`) VALUES
(1, 'Benjamin', 'Ventura', 'Medina', 'M', 'benjamin.medina@colima.tecnm.mx', 'instructor1', NULL, 1),
(2, 'Efraín', 'Ponce', 'Díaz', 'M', 'efrain.diaz@colima.tecnm.mx', 'instructor1', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

DROP TABLE IF EXISTS `lugar`;
CREATE TABLE `lugar` (
  `id_lugar` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `capacidad_max` int(11) NOT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `foto_1` varchar(200) DEFAULT NULL,
  `foto_2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lugar`
--

INSERT INTO `lugar` (`id_lugar`, `nombre`, `capacidad_max`, `observaciones`, `foto_1`, `foto_2`) VALUES
(1, 'Cancha de futbol', 240, NULL, NULL, NULL),
(2, 'Plaza Cultural', 30, 'Pendiente', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_actividad`
--

DROP TABLE IF EXISTS `material_actividad`;
CREATE TABLE `material_actividad` (
  `id_material_actividad` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `material_actividad`
--

INSERT INTO `material_actividad` (`id_material_actividad`, `nombre`, `cantidad`, `id_actividad`) VALUES
(1, 'Balones', 20, 1),
(2, 'Conos', 40, 1),
(3, 'Estacas', 20, 1),
(4, 'casacas', 20, 1),
(5, 'Porterias pequeñas', 16, 1),
(6, 'platos', 40, 1),
(7, 'vallas', 20, 1),
(8, 'Mesas de trabajo', 30, 2),
(9, 'Brochas de 5 pulgadas', 2, 2),
(10, 'Galón pintura vinilica blanca', 1, 2),
(11, 'sillas', 30, 2),
(12, 'Mesas de trabajo', 30, 3),
(13, 'Brochas de 5 pulgadas', 2, 3),
(14, 'Galón pintura vinilica blanca', 1, 3),
(15, 'sillas', 30, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_alumno`
--

DROP TABLE IF EXISTS `material_alumno`;
CREATE TABLE `material_alumno` (
  `id_material_alumno` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `material_alumno`
--

INSERT INTO `material_alumno` (`id_material_alumno`, `nombre`, `cantidad`, `id_actividad`) VALUES
(1, 'Zapatos de futbol', 1, 1),
(2, 'Short', 1, 1),
(3, 'Playera deportiva', 1, 1),
(4, 'Espinilleras', 2, 1),
(5, 'calcetas', 2, 1),
(6, 'Brochas de 5 pulgadas', 1, 2),
(7, 'Brochas de 5 pulgadas', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo`
--

DROP TABLE IF EXISTS `periodo`;
CREATE TABLE `periodo` (
  `id_periodo` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `fecha_inicio_actividades` date NOT NULL,
  `fecha_fin_actividades` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodo`
--

INSERT INTO `periodo` (`id_periodo`, `nombre`, `fecha_inicio_actividades`, `fecha_fin_actividades`) VALUES
(1, 'Ago-Dic 2022', '2022-08-22', '2022-12-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_actividad`
--

DROP TABLE IF EXISTS `periodo_actividad`;
CREATE TABLE `periodo_actividad` (
  `id_periodo` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodo_actividad`
--

INSERT INTO `periodo_actividad` (`id_periodo`, `id_actividad`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

DROP TABLE IF EXISTS `programa`;
CREATE TABLE `programa` (
  `id_programa` int(11) NOT NULL,
  `clave` varchar(12) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id_programa`, `clave`, `nombre`, `descripcion`, `observaciones`, `visible`) VALUES
(1, 'PDEP', 'Programa Deportivo', NULL, NULL, 1),
(2, 'PCUL', 'Programa Cultural', NULL, NULL, 1),
(3, 'PCIV', 'Programa Cívico', NULL, NULL, 1);

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
(1, '190', 'Ariel', 'Lira', 'Obando', 'M', 'alira@colima.tecnm.mx', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

DROP TABLE IF EXISTS `tema`;
CREATE TABLE `tema` (
  `id_tema` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `semanas` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`id_tema`, `nombre`, `descripcion`, `semanas`, `id_actividad`) VALUES
(1, 'Movilidad general y especifica para futbol', 'prediente', 1, 1),
(2, 'Fundamento tectnicos (pase,resepcion,conducción)', 'prediente', 2, 1),
(3, 'Acondicionamiento Fisico', 'prediente', 1, 1),
(4, 'Mini futbol (3 vs 3, 4 vs 4, 5 vs 5)', 'prediente', 1, 1),
(5, 'Rondas', 'prediente', 1, 1),
(6, 'Juegos de posicion', 'prediente', 1, 1),
(7, 'Situacion estaticas', 'prediente', 1, 1),
(8, 'espacio reducudo', 'prediente', 1, 1),
(9, 'fuerza por situaciones tacticas de juego', 'prediente', 1, 1),
(10, 'Partidos condicionados', 'prediente', 2, 1),
(11, 'Dibujo a mano alzada', 'Pendiente', 1, 2),
(12, 'Dibujo a mano alzada', 'Pendiente', 1, 3);

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
-- Indices de la tabla `actividad_instructor`
--
ALTER TABLE `actividad_instructor`
  ADD UNIQUE KEY `id_actividad` (`id_actividad`,`id_instructor`,`id_evidencia`),
  ADD KEY `id_instructor` (`id_instructor`),
  ADD KEY `id_evidencia` (`id_evidencia`);

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id_alumno`);

--
-- Indices de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  ADD PRIMARY KEY (`id_caracteristica`);

--
-- Indices de la tabla `carga_actividad`
--
ALTER TABLE `carga_actividad`
  ADD UNIQUE KEY `id_carga` (`id_carga`,`id_actividad`),
  ADD KEY `id_actividad` (`id_actividad`);

--
-- Indices de la tabla `carga_complementaria`
--
ALTER TABLE `carga_complementaria`
  ADD PRIMARY KEY (`id_carga`),
  ADD KEY `id_periodo` (`id_periodo`),
  ADD KEY `id_alumno` (`id_alumno`) USING BTREE;

--
-- Indices de la tabla `carga_grupo`
--
ALTER TABLE `carga_grupo`
  ADD UNIQUE KEY `id_carga` (`id_carga`,`id_grupo`),
  ADD KEY `id_grupo` (`id_grupo`);

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
-- Indices de la tabla `criterio`
--
ALTER TABLE `criterio`
  ADD PRIMARY KEY (`id_criterio`);

--
-- Indices de la tabla `criterio_alumno`
--
ALTER TABLE `criterio_alumno`
  ADD UNIQUE KEY `id_alumno` (`id_alumno`,`id_grupo`,`id_criterio`),
  ADD KEY `id_criterio` (`id_criterio`),
  ADD KEY `id_grupo` (`id_grupo`);

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
-- Indices de la tabla `detalles_inscripcion`
--
ALTER TABLE `detalles_inscripcion`
  ADD UNIQUE KEY `id_alumno` (`id_alumno`,`id_grupo`,`id_actividad`,`id_periodo`) USING BTREE,
  ADD KEY `id_grupo` (`id_grupo`),
  ADD KEY `id_actividad` (`id_actividad`),
  ADD KEY `id_periodo` (`id_periodo`);

--
-- Indices de la tabla `directivo`
--
ALTER TABLE `directivo`
  ADD PRIMARY KEY (`id_directivo`);

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
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  MODIFY `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `carga_complementaria`
--
ALTER TABLE `carga_complementaria`
  MODIFY `id_carga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  MODIFY `id_coordinador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `criterio`
--
ALTER TABLE `criterio`
  MODIFY `id_criterio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `criterio_evaluacion`
--
ALTER TABLE `criterio_evaluacion`
  MODIFY `id_criterio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `directivo`
--
ALTER TABLE `directivo`
  MODIFY `id_directivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evidencia`
--
ALTER TABLE `evidencia`
  MODIFY `id_evidencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id_instructor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `lugar`
--
ALTER TABLE `lugar`
  MODIFY `id_lugar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `material_actividad`
--
ALTER TABLE `material_actividad`
  MODIFY `id_material_actividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `material_alumno`
--
ALTER TABLE `material_alumno`
  MODIFY `id_material_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `periodo`
--
ALTER TABLE `periodo`
  MODIFY `id_periodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `programa`
--
ALTER TABLE `programa`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `responsable`
--
ALTER TABLE `responsable`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad_evidencia`
--
ALTER TABLE `actividad_evidencia`
  ADD CONSTRAINT `actividad_evidencia_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`),
  ADD CONSTRAINT `actividad_evidencia_ibfk_2` FOREIGN KEY (`id_evidencia`) REFERENCES `evidencia` (`id_evidencia`);

--
-- Filtros para la tabla `actividad_instructor`
--
ALTER TABLE `actividad_instructor`
  ADD CONSTRAINT `actividad_instructor_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`),
  ADD CONSTRAINT `actividad_instructor_ibfk_2` FOREIGN KEY (`id_instructor`) REFERENCES `instructor` (`id_instructor`),
  ADD CONSTRAINT `actividad_instructor_ibfk_3` FOREIGN KEY (`id_evidencia`) REFERENCES `evidencia` (`id_evidencia`);

--
-- Filtros para la tabla `carga_actividad`
--
ALTER TABLE `carga_actividad`
  ADD CONSTRAINT `carga_actividad_ibfk_1` FOREIGN KEY (`id_carga`) REFERENCES `carga_complementaria` (`id_carga`),
  ADD CONSTRAINT `carga_actividad_ibfk_2` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`);

--
-- Filtros para la tabla `carga_complementaria`
--
ALTER TABLE `carga_complementaria`
  ADD CONSTRAINT `carga_complementaria_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `carga_complementaria_ibfk_2` FOREIGN KEY (`id_periodo`) REFERENCES `periodo` (`id_periodo`);

--
-- Filtros para la tabla `carga_grupo`
--
ALTER TABLE `carga_grupo`
  ADD CONSTRAINT `carga_grupo_ibfk_1` FOREIGN KEY (`id_carga`) REFERENCES `carga_complementaria` (`id_carga`),
  ADD CONSTRAINT `carga_grupo_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`);

--
-- Filtros para la tabla `coordinador_programa`
--
ALTER TABLE `coordinador_programa`
  ADD CONSTRAINT `coordinador_programa_ibfk_1` FOREIGN KEY (`id_coordinador`) REFERENCES `coordinador` (`id_coordinador`),
  ADD CONSTRAINT `coordinador_programa_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`);

--
-- Filtros para la tabla `criterio_alumno`
--
ALTER TABLE `criterio_alumno`
  ADD CONSTRAINT `criterio_alumno_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `criterio_alumno_ibfk_2` FOREIGN KEY (`id_criterio`) REFERENCES `criterio_evaluacion` (`id_criterio`),
  ADD CONSTRAINT `criterio_alumno_ibfk_3` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`);

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
-- Filtros para la tabla `detalles_inscripcion`
--
ALTER TABLE `detalles_inscripcion`
  ADD CONSTRAINT `detalles_inscripcion_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `detalles_inscripcion_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`),
  ADD CONSTRAINT `detalles_inscripcion_ibfk_3` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`),
  ADD CONSTRAINT `detalles_inscripcion_ibfk_4` FOREIGN KEY (`id_periodo`) REFERENCES `periodo` (`id_periodo`),
  ADD CONSTRAINT `detalles_inscripcion_ibfk_5` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`);

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
