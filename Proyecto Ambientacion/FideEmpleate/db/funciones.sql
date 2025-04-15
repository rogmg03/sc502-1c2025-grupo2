-- Función: Total de empleos publicados por un reclutador
DROP FUNCTION IF EXISTS fn_total_empleos_publicados;
DELIMITER $$
CREATE FUNCTION fn_total_empleos_publicados(reclutador_id INT)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM empleos WHERE id_usuario_reclutador = reclutador_id;
    RETURN total;
END$$
DELIMITER ;

-- Función: Total de estudiantes registrados
DROP FUNCTION IF EXISTS fn_total_estudiantes;
DELIMITER $$
CREATE FUNCTION fn_total_estudiantes()
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM usuarios WHERE rol = 'Estudiante';
    RETURN total;
END$$
DELIMITER ;

-- Función: Total de postulaciones recibidas por un reclutador
DROP FUNCTION IF EXISTS fn_total_postulaciones_reclutador;
DELIMITER $$

CREATE FUNCTION fn_total_postulaciones_reclutador(reclutador_id INT)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE total INT;

    SELECT COUNT(DISTINCT p.id_usuario_estudiante)
    INTO total
    FROM postulaciones p
    INNER JOIN empleos e ON p.id_empleo = e.id_empleo
    WHERE e.id_usuario_reclutador = reclutador_id;

    RETURN total;
END$$

DELIMITER ;

DROP FUNCTION IF EXISTS fn_tiempo_empleado_estudiante_meses;
DELIMITER $$

CREATE FUNCTION fn_tiempo_empleado_estudiante_meses(estudiante_id INT)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE total_meses INT;

    SELECT SUM(
        PERIOD_DIFF(
            DATE_FORMAT(IFNULL(el.fecha_finalizacion, CURDATE()), '%Y%m'),
            DATE_FORMAT(el.fecha_inicio, '%Y%m')
        )
    )
    INTO total_meses
    FROM cv c
    INNER JOIN cv_experiencia ce ON ce.id_cv = c.id_cv
    INNER JOIN experiencia_laboral el ON el.id_experiencia = ce.id_experiencia
    WHERE c.id_usuario = estudiante_id AND c.activo = 1;

    RETURN IFNULL(total_meses, 0);
END$$

DELIMITER ;





DROP PROCEDURE IF EXISTS sp_estudiante_con_mas_experiencia;
DELIMITER $$

CREATE PROCEDURE sp_estudiante_con_mas_experiencia()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE estudiante_id INT;
    DECLARE mejor_id INT DEFAULT NULL;
    DECLARE max_meses INT DEFAULT -1;
    DECLARE meses_actual INT;

    DECLARE cur CURSOR FOR 
        SELECT id_usuario FROM usuarios WHERE rol = 'Estudiante';

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO estudiante_id;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET meses_actual = fn_tiempo_empleado_estudiante_meses(estudiante_id);

        IF meses_actual > max_meses THEN
            SET max_meses = meses_actual;
            SET mejor_id = estudiante_id;
        END IF;
    END LOOP;

    CLOSE cur;

    SELECT mejor_id AS id_top_estudiante;
END$$

DELIMITER ;




