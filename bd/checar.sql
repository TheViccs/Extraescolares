--FALTAN PROCEDIMIENTOS PARA CRITERIO_ALUMNO
--FALTAN PROCEDIMIENTOS PARA DETALLES_INSCRIPCION

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_insert_detalles_inscripcion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_detalles_inscripcion` ()   
BEGIN
START TRANSACTION;
	CREATE TEMPORARY TABLE actividades_nombre_igual(
    	id_actividad INT
	); 
    SET @nombre_actividad = SELECT nombre FROM actividad WHERE id_actividad=d_id_actividad;
    INSERT INTO actividades_nombre_igual SELECT id_actividad FROM actividad WHERE nombre=@nombre_actividad;
	IF 2 > (SELECT COUNT(*) FROM detalles_inscripcion WHERE id_alumno=d_id_alumno AND id_periodo=periodo_actual()) THEN
    	IF 1 > (SELECT COUNT(*) FROM detalles_inscripcion WHERE id_alumno=d_id_alumno AND id_actividad IN (SELECT * FROM actividades_nombre_igual)) THEN
        	
        END IF;
    END IF;
COMMIT;
END$$
DELIMITER ;