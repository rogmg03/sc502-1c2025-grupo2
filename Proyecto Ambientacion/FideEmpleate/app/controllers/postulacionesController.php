<?php
namespace app\controllers;

use app\models\mainModel;
use PDO;

class postulacionesController extends mainModel
{

    public function obtenerPostulacionesAsignadas($idReclutador)
    {
        $sql = "
            SELECT 
                p.id_postulacion,
                u.id_usuario AS id_estudiante,
                u.nombre_completo,
                e.nombre_puesto,
                p.fecha_postulacion,
                p.estado
            FROM postulaciones p
            INNER JOIN procesos_reclutamiento pr ON pr.id_postulacion = p.id_postulacion
            INNER JOIN usuarios u ON p.id_usuario_estudiante = u.id_usuario
            INNER JOIN empleos e ON p.id_empleo = e.id_empleo
            WHERE pr.id_reclutador_asignado = :idReclutador
            ORDER BY p.fecha_postulacion DESC
        ";

        $stmt = $this->ejecutarConsultaParametros($sql, [':idReclutador' => $idReclutador]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstadoYObservacion($idPostulacion, $nuevoEstado, $observacion, $idReclutador)
    {
        // Verifica que el proceso pertenezca al reclutador en sesión
        $verificar = $this->ejecutarConsultaParametros("
            SELECT id_proceso FROM procesos_reclutamiento 
            WHERE id_postulacion = :idPost AND id_reclutador_asignado = :idRec
        ", [
            ':idPost' => $idPostulacion,
            ':idRec' => $idReclutador
        ])->fetch();

        if (!$verificar)
            return false;

        // Actualiza el estado de la postulación
        $this->ejecutarConsultaParametros("
            UPDATE postulaciones 
            SET estado = :estado 
            WHERE id_postulacion = :idPost
        ", [
            ':estado' => $nuevoEstado,
            ':idPost' => $idPostulacion
        ]);

        // Actualiza la observación en el proceso
        $this->ejecutarConsultaParametros("
            UPDATE procesos_reclutamiento 
            SET observaciones = :obs 
            WHERE id_postulacion = :idPost AND id_reclutador_asignado = :idRec
        ", [
            ':obs' => $observacion,
            ':idPost' => $idPostulacion,
            ':idRec' => $idReclutador
        ]);

        return true;
    }

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

    public function obtenerDetallePostulacion($id_postulacion, $id_estudiante)
    {
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

    public function cancelarPostulacion($id_postulacion, $id_estudiante)
    {
        $this->ejecutarConsultaParametros(
            "DELETE FROM procesos_reclutamiento WHERE id_postulacion = :id",
            [
                ":id" => $id_postulacion
            ]
        );
        $sql = "DELETE FROM postulaciones WHERE id_postulacion = :id AND id_usuario_estudiante = :user";
        $stmt = $this->ejecutarConsultaParametros($sql, [
            ":id" => $id_postulacion,
            ":user" => $id_estudiante
        ]);
        return $stmt->rowCount() > 0;
    }

}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_postulacion'], $_POST['nuevo_estado'], $_POST['observacion'])) {
    $controller = new postulacionesController();
    $success = $controller->actualizarEstadoYObservacion(
        $_POST['id_postulacion'],
        $_POST['nuevo_estado'],
        $_POST['observacion'],
        $_SESSION['id']
    );

    if ($success) {
        $_SESSION['postulacion_actualizada'] = "Postulación actualizada correctamente.";
    } else {
        $_SESSION['postulacion_actualizada'] = "No tienes permiso para modificar esta postulación.";
    }

    header("Location: " . APP_URL . "a-postings/");
    exit();
}
