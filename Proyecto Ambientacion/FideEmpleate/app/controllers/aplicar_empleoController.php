<?php

namespace app\controllers;
use app\models\mainModel;

class aplicar_empleoController extends mainModel {

    public function aplicar_empleoController() {
        // Obtener y limpiar datos
        $id_empleo = $this->limpiarCadena($_POST['id_empleo'] ?? '');
        $id_estudiante = $this->limpiarCadena($_POST['id_alumno'] ?? '');

        // Validar campos obligatorios
        if (empty($id_empleo) || empty($id_estudiante)) {
            return "Faltan datos para aplicar.";
        }

        // Validar que el empleo exista y esté activo
        $verificar_empleo = $this->ejecutarConsultaParametros(
            "SELECT estado FROM empleos WHERE id_empleo = :id",
            [":id" => $id_empleo]
        );

        $estado = $verificar_empleo->fetchColumn();
        if (!$estado) {
            return "El empleo no existe.";
        }

        if ($estado !== 'Activo') {
            return "No puedes aplicar a un empleo inactivo.";
        }

        // Verificar si ya aplicó anteriormente
        $verificacion = $this->ejecutarConsultaParametros(
            "SELECT 1 FROM postulaciones WHERE id_empleo = :Empleo AND id_usuario_estudiante = :Estudiante",
            [
                ":Empleo" => $id_empleo,
                ":Estudiante" => $id_estudiante
            ]
        );

        if ($verificacion->rowCount() > 0) {
            return "Ya has aplicado a este empleo.";
        }

        // Datos para insertar la postulación
        $datos = [
            ["campo_nombre" => "id_usuario_estudiante", "campo_marcador" => ":Estudiante", "campo_valor" => $id_estudiante],
            ["campo_nombre" => "id_empleo", "campo_marcador" => ":Empleo", "campo_valor" => $id_empleo],
            ["campo_nombre" => "fecha_postulacion", "campo_marcador" => ":Fecha", "campo_valor" => date("Y-m-d H:i:s")],
            ["campo_nombre" => "estado", "campo_marcador" => ":Estado", "campo_valor" => "Postulado"]
        ];

        $guardar = $this->guardarDatos("postulaciones", $datos);

        if ($guardar->rowCount() == 1) {
            return "¡Aplicación enviada correctamente!";
        } else {
            return "Error al aplicar. Inténtalo más tarde.";
        }
    }
}

