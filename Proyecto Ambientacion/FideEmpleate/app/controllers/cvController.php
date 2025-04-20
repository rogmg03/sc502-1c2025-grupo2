<?php

namespace app\controllers;

use app\models\mainModel;

class cvController extends mainModel {

    public function obtenerCurriculumsUsuario($id_usuario) {
        $sql = "
            SELECT 
                cv.id_cv,
                ip.estudiante_de AS titulo,
                cv.activo
            FROM cv
            INNER JOIN informacion_personal ip ON cv.id_informacion_personal = ip.id_personal
            WHERE cv.id_usuario = :id_usuario
        ";

        $stmt = $this->ejecutarConsultaParametros($sql, [':id_usuario' => $id_usuario]);

        $resultados = [];

        if ($stmt && $stmt->rowCount() > 0) {
            while ($fila = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $resultados[] = [
                    'id_cv'   => $fila['id_cv'],
                    'titulo'  => $fila['titulo'],
                    'estado'  => $fila['activo'] ? 'Activo' : 'Inactivo'
                ];
            }
        }

        return $resultados;
    }

    public function eliminarCV($id_cv) {
        $sql = "DELETE FROM cv WHERE id_cv = :id_cv";
        return $this->ejecutarConsultaParametros($sql, [':id_cv' => $id_cv]);
    }

    public function activarCV($id_cv, $id_usuario) {
        // Desactivar todos los CV del usuario
        $this->ejecutarConsultaParametros(
            "UPDATE cv SET activo = 0 WHERE id_usuario = :id",
            [':id' => $id_usuario]
        );

        // Activar solo el seleccionado
        return $this->ejecutarConsultaParametros(
            "UPDATE cv SET activo = 1 WHERE id_cv = :id_cv",
            [':id_cv' => $id_cv]
        );
    }

    public function manejarAcciones() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';
            $id_cv = intval($_POST['id_cv'] ?? 0);
            $id_usuario = $_SESSION['id'] ?? 0;
    
            if ($accion === 'eliminar') {
                $this->eliminarCV($id_cv);
                $_SESSION['mensaje'] = ['texto' => 'Currículum eliminado exitosamente.', 'tipo' => 'success'];
            } elseif ($accion === 'activar') {
                $this->activarCV($id_cv, $id_usuario);
                $_SESSION['mensaje'] = ['texto' => 'Currículum activado correctamente.', 'tipo' => 'success'];
            }
    
            header("Location: " . APP_URL . "s-view-cv/");
            exit();
        }
    }
    
}
