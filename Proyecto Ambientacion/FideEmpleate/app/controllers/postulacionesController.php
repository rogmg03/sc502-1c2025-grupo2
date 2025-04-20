<?php

namespace app\controllers;
use app\models\mainModel;
use PDO;

class verPostulacionesController extends mainModel {

    public function obtenerPostulacionesPorEstudiante($id_estudiante) {
        if (empty($id_estudiante)) {
            return [];
        }

        $consulta = "
            SELECT 
                p.id_postulacion,
                e.nombre_puesto,
                e.area,
                e.modalidad,
                e.ubicacion,
                e.salario,
                e.fecha_publicacion,
                p.estado,
                p.fecha_postulacion
            FROM postulaciones p
            INNER JOIN empleos e ON p.id_empleo = e.id_empleo
            WHERE p.id_usuario_estudiante = :id
            ORDER BY p.fecha_postulacion DESC
        ";

        $stmt = $this->ejecutarConsultaParametros($consulta, [":id" => $id_estudiante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDetallePostulacion($id_postulacion, $id_estudiante) {
        $consulta = "
            SELECT 
                p.id_postulacion,
                e.nombre_puesto,
                e.descripcion,
                e.requisitos,
                e.modalidad,
                e.ubicacion,
                e.salario,
                p.estado,
                pr.observaciones,
                pr.fecha_asignacion
            FROM postulaciones p
            JOIN empleos e ON p.id_empleo = e.id_empleo
            LEFT JOIN procesos_reclutamiento pr ON pr.id_postulacion = p.id_postulacion
            WHERE p.id_postulacion = :id_postulacion
              AND p.id_usuario_estudiante = :id_estudiante
        ";
    
        return $this->ejecutarConsultaParametros($consulta, [
            ":id_postulacion" => $id_postulacion,
            ":id_estudiante" => $id_estudiante
        ])->fetch(PDO::FETCH_ASSOC);
    }
    
    public function cancelarPostulacion($id_postulacion, $id_estudiante) {
        $this->ejecutarConsultaParametros(
            "DELETE FROM procesos_reclutamiento WHERE id_postulacion = :id",
            [":id" => $id_postulacion
        ]);        
        $sql = "DELETE FROM postulaciones WHERE id_postulacion = :id AND id_usuario_estudiante = :user";
        $stmt = $this->ejecutarConsultaParametros($sql, [
            ":id" => $id_postulacion,
            ":user" => $id_estudiante
        ]);
        return $stmt->rowCount() > 0;
    }
    
}
