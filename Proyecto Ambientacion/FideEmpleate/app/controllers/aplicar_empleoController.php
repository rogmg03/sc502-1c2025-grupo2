<?php

namespace app\controllers;
use app\models\mainModel;

class aplicar_empleoController extends mainModel {

    public function aplicar_empleoController() {
        // Limpiar los datos recibidos
        $id_empleo = $this->limpiarCadena($_POST['id_empleo'] ?? '');
        $id_alumno = $this->limpiarCadena($_POST['id_alumno'] ?? '');

        // Validación de datos obligatorios
        if (empty($id_empleo) || empty($id_alumno)) {
            return "Faltan datos para aplicar.";
        }

        // Verificar si ya ha aplicado anteriormente
        $verificacion = $this->ejecutarConsultaParametros(
            "SELECT 1 FROM aplicaciones WHERE id_empleo = :Empleo AND id_alumno = :Alumno",
            [
                ":Empleo" => $id_empleo,
                ":Alumno" => $id_alumno
            ]
        );
        

        if ($verificacion->rowCount() > 0) {
            return "Ya has aplicado a este empleo.";
        }

        // Preparar datos para inserción
        $datos = [
            ["campo_nombre" => "id_empleo",         "campo_marcador" => ":Empleo",   "campo_valor" => $id_empleo],
            ["campo_nombre" => "id_alumno",         "campo_marcador" => ":Alumno",   "campo_valor" => $id_alumno],
            ["campo_nombre" => "fecha_aplicacion",  "campo_marcador" => ":Fecha",    "campo_valor" => date("Y-m-d H:i:s")]
        ];

        // Ejecutar inserción
        $guardar = $this->guardarDatos("aplicaciones", $datos);

        if ($guardar->rowCount() == 1) {
            return "¡Aplicación enviada correctamente!";
        } else {
            return "Error al aplicar. Inténtalo más tarde.";
        }
    }
}
