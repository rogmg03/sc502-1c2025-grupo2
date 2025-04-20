<?php
namespace app\controllers;

use app\models\mainModel;
use PDO;

class postulacionesController extends mainModel {

    public function obtenerPostulacionesAsignadas($idReclutador) {
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

    public function actualizarEstadoYObservacion($idPostulacion, $nuevoEstado, $observacion, $idReclutador) {
        // Verifica que el proceso pertenezca al reclutador en sesión
        $verificar = $this->ejecutarConsultaParametros("
            SELECT id_proceso FROM procesos_reclutamiento 
            WHERE id_postulacion = :idPost AND id_reclutador_asignado = :idRec
        ", [
            ':idPost' => $idPostulacion,
            ':idRec' => $idReclutador
        ])->fetch();

        if (!$verificar) return false;

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
